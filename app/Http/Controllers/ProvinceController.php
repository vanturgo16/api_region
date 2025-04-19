<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Province;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends BaseController
{
    public function provinceName()
    {
        $provinces=Province::orderBy('nama','asc')
            ->get();

        return $this->sendResponse($provinces, 'Data Provinces Found');
    }

    public function provinceById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=$request->province_id;

        //check province exist
        $checkProvince=Province::where('id',$province)->count();
        
        if($checkProvince > 0){
            $provinces=Province::where('id',$province)->get();

            return $this->sendResponse($provinces,'Data Province Found.');
        }
        else{
            return $this->sendError('Not Found.', 'Data Province Not Found');            
        }
    }

    public function provinceStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=strtoupper($request->province);

        //check province exist
        $checkProvince=Province::where('nama',$province)->count();
        
        if($checkProvince > 0){
            return $this->sendResponse($province,'Data Province Already Exist.');
        }
        else{
            $addProvince=Province::create([
                'nama' => $province
            ]);

            return $this->sendResponse($province,'Success Add Data Province.');            
        }
    }
}

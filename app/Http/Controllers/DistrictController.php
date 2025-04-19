<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class DistrictController extends BaseController
{
    public function districtName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $districts=District::where('kabupaten_id',$request->city_id)
            ->orderBy('nama','asc')
            ->get();

        return $this->sendResponse($districts, 'Data District Found');
    }

    public function districtById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $district=$request->district_id;

        //check district exist
        $checkDistrict=District::where('id',$district)->count();
        
        if($checkDistrict > 0){
            $districts=District::where('id',$district)->get();

            return $this->sendResponse($districts,'Data District Found.');
        }
        else{
            return $this->sendError('Not Found.', 'Data District Not Found');            
        }
    }

    public function districtStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required',
            'id_city' => 'required',
            'district' => 'required',   
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=$request->id_province;
        $city=$request->id_city;
        $district=strtoupper($request->district);

        //check district exist
        $checkDistrict=District::where('nama',$district)->where('kabupaten_id',$city)->count();
        //dd($checkCity);
        if($checkDistrict > 0){
            return $this->sendResponse($district,'Data District Already Exist.');
        }
        else{
            $addDistrict=District::create([
                'kabupaten_id' => $city,
                'nama' => $district
            ]);

            return $this->sendResponse($district,'Success Add Data District.');            
        }
    }
}

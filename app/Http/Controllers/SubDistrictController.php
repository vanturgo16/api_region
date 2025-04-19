<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\SubDistrict;
use Illuminate\Support\Facades\Validator;

class SubDistrictController extends BaseController
{
    public function subDistrictName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $subdistricts=SubDistrict::where('kecamatan_id',$request->district_id)
            ->orderBy('nama','asc')
            ->get();

        return $this->sendResponse($subdistricts, 'Data Sub District Found');
    }

    public function subDistrictById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subdistrict_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $subdistrict=$request->subdistrict_id;

        //check subdistrict exist
        $checkSubDistrict=SubDistrict::where('id',$subdistrict)->count();
        
        if($checkSubDistrict > 0){
            $subdistricts=SubDistrict::where('id',$subdistrict)->get();

            return $this->sendResponse($subdistricts,'Data Sub District Found.');
        }
        else{
            return $this->sendError('Not Found.', 'Data Sub District Not Found');            
        }
    }

    public function subDistrictStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required',
            'id_city' => 'required',
            'id_district' => 'required',
            'sub_district' => 'required',   
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=$request->id_province;
        $city=$request->id_city;
        $district=$request->id_district;
        $sub_district=strtoupper($request->sub_district);

        //check district exist
        $checkSubDistrict=SubDistrict::where('nama',$sub_district)->where('kecamatan_id',$district)->count();
        //dd($checkSubDistrict);
        if($checkSubDistrict > 0){
            return $this->sendResponse($sub_district,'Data Sub District Already Exist.');
        }
        else{
            $addSubDistrict=SubDistrict::create([
                'kecamatan_id' => $district,
                'nama' => $sub_district
            ]);

            return $this->sendResponse($sub_district,'Success Add Data Sub District.');            
        }
    }
}

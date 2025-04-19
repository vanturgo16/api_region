<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\City;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class CityController extends BaseController
{
    public function cityName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $cities=City::where('provinsi_id',$request->province_id)
            ->orderBy('nama','asc')
            ->get();

        return $this->sendResponse($cities, 'Data Cities Found');
    }

    public function cityById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $city=$request->city_id;

        //check city exist
        $checkCity=City::where('id',$city)->count();
        
        if($checkCity > 0){
            $cities=City::where('id',$city)->get();

            return $this->sendResponse($cities,'Data City Found.');
        }
        else{
            return $this->sendError('Not Found.', 'Data City Not Found');            
        }
    }

    public function cityStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required',
            'city' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=$request->id_province;
        $city=strtoupper($request->city);

        //check city exist
        $checkCity=City::where('nama',$city)->where('provinsi_id',$province)->count();
        //dd($checkCity);
        if($checkCity > 0){
            return $this->sendResponse($city,'Data City Already Exist.');
        }
        else{
            $addCity=City::create([
                'provinsi_id' => $province,
                'nama' => $city
            ]);

            return $this->sendResponse($city,'Success Add Data City.');            
        }
    }
}

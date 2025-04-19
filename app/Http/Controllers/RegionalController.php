<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\Regional;

class RegionalController extends BaseController
{
    public function regionalAll()
    {
        $regionals=Regional::where('regionals.regional','<>','')
        ->select(
            'regionals.id',
            'provinces.nama',
            'cities.nama',
            'regionals.regional'
        )
        ->leftJoin('provinces','regionals.province','provinces.id')
        ->leftJoin('cities','regionals.city','cities.id')
        ->get();
        return $this->sendResponse($regionals, 'Data Regional Found');
    }

    public function regionalAllGroup()
    {
        $regionals=Regional::where('regionals.regional','<>','')
        ->select(
            'regionals.id',
            'regionals.regional'
        )
        ->leftJoin('provinces','regionals.province','provinces.id')
        ->leftJoin('cities','regionals.city','cities.id')
        ->groupBy('regionals.regional')
        ->get();
        return $this->sendResponse($regionals, 'Data Regional Found');
    }

    public function regionalName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required',
            'city' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=strtoupper($request->id_province);
        $city=strtoupper($request->city);

        //pastikan city sama province cocok
        $query=City::select('cities.id')
        ->where('provinces.nama',$province)
        ->where('cities.nama',$city)
        ->leftJoin('provinces','cities.provinsi_id','provinces.id')
        ->orderBy('id','desc');

        $countData=$query->count();
        //dd($countData);
        if($countData > 0){
            $cities=$query->first();
            $id_city=$cities->id;
            //dd($id_city);
                
            $regionals=Regional::where('regionals.city',$id_city)
            ->select(
                'regionals.id',
                'provinces.nama',
                'cities.nama',
                'regionals.regional'
            )
            ->leftJoin('provinces','regionals.province','provinces.id')
            ->leftJoin('cities','regionals.city','cities.id')
            ->get();
            return $this->sendResponse($regionals, 'Data Regional Found');
        }
        else{
            return $this->sendError('Data Regional Not Found.');
        }
    }

    public function addRegional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required|exists:App\Models\Province,id',
            'id_city' => 'required|exists:App\Models\City,id',
            'regional' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $province=$request->id_province;
        $city=$request->id_city;
        $regional=strtoupper($request->regional);

        //check regional exist
        $checkRegional=Regional::where('city',$city)
        ->where('province',$province)
        ->count();
        
        if($checkRegional > 0){
            return $this->sendResponse($regional,'Data Regional Already Exist.');
        }
        else{
            $addRegional=Regional::create([
                'province' => $province,
                'city' => $city,
                'regional' => $regional
            ]);

            return $this->sendResponse($regional,'Success Add Data Regional.');            
        }
    }

    public function deleteRegional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_regional' => 'required|exists:App\Models\Regional,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $regional=$request->id_regional;

        $deleteRegional=Regional::where('id',$regional)->delete();

        return $this->sendResponse($regional,'Success Delete Data Regional.'); 
    }

    public function regionalById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regional_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $regional=$request->regional_id;

        //check regional exist
        $checkRegional=Regional::where('id',$regional)->count();
        
        if($checkRegional > 0){
            $regionals=Regional::where('regionals.id',$regional)
            ->select(
            'regionals.id',
            'provinces.nama',
            'cities.nama',
            'regionals.regional'
        )
        ->leftJoin('provinces','regionals.province','provinces.id')
        ->leftJoin('cities','regionals.city','cities.id')
        ->get();

            return $this->sendResponse($regionals,'Data Regional Found.');
        }
        else{
            return $this->sendError('Not Found.', 'Data Regional Not Found');            
        }
    }

    public function testConnect(){
        return "hai";
    }
}

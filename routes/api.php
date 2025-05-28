<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DialCodeController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\SubDistrictController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//AUTH
Route::post('register', [AuthController::class, 'registerUser']);
Route::post('auth', [AuthController::class, 'authToken']);
Route::get('test', [RegionalController::class, 'testConnect']);

Route::middleware('auth:api')->group( function () {
    //REGIONAL
    // Route::post('regional', [RegionalController::class, 'regionalName']);
    // Route::post('regional/search', [RegionalController::class, 'regionalById']);
    // Route::get('regional/all', [RegionalController::class, 'regionalAll']);
    // Route::get('regional/all-group', [RegionalController::class, 'regionalAllGroup']);
    // Route::post('regional/add', [RegionalController::class, 'addRegional']);
    // Route::post('regional/update', [RegionalController::class, 'updateRegional']); //BELUM Monitor KETIKA PROSES butuh atau tidak
    // Route::post('regional/delete', [RegionalController::class, 'deleteRegional']);

    //PROVINCE
    Route::get('province', [ProvinceController::class, 'provinceName']);
    Route::post('province/add', [ProvinceController::class, 'provinceStore']);
    Route::post('province/search', [ProvinceController::class, 'provinceById']);

    //CITY
    Route::post('city', [CityController::class, 'cityName']);
    Route::post('city/add', [CityController::class, 'cityStore']);
    Route::post('city/search', [CityController::class, 'cityById']);

    //DISTRICT
    Route::post('district', [DistrictController::class, 'districtName']);
    Route::post('district/add', [DistrictController::class, 'districtStore']);
    Route::post('district/search', [DistrictController::class, 'districtById']);

    //SUB DISTRICT
    Route::post('subdistrict', [SubDistrictController::class, 'subDistrictName']);
    Route::post('subdistrict/add', [SubDistrictController::class, 'subDistrictStore']);
    Route::post('subdistrict/search', [SubDistrictController::class, 'subDistrictById']);

    //Country Dial Code
    //Route::get('country-code', [DialCodeController::class, 'listCountry']);
});
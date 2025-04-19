<?php

namespace App\Http\Controllers;

use App\Models\DialCode;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class DialCodeController extends BaseController
{
    public function listCountry()
    {
        $countries=DialCode::orderBy('name','asc')
            ->get();

        return $this->sendResponse($countries, 'Data Countries Found');
    }
}

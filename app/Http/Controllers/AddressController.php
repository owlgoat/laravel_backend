<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prefecture;
use App\Models\Postcode;

class AddressController extends Controller
{
    // public function getPrefectureByPostcode($postcode)
    // {
    //     $prefectures = new Postcode();
    //     $prefectures = Postcode::where('postcode', $postcode)->groupBy('prefecture')->pluck('prefecture');

    //     return response()->json($prefectures);
    // }

}

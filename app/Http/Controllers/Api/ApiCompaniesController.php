<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Prefecture;

class ApiCompaniesController extends Controller
{
    /**
     * Return the contents of User table in tabular form
     *
     */
    public function getCompaniesTabular() {
        $companies = Company::orderBy('id', 'desc')->get();
        // $companies->append('address');
        // $companies->address = $companies->city.$companies->local.$companies->street_address;
        return response()->json($companies);
    }
}

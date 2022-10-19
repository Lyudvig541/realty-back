<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\CreditCompany;
use Illuminate\Http\Request;

class CreditCompanyController extends Controller
{

    public function company(Request $request)
    {
        $company = CreditCompany::query()->where('id', (int)$request->id)->first();
        return response()->json(compact('company'));
    }
    public function topCompanies(){
        $top_companies = CreditCompany::offset(0)->limit(1)->get();
        return response()->json(compact('top_companies'));
    }
    public function allCompanies(){
        $all_companies = CreditCompany::offset(0)->limit(10)->get();
        return response()->json(compact('all_companies'));
    }

}

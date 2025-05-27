<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request) {
        $companies = Company::get();
        return CompanyResource::collection($companies);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $company) {
        return new CompanyResource(Company::find($company)->load('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $company = Company::create([
            'name' => $request->input('name'),
            'abn' => $request->input('abn'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        return new CompanyResource($company);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company) {
        
        $company->fill($request->only(['name', 'email', 'abn', 'address']));
        $company->save();

        return new CompanyResource($company->load('employees'));
    }
}

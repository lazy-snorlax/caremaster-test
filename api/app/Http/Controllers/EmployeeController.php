<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        return new EmployeeResource(Employee::find($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $employee = Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'company_id' => $request->input('company_id'),
        ]);

        return new EmployeeResource($employee);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee) {
        
        $employee->fill($request->only(['first_name', 'last_name', 'email', 'address']));
        $employee->save();

        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee, $id)
    {
        dd($employee);
    }
}

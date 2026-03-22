<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() {
        $Employees = Employee::all();

        return view('employee.index', [
            'items' => $Employees
        ]);
    }



    public function store(Request $request) {
        Employee::create([
            'FirstName' => $request->firstname123,
            'LastName' => $request->lastname123,
            'Job' => $request->job123,
            'Salary' => $request->salary123,
        ]);

        return redirect('/employee');
    }
}

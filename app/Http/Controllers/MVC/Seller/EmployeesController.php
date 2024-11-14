<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Sellers\Seller;
use App\Models\Sellers\Employee;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all employees for the current seller
        try {
            $employees = Employee::where('seller_id', Auth::user()->id)->get();
            return view('seller.employees.allEmployees', compact('employees'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Store the new employee
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $employee = new Employee();
            $employee->seller_id = Auth::user()->id;
            $employee->name = $request->name;
            $employee->position = $request->position;
            $employee->save();

            return redirect()->back()->with('success', 'تم اضافة الموظف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Edit the employee page
        try {
            $employee = Employee::findOrFail($id);
            return view('seller.employees.updateEmployee', compact('employee'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update the employee
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $employee = Employee::findOrFail($id);

            // Update employee details
            $employee->name = $request->name;
            $employee->position = $request->position;
            $employee->status = $request->status;
            $employee->save();
            return redirect()->route('seller.employees')->with('success', 'تم تعديل الموظف بنجاح');
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Remove the employee
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return redirect()->route('seller.employees')->with('success', 'تم حذف الموظف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('seller.employees')->with('error', $th->getMessage());
        }
    }
}

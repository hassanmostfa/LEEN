<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\Employee;


class EmployeesController extends Controller
{
    // get all employees
    public function index(){
        try{
            $employees = Employee::all();
            return response()->json(['status' => 'success', 'data' => $employees]);
        }catch(\Throwable $th){
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

/*************************************************************************************** */

// get employee by id
    public function show($id){
        try{
            $employee = Employee::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $employee]);
        }catch(\Throwable $th){
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

/*************************************************************************************** */

// Store new employee
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        try {
            $employee = new Employee();
            $employee->seller_id = Auth::user()->id;
            $employee->name = $request->name;
            $employee->position = $request->position;
            $employee->save();

            return response()->json(['status' => 'success', 'message' => 'تم اضافة الموظف بنجاح']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    /***************************************************************************************/

    // Update employee
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        try {
            $employee = Employee::findOrFail($id);

            // Update employee details
            $employee->name = $request->name;
            $employee->position = $request->position;
            $employee->status = $request->status;

            if ($request->hasFile('image')) {
                // Delete the old image if it exists and store the new one
                if ($employee->image) {
                    Storage::delete($employee->image);
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $employee->image = $imageName;
            }
            $employee->save();

            return response()->json(['status' => 'success', 'message' => 'تم تعديل الموظف بنجاح']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

/***************************************************************************************/

// Delete employee
    public function destroy($id){
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json(['status' => 'success', 'message' => 'تم حذف الموظف بنجاح']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

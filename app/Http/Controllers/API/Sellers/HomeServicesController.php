<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\HomeService;
use App\Http\Resources\HomeServiceResource;
class HomeServicesController extends Controller
{
    //get all home services for the current seller
    public function index(){
        try{
            $homeServices = HomeService::where('seller_id', Auth::user()->id)->get();
        return response()->json(['status' => 'success', 'data' => HomeServiceResource::collection($homeServices)]);
        }catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]); 
        }
    }

    /************************************************************************************/
    // Show Home Service Details
    public function show($id){
        try {
            $homeService = HomeService::find($id);
            return response()->json(['status' => 'success', 'data' => new HomeServiceResource($homeService)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    /************************************************************************************/
    // Store New Home Service
    public function store(Request $request){
         // Validate the request
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'service_details.*' => 'required|string', // Validate each item in the service_details array
            'employees.*' => 'required|string', // Validate each item in the employees array
            'price' => 'required|numeric', // Validate price to be numeric
            'booking_status' => 'required',
        ]);
    
        // Handle validation failure
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            // Create a new HomeService instance
            $homeService = new HomeService();
            $homeService->seller_id = Auth::user()->id;
            $homeService->name = $request->name;
            $homeService->gender = $request->gender;
            $homeService->category_id = $request->category_id;
            $homeService->sub_category_id = $request->sub_category_id;
    
            // Store service details and employees as JSON
            $homeService->service_details = json_encode($request->service_details);
            $homeService->employees = json_encode($request->employees);
            
            $homeService->price = $request->price;
            $homeService->booking_status = $request->booking_status;
            $homeService->discount = $request->discount;
            $homeService->percentage = $request->percentage;
            $homeService->points = $request->points ?? 0;
            $homeService->save();

            return response()->json(['status' => 'success', 'message' => 'تم إضافة الخدمة بنجاح ', 'data' => new HomeServiceResource($homeService)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    /************************************************************************************/
    // Update Home Service
    public function update(Request $request, $id){
            // Validate the request
            $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'service_details.*' => 'required|string', // Validate each item in the service_details array
            'employees.*' => 'required|string', // Validate each item in the employees array
            'price' => 'required|numeric', // Validate price to be numeric
            'booking_status' => 'required',
        ]);
    
        // Handle validation failure
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $homeService = HomeService::find($id);
            $homeService->name = $request->name;
            $homeService->gender = $request->gender;
            $homeService->category_id = $request->category_id;
            $homeService->sub_category_id = $request->sub_category_id;

            // Store service details and employees as JSON
            $homeService->service_details = json_encode($request->service_details);
            $homeService->employees = json_encode($request->employees);

            $homeService->price = $request->price;
            $homeService->booking_status = $request->booking_status;
            $homeService->discount = $request->discount;
            $homeService->percentage = $request->percentage;
            $homeService->points = $request->points ?? 0;

            $homeService->save();

            return response()->json(['status' => 'success', 'message' => 'تم تحديث الخدمة بنجاح ', 'data' => new HomeServiceResource($homeService)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    /************************************************************************************/
    // Delete Home Service
    public function destroy($id){
        try {
            $homeService = HomeService::find($id);
            $homeService->delete();
            return response()->json(['status' => 'success', 'message' => 'تم حذف الخدمة بنجاح']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

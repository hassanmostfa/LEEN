<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\StudioService;
use App\Http\Resources\StudioServiceResource;

class studioServicesController extends Controller
{
        //get all studio services for the current seller
        public function index(){
            try{
                $studioServices = StudioService::where('seller_id', Auth::user()->id)->get();
            return response()->json(['status' => 'success', 'data' => StudioServiceResource::collection($studioServices)]);
            }catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]); 
            }
        }
    
        /************************************************************************************/
        // Show studio Service Details
        public function show($id){
            try {
                $studioService = StudioService::find($id);
                return response()->json(['status' => 'success', 'data' => new StudioServiceResource($studioService)]);
            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }
        /************************************************************************************/
        // Store New studio Service
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
                // Create a new studioService instance
                $studioService = new StudioService();
                $studioService->seller_id = Auth::user()->id;
                $studioService->name = $request->name;
                $studioService->gender = $request->gender;
                $studioService->category_id = $request->category_id;
                $studioService->sub_category_id = $request->sub_category_id;
        
                // Store service details and employees as JSON
                $studioService->service_details = json_encode($request->service_details);
                $studioService->employees = json_encode($request->employees);
                
                $studioService->price = $request->price;
                $studioService->booking_status = $request->booking_status;
                $studioService->discount = $request->discount;
                $studioService->percentage = $request->percentage;
                $studioService->points = $request->points ?? 0;
                $studioService->save();
    
                return response()->json(['status' => 'success', 'message' => 'تم إضافة الخدمة بنجاح ', 'data' => new StudioServiceResource($studioService)]);
            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }

        /************************************************************************************/
        // Update studio Service
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
                $studioService = StudioService::find($id);
                $studioService->name = $request->name;
                $studioService->gender = $request->gender;
                $studioService->category_id = $request->category_id;
                $studioService->sub_category_id = $request->sub_category_id;
    
                // Store service details and employees as JSON
                $studioService->service_details = json_encode($request->service_details);
                $studioService->employees = json_encode($request->employees);
    
                $studioService->price = $request->price;
                $studioService->booking_status = $request->booking_status;
                $studioService->discount = $request->discount;
                $studioService->percentage = $request->percentage;
                $studioService->points = $request->points ?? 0;
    
                $studioService->save();
    
                return response()->json(['status' => 'success', 'message' => 'تم تحديث الخدمة بنجاح ', 'data' => new StudioServiceResource($studioService)]);
            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }
        /************************************************************************************/
        // Delete studio Service
        public function destroy($id){
            try {
                $studioService = StudioService::find($id);
                $studioService->delete();
                return response()->json(['status' => 'success', 'message' => 'تم حذف الخدمة بنجاح']);
            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }
}
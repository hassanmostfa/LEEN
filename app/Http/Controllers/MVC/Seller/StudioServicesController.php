<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Sellers\StudioService;
use App\Models\Sellers\Seller;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;

use App\Models\Sellers\Employee;

class StudioServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Show Home Services
        $studioServices = StudioService::where('seller_id', Auth::user()->id)->get();

        // Category name for each service
        foreach ($studioServices as $service) {
            $category = Category::find($service->category_id);
            $service->category = $category->name;

            $subCategory = SubCategory::find($service->sub_category_id);
            $service->sub_category = $subCategory->name;

        }
        return view('seller.services.studio services.services', compact('studioServices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            // Get Authenticated Seller
            $seller = Seller::where('id', Auth::user()->id)->first();

            if ($seller->request_status == 'approved') {
                // Get All Categories
        $categories = Category::all();

        // Get  Employees for the current seller
        $employees = Employee::where('seller_id', Auth::user()->id)
        ->where('status', 'active')
        ->get();

        // Show Create Home Service Form
        return view('seller.services.studio services.create' , compact('categories' , 'employees'));
            }else{
                return redirect()->route('seller.dashboard')->with('error', 'لا يمكنك اضافة خدمة جديدة لان حسابك غير مفعل');
            }
    }catch (\Throwable $th) {
        return redirect()->route('seller.dashboard')->with('error', 'حدث خطاء: ' . $th->getMessage());
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
            $homeService = new StudioService();
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
            $homeService->points = $request->points;
            $homeService->save();
    
            return redirect()->route('seller.studioServices')->with('success', 'تم اضافة الخدمة بنجاح');
        } catch (\Throwable $th) {
            // Handle any errors during the save operation
            return redirect()->route('seller.studioServices')->with('error', 'حدث خطأ: ' . $th->getMessage());
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Studio Service
        $studioService = StudioService::findOrFail($id);
        //get category name
        $category = Category::findOrFail($studioService->category_id);
        $studioService->category = $category->name;

        // get subcategory name
        $subCategory = SubCategory::findOrFail($studioService->sub_category_id);
        $studioService->sub_category = $subCategory->name;

        // Get  Employees for the current Service
        $employees = json_decode($studioService->employees);
        foreach ($employees as $key => $employee) {
            $employee = Employee::findOrFail($employee);
            $employees[$key] = $employee->name;
        }
        return view('seller.services.studio services.showService', compact('studioService' , 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Edit Studio Service Page
        $studioService = StudioService::findOrFail($id);

        // Get All Categories
        $categories = Category::all();

        // Get Sub Category name
        $subCategory = SubCategory::findOrFail($studioService->sub_category_id);
        // Get  Employees for the current seller
        $employees = Employee::where('seller_id', Auth::user()->id)->get();

        return view('seller.services.studio services.updateService', compact('studioService' , 'categories' , 'employees' , 'subCategory'));
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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'service_details' => 'required|array',
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
            // Update Home Service
            $studioService = StudioService::findOrFail($id);
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
            $studioService->points = $request->points;
            $studioService->save();

            return redirect()->route('seller.studioServices')->with('success', 'تم تحديث الخدمة بنجاح');
    }catch (\Throwable $th) {
        return redirect()->route('seller.studioServices')->with('error', 'حدث خطاء: ' . $th->getMessage());
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
        // Delete Studio Service
        try {
            $studioService = StudioService::findOrFail($id);
            $studioService->delete();
            return redirect()->route('seller.studioServices')->with('success', 'تم حذف الخدمة بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('seller.studioServices')->with('error', 'حدث خطاء: ' . $th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HomeServiceResource;
use App\Http\Resources\StudioServiceResource;
use App\Http\Resources\GallaryResource;
use App\Http\Resources\ReelsResource;
use App\Models\Sellers\Employee;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;
use App\Models\Sellers\Image;
use App\Models\Sellers\Reel;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;

class HomeController extends Controller
{
    // get all home services
    public function getAllHomeServices(){
        try {
            $homeServices = HomeService::all();
            return response()->json(['status' => 'success', 'data' => HomeServiceResource::collection($homeServices)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    // Show Home Service Details
    public function showHomeService($id){
        try {
            $homeService = HomeService::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => new HomeServiceResource($homeService)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    // Get all studio bookings
    public function getAllStudioServices(){
        try {
            $studioServices = StudioService::all();
            return response()->json(['status' => 'success', 'data' => StudioServiceResource::collection($studioServices)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    // Show Studio Service Details
    public function showStudioService($id){
        try{
            $studioService = StudioService::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => new StudioServiceResource($studioService)]);
        }catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    // get all gallary images
    public function getAllGallaryImages(){
        try {
            $images = Image::all();
            return response()->json(['status' => 'success', 'data' => GallaryResource::collection($images)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    // get all reels 
    public function getAllReels(){
        try {
            $reels = Reel::all();
            return response()->json(['status' => 'success', 'data' => ReelsResource::collection($reels)]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    /***********************************************************************************************/
        // Get all Categories with their SubCategories
        public function getAllCategories() {
            try {
                // Retrieve all categories and load their related subcategories
                $categories = Category::with('subCategories')->get();

                return response()->json(['status' => 'success', 'data' => $categories]);
            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
            }
        }

    /************************************************************************************************/
    // get all SubCategories
    public function getAllSubCategories(){
        try {
            $subCategories = SubCategory::all();
            return response()->json(['status' => 'success', 'data' => $subCategories]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

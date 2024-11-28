<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GallaryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\Image;



class ImagesController extends Controller
{
    public function index()
    {
      try{
        $images = Image::where('seller_id', auth()->id())->get();
        return response()->json(['status' => 'success', 'data' => GallaryResource::collection($images)]);
      }catch(\Exception $e){
          return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
      }
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => $validator->errors()]);
    }

   try{
    $image = new Image();
    $image->seller_id = auth()->id();
    $image->image = $request->file('image')->store('sellers_images');
    $image->description = $request->description;
    $image->save();

    return response()->json(['status' => 'success', 'message' => 'تم رفع الصورة بنجاح']);
   }catch(\Exception $e){
    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
   }
}


    // Delete Image
    public function destroy($id){
        try {
            $image = Image::findOrFail($id);
            $image->delete();
            return response()->json(['status' => 'success', 'message' => 'تم حذف الصورة بنجاح']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

}

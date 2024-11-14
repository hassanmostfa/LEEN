<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\Image;



class ImagesController extends Controller
{

    public function index()
    {
        $images = Image::where('seller_id', Auth::id())->get();
        return view('seller.media.images', compact('images'));
    }

    public function uploadImage(Request $request)
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
    $image->save();

    return redirect()->route('seller.images')->with('success', 'تم رفع الصورة بنجاح');
   }catch(\Exception $e){
    return redirect()->route('seller.images')->with('error', $e->getMessage());
   }
}


    // Delete Image
    public function delete($id){
        try {
            $image = Image::findOrFail($id);
            $image->delete();
            return redirect()->route('seller.images')->with('success', 'تم حذف الصورة بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('seller.images')->with('error', $th->getMessage());
        }
    }

}

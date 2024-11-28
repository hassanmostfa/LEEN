<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\Reel;
use App\Http\Resources\ReelsResource;

class ReelsController extends Controller
{
     // get all reels by seller id
     public function index(){
        try{
            $reels = Reel::where('seller_id', Auth::id())->get();
            return response()->json(['status' => 'success', 'reels' => ReelsResource::collection($reels)]);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // Upload reel
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'reel' => 'required|file|mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        try{
            $reel = new Reel();
            $reel->seller_id = auth()->id();
            $reel->reel = $request->file('reel')->store('sellers_reels');
            $reel->description = $request->description;
            $reel->save();

            return response()->json(['status' => 'success', 'message' => 'تم رفع الفيديو بنجاح']);
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    // Delete reel
    public function destroy($id){
        try {
            $reel = Reel::findOrFail($id);
            $reel->delete();
            return response()->json(['status' => 'success', 'message' => 'تم حذف الفيديو بنجاح']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

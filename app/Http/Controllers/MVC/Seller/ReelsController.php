<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\Reel;

class ReelsController extends Controller
{
    // get all reels by seller id
    public function index(){
        $reels = Reel::where('seller_id', Auth::id())->get();
        return view('seller.media.reels', compact('reels'));
    }

    // Upload reel
    public function uploadReel(Request $request){

        $validator = Validator::make($request->all(), [
            'reel' => 'required|file|mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $reel = new Reel();
        $reel->seller_id = auth()->id();
        $reel->reel = $request->file('reel')->store('sellers_reels');
        $reel->save();
        return redirect()->route('seller.reels')->with('success', 'تم رفع الفيديو بنجاح');
    }

    // Delete reel
    public function delete($id){
        try {
            $reel = Reel::findOrFail($id);
            $reel->delete();
            return redirect()->route('seller.reels')->with('success', 'تم حذف الفيديو بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('seller.reels')->with('error', $th->getMessage());
        }
    }
}

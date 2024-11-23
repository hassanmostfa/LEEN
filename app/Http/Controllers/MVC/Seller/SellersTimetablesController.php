<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\SellerTimetable;


class SellersTimetablesController extends Controller
{
    // show all timetables
    public function index(){
        // get all timetables
        $sellerId = Auth::user()->id;
        $timetables = SellerTimetable::where('seller_id', $sellerId)->get();
        return view('seller.work_timetable.timetable' , compact('timetables'));
    }

    // Store New Timetable
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        $sellerId = Auth::user()->id;

        $timetable = new SellerTimetable();
        $timetable->seller_id = $sellerId;
        $timetable->day = $request->day;
        $timetable->start_time = $request->start_time;
        $timetable->end_time = $request->end_time;
        $timetable->save();

        return redirect()->route('seller.timetables')->with('success', 'تم حفظ الوقت بنجاح');
    }

    // Edit Timetable
    public function edit($id){
        $timetable = SellerTimetable::findOrFail($id);
        return view('seller.work_timetable.updateTimetable', compact('timetable'));
    }

    // ُUpdate Timetable
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        $timetable = SellerTimetable::findOrFail($id);
        $timetable->day = $request->day;
        $timetable->start_time = $request->start_time;
        $timetable->end_time = $request->end_time;
        $timetable->save();

        return redirect()->route('seller.timetables')->with('success', 'تم تعديل الوقت بنجاح');
    }

    // Delete Timetable
    public function destroy($id){
        $timetable = SellerTimetable::findOrFail($id);
        $timetable->delete();
        return redirect()->route('seller.timetables')->with('success', 'تم حذف الوقت بنجاح');
    }
}

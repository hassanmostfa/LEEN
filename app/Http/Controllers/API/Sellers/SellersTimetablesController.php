<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\SellerTimetable;

class SellersTimetablesController extends Controller
{
    // show all timetables
    public function index(){
        try{
            // get all timetables
            $sellerId = Auth::user()->id;
            $timetables = SellerTimetable::where('seller_id', $sellerId)->get();
            return response()->json(['status' => 'success', 'timetables' => $timetables], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    /**************************************************************************************/
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

        try{
            $sellerId = Auth::user()->id;

            $timetable = new SellerTimetable();
            $timetable->seller_id = $sellerId;
            $timetable->day = $request->day;
            $timetable->start_time = $request->start_time;
            $timetable->end_time = $request->end_time;
            $timetable->save();
            
            return response()->json(['status' => 'success', 'message' => 'تم حفظ موعد العمل بنجاح' , 'data' => $timetable], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    /***************************************************************************************/
    // show Timetable
    public function show($id){
        try{
            $timetable = SellerTimetable::findOrFail($id);            
            return response()->json(['status' => 'success', 'timetable' => $timetable], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    /****************************************************************************************/
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

        try{
            
        $timetable = SellerTimetable::findOrFail($id);
        $timetable->day = $request->day;
        $timetable->start_time = $request->start_time;
        $timetable->end_time = $request->end_time;
        $timetable->save();
        
            return response()->json(['status' => 'success', 'message' => 'تم تعديل موعد العمل بنجاح' , 'data' => $timetable], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    /***************************************************************************************/
    // Delete Timetable
    public function destroy($id){
        try{
            $timetable = SellerTimetable::findOrFail($id);
            $timetable->delete();
            return response()->json(['status' => 'success', 'message' => 'تم حذف موعد العمل بنجاح'], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}

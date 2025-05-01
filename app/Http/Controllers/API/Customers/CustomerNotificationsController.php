<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class CustomerNotificationsController extends Controller
{
    // get all notifications for current seller
    public function index(){
        try{
            $notifications = Notification::where('customer_id',Auth::user()->id)
            ->where('sender_type', 'seller')->get();
            return response()->json(['status' => 'success', 'data' => $notifications]);
        }catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    // Mark All Notifications As Read
    public function markAllAsRead(){
        try{
            Notification::where('customer_id',Auth::user()->id)
            ->where('sender_type', 'seller')
            ->update(['is_read' => true]);
            return response()->json(['status' => 'success', 'message' => 'تم تحديث الاشعارات بنجاح']);
        }catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}

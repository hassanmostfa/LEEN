<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OTPController;
use App\Http\Controllers\API\HomeController;

use App\Http\Controllers\API\Sellers\SellerController;
use App\Http\Controllers\API\Sellers\EmployeesController;
use App\Http\Controllers\API\Sellers\HomeServicesController;
use App\Http\Controllers\API\Sellers\StudioServicesController;
use App\Http\Controllers\API\Sellers\HomeBookingsController;
use App\Http\Controllers\API\Sellers\StudioBookingsController;
use App\Http\Controllers\API\Sellers\ImagesController;
use App\Http\Controllers\API\Sellers\ReelsController;
use App\Http\Controllers\API\Sellers\CouponsController;
use App\Http\Controllers\API\Sellers\ChatController;
use App\Http\Controllers\API\Sellers\SellersTimetablesController;

use App\Http\Controllers\API\Customers\CustomerController;
use App\Http\Controllers\API\Customers\ServicesController;
use App\Http\Controllers\API\Customers\BookingHomeServicesController;
use App\Http\Controllers\API\Customers\BookingStudioServicesController;
use App\Http\Controllers\API\Customers\RatingController;
use App\Http\Controllers\API\Customers\CustomersCouponsController;
use App\Http\Controllers\API\Customers\FavouritesController;
use App\Http\Controllers\API\Customers\CustomerChatController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*==================================================================================*/
//================================= Auth OTP Routes ====================================
/*==================================================================================*/
    Route::controller(OTPController::class)->group(function () {
        Route::post('/send-otp','sendOtp'); // Send OTP
        Route::post('/verify-otp','verifyOtp'); // Verify OTP
    });
/*==================================================================================*/


/*==================================================================================*/
//================================= Home Routes ====================================
/*==================================================================================*/
    Route::controller(HomeController::class)->group(function () {
        Route::get('/homeServices','getAllHomeServices'); // Get All Home Services
        Route::get('/homeService/{id}','showHomeService'); // Show Home Service
        Route::get('/studioServices','getAllStudioServices'); // Get All Studio Services
        Route::get('/studioService/{id}','showStudioService'); // Show Studio Service
        Route::get('/gallaryImages','getAllGallaryImages'); // Get All Gallary Images
        Route::get('/reels','getAllReels'); // Get All Reels
        Route::get('/categories','getAllCategories'); // Get All Categories
        Route::get('/subCategories','getAllSubCategories'); // Get All SubCategories
    });
/*==================================================================================*/


/*==================================================================================*/
//================================= Seller Routes ====================================
/*==================================================================================*/
    Route::controller(SellerController::class)->group(function () {
        Route::post('seller/register','registerSeller'); // Register New Seller
        Route::post('seller/login','sellerLogin'); // Login Seller
    });

    Route::middleware('auth:sanctum')->group( function () {
        // Seller Routes
        Route::controller(SellerController::class)->group(function () {
            Route::post('seller/logout','logout'); // Logout Seller
            Route::get('seller/clients','getAllClients'); // Get All Clients for chat
            Route::get('seller/info','getSellerInfo'); // Get Seller Info
            Route::post('seller/info/update/{id}','updateSellerInfo'); // Update Seller Info
        });

        // Employees Routes
        Route::controller(EmployeesController::class)->group(function () {
            Route::get('seller/employees','index'); // Get All Employees
            Route::get('seller/employees/{id}','show'); // Get Employee
            Route::post('seller/employees/store','store'); // Store New Employee
            Route::put('seller/employees/update/{id}','update'); // Update Employee
            Route::delete('seller/employees/destroy/{id}','destroy'); // Delete Employee
        });

        // Home Services Routes
        Route::controller(HomeServicesController::class)->group(function () {
            Route::get('seller/homeServices','index'); // Get All Home Services
            Route::get('seller/homeServices/{id}','show'); // Get Home Service
            Route::post('seller/homeServices/store','store'); // Store New Home Service
            Route::put('seller/homeServices/update/{id}','update'); // Update Home Service
            Route::delete('seller/homeServices/destroy/{id}','destroy'); // Delete Home Service
        });

        // Studio Services Routes
        Route::controller(StudioServicesController::class)->group(function () {
            Route::get('seller/studioServices','index'); // Get All Studio Services
            Route::get('seller/studioServices/{id}','show'); // Get Studio Service
            Route::post('seller/studioServices/store','store'); // Store New Studio Service
            Route::put('seller/studioServices/update/{id}','update'); // Update Studio Service
            Route::delete('seller/studioServices/destroy/{id}','destroy'); // Delete Studio Service
        });

        // Home Bookings Routes
        Route::controller(HomeBookingsController::class)->group(function () {
            Route::get('seller/homeBookings','index'); // Get All Accepted Home Bookings
            Route::get('seller/homeBookings/newRequests','getNewHomeBookings'); // Get All New Home Bookings
            Route::get('seller/homeBookings/rejectedRequests','getRefusedHomeBookings'); // Get All Refused Home Bookings
            Route::get('seller/homeBookings/{id}','show'); // Get Home Booking
            Route::post('seller/homeBookings/accept/{id}','acceptHomeBooking'); // Accept Home Booking
            Route::post('seller/homeBookings/reject/{id}','rejectHomeBooking'); // Reject Home Booking
            Route::put('seller/homeBookings/serviceIsDone/{id}','homeServiceIsDone'); // Service is done
        });

        // Studio Bookings Routes
        Route::controller(StudioBookingsController::class)->group(function () {
            Route::get('seller/studioBookings','index'); // Get All Accepted Studio Bookings
            Route::get('seller/studioBookings/newRequests','getNewStudioBookings'); // Get All New Studio Bookings
            Route::get('seller/studioBookings/rejectedRequests','getRefusedStudioBookings'); // Get All Refused Studio Bookings
            Route::get('seller/studioBookings/{id}','show'); // Get Studio Booking
            Route::post('seller/studioBookings/accept/{id}','acceptStudioBooking'); // Accept Studio Booking
            Route::post('seller/studioBookings/reject/{id}','rejectStudioBooking'); // Reject Studio Booking
            Route::put('seller/studioBookings/serviceIsDone/{id}','studioServiceIsDone'); // Service is done
        });

        // Images Routes
        Route::controller(ImagesController::class)->group(function () {
            Route::get('seller/images','index'); // Get All Images
            Route::post('seller/images/upload','store'); // Upload Image
            Route::delete('seller/images/destroy/{id}','destroy'); // Delete Image
        });

        // Reels Routes
        Route::controller(ReelsController::class)->group(function () {
            Route::get('seller/reels','index'); // Get All Reels
            Route::post('seller/reels/upload','store'); // Upload Reel
            Route::delete('seller/reels/destroy/{id}','destroy'); // Delete Reel
        });

        // Coupons Routes
        Route::controller(CouponsController::class)->group(function () {
            Route::get('seller/coupons','index'); // Get All Coupons
            Route::post('seller/coupons/store','store'); // Store New Coupon
            Route::get('seller/coupons/{id}','show'); // Show Coupon
            Route::put('seller/coupons/update/{id}','update'); // Update Coupon
            Route::delete('seller/coupons/destroy/{id}','destroy'); // Delete Coupon
        });

        // Chat Routes
        Route::controller(ChatController::class)->group(function () {
            Route::get('seller/chat/{customerId}','startOrResumeChat'); // Start a new chat or continue an existing one
            Route::get('seller/chat/messages/{chatRoomId}','showMessages'); // Display the messages view for an existing chat session
            Route::post('seller/chat/sendMessage','sendMessage'); // Store a new message in the chat session
        });

        // Seller Timetable Routes
        Route::controller(SellersTimetablesController::class)->group(function () {
            Route::get('/seller/timetables', 'index'); // Show All Timetables
            Route::get('/seller/timetables/show/{id}', 'show'); // Show Timetable
            Route::post('/seller/timetables/store', 'store'); // Store New Timetable
            Route::put('/seller/timetables/update/{id}', 'update');// Update Timetable
            Route::delete('/seller/timetables/destroy/{id}', 'destroy');// Delete Timetable
        });
    });
/*==================================================================================*/



/*==================================================================================*/
//================================= Customer Routes ====================================
/*==================================================================================*/
    Route::controller(CustomerController::class)->group(function () {
        Route::post('customer/register','registerCustomer'); // Register New Customer
        Route::post('customer/login','customerLogin'); // Login Customer
        });

    Route::controller(ServicesController::class)->group(function () {
        Route::get('/seller/{sellerId}/active-weekdays', 'getSellerActiveWeekdays');// Get Working Days
        Route::post('/check-available-times','checkAvailableTimes');// check available times
        Route::post('/check-employee-availability','checkEmployeeAvailability');// Check Employee Availability
        Route::get('customer/seller/homeServices/{sellerId}','getSellerHomeServices');// Get All Home Services for a specific seller
        Route::get('customer/seller/studioServices/{sellerId}','getSellerStudioServices');// Get All Studio Services for a specific seller
        Route::get('/get-employees/{serviceId}','getEmployeesByService');// Get Related Employees By Home Service
        Route::get('/get-studio-employees/{serviceId}', 'getStudioEmployeesByService');// Get Related Employees By Studio Service
    });

    Route::middleware('auth:sanctum')->group( function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::post('customer/logout','logout'); // Logout Customer
            Route::get('customer/info','show'); // Get Customer Info
            Route::post('customer/info/update/{id}','update'); // Update Customer Info
            Route::get('customer/sellers','getCustomerSellers'); // Get All Sellers for the customer
        });

        // Home Bookings Routes
        Route::controller(BookingHomeServicesController::class)->group(function () {
            Route::get('customer/homeServices/bookings' , 'index'); // Get All Home Bookings for the current customer
            Route::post('customer/homeServices/book' , 'store'); // Book Home Service
            Route::put('customer/homeServices/update/{id}' , 'update'); // Update Home Service
            Route::post('customer/homeServices/addServiceToExistingBooking' , 'addServiceToExistingBooking'); // Add Service To Existing Booking
        });

        // Studio Bookings Routes
        Route::controller(BookingStudioServicesController::class)->group(function () {
            Route::get('customer/studioServices/bookings' , 'index'); // Get All Studio Bookings for the current customer
            Route::post('customer/studioServices/book' , 'store'); // Book Studio Service
            Route::put('customer/studioServices/update/{id}' , 'update'); // Update Studio Service
            Route::post('customer/studioServices/addServiceToExistingBooking' , 'addStudioServiceToExistingBooking'); // Add Service To Existing Booking
        });

        // Rating Routes
        Route::controller(RatingController::class)->group(function () {
            Route::post('customer/rate/service','store'); // Store Rating
        });

        // Customer Coupons Routes
        Route::controller(CustomersCouponsController::class)->group(function () {
            Route::get('customer/coupons' , 'index'); // Get All Customer Coupons
        });

        // Favourites Routes
        Route::controller(FavouritesController::class)->group(function () {
            Route::get('customer/sellers' , 'getCustomerSellers'); // get all customer sellers that can be added to favourites
            Route::get('customer/favourites' , 'index'); // Get All Favourites
            Route::post('customer/favourites/store/{id}' , 'store'); // Store Favourite
            Route::delete('customer/favourites/destroy/{id}' , 'destroy'); // Delete Favourite
        });

        // Chat Routes
        Route::controller(CustomerChatController::class)->group(function () {
            Route::get('customer/chat/{sellerId}','startOrResumeChat'); // Start a new chat or continue an existing one
            Route::get('customer/chat/messages/{chatRoomId}','showMessages'); // Display the messages view for an existing chat session
            Route::post('customer/chat/sendMessage','sendMessage'); // Store a new message in the chat session
        });

    });
/*==================================================================================*/
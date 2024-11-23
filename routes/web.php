<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;


use App\Http\Controllers\MVC\HomeController;

use App\Http\Controllers\MVC\Admin\AdminController;
use App\Http\Controllers\MVC\Admin\CategoriesController;
use App\Http\Controllers\MVC\Admin\SubCategoriesController;
use App\Http\Controllers\MVC\Admin\SellersRequestsController;
use App\Http\Controllers\MVC\Admin\AllSellersController;

use App\Http\Controllers\MVC\Seller\SellerController;
use App\Http\Controllers\MVC\Seller\SellerProfileController;
use App\Http\Controllers\MVC\Seller\EmployeesController;
use App\Http\Controllers\MVC\Seller\HomeServicesController;
use App\Http\Controllers\MVC\Seller\StudioServicesController;
use App\Http\Controllers\MVC\Seller\HomeBookingsController;
use App\Http\Controllers\MVC\Seller\StudioBookingsController;
use App\Http\Controllers\MVC\Seller\ImagesController;
use App\Http\Controllers\MVC\Seller\ReelsController;
use App\Http\Controllers\MVC\Seller\CouponsController;
use App\Http\Controllers\MVC\Seller\ChatController;
use App\Http\Controllers\MVC\Seller\SellersTimetablesController;

use App\Http\Controllers\MVC\Customers\CustomerController;
use App\Http\Controllers\MVC\Customers\ProfileController;
use App\Http\Controllers\MVC\Customers\BookingHomeServicesController;
use App\Http\Controllers\MVC\Customers\BookingStudioServicesController;
use App\Http\Controllers\MVC\Customers\ServicesController;
use App\Http\Controllers\MVC\Customers\RatingController;
use App\Http\Controllers\MVC\Customers\CustomersCouponsController;
use App\Http\Controllers\MVC\Customers\FavouritesController;
use App\Http\Controllers\MVC\Customers\CustomerChatController;

use App\Http\Controllers\OTPController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(HomeController::class)->group(function () {
    // Show Home Page
    Route::get('/', 'index')->name('home');
    // Show Home Service Details
    Route::get('/homeService/{id}', 'showHomeService')->name('homeService.show');
    // Show Studio Service Details
    Route::get('/studioService/{id}', 'showStudioService')->name('studioService.show');
});

// OTP Routes
Route::controller(OTPController::class)->group(function () {
    Route::post('/send-otp','sendOtp')->name('send.otp'); // Send OTP
    Route::post('/verify-otp','verifyOtp')->name('verify.otp'); // Verify OTP
});


//=====================================================================================>
// Admin Routes
//=====================================================================================>
Route::controller(AdminController::class)->group(function () {
    // Show Login Page
    Route::get('/admin/login', 'LoginPage')->name('admin.loginPage');
    // Admin Login Action
    Route::post('/admin/loginAction', 'AdminLogin')->name('admin.login');
});

// In web.php or api.php
Route::get('/subcategories/{categoryId}', [SubCategoriesController::class, 'getSubcategories']);

Route::middleware('auth:admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        // Admin Dashboard
        Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');
        // Admin Logout
        Route::get('/admin/logout', 'AdminLogout')->name('admin.logout');
    });

    Route::controller(CategoriesController::class)->group(function () {
        // Show All Categories
        Route::get('/admin/categories', 'index')->name('admin.categories');
        // Store New Category
        Route::post('/admin/categories/store', 'store')->name('admin.categories.store');
        // Edit Category
        Route::get('/admin/categories/edit/{id}', 'edit')->name('admin.categories.edit');
        // Update Category
        Route::put('/admin/categories/update/{id}', 'update')->name('admin.categories.update');
        // Delete Category
        Route::delete('/admin/categories/destroy/{id}', 'destroy')->name('admin.categories.destroy');
    });

    Route::controller(SubCategoriesController::class)->group(function () {
        // Show All SubCategories
        Route::get('/admin/subCategories', 'index')->name('admin.subCategories');
        // Store New SubCategory
        Route::post('/admin/subCategories/store', 'store')->name('admin.subCategories.store');
        // Edit SubCategory
        Route::get('/admin/subCategories/edit/{id}', 'edit')->name('admin.subCategories.edit');
        // Update SubCategory
        Route::put('/admin/subCategories/update/{id}', 'update')->name('admin.subCategories.update');
        // Delete SubCategory
        Route::delete('/admin/subCategories/destroy/{id}', 'destroy')->name('admin.subCategories.destroy');
    });

    Route::controller(SellersRequestsController::class)->group(function () {
        // Show All Pending Requests
        Route::get('/admin/sellers/requests', 'index')->name('admin.sellers.requests');
        // Show New Request
        Route::get('/admin/sellers/requests/{id}', 'show')->name('admin.sellers.requests.show');
        // Approve Request
        Route::put('/admin/sellers/requests/approve/{id}', 'approveSellerRequest')->name('admin.sellers.requests.approve');
        // Reject Request
        Route::put('/admin/sellers/requests/reject/{id}', 'rejectSellerRequest')->name('admin.sellers.requests.reject');
    });

    // Approved Sellers Routes
    Route::controller(AllSellersController::class)->group(function () {
        // Show All Approved Sellers
        Route::get('/admin/sellers/approved', 'index')->name('admin.sellers.approved');
        // Show Seller Details
        Route::get('/admin/sellers/approved/{id}', 'show')->name('admin.sellers.approved.show');
        // Edit Seller Page
        Route::get('/admin/sellers/edit/{id}', 'edit')->name('admin.sellers.edit');
        // Update Seller
        Route::put('/admin/sellers/update/{id}', 'update')->name('admin.sellers.update');
        // Delete Seller
        Route::delete('/admin/sellers/delete/{id}', 'delete')->name('admin.sellers.delete');
    });
});


//=====================================================================================>

//=====================================================================================>
// Seller Routes
//=====================================================================================>
Route::controller(SellerController::class)->group(function () {
    // Show Register Page
    Route::get('/seller/register', 'sellerRegisterPage')->name('seller.registerPage');
    // Register Action
    Route::post('/seller/registerAction', 'registerSeller')->name('seller.register');
    // Show Login Page
    Route::get('/seller/login', 'sellerLoginPage')->name('seller.loginPage');
    // Login Action
    Route::post('/seller/loginAction', 'sellerLogin')->name('seller.login');
});

Route::middleware('auth:seller')->group(function () {
    Route::controller(SellerController::class)->group(function () {
        // Seller Logout
        Route::get('/seller/logout', 'logout')->name('seller.logout');
        // Seller Dashboard
        Route::get('/seller/dashboard', 'sellerDashboard')->name('seller.dashboard');
        // Get All Clients for a specific seller
        Route::get('/seller/clients', 'getAllClients')->name('seller.clients');
    });

    // Seller Profile Routes
    Route::controller(SellerProfileController::class)->group(function () {
        // Show Profile Page
        Route::get('/seller/profile', 'index')->name('seller.profile');
        // Update Profile
        Route::put('/seller/profile/update/{id}', 'update')->name('seller.profile.update');
    });

    // Employee Routes
    Route::controller(EmployeesController::class)->group(function () {
        // Show All Employees
        Route::get('/seller/employees', 'index')->name('seller.employees');
        // Store New Employee
        Route::post('/seller/employees/store', 'store')->name('seller.employees.store');
        // Edit Employee
        Route::get('/seller/employees/edit/{id}', 'edit')->name('seller.employees.edit');
        // Update Employee
        Route::put('/seller/employees/update/{id}', 'update')->name('seller.employees.update');
        // Delete Employee
        Route::delete('/seller/employees/destroy/{id}', 'destroy')->name('seller.employees.destroy');
    });

    // Home Services Routes
    Route::controller(HomeServicesController::class)->group(function () {
        // Show All Home Services
        Route::get('/seller/homeServices', 'index')->name('seller.homeServices');
        // Show Create Home Service Page
        Route::get('/seller/homeServices/create', 'create')->name('seller.homeServices.create');
        // Store New Home Service
        Route::post('/seller/homeServices/store', 'store')->name('seller.homeServices.store');
        // Show Home Service Details
        Route::get('/seller/homeServices/{id}', 'show')->name('seller.homeServices.show');
        // Edit Home Service
        Route::get('/seller/homeServices/edit/{id}', 'edit')->name('seller.homeServices.edit');
        // Update Home Service
        Route::put('/seller/homeServices/update/{id}', 'update')->name('seller.homeServices.update');
        // Delete Home Service
        Route::delete('/seller/homeServices/destroy/{id}', 'destroy')->name('seller.homeServices.destroy');
    });


    // Studio Services Routes
    Route::controller(StudioServicesController::class)->group(function () {
        // Show All Studio Services
        Route::get('/seller/studioServices', 'index')->name('seller.studioServices');
        // Show Create Studio Service Page
        Route::get('/seller/studioServices/create', 'create')->name('seller.studioServices.create');
        // Store New Studio Service    
        Route::post('/seller/studioServices/store', 'store')->name('seller.studioServices.store');
        // Show Studio Service Details
        Route::get('/seller/studioServices/{id}', 'show')->name('seller.studioServices.show');
        // Edit Studio Service
        Route::get('/seller/studioServices/edit/{id}', 'edit')->name('seller.studioServices.edit');
        // Update Studio Service
        Route::put('/seller/studioServices/update/{id}', 'update')->name('seller.studioServices.update');
        // Delete Studio Service
        Route::delete('/seller/studioServices/destroy/{id}', 'destroy')->name('seller.studioServices.destroy');
    });


    // Home Bookings Routes
    Route::controller(HomeBookingsController::class)->group(function () {
        // Show All Accepted Home Bookings
        Route::get('/seller/homeBookings', 'index')->name('seller.homeBookings');
        // Show All New bookings requests
        Route::get('/seller/homeBookings/newRequests', 'getNewHomeBookings')->name('seller.homeBookings.newRequests');
        // Show Home Booking Request Details
        Route::get('/seller/homeBookings/{id}', 'show')->name('seller.homeBookings.show');
        // Accept Home Booking Request
        Route::put('/seller/homeBookings/accept/{id}', 'acceptHomeBooking')->name('seller.homeBookings.accept');
        // Reject Home Booking Request
        Route::put('/seller/homeBookings/reject/{id}', 'rejectHomeBooking')->name('seller.homeBookings.reject');
        // Show Rejected Home Bookings
        Route::get('/seller/homeBookings/requests/rejected', 'refusedRequests')->name('seller.homeBookings.rejectedRequests');
        // Service is done
        Route::put('/seller/homeBookings/serviceIsDone/{id}', 'homeServiceIsDone')->name('seller.homeBookings.serviceIsDone');
    });

    // Studio Bookings Routes
    Route::controller(StudioBookingsController::class)->group(function () {
        // Show All Accepted Studio Bookings
        Route::get('/seller/studioBookings', 'index')->name('seller.studioBookings');
        // Show All New bookings requests
        Route::get('/seller/studioBookings/newRequests', 'getNewStudioBookings')->name('seller.studioBookings.newRequests');
        // Show Studio Booking Request Details
        Route::get('/seller/studioBookings/{id}', 'show')->name('seller.studioBookings.show');
        // Accept Studio Booking Request
        Route::put('/seller/studioBookings/accept/{id}', 'acceptStudioBooking')->name('seller.studioBookings.accept');
        // Reject Studio Booking Request
        Route::put('/seller/studioBookings/reject/{id}', 'rejectStudioBooking')->name('seller.studioBookings.reject');
        // Show Rejected Studio Bookings
        Route::get('/seller/studioBookings/requests/rejected', 'refusedRequests')->name('seller.studioBookings.rejectedRequests');
        // Service is done
        Route::put('/seller/studioBookings/serviceIsDone/{id}', 'studioServiceIsDone')->name('seller.studioBookings.serviceIsDone');
    });

    // images routes
    Route::controller(ImagesController::class)->group(function () {
        // get all seller images
        Route::get('/seller/images', 'index')->name('seller.images');
        // upload image
        Route::post('/seller/images/upload', 'uploadImage')->name('seller.images.upload');
        // delete image
        Route::delete('/seller/images/destroy/{id}', 'delete')->name('seller.images.destroy');
    });

    // reels routes
    Route::controller(ReelsController::class)->group(function () {
        // get all seller reels
        Route::get('/seller/reels', 'index')->name('seller.reels');
        // upload reel
        Route::post('/seller/reels/upload', 'uploadReel')->name('seller.reels.upload');
        // delete reel
        Route::delete('/seller/reels/destroy/{id}', 'delete')->name('seller.reels.destroy');
    });

    // Coupons Routes
    Route::controller(CouponsController::class)->group(function () {
        // Show All Coupons 
        Route::get('/seller/coupons', 'index')->name('seller.coupons');
        // Store New Coupon
        Route::post('/seller/coupons/store', 'store')->name('seller.coupons.store');
        // Edit Coupon
        Route::get('/seller/coupons/edit/{id}', 'edit')->name('seller.coupons.edit');
        // Update Coupon
        Route::put('/seller/coupons/update/{id}', 'update')->name('seller.coupons.update');
        // Delete Coupon
        Route::delete('/seller/coupons/destroy/{id}', 'destroy')->name('seller.coupons.destroy');
        // Apply a coupon and track usage count
        Route::post('/seller/coupons/apply', 'applyCoupon')->name('seller.coupons.apply');
    });

    // Chat Routes
    Route::controller(ChatController::class)->group(function () {
        // Start a new chat or continue an existing one
        Route::get('/seller/chat/{customerId}', 'startOrResumeChat')->name('seller.chat');
        // Display the messages view for an existing chat session
        Route::get('/seller/chat/messages/{chatRoomId}', 'showMessages')->name('seller.chat.messages');
        // Store a new message in the chat session
        Route::post('/seller/chat/send', 'sendMessage')->name('seller.chat.send');
    });

    // Seller Timetable Routes
    Route::controller(SellersTimetablesController::class)->group(function () {
        // Show All Timetables
        Route::get('/seller/timetables', 'index')->name('seller.timetables');
        // Store New Timetable
        Route::post('/seller/timetables/store', 'store')->name('seller.timetable.store');
        // Edit Timetable
        Route::get('/seller/timetables/edit/{id}', 'edit')->name('seller.timetable.edit');
        // Update Timetable
        Route::put('/seller/timetables/update/{id}', 'update')->name('seller.timetable.update');
        // Delete Timetable
        Route::delete('/seller/timetables/destroy/{id}', 'destroy')->name('seller.timetable.destroy');
    });
});

//=====================================================================================>

//=====================================================================================>
// Customer Routes
//=====================================================================================>
Route::controller(CustomerController::class)->group(function () {
    // Show Register Page
    Route::get('/customer/register', 'customerRegisterPage')->name('customer.registerPage');
    // Register Action
    Route::post('/customer/registerAction', 'registerCustomer')->name('customer.register');
    // Show Login Page
    Route::get('/customer/login', 'customerLoginPage')->name('customer.loginPage');
    // Login Action
    Route::post('/customer/loginAction', 'customerLogin')->name('customer.login');
});

// Customer authenticated routes
Route::middleware('auth:customer')->group(function () {

    Route::controller(CustomerController::class)->group(function () {
        // Customer Profile
        Route::get('/customer/profile', 'index')->name('customer.profile');
        // Logout Action
        Route::get('/customer/logout', 'logout')->name('customer.logout');
        // get all sellers for the customer
        Route::get('/customer/sellers', 'getCustomerSellers')->name('customer.sellers');
    });

    Route::controller(ProfileController::class)->group(function () {
        // Update Profile
        Route::put('/customer/profile/update/{id}', 'update')->name('customer.profile.update');
    });
});

// Get Working Days
Route::get('/seller/{sellerId}/active-weekdays', [BookingHomeServicesController::class, 'getSellerActiveWeekdays'])->name('getSellerActiveWeekdays');
// check available times
Route::post('/check-available-times', [BookingHomeServicesController::class, 'checkAvailableTimes'])->name('checkAvailableTimes');
// Check Employee Availability
Route::post('/check-employee-availability', [BookingHomeServicesController::class, 'checkEmployeeAvailability'])->name('checkEmployeeAvailability');
// Get Related Employees By Home Service
Route::get('/get-employees/{serviceId}', [ServicesController::class, 'getEmployeesByService'])->name('getEmployeesByService');
// Get Related Employees By Studio Service
Route::get('/get-studio-employees/{serviceId}', [ServicesController::class, 'getStudioEmployeesByService'])->name('getStudioEmployeesByService');



Route::middleware('auth:customer')->group(function () {
    Route::controller(BookingHomeServicesController::class)->group(function () {
        // Book Home Service
        Route::post('/customer/bookHomeService', 'store')->name('customer.bookHomeService');
        // Edit Home Service
        Route::get('/customer/bookHomeService/edit/{id}', 'edit')->name('customer.bookHomeService.edit');
        // Update Home Service
        Route::put('/customer/bookHomeService/update/{id}', 'update')->name('customer.bookHomeService.update');
        // Add Service To Existing Booking
        Route::post('/customer/bookHomeService/addServiceToExistingBooking', 'addServiceToExistingBooking')->name('customer.bookHomeService.addServiceToExistingBooking');
    });

    Route::controller(BookingStudioServicesController::class)->group(function () {
        // Book Studio Service
        Route::post('/customer/bookStudioService', 'store')->name('customer.bookStudioService');
        // Edit Studio Service
        Route::get('/customer/bookStudioService/edit/{id}', 'edit')->name('customer.bookStudioService.edit');
        // Update Studio Service
        Route::put('/customer/bookStudioService/update/{id}', 'update')->name('customer.bookStudioService.update');
        // Add Service To Existing Booking
        Route::post('/customer/bookStudioService/addServiceToExistingBooking', 'addStudioServiceToExistingBooking')->name('customer.bookStudioService.addServiceToExistingBooking');
    });

    Route::controller(servicesController::class)->group(function () {
        // Show All Home Bookings
        Route::get('/customer/homeBookings', 'getHomeBookings')->name('customer.homeBookings');
        // Show All Studio Bookings
        Route::get('/customer/studioBookings', 'getStudioBookings')->name('customer.studioBookings');
    });

    Route::controller(RatingController::class)->group(function () {
        // Store Rating
        Route::post('/ratings','store')->name('ratings.store');
    });

    Route::controller(CustomersCouponsController::class)->group(function () {
        // Show All available coupons
        Route::get('/customer/coupons', 'index')->name('customer.coupons');
    });

    // Favourites Routes
    Route::controller(FavouritesController::class)->group(function () {
        // Show All Favourites
        Route::get('/customer/favourites', 'index')->name('customer.favourites');
        // Add Favourite for a specific seller page
        Route::get('/customer/favourites/add', 'create')->name('customer.favourites.add');
        // Add Favourite for a specific seller
        Route::post('/customer/favourites/store/{sellerId}', 'store')->name('customer.favourites.store');
        // Delete favourite
        Route::delete('/customer/favourites/destroy/{id}', 'destroy')->name('customer.favourites.destroy');
    });

    // Chat Routes
    Route::controller(CustomerChatController::class)->group(function () {
        // Start a new chat or continue an existing one
        Route::get('/customer/chat/{customerId}', 'startOrResumeChat')->name('customer.chat');
        // Display the messages view for an existing chat session
        Route::get('/customer/chat/messages/{chatRoomId}', 'showMessages')->name('customer.chat.messages');
        // Store a new message in the chat session
        Route::post('/customer/chat/send', 'sendMessage')->name('customer.chat.send');
    });
});


//=====================================================================================>

Route::post('/broadcasting/auth', function (Request $request) {
    try {
        return Broadcast::auth($request);
    } catch (Exception $e) {
        \Log::error('Pusher auth error: ' . $e->getMessage());
        return response()->json(['error' => 'Authentication failed'], 500);
    }
})->middleware('auth:seller');


Route::post('/broadcasting/auth/customer', function (Request $request) {
    try {
        return Broadcast::auth($request);
    } catch (Exception $e) {
        \Log::error('Pusher auth error: ' . $e->getMessage());
        return response()->json(['error' => 'Authentication failed'], 500);
    }
})->middleware('auth:customer');


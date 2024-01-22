<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\TokenVerifiedMiddleware;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });


//web api
Route::post('/user', [UserController::class,'UserRegisgter']);
Route::post('/user/login', [UserController::class,'UserLogin']);
Route::post('/user/otp', [UserController::class,'OTPMail']);
Route::post('/user/send-otp', [UserController::class,'OTPVerified']);
//token verified and reset passeword
Route::post('/user/resetPassword', [UserController::class,'resetPassword'])
            ->middleware(TokenVerifiedMiddleware::class);

 Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerifiedMiddleware::class]);
 Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerifiedMiddleware::class]);
// User Logout
Route::get('/logout',[UserController::class,'UserLogout']);


// Category API
Route::post("/create-category",[CategoryController::class,'CategoryCreate'])->middleware([TokenVerifiedMiddleware::class]);
Route::get("/list-category",[CategoryController::class,'CategoryList'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware([TokenVerifiedMiddleware::class]);

// Product API
Route::post("/create-product",[ProductController::class,'CreateProduct'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/delete-product",[ProductController::class,'DeleteProduct'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/update-product",[ProductController::class,'UpdateProduct'])->middleware([TokenVerifiedMiddleware::class]);
Route::get("/list-product",[ProductController::class,'ProductList'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/product-by-id",[ProductController::class,'ProductByID'])->middleware([TokenVerifiedMiddleware::class]);

//customer Api 

Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware([TokenVerifiedMiddleware::class]);
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerifiedMiddleware::class]);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware([TokenVerifiedMiddleware::class]);

// Page Routes
Route::get('/',[HomeController::class,'HomePage']);
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerifiedMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerifiedMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerifiedMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerifiedMiddleware::class]);


Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerifiedMiddleware::class]);
// Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerifiedMiddleware::class]);
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerifiedMiddleware::class]);
// Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerifiedMiddleware::class]);
// Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerifiedMiddleware::class]);
// Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerifiedMiddleware::class]);
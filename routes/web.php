<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

// Page Routes
Route::get('/',[HomeController::class,'HomePage']);
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerifiedMiddleware::class]);
 Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerifiedMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerifiedMiddleware::class]);



// Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);
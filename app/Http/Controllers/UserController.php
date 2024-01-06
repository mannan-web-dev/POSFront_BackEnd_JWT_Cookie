<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
   
    public function LoginPage(){
        return view("pages.auth.login-page");
    }
    function RegistrationPage(){
        return view('pages.auth.registration-page');
    }

    function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPPage(){
        return view('pages.auth.verify-otp-page');
    }
    function ResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage(){
        return view('pages.dashboard.profile-page');
    }


    //Backend Data
    public function UserRegisgter(Request $request){

        try {
            User::create([
                "firstName"=> $request->firstName,
                "lastName"=> $request->lastName,
                "email"=> $request->email,
                "mobile"=> $request->mobile,
                "password"=> $request->password,
                // "otp"=> "otp", //  define in model
            ]);
    
         return response()->json([
            "status"=> "success",
            "message"=> "user created succesfully"
         ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> "error",
                "message"=> "user Registration fail"
            ], 200);
            
        }
 
    }

    public function UserLogin(Request $request){

        $count = User::where('email', '=', $request->input("email"))
        ->where('password', '=', $request->input("password"))
        ->select('id')->first();
        
        if ($count !== null) {
            $token = JWTToken::JWTCreate($request->input("email"),$count->id);
            return response()->json([
                "status"=> "success",
                "message"=> "user Login",
                // "token"=> $token
            ], 200)->cookie("token", $token, time()+60*24*20);

        } else {
            return response()->json([
                "status"=> "Fail",
                "message"=> "Unautthorized"
            ], 200);
        }
    }


    public function OTPMail(Request $request){

        $email = $request->input("email");
        $otp = rand(1000, 9999);
        $chk = User::where('email', '=', $request->input("email"))->count();;
        if ($chk == 1) {
            //otp send to email
            Mail::to($email)->send(new OTPMail($otp));
            // otp send to database
            User::where('email','=', $email)->update(["otp"=> $otp]);

            return response()->json([
                "status"=> "success",
                "message"=> "The OTP code hase been send to your Email"
            ], 200);

        }else{
            return response()->json([
                "status"=> "Fail",
                "message"=> "Unautthorized"
            ], 200);
        }

    }

    public function OTPVerified(Request $request){
        $email = $request->input("email");
        $otp = $request->input("otp");

        $chk = User::where("email", "=", $request->input("email"))
                 ->where("otp","=", $otp)
                 ->count();

        //    return $chk;

        if ($chk == 1) {
            //new token generate for reset passweord
            $token = JWTToken::JWTTokenForResetPassword($email);

             //otp update in database
             User::where('email','=', $email)->update(["otp"=> 0]);

            return response()->json([
                "status"=> "success",
                "message"=> "otp successfully sent",
            ], 200)->cookie('token',$token,60*24*30);

        }else{
            return response()->json([
                "status"=> "Fail",
                "message"=> "please input vailed OTP"
            ], 200);
        }
    }

    public function resetPassword(Request $request){
        try {
            $email = $request->header("email");
            $password = $request->input("password");
            User::where("email", "=", $email)->update(["password"=>$password]);

            // return $email;
            return response()->json([
                "status"=> "success",
                "message"=> "password has been reset",
            ], 200);
        } catch ( Exception $e ) {
            return response()->json([
                "status"=> "Fail",
                "message"=> "somwthing went wrong"
            ], 200);
        }
        
    }

    function UserLogout(){
        return redirect('/userLogin')->cookie('token','',-1);
    }

    function UserProfile(Request $request){
        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ],200);
    }

    function UpdateProfile(Request $request){
        try{
            $email=$request->header('email');
            $firstName=$request->input('firstName');
            $lastName=$request->input('lastName');
            $mobile=$request->input('mobile');
            $password=$request->input('password');
            User::where('email','=',$email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }
}

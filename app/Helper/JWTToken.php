<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{
    public static function JWTCreate($userEmail, $userID):string{
        $key = env("JWT_KEY");

        $payload = [
            'iss' => 'Laravel-token',
            'iat' => time(),
            'exp' => time()+60*60,
            'userEmail'=> $userEmail,
            'userID'=> $userID,
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return  $token;
       
    }

    //otp verfied token decode 
    public static function JWTVerify($token):string|object{

        try {

            if ($token == null) {
                return 'unauthorized';
            }else {
                $key = env("JWT_KEY");
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
               return $decoded;
            }

        } catch (Exception $e) {
            return 'Unautthorized';
            
        }
        
    }

        // otp password reset tokken
    public static function JWTTokenForResetPassword($userEmail):string{
        $key = env("JWT_KEY");
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time()+60*60,
            'userEmail'=> $userEmail,
            'userID'=> 0,
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return  $token;
       
    }
}

?>
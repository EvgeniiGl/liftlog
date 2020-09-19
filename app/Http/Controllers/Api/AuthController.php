<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use Validator;

class AuthController extends ResponseController
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $credentials = request(['login',
                                'password']);
        if (!Auth::attempt($credentials)) {
            $error = "Не авторизован";
            return $this->sendError($error, 401);
        }
        $user             = $request->user();
        $success['token'] = $user->createToken('token')->accessToken;
        return $this->sendResponse($success);
    }

    //logout
    public function logout(Request $request)
    {
        $isUser = $request->user()->token()->revoke();
        if ($isUser) {
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        } else {
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
    }


}

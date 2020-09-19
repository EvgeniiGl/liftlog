<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function __invoke(Request $request)
//    {
//        $credentials = $request->only('login', 'password');
//
//        if (!Auth::attempt($credentials)) {
//            return response()->json([
//                'message' => 'Такого пользователя нет!',
//                'errors'  => 'Unauthorised'
//            ], 401);
//        }
//        $token = Auth::user()->createToken(config('app.name'));
////        $token->token->expires_at = $request->remember_me ?
////            Carbon::now()->addMonth()->format(config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat')) :
////            Carbon::now()->addDay()->format(config('datetime_format.dateFormat'). " " . config('datetime_format.timeFormat'));
////        $token->token->save();
////
////        return response()->json([
////            'token_type' => 'Bearer',
////            'token'      => $token->accessToken,
////            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
////        ], 200);
//
//        return response()->json([
//            'id' => Auth::user()->id
//        ], 200);
//    }
}

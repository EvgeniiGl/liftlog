<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use ResponseHelper;

/**
 * Class for mobile devices
 *
 * Class DeviceController
 * @package App\Http\Controllers\Api
 */
class DeviceController extends Controller
{
    /**
     * Register mobile devices for push notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'token' => 'required|string'
        ]);
        if ($validator->fails()) {
            ResponseHelper::setCode(422);
            ResponseHelper::setMessage("Ошибка валидации");
            ResponseHelper::setData($validator->errors()->toArray());
            return ResponseHelper::errorResponse();
        }
        $user = \Auth::user();
        Device::updateOrCreate(
            ['user_id' => $user->id],
            $validator->getData()
        );
        return ResponseHelper::successResponse();
    }
}

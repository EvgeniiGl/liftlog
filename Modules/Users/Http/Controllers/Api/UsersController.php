<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Users\Repositories\UsersRepository;

class UsersController extends Controller
{

    protected $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
        $data = ['user' => $user];
        if ($user) {
            return response()->json($data, 200);
        } else {
            $response = ["error" => "user not found"];
            return response()->json($response, 404);
        }
    }


}

<?php

namespace Modules\Users\Http\Controllers;

use App\Helpers\Response\ResponseHelper;
use App\Helpers\SharedDataHelper;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Modules\Users\Http\Requests\UsersAccessRequest;
use Modules\Users\Http\Requests\UsersRequest;
use Modules\Users\Repositories\UsersRepository;

class UsersController extends Controller
{
    /**
     * @var UsersRepository
     */
    protected $usersRepository;
    protected $addressRepository;
    /**
     * @var SharedDataHelper
     */
    private $sharedDataHelper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->usersRepository  = new UsersRepository();
        $this->sharedDataHelper = new SharedDataHelper();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->cannot('view', $user)) {
            return redirect('login');
        }
        $this->sharedDataHelper->put("currentUser", [
            'id'   => $user->id,
            'name' => $user->name,
            'role' => $user->role
        ]);
        $users         = $this->usersRepository->all();
        $usersRoles    = User::getRolesUsers();
        $notifications = User::getNotifications();
        $data          = compact('users', 'usersRoles', 'notifications');
//        dd($data);
        return view('users::index', $data);
    }

//    public function access(UsersAccessRequest $request)
//    {
//        $data = $request->validated();
//        $this->usersRepository->update($data, $data['id']);
//        return response()->json([
//            "access" => (int)$data['access'],
//            'status' => true
//        ]);
//    }

    public function access(UsersAccessRequest $request)
    {
        $user = Auth::user();
        if ($user->cannot('write', $user)) {
            return back();
        }
        $data = $request->validated();
        $this->usersRepository->update($data, $data['id']);
        return back();
    }

    public function address(Request $request)
    {
        dd($request->all());
        $user = Auth::user();
        if ($user->cannot('write', $user)) {
            return back();
        }
        $data = $request->validated();
        $this->usersRepository->update($data, $data['id']);
        return back();
    }

    protected function create(UsersRequest $request)
    {
        $user = Auth::user();
        if ($user->cannot('write', $user)) {
            return back();
        }
        //TODO show errors validate
        $data             = $request->validated();
        $data['password'] = Hash::make($data['password']);
        if ($data['role'] !== 'диспетчер') {
            $data['notificate'] = $user->getNotificateID('свои');
        }
        try {
            if (!empty($data['id'])):
                $user = User::find($data['id']);
                unset($data['id']);
                $result = $user->fill($data)->save();
            else:
                $result = User::create($data);
            endif;
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode() === "23000") {
                $request->session()->flash('message', 'Такой логин уже существует');
            }
            $request->session()->flash('alert-class', 'alert-danger');
            return back()->withInput();
        }
        Session::flash('message', 'Успешно!');
        Session::flash('alert-class', 'alert-success');
        return back()->withInput();
    }

    public function token()
    {
        $token  = Auth::user()->createToken('token')->accessToken;
        $tokens = [
            'token'        => $token,
            'refreshToken' => '',
        ];
        ResponseHelper::setData($tokens);
        return ResponseHelper::successResponse();
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return RedirectResponse|null
     */
    public function destroy(int $id): ?RedirectResponse
    {
        $user = Auth::user();
        if ($user->cannot('write', $user)) {
            return back();
        }
        $result = $this->usersRepository->delete($id);
        if ($result) {
            return redirect()->back();
        };
    }

    public function setNotificate(Request $request, int $userId)
    {
        $currentUser = Auth::user();
        if ($currentUser->cannot('write', $currentUser)) {
            return ResponseHelper::errorResponse();
        }
        $user       = User::find($userId);
        $userNotifs = $user->getNotifications();
        $data       = $request->validate([
            'notificate' => [
                'required',
                Rule::in($userNotifs)
            ],
        ]);
        $user->update($data);
        return ResponseHelper::successResponse();
    }
}

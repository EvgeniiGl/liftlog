<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * @var User
     */
    protected $model;


    /**
     * Create a new controller instance.
     * @param User $model
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $userRoles = $this->model->getRolesUsers();
        $validator = Validator::make($data, [
            'id'       => ['nullable',
                           'integer',
                           'max:255'],
            'name'     => ['required',
                           'string',
                           'max:255'],
            'login'    => ['required',
                           'string',
                           'max:255',
                           'unique:users'],
            'phone'    => ['required',
                           'integer'],
            //            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required',
                           'string',
                           'min:8',
                           'confirmed'],
            'role'     => ['required',
                           Rule::in($userRoles)],
        ]);
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User&static|bool|mixed
     */
    protected function create(array $data)
    {
        $user = [
            'name'     => $data['name'],
            'login'    => $data['login'],
            'phone'    => $data['phone'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'access'   => empty($data['access'])?0:1,
        ];
        if (!empty($data['id'])):
            $user   = User::find($data['id']);
            $result = $user->fill($data)->save();
        else:
            $result = User::create($user);
        endif;
        return $result;
    }

    public function showRegistrationForm()
    {
        $data['roles']=User::getSimpleRolesUsers();
        return view('auth.register', $data);
    }

    public function register(Request $request)
    {
       $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}

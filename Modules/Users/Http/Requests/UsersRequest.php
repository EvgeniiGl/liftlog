<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;

class UsersRequest extends FormRequest
{
    /**
     * @var User
     */
    protected $model;

    /**
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO check this authorize

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userRoles = $this->model->getRolesUsers();
        $rules     = [
            "id"             => 'integer|nullable',
            'name'           => 'required|string|max:255',
            'login'          => 'required|string|max:255',
            'phone'          => 'required|integer',
            'password'       => 'required|string|min:8|max:255|confirmed',
            'role'           => ['required',
                                 Rule::in($userRoles)],
            'access_users'   => 'integer|nullable',
            'access_records' => 'integer|nullable',
        ];
        return $rules;
    }
}

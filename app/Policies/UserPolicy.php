<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */


    public function view(User $user)
    {
        if (empty($user->access_users)) {
            Session::flash('message', 'Доступ запрещен!');
            Session::flash('alert-class', 'alert-danger');
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function write(User $user)
    {
        if ($user->access_users != 2) {
            Session::flash('message', 'Нет прав на редактирование!');
            Session::flash('alert-class', 'alert-danger');
            return false;
        }
        return true;
    }

}

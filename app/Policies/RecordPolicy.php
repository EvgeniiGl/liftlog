<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Session;

class RecordPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        if (empty($user->access_records)) {
            Session::flash('message', 'Доступ запрещен!');
            Session::flash('alert-class', 'alert-danger');
            return false;
        }
        return true;
    }

    public function write(User $user)
    {
        if ($user->access_records != 2) {
            Session::flash('message', 'Нет прав на редактирование!');
            Session::flash('alert-class', 'alert-danger');
            return false;
        }
        return true;
    }
}

<?php

namespace Modules\Users\Http\Middleware;

use App\User;
use Auth;
use Closure;

class UserAdmin
{
    public function handle($request, Closure $next)
    {
//        $rolesAdmin = User::getAdminRolesUsers();
//        foreach ($rolesAdmin as $role) {
//            if ($role === Auth::user()->role) {
                return $next($request);
//            }
//        }
//        return redirect('records');
    }

}

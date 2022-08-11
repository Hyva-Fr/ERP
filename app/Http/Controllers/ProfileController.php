<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Widgets\UserWidget;
use Auth;
use App\Models\Role;
use App\Models\RoleUser;

class ProfileController extends Controller
{
    public function index()
    {
        $widget = UserWidget::single(Auth::user()->id);
        $roles = Role::get();

        $userRoles = RoleUser::select('roles.id', 'roles.name')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', Auth::user()->id)
            ->get();

        $rolesIDs = [];
        foreach ($userRoles as $userRole) {
            $rolesIDs[] = $userRole->id;
        }
        return view('profile.index', compact('widget', 'roles', 'rolesIDs'));
    }
}

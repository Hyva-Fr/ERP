<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Role;
use App\Models\Agency;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\UserWidget;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'users';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id',
            'firstname',
            'lastname',
            'email_verified_at',
            'password',
            'two_factor_secret',
            'two_factor_recovery_codes',
            'two_factor_confirmed_at',
            'remember_token',
            'updated_at'
        ];
        $thead = setColumns($keys, $excepts);
        $extracts = [
            'agency' => [
                'route' => 'agencies',
                'rel' => 'agency_id'
            ]
        ];
        $filters = [];

        foreach ($thead as $filter) {
            if(!array_key_exists($filter, $extracts)) {
                $filters[] = $filter;
            }
        }

        $query = User::select(
            'users.id',
            'users.avatar',
            'users.name',
            'users.email',
            'users.employed',
            'users.agency_id',
            'agencies.name as agency',
            'users.created_at',
        )
            ->join('agencies', 'users.agency_id', '=', 'agencies.id');

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = UserWidget::all();
        $compact = compact('thead', 'data', 'excepts', 'table', 'extracts', 'widget');

        if (\Request::ajax()) {
            return view('cruds.table', $compact);
        }

        return view('cruds.index', $compact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agencies = Agency::get();
        $roles = Role::get();
        return view('cruds.users.edit-show', compact('agencies', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:80',
            'lastname' => 'required|max:80',
            'employed' => 'required|boolean',
            'email' => 'required|unique:users',
            'agency_id' => 'required|integer',
        ]);

        $user = User::create([
            'avatar' => $request->input('avatar'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'employed' => $request->input('employed'),
            'agency_id' => $request->input('agency_id'),
        ]);

        if ($request->input('roles') !== null) {
            foreach ($request->input('roles') as $role) {
                RoleUser::create([
                    'user_id' => $user->id,
                    'role_id' => $role
                ]);
            }
        }

        Session::flash('message', 'Successfully created user!');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::select(
            'users.id',
            'users.avatar',
            'users.firstname',
            'users.lastname',
            'users.email',
            'users.employed',
            'users.agency_id',
            'agencies.name as agency',
            'users.created_at',
        )
            ->join('agencies', 'users.agency_id', '=', 'agencies.id')
            ->where('users.id', $id)
            ->firstOrFail();

        $agencies = Agency::get();
        $widget = UserWidget::single($id);
        $roles = Role::get();

        $userRoles = RoleUser::select('roles.id', 'roles.name')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', $id)
            ->get();

        $rolesIDs = [];
        foreach ($userRoles as $userRole) {
            $rolesIDs[] = $userRole->id;
        }

        return view('cruds.users.edit-show', compact('data', 'id', 'agencies', 'widget', 'roles', 'rolesIDs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::select(
            'users.id',
            'users.avatar',
            'users.firstname',
            'users.lastname',
            'users.email',
            'users.employed',
            'users.agency_id',
            'agencies.name as agency',
            'users.created_at',
        )
            ->join('agencies', 'users.agency_id', '=', 'agencies.id')
            ->where('users.id', $id)
            ->firstOrFail();

        $roles = Role::get();

        $userRoles = RoleUser::select('roles.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', $id)
            ->get();

        $rolesIDs = [];
        foreach ($userRoles as $userRole) {
            $rolesIDs[] = $userRole->id;
        }

        $agencies = Agency::get();
        $widget = UserWidget::single($id);

        return view('cruds.users.edit-show', compact('data', 'id', 'agencies', 'widget', 'roles', 'rolesIDs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:80',
            'lastname' => 'required|max:80',
            'employed' => 'required|boolean',
            'email' => 'required|unique:users,' . $id,
            'agency_id' => 'required|integer',
        ]);

        User::where('id', $id)->update([
            'avatar' => $request->input('avatar'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'employed' => $request->input('employed'),
            'agency_id' => $request->input('agency_id'),
        ]);

        if ($request->input('roles') !== null) {
            RoleUser::where('user_id', $id)->delete();
            foreach ($request->input('roles') as $role) {
                RoleUser::create([
                    'user_id' => $id,
                    'role_id' => $role
                ]);
            }
        }

        Session::flash('message', 'Successfully updated user!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        RoleUser::where('user_id', $id)->delete();
        Session::flash('message', 'Successfully deleted user!');
        return redirect()->route('users.index');
    }
}

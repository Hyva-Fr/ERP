<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Constants\PermissionsConstants;
use JsonException;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'roles';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [];
        $filters = [];

        $query = Role::select(
            'roles.id',
            'roles.name',
            'roles.code',
            'roles.constants',
            'roles.created_at',
        );

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $compact = compact('thead', 'data', 'excepts', 'table', 'extracts');

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
        $constants = PermissionsConstants::getConstants();
        $constantsKeys = array_keys($constants);
        return view('cruds.roles.edit-show', compact('constants', 'constantsKeys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:80|unique:roles,name',
            'code' => 'required|max:80|unique:roles,code',
            'constants' => 'required',
        ]);

        Role::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'constants' => json_encode($request->input('constants'), JSON_THROW_ON_ERROR)
        ]);
        
        Session::flash('message', 'Successfully created role!');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function show($id)
    {
        $data = Role::select(
            'roles.id',
            'roles.name',
            'roles.code',
            'roles.constants',
            'roles.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();

        $constants = PermissionsConstants::getConstants();
        $data->constants = json_decode($data->constants, true, 512, JSON_THROW_ON_ERROR);
        $constantsKeys = array_keys($constants);

        return view('cruds.roles.edit-show', compact('data', 'id', 'constants', 'constantsKeys'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function edit($id)
    {
        $data = Role::select(
            'roles.id',
            'roles.name',
            'roles.code',
            'roles.constants',
            'roles.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();

        $constants = PermissionsConstants::getConstants();
        $data->constants = json_decode($data->constants, true, 512, JSON_THROW_ON_ERROR);
        $constantsKeys = array_keys($constants);

        return view('cruds.roles.edit-show', compact('data', 'id', 'constants', 'constantsKeys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:80|unique:roles,name,' . $id,
            'code' => 'required|max:80|unique:roles,code,' . $id,
            'constants' => 'required',
        ]);

        Role::where('id', $id)->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'constants' => json_encode($request->input('constants'), JSON_THROW_ON_ERROR)
        ]);

        Session::flash('message', 'Successfully updated role!');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted role!');
        return redirect()->route('roles.index');
    }
}

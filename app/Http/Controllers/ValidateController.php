<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validate;
use App\Models\User;
use App\Models\Form;
use App\Models\Mission;
use App\Models\Agency;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\ValidateWidget;
use Session;
use Auth;

class ValidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'validates';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [
            'user' => [
                'route' => 'users',
                'rel' => 'user_id'
            ],
            'form' => [
                'route' => 'forms',
                'rel' => 'form_id'
            ],
            'mission' => [
                'route' => 'missions',
                'rel' => 'mission_id'
            ],
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

        $query = Validate::select(
            'validates.id',
            'validates.content',
            'validates.agency_id',
            'agencies.name as agency',
            'validates.user_id',
            'users.name as user',
            'validates.form_id',
            'forms.name as form',
            'validates.mission_id',
            'missions.serial as mission',
            'validates.created_at',
        )
            ->join('agencies', 'validates.agency_id', '=', 'agencies.id')
            ->join('users', 'validates.user_id', '=', 'users.id')
            ->join('forms', 'validates.form_id', '=', 'forms.id')
            ->join('missions', 'validates.mission_id', '=', 'missions.id')
            ->where('validates.agency_id', Auth::user()->agency_id);

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
    /*public function create()
    {
        $users = User::get();
        $forms = Form::get();
        $missions = Mission::get();
        $agencies = Agency::get();
        return view('cruds.validates.edit-show', compact('users', 'forms', 'missions', 'agencies'));
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        Validate::create([
            'content' => $request->input('content'),
            'user_id' => $request->input('user_id'),
            'form_id' => $request->input('form_id'),
            'mission_id' => $request->input('mission_id'),
            'agency_id' => $request->input('agency_id')
        ]);
        Session::flash('message', 'Successfully created Mission form!');
        return redirect()->route('completed-forms.index');
    }*/

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \JsonException
     */
    public function show($id)
    {
        $data = Validate::select(
            'validates.id',
            'validates.content',
            'validates.agency_id',
            'agencies.name as agency',
            'validates.user_id',
            'users.name as user',
            'validates.form_id',
            'forms.name as form',
            'validates.mission_id',
            'missions.serial as mission',
            'validates.created_at',
        )
            ->join('agencies', 'validates.agency_id', '=', 'agencies.id')
            ->join('users', 'validates.user_id', '=', 'users.id')
            ->join('forms', 'validates.form_id', '=', 'forms.id')
            ->join('missions', 'validates.mission_id', '=', 'missions.id')
            ->where(['validates.id' => $id, 'validates.agency_id' => Auth::user()->agency_id])
            ->firstOrFail();

        $user = User::where('id', $data->user_id)->first();
        $form = Form::where('id', $data->form_id)->first() ?? json_decode($data->form, true, 512, JSON_THROW_ON_ERROR);
        $mission = Mission::where('id', $data->mission_id)->first() ?? json_decode($data->mission, true, 512, JSON_THROW_ON_ERROR);
        $agency = Agency::where('id', $data->agency_id)->first();

        return view('cruds.validates.edit-show', compact('data', 'id', 'user', 'form', 'mission', 'agency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        $data = Validate::select(
            'validates.id',
            'validates.content',
            'validates.agency_id',
            'agencies.name as agency',
            'validates.user_id',
            'users.name as user',
            'validates.form_id',
            'forms.name as form',
            'validates.mission_id',
            'missions.serial as mission',
            'validates.created_at',
        )
            ->join('agencies', 'validates.agency_id', '=', 'agencies.id')
            ->join('users', 'validates.user_id', '=', 'users.id')
            ->join('forms', 'validates.form_id', '=', 'forms.id')
            ->join('missions', 'validates.mission_id', '=', 'missions.id')
            ->where('validates.id', $id)
            ->firstOrFail();

        $users = User::get();
        $forms = Form::get();
        $missions = Mission::get();
        $agencies = Agency::get();

        return view('cruds.validates.edit-show', compact('data', 'id', 'users', 'forms', 'missions', 'agencies'));
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        Validate::where('id', $id)->update([
            'content' => $request->input('content'),
            'user_id' => $request->input('user_id'),
            'form_id' => $request->input('form_id'),
            'mission_id' => $request->input('mission_id'),,
            'agency_id' => $request->input('agency_id')
        ]);
        Session::flash('message', 'Successfully updated Mission form!');
        return redirect()->route('completed-forms.index');
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Validate::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted Mission form!');
        return redirect()->route('completed-forms.index');
    }
}

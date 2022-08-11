<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\StateWidget;
use Session;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'states';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [
            'country' => [
                'route' => 'countries',
                'rel' => 'country_id'
            ]
        ];
        $filters = [];

        foreach ($thead as $filter) {
            if(!array_key_exists($filter, $extracts)) {
                $filters[] = $filter;
            }
        }

        $query = State::select(
            'states.id',
            'states.name',
            'states.code',
            'states.country_id',
            'countries.name as country',
            'states.created_at',
        )
            ->join('countries', 'states.country_id', '=', 'countries.id');

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = StateWidget::all();
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
        $countries = Country::get();
        return view('cruds.states.edit-show', compact('countries'));
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
            'name' => 'required|max:80|unique:states,name',
            'code' => 'required|max:5|unique:states,code',
            'country_id' => 'required|integer',
        ]);

        State::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'country_id' => $request->input('country_id'),
        ]);

        Session::flash('message', 'Successfully created state!');
        return redirect()->route('states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = State::select(
            'states.id',
            'states.name',
            'states.code',
            'states.country_id',
            'countries.name as country',
            'states.created_at',
        )
            ->join('countries', 'states.country_id', '=', 'countries.id')
            ->where('states.id', $id)
            ->firstOrFail();

        $countries = Country::get();
        $widget = StateWidget::single($id);

        return view('cruds.states.edit-show', compact('data', 'id', 'countries', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = State::select(
            'states.id',
            'states.name',
            'states.code',
            'states.country_id',
            'countries.name as country',
            'states.created_at',
        )
            ->join('countries', 'states.country_id', '=', 'countries.id')
            ->where('states.id', $id)
            ->firstOrFail();

        $countries = Country::get();
        $widget = StateWidget::single($id);

        return view('cruds.states.edit-show', compact('data', 'id', 'countries', 'widget'));
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
            'name' => 'required|max:80|unique:states,name,' . $id,
            'code' => 'required|max:5|unique:states,code,' . $id,
            'country_id' => 'required|integer',
        ]);

        State::where('id', $id)->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'country_id' => $request->input('country_id'),
        ]);
        
        Session::flash('message', 'Successfully updated state!');
        return redirect()->route('states.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        State::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted state!');
        return redirect()->route('states.index');
    }
}

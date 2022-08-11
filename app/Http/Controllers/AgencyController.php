<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\State;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\AgencyWidget;
use Session;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'agencies';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [
            'state' => [
                'route' => 'states',
                'rel' => 'state_id'
            ]
        ];
        $filters = [];

        foreach ($thead as $filter) {
            if(!array_key_exists($filter, $extracts)) {
                $filters[] = $filter;
            }
        }

        $query = Agency::select(
            'agencies.id',
            'agencies.name',
            'agencies.street',
            'agencies.zip',
            'agencies.city',
            'agencies.state_id',
            'states.name as state',
            'agencies.created_at',
        )
            ->join('states', 'agencies.state_id', '=', 'states.id');
        
        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = AgencyWidget::all();
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
        $states = State::get();
        return view('cruds.agencies.edit-show', compact('states'));
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
            'name' => 'required|unique:agencies|max:80',
            'street' => 'required|max:255',
            'zip' => 'required|max:20',
            'city' => 'required|max:150',
            'state_id' => 'required|integer',
        ]);

        Agency::create([
            'name' => $request->input('name'),
            'street' => $request->input('street'),
            'zip' => $request->input('zip'),
            'city' => $request->input('city'),
            'state_id' => $request->input('state_id')
        ]);

        Session::flash('message', 'Successfully created agency!');
        return redirect()->route('agencies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Agency::select(
            'agencies.id',
            'agencies.name',
            'agencies.street',
            'agencies.zip',
            'agencies.city',
            'agencies.state_id',
            'states.name as state',
            'agencies.created_at',
        )
            ->join('states', 'agencies.state_id', '=', 'states.id')
            ->where('agencies.id', $id)
            ->firstOrFail();

        $states = State::get();
        $widget = AgencyWidget::single($id);

        return view('cruds.agencies.edit-show', compact('data', 'id', 'states', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Agency::select(
            'agencies.id',
            'agencies.name',
            'agencies.street',
            'agencies.zip',
            'agencies.city',
            'agencies.state_id',
            'states.name as state',
            'agencies.created_at',
        )
            ->join('states', 'agencies.state_id', '=', 'states.id')
            ->where('agencies.id', $id)
            ->firstOrFail();

        $states = State::get();
        $widget = AgencyWidget::single($id);

        return view('cruds.agencies.edit-show', compact('data', 'id', 'states', 'widget'));
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
            'name' => 'required|max:80|unique:agencies,name,' . $id,
            'street' => 'required|max:255',
            'zip' => 'required|max:20',
            'city' => 'required|max:150',
            'state_id' => 'required|integer',
        ]);

        Agency::where('id', $id)->update([
            'name' => $request->input('name'),
            'street' => $request->input('street'),
            'zip' => $request->input('zip'),
            'city' => $request->input('city'),
            'state_id' => $request->input('state_id')
        ]);
        
        Session::flash('message', 'Successfully updated agency!');
        return redirect()->route('agencies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Agency::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted agency!');
        return redirect()->route('agencies.index');
    }
}

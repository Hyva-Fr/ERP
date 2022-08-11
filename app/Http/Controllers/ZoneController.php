<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\GeographicWidget;
use Session;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'zones';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [];
        $filters = [];

        $query = Zone::select(
            'zones.id',
            'zones.name',
            'zones.created_at',
        );

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = GeographicWidget::all();
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
        return view('cruds.zones.edit-show');
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
            'name' => 'required|max:150|unique:zones,name',
        ]);

        Zone::create([
            'name' => $request->input('name')
        ]);

        Session::flash('message', 'Successfully created geographic zone!');
        return redirect()->route('geographic-zone.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Zone::select(
            'zones.id',
            'zones.name',
            'zones.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();
        $widget = GeographicWidget::single($id);

        return view('cruds.zones.edit-show', compact('data', 'id', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Zone::select(
            'zones.id',
            'zones.name',
            'zones.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();
        $widget = GeographicWidget::single($id);

        return view('cruds.zones.edit-show', compact('data', 'id', 'widget'));
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
            'name' => 'required|max:150|unique:zones,name,' . $id,
        ]);

        Zone::where('id', $id)->update([
            'name' => $request->input('name')
        ]);
        
        Session::flash('message', 'Successfully updated geographic zone!');
        return redirect()->route('geographic-zone.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Zone::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted geographic zone!');
        return redirect()->route('geographic-zone.index');
    }
}

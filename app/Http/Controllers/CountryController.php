<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Zone;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\CountryWidget;
use Session;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'countries';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [
          'zone' => [
              'route' => 'geographic-zones',
              'rel' => 'zone_id'
          ]
        ];
        $filters = [];

        foreach ($thead as $filter) {
            if(!array_key_exists($filter, $extracts)) {
                $filters[] = $filter;
            }
        }

        $query = Country::select(
            'countries.id',
            'countries.name',
            'countries.land_code',
            'countries.short_code',
            'countries.zone_id',
            'zones.name as zone',
            'countries.created_at',
        )
            ->join('zones', 'countries.zone_id', '=', 'zones.id');

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = CountryWidget::all();
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
        $zones = Zone::get();
        return view('cruds.countries.edit-show', compact('zones'));
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
            'name' => 'required|max:80|unique:countries',
            'land_code' => 'required|max:5',
            'short_code' => 'required|max:5',
            'zone_id' => 'required|integer',
        ]);

        Country::create([
            'name' => $request->input('name'),
            'land_code' => $request->input('land_code'),
            'short_code' => $request->input('short_code'),
            'zone_id' => $request->input('zone_id'),
        ]);

        Session::flash('message', 'Successfully created country!');
        return redirect()->route('countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Country::select(
            'countries.id',
            'countries.name',
            'countries.land_code',
            'countries.short_code',
            'countries.zone_id',
            'zones.name as zone',
            'countries.created_at',
        )
            ->join('zones', 'countries.zone_id', '=', 'zones.id')
            ->where('countries.id', $id)
            ->firstOrFail();

        $zones = Zone::get();
        $widget = CountryWidget::single($id);

        return view('cruds.countries.edit-show', compact('data', 'id', 'zones', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Country::select(
            'countries.id',
            'countries.name',
            'countries.land_code',
            'countries.short_code',
            'countries.zone_id',
            'zones.name as zone',
            'countries.created_at',
        )
            ->join('zones', 'countries.zone_id', '=', 'zones.id')
            ->where('countries.id', $id)
            ->firstOrFail();

        $zones = Zone::get();
        $widget = CountryWidget::single($id);

        return view('cruds.countries.edit-show', compact('data', 'id', 'zones', 'widget'));
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
            'name' => 'required|max:80|unique:countries,name,' . $id,
            'land_code' => 'required|max:5',
            'short_code' => 'required|max:5',
            'zone_id' => 'required|integer',
        ]);

        Country::where('id', $id)->update([
            'name' => $request->input('name'),
            'land_code' => $request->input('land_code'),
            'short_code' => $request->input('short_code'),
            'zone_id' => $request->input('zone_id'),
        ]);
        
        Session::flash('message', 'Successfully updated country!');
        return redirect()->route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted country!');
        return redirect()->route('countries.index');
    }
}

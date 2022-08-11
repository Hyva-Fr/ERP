<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Society;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\SocietyWidget;
use Session;

class SocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'societies';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [];
        $filters = [];

        $query = Society::select(
            'societies.id',
            'societies.name',
            'societies.description',
            'societies.street',
            'societies.zip',
            'societies.city',
            'societies.country',
            'societies.created_at',
        );

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = SocietyWidget::all();
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
        return view('cruds.societies.edit-show');
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
            'name' => 'required|max:80|unique:societies,name',
            'street' => 'required|max:150',
            'zip' => 'required|max:20',
            'city' => 'required|max:80',
            'country' => 'required|max:80',
        ]);

        Society::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'street' => $request->input('street'),
            'zip' => $request->input('zip'),
            'city' => $request->input('city'),
            'country' => $request->input('country')
        ]);

        Session::flash('message', 'Successfully created society!');
        return redirect()->route('societies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Society::select(
            'societies.id',
            'societies.name',
            'societies.description',
            'societies.street',
            'societies.zip',
            'societies.city',
            'societies.country',
            'societies.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();
        $widget = SocietyWidget::single($id);

        return view('cruds.societies.edit-show', compact('data', 'id', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Society::select(
            'societies.id',
            'societies.name',
            'societies.description',
            'societies.street',
            'societies.zip',
            'societies.city',
            'societies.country',
            'societies.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();
        $widget = SocietyWidget::single($id);

        return view('cruds.societies.edit-show', compact('data', 'id', 'widget'));
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
            'name' => 'required|max:80|unique:societies,name,' . $id,
            'street' => 'required|max:150',
            'zip' => 'required|max:20',
            'city' => 'required|max:80',
            'country' => 'required|max:80',
        ]);

        Society::where('id', $id)->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'street' => $request->input('street'),
            'zip' => $request->input('zip'),
            'city' => $request->input('city'),
            'country' => $request->input('country')
        ]);
        
        Session::flash('message', 'Successfully updated society!');
        return redirect()->route('societies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Society::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted society!');
        return redirect()->route('societies.index');
    }
}

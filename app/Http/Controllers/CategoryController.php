<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\CategoryWidget;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'categories';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'parent', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [];
        $filters = [];

        $query = Category::select(
            'categories.id',
            'categories.name',
            'categories.created_at',
        )
            ->where('name', '!=', 'None');

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = CategoryWidget::all();
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
        $parents = Category::select(
            'categories.id',
            'categories.name',
        )
            ->orderBy('id')
            ->get();
        return view('cruds.categories.edit-show', compact('parents'));
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
            'name' => 'required|unique:categories|max:80',
            'parent' => 'nullable|integer',
        ]);

        Category::create([
            'name' => $request->input('name'),
            'parent' => $request->input('parent')
        ]);

        Session::flash('message', 'Successfully created category!');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Category::select(
            'categories.id',
            'categories.name',
            'categories.parent',
            'categories.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();

        $parents = Category::select(
            'categories.id',
            'categories.name',
        )
            ->orderBy('id')
            ->get();
        $widget = CategoryWidget::single($id);

        return view('cruds.categories.edit-show', compact('data', 'id', 'parents', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Category::select(
            'categories.id',
            'categories.name',
            'categories.parent',
            'categories.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();

        $parents = Category::select(
            'categories.id',
            'categories.name',
        )
            ->orderBy('id')
            ->get();
        $widget = CategoryWidget::single($id);

        return view('cruds.categories.edit-show', compact('data', 'id', 'parents', 'widget'));
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
            'name' => 'required|max:80|unique:categories,name,' . $id,
            'parent' => 'nullable|integer',
        ]);

        Category::where('id', $id)->update([
            'name' => $request->input('name'),
            'parent' => $request->input('parent')
        ]);

        Session::flash('message', 'Successfully updated category!');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted category!');
        return redirect()->route('categories.index');
    }
}

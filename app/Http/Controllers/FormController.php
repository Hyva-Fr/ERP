<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use App\Widgets\FormWidget;
use Session;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'forms';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'form', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [
            'category' => [
                'route' => 'categories',
                'rel' => 'category_id'
            ],
            'user' => [
                'route' => 'users',
                'rel' => 'user_id'
            ]
        ];
        $filters = [];

        foreach ($thead as $filter) {
            if(!array_key_exists($filter, $extracts)) {
                $filters[] = $filter;
            }
        }

        $query = Form::select(
            'forms.id',
            'forms.name',
            'forms.form',
            'forms.category_id',
            'categories.name as category',
            'forms.user_id',
            'users.name as user',
            'forms.created_at',
        )
            ->join('categories', 'forms.category_id', '=', 'categories.id')
            ->join('users', 'forms.user_id', '=', 'users.id');

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $widget = FormWidget::all();
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
        $categories = Category::get();
        $users = User::get();
        return view('cruds.forms.edit-show', compact('categories', 'users'));
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
            'name' => 'required|max:80',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'form' => 'required'
        ]);

        Form::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'user_id' => $request->input('user_id'),
            'form' => $request->input('form'),
        ]);

        Session::flash('message', 'Successfully created form!');
        return redirect()->route('forms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Form::select(
            'forms.id',
            'forms.name',
            'forms.form',
            'forms.category_id',
            'categories.name as category',
            'forms.user_id',
            'users.name as user',
            'forms.created_at',
        )
            ->join('categories', 'forms.category_id', '=', 'categories.id')
            ->join('users', 'forms.user_id', '=', 'users.id')
            ->where('forms.id', $id)
            ->firstOrFail();

        $categories = Category::get();
        $users = User::get();
        $widget = FormWidget::single($id);

        return view('cruds.forms.edit-show', compact('data', 'id', 'categories', 'users', 'widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Form::select(
            'forms.id',
            'forms.name',
            'forms.form',
            'forms.category_id',
            'categories.name as category',
            'forms.user_id',
            'users.name as user',
            'forms.created_at',
        )
            ->join('categories', 'forms.category_id', '=', 'categories.id')
            ->join('users', 'forms.user_id', '=', 'users.id')
            ->where('forms.id', $id)
            ->firstOrFail();

        $categories = Category::get();
        $users = User::get();
        $widget = FormWidget::single($id);

        return view('cruds.forms.edit-show', compact('data', 'id', 'categories', 'users', 'widget'));
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
            'name' => 'required|max:80',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'form' => 'required'
        ]);

        Form::where(['id' => $id])->update([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'user_id' => $request->input('user_id'),
            'form' => $request->input('form'),
        ]);

        Session::flash('message', 'Successfully updated form!');
        return redirect()->route('forms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Session::flash('message', 'Successfully deleted form!');
        Form::where(['id' => $id])->delete();
        return redirect()->route('forms.index');
    }
}

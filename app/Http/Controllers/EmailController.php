<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use Session;
use Storage;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'emails';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [];
        $filters = [];

        $query = Email::select(
            'emails.id',
            'emails.name',
            'emails.subject',
            'emails.template',
            'emails.created_at',
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
        $shortCodes = [];
        $templates = $this->getTemplates();
        return view('cruds.emails.edit-show', compact('shortCodes', 'templates'));
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
            'name' => 'required|unique:emails,name|max:100',
            'subject' => 'required|max:150',
            'content' => 'required',
            'template' => 'required|unique:emails,template|max:80',
        ]);

        Email::create([
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'template' => $request->input('template')
        ]);

        Session::flash('message', 'Successfully created email!');
        return redirect()->route('emails.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Email::select(
            'emails.id',
            'emails.name',
            'emails.subject',
            'emails.content',
            'emails.template',
            'emails.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();

        $shortCodes = [];
        $templates = $this->getTemplates();

        return view('cruds.emails.edit-show', compact('data', 'id', 'shortCodes', 'templates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Email::select(
            'emails.id',
            'emails.name',
            'emails.subject',
            'emails.content',
            'emails.template',
            'emails.created_at',
        )
            ->where('id', $id)
            ->firstOrFail();

        $shortCodes = [];
        $templates = $this->getTemplates();

        return view('cruds.emails.edit-show', compact('data', 'id', 'shortCodes', 'templates'));
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
            'name' => 'required|max:100|unique:emails,name,' . $id,
            'subject' => 'required|max:150',
            'content' => 'required',
            'template' => 'required|max:80|unique:emails,template,' . $id,
        ]);

        Email::where('id', $id)->update([
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'template' => $request->input('template')
        ]);
        
        Session::flash('message', 'Successfully updated email!');
        return redirect()->route('emails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Email::where('id', $id)->delete();
        Session::flash('message', 'Successfully deleted email!');
        return redirect()->route('emails.index');
    }

    private function getTemplates(): array
    {
        $path = Storage::disk('emails')->files();
        $templates = [];
        foreach ($path as $template) {
            $templates[] = ucfirst(str_replace('.blade.php', '', $template));
        }
        return $templates;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Category;
use Storage;
use App;
use Barryvdh\Debugbar\Facade as Debugbar;

class PDFController extends Controller
{
    public function __construct()
    {
        if (App::environment('local')) {
            Debugbar::disable();
        }
    }

    public function index($id)
    {
        $form = Form::where('id', $id)->firstOrFail();
        $category = Category::select('name')->where('id', $form->category_id)->firstOrFail();
        $style = Storage::disk('pdf')->get('index.css');
        return view('pdf.index', compact('form', 'style', 'category'));
    }

    public function download($id)
    {
        $form = Form::where('id', $id)->firstOrFail();
        $category = Category::select('name')->where('id', $form->category_id)->firstOrFail();
        $style = Storage::disk('pdf')->get('index.css');
        $print = Storage::disk('pdf')->get('print.css');
        $script = Storage::disk('pdf-js')->get('index.js');
        return view('pdf.index', compact('form', 'style', 'category', 'script', 'print'));
    }
}

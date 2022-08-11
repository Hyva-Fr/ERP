<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function index($slug, Request $request)
    {
        $modalPath = base_path() . '/resources/views/modals/' . $slug . '.blade.php';
        if ($request->ajax() && file_exists($modalPath)) {
            $data = $request->input('data');
            return view('modals.' . $slug, compact('data', 'slug'));
        }
        return abort(404);
    }
}

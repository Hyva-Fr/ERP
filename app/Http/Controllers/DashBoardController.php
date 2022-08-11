<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dimmers\Dimmer;
use Auth;

class DashBoardController extends Controller
{
    public function index()
    {
        $dimmerClass = new Dimmer();
        $dimmers = $dimmerClass->activate();

        return view('dashboard', compact('dimmers'));
    }
}

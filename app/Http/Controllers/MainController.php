<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubTheme;

class MainController extends Controller
{
    public function index()
    {
        return view('main.index');
    }

    public function about()
    {
        return view('main.about');
    }

    public function conferenceTheme()
    {
        return view('main.conference-theme');
    }

    public function conferenceProcedure()
    {
        return view('main.conference-procedure');
    }

    public function submitAbstract()
    {
        $subThemes = SubTheme::orderBy('full_name')->get();

        return view('main.submit-abstract', compact('subThemes'));
    }

}


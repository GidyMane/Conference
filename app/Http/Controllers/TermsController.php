<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Display the terms and conditions page.
     */
    public function index(Request $request)
    {
        // Get 'from' query parameter, fallback to previous page
        $backUrl = $request->query('from', url()->previous());

        return view('main.terms', compact('backUrl'));
    }
}

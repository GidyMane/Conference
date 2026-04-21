<?php

namespace App\Http\Controllers;

use App\Models\PrequalifiedReviewer;
use Illuminate\Http\Request;

class PrequalifiedReviewerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:100',
            'email' => 'required|email|unique:prequalified_reviewers,email',
            'phone' => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
            'sub_theme_id' => 'required|exists:sub_themes,id',
            'area_of_specialization' => 'nullable|string',
        ]);

        PrequalifiedReviewer::create($validated);

        return redirect()->back()->with('success', 'Prequalified reviewer added successfully.');
    }
}
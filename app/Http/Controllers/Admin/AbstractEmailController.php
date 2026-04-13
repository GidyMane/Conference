<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use Illuminate\Support\Facades\Mail;
use App\Mail\BulkAbstractMail;

class AbstractEmailController extends Controller
{
    public function index()
    {
        return view('admin.abstracts.email');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'status'  => 'nullable|string',
            'sub_theme_id' => 'nullable|exists:sub_themes,id',
        ]);

        $query = SubmittedAbstract::query();

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by sub-theme
        if ($request->sub_theme_id) {
            $query->where('sub_theme_id', $request->sub_theme_id);
        }

        $abstracts = $query->get();

        foreach ($abstracts as $abstract) {
            try {
                Mail::to($abstract->author_email)
                ->send(new BulkAbstractMail(
                    $request->subject,
                    $request->message,
                    $abstract
                ));
            } catch (\Throwable $e) {
                \Log::error('Bulk email failed', [
                    'email' => $abstract->author_email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return back()->with('success', 'Emails sent successfully!');
    }
}
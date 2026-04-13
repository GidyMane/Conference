@extends('admin.layout')

@section('title', 'Send Bulk Email')

@section('content')
<div class="container">
    <h2>Send Email to Abstract Submitters</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.abstracts.email.send') }}">
        @csrf

        <div class="mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" rows="6" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Filter by Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="PENDING">Pending</option>
                <option value="UNDER_REVIEW">Under Review</option>
                <option value="APPROVED">Approved</option>
                <option value="REJECTED">Rejected</option>
                <option value="RESUBMIT">Resubmit</option>
            </select>
        </div>

        <!--<div class="mb-3">
            <label>Filter by Sub Theme</label>
            <select name="sub_theme_id" class="form-control">
                <option value="">All</option>
                @foreach(\App\Models\SubTheme::all() as $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>-->

        <button class="btn btn-primary">Send Emails</button>
    </form>
</div>
@endsection
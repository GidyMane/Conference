@component('mail::message')
# New Abstract Submission

Dear Secretariat Team,

A new abstract has been successfully submitted to the **KALRO Conference 2026 system**.

**Submission Details:**

@component('mail::table')
| Field | Details |
|-------|---------|
| Submission Code | {{ $abstract->submission_code }} |
| Author | {{ $abstract->author_name }} |
| Email | {{ $abstract->author_email }} |
| Organisation | {{ $abstract->organisation }} |
| Department | {{ $abstract->department ?? 'N/A' }} |
| Position | {{ $abstract->position ?? 'N/A' }} |
| Paper Title | {{ $abstract->paper_title }} |
| Sub-Theme | {{ $abstract->subTheme->full_name ?? 'N/A' }} |
| Presentation Preference | {{ $abstract->presentation_preference ?? 'N/A' }} |
| Attendance Mode | {{ $abstract->attendance_mode ?? 'N/A' }} |
@endcomponent

A confirmation email has been sent to the author.

Thanks,<br>
**KALRO Conference System**
@endcomponent
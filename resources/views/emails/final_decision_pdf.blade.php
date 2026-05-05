<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Review Summary PDF</title>

<style>

body{
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size:12px;
    color:#333;
    background:#f8fafc;
}

h2,h3{
    text-align:center;
    color:#158532;
    margin-bottom:4px;
}

p{ margin:4px 0; }

.section-title{
    background:#158532;
    color:white;
    padding:8px;
    margin-top:20px;
    border-radius:4px;
    font-weight:bold;
}

.info-box{
    background:white;
    border:1px solid #e2e8f0;
    padding:10px;
    border-radius:4px;
    margin-bottom:10px;
}

.reviewer-card{
    border:1px solid #e2e8f0;
    border-radius:6px;
    margin-top:20px;
    background:white;
    padding:12px;
}



.total-score{
    font-size:16px;
    font-weight:bold;
    color:#16a34a;
}

.score-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.score-table th{
    background:#16a34a;
    color:white;
    padding:6px;
    text-align:left;
}

.score-table td{
    border:1px solid #e2e8f0;
    padding:6px;
}

.criteria-table{
    width:100%;
    border-collapse:collapse;
    margin-top:5px;
    font-size:11px;
}

.criteria-table td{
    border:1px solid #e2e8f0;
    padding:5px;
}

.comment-box{
    background:#f1f5f9;
    border-left:4px solid #16a34a;
    padding:8px;
    margin-top:8px;
    border-radius:3px;
}

.leader-comments{
    background:#e6f4ea;
    border-left:4px solid #16a34a;
    padding:10px;
    margin-top:8px;
}

.footer{
    text-align:center;
    font-size:10px;
    color:#666;
    margin-top:30px;
}

</style>
</head>

<body>

<h2>2nd KALRO Scientific Conference & Exhibition</h2>
<h3>Full Paper Review Summary</h3>

<div class="info-box">
<p><strong>Paper Title:</strong> {{ $paper->abstract->title }}</p>
<p><strong>Paper ID:</strong> {{ $paper->abstract->submission_code }}</p>
<p><strong>Sub-Theme:</strong> {{ $paper->abstract->subtheme->full_name ?? 'N/A' }}</p>

<p><strong>Decision:</strong>
<span style="color:#16a34a;font-weight:bold;">
{{ strtoupper(str_replace('_',' ',$paper->final_decision)) }}
</span>
</p>

@if($paper->presentation_type)
<p><strong>Presentation Format:</strong>
<span style="font-weight:bold;color:#16a34a;">
{{ ucwords(str_replace('_',' ',$paper->presentation_type)) }}
</span>
</p>
@endif

<p>
<strong>Average Reviewer Score:</strong>
<span class="total-score">
{{ $paper->average_score ?? 'N/A' }}/100
</span>
</p>
</div>


<div class="section-title">Sub-Theme Leader Comments</div>

<div class="leader-comments">
{{ $paper->leader_comments ?? 'No comments provided.' }}
</div>


@foreach($reviews as $index => $review)
<div class="reviewer-card">

<div class="section-title">
    Reviewer {{ $index + 1 }}
</div>

<p class="total-score">
Total Score: {{ $review->total_score ?? '-' }}/100
</p>


<table class="score-table">
<thead>
<tr>
<th>Section</th>
<th>Score</th>
<th>Max</th>
</tr>
</thead>

<tbody>

<tr>
<td>Title</td>
<td>{{ $review->score_title }}</td>
<td>5</td>
</tr>

<tr>
<td>Abstract</td>
<td>{{ $review->score_abstract }}</td>
<td>5</td>
</tr>

<tr>
<td>Introduction</td>
<td>{{ $review->score_introduction }}</td>
<td>10</td>
</tr>

<tr>
<td>Methods</td>
<td>{{ $review->score_methods }}</td>
<td>25</td>
</tr>

<tr>
<td>Results</td>
<td>{{ $review->score_results }}</td>
<td>25</td>
</tr>

<tr>
<td>Discussion</td>
<td>{{ $review->score_discussion }}</td>
<td>15</td>
</tr>

<tr>
<td>Conclusion</td>
<td>{{ $review->score_conclusion }}</td>
<td>10</td>
</tr>

<tr>
<td>References</td>
<td>{{ $review->score_references }}</td>
<td>5</td>
</tr>

</tbody>
</table>


<div class="section-title">Detailed Section Review</div>


<b>Title</b>

<table class="criteria-table">
<tr><td>Appropriate</td><td>{{ $review->title_appropriate }}/2</td></tr>
<tr><td>Reflects Content</td><td>{{ $review->title_reflects_content }}/3</td></tr>
</table>

<div class="comment-box">
{{ $review->title_comments }}
</div>


<b>Abstract</b>

<table class="criteria-table">
<tr><td>Word Count</td><td>{{ $review->abstract_word_count }}/2</td></tr>
<tr><td>Completeness</td><td>{{ $review->abstract_completeness }}/3</td></tr>
</table>

<div class="comment-box">
{{ $review->abstract_comments }}
</div>


<b>Introduction</b>

<table class="criteria-table">
<tr><td>Background</td><td>{{ $review->intro_background }}/3</td></tr>
<tr><td>Originality</td><td>{{ $review->intro_originality }}/5</td></tr>
<tr><td>Objectives</td><td>{{ $review->intro_objectives }}/2</td></tr>
</table>

<div class="comment-box">
{{ $review->introduction_comments }}
</div>


<b>Methods</b>

<table class="criteria-table">
<tr><td>Replication</td><td>{{ $review->methods_replication }}/10</td></tr>
<tr><td>Design</td><td>{{ $review->methods_design }}/5</td></tr>
<tr><td>Statistics</td><td>{{ $review->methods_statistics }}/5</td></tr>
<tr><td>Ethics</td><td>{{ $review->methods_ethics }}/5</td></tr>
</table>

<div class="comment-box">
{{ $review->methods_comments }}
</div>


<b>Results</b>

<table class="criteria-table">
<tr><td>Insights</td><td>{{ $review->results_insights }}/5</td></tr>
<tr><td>Narrative</td><td>{{ $review->results_narrative }}/5</td></tr>
<tr><td>Data Clarity</td><td>{{ $review->results_data_clarity }}/8</td></tr>
<tr><td>Visuals</td><td>{{ $review->results_visuals }}/5</td></tr>
<tr><td>Referencing</td><td>{{ $review->results_referencing }}/2</td></tr>
</table>

<div class="comment-box">
{{ $review->results_comments }}
</div>


<b>Discussion</b>

<table class="criteria-table">
<tr><td>Context</td><td>{{ $review->discussion_context }}/2</td></tr>
<tr><td>Objectives</td><td>{{ $review->discussion_objectives }}/2</td></tr>
<tr><td>Significance</td><td>{{ $review->discussion_significance }}/5</td></tr>
<tr><td>Theme Alignment</td><td>{{ $review->discussion_theme }}/2</td></tr>
<tr><td>References</td><td>{{ $review->discussion_references }}/4</td></tr>
</table>

<div class="comment-box">
{{ $review->discussion_comments }}
</div>


<b>Conclusion</b>

<table class="criteria-table">
<tr><td>Objectives</td><td>{{ $review->conclusion_objectives }}/2</td></tr>
<tr><td>Consistency</td><td>{{ $review->conclusion_consistency }}/5</td></tr>
<tr><td>Contribution</td><td>{{ $review->conclusion_contribution }}/3</td></tr>
</table>

<div class="comment-box">
{{ $review->conclusion_comments }}
</div>


<b>References</b>

<table class="criteria-table">
<tr><td>Acknowledgement</td><td>{{ $review->acknowledgement_present }}/1</td></tr>
<tr><td>Accuracy</td><td>{{ $review->references_accuracy }}/1</td></tr>
<tr><td>Balance</td><td>{{ $review->references_balance }}/1</td></tr>
<tr><td>Citation</td><td>{{ $review->references_citation }}/1</td></tr>
<tr><td>Matching</td><td>{{ $review->references_matching }}/1</td></tr>
</table>

<div class="comment-box">
{{ $review->references_comments }}
</div>


<div class="section-title">Overall Comments</div>

<div class="comment-box">
{{ $review->overall_comments }}
</div>

</div>

@endforeach


<div class="footer">
<p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
<p>© {{ date('Y') }} 2nd KALRO Scientific Conference & Exhibition</p>
</div>

</body>
</html>
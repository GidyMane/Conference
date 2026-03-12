<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Review Summary PDF</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 12px; 
            color: #333; 
            background-color: #f8fafc; 
            margin: 0; 
            padding: 20px;
        }

        h2, h3 { 
            text-align: center; 
            color: #158532; 
            margin-bottom: 5px; 
        }

        p { margin: 5px 0; }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            background-color: #ffffff;
            border-radius: 5px;
            overflow: hidden;
        }

        th, td { 
            border: 1px solid #cbd5e1; 
            padding: 10px; 
            vertical-align: top; 
        }

        th { 
            background-color: #16a34a; 
            color: #ffffff; 
            text-align: left; 
        }

        tr:nth-child(even) { background-color: #f1f5f9; }

        .mini-scores { 
            margin-top: 5px; 
            font-size: 11px; 
            color: #555; 
            width: 100%;
        }

        .mini-scores td { 
            border: none; 
            padding: 2px 5px; 
        }

        .reviewer-name { 
            font-weight: bold; 
            color: #158532;
        }

        .total-score { 
            font-weight: bold; 
            color: #16a34a;
        }

        .recommendation-approved { color: #16a34a; font-weight: bold; }
        .recommendation-rejected { color: #dc2626; font-weight: bold; }
        .recommendation-accept_with_minor_revisions { color: #f59e0b; font-weight: bold; }
        .recommendation-accept_with_major_revisions { color: #f97316; font-weight: bold; }
        .recommendation-not_approved { color: #dc2626; font-weight: bold; }

        .section-header {
            background-color: #158532;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 4px;
            margin-top: 20px;
            font-size: 14px;
        }

        .leader-comments {
            background-color: #e6f4ea;
            border-left: 4px solid #16a34a;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <h2>2nd KALRO Scientific Conference & Exhibition</h2>
    <h3>Full Paper Review Summary</h3>

    <p><strong>Paper Title:</strong> {{ $paper->abstract->title }}</p>
    <p><strong>Paper ID:</strong> {{ $paper->abstract->submission_code }}</p>
    <p><strong>Sub-Theme:</strong> {{ $paper->abstract->subtheme->full_name ?? 'N/A' }}</p>
    
    <p><strong>Sub-Theme Leader Decision:</strong> 
        <span class="recommendation-{{ $paper->final_decision }}">
            {{ strtoupper(str_replace('_', ' ', $paper->final_decision)) }}
        </span>
    </p>

    @if($paper->presentation_type)
    <p><strong>Recommended Presentation Format:</strong> 
        <span style="font-weight:bold; color:#16a34a;">
            {{ ucwords(str_replace('_', ' ', $paper->presentation_type)) }}
        </span>
    </p>
    @endif
    
    <p>
        <strong>Average Reviewer Score:</strong> 
        <span style="font-weight:bold; color:#16a34a;">
            {{ $paper->average_score ?? 'N/A' }}/100
        </span>
    </p>

    <div class="section-header">Sub-Theme Leader Comments</div>
    <div class="leader-comments">
        {{ $paper->leader_comments ?? 'No comments provided.' }}
    </div>

    <div class="section-header">Reviewer Scores & Detailed Comments</div>
    <table>
        <thead>
            <tr>
                <th width="20%">Reviewer</th>
                <th width="20%">Total Score</th>
                <th width="60%">Overall Comments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td class="reviewer-name">
                    {{ $review->assignment->prequalifiedReviewer->name ?? $review->assignment->peerReviewer->full_name ?? 'Reviewer ' . $loop->iteration }}
                </td>
                <td class="total-score">
                    {{ $review->total_score ?? '-' }}/100

                    <table class="mini-scores">
                        <tr><td>Title:</td><td>{{ $review->score_title ?? '-' }}/5</td></tr>
                        <tr><td>Abstract:</td><td>{{ $review->score_abstract ?? '-' }}/5</td></tr>
                        <tr><td>Introduction:</td><td>{{ $review->score_introduction ?? '-' }}/10</td></tr>
                        <tr><td>Methods:</td><td>{{ $review->score_methods ?? '-' }}/25</td></tr>
                        <tr><td>Results:</td><td>{{ $review->score_results ?? '-' }}/25</td></tr>
                        <tr><td>Discussion:</td><td>{{ $review->score_discussion ?? '-' }}/15</td></tr>
                        <tr><td>Conclusion:</td><td>{{ $review->score_conclusion ?? '-' }}/10</td></tr>
                        <tr><td>References:</td><td>{{ $review->score_references ?? '-' }}/5</td></tr>
                    </table>
                </td>

                <td>
                    {{ $review->overall_comments ?? 'No comments provided.' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>© {{ date('Y') }} 2nd KALRO Scientific Conference & Exhibition</p>
    </div>

</body>
</html>
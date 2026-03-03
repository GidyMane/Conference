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

    <p><strong>Paper:</strong> {{ $paper->abstract->title }}</p>
    <p><strong>Author:</strong> {{ $paper->abstract->author_name }} ({{ $paper->abstract->author_email }})</p>
    <p><strong>Final Decision:</strong> 
        <span class="{{ $paper->final_decision === 'approved' ? 'recommendation-approved' : 'recommendation-rejected' }}">
            {{ strtoupper($paper->final_decision) }}
        </span>
    </p>

    <div class="section-header">Leader Comments</div>
    <div class="leader-comments">
        {{ $paper->leader_comments }}
    </div>

    <div class="section-header">Reviewer Scores & Comments</div>
    <table>
        <thead>
            <tr>
                <th>Reviewer</th>
                <th>Total Score</th>
                <th>Recommendation</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td class="reviewer-name">
                    {{ $review->assignment->prequalifiedReviewer->name ?? $review->assignment->peerReviewer->full_name }}
                </td>
                <td class="total-score">
                    {{ $review->total_score ?? '-' }}/100
                    @if(isset($review->mini_scores) && count($review->mini_scores) > 0)
                        <table class="mini-scores">
                            @foreach($review->mini_scores as $criterion => $score)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $criterion)) }}:</td>
                                <td>{{ $score }}</td>
                            </tr>
                            @endforeach
                        </table>
                    @endif
                </td>
                <td class="{{ $review->recommendation === 'approved' ? 'recommendation-approved' : 'recommendation-rejected' }}">
                    {{ ucwords(str_replace('_',' ',$review->recommendation)) }}
                </td>
                <td>{{ $review->overall_comments }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
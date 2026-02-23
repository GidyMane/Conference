<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Submitted - KALRO Conference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-card {
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(22,163,74,.2);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .success-body {
            padding: 40px;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-header">
        <div class="success-icon">
            <i class="fas fa-check fa-3x"></i>
        </div>
        <h2>Review Submitted Successfully!</h2>
        <p class="mb-0">Thank you for your contribution</p>
    </div>
    <div class="success-body text-center">
        <h5 class="mb-3">Paper: {{ $paper->abstract->paper_title }}</h5>
        
        <div class="alert alert-success mb-4">
            <h3 class="mb-0">Your Score: {{ $totalScore }}/100</h3>
        </div>

        <p class="text-muted">
            Your review has been recorded and will be forwarded to the Sub-Theme Leader along with the other reviewers' assessments.
        </p>

        <hr class="my-4">

        <h6>What Happens Next?</h6>
        <ul class="text-start">
            <li>The Sub-Theme Leader will review all 3 assessments</li>
            <li>A final decision will be made on paper acceptance</li>
            <li>The author will be notified of the outcome</li>
        </ul>

        <div class="mt-4">
            <p class="text-muted small mb-0">
                <i class="fas fa-shield-alt me-1"></i>
                Your review is confidential and will only be shared with the conference organizers.
            </p>
        </div>
    </div>
</div>

</body>
</html>
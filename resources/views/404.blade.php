<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KALRO | Maintenance</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 550px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.35);
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.95;
        }

        .loader {
            margin: 25px auto;
            border: 5px solid rgba(255,255,255,0.2);
            border-top: 5px solid #F9A825;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9rem;
            opacity: 0.75;
        }

        .highlight {
            color: #F9A825;
            font-weight: 500;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 25px;
            }

            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">

        <h1>🚧 Site Under Maintenance</h1>

        <div class="loader"></div>

        <p>
            The <span class="highlight">KALRO</span> website is currently undergoing maintenance.<br>
            We are working to resolve an issue and improve your experience.
        </p>

        <p>
            Please check back shortly.
        </p>

        <div class="footer">
            &copy; 2026 KALRO — Kenya Agricultural & Livestock Research Organization
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ग्रामपंचायत आढळली नाही</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 48px 40px;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #fff3cd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 2.5rem;
        }
        h2 {
            color: #c0392b;
            font-size: 1.6rem;
            margin-bottom: 12px;
        }
        p {
            color: #555;
            font-size: 1rem;
            line-height: 1.7;
        }
        .gp-name-badge {
            display: inline-block;
            background: #f8d7da;
            color: #842029;
            border-radius: 6px;
            padding: 2px 12px;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 16px;
        }
        .contact-link {
            color: #2d6a4f;
            font-weight: 600;
            text-decoration: none;
        }
        .contact-link:hover {
            text-decoration: underline;
        }
        .divider {
            border-top: 1px solid #e9ecef;
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="card-box">
        <div class="icon-circle">⚠️</div>
        <h2>माहिती आढळली नाही</h2>
        <div class="gp-name-badge">{{ $gpname }}</div>
        <p>
            <strong>"{{ $gpname }}"</strong> या नावाची ग्रामपंचायत आमच्या प्रणालीमध्ये नोंदणीकृत नाही
            किंवा सध्या उपलब्ध नाही.
        </p>
        <div class="divider"></div>
        <p>
            अधिक माहितीसाठी कृपया आमच्याशी संपर्क साधा:<br>
            <a href="mailto:admin@gmail.com" class="contact-link">admin@gmail.com</a>
        </p>
        <p class="mt-2" style="font-size:0.9rem; color:#888;">
            URL तपासा किंवा योग्य ग्रामपंचायत नाव वापरा.
        </p>
    </div>
</body>
</html>

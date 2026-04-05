<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ग्रामपंचायत निष्क्रिय</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e8eaf6 0%, #ede7f6 50%, #e3f2fd 100%);
            padding: 20px;
        }

        .wrapper {
            width: 100%;
            max-width: 560px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.12);
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-top-bar {
            height: 6px;
            background: linear-gradient(90deg, #546e7a, #90a4ae);
        }

        .card-body {
            padding: 48px 40px 40px;
            text-align: center;
        }

        /* Icon */
        .icon-wrap {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #eceff1, #cfd8dc);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 4px 16px rgba(84,110,122,0.18);
        }

        .icon-wrap svg {
            width: 44px;
            height: 44px;
        }

        /* Status pill */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eceff1;
            color: #546e7a;
            border: 1.5px solid #cfd8dc;
            border-radius: 30px;
            padding: 5px 16px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .status-pill span.dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #90a4ae;
            display: inline-block;
        }

        h1 {
            font-size: 1.55rem;
            font-weight: 700;
            color: #37474f;
            margin-bottom: 10px;
        }

        /* GP badge */
        .gp-badge {
            display: inline-block;
            background: #eceff1;
            color: #546e7a;
            border: 1.5px solid #cfd8dc;
            border-radius: 30px;
            padding: 4px 18px;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .description {
            font-size: 1rem;
            color: #555;
            line-height: 1.8;
        }

        /* Info box */
        .info-box {
            background: #fafafa;
            border: 1.5px solid #eceff1;
            border-radius: 12px;
            padding: 16px 20px;
            margin: 24px 0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            text-align: left;
        }

        .info-box svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-box p {
            font-size: 0.88rem;
            color: #666;
            line-height: 1.7;
            margin: 0;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px dashed #e0e0e0;
            margin: 24px 0;
        }

        /* Contact box */
        .contact-box {
            background: #f8fffe;
            border: 1.5px solid #d4edda;
            border-radius: 12px;
            padding: 18px 24px;
            margin-bottom: 20px;
        }

        .contact-box p {
            font-size: 0.92rem;
            color: #555;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .contact-box a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #2d6a4f;
            color: #fff;
            text-decoration: none;
            padding: 8px 22px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .contact-box a:hover {
            background: #1b4332;
        }

        /* Footer strip */
        .card-footer-strip {
            background: #fafafa;
            border-top: 1px solid #f0f0f0;
            padding: 12px 40px;
            text-align: center;
        }

        .card-footer-strip p {
            font-size: 0.78rem;
            color: #bbb;
            margin: 0;
        }

        @media (max-width: 480px) {
            .card-body { padding: 36px 24px 28px; }
            h1 { font-size: 1.3rem; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="card-top-bar"></div>
            <div class="card-body">

                <div class="icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#546e7a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>

                <div class="status-pill">
                    <span class="dot"></span> Inactive
                </div>

                <h1>ग्रामपंचायत सध्या उपलब्ध नाही</h1>
                <div class="gp-badge">{{ $gpname }}</div>

                <p class="description">
                    <strong>"{{ $gpname }}"</strong> ही ग्रामपंचायत सध्या निष्क्रिय आहे.
                    हे पोर्टल तात्पुरते बंद केले आहे.
                </p>

                <div class="info-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#90a4ae" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p>
                        हे पोर्टल लवकरच पुन्हा सुरू होईल. कृपया नंतर पुन्हा प्रयत्न करा
                        किंवा खाली दिलेल्या संपर्क माहितीवर आमच्याशी संपर्क साधा.
                    </p>
                </div>

                <hr class="divider">

                <div class="contact-box">
                    <p>अधिक माहितीसाठी कृपया आमच्याशी संपर्क साधा</p>
                    <a href="mailto:admin@gmail.com">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        admin@gmail.com
                    </a>
                </div>

            </div>
            <div class="card-footer-strip">
                <p>Gram Panchayat Digital Portal</p>
            </div>
        </div>
    </div>
</body>
</html>

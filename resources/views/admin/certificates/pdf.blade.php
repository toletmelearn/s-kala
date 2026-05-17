<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $certificate->certificate_no }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #292524; margin: 0; }
        .frame { margin: 24px; border: 2px solid #881337; padding: 28px; }
        .muted { color: #57534e; font-size: 12px; }
        .title { font-size: 42px; font-weight: 700; margin: 12px 0 4px; text-align: center; }
        .subtitle { font-size: 22px; margin: 0; text-align: center; }
        .main { text-align: center; margin-top: 24px; }
        .name { font-size: 34px; font-weight: 700; margin: 16px 0; }
        .program { font-size: 24px; font-weight: 600; margin: 12px 0; }
        .meta { margin-top: 28px; font-size: 13px; line-height: 1.8; }
        .row { width: 100%; margin-top: 42px; }
        .col { width: 45%; display: inline-block; text-align: center; vertical-align: top; }
        .line { border-top: 1px solid #78716c; margin: 40px auto 8px; width: 70%; }
        .footer { margin-top: 28px; text-align: center; font-size: 13px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="frame">
        <p class="muted" style="text-align:center;">S-kala - Shakuntala Shishu Lok</p>
        <h1 class="title">Certificate of Completion</h1>
        <p class="subtitle">Skill, Strength &amp; Self-Reliance</p>

        <div class="main">
            <p>This certificate is proudly awarded to</p>
            <div class="name">{{ $certificate->trainee?->name }}</div>
            <p>for successfully completing the training program</p>
            <div class="program">{{ $certificate->trainingProgram?->name ?: 'S-kala Training Program' }}</div>
        </div>

        <div class="meta">
            <p><strong>Certificate Number:</strong> {{ $certificate->certificate_no }}</p>
            <p><strong>Issue Date:</strong> {{ $certificate->issue_date?->format('d M Y') }}</p>
            <p><strong>Completion Date:</strong> {{ $certificate->completion_date?->format('d M Y') ?: '-' }}</p>
            <p><strong>Verification Code:</strong> {{ $certificate->verification_code }}</p>
            <p><strong>Verification URL:</strong> {{ $verificationUrl }}</p>
        </div>

        <div class="row">
            <div class="col">
                <div class="line"></div>
                <p>Incharge</p>
            </div>
            <div class="col" style="float:right;">
                <div class="line"></div>
                <p>Director</p>
            </div>
        </div>

        <p class="footer">Skill, Strength &amp; Self-Reliance</p>
    </div>
</body>
</html>

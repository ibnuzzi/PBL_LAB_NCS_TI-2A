<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Lab NCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Grid */
        .grid-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Floating Particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(59, 130, 246, 0.5);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        .particle:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 12s;
        }

        .particle:nth-child(2) {
            left: 20%;
            animation-delay: 2s;
            animation-duration: 14s;
        }

        .particle:nth-child(3) {
            left: 30%;
            animation-delay: 4s;
            animation-duration: 10s;
        }

        .particle:nth-child(4) {
            left: 40%;
            animation-delay: 1s;
            animation-duration: 16s;
        }

        .particle:nth-child(5) {
            left: 50%;
            animation-delay: 3s;
            animation-duration: 11s;
        }

        .particle:nth-child(6) {
            left: 60%;
            animation-delay: 5s;
            animation-duration: 13s;
        }

        .particle:nth-child(7) {
            left: 70%;
            animation-delay: 2s;
            animation-duration: 15s;
        }

        .particle:nth-child(8) {
            left: 80%;
            animation-delay: 4s;
            animation-duration: 12s;
        }

        .particle:nth-child(9) {
            left: 90%;
            animation-delay: 1s;
            animation-duration: 14s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* Glowing Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: pulse 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #3B82F6 0%, transparent 70%);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #8B5CF6 0%, transparent 70%);
            bottom: -50px;
            right: -50px;
            animation-delay: 2s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, #06B6D4 0%, transparent 70%);
            top: 50%;
            right: 20%;
            animation-delay: 4s;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.1);
            }
        }

        /* Main Content */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 40px;
            max-width: 600px;
        }

        /* Glitch Effect for 404 */
        .error-code {
            font-size: 180px;
            font-weight: 800;
            color: transparent;
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 50%, #06B6D4 100%);
            -webkit-background-clip: text;
            background-clip: text;
            line-height: 1;
            margin-bottom: 20px;
            position: relative;
            animation: glitch 3s infinite;
        }

        .error-code::before,
        .error-code::after {
            content: '404';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }

        .error-code::before {
            color: #FF6B6B;
            animation: glitch-1 0.5s infinite;
            clip-path: polygon(0 0, 100% 0, 100% 35%, 0 35%);
        }

        .error-code::after {
            color: #4ECDC4;
            animation: glitch-2 0.5s infinite;
            clip-path: polygon(0 65%, 100% 65%, 100% 100%, 0 100%);
        }

        @keyframes glitch {

            0%,
            90%,
            100% {
                transform: none;
            }

            91% {
                transform: skew(0.5deg, 0.1deg);
            }

            92% {
                transform: none;
            }

            93% {
                transform: skew(-0.2deg, -0.2deg);
            }
        }

        @keyframes glitch-1 {

            0%,
            100% {
                transform: translateX(-50%);
            }

            20% {
                transform: translateX(-48%);
            }

            40% {
                transform: translateX(-52%);
            }
        }

        @keyframes glitch-2 {

            0%,
            100% {
                transform: translateX(-50%);
            }

            20% {
                transform: translateX(-53%);
            }

            40% {
                transform: translateX(-47%);
            }
        }

        /* Shield Icon with Cyber Effect */
        .shield-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            position: relative;
        }

        .shield-icon i {
            font-size: 60px;
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            position: relative;
            z-index: 2;
        }

        .shield-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.3);
                opacity: 0;
            }
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #F1F5F9;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 16px;
            color: #94A3B8;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            color: white;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(59, 130, 246, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #94A3B8;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #F1F5F9;
            transform: translateY(-3px);
            border-color: rgba(59, 130, 246, 0.5);
        }

        /* Lab NCS Branding */
        .branding {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .branding-text {
            font-size: 12px;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .branding-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            color: #94A3B8;
            font-weight: 600;
        }

        .branding-logo i {
            color: #3B82F6;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .error-code {
                font-size: 120px;
            }

            .title {
                font-size: 22px;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Background Effects -->
    <div class="grid-background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="shield-icon">
            <i class="fas fa-shield-halved"></i>
        </div>

        <div class="error-code">404</div>

        <h1 class="title">Access Denied</h1>

        <p class="subtitle">
            Halaman yang Anda cari tidak ditemukan atau telah dipindahkan.
            Pastikan URL yang Anda masukkan sudah benar.
        </p>

        <div class="btn-group">
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>/dashboard" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <div class="branding">
            <div class="branding-text">Network & Cyber Security Laboratory</div>
            <div class="branding-logo">
                <i class="fas fa-lock"></i>
                Lab NCS - JTI Polinema
            </div>
        </div>
    </div>
</body>

</html>
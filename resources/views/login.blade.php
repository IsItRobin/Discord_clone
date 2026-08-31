<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'FormRDD') }}</title>
    
    <!-- Google Fonts: gg sans alternative (Inter & Outfit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg-canvas: #1b1e4b;
            --card-bg: #313338;
            --input-bg: #1e1f22;
            --brand-primary: #5865F2;
            --brand-hover: #4752C4;
            --brand-active: #3C45A5;
            --text-heading: #F2F3F5;
            --text-muted: #B5BAC1;
            --text-sub: #949BA4;
            --text-link: #00A8FC;
            --danger-red: #F23F43;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #10122e;
            background-image: 
                radial-gradient(circle at 15% 25%, rgba(88, 101, 242, 0.28) 0%, transparent 45%),
                radial-gradient(circle at 85% 30%, rgba(59, 130, 246, 0.25) 0%, transparent 40%),
                radial-gradient(circle at 50% 85%, rgba(40, 48, 128, 0.4) 0%, transparent 55%),
                linear-gradient(135deg, #111438 0%, #1a1f59 35%, #182064 65%, #0f133d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
            color: #DBDEE1;
        }

        /* Floating background decoration */
        .ambient-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .star {
            position: absolute;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 1px;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
            animation: pulse-star 3s ease-in-out infinite alternate;
        }

        .star-cross {
            position: absolute;
            width: 14px;
            height: 14px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            font-weight: 300;
            line-height: 1;
            user-select: none;
            filter: drop-shadow(0 0 6px rgba(147, 197, 253, 0.8));
            animation: float-drift 7s ease-in-out infinite alternate;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, rgba(139, 92, 246, 0.7), rgba(49, 46, 129, 0.85) 60%, rgba(15, 23, 42, 0.95));
            box-shadow: inset 0 2px 10px rgba(255, 255, 255, 0.4), 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        .floating-orb-left {
            left: -3%;
            top: 28%;
            width: 140px;
            height: 140px;
            filter: blur(1px);
            opacity: 0.85;
        }

        .floating-cube-right {
            right: 2%;
            top: 24%;
            width: 120px;
            height: 120px;
            opacity: 0.6;
            filter: blur(1.5px);
        }

        @keyframes pulse-star {
            0% { opacity: 0.25; transform: scale(0.8); }
            100% { opacity: 0.95; transform: scale(1.2); }
        }

        @keyframes float-drift {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-10px) rotate(8deg); }
        }

        /* Discord-style Card */
        .login-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5), 0 1px 3px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 784px;
            padding: 32px;
            position: relative;
            z-index: 10;
            display: flex;
            gap: 32px;
            align-items: center;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 480px;
                padding: 24px;
                gap: 24px;
            }
            .qr-section {
                display: none !important;
            }
        }

        .form-section {
            flex: 1;
            width: 100%;
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-title {
            color: var(--text-heading);
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.3px;
            margin-bottom: 6px;
        }

        .form-subtitle {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 400;
            line-height: 1.4;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .required-star {
            color: var(--danger-red);
            margin-left: 2px;
        }

        .form-input {
            width: 100%;
            height: 40px;
            padding: 10px;
            background-color: var(--input-bg);
            border: 1px solid transparent;
            border-radius: 4px;
            color: #DBDEE1;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input:focus {
            border-color: #5865F2;
            box-shadow: 0 0 0 1px #5865F2;
        }

        .forgot-link {
            display: inline-block;
            color: var(--text-link);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-top: 4px;
            margin-bottom: 20px;
            transition: text-decoration 0.15s ease;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            height: 44px;
            background-color: var(--brand-primary);
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.17s ease, transform 0.1s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-btn:hover {
            background-color: var(--brand-hover);
        }

        .submit-btn:active {
            background-color: var(--brand-active);
            transform: scale(0.99);
        }

        .footer-text {
            color: var(--text-sub);
            font-size: 13px;
            margin-top: 10px;
        }

        .register-link {
            color: var(--text-link);
            text-decoration: none;
            font-weight: 500;
            margin-left: 4px;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        /* QR Code Section */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 240px;
            flex-shrink: 0;
            padding-left: 8px;
        }

        .qr-wrapper {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 8px;
            width: 176px;
            height: 176px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .qr-image {
            width: 160px;
            height: 160px;
            display: block;
        }

        .qr-title {
            color: var(--text-heading);
            font-size: 22px;
            font-weight: 700;
            margin-top: 24px;
            margin-bottom: 8px;
            letter-spacing: -0.2px;
        }

        .qr-desc {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.45;
            margin-bottom: 12px;
        }

        .qr-desc strong {
            color: #ffffff;
            font-weight: 600;
        }

        .passkey-link {
            color: var(--text-link);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: text-decoration 0.15s ease;
        }

        .passkey-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Ambient Background Elements -->
    <div class="ambient-bg" aria-hidden="true">
        <!-- Floating 3D Orbs / Geometry -->
        <div class="floating-orb floating-orb-left"></div>
        <div class="floating-cube-right">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="50,15 90,38 90,82 50,60" fill="#4338ca" opacity="0.8"/>
                <polygon points="10,38 50,15 50,60 10,82" fill="#6366f1" opacity="0.9"/>
                <polygon points="50,60 90,82 50,105 10,82" fill="#312e81" opacity="0.85"/>
            </svg>
        </div>

        <!-- Star Sparkles & Crosses matching screenshot -->
        <div class="star" style="width: 3px; height: 3px; top: 18%; left: 8%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 35%; left: 4%;"></div>
        <div class="star" style="width: 4px; height: 4px; top: 78%; left: 7%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 22%; left: 32%;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 62%; left: 22%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 88%; left: 22%;"></div>
        <div class="star" style="width: 4px; height: 4px; top: 12%; right: 24%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 70%; right: 22%;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 25%; right: 7%;"></div>
        <div class="star" style="width: 4px; height: 4px; top: 58%; right: 11%;"></div>

        <!-- Plus / Cross markers -->
        <div class="star-cross" style="top: 17%; left: 15%;">✦</div>
        <div class="star-cross" style="top: 61%; left: 14%;">✦</div>
        <div class="star-cross" style="top: 97%; left: 13%;">✦</div>
        <div class="star-cross" style="top: 86%; right: 21%;">✦</div>
        <div class="star-cross" style="top: 5%; right: 8%;">✦</div>
        <div class="star-cross" style="top: 88%; right: 8%; font-size: 24px; color: rgba(147, 197, 253, 0.65);">✦</div>
    </div>

    <!-- Login Modal Box -->
    <main class="login-card">
        <!-- Left Side: Login Form -->
        <section class="form-section">
            <header class="form-header">
                <h1 class="form-title">Welcome back!</h1>
                <p class="form-subtitle">We're so excited to see you again!</p>
            </header>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email or Phone Number -->
                <div class="input-group">
                    <label for="login_identity" class="input-label">
                        Email or Phone Number<span class="required-star">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="login_identity" 
                        name="email" 
                        required 
                        autocomplete="username"
                        value="{{ old('email') }}"
                        class="form-input"
                    >
                    @error('email')
                        <span style="color: var(--danger-red); font-size: 12px; margin-top: 4px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group" style="margin-bottom: 6px;">
                    <label for="password" class="input-label">
                        Password<span class="required-star">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="form-input"
                    >
                    @error('password')
                        <span style="color: var(--danger-red); font-size: 12px; margin-top: 4px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Forgot Password -->
                <div>
                    <a href="#" class="forgot-link">Forgot your password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    Log In
                </button>

                <!-- Footer Text / Register -->
                <p class="footer-text">
                    Need an account?<a href="{{ Route::has('register') ? route('register') : '#' }}" class="register-link">Register</a>
                </p>
            </form>
        </section>

        <!-- Right Side: QR Code Login -->
        <section class="qr-section">
            <div class="qr-wrapper">
                <!-- High-Fidelity SVG QR Code with Discord Center Emblem -->
                <svg class="qr-image" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- QR Finder Patterns (Top-Left, Top-Right, Bottom-Left) -->
                    <!-- Top-Left -->
                    <rect x="10" y="10" width="38" height="38" rx="4" fill="#000"/>
                    <rect x="16" y="16" width="26" height="26" rx="2" fill="#fff"/>
                    <rect x="22" y="22" width="14" height="14" rx="2" fill="#000"/>

                    <!-- Top-Right -->
                    <rect x="112" y="10" width="38" height="38" rx="4" fill="#000"/>
                    <rect x="118" y="16" width="26" height="26" rx="2" fill="#fff"/>
                    <rect x="124" y="22" width="14" height="14" rx="2" fill="#000"/>

                    <!-- Bottom-Left -->
                    <rect x="10" y="112" width="38" height="38" rx="4" fill="#000"/>
                    <rect x="16" y="118" width="26" height="26" rx="2" fill="#fff"/>
                    <rect x="22" y="124" width="14" height="14" rx="2" fill="#000"/>

                    <!-- QR Data Matrix Dots Simulation -->
                    <!-- Top horizontal strip & dots -->
                    <rect x="54" y="12" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="66" y="12" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="78" y="12" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="96" y="12" width="6" height="6" fill="#000" rx="1"/>

                    <rect x="54" y="24" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="72" y="24" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="84" y="24" width="18" height="6" fill="#000" rx="1"/>

                    <rect x="54" y="36" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="66" y="36" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="90" y="36" width="12" height="6" fill="#000" rx="1"/>

                    <!-- Left side middle dots -->
                    <rect x="12" y="54" width="6" height="12" fill="#000" rx="1"/>
                    <rect x="24" y="54" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="36" y="54" width="12" height="6" fill="#000" rx="1"/>
                    
                    <rect x="12" y="72" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="30" y="72" width="6" height="12" fill="#000" rx="1"/>
                    <rect x="42" y="72" width="6" height="6" fill="#000" rx="1"/>

                    <rect x="12" y="90" width="6" height="12" fill="#000" rx="1"/>
                    <rect x="24" y="90" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="42" y="90" width="6" height="6" fill="#000" rx="1"/>

                    <!-- Right side middle dots -->
                    <rect x="114" y="54" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="132" y="54" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="114" y="66" width="6" height="12" fill="#000" rx="1"/>
                    <rect x="126" y="66" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="144" y="66" width="6" height="18" fill="#000" rx="1"/>
                    <rect x="114" y="84" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="138" y="84" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="114" y="96" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="126" y="96" width="12" height="12" fill="#000" rx="1"/>

                    <!-- Bottom Right matrix dots -->
                    <rect x="54" y="114" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="72" y="114" width="6" height="18" fill="#000" rx="1"/>
                    <rect x="84" y="114" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="114" y="114" width="6" height="12" fill="#000" rx="1"/>
                    <rect x="126" y="114" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="144" y="114" width="6" height="6" fill="#000" rx="1"/>

                    <rect x="54" y="126" width="6" height="12" fill="#000" rx="1"/>
                    <rect x="66" y="132" width="12" height="6" fill="#000" rx="1"/>
                    <rect x="84" y="126" width="12" height="12" fill="#000" rx="1"/>
                    <rect x="102" y="126" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="126" y="126" width="6" height="18" fill="#000" rx="1"/>
                    <rect x="138" y="126" width="12" height="6" fill="#000" rx="1"/>

                    <rect x="54" y="144" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="78" y="144" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="90" y="144" width="18" height="6" fill="#000" rx="1"/>
                    <rect x="114" y="144" width="6" height="6" fill="#000" rx="1"/>
                    <rect x="138" y="138" width="12" height="12" fill="#000" rx="1"/>

                    <!-- Center Badge Background -->
                    <circle cx="80" cy="80" r="21" fill="#fff"/>
                    <circle cx="80" cy="80" r="18" fill="#000"/>

                    <!-- Discord Controller / Mask Emblem -->
                    <g transform="translate(68, 69) scale(0.68)">
                        <path d="M29.5 5.5C27.2 4.4 24.8 3.6 22.2 3.1C22 3.5 21.7 4.1 21.5 4.6C18.8 4.2 16.1 4.2 13.5 4.6C13.3 4.1 13 3.5 12.7 3.1C10.1 3.6 7.7 4.4 5.5 5.5C1 12.2 -0.2 18.7 0.05 25.1C3.1 27.4 6 28.7 8.9 29.6C9.6 28.6 10.2 27.6 10.7 26.5C9.7 26.1 8.7 25.6 7.7 25C8 24.8 8.2 24.6 8.5 24.4C14.2 27 20.8 27 26.5 24.4C26.8 24.6 27 24.8 27.3 25C26.3 25.6 25.3 26.1 24.3 26.5C24.8 27.6 25.4 28.6 26.1 29.6C29 28.7 31.9 27.4 34.9 25.1C35.3 17.6 33.3 11.2 29.5 5.5ZM11.7 20.6C10 20.6 8.5 19 8.5 17C8.5 15 9.9 13.4 11.7 13.4C13.5 13.4 14.9 15 14.9 17C14.9 19 13.4 20.6 11.7 20.6ZM23.3 20.6C21.6 20.6 20.1 19 20.1 17C20.1 15 21.5 13.4 23.3 13.4C25.1 13.4 26.5 15 26.5 17C26.5 19 25.1 20.6 23.3 20.6Z" fill="#fff"/>
                    </g>
                </svg>
            </div>

            <h2 class="qr-title">Log in with QR Code</h2>
            <p class="qr-desc">
                Scan this with the <strong>Discord mobile app</strong> to log in instantly.
            </p>
            <a href="#" class="passkey-link">Or sign in with a passkey</a>
        </section>
    </main>
</body>
</html>
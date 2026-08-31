<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account - {{ config('app.name', 'Discord') }}</title>
    
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
            padding: 2.5rem 1rem;
            position: relative;
            overflow-x: hidden;
            color: #DBDEE1;
        }

        /* Top Left Discord Logo */
        .discord-brand-logo {
            position: absolute;
            top: 28px;
            left: 32px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #ffffff;
            z-index: 20;
            transition: opacity 0.2s ease;
        }

        .discord-brand-logo:hover {
            opacity: 0.9;
        }

        .discord-brand-logo svg {
            width: 32px;
            height: 32px;
        }

        .discord-brand-name {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: -0.5px;
        }

        @media (max-width: 640px) {
            .discord-brand-logo {
                position: static;
                margin-bottom: 20px;
                justify-content: center;
            }
            body {
                flex-direction: column;
                padding: 1.5rem 1rem;
            }
        }

        /* Ambient Background Elements */
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

        /* Registration Card */
        .register-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5), 0 1px 3px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 480px;
            padding: 32px;
            position: relative;
            z-index: 10;
        }

        .register-title {
            color: var(--text-heading);
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            letter-spacing: -0.3px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 16px;
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

        /* Date of Birth Dropdowns */
        .dob-container {
            display: flex;
            gap: 10px;
        }

        .dob-select-wrapper {
            position: relative;
            flex: 1;
        }

        .dob-select-wrapper.flex-month {
            flex: 1.3;
        }

        .dob-select {
            width: 100%;
            height: 40px;
            padding: 8px 30px 8px 12px;
            background-color: var(--input-bg);
            border: 1px solid transparent;
            border-radius: 4px;
            color: #DBDEE1;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .dob-select:focus {
            border-color: #5865F2;
            box-shadow: 0 0 0 1px #5865F2;
        }

        .dob-select option {
            background-color: #2b2d31;
            color: #DBDEE1;
            padding: 8px;
        }

        .select-arrow {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--text-muted);
        }

        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 18px;
            margin-bottom: 14px;
            cursor: pointer;
            user-select: none;
        }

        .custom-checkbox {
            position: relative;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            background-color: var(--input-bg);
            border: 1px solid #4e5058;
            border-radius: 4px;
            transition: background-color 0.15s ease, border-color 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-checkbox input:checked ~ .checkmark {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .checkmark svg {
            display: none;
            width: 14px;
            height: 14px;
            stroke: #ffffff;
            stroke-width: 3;
        }

        .custom-checkbox input:checked ~ .checkmark svg {
            display: block;
        }

        .checkbox-label {
            color: var(--text-sub);
            font-size: 12px;
            line-height: 1.45;
        }

        /* Terms and Privacy Text */
        .terms-text {
            color: var(--text-sub);
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 20px;
        }

        .terms-text a,
        .footer-link {
            color: var(--text-link);
            text-decoration: none;
            transition: text-decoration 0.15s ease;
        }

        .terms-text a:hover,
        .footer-link:hover {
            text-decoration: underline;
        }

        /* Submit Button */
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
            margin-bottom: 12px;
        }

        .submit-btn:hover {
            background-color: var(--brand-hover);
        }

        .submit-btn:active {
            background-color: var(--brand-active);
            transform: scale(0.99);
        }

        .footer-text {
            font-size: 13px;
        }
    </style>
</head>
<body>
    <!-- Top Left Discord Brand Header -->
    <a href="{{ route('login') }}" class="discord-brand-logo">
        <svg viewBox="0 0 127.14 96.36" fill="currentColor">
            <path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,45.91,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,45.91,96.12,53,91.08,65.69,84.69,65.69Z"/>
        </svg>
        <span class="discord-brand-name">Discord</span>
    </a>

    <!-- Ambient Cosmic Elements -->
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

    <!-- Registration Card -->
    <main class="register-card">
        <h1 class="register-title">Create an account</h1>

       <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="input-label">
                    Email<span class="required-star">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required 
                    autocomplete="email"
                    value="{{ old('email') }}"
                    class="form-input"
                >
                @error('email')
                    <span style="color: var(--danger-red); font-size: 12px; margin-top: 4px; display: block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Display Name (Optional) -->
            <div class="input-group">
                <label for="display_name" class="input-label">
                    Display Name
                </label>
                <input 
                    type="text" 
                    id="display_name" 
                    name="display_name" 
                    autocomplete="nickname"
                    value="{{ old('display_name') }}"
                    class="form-input"
                >
            </div>

            <!-- Username -->
            <div class="input-group">
                <label for="username" class="input-label">
                    Username<span class="required-star">*</span>
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="name" 
                    required 
                    autocomplete="username"
                    value="{{ old('name') }}"
                    class="form-input"
                >
                @error('name')
                    <span style="color: var(--danger-red); font-size: 12px; margin-top: 4px; display: block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">
                    Password<span class="required-star">*</span>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    class="form-input"
                >
                @error('password')
                    <span style="color: var(--danger-red); font-size: 12px; margin-top: 4px; display: block;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div class="input-group">
                <label class="input-label">
                    Date of Birth<span class="required-star">*</span>
                </label>
                <div class="dob-container">
                    <!-- Month -->
                    <div class="dob-select-wrapper flex-month">
                        <select name="dob_month" class="dob-select">
                            <option value="" disabled selected hidden>Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <svg class="select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <!-- Day -->
                    <div class="dob-select-wrapper">
                        <select name="dob_day" class="dob-select">
                            <option value="" disabled selected hidden>Day</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endfor
                        </select>
                        <svg class="select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <!-- Year -->
                    <div class="dob-select-wrapper">
                        <select name="dob_year" class="dob-select">
                            <option value="" disabled selected hidden>Year</option>
                            @for ($y = date('Y'); $y >= 1920; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        <svg class="select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Email updates checkbox -->
            <label class="checkbox-container">
                <span class="custom-checkbox">
                    <input type="checkbox" name="marketing_opt_in" checked>
                    <span class="checkmark">
                        <svg viewBox="0 0 24 24" fill="none">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                </span>
                <span class="checkbox-label">
                    (Optional) It's okay to send me emails with Discord updates, tips, and special offers. You can opt out at any time.
                </span>
            </label>

            <!-- Terms and Privacy Note -->
            <p class="terms-text">
                By clicking “Create Account,” you agree to Discord's <a href="#">Terms of Service</a> and have read the <a href="#">Privacy Policy</a>
            </p>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                Create Account
            </button>

            <!-- Footer Login Link -->
            <p class="footer-text">
                <a href="{{ route('login') }}" class="footer-link">Already have an account? Log in</a>
            </p>
        </form>
    </main>
</body>
</html>
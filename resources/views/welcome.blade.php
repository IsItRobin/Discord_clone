<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discord | Group Chat That's All Fun & Games</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 127.14 96.36'><path fill='%235865F2' d='M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,45.91,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,45.91,96.12,53,91.08,65.69,84.69,65.69Z'/></svg>">
    
    <!-- Google Fonts: Inter & Outfit for authentic Discord typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg-deep: #161845;
            --bg-gradient-top: #151842;
            --bg-gradient-mid: #1d2260;
            --bg-gradient-bot: #23297a;
            --brand-blurple: #5865F2;
            --brand-blurple-hover: #4752C4;
            --brand-dark: #23272A;
            --text-white: #FFFFFF;
            --text-subtle: #E3E5E8;
            --text-nav: #FFFFFF;
            --text-nav-hover: rgba(255, 255, 255, 0.8);
            --header-height: 80px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #14173e;
            background-image: 
                radial-gradient(ellipse at 85% 15%, rgba(114, 137, 218, 0.22) 0%, transparent 50%),
                radial-gradient(ellipse at 15% 40%, rgba(88, 101, 242, 0.28) 0%, transparent 60%),
                radial-gradient(circle at 50% 100%, rgba(46, 56, 163, 0.5) 0%, transparent 70%),
                linear-gradient(180deg, #121435 0%, #1a1f59 35%, #222976 65%, #191f63 100%);
            min-height: 100vh;
            color: var(--text-white);
            overflow-x: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Ambient floating stars and decorations */
        .ambient-stars {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .star {
            position: absolute;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 6px rgba(255, 255, 255, 0.9), 0 0 12px rgba(147, 197, 253, 0.6);
            animation: pulse-twinkle 4s ease-in-out infinite alternate;
        }

        .sparkle-cross {
            position: absolute;
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            user-select: none;
            filter: drop-shadow(0 0 6px rgba(165, 180, 252, 0.8));
            animation: float-sparkle 6s ease-in-out infinite alternate;
        }

        @keyframes pulse-twinkle {
            0% { opacity: 0.2; transform: scale(0.7); }
            50% { opacity: 0.9; transform: scale(1.3); }
            100% { opacity: 0.3; transform: scale(0.8); }
        }

        @keyframes float-sparkle {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.4; }
            50% { opacity: 0.95; }
            100% { transform: translateY(-12px) rotate(15deg); opacity: 0.5; }
        }

        /* Floating 3D crowns & items in ambient */
        .floating-crown-bg {
            position: absolute;
            top: 15%;
            left: 36%;
            width: 90px;
            opacity: 0.45;
            filter: blur(1.5px) drop-shadow(0 10px 20px rgba(0,0,0,0.4));
            animation: float-item 8s ease-in-out infinite alternate;
            z-index: 1;
        }

        .floating-crown-right {
            position: absolute;
            top: 40%;
            right: 2%;
            width: 80px;
            opacity: 0.35;
            filter: blur(2px) drop-shadow(0 10px 20px rgba(0,0,0,0.5));
            animation: float-item-rev 9s ease-in-out infinite alternate;
            z-index: 1;
        }

        @keyframes float-item {
            0% { transform: translateY(0px) rotate(-6deg) scale(0.95); }
            100% { transform: translateY(-18px) rotate(4deg) scale(1.05); }
        }

        @keyframes float-item-rev {
            0% { transform: translateY(0px) rotate(8deg); }
            100% { transform: translateY(-22px) rotate(-8deg); }
        }

        /* Navigation Bar */
        .navbar-container {
            width: 100%;
            max-width: 1380px;
            margin: 0 auto;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 30;
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            transition: opacity 0.2s ease;
        }

        .logo-wrap:hover {
            opacity: 0.9;
        }

        .logo-icon {
            width: 34px;
            height: 26px;
            fill: #ffffff;
        }

        .logo-text {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
        }

        /* Nav links */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: var(--text-nav);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 2px;
            transition: color 0.15s ease, opacity 0.15s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .dropdown-chevron {
            width: 10px;
            height: 6px;
            transition: transform 0.2s ease;
            opacity: 0.85;
        }

        .nav-item:hover .dropdown-chevron {
            transform: rotate(180deg);
        }

        /* Dropdown popover */
        .nav-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: #23272A;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 0;
            min-width: 160px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
            z-index: 50;
        }

        .nav-item:hover .nav-dropdown {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateX(-50%) translateY(4px);
        }

        .dropdown-item {
            display: block;
            padding: 8px 16px;
            color: #DBDEE1;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .dropdown-item:hover {
            background: #5865F2;
            color: #FFFFFF;
        }

        /* Nav Right / Action */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .login-btn {
            background-color: #FFFFFF;
            color: #23272A;
            font-size: 14px;
            font-weight: 600;
            padding: 9px 18px;
            border-radius: 40px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .login-btn:hover {
            background-color: #F6F6F6;
            color: #5865F2;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-1px);
        }

        .login-btn:active {
            transform: translateY(1px);
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: #FFFFFF;
            cursor: pointer;
            padding: 8px;
        }

        /* Hero Section */
        .hero-section {
            width: 100%;
            max-width: 1380px;
            margin: 0 auto;
            padding: 40px 32px 60px 32px;
            display: grid;
            grid-template-columns: 1.05fr 1.35fr;
            align-items: center;
            gap: 40px;
            flex: 1;
            position: relative;
            z-index: 10;
        }

        /* Left Hero Content */
        .hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 20;
            padding-bottom: 30px;
        }

        .hero-title {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-size: clamp(40px, 4.4vw, 68px);
            font-weight: 900;
            line-height: 1.04;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            color: #FFFFFF;
            margin-bottom: 28px;
            text-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
        }

        .hero-desc {
            font-size: clamp(16px, 1.2vw, 19px);
            line-height: 1.62;
            color: #ECEFF4;
            max-width: 520px;
            margin-bottom: 34px;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }

        .hero-btn-primary {
            background-color: #FFFFFF;
            color: #23272A;
            font-size: 17px;
            font-weight: 600;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            transition: all 0.2s ease;
        }

        .hero-btn-primary:hover {
            color: #5865F2;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.35);
            transform: translateY(-2px);
        }

        .hero-btn-secondary {
            background-color: #23272A;
            color: #FFFFFF;
            font-size: 17px;
            font-weight: 600;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            transition: all 0.2s ease;
        }

        .hero-btn-secondary:hover {
            background-color: #2c2f33;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.35);
            transform: translateY(-2px);
        }

        /* Right Hero Artwork Composition */
        .hero-artwork-wrapper {
            position: relative;
            width: 100%;
            min-height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-stage {
            position: relative;
            width: 100%;
            max-width: 720px;
            aspect-ratio: 16 / 11;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ground Glow & Shadow */
        .ground-glow {
            position: absolute;
            bottom: 0px;
            left: 5%;
            right: 5%;
            height: 70px;
            background: radial-gradient(ellipse at 50% 60%, rgba(20, 24, 75, 0.95) 0%, rgba(15, 18, 55, 0.6) 45%, transparent 75%);
            border-radius: 50%;
            filter: blur(12px);
            z-index: 2;
        }

        /* Main Monitor Frame (Desktop App) */
        .mockup-monitor {
            position: absolute;
            width: 76%;
            height: 76%;
            top: 2%;
            right: 8%;
            background: #1e1f22;
            border-radius: 12px;
            border: 4px solid #35373c;
            box-shadow: 
                -12px 18px 45px rgba(0, 0, 0, 0.65),
                0 0 0 1px rgba(255, 255, 255, 0.08),
                inset 0 1px 2px rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 4;
            transform: perspective(1000px) rotateY(-4deg) rotateX(2deg);
        }

        /* Monitor 3D back rim */
        .mockup-monitor::after {
            content: '';
            position: absolute;
            top: -4px;
            right: -14px;
            width: 14px;
            height: 100%;
            background: linear-gradient(90deg, #18191c 0%, #0d0e10 100%);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            pointer-events: none;
            clip-path: polygon(0 0, 100% 4%, 100% 96%, 0 100%);
        }

        /* Monitor Top Bar */
        .monitor-top-bar {
            height: 24px;
            background: #1e1f22;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px;
            border-bottom: 1px solid #111214;
        }

        .window-dots {
            display: flex;
            gap: 5px;
        }

        .w-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }
        .w-dot.red { background: #ed4245; }
        .w-dot.yellow { background: #fee75c; }
        .w-dot.green { background: #57f287; }

        .monitor-cam {
            width: 5px;
            height: 5px;
            background: #000;
            border: 1px solid #4e5058;
            border-radius: 50%;
        }

        /* Discord UI Mockup Inside Monitor */
        .discord-screen {
            flex: 1;
            display: grid;
            grid-template-columns: 42px 110px 1fr 90px;
            background: #313338;
            font-size: 11px;
            overflow: hidden;
        }

        /* Mini Server Rail */
        .screen-servers {
            background: #1e1f22;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 0;
            gap: 6px;
            border-right: 1px solid #111214;
        }

        .s-icon {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #313338;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
        }

        .s-icon.active {
            background: #5865F2;
            border-radius: 8px;
        }

        .s-divider {
            width: 18px;
            height: 1px;
            background: #35373c;
        }

        /* Channels Sidebar */
        .screen-channels {
            background: #2b2d31;
            padding: 8px 6px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            border-right: 1px solid #232428;
        }

        .ch-header {
            font-size: 10px;
            font-weight: 700;
            color: #949ba4;
            text-transform: uppercase;
            margin-bottom: 2px;
            padding: 2px 4px;
        }

        .ch-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 4px 6px;
            border-radius: 4px;
            color: #949ba4;
            font-size: 10px;
        }

        .ch-item.active {
            background: rgba(255, 255, 255, 0.08);
            color: #f2f3f5;
            font-weight: 600;
        }

        .ch-item.voice {
            color: #23a55a;
        }

        /* Main Chat Area */
        .screen-chat {
            background: #313338;
            display: flex;
            flex-direction: column;
            padding: 8px 10px;
            overflow: hidden;
        }

        .chat-header-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 8px;
            color: #f2f3f5;
            font-weight: 700;
            font-size: 11px;
        }

        .chat-stream {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .msg-row {
            display: flex;
            gap: 6px;
            align-items: flex-start;
        }

        .msg-avatar {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #5865F2;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: bold;
        }

        .msg-avatar.pink { background: #eb459e; }
        .msg-avatar.green { background: #57f287; }
        .msg-avatar.yellow { background: #fee75c; color: #000; }

        .msg-body {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .msg-author {
            font-size: 9.5px;
            font-weight: 700;
            color: #f2f3f5;
        }

        .msg-text {
            font-size: 9.5px;
            color: #dbdee1;
            line-height: 1.3;
        }

        .msg-card-embed {
            margin-top: 4px;
            background: #2b2d31;
            border-left: 3px solid #5865F2;
            border-radius: 4px;
            padding: 6px;
            font-size: 9px;
        }

        /* Voice Call / Stage Bar inside Monitor */
        .voice-connected-strip {
            background: #232428;
            border-radius: 4px;
            padding: 4px 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
        }

        /* Members Sidebar */
        .screen-members {
            background: #2b2d31;
            padding: 8px 6px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .mem-heading {
            font-size: 8.5px;
            font-weight: 700;
            color: #949ba4;
            text-transform: uppercase;
        }

        .mem-row {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            color: #dbdee1;
        }

        .mem-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #23a55a;
        }

        /* Monitor Stand */
        .monitor-stand {
            position: absolute;
            bottom: 4%;
            left: 46%;
            transform: translateX(-50%);
            width: 70px;
            height: 65px;
            background: linear-gradient(180deg, #2b2d31 0%, #1e1f22 100%);
            border-radius: 4px;
            z-index: 3;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
        }

        .monitor-base {
            position: absolute;
            bottom: 2%;
            left: 46%;
            transform: translateX(-50%);
            width: 220px;
            height: 16px;
            background: linear-gradient(180deg, #35373c 0%, #1e1f22 100%);
            border-radius: 8px;
            z-index: 3;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.7);
        }

        /* Monitor Yellow Sticky Note */
        .sticky-note {
            position: absolute;
            bottom: 22%;
            left: 20%;
            width: 48px;
            height: 48px;
            background: #fee75c;
            border-radius: 2px;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.4);
            transform: rotate(-10deg);
            z-index: 8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: cursive, sans-serif;
            font-size: 8px;
            color: #23272a;
            font-weight: bold;
        }

        /* Character 1: Left Girl with Purple/Orange Outfit */
        .character-left {
            position: absolute;
            left: 11%;
            bottom: 2%;
            width: 140px;
            height: 250px;
            z-index: 7;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.5));
            animation: char-float-left 7s ease-in-out infinite alternate;
        }

        @keyframes char-float-left {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-6px); }
        }

        /* Character 2: Center Robot Toy */
        .character-robot {
            position: absolute;
            left: 28%;
            bottom: 3%;
            width: 58px;
            height: 72px;
            z-index: 8;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.6));
            animation: robot-wiggle 5s ease-in-out infinite alternate;
        }

        @keyframes robot-wiggle {
            0% { transform: rotate(-2deg) translateY(0); }
            100% { transform: rotate(3deg) translateY(-4px); }
        }

        /* Character 3: Game Controller */
        .prop-controller {
            position: absolute;
            left: 36%;
            bottom: 2%;
            width: 130px;
            height: 80px;
            z-index: 9;
            filter: drop-shadow(0 12px 20px rgba(0, 0, 0, 0.65));
        }

        /* Character 4: Piggy Creature Mascot */
        .character-piggy {
            position: absolute;
            left: 55%;
            bottom: 1%;
            width: 115px;
            height: 135px;
            z-index: 9;
            filter: drop-shadow(0 12px 20px rgba(0, 0, 0, 0.55));
            animation: pig-bounce 6s ease-in-out infinite alternate;
        }

        @keyframes pig-bounce {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-7px) rotate(2deg); }
        }

        /* Smartphone Mockup with Video Grid */
        .mockup-phone {
            position: absolute;
            right: 17%;
            bottom: 4%;
            width: 110px;
            height: 200px;
            background: #111214;
            border-radius: 20px;
            border: 3px solid #35373c;
            box-shadow: 
                -8px 12px 30px rgba(0, 0, 0, 0.65),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            z-index: 10;
            display: flex;
            flex-direction: column;
            transform: rotate(-4deg);
        }

        .phone-notch {
            width: 40px;
            height: 6px;
            background: #000;
            margin: 4px auto 2px auto;
            border-radius: 4px;
        }

        .phone-video-grid {
            flex: 1;
            padding: 4px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 4px;
            background: #1e1f22;
        }

        .video-tile {
            background: #2b2d31;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-tile.active-speaking {
            border: 1.5px solid #23a55a;
        }

        .video-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }

        .video-tile-name {
            position: absolute;
            bottom: 2px;
            left: 3px;
            font-size: 6.5px;
            background: rgba(0, 0, 0, 0.6);
            padding: 1px 3px;
            border-radius: 2px;
            color: #fff;
        }

        /* Character 5: Right Boy with Purple Jacket */
        .character-right {
            position: absolute;
            right: 4%;
            bottom: 2%;
            width: 110px;
            height: 235px;
            z-index: 8;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.5));
            animation: char-float-right 8s ease-in-out infinite alternate;
        }

        @keyframes char-float-right {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-8px) rotate(-1deg); }
        }

        /* Responsive Breakpoints */
        @media (max-width: 1100px) {
            .hero-section {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 40px;
                padding-top: 20px;
            }
            .hero-content {
                align-items: center;
                margin: 0 auto;
            }
            .hero-buttons {
                justify-content: center;
            }
            .nav-menu {
                display: none;
            }
            .mobile-toggle {
                display: block;
            }
            .hero-artwork-wrapper {
                min-height: 440px;
            }
        }

        @media (max-width: 640px) {
            .navbar-container {
                padding: 16px 20px;
            }
            .hero-section {
                padding: 20px 16px 40px 16px;
            }
            .hero-title {
                font-size: 34px;
            }
            .hero-desc {
                font-size: 15px;
            }
            .hero-btn-primary, .hero-btn-secondary {
                width: 100%;
                justify-content: center;
                font-size: 15px;
                padding: 13px 20px;
            }
            .hero-artwork-wrapper {
                transform: scale(0.85);
                transform-origin: center top;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Sparkles & Floating Objects -->
    <div class="ambient-stars" aria-hidden="true">
        <!-- Floating Stars -->
        <div class="star" style="width: 3px; height: 3px; top: 12%; left: 14%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 28%; left: 8%;"></div>
        <div class="star" style="width: 4px; height: 4px; top: 72%; left: 4%;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 22%; left: 45%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 10%; left: 68%;"></div>
        <div class="star" style="width: 4px; height: 4px; top: 18%; right: 18%;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 38%; right: 6%;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 65%; right: 14%;"></div>

        <!-- Cross Sparkles (✦) -->
        <div class="sparkle-cross" style="top: 15%; left: 18%;">✦</div>
        <div class="sparkle-cross" style="top: 48%; left: 6%;">✦</div>
        <div class="sparkle-cross" style="top: 80%; left: 22%;">✦</div>
        <div class="sparkle-cross" style="top: 12%; right: 30%;">✦</div>
        <div class="sparkle-cross" style="top: 60%; right: 4%;">✦</div>

        <!-- 3D Polygonal Floating Crown (Left Center) -->
        <div class="floating-crown-bg">
            <svg viewBox="0 0 100 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 65 L20 25 L45 50 L50 15 L55 50 L80 25 L90 65 Z" fill="url(#crownGrad1)" />
                <path d="M10 65 L50 78 L90 65 L55 50 L45 50 Z" fill="url(#crownGrad2)" opacity="0.8" />
                <defs>
                    <linearGradient id="crownGrad1" x1="0" y1="0" x2="100" y2="80" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#EC4899" />
                        <stop offset="0.5" stop-color="#A855F7" />
                        <stop offset="1" stop-color="#6366F1" />
                    </linearGradient>
                    <linearGradient id="crownGrad2" x1="0" y1="0" x2="100" y2="80" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#8B5CF6" />
                        <stop offset="1" stop-color="#3B82F6" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- 3D Floating Geometry (Right) -->
        <div class="floating-crown-right">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="50,15 90,38 90,82 50,60" fill="#6366F1" opacity="0.6"/>
                <polygon points="10,38 50,15 50,60 10,82" fill="#818CF8" opacity="0.7"/>
                <polygon points="50,60 90,82 50,105 10,82" fill="#4338CA" opacity="0.5"/>
            </svg>
        </div>
    </div>

    <!-- Navigation Header -->
    <header>
        <nav class="navbar-container" aria-label="Main Navigation">
            <!-- Discord Logo -->
            <a href="/" class="logo-wrap" title="Discord Home">
                <svg class="logo-icon" viewBox="0 0 127.14 96.36">
                    <path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,45.91,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,45.91,96.12,53,91.08,65.69,84.69,65.69Z"/>
                </svg>
                <span class="logo-text">Discord</span>
            </a>

            <!-- Nav Links List -->
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link">Download</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Nitro</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Discover
                        <svg class="dropdown-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-item">Gaming</a>
                        <a href="#" class="dropdown-item">Music</a>
                        <a href="#" class="dropdown-item">Education</a>
                        <a href="#" class="dropdown-item">Science & Tech</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Safety
                        <svg class="dropdown-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-item">Safety Center</a>
                        <a href="#" class="dropdown-item">Family Center</a>
                        <a href="#" class="dropdown-item">Community Guidelines</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Quests
                        <svg class="dropdown-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-item">Active Quests</a>
                        <a href="#" class="dropdown-item">Rewards</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Support
                        <svg class="dropdown-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-item">Help Center</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <a href="#" class="dropdown-item">Status</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Blog
                        <svg class="dropdown-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-item">All Posts</a>
                        <a href="#" class="dropdown-item">Product News</a>
                        <a href="#" class="dropdown-item">Community Stories</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Developers
                        <svg class="dropdown-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-item">Developer Portal</a>
                        <a href="#" class="dropdown-item">Documentation</a>
                        <a href="#" class="dropdown-item">API Status</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Careers</a>
                </li>
            </ul>

            <!-- Right Action: Log In Button -->
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="login-btn" id="login-button">
                    Log In
                </a>
                <button class="mobile-toggle" aria-label="Open navigation menu" onclick="toggleMobileMenu()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Main Hero Section -->
    <main class="hero-section">
        <!-- Left Column: Big Headline & Intro -->
        <section class="hero-content">
            <h1 class="hero-title">
                GROUP CHAT<br>
                THAT'S ALL<br>
                FUN & GAMES
            </h1>
            <p class="hero-desc">
                Discord is great for playing games and chilling with friends, or even building a worldwide community. Customize your own space to talk, play, and hang out.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="hero-btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z"/>
                    </svg>
                    Download for Windows
                </a>
                <a href="{{ route('login') }}" class="hero-btn-secondary">
                    Open Discord in your browser
                </a>
            </div>
        </section>

        <!-- Right Column: 3D Artwork Composition -->
        <section class="hero-artwork-wrapper" aria-label="Discord Interactive Artwork">
            <div class="hero-stage">
                <!-- Ambient Floor Shadow -->
                <div class="ground-glow"></div>

                <!-- 1. Monitor Stand & Base -->
                <div class="monitor-stand"></div>
                <div class="monitor-base"></div>

                <!-- 2. Main 3D Discord Monitor (Desktop Interface) -->
                <div class="mockup-monitor">
                    <!-- Top Window Bar -->
                    <div class="monitor-top-bar">
                        <div class="window-dots">
                            <span class="w-dot red"></span>
                            <span class="w-dot yellow"></span>
                            <span class="w-dot green"></span>
                        </div>
                        <div class="monitor-cam"></div>
                        <div style="font-size: 8px; color: #949ba4; font-weight: 600;">Discord</div>
                    </div>

                    <!-- App UI -->
                    <div class="discord-screen">
                        <!-- Left Server Bar -->
                        <div class="screen-servers">
                            <div class="s-icon active">
                                <svg width="14" height="14" viewBox="0 0 127.14 96.36" fill="#fff">
                                    <path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,45.91,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,45.91,96.12,53,91.08,65.69,84.69,65.69Z"/>
                                </svg>
                            </div>
                            <div class="s-divider"></div>
                            <div class="s-icon" style="background: #23a55a;">🎮</div>
                            <div class="s-icon" style="background: #eb459e;">🌸</div>
                            <div class="s-icon" style="background: #f47b67;">🔥</div>
                        </div>

                        <!-- Channels Sidebar -->
                        <div class="screen-channels">
                            <div class="ch-header">Text Channels</div>
                            <div class="ch-item active"># deep-talk</div>
                            <div class="ch-item"># general</div>
                            <div class="ch-item"># gaming</div>
                            <div class="ch-header" style="margin-top: 4px;">Voice Channels</div>
                            <div class="ch-item voice active">🔊 Chill Room</div>
                            <div style="font-size: 8px; color: #949ba4; padding-left: 12px;">• 4 connected</div>
                        </div>

                        <!-- Main Chat Screen -->
                        <div class="screen-chat">
                            <div class="chat-header-bar">
                                <span style="color: #949ba4;">#</span> deep-talk
                            </div>
                            <div class="chat-stream">
                                <div class="msg-row">
                                    <div class="msg-avatar pink">M</div>
                                    <div class="msg-body">
                                        <span class="msg-author" style="color: #eb459e;">Mina <span style="color: #949ba4; font-size: 7.5px;">Today at 8:12 PM</span></span>
                                        <span class="msg-text">who is ready for the tournament tonight?! 🏆</span>
                                    </div>
                                </div>
                                <div class="msg-row">
                                    <div class="msg-avatar" style="background: #5865f2;">B</div>
                                    <div class="msg-body">
                                        <span class="msg-author" style="color: #5865f2;">Bot Clyde <span style="background: #5865f2; color: #fff; font-size: 7px; padding: 0 2px; border-radius: 2px;">BOT</span></span>
                                        <div class="msg-card-embed">
                                            <strong style="color: #fff;">Server Quest Activated!</strong><br>
                                            Play with friends to earn exclusive Nitro badges.
                                        </div>
                                    </div>
                                </div>
                                <div class="msg-row">
                                    <div class="msg-avatar green">Z</div>
                                    <div class="msg-body">
                                        <span class="msg-author" style="color: #57f287;">Zack</span>
                                        <span class="msg-text">Hopping into voice call right now!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="voice-connected-strip">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <span style="width: 5px; height: 5px; background: #23a55a; border-radius: 50%;"></span>
                                    <span style="font-size: 7.5px; color: #23a55a; font-weight: bold;">Voice Connected</span>
                                </div>
                                <span style="font-size: 7.5px; color: #949ba4;">RTC Connecting</span>
                            </div>
                        </div>

                        <!-- Members Panel -->
                        <div class="screen-members">
                            <div class="mem-heading">Online — 4</div>
                            <div class="mem-row"><span class="mem-dot"></span> Mina</div>
                            <div class="mem-row"><span class="mem-dot"></span> Zack</div>
                            <div class="mem-row"><span class="mem-dot"></span> Snuggle</div>
                            <div class="mem-row"><span class="mem-dot"></span> Robin</div>
                            <div class="mem-heading" style="margin-top: 4px;">Offline — 2</div>
                            <div class="mem-row" style="color: #949ba4;"><span class="mem-dot" style="background: #80848e;"></span> Kai</div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Post-It Note on Monitor Base -->
                <div class="sticky-note">
                    PLAY<br>GAMES! 🎮
                </div>

                <!-- 3. Left Girl Character (Vector Illustration) -->
                <div class="character-left">
                    <svg viewBox="0 0 140 250" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Shadow Base -->
                        <ellipse cx="65" cy="242" rx="40" ry="6" fill="#0b0d26" opacity="0.6"/>
                        <!-- Legs & Pants -->
                        <path d="M48 140 L40 235 L52 235 L58 155 L68 155 L75 235 L87 235 L82 140 Z" fill="#1e1b4b"/>
                        <!-- Shoes -->
                        <rect x="36" y="230" width="18" height="10" rx="4" fill="#3b82f6"/>
                        <rect x="74" y="230" width="18" height="10" rx="4" fill="#3b82f6"/>
                        <path d="M38 235 h14 M76 235 h14" stroke="#ffffff" stroke-width="2"/>
                        <!-- Purple Jacket / Body -->
                        <path d="M35 85 Q25 110 32 145 L95 145 Q102 110 92 85 Z" fill="#7c3aed"/>
                        <path d="M35 85 L65 145 L92 85" fill="#6d28d9"/>
                        <!-- Left Arm leaning -->
                        <path d="M35 90 L18 120 L28 135 L42 105 Z" fill="#6d28d9"/>
                        <!-- Orange Scarf -->
                        <path d="M42 70 Q64 88 84 70 Q88 88 64 92 Q40 88 42 70 Z" fill="#f97316"/>
                        <path d="M56 86 L52 125 L68 125 L64 86 Z" fill="#ea580c"/>
                        <!-- Head & Face -->
                        <circle cx="64" cy="52" r="18" fill="#fed7aa"/>
                        <!-- Hair (Dark Violet/Navy Bangs) -->
                        <path d="M44 50 Q48 28 64 28 Q80 28 84 50 Q75 42 64 44 Q52 42 44 50 Z" fill="#1e1b4b"/>
                        <path d="M44 48 L40 68 L48 60 Z" fill="#1e1b4b"/>
                        <path d="M84 48 L88 68 L80 60 Z" fill="#1e1b4b"/>
                        <!-- Eyes & Cute Expression -->
                        <circle cx="58" cy="53" r="2.5" fill="#1e1b4b"/>
                        <circle cx="70" cy="53" r="2.5" fill="#1e1b4b"/>
                        <path d="M62 60 Q64 63 66 60" stroke="#ea580c" stroke-width="1.5" stroke-linecap="round"/>
                        <!-- Headband / Hat Detail -->
                        <path d="M46 38 Q64 32 82 38" stroke="#f97316" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </div>

                <!-- 4. Cute Little Companion Robot -->
                <div class="character-robot">
                    <svg viewBox="0 0 60 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Feet -->
                        <ellipse cx="20" cy="70" rx="8" ry="4" fill="#3b82f6"/>
                        <ellipse cx="40" cy="70" rx="8" ry="4" fill="#3b82f6"/>
                        <!-- Body -->
                        <rect x="14" y="44" width="32" height="24" rx="8" fill="#e2e8f0"/>
                        <rect x="22" y="50" width="16" height="12" rx="4" fill="#6366f1"/>
                        <circle cx="30" cy="56" r="3" fill="#fee75c"/>
                        <!-- Head -->
                        <rect x="10" y="16" width="40" height="26" rx="8" fill="#e2e8f0"/>
                        <rect x="15" y="20" width="30" height="18" rx="5" fill="#1e1b4b"/>
                        <!-- Glowing Eyes -->
                        <circle cx="23" cy="29" r="3" fill="#57f287"/>
                        <circle cx="37" cy="29" r="3" fill="#57f287"/>
                        <!-- Antenna -->
                        <rect x="28" y="6" width="4" height="10" fill="#94a3b8"/>
                        <circle cx="30" cy="5" r="4" fill="#f43f5e"/>
                    </svg>
                </div>

                <!-- 5. 3D Gamepad Controller (Center Foreground) -->
                <div class="prop-controller">
                    <svg viewBox="0 0 130 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 25 Q40 18 65 22 Q90 18 108 25 Q125 35 120 62 Q115 78 95 72 Q82 68 76 52 Q65 54 54 52 Q48 68 35 72 Q15 78 10 62 Q5 35 22 25 Z" fill="url(#padGrad)" />
                        <!-- D-Pad Left -->
                        <path d="M28 36 h10 v-6 h6 v6 h10 v6 h-10 v6 h-6 v-6 h-10 Z" fill="#1e1b4b"/>
                        <!-- Action Buttons Right -->
                        <circle cx="92" cy="36" r="3" fill="#57f287"/>
                        <circle cx="102" cy="42" r="3" fill="#eb459e"/>
                        <circle cx="82" cy="42" r="3" fill="#fee75c"/>
                        <circle cx="92" cy="48" r="3" fill="#5865f2"/>
                        <!-- Glowing Joysticks -->
                        <circle cx="46" cy="48" r="8" fill="#1e1b4b"/>
                        <circle cx="46" cy="48" r="6" fill="#4338ca"/>
                        <circle cx="84" cy="48" r="8" fill="#1e1b4b"/>
                        <circle cx="84" cy="48" r="6" fill="#4338ca"/>
                        <!-- Discord Center Logo on Controller -->
                        <circle cx="65" cy="34" r="5" fill="#ffffff" opacity="0.9"/>
                        <defs>
                            <linearGradient id="padGrad" x1="10" y1="20" x2="120" y2="75" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7c3aed" />
                                <stop offset="0.5" stop-color="#5865f2" />
                                <stop offset="1" stop-color="#3b82f6" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <!-- 6. Cute Piggy Mascot in Puffy Coat -->
                <div class="character-piggy">
                    <svg viewBox="0 0 115 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Puffy White Jacket Body -->
                        <path d="M25 65 Q15 95 30 120 Q57 130 85 120 Q100 95 90 65 Q57 55 25 65 Z" fill="#e2e8f0"/>
                        <!-- Jacket Texture / Seams -->
                        <path d="M30 82 Q57 75 85 82 M32 100 Q57 94 83 100" stroke="#cbd5e1" stroke-width="2.5" stroke-linecap="round"/>
                        <!-- Little Boots -->
                        <rect x="36" y="118" width="16" height="12" rx="5" fill="#3b82f6"/>
                        <rect x="63" y="118" width="16" height="12" rx="5" fill="#3b82f6"/>
                        <!-- Piggy Head -->
                        <ellipse cx="57" cy="48" rx="26" ry="22" fill="#818cf8"/>
                        <!-- Cute Leaf on Top -->
                        <path d="M57 26 Q64 16 72 20 Q70 28 57 26 Z" fill="#34d399"/>
                        <path d="M57 26 Q52 18 46 22 Q48 29 57 26 Z" fill="#10b981"/>
                        <!-- Ears -->
                        <polygon points="36,36 42,22 48,34" fill="#6366f1"/>
                        <polygon points="78,36 72,22 66,34" fill="#6366f1"/>
                        <!-- Snout -->
                        <ellipse cx="57" cy="54" rx="10" ry="6" fill="#a5b4fc"/>
                        <circle cx="53" cy="54" r="2" fill="#312e81"/>
                        <circle cx="61" cy="54" r="2" fill="#312e81"/>
                        <!-- Happy Eyes -->
                        <path d="M44 45 Q48 40 52 45" stroke="#1e1b4b" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M62 45 Q66 40 70 45" stroke="#1e1b4b" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>

                <!-- 7. Smartphone Standing Mockup (Discord Video Call) -->
                <div class="mockup-phone">
                    <div class="phone-notch"></div>
                    <div class="phone-video-grid">
                        <!-- Friend 1 Video Tile -->
                        <div class="video-tile active-speaking">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #f43f5e; display: flex; align-items: center; justify-content: center; font-size: 11px;">👩‍🦰</div>
                            <span class="video-tile-name">Alex</span>
                        </div>
                        <!-- Friend 2 Video Tile -->
                        <div class="video-tile">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 11px;">🎧</div>
                            <span class="video-tile-name">Sarah</span>
                        </div>
                        <!-- Friend 3 Video Tile -->
                        <div class="video-tile">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #eab308; display: flex; align-items: center; justify-content: center; font-size: 11px;">😎</div>
                            <span class="video-tile-name">Leo</span>
                        </div>
                        <!-- Friend 4 Video Tile -->
                        <div class="video-tile">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: #10b981; display: flex; align-items: center; justify-content: center; font-size: 11px;">👾</div>
                            <span class="video-tile-name">Liam</span>
                        </div>
                    </div>
                    <!-- Phone Video Controls Bar -->
                    <div style="height: 24px; background: #111214; display: flex; align-items: center; justify-content: space-around; padding: 0 6px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #ed4245;"></span>
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #4e5058;"></span>
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #4e5058;"></span>
                    </div>
                </div>

                <!-- 8. Right Boy Character with Spiky Hair & Purple Coat -->
                <div class="character-right">
                    <svg viewBox="0 0 110 235" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Shadow -->
                        <ellipse cx="55" cy="228" rx="35" ry="5" fill="#0b0d26" opacity="0.6"/>
                        <!-- Legs & Sneakers -->
                        <path d="M40 145 L35 220 L48 220 L52 155 L60 155 L65 220 L78 220 L72 145 Z" fill="#1e1b4b"/>
                        <rect x="30" y="215" width="18" height="10" rx="3" fill="#ffffff"/>
                        <rect x="65" y="215" width="18" height="10" rx="3" fill="#ffffff"/>
                        <!-- Purple Streetwear Jacket -->
                        <path d="M28 85 Q18 115 28 145 L82 145 Q92 115 82 85 Z" fill="#5865f2"/>
                        <!-- Discord Badge on Jacket -->
                        <circle cx="42" cy="105" r="4" fill="#ffffff"/>
                        <!-- Head & Face -->
                        <circle cx="55" cy="52" r="16" fill="#fed7aa"/>
                        <!-- Spiky Anime Hair -->
                        <path d="M38 48 L32 30 L45 36 L52 18 L62 34 L74 24 L72 48 Q55 36 38 48 Z" fill="#1e1b4b"/>
                        <!-- Eyes & Smile -->
                        <circle cx="49" cy="52" r="2" fill="#1e1b4b"/>
                        <circle cx="61" cy="52" r="2" fill="#1e1b4b"/>
                        <path d="M52 58 Q55 61 58 58" stroke="#1e1b4b" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </section>
    </main>

    <script>
        function toggleMobileMenu() {
            const menu = document.querySelector('.nav-menu');
            if (menu) {
                if (menu.style.display === 'flex') {
                    menu.style.display = 'none';
                } else {
                    menu.style.display = 'flex';
                    menu.style.flexDirection = 'column';
                    menu.style.position = 'absolute';
                    menu.style.top = '100%';
                    menu.style.left = '0';
                    menu.style.right = '0';
                    menu.style.background = '#1e1f22';
                    menu.style.padding = '20px';
                    menu.style.boxShadow = '0 10px 30px rgba(0,0,0,0.7)';
                }
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discord - Friends</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg-servers: #1E1F22;
            --bg-sidebar: #2B2D31;
            --bg-main: #313338;
            --bg-user-bar: #232428;
            --bg-search: #1E1F22;
            --brand-primary: #5865F2;
            --brand-hover: #4752C4;
            --brand-active: #3C45A5;
            --green-active: #23A55A;
            --red-status: #F23F43;
            --text-normal: #DBDEE1;
            --text-heading: #F2F3F5;
            --text-muted: #949BA4;
            --text-interactive: #B5BAC1;
            --channel-hover: rgba(255, 255, 255, 0.05);
            --channel-active: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-servers);
            color: var(--text-normal);
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
        }

        /* 1. Server List Bar (Far Left) */
        .server-sidebar {
            width: 72px;
            background-color: var(--bg-servers);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px 0;
            gap: 8px;
            flex-shrink: 0;
            user-select: none;
            overflow-y: auto;
        }

        .server-sidebar::-webkit-scrollbar {
            display: none;
        }

        .server-pill-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .server-icon {
            width: 48px;
            height: 48px;
            border-radius: 24px;
            background-color: var(--bg-main);
            color: var(--text-heading);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
        }

        .server-icon.active,
        .server-icon:hover {
            border-radius: 16px;
            background-color: var(--brand-primary);
            color: #ffffff;
        }

        .server-icon.green-hover:hover {
            background-color: var(--green-active);
        }

        .server-pill {
            position: absolute;
            left: 0;
            width: 4px;
            height: 40px;
            background-color: #ffffff;
            border-radius: 0 4px 4px 0;
            transition: height 0.2s ease;
        }

        .server-divider {
            width: 32px;
            height: 2px;
            background-color: #35363c;
            border-radius: 1px;
            margin: 4px 0;
        }

        /* 2. Direct Messages & Channels Sidebar */
        .channel-sidebar {
            width: 240px;
            background-color: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: relative;
        }

        .search-container {
            padding: 10px;
            height: 48px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .search-btn {
            width: 100%;
            height: 28px;
            background-color: var(--bg-search);
            color: var(--text-muted);
            border: none;
            border-radius: 4px;
            padding: 0 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            cursor: pointer;
            font-family: inherit;
        }

        .channels-nav {
            flex: 1;
            padding: 8px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 10px 12px;
            border-radius: 4px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }

        .nav-item:hover {
            background-color: var(--channel-hover);
            color: var(--text-interactive);
        }

        .nav-item.active {
            background-color: var(--channel-active);
            color: var(--text-heading);
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background-color: var(--brand-primary);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .dm-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 8px 4px 10px;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            user-select: none;
        }

        .dm-header:hover {
            color: var(--text-interactive);
        }

        .dm-skeleton {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px;
            border-radius: 4px;
            opacity: 0.45;
            cursor: default;
        }

        .dm-skeleton-avatar {
            width: 32px;
            height: 32px;
            border-radius: 16px;
            background-color: #35373c;
        }

        .dm-skeleton-text {
            height: 12px;
            border-radius: 6px;
            background-color: #35373c;
            width: 100px;
        }

        /* Bottom User Control Bar */
        .user-control-bar {
            height: 52px;
            background-color: var(--bg-user-bar);
            padding: 0 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
        }

        .user-profile-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.15s;
            max-width: 125px;
        }

        .user-profile-info:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }

        .user-avatar-wrap {
            position: relative;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        .user-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5865F2, #854CE6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 14px;
        }

        .user-status-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--green-active);
            border: 2px solid var(--bg-user-bar);
        }

        .user-text-details {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            line-height: 1.2;
        }

        .user-display-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-heading);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-status-text {
            font-size: 11px;
            color: var(--text-muted);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .control-btn {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-interactive);
            cursor: pointer;
            border: none;
            background: transparent;
            transition: all 0.15s;
        }

        .control-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-heading);
        }

        .logout-action-btn {
            color: #f23f43;
        }

        .logout-action-btn:hover {
            background-color: rgba(242, 63, 67, 0.15);
            color: #ff6b6e;
        }

        /* 3. Main Dashboard Workspace */
        .main-workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-main);
            height: 100vh;
            overflow: hidden;
        }

        /* Top Header Navbar */
        .workspace-header {
            height: 48px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            user-select: none;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-title-group {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--text-heading);
            font-size: 15px;
            padding-right: 16px;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-tabs {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-link {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-interactive);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .tab-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text-heading);
        }

        .tab-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-heading);
        }

        .tab-link.add-friend-btn {
            background-color: var(--brand-primary);
            color: #ffffff;
            font-weight: 600;
            padding: 4px 10px;
        }

        .tab-link.add-friend-btn:hover {
            background-color: var(--brand-hover);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
            color: var(--text-interactive);
        }

        .header-icon {
            cursor: pointer;
            transition: color 0.15s;
        }

        .header-icon:hover {
            color: var(--text-heading);
        }

        /* Workspace Content Body */
        .workspace-body {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        /* Center Content Area */
        .friends-center-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            user-select: none;
        }

        .empty-illustration {
            width: 280px;
            height: 160px;
            margin-bottom: 24px;
            opacity: 0.85;
        }

        .empty-friends-text {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 400;
        }

        /* Right Sidebar ("Active Now") */
        .active-now-sidebar {
            width: 360px;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            user-select: none;
        }

        @media (max-width: 1024px) {
            .active-now-sidebar {
                display: none;
            }
        }

        .active-now-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-heading);
            margin-bottom: 16px;
        }

        .active-now-card {
            background-color: var(--bg-sidebar);
            border-radius: 8px;
            padding: 24px 16px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .active-now-heading {
            color: var(--text-heading);
            font-size: 15px;
            font-weight: 700;
        }

        .active-now-desc {
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.45;
        }

        /* Top Header Logout Quick Button */
        .header-logout-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            background-color: rgba(242, 63, 67, 0.1);
            color: #ff787b;
            border: 1px solid rgba(242, 63, 67, 0.3);
            border-radius: 4px;
            padding: 4px 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            font-family: inherit;
        }

        .header-logout-pill:hover {
            background-color: var(--red-status);
            color: #ffffff;
            border-color: var(--red-status);
        }
    </style>
</head>
<body>
    <!-- 1. Leftmost Server Sidebar -->
    <nav class="server-sidebar" aria-label="Servers">
        <!-- Direct Messages Home Pill -->
        <div class="server-pill-container">
            <div class="server-pill"></div>
            <a href="{{ route('dashboard') }}" class="server-icon active" title="Direct Messages">
                <!-- Discord Mascot Logo -->
                <svg width="28" height="20" viewBox="0 0 127.14 96.36" fill="currentColor">
                    <path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,45.91,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,45.91,96.12,53,91.08,65.69,84.69,65.69Z"/>
                </svg>
            </a>
        </div>

        <div class="server-divider"></div>

        <!-- Server: x.c -->
        <div class="server-pill-container">
            <div class="server-icon" title="x.c server">
                <span>x.c</span>
            </div>
        </div>

        <!-- Add a Server '+' -->
        <div class="server-pill-container">
            <div class="server-icon green-hover" title="Add a Server">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>
        </div>

        <!-- Explore Discoverable Servers -->
        <div class="server-pill-container">
            <div class="server-icon green-hover" title="Explore Discoverable Servers">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                </svg>
            </div>
        </div>

        <!-- Download Apps -->
        <div class="server-pill-container">
            <div class="server-icon green-hover" title="Download Apps">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
            </div>
        </div>
    </nav>

    <!-- 2. Direct Messages & Sub-Navigation Sidebar -->
    <aside class="channel-sidebar">
        <!-- Search top -->
        <div class="search-container">
            <button class="search-btn" type="button">
                Find or start a conversation
            </button>
        </div>

        <!-- Navigation items -->
        <nav class="channels-nav">
            <!-- Friends (Active) -->
            <a href="#" class="nav-item active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Friends</span>
            </a>

            <!-- Nitro -->
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span>Nitro</span>
            </a>

            <!-- Shop (With NEW badge) -->
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span>Shop</span>
                <span class="nav-badge">NEW</span>
            </a>

            <!-- Quests -->
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <span>Quests</span>
            </a>

            <!-- Direct Messages Header -->
            <div class="dm-header">
                <span>Direct Messages</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="cursor: pointer;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>

            <!-- Direct message placeholder skeletons -->
            @for ($i = 0; $i < 7; $i++)
                <div class="dm-skeleton">
                    <div class="dm-skeleton-avatar"></div>
                    <div class="dm-skeleton-text"></div>
                </div>
            @endfor
        </nav>

        <!-- Bottom User Control / Profile Bar -->
        <div class="user-control-bar">
            <!-- User Info -->
            <div class="user-profile-info" title="{{ Auth::user()->email ?? 'user@discord.com' }}">
                <div class="user-avatar-wrap">
                    <div class="user-avatar-img">
                        {{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 1)) }}
                    </div>
                    <div class="user-status-dot"></div>
                </div>
                <div class="user-text-details">
                    <span class="user-display-name">{{ Auth::user()->name ?? 'Robin' }}</span>
                    <span class="user-status-text">Online</span>
                </div>
            </div>

            <!-- User Quick Controls & Logout Button -->
            <div class="user-actions">
                <!-- Mute -->
                <button class="control-btn" title="Mute" type="button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                        <line x1="12" y1="19" x2="12" y2="23"></line>
                        <line x1="8" y1="23" x2="16" y2="23"></line>
                    </svg>
                </button>

                <!-- Deafen -->
                <button class="control-btn" title="Deafen" type="button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                        <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                    </svg>
                </button>

                <!-- Logout Form Button -->
                <form action="{{ route('logout') }}" method="{{ Route::has('logout') ? 'POST' : 'GET' }}" style="display: inline; margin: 0;">
                    @csrf
                    <button type="submit" class="control-btn logout-action-btn" title="Log Out">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- 3. Main Workspace Area -->
    <main class="main-workspace">
        <!-- Top Workspace Header -->
        <header class="workspace-header">
            <div class="header-left">
                <!-- Friends Icon & Title -->
                <div class="header-title-group">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Friends</span>
                </div>

                <!-- Tabs: Online, All, Pending, Blocked, Add Friend -->
                <nav class="header-tabs">
                    <a href="#" class="tab-link">Online</a>
                    <a href="#" class="tab-link active">All</a>
                    <a href="#" class="tab-link">Pending</a>
                    <a href="#" class="tab-link">Blocked</a>
                    <a href="#" class="tab-link add-friend-btn">Add Friend</a>
                </nav>
            </div>

            <div class="header-right">
                <!-- Direct Logout Header Button -->
                <form action="{{ route('logout') }}" method="{{ Route::has('logout') ? 'POST' : 'GET' }}" style="display: inline; margin: 0;">
                    @csrf
                    <button type="submit" class="header-logout-pill">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>

                <!-- New Group DM Icon -->
                <div class="header-icon" title="New Group DM">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>

                <!-- Inbox -->
                <div class="header-icon" title="Inbox">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                    </svg>
                </div>

                <!-- Help -->
                <div class="header-icon" title="Help">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
        </header>

        <!-- Body: Center Area + Active Now Right Column -->
        <div class="workspace-body">
            <!-- Center Empty State -->
            <section class="friends-center-area">
                <!-- Wumpus / Empty State SVG -->
                <svg class="empty-illustration" viewBox="0 0 300 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="150" cy="90" r="55" fill="#2B2D31"/>
                    <path d="M130 90C130 84.4772 134.477 80 140 80H160C165.523 80 170 84.4772 170 90V105H130V90Z" fill="#35373C"/>
                    <circle cx="142" cy="88" r="3" fill="#80848E"/>
                    <circle cx="158" cy="88" r="3" fill="#80848E"/>
                    <path d="M145 98C148 100 152 100 155 98" stroke="#80848E" stroke-width="2" stroke-linecap="round"/>
                    <ellipse cx="150" cy="148" rx="65" ry="8" fill="#232428"/>
                </svg>

                <p class="empty-friends-text">
                    There are no friends online at this time. Check back later!
                </p>
            </section>

            <!-- Right Sidebar: Active Now -->
            <aside class="active-now-sidebar">
                <h2 class="active-now-title">Active Now</h2>
                <div class="active-now-card">
                    <h3 class="active-now-heading">It's quiet for now...</h3>
                    <p class="active-now-desc">
                        When a friend starts an activity – like playing a game or hanging out on voice – we'll show it here!
                    </p>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
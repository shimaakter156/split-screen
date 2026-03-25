<!doctype html>
<html lang="en">

<head>
    <title>SplitScreen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        :root {
            --bg: #0a0a0f;
            --surface: #13131a;
            --surface2: #1c1c28;
            --border: #2a2a3d;
            --accent: #6c63ff;
            --accent2: #ff6584;
            --accent3: #43e97b;
            --yellow: #f7c948;
            --text: #e8e8f0;
            --muted: #6b6b8a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(108, 99, 255, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(255, 101, 132, 0.06) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* ======== FORM SCREEN ======== */
        #formScreen {
            position: relative;
            z-index: 1;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            overflow-y: auto;
        }

        .form-card {
            width: 100%;
            max-width: 580px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 0 80px rgba(108, 99, 255, 0.1), 0 40px 80px rgba(0, 0, 0, 0.4);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            margin-bottom: 36px;
            text-align: center;
        }

        .form-header .badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            font-family: 'Space Mono', monospace;
            font-size: 10px;
            letter-spacing: 2px;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .form-header h1 {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .supported-types {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .type-chip {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-family: 'Space Mono', monospace;
        }

        .type-chip.web {
            background: rgba(108, 99, 255, 0.15);
            color: var(--accent);
            border: 1px solid rgba(108, 99, 255, 0.3);
        }

        .type-chip.yt {
            background: rgba(255, 0, 0, 0.15);
            color: #ff4444;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }

        .type-chip.gdrive {
            background: rgba(247, 201, 72, 0.15);
            color: var(--yellow);
            border: 1px solid rgba(247, 201, 72, 0.3);
        }

        .link-input-group {
            margin-bottom: 14px;
        }

        .link-input-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .link-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 700;
        }

        .link-input-group input {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 13px 16px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .link-input-group input::placeholder {
            color: var(--muted);
        }

        .link-input-group.g1 input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.2);
        }

        .link-input-group.g2 input:focus {
            border-color: var(--accent2);
            box-shadow: 0 0 0 3px rgba(255, 101, 132, 0.2);
        }

        .link-input-group.g3 input:focus {
            border-color: var(--accent3);
            box-shadow: 0 0 0 3px rgba(67, 233, 123, 0.2);
        }

        .link-input-group.g4 input:focus {
            border-color: var(--yellow);
            box-shadow: 0 0 0 3px rgba(247, 201, 72, 0.2);
        }

        .type-badge {
            display: none;
            margin-top: 6px;
            font-size: 11px;
            font-family: 'Space Mono', monospace;
            padding: 3px 10px;
            border-radius: 20px;
            width: fit-content;
        }

        .type-badge.web {
            background: rgba(108, 99, 255, 0.15);
            color: var(--accent);
            border: 1px solid rgba(108, 99, 255, 0.3);
        }

        .type-badge.yt {
            background: rgba(255, 0, 0, 0.15);
            color: #ff4444;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }

        .type-badge.gdrive {
            background: rgba(247, 201, 72, 0.15);
            color: var(--yellow);
            border: 1px solid rgba(247, 201, 72, 0.3);
        }

        .error-msg {
            color: var(--accent2);
            font-size: 11px;
            margin-top: 5px;
            display: none;
            font-family: 'Space Mono', monospace;
        }

        .submit-btn {
            width: 100%;
            margin-top: 28px;
            padding: 15px;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            border: none;
            border-radius: 12px;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(108, 99, 255, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(108, 99, 255, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* ======== VIEWER SCREEN ======== */
        #iframeScreen {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100;
            flex-direction: column;
            background: #000;
        }

        #iframeScreen.active {
            display: flex;
        }

        .viewer-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            height: 48px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            gap: 10px;
            z-index: 10;
        }

        .brand {
            font-family: 'Space Mono', monospace;
            font-size: 13px;
            color: var(--accent);
            font-weight: 700;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .tab-pills {
            display: flex;
            gap: 5px;
            flex: 1;
            justify-content: center;
            overflow-x: auto;
        }

        .tab-pill {
            padding: 5px 13px;
            border-radius: 20px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tab-pill:hover {
            border-color: var(--accent);
            color: var(--text);
        }

        .tab-pill.active {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
            font-weight: 600;
        }

        .tab-pill.t2.active {
            background: var(--accent2);
            border-color: var(--accent2);
        }

        .tab-pill.t3.active {
            background: var(--accent3);
            border-color: var(--accent3);
            color: #000;
        }

        .tab-pill.t4.active {
            background: var(--yellow);
            border-color: var(--yellow);
            color: #000;
        }

        .tab-pill.tg.active {
            border-color: var(--accent);
            color: var(--accent);
            background: transparent;
        }

        .back-btn {
            padding: 6px 14px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .back-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ---- IFRAME BODY ---- */
        .iframe-body {
            flex: 1;
            overflow: hidden;
            position: relative;
            background: #000;
        }

        /* ---- GRID VIEW: no gap, no labels, iframes fill 100% ---- */
        #gridView {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0;
            padding: 0;
            height: 100%;
            background: #000;
        }

        #gridView .iframe-panel {
            position: relative;
            overflow: hidden;
            border-radius: 0;
            border: none;
            background: #000;
        }

        /* No label bar in grid */
        #gridView .iframe-panel-label {
            display: none;
        }

        #gridView .iframe-panel iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: none;
            display: none;
        }

        #gridView .iframe-loading {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            background: #000;
            color: var(--muted);
            font-size: 12px;
            font-family: 'Space Mono', monospace;
            z-index: 2;
        }

        #gridView .iframe-fallback {
            display: none;
            position: absolute;
            inset: 0;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 30px;
            text-align: center;
            background: var(--surface2);
        }

        /* ---- SINGLE VIEW ---- */
        #singleView {
            display: none;
            height: 100%;
            flex-direction: column;
        }

        #singleView .iframe-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: #000;
            display: flex;
            flex-direction: column;
        }

        #singleView .iframe-panel-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            font-size: 11px;
            font-family: 'Space Mono', monospace;
            color: var(--muted);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            height: 28px;
        }

        #singleView .iframe-panel iframe {
            position: absolute;
            inset: 28px 0 0 0;
            width: 100%;
            height: calc(100% - 28px);
            border: none;
            display: none;
        }

        #singleView .iframe-loading {
            position: absolute;
            inset: 28px 0 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            background: #000;
            color: var(--muted);
            font-size: 12px;
            font-family: 'Space Mono', monospace;
            z-index: 2;
        }

        #singleView .iframe-fallback {
            display: none;
            position: absolute;
            inset: 28px 0 0 0;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 30px;
            text-align: center;
            background: var(--surface2);
        }

        /* ---- SHARED ---- */
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .d1 {
            background: var(--accent);
        }

        .d2 {
            background: var(--accent2);
        }

        .d3 {
            background: var(--accent3);
        }

        .d4 {
            background: var(--yellow);
        }

        .spinner {
            width: 24px;
            height: 24px;
            border: 2px solid #333;
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .fallback-icon {
            font-size: 40px;
        }

        .fallback-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .fallback-desc {
            font-size: 12px;
            color: var(--muted);
            max-width: 240px;
            line-height: 1.6;
        }

        .open-btn {
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
            box-shadow: 0 4px 16px rgba(108, 99, 255, 0.4);
        }

        .open-btn:hover {
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>

<body>

    {{-- ======== FORM SCREEN ======== --}}
    <div id="formScreen">
        <div class="form-card">
            <div class="form-header">
                <div class="badge">✦ SplitScreen</div>
                <h1>SplitScreen</h1>
                <p>Paste any URL — auto detected instantly</p>
                <div class="supported-types">
                    <span class="type-chip web">🌐 Website</span>
                    <span class="type-chip yt">▶️ YouTube</span>
                    <span class="type-chip gdrive">📁 Google Drive</span>
                </div>
            </div>

            <form id="linkForm" novalidate>
                @csrf

                <div class="link-input-group g1">
                    <label><span class="link-num" style="background:var(--accent);color:white">1</span> Link One</label>
                    <input type="text" id="link1" placeholder="Paste any URL here..." autocomplete="off">
                    <div class="type-badge" id="badge1"></div>
                    <p class="error-msg" id="err1">⚠ Please enter a valid URL starting with https://</p>
                </div>

                <div class="link-input-group g2">
                    <label><span class="link-num" style="background:var(--accent2);color:white">2</span> Link
                        Two</label>
                    <input type="text" id="link2" placeholder="Paste any URL here..." autocomplete="off">
                    <div class="type-badge" id="badge2"></div>
                    <p class="error-msg" id="err2">⚠ Please enter a valid URL starting with https://</p>
                </div>

                <div class="link-input-group g3">
                    <label><span class="link-num" style="background:var(--accent3);color:#000">3</span> Link
                        Three</label>
                    <input type="text" id="link3" placeholder="Paste any URL here..." autocomplete="off">
                    <div class="type-badge" id="badge3"></div>
                    <p class="error-msg" id="err3">⚠ Please enter a valid URL starting with https://</p>
                </div>

                <div class="link-input-group g4">
                    <label><span class="link-num" style="background:var(--yellow);color:#000">4</span> Link Four</label>
                    <input type="text" id="link4" placeholder="Paste any URL here..." autocomplete="off">
                    <div class="type-badge" id="badge4"></div>
                    <p class="error-msg" id="err4">⚠ Please enter a valid URL starting with https://</p>
                </div>

                <button type="submit" class="submit-btn">✦ Launch SplitScreen</button>
            </form>
        </div>
    </div>

    {{-- ======== VIEWER SCREEN ======== --}}
    <div id="iframeScreen">
        <div class="viewer-topbar">
            <div class="brand">SPLITSCREEN</div>
            <div class="tab-pills">
                <button class="tab-pill tg active" id="tabGrid" onclick="switchTab('grid')">⊞ Grid</button>
                <button class="tab-pill t1" id="tab0" onclick="switchTab(0)"><span id="tabIcon0">🌐</span> Link
                    1</button>
                <button class="tab-pill t2" id="tab1" onclick="switchTab(1)"><span id="tabIcon1">🌐</span> Link
                    2</button>
                <button class="tab-pill t3" id="tab2" onclick="switchTab(2)"><span id="tabIcon2">🌐</span> Link
                    3</button>
                <button class="tab-pill t4" id="tab3" onclick="switchTab(3)"><span id="tabIcon3">🌐</span> Link
                    4</button>
            </div>
            <button class="back-btn" onclick="goBack()">← Back</button>
        </div>

        <div class="iframe-body">

            {{-- GRID VIEW: labels hidden, iframes fill 100% --}}
            <div id="gridView">
                <div class="iframe-panel">
                    <div class="iframe-panel-label"><span class="dot d1"></span> Link 1</div>
                    <div class="iframe-loading" id="loading0">
                        <div class="spinner"></div>Loading...
                    </div>
                    <iframe id="webFrame0" src="" allow="autoplay; fullscreen"></iframe>
                    <div class="iframe-fallback" id="fallback0">
                        <div class="fallback-icon">🔒</div>
                        <div class="fallback-title">This site blocks embedding</div>
                        <div class="fallback-desc">This website prevents being shown inside another page.</div>
                        <a class="open-btn" id="openBtn0" href="#" target="_self">Open in This Tab →</a>
                    </div>
                </div>
                <div class="iframe-panel">
                    <div class="iframe-panel-label"><span class="dot d2"></span> Link 2</div>
                    <div class="iframe-loading" id="loading1">
                        <div class="spinner"></div>Loading...
                    </div>
                    <iframe id="webFrame1" src="" allow="autoplay; fullscreen"></iframe>
                    <div class="iframe-fallback" id="fallback1">
                        <div class="fallback-icon">🔒</div>
                        <div class="fallback-title">This site blocks embedding</div>
                        <div class="fallback-desc">This website prevents being shown inside another page.</div>
                        <a class="open-btn" id="openBtn1" href="#" target="_self">Open in This Tab →</a>
                    </div>
                </div>
                <div class="iframe-panel">
                    <div class="iframe-panel-label"><span class="dot d3"></span> Link 3</div>
                    <div class="iframe-loading" id="loading2">
                        <div class="spinner"></div>Loading...
                    </div>
                    <iframe id="webFrame2" src="" allow="autoplay; fullscreen"></iframe>
                    <div class="iframe-fallback" id="fallback2">
                        <div class="fallback-icon">🔒</div>
                        <div class="fallback-title">This site blocks embedding</div>
                        <div class="fallback-desc">This website prevents being shown inside another page.</div>
                        <a class="open-btn" id="openBtn2" href="#" target="_self">Open in This Tab →</a>
                    </div>
                </div>
                <div class="iframe-panel">
                    <div class="iframe-panel-label"><span class="dot d4"></span> Link 4</div>
                    <div class="iframe-loading" id="loading3">
                        <div class="spinner"></div>Loading...
                    </div>
                    <iframe id="webFrame3" src="" allow="autoplay; fullscreen"></iframe>
                    <div class="iframe-fallback" id="fallback3">
                        <div class="fallback-icon">🔒</div>
                        <div class="fallback-title">This site blocks embedding</div>
                        <div class="fallback-desc">This website prevents being shown inside another page.</div>
                        <a class="open-btn" id="openBtn3" href="#" target="_self">Open in This Tab →</a>
                    </div>
                </div>
            </div>

            {{-- SINGLE VIEW --}}
            <div id="singleView">
                <div class="iframe-panel">
                    <div class="iframe-panel-label"><span class="dot" id="singleDot"></span><span
                            id="singleLabel">Link</span></div>
                    <div class="iframe-loading" id="loadingSingle">
                        <div class="spinner"></div>Loading...
                    </div>
                    <iframe id="webFrameSingle" src="" allow="autoplay; fullscreen"></iframe>
                    <div class="iframe-fallback" id="fallbackSingle">
                        <div class="fallback-icon">🔒</div>
                        <div class="fallback-title">This site blocks embedding</div>
                        <div class="fallback-desc">This website prevents being shown inside another page.</div>
                        <a class="open-btn" id="openBtnSingle" href="#" target="_self">Open in This Tab →</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let links = ['', '', '', ''];
        let types = ['web', 'web', 'web', 'web'];
        const dotClasses = ['d1', 'd2', 'd3', 'd4'];

        function detectType(url) {
            if (!url) return 'web';
            if (/youtube\.com\/watch|youtu\.be\/|youtube\.com\/embed/i.test(url)) return 'youtube';
            if (/drive\.google\.com\/file\/d\//i.test(url)) return 'gdrive';
            return 'web';
        }

        function getEmbedUrl(url, type) {
            if (type === 'youtube') {
                let match = url.match(/[?&]v=([^&#]+)/) || url.match(/youtu\.be\/([^?&#]+)/);
                return match ? 'https://www.youtube.com/embed/' + match[1] : url;
            }
            if (type === 'gdrive') {
                let match = url.match(/drive\.google\.com\/file\/d\/([^\/]+)/);
                return match ? 'https://drive.google.com/file/d/' + match[1] + '/preview' : url;
            }
            return url;
        }

        function getTypeIcon(type) {
            return { web: '🌐', youtube: '▶️', gdrive: '📁' }[type] || '🌐';
        }

        function getTypeBadgeText(type) {
            return { web: '🌐 Website', youtube: '▶️ YouTube', gdrive: '📁 Google Drive' }[type] || '🌐 Website';
        }

        function getBadgeClass(type) {
            return { web: 'web', youtube: 'yt', gdrive: 'gdrive' }[type] || 'web';
        }

        function isValidUrl(str) {
            try {
                let url = new URL(str);
                return url.protocol === 'http:' || url.protocol === 'https:';
            } catch { return false; }
        }

        // Live detection
        for (let i = 1; i <= 4; i++) {
            (function (idx) {
                $('#link' + idx).on('input', function () {
                    let val = $(this).val().trim();
                    $('#err' + idx).hide();
                    let $badge = $('#badge' + idx);
                    if (val && isValidUrl(val)) {
                        let t = detectType(val);
                        $badge.attr('class', 'type-badge ' + getBadgeClass(t));
                        $badge.text(getTypeBadgeText(t)).show();
                    } else {
                        $badge.hide();
                    }
                });
            })(i);
        }

        // Form submit
        $('#linkForm').on('submit', function (e) {
            e.preventDefault();
            let valid = true;
            for (let i = 0; i < 4; i++) {
                let val = $('#link' + (i + 1)).val().trim();
                if (!val || !isValidUrl(val)) {
                    $('#err' + (i + 1)).show();
                    valid = false;
                } else {
                    $('#err' + (i + 1)).hide();
                    links[i] = val;
                    types[i] = detectType(val);
                    $('#tabIcon' + i).text(getTypeIcon(types[i]));
                }
            }
            if (!valid) return;

            for (let i = 0; i < 4; i++) loadPanel(i, links[i], types[i], false);

            switchTab('grid');
            $('#formScreen').hide();
            $('#iframeScreen').addClass('active').css('display', 'flex');
        });

        // Load panel
        function loadPanel(idx, url, type, isSingle) {
            let s = isSingle ? 'Single' : idx;
            let $web = $('#webFrame' + s);
            let $loading = $('#loading' + s);
            let $fallback = $('#fallback' + s);
            let $openBtn = $('#openBtn' + s);

            $web.hide().attr('src', '');
            $fallback.hide().css('display', 'none');
            $loading.show();
            $openBtn.attr('href', url);

            if (isSingle) {
                $('#singleDot').attr('class', 'dot ' + dotClasses[idx]);
                $('#singleLabel').text('Link ' + (idx + 1));
            }

            let embedUrl = getEmbedUrl(url, type);

            if (type === 'youtube' || type === 'gdrive') {
                $web.attr('src', embedUrl).show();
                $web.off('load').on('load', function () { $loading.fadeOut(200); });
                setTimeout(function () { $loading.fadeOut(200); }, 4000);
            } else {
                $web.attr('src', url).show();
                $web.off('load').on('load', function () {
                    $loading.fadeOut(200);
                    try {
                        let doc = this.contentDocument || this.contentWindow.document;
                        if (!doc || !doc.body || doc.body.innerHTML.trim() === '') {
                            showFallback($web, $fallback, $loading);
                        }
                    } catch (e) { $loading.fadeOut(200); }
                });
                setTimeout(function () {
                    if ($loading.is(':visible')) {
                        try {
                            let doc = $web[0].contentDocument || $web[0].contentWindow.document;
                            if (!doc || !doc.body || doc.body.innerHTML.trim() === '') {
                                showFallback($web, $fallback, $loading);
                            } else { $loading.fadeOut(200); }
                        } catch (e) { $loading.fadeOut(200); }
                    }
                }, 5000);
            }
        }

        function showFallback($web, $fallback, $loading) {
            $loading.hide();
            $web.hide();
            $fallback.css('display', 'flex');
        }

        function switchTab(idx) {
            $('.tab-pill').removeClass('active');
            if (idx === 'grid') {
                $('#tabGrid').addClass('active');
                $('#gridView').show();
                $('#singleView').hide().css('display', 'none');
            } else {
                $('#tab' + idx).addClass('active');
                $('#gridView').hide();
                $('#singleView').show().css('display', 'flex');
                loadPanel(idx, links[idx], types[idx], true);
            }
        }

        function goBack() {
            $('iframe').attr('src', '');
            $('#iframeScreen').removeClass('active').hide();
            $('#formScreen').show();
        }
    </script>

</body>

</html>
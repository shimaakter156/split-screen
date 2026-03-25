<!doctype html>
<html lang="en">
<head>
    <title>Split Screen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
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
            --glow: rgba(108,99,255,0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(108,99,255,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(255,101,132,0.06) 0%, transparent 50%);
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
            max-width: 540px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 0 80px rgba(108,99,255,0.1), 0 40px 80px rgba(0,0,0,0.4);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-header { margin-bottom: 36px; text-align: center; }

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
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .form-header p { color: var(--muted); font-size: 14px; font-weight: 300; }

        .link-input-group { margin-bottom: 16px; }

        .link-input-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .link-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px; height: 20px;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 700;
            color: white;
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

        .link-input-group input::placeholder { color: var(--muted); }
        .link-input-group.g1 input:focus { border-color: var(--accent);  box-shadow: 0 0 0 3px rgba(108,99,255,0.2); }
        .link-input-group.g2 input:focus { border-color: var(--accent2); box-shadow: 0 0 0 3px rgba(255,101,132,0.2); }
        .link-input-group.g3 input:focus { border-color: var(--accent3); box-shadow: 0 0 0 3px rgba(67,233,123,0.2); }
        .link-input-group.g4 input:focus { border-color: var(--yellow);  box-shadow: 0 0 0 3px rgba(247,201,72,0.2); }

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
            box-shadow: 0 4px 20px rgba(108,99,255,0.4);
        }

        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(108,99,255,0.5); }
        .submit-btn:active { transform: translateY(0); }

        /* ======== IFRAME SCREEN ======== */
        #iframeScreen {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100;
            flex-direction: column;
        }

        #iframeScreen.active { display: flex; }

        /* Top Bar */
        .viewer-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            height: 52px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            gap: 10px;
        }

        .brand {
            font-family: 'Space Mono', monospace;
            font-size: 12px;
            color: var(--accent);
            font-weight: 700;
            letter-spacing: 1px;
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
        }

        .tab-pill:hover { border-color: var(--accent); color: var(--text); }
        .tab-pill.active        { background: var(--accent);  border-color: var(--accent);  color: white; font-weight: 600; }
        .tab-pill.t2.active     { background: var(--accent2); border-color: var(--accent2); }
        .tab-pill.t3.active     { background: var(--accent3); border-color: var(--accent3); color: #000; }
        .tab-pill.t4.active     { background: var(--yellow);  border-color: var(--yellow);  color: #000; }
        .tab-pill.tg.active     { border-color: var(--accent); color: var(--accent); background: transparent; }

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
        .back-btn:hover { border-color: var(--accent); color: var(--accent); }

        /* Iframe Body */
        .iframe-body {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        /* Grid View */
        #gridView {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 8px;
            padding: 8px;
            height: 100%;
        }

        /* Single View */
        #singleView {
            display: none;
            height: 100%;
            padding: 8px;
        }

        .iframe-panel {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: var(--surface2);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .iframe-panel-label {
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
        }

        .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .d1 { background: var(--accent); }
        .d2 { background: var(--accent2); }
        .d3 { background: var(--accent3); }
        .d4 { background: var(--yellow); }

        .iframe-panel iframe {
            flex: 1;
            width: 100%;
            border: none;
            background: white;
        }

        /* ---- BLOCKED FALLBACK ---- */
        .iframe-fallback {
            display: none;
            flex: 1;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 30px;
            text-align: center;
            background: var(--surface2);
        }

        .fallback-icon { font-size: 48px; }

        .fallback-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }

        .fallback-desc {
            font-size: 12px;
            color: var(--muted);
            max-width: 280px;
            line-height: 1.6;
        }

        .open-btn {
            padding: 10px 24px;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(108,99,255,0.4);
            text-decoration: none;
            display: inline-block;
        }

        .open-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(108,99,255,0.5); color: white; }

        /* Loading spinner */
        .iframe-loading {
            position: absolute;
            inset: 26px 0 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface2);
            flex-direction: column;
            gap: 10px;
            font-size: 12px;
            color: var(--muted);
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .spinner {
            width: 24px; height: 24px;
            border: 2px solid var(--border);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

{{-- ======== FORM SCREEN ======== --}}
<div id="formScreen">
    <div class="form-card">
        <div class="form-header">
            <div class="badge">⚡ Split Screen</div>
            <h1>Submit Your Links</h1>
            <p>Enter 4 URLs — view and interact with them all in one screen</p>
        </div>

        <form id="linkForm" novalidate>
            @csrf

            <div class="link-input-group g1">
                <label><span class="link-num" style="background:var(--accent)">1</span> Link One</label>
                <input type="text" id="link1" placeholder="https://your-first-link.com" autocomplete="off">
                <p class="error-msg" id="err1">⚠ Please enter a valid URL starting with http:// or https://</p>
            </div>

            <div class="link-input-group g2">
                <label><span class="link-num" style="background:var(--accent2)">2</span> Link Two</label>
                <input type="text" id="link2" placeholder="https://your-second-link.com" autocomplete="off">
                <p class="error-msg" id="err2">⚠ Please enter a valid URL starting with http:// or https://</p>
            </div>

            <div class="link-input-group g3">
                <label><span class="link-num" style="background:var(--accent3);color:#000">3</span> Link Three</label>
                <input type="text" id="link3" placeholder="https://your-third-link.com" autocomplete="off">
                <p class="error-msg" id="err3">⚠ Please enter a valid URL starting with http:// or https://</p>
            </div>

            <div class="link-input-group g4">
                <label><span class="link-num" style="background:var(--yellow);color:#000">4</span> Link Four</label>
                <input type="text" id="link4" placeholder="https://your-fourth-link.com" autocomplete="off">
                <p class="error-msg" id="err4">⚠ Please enter a valid URL starting with http:// or https://</p>
            </div>

            <button type="submit" class="submit-btn">⚡ Launch Viewer</button>
        </form>
    </div>
</div>

{{-- ======== IFRAME SCREEN ======== --}}
<div id="iframeScreen">
    <div class="viewer-topbar">
        <div class="brand">⚡ VIEWER</div>
        <div class="tab-pills">
            <button class="tab-pill tg active" id="tabGrid" onclick="switchTab('grid')">⊞ Grid</button>
            <button class="tab-pill t1" id="tab1" onclick="switchTab(0)">Link 1</button>
            <button class="tab-pill t2" id="tab2" onclick="switchTab(1)">Link 2</button>
            <button class="tab-pill t3" id="tab3" onclick="switchTab(2)">Link 3</button>
            <button class="tab-pill t4" id="tab4" onclick="switchTab(3)">Link 4</button>
        </div>
        <button class="back-btn" onclick="goBack()">← Back</button>
    </div>

    <div class="iframe-body">

        {{-- GRID VIEW --}}
        <div id="gridView">
            <div class="iframe-panel" id="panel0">
                <div class="iframe-panel-label"><span class="dot d1"></span> <span id="label0"  onclick="switchTab(0)">Link 1</span></div>
                <div class="iframe-loading" id="loading0"><div class="spinner"></div> Loading...</div>
                <iframe id="iframe0" src=""></iframe>
                <div class="iframe-fallback" id="fallback0">
                    <div class="fallback-icon">🔒</div>
                    <div class="fallback-title">This site blocks embedding</div>
                    <div class="fallback-desc">This website does not allow being displayed inside another page. Click below to open it directly.</div>
                    <a class="open-btn" id="openBtn0" href="#" target="_self">Open in This Tab →</a>
                </div>
            </div>
            <div class="iframe-panel" id="panel1">
                <div class="iframe-panel-label"><span class="dot d2"></span> <span id="label1"  onclick="switchTab(1)">Link 2</span></div>
                <div class="iframe-loading" id="loading1"><div class="spinner"></div> Loading...</div>
                <iframe id="iframe1" src=""></iframe>
                <div class="iframe-fallback" id="fallback1">
                    <div class="fallback-icon">🔒</div>
                    <div class="fallback-title">This site blocks embedding</div>
                    <div class="fallback-desc">This website does not allow being displayed inside another page. Click below to open it directly.</div>
                    <a class="open-btn" id="openBtn1" href="#" target="_self">Open in This Tab →</a>
                </div>
            </div>
            <div class="iframe-panel" id="panel2">
                <div class="iframe-panel-label"><span class="dot d3"></span> <span id="label2"  onclick="switchTab(2)">Link 3</span></div>
                <div class="iframe-loading" id="loading2"><div class="spinner"></div> Loading...</div>
                <iframe id="iframe2" src=""></iframe>
                <div class="iframe-fallback" id="fallback2">
                    <div class="fallback-icon">🔒</div>
                    <div class="fallback-title">This site blocks embedding</div>
                    <div class="fallback-desc">This website does not allow being displayed inside another page. Click below to open it directly.</div>
                    <a class="open-btn" id="openBtn2" href="#" target="_self">Open in This Tab →</a>
                </div>
            </div>
            <div class="iframe-panel" id="panel3">
                <div class="iframe-panel-label"><span class="dot d4"></span> <span id="label3"  onclick="switchTab(3)">Link 4</span></div>
                <div class="iframe-loading" id="loading3"><div class="spinner"></div> Loading...</div>
                <iframe id="iframe3" src=""></iframe>
                <div class="iframe-fallback" id="fallback3">
                    <div class="fallback-icon">🔒</div>
                    <div class="fallback-title">This site blocks embedding</div>
                    <div class="fallback-desc">This website does not allow being displayed inside another page. Click below to open it directly.</div>
                    <a class="open-btn" id="openBtn3" href="#" target="_self">Open in This Tab →</a>
                </div>
            </div>
        </div>

        {{-- SINGLE VIEW --}}
        <div id="singleView">
            <div class="iframe-panel" style="height:100%;">
                <div class="iframe-panel-label"><span class="dot" id="singleDot"></span> <span id="singleLabel">Link</span></div>
                <div class="iframe-loading" id="loadingSingle"><div class="spinner"></div> Loading...</div>
                <iframe id="iframeSingle" src=""></iframe>
                <div class="iframe-fallback" id="fallbackSingle">
                    <div class="fallback-icon">🔒</div>
                    <div class="fallback-title">This site blocks embedding</div>
                    <div class="fallback-desc">This website does not allow being displayed inside another page. Click below to open it directly in this tab.</div>
                    <a class="open-btn" id="openBtnSingle" href="#" target="_self">Open in This Tab →</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let links = ['', '', '', ''];
    const dotClasses = ['d1','d2','d3','d4'];
    const tabNames = ['Link 1','Link 2','Link 3','Link 4'];
    const TIMEOUT_MS = 5000; // show fallback after 5s if blank

    function isValidUrl(str) {
        try {
            let url = new URL(str);
            return url.protocol === 'http:' || url.protocol === 'https:';
        } catch { return false; }
    }

    // ---- Form Submit ----
    $('#linkForm').on('submit', function(e) {
        e.preventDefault();
        let valid = true;

        for (let i = 0; i < 4; i++) {
            let val = $('#link' + (i+1)).val().trim();
            if (!val || !isValidUrl(val)) {
                $('#err' + (i+1)).show();
                valid = false;
            } else {
                $('#err' + (i+1)).hide();
                links[i] = val;
            }
        }
        if (!valid) return;

        // Update labels & open buttons
        for (let i = 0; i < 4; i++) {
            $('#label' + i).text(links[i]);
            $('#openBtn' + i).attr('href', links[i]);
            $('#tab' + (i+1)).text('Link ' + (i+1));
        }

        loadGridIframes();

        $('#formScreen').hide();
        $('#iframeScreen').addClass('active').css('display','flex');
        switchTab('grid');
    });

    // ---- Load Iframes in Grid ----
    function loadGridIframes() {
        for (let i = 0; i < 4; i++) {
            loadIframe('iframe' + i, 'fallback' + i, 'loading' + i, links[i], '#openBtn' + i);
        }
    }

    function loadIframe(iframeId, fallbackId, loadingId, url, openBtnSelector) {
        let $iframe = $('#' + iframeId);
        let $fallback = $('#' + fallbackId);
        let $loading = $('#' + loadingId);

        // Reset
        $iframe.show().attr('src', '');
        $fallback.hide().css('display','none');
        $loading.show();
        if (openBtnSelector) $(openBtnSelector).attr('href', url);

        // Set src
        $iframe.attr('src', url);

        // Detect load
        $iframe.off('load').on('load', function() {
            $loading.fadeOut(200);
            // Try to detect if blocked (blank content)
            try {
                let doc = this.contentDocument || this.contentWindow.document;
                if (!doc || doc.body === null || doc.body.innerHTML.trim() === '') {
                    showFallback($iframe, $fallback, $loading);
                }
            } catch(err) {
                // Cross-origin: can't read content — it likely loaded fine
                $loading.fadeOut(200);
            }
        });

        // Timeout fallback — if still loading after N seconds, show fallback
        let timer = setTimeout(function() {
            try {
                let doc = $iframe[0].contentDocument || $iframe[0].contentWindow.document;
                if (!doc || doc.body === null || doc.body.innerHTML.trim() === '') {
                    showFallback($iframe, $fallback, $loading);
                } else {
                    $loading.fadeOut(200);
                }
            } catch(e) {
                // Cross-origin — assume loaded
                $loading.fadeOut(200);
            }
        }, TIMEOUT_MS);

        $iframe.data('timer', timer);
    }

    function showFallback($iframe, $fallback, $loading) {
        $loading.hide();
        $iframe.hide();
        $fallback.css('display','flex');
    }

    // ---- Tab Switch ----
    function switchTab(idx) {
        $('.tab-pill').removeClass('active');

        if (idx === 'grid') {
            $('#tabGrid').addClass('active');
            $('#gridView').show();
            $('#singleView').hide();
        } else {
            $('#tab' + (idx+1)).addClass('active');
            $('#gridView').hide();
            $('#singleView').show();

            // Update single dot color
            $('#singleDot').attr('class', 'dot ' + dotClasses[idx]);
            $('#singleLabel').text(links[idx]);
            $('#openBtnSingle').attr('href', links[idx]);

            loadIframe('iframeSingle', 'fallbackSingle', 'loadingSingle', links[idx], null);
        }
    }

    // ---- Back ----
    function goBack() {
        $('iframe').attr('src', '');
        $('#iframeScreen').removeClass('active').hide();
        $('#formScreen').show();
    }

    // Hide error on input
    for (let i = 1; i <= 4; i++) {
        $('#link' + i).on('input', function() { $('#err' + i).hide(); });
    }
</script>

</body>
</html>

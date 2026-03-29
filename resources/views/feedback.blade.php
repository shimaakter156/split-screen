<!doctype html>
<html lang="en">
<head>
    <title>SplitScreen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0a0a0f;--sur:#13131a;--sur2:#1c1c28;--brd:#2a2a3d;--a:#6c63ff;--a2:#ff6584;--a3:#43e97b;--a4:#f7c948;--tx:#e8e8f0;--mu:#6b6b8a}
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{height:100%;overflow:hidden;background:var(--bg);color:var(--tx);font-family:'DM Sans',sans-serif}

        #form{position:fixed;inset:0;z-index:20;display:flex;align-items:center;justify-content:center;padding:20px;background:var(--bg);transition:opacity .4s}
        #form.out{opacity:0;pointer-events:none}

        .card{width:100%;max-width:540px;background:var(--sur);border:1px solid var(--brd);border-radius:22px;padding:42px 38px;box-shadow:0 0 80px rgba(108,99,255,.1),0 40px 80px rgba(0,0,0,.4)}
        .hd{text-align:center;margin-bottom:28px}
        .bdg{display:inline-block;background:linear-gradient(135deg,var(--a),var(--a2));color:#fff;font-family:'Space Mono',monospace;font-size:10px;letter-spacing:2px;padding:4px 14px;border-radius:20px;margin-bottom:12px;text-transform:uppercase}
        .hd h1{font-size:27px;font-weight:700;letter-spacing:-.5px;margin-bottom:5px}
        .hd p{color:var(--mu);font-size:13px}
        .chips{display:flex;gap:7px;justify-content:center;flex-wrap:wrap;margin-top:9px}
        .chip{font-size:11px;padding:3px 10px;border-radius:20px;font-family:'Space Mono',monospace}
        .cw{background:rgba(108,99,255,.15);color:var(--a);border:1px solid rgba(108,99,255,.3)}
        .cy{background:rgba(255,0,0,.15);color:#f44;border:1px solid rgba(255,0,0,.3)}
        .cg{background:rgba(247,201,72,.15);color:var(--a4);border:1px solid rgba(247,201,72,.3)}
        .fld{margin-bottom:11px}
        .fld label{display:flex;align-items:center;gap:7px;font-family:'Space Mono',monospace;font-size:10px;color:var(--mu);letter-spacing:1px;text-transform:uppercase;margin-bottom:5px}
        .num{display:inline-flex;align-items:center;justify-content:center;width:17px;height:17px;border-radius:50%;font-size:9px;font-weight:700}
        .fld input{width:100%;background:var(--sur2);border:1px solid var(--brd);border-radius:10px;padding:11px 13px;color:var(--tx);font-family:'DM Sans',sans-serif;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s}
        .fld input::placeholder{color:var(--mu)}
        .n0 input:focus{border-color:var(--a);box-shadow:0 0 0 3px rgba(108,99,255,.2)}
        .n1 input:focus{border-color:var(--a2);box-shadow:0 0 0 3px rgba(255,101,132,.2)}
        .n2 input:focus{border-color:var(--a3);box-shadow:0 0 0 3px rgba(67,233,123,.2)}
        .n3 input:focus{border-color:var(--a4);box-shadow:0 0 0 3px rgba(247,201,72,.2)}
        .det{display:none;margin-top:4px;font-size:11px;font-family:'Space Mono',monospace;padding:2px 9px;border-radius:20px;width:fit-content}
        .dw{background:rgba(108,99,255,.15);color:var(--a);border:1px solid rgba(108,99,255,.3)}
        .dy{background:rgba(255,0,0,.15);color:#f44;border:1px solid rgba(255,0,0,.3)}
        .dg{background:rgba(247,201,72,.15);color:var(--a4);border:1px solid rgba(247,201,72,.3)}
        .err{color:var(--a2);font-size:11px;margin-top:3px;display:none;font-family:'Space Mono',monospace}
        .go{width:100%;margin-top:22px;padding:14px;background:linear-gradient(135deg,var(--a),#8b5cf6);border:none;border-radius:11px;color:#fff;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;cursor:pointer;box-shadow:0 4px 20px rgba(108,99,255,.4);transition:transform .2s,box-shadow .2s}
        .go:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(108,99,255,.5)}
        .go:active{transform:translateY(0)}

        /* GATE */
        #gate{position:fixed;inset:0;z-index:15;display:none;flex-direction:column;align-items:center;justify-content:center;gap:24px;background:var(--bg)}
        #gate.show{display:flex}
        .gt{font-family:'Space Mono',monospace;font-size:12px;color:var(--a);letter-spacing:3px;text-transform:uppercase}
        .gbars{display:flex;gap:12px}
        .gb{width:40px;height:4px;border-radius:2px;background:var(--brd);transition:background .4s}
        .gb.done{background:var(--a3)}
        .gb.loading{background:var(--a);animation:blink 1s infinite}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:.2}}
        .gcnt{font-family:'Space Mono',monospace;font-size:11px;color:var(--mu);letter-spacing:1px}
        .gready{font-family:'Space Mono',monospace;font-size:11px;color:var(--a3);letter-spacing:2px;opacity:0;transition:opacity .4s}
        .gready.show{opacity:1}

        /* VIEWER */
        #viewer{position:fixed;inset:0;z-index:10;display:flex;flex-direction:column;background:#000;opacity:0;pointer-events:none;transition:opacity .5s}
        #viewer.show{opacity:1;pointer-events:all}
        .bar{display:flex;align-items:center;height:44px;padding:0 12px;background:var(--sur);border-bottom:1px solid var(--brd);gap:8px;flex-shrink:0}
        .brand{font-family:'Space Mono',monospace;font-size:11px;color:var(--a);font-weight:700;letter-spacing:2px;white-space:nowrap}
        .tabs{display:flex;gap:4px;flex:1;justify-content:center;overflow-x:auto}
        .tab{padding:4px 11px;border-radius:20px;border:1px solid var(--brd);background:transparent;color:var(--mu);font-size:12px;font-family:'DM Sans',sans-serif;cursor:pointer;white-space:nowrap;transition:all .2s}
        .tab:hover{border-color:var(--a);color:var(--tx)}
        .tab.on.tg{border-color:var(--a);color:var(--a)}
        .tab.on.t0{background:var(--a);border-color:var(--a);color:#fff;font-weight:600}
        .tab.on.t1{background:var(--a2);border-color:var(--a2);color:#fff;font-weight:600}
        .tab.on.t2{background:var(--a3);border-color:var(--a3);color:#000;font-weight:600}
        .tab.on.t3{background:var(--a4);border-color:var(--a4);color:#000;font-weight:600}
        .bk{padding:5px 12px;background:var(--sur2);border:1px solid var(--brd);border-radius:7px;color:var(--tx);font-size:12px;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all .2s;white-space:nowrap}
        .bk:hover{border-color:var(--a);color:var(--a)}
        .area{flex:1;position:relative;overflow:hidden}

        /* GRID */
        #grid{position:absolute;inset:0;display:grid;grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr}
        .pnl{position:relative;overflow:hidden;background:#000;border:1px solid #111}
        .pnl .wrap{position:absolute;inset:0;width:100%;height:100%}
        .pnl .wrap iframe{width:100%;height:100%;border:none;display:block}
        /* YT player container */
        .pnl .wrap>div{width:100%!important;height:100%!important}
        .pnl .wrap>div iframe{width:100%!important;height:100%!important;border:none}
        .fw{display:none;position:absolute;inset:0;z-index:5;flex-direction:column;align-items:center;justify-content:center;gap:11px;padding:20px;text-align:center;background:var(--sur2)}
        .fw .fi{font-size:34px}.fw .ft{font-size:13px;font-weight:600}.fw .fd{font-size:11px;color:var(--mu);line-height:1.6}
        .fw a{padding:8px 18px;background:linear-gradient(135deg,var(--a),#8b5cf6);border-radius:8px;color:#fff;font-size:12px;font-weight:600;text-decoration:none}

        /* SINGLE */
        #single{display:none;position:absolute;inset:0;z-index:10;flex-direction:column;background:#000}
        .slbl{display:flex;align-items:center;gap:7px;height:26px;padding:0 11px;background:var(--sur);border-bottom:1px solid var(--brd);font-size:11px;font-family:'Space Mono',monospace;color:var(--mu);flex-shrink:0}
        #slot{flex:1;position:relative;overflow:hidden}
        #slot>.wrap,#slot>.fw{position:absolute!important;inset:0!important;width:100%!important;height:100%!important}
        #slot>.wrap iframe{width:100%!important;height:100%!important;border:none}
        #slot>.wrap>div{width:100%!important;height:100%!important}
        #slot>.wrap>div iframe{width:100%!important;height:100%!important;border:none}
        .dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
        .d0{background:var(--a)}.d1{background:var(--a2)}.d2{background:var(--a3)}.d3{background:var(--a4)}
    </style>
</head>
<body>

<!-- FORM -->
<div id="form">
    <div class="card">
        <div class="hd">
            <div class="bdg">✦ SplitScreen</div>
            <h1>SplitScreen</h1>
            <p>Paste any URL — auto detected instantly</p>
            <div class="chips">
                <span class="chip cw">🌐 Website</span>
                <span class="chip cy">▶️ YouTube</span>
                <span class="chip cg">📁 Google Drive</span>
            </div>
        </div>
        <div class="fld n0"><label><span class="num" style="background:var(--a);color:#fff">1</span>Link One</label>
            <input id="i0" type="text" placeholder="Paste any URL…" autocomplete="off">
            <div class="det" id="db0"></div><p class="err" id="e0">⚠ Enter a valid URL</p></div>
        <div class="fld n1"><label><span class="num" style="background:var(--a2);color:#fff">2</span>Link Two</label>
            <input id="i1" type="text" placeholder="Paste any URL…" autocomplete="off">
            <div class="det" id="db1"></div><p class="err" id="e1">⚠ Enter a valid URL</p></div>
        <div class="fld n2"><label><span class="num" style="background:var(--a3);color:#000">3</span>Link Three</label>
            <input id="i2" type="text" placeholder="Paste any URL…" autocomplete="off">
            <div class="det" id="db2"></div><p class="err" id="e2">⚠ Enter a valid URL</p></div>
        <div class="fld n3"><label><span class="num" style="background:var(--a4);color:#000">4</span>Link Four</label>
            <input id="i3" type="text" placeholder="Paste any URL…" autocomplete="off">
            <div class="det" id="db3"></div><p class="err" id="e3">⚠ Enter a valid URL</p></div>
        <button class="go" onclick="launch()">✦ Launch SplitScreen</button>
    </div>
</div>

<!-- GATE -->
<div id="gate">
    <div class="gt">Loading all panels</div>
    <div class="gbars">
        <div class="gb loading" id="gb0"></div>
        <div class="gb loading" id="gb1"></div>
        <div class="gb loading" id="gb2"></div>
        <div class="gb loading" id="gb3"></div>
    </div>
    <div class="gcnt" id="gcnt">0 / 4 ready</div>
    <div class="gready" id="gready">▶ LAUNCHING NOW</div>
</div>

<!-- VIEWER -->
<div id="viewer">
    <div class="bar">
        <div class="brand">SPLITSCREEN</div>
        <div class="tabs">
            <button class="tab tg on" id="tg" onclick="showGrid()">⊞ Grid</button>
            <button class="tab t0" id="t0" onclick="showSingle(0)"><span id="ic0">🌐</span> Link 1</button>
            <button class="tab t1" id="t1" onclick="showSingle(1)"><span id="ic1">🌐</span> Link 2</button>
            <button class="tab t2" id="t2" onclick="showSingle(2)"><span id="ic2">🌐</span> Link 3</button>
            <button class="tab t3" id="t3" onclick="showSingle(3)"><span id="ic3">🌐</span> Link 4</button>
        </div>
        <button class="bk" onclick="goBack()">← Back</button>
    </div>
    <div class="area">
        <div id="grid">
            <div class="pnl" id="p0"><div class="wrap" id="wrap0"></div><div class="fw" id="w0"><div class="fi">🔒</div><div class="ft">Blocked</div><div class="fd">This site prevents embedding.</div><a id="a0" href="#" target="_blank">Open →</a></div></div>
            <div class="pnl" id="p1"><div class="wrap" id="wrap1"></div><div class="fw" id="w1"><div class="fi">🔒</div><div class="ft">Blocked</div><div class="fd">This site prevents embedding.</div><a id="a1" href="#" target="_blank">Open →</a></div></div>
            <div class="pnl" id="p2"><div class="wrap" id="wrap2"></div><div class="fw" id="w2"><div class="fi">🔒</div><div class="ft">Blocked</div><div class="fd">This site prevents embedding.</div><a id="a2" href="#" target="_blank">Open →</a></div></div>
            <div class="pnl" id="p3"><div class="wrap" id="wrap3"></div><div class="fw" id="w3"><div class="fi">🔒</div><div class="ft">Blocked</div><div class="fd">This site prevents embedding.</div><a id="a3" href="#" target="_blank">Open →</a></div></div>
        </div>
        <div id="single">
            <div class="slbl"><span class="dot" id="sdot"></span><span id="slbl">Link</span></div>
            <div id="slot"></div>
        </div>
    </div>
</div>

<script>
    // Load YouTube IFrame API
    var ytTag = document.createElement('script');
    ytTag.src = 'https://www.youtube.com/iframe_api';
    document.head.appendChild(ytTag);

    var ytAPIReady = false;
    var pendingLaunch = null;

    function onYouTubeIframeAPIReady(){
        ytAPIReady = true;
        if(pendingLaunch) { pendingLaunch(); pendingLaunch = null; }
    }

    // State
    var panels = [null,null,null,null]; // {type, player/iframe, url}
    var readyFlags = [false,false,false,false];
    var cur = -1;

    var ICONS = {web:'🌐', youtube:'▶️', gdrive:'📁'};

    function dtype(url){
        if(/youtube\.com\/watch|youtu\.be\/|youtube\.com\/embed/i.test(url)) return 'youtube';
        if(/drive\.google\.com\/file\/d\//i.test(url)) return 'gdrive';
        return 'web';
    }
    function getVid(url){
        const m = url.match(/[?&]v=([^&#]+)/) || url.match(/youtu\.be\/([^?&#]+)/);
        return m ? m[1] : null;
    }
    function embedUrl(url, t){
        if(t === 'gdrive'){
            const m = url.match(/drive\.google\.com\/file\/d\/([^/]+)/);
            if(m) return `https://drive.google.com/file/d/${m[1]}/preview`;
        }
        return url;
    }
    function isUrl(s){try{const u=new URL(s);return u.protocol==='http:'||u.protocol==='https:'}catch{return false}}
    function bc(t){return{web:'dw',youtube:'dy',gdrive:'dg'}[t]||'dw'}
    function bt(t){return{web:'🌐 Website',youtube:'▶️ YouTube',gdrive:'📁 Google Drive'}[t]||'🌐 Website'}

    // Live detection
    for(let i=0;i<4;i++){
        document.getElementById('i'+i).addEventListener('input', function(){
            const v=this.value.trim(), db=document.getElementById('db'+i);
            document.getElementById('e'+i).style.display='none';
            if(v&&isUrl(v)){const t=dtype(v);db.className='det '+bc(t);db.textContent=bt(t);db.style.display='block'}
            else db.style.display='none';
        });
    }

    function markReady(i){
        if(readyFlags[i]) return;
        readyFlags[i] = true;
        document.getElementById('gb'+i).classList.remove('loading');
        document.getElementById('gb'+i).classList.add('done');
        const count = readyFlags.filter(Boolean).length;
        document.getElementById('gcnt').textContent = count + ' / 4 ready';
        if(count === 4) startAll();
    }

    function startAll(){
        document.getElementById('gready').classList.add('show');
        setTimeout(()=>{
            // Fire playVideo on all YouTube players simultaneously
            for(let i=0;i<4;i++){
                if(panels[i] && panels[i].type === 'youtube'){
                    try{ panels[i].player.seekTo(0); panels[i].player.playVideo(); }catch(e){}
                }
            }
            document.getElementById('gate').classList.remove('show');
            document.getElementById('viewer').classList.add('show');
            setTab('grid');
        }, 500);
    }

    function launch(){
        const vals=[], typs=[];
        let ok=true;
        for(let i=0;i<4;i++){
            const v=document.getElementById('i'+i).value.trim();
            if(!v||!isUrl(v)){document.getElementById('e'+i).style.display='block';ok=false}
            else{document.getElementById('e'+i).style.display='none';vals.push(v);typs.push(dtype(v))}
        }
        if(!ok||vals.length!==4) return;

        for(let i=0;i<4;i++){
            document.getElementById('ic'+i).textContent = ICONS[typs[i]]||'🌐';
            document.getElementById('a'+i).href = vals[i];
        }

        readyFlags=[false,false,false,false];
        document.getElementById('gate').classList.add('show');
        document.getElementById('form').classList.add('out');
        document.getElementById('gcnt').textContent='0 / 4 ready';
        document.getElementById('gready').classList.remove('show');
        for(let i=0;i<4;i++) document.getElementById('gb'+i).className='gb loading';

        function doLaunch(){
            for(let i=0;i<4;i++){
                const url=vals[i], t=typs[i];
                const wrap=document.getElementById('wrap'+i);
                wrap.innerHTML='';
                document.getElementById('w'+i).style.display='none';
                panels[i]={type:t, url:url};

                if(t === 'youtube'){
                    // Use IFrame API — load silently, play all at once later
                    const vid = getVid(url);
                    const div = document.createElement('div');
                    div.id = 'ytdiv'+i;
                    wrap.appendChild(div);
                    panels[i].player = new YT.Player('ytdiv'+i, {
                        videoId: vid,
                        playerVars:{autoplay:0, mute:1, loop:1, playlist:vid, rel:0, controls:1, modestbranding:1},
                        events:{
                            onReady:(function(idx){ return function(e){
                                e.target.mute();
                                setTimeout(()=>markReady(idx), 200);
                            }})(i),
                            onError:(function(idx){ return function(){
                                document.getElementById('w'+idx).style.display='flex';
                                markReady(idx);
                            }})(i)
                        }
                    });
                } else {
                    // Web / GDrive — regular iframe, mark ready on load
                    const fr = document.createElement('iframe');
                    fr.allow = 'autoplay;fullscreen;encrypted-media';
                    fr.allowFullscreen = true;
                    fr.onload = (function(idx, type, frame){ return function(){
                        try{
                            const d=frame.contentDocument||frame.contentWindow.document;
                            if(!d||!d.body||d.body.innerHTML.trim()===''){
                                document.getElementById('w'+idx).style.display='flex';
                            }
                        }catch(e){} // cross-origin = fine
                        markReady(idx);
                    }})(i, t, fr);
                    // Timeout fallback
                    setTimeout((function(idx){ return function(){ markReady(idx); }})(i), t==='web'?8000:5000);
                    fr.src = embedUrl(url, t);
                    wrap.appendChild(fr);
                    panels[i].iframe = fr;
                }
            }
        }

        // Wait for YT API if not ready yet
        if(ytAPIReady) doLaunch();
        else pendingLaunch = doLaunch;
    }

    function setTab(w){
        document.querySelectorAll('.tab').forEach(t=>t.classList.remove('on'));
        document.getElementById(w==='grid'?'tg':'t'+w).classList.add('on');
    }

    function showGrid(){
        if(cur>=0){toGrid(cur);cur=-1}
        document.getElementById('single').style.display='none';
        setTab('grid');
    }

    function showSingle(i){
        if(cur>=0&&cur!==i) toGrid(cur);
        cur=i;
        document.getElementById('sdot').className='dot d'+i;
        document.getElementById('slbl').textContent='Link '+(i+1);
        const slot=document.getElementById('slot');
        slot.appendChild(document.getElementById('wrap'+i));
        slot.appendChild(document.getElementById('w'+i));
        document.getElementById('single').style.display='flex';
        setTab(i);
    }

    function toGrid(i){
        const p=document.getElementById('p'+i);
        p.insertBefore(document.getElementById('wrap'+i), document.getElementById('w'+i));
    }

    function goBack(){
        if(cur>=0){toGrid(cur);cur=-1}
        for(let i=0;i<4;i++){
            if(panels[i]&&panels[i].type==='youtube'){
                try{panels[i].player.stopVideo();panels[i].player.destroy();}catch(e){}
            }
            document.getElementById('wrap'+i).innerHTML='';
            document.getElementById('w'+i).style.display='none';
            document.getElementById('gb'+i).className='gb loading';
            panels[i]=null;
        }
        readyFlags=[false,false,false,false];
        document.getElementById('gcnt').textContent='0 / 4 ready';
        document.getElementById('gready').classList.remove('show');
        document.getElementById('single').style.display='none';
        document.getElementById('viewer').classList.remove('show');
        document.getElementById('gate').classList.remove('show');
        document.getElementById('form').classList.remove('out');
    }
</script>
</body>
</html>

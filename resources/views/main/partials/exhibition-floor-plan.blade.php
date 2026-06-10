<div class="floor-plan-wrapper mb-5">
<style>
/* ── Wrapper ── */
.floor-plan-wrapper {
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,.1), 0 1px 4px rgba(0,0,0,.06);
    overflow: hidden;
    border: 1px solid #d1fae5;
    background: white;
}

/* ── Header ── */
.fp-header {
    background: linear-gradient(135deg, #14532d 0%, #166534 45%, #15803d 100%);
    color: white;
    padding: 26px 30px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    position: relative;
    overflow: hidden;
}
.fp-header::after {
    content: '';
    position: absolute;
    right: -30px; top: -30px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
}
.fp-header h3 {
    font-size: 1.2rem; font-weight: 700; margin: 0 0 4px;
    display: flex; align-items: center; gap: 9px;
}
.fp-header p  { margin: 0; opacity: .75; font-size: .84rem; }
.fp-badge {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 20px;
    padding: 5px 16px;
    font-size: .76rem; font-weight: 700;
    letter-spacing: .04em;
    white-space: nowrap;
    backdrop-filter: blur(4px);
}

/* ── Body ── */
.fp-body { padding: 22px 26px 26px; }

/* ── Info bar ── */
.fp-info {
    background: linear-gradient(90deg, #f0fdf4 0%, #ecfdf5 100%);
    border: 1px solid #6ee7b7;
    border-radius: 10px;
    padding: 11px 16px;
    font-size: .84rem; color: #065f46;
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 18px;
    font-weight: 500;
}

/* ── Map container ── */
.fp-scroll {
    overflow-x: auto;
    border-radius: 14px;
    border: 1px solid #d1e0d5;
    box-shadow: inset 0 2px 8px rgba(0,0,0,.04);
    background: #e8f0e8;
    padding: 0;
    margin-bottom: 20px;
}
.fp-scroll::-webkit-scrollbar { height: 6px; }
.fp-scroll::-webkit-scrollbar-track { background: #f1f5f1; }
.fp-scroll::-webkit-scrollbar-thumb { background: #a7c4a7; border-radius: 3px; }

/* ── Booth hover ── */
.fp-booth { cursor: pointer; }
.fp-booth rect { transition: filter .14s, transform .14s; transform-box: fill-box; transform-origin: center; }
.fp-booth:hover rect { filter: brightness(.88) drop-shadow(0 2px 4px rgba(0,0,0,.18)); transform: scale(1.08); }

/* ── Tooltip ── */
.fp-tooltip {
    position: fixed;
    background: #0f172a;
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 12px; font-weight: 600;
    pointer-events: none;
    z-index: 9999;
    display: none;
    white-space: nowrap;
    box-shadow: 0 6px 20px rgba(0,0,0,.35);
    border: 1px solid rgba(255,255,255,.08);
    letter-spacing: .01em;
}
.fp-tooltip::after {
    content: '';
    position: absolute;
    top: 100%; left: 50%; transform: translateX(-50%);
    border: 6px solid transparent;
    border-top-color: #0f172a;
}

/* ── Divider ── */
.fp-divider {
    display: flex; align-items: center; gap: 12px;
    margin: 20px 0 12px;
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em; color: #94a3b8;
}
.fp-divider::before, .fp-divider::after {
    content: ''; flex: 1; height: 1px; background: #e2e8f0;
}

/* ── Infrastructure badges ── */
.fp-infra { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 20px; }
.fp-ib {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 13px; border-radius: 20px;
    font-size: .76rem; font-weight: 600;
    border: 1px solid transparent;
}

/* ── Legend ── */
.fp-legend {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 7px;
}
.fp-leg {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px;
    border-radius: 10px;
    border: 1.5px solid #f1f5f9;
    background: #fafbfc;
    font-size: .8rem;
    cursor: pointer;
    transition: border-color .15s, background .15s, transform .1s, box-shadow .15s;
    user-select: none;
}
.fp-leg:hover {
    border-color: #6ee7b7;
    background: #f0fdf4;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0,0,0,.07);
}
.fp-leg.on {
    border-color: #16a34a;
    background: #dcfce7;
    box-shadow: 0 0 0 2px rgba(22,163,74,.15);
}
.fp-swatch {
    width: 22px; height: 22px; border-radius: 5px; flex-shrink: 0;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,.12);
}
.fp-range { font-family: monospace; font-size: .72rem; color: #94a3b8; display: block; margin-top: 1px; }
.fp-leg-name { font-weight: 600; color: #1e293b; line-height: 1.3; }
</style>

<div class="fp-tooltip" id="fpTip"></div>

{{-- ── HEADER ── --}}
<div class="fp-header">
    <div>
        <h3>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity=".9"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
            Exhibition Ground Floor Plan
        </h3>
        <p>Review booth positions and categories before you register</p>
    </div>
    <span class="fp-badge">🏛 50 Booths · KALRO Conference Grounds</span>
</div>

<div class="fp-body">

    {{-- ── INFO BAR ── --}}
    <div class="fp-info">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2.2" stroke-linecap="round" flex-shrink="0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Hover over any booth to see its category &amp; name. Click a legend tile to highlight that group across the map.
    </div>

    {{-- ── SVG MAP ── --}}
    <div class="fp-scroll">
    <svg width="912" height="808" viewBox="0 0 912 808"
         role="img" xmlns="http://www.w3.org/2000/svg" style="display:block;">
        <title>KALRO Exhibition Ground Floor Plan — 50 booths G1–G50</title>
        <desc>U-shaped layout: left column G23–G34, bottom row G7–G22, right column G1–G6. KALRO pavilion across the top. Large machinery area left, networking area centre-right.</desc>

        @php
        $cats = [
            'research'   => ['fill'=>'#bbf7d0','stroke'=>'#16a34a','text'=>'#14532d','label'=>'Research institutions',              'range'=>'G01–G06'],
            'university' => ['fill'=>'#bfdbfe','stroke'=>'#2563eb','text'=>'#1e3a8a','label'=>'Universities & training institutions', 'range'=>'G07–G12'],
            'government' => ['fill'=>'#fde68a','stroke'=>'#ca8a04','text'=>'#713f12','label'=>'Government agencies',                'range'=>'G13–G17'],
            'private'    => ['fill'=>'#fed7aa','stroke'=>'#ea580c','text'=>'#7c2d12','label'=>'Private agribusiness companies',      'range'=>'G18–G22'],
            'financial'  => ['fill'=>'#e9d5ff','stroke'=>'#7c3aed','text'=>'#4c1d95','label'=>'Financial institutions',             'range'=>'G23–G28'],
            'ict'        => ['fill'=>'#99f6e4','stroke'=>'#0d9488','text'=>'#134e4a','label'=>'ICT & digital agriculture',           'range'=>'G29–G33'],
            'ngo'        => ['fill'=>'#fca5a5','stroke'=>'#dc2626','text'=>'#7f1d1d','label'=>'Development partners & NGOs',         'range'=>'G34–G38'],
            'input'      => ['fill'=>'#d9f99d','stroke'=>'#65a30d','text'=>'#365314','label'=>'Input suppliers',                    'range'=>'G39–G44'],
            'food'       => ['fill'=>'#fbcfe8','stroke'=>'#db2777','text'=>'#831843','label'=>'Food processing & value addition',    'range'=>'G45–G50'],
        ];
        $boothCat = [];
        foreach(range(1,6)  as $n) $boothCat["G$n"] = 'research';
        foreach(range(7,12) as $n) $boothCat["G$n"] = 'university';
        foreach(range(13,17)as $n) $boothCat["G$n"] = 'government';
        foreach(range(18,22)as $n) $boothCat["G$n"] = 'private';
        foreach(range(23,28)as $n) $boothCat["G$n"] = 'financial';
        foreach(range(29,33)as $n) $boothCat["G$n"] = 'ict';
        foreach(range(34,38)as $n) $boothCat["G$n"] = 'ngo';
        foreach(range(39,44)as $n) $boothCat["G$n"] = 'input';
        foreach(range(45,50)as $n) $boothCat["G$n"] = 'food';

        $cw = 34; $rh = 34;
        $x0 = 14; $y0 = 10;
        $bw = 30; $bh = 30;
        $bp = 2;

        function cx($c, $x0, $cw){ return $x0 + ($c-1)*$cw; }
        function ry($r, $y0, $rh){ return $y0 + ($r-1)*$rh; }

        $positions = [];
        $leftBooths = ['G34','G33','G32','G31','G30','G29','G28','G27','G26','G25','G24','G23'];
        foreach($leftBooths as $i => $b) {
            $positions[$b] = [cx(9,$x0,$cw)+$bp, ry(10+$i,$y0,$rh)+$bp];
        }
        foreach(range(22,7,-1) as $i => $n) {
            $positions["G$n"] = [cx(10+$i,$x0,$cw)+$bp, ry(22,$y0,$rh)+$bp];
        }
        foreach(range(1,6) as $i) {
            $positions["G$i"] = [cx(26,$x0,$cw)+$bp, ry(15+$i,$y0,$rh)+$bp];
        }
        @endphp

        {{-- ── GROUND — warm off-white with subtle grid ── --}}
        <defs>
            <pattern id="grid" width="34" height="34" patternUnits="userSpaceOnUse">
                <path d="M 34 0 L 0 0 0 34" fill="none" stroke="#c8d8c8" stroke-width="0.4" opacity=".6"/>
            </pattern>
        </defs>
        <rect width="912" height="808" fill="#f0f5f0"/>
        <rect width="912" height="808" fill="url(#grid)"/>

        {{-- ── VISITORS REGISTRATION ── --}}
        <rect x="354" y="10" width="136" height="32" rx="6"
              fill="#eff6ff" stroke="#93c5fd" stroke-width="1.5"/>
        <text x="422" y="30" text-anchor="middle" dominant-baseline="central"
              font-size="9.5" font-weight="700" fill="#1e40af" font-family="sans-serif">VISITORS REGISTRATION</text>

        {{-- ── FIRST AID ── --}}
        <rect x="524" y="10" width="102" height="32" rx="6"
              fill="#fef2f2" stroke="#fca5a5" stroke-width="1.5"/>
        <text x="575" y="30" text-anchor="middle" dominant-baseline="central"
              font-size="9.5" font-weight="700" fill="#dc2626" font-family="sans-serif">✚ FIRST AID</text>

        {{-- ── MAIN GATE ── --}}
        <rect x="14" y="78" width="28" height="76" rx="5"
              fill="#1e293b" stroke="#334155" stroke-width="1"/>
        <text transform="translate(28,150) rotate(-90)" text-anchor="start"
              font-size="9" font-weight="700" fill="white" font-family="sans-serif"
              letter-spacing="1">MAIN GATE</text>

        {{-- ── ROAD ── --}}
        <rect x="48" y="112" width="850" height="28" rx="4"
              fill="#94a3b8" opacity=".35"/>
        <rect x="48" y="112" width="850" height="28" rx="4"
              fill="none" stroke="#64748b" stroke-width="0.8" opacity=".4"/>
        {{-- Road markings --}}
        @for($rm = 0; $rm < 20; $rm++)
        <rect x="{{ 120 + $rm * 42 }}" y="124" width="24" height="4" rx="2" fill="white" opacity=".5"/>
        @endfor
        <text x="473" y="130" text-anchor="middle" dominant-baseline="central"
              font-size="10" font-weight="700" fill="#334155" font-family="sans-serif"
              letter-spacing="3">ROAD</text>

        {{-- ── WATER SOURCE ── --}}
        <rect x="286" y="214" width="136" height="32" rx="6"
              fill="#e0f2fe" stroke="#7dd3fc" stroke-width="1.5"/>
        <text x="354" y="230" text-anchor="middle" dominant-baseline="central"
              font-size="9.5" font-weight="700" fill="#0369a1" font-family="sans-serif">💧 WATER SOURCE</text>

        {{-- ── WASTE BIN ── --}}
        <rect x="524" y="214" width="88" height="32" rx="6"
              fill="#fffbeb" stroke="#fcd34d" stroke-width="1.5"/>
        <text x="568" y="230" text-anchor="middle" dominant-baseline="central"
              font-size="9.5" font-weight="700" fill="#92400e" font-family="sans-serif">🗑 WASTE BIN</text>

        {{-- ── KALRO ROW — 16 individual green blocks ── --}}
        @for($k = 0; $k < 16; $k++)
        @php $kx = 320 + $k * 34; @endphp
        <rect x="{{ $kx }}" y="282" width="30" height="30" rx="4"
              fill="#14532d" stroke="#052e16" stroke-width="1"/>
        <rect x="{{ $kx+1 }}" y="283" width="28" height="14" rx="3" fill="rgba(255,255,255,.06)"/>
        <text x="{{ $kx+15 }}" y="297" text-anchor="middle" dominant-baseline="central"
              font-size="7" font-weight="700" fill="#bbf7d0" font-family="sans-serif"
              letter-spacing="0.5">KALRO</text>
        @endfor

        {{-- ── LARGE MACHINERY ── --}}
        <rect x="82" y="316" width="170" height="408" rx="10"
              fill="#fefce8" stroke="#d97706" stroke-width="1.5" stroke-dasharray="8,4"/>
        <rect x="84" y="318" width="166" height="16" rx="8" fill="#fef08a" opacity=".6"/>
        <text transform="translate(140,520) rotate(-90)"
              text-anchor="middle" font-size="10" font-weight="700"
              fill="#92400e" font-family="sans-serif" letter-spacing="1">LARGE MACHINERY VEHICLES &amp; TRACTORS</text>

        {{-- ── NETWORKING AREA ── --}}
        <rect x="490" y="350" width="210" height="175" rx="10"
              fill="#fdf4ff" stroke="#c084fc" stroke-width="1.5" stroke-dasharray="8,4"/>
        <rect x="492" y="352" width="206" height="16" rx="8" fill="#e9d5ff" opacity=".7"/>
        <text x="595" y="420" text-anchor="middle"
              font-size="11.5" font-weight="700" fill="#7e22ce" font-family="sans-serif">NETWORKING AREA</text>
        <text x="595" y="440" text-anchor="middle"
              font-size="9" fill="#a855f7" font-family="sans-serif">Wi-Fi · Lounge · Refreshments</text>

        {{-- ── ALL BOOTHS ── --}}
        @foreach($positions as $booth => $pos)
        @php
            $cat  = $boothCat[$booth] ?? 'research';
            $fill = $cats[$cat]['fill'];
            $strk = $cats[$cat]['stroke'];
            $tc   = $cats[$cat]['text'];
            $lbl  = $cats[$cat]['label'];
            $px   = $pos[0]; $py = $pos[1];
            $cx2  = $px + $bw/2; $cy2 = $py + $bh/2;
        @endphp
        <g class="fp-booth" data-cat="{{ $cat }}"
           onmouseenter="fpTip(event,'{{ $booth }} — {{ $lbl }}')"
           onmouseleave="fpHide()"
           onclick="fpSel('{{ $cat }}')">
            {{-- Shadow layer --}}
            <rect x="{{ $px+1 }}" y="{{ $py+2 }}" width="{{ $bw }}" height="{{ $bh }}"
                  rx="5" fill="rgba(0,0,0,.1)"/>
            {{-- Main booth --}}
            <rect x="{{ $px }}" y="{{ $py }}" width="{{ $bw }}" height="{{ $bh }}"
                  rx="5" fill="{{ $fill }}" stroke="{{ $strk }}" stroke-width="1.5"/>
            {{-- Shine strip --}}
            <rect x="{{ $px+2 }}" y="{{ $py+2 }}" width="{{ $bw-4 }}" height="8"
                  rx="3" fill="rgba(255,255,255,.35)"/>
            <text x="{{ $cx2 }}" y="{{ $cy2+1 }}" text-anchor="middle" dominant-baseline="central"
                  font-size="8.5" font-weight="700" fill="{{ $tc }}" font-family="sans-serif">{{ $booth }}</text>
        </g>
        @endforeach

        {{-- ── COMPASS ROSE ── --}}
        <g transform="translate(880,774)">
            <circle cx="0" cy="0" r="22" fill="white" stroke="#e2e8f0" stroke-width="1.5"
                    filter="drop-shadow(0 1px 3px rgba(0,0,0,.1))"/>
            <polygon points="0,-16 4,0 0,-4 -4,0" fill="#166534"/>
            <polygon points="0,16  4,0 0, 4 -4,0" fill="#cbd5e1"/>
            <line x1="-16" y1="0" x2="16" y2="0" stroke="#e2e8f0" stroke-width="1"/>
            <line x1="0" y1="-16" x2="0" y2="16" stroke="#e2e8f0" stroke-width="1"/>
            <text x="0" y="-6" text-anchor="middle" dominant-baseline="central"
                  font-size="8" font-weight="700" fill="#166534" font-family="sans-serif">N</text>
            <text x="0" y="12" text-anchor="middle" dominant-baseline="central"
                  font-size="7" fill="#94a3b8" font-family="sans-serif">S</text>
            <text x="-12" y="1" text-anchor="middle" dominant-baseline="central"
                  font-size="7" fill="#94a3b8" font-family="sans-serif">W</text>
            <text x="12" y="1" text-anchor="middle" dominant-baseline="central"
                  font-size="7" fill="#94a3b8" font-family="sans-serif">E</text>
        </g>

        {{-- ── SCALE CAPTION ── --}}
        <text x="456" y="796" text-anchor="middle"
              font-size="9" fill="#94a3b8" font-family="sans-serif"
              letter-spacing=".5">50 exhibition booths (G1–G50) · hover any booth for details</text>

    </svg>
    </div>

    {{-- ── INFRASTRUCTURE ── --}}
    <div class="fp-divider">Venue Infrastructure</div>
    <div class="fp-infra">
        <span class="fp-ib" style="background:#e0f2fe;color:#0369a1;border-color:#7dd3fc;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="#0369a1"><path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/></svg>
            Water Source
        </span>
        <span class="fp-ib" style="background:#fef2f2;color:#dc2626;border-color:#fca5a5;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            First Aid
        </span>
        <span class="fp-ib" style="background:#fdf4ff;color:#7e22ce;border-color:#c084fc;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7e22ce" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="#7e22ce"/></svg>
            Networking Area
        </span>
        <span class="fp-ib" style="background:#fffbeb;color:#92400e;border-color:#fcd34d;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
            Waste Bin
        </span>
        <span class="fp-ib" style="background:#fefce8;color:#713f12;border-color:#fde68a;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#713f12" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            Large Machinery Area
        </span>
    </div>

    {{-- ── LEGEND ── --}}
    <div class="fp-divider">Booth Categories</div>
    <div class="fp-legend">
        @foreach($cats as $key => $cat)
        <div class="fp-leg" data-cat="{{ $key }}" onclick="fpSel('{{ $key }}')">
            <div class="fp-swatch"
                 style="background:{{ $cat['fill'] }};box-shadow:inset 0 0 0 1.5px {{ $cat['stroke'] }};"></div>
            <div>
                <div class="fp-leg-name">{{ $cat['label'] }}</div>
                <span class="fp-range">{{ $cat['range'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

</div>
</div>

<script>
(function(){
    var tip=document.getElementById('fpTip'), active=null;
    window.fpTip=function(e,t){
        tip.textContent=t;
        tip.style.display='block';
        tip.style.left=(e.clientX-Math.round(tip.offsetWidth/2||80))+'px';
        tip.style.top=(e.clientY-48)+'px';
    };
    window.fpHide=function(){ tip.style.display='none'; };
    document.addEventListener('mousemove',function(e){
        if(tip.style.display==='block'){
            tip.style.left=(e.clientX-Math.round(tip.offsetWidth/2||80))+'px';
            tip.style.top=(e.clientY-48)+'px';
        }
    });
    window.fpSel=function(cat){
        if(active===cat){ active=null; reset(); return; }
        active=cat;
        document.querySelectorAll('.fp-booth').forEach(function(b){
            b.style.opacity = b.dataset.cat===cat ? '1' : '0.12';
        });
        document.querySelectorAll('.fp-leg').forEach(function(l){
            l.classList.toggle('on', l.dataset.cat===cat);
        });
    };
    function reset(){
        document.querySelectorAll('.fp-booth').forEach(function(b){ b.style.opacity='1'; });
        document.querySelectorAll('.fp-leg').forEach(function(l){ l.classList.remove('on'); });
    }
})();
</script>
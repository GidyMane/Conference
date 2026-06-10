<div class="floor-plan-wrapper mb-5">
<style>
.floor-plan-wrapper{background:white;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;border:1px solid #e2e8f0;}
.fp-header{background:linear-gradient(135deg,#1a5f3a 0%,#2d8a3e 100%);color:white;padding:20px 26px 18px;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:10px;}
.fp-header h3{font-size:1.15rem;font-weight:700;margin:0 0 3px;}
.fp-header p{margin:0;opacity:.8;font-size:.83rem;}
.fp-badge{background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);border-radius:20px;padding:4px 13px;font-size:.75rem;font-weight:700;white-space:nowrap;}
.fp-body{padding:20px 22px;}
.fp-info{background:#f0fdf4;border:1px solid #a7f3d0;border-radius:10px;padding:10px 15px;font-size:.82rem;color:#065f46;display:flex;align-items:center;gap:9px;margin-bottom:16px;}
.fp-scroll{overflow-x:auto;background:#f1f5f0;border:1px solid #d1e0d5;border-radius:12px;padding:12px;}
.fp-booth{cursor:pointer;}
.fp-booth rect{transition:opacity .12s;}
.fp-booth:hover rect{opacity:.7;}
.fp-tooltip{position:fixed;background:#1e293b;color:white;padding:6px 12px;border-radius:7px;font-size:11.5px;font-weight:600;pointer-events:none;z-index:9999;display:none;white-space:nowrap;box-shadow:0 3px 12px rgba(0,0,0,.3);}
.fp-tooltip::after{content:'';position:absolute;top:100%;left:50%;transform:translateX(-50%);border:5px solid transparent;border-top-color:#1e293b;}
.fp-legend{display:grid;grid-template-columns:repeat(auto-fill,minmax(195px,1fr));gap:6px;margin-top:14px;}
.fp-leg{display:flex;align-items:center;gap:8px;padding:7px 10px;border-radius:7px;border:1.5px solid #e8edf2;background:white;font-size:.78rem;cursor:pointer;transition:border-color .14s,background .14s;user-select:none;}
.fp-leg:hover{border-color:#2d8a3e;background:#f0fdf4;}
.fp-leg.on{border-color:#2d8a3e;background:#e8f5e9;}
.fp-swatch{width:20px;height:20px;border-radius:4px;flex-shrink:0;border:1px solid rgba(0,0,0,.1);}
.fp-range{font-family:monospace;font-size:.72rem;color:#64748b;display:block;}
.fp-infra{display:flex;flex-wrap:wrap;gap:6px;margin:12px 0;}
.fp-ib{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:14px;font-size:.74rem;font-weight:600;}
</style>

<div class="fp-tooltip" id="fpTip"></div>

<div class="fp-header">
    <div>
        <h3><i class="bi bi-map me-2"></i>Exhibition Ground Floor Plan</h3>
        <p>Review booth positions and categories before registering</p>
    </div>
    <span class="fp-badge">50 Booths · KALRO Conference Grounds</span>
</div>

<div class="fp-body">
    <div class="fp-info">
        <i class="bi bi-info-circle-fill fs-6 flex-shrink-0"></i>
        Hover over any booth to see its category. Click a legend item to highlight that group on the map.
    </div>

    <div class="fp-scroll">
    {{-- SVG dimensions exactly match the Excel spatial layout --}}
    {{-- col_w=34, row_h=34, x0=14, y0=10 --}}
    {{-- Total: 912 x 808 --}}
    <svg width="912" height="808" viewBox="0 0 912 808"
         role="img" xmlns="http://www.w3.org/2000/svg" style="display:block;">
        <title>KALRO Exhibition Ground Floor Plan — 50 booths G1–G50</title>
        <desc>U-shaped layout: left column G23–G34, bottom row G7–G22, right column G1–G6. KALRO pavilion across the top. Large machinery area left, networking area centre-right.</desc>

        @php
        $cats = [
            'research'   => ['fill'=>'#bbf7d0','stroke'=>'#16a34a','text'=>'#14532d','label'=>'Research institutions',             'range'=>'G01–G06'],
            'university' => ['fill'=>'#bfdbfe','stroke'=>'#2563eb','text'=>'#1e3a8a','label'=>'Universities & training institutions','range'=>'G07–G12'],
            'government' => ['fill'=>'#fde68a','stroke'=>'#ca8a04','text'=>'#713f12','label'=>'Government agencies',               'range'=>'G13–G17'],
            'private'    => ['fill'=>'#fed7aa','stroke'=>'#ea580c','text'=>'#7c2d12','label'=>'Private agribusiness companies',     'range'=>'G18–G22'],
            'financial'  => ['fill'=>'#e9d5ff','stroke'=>'#7c3aed','text'=>'#4c1d95','label'=>'Financial institutions',            'range'=>'G23–G28'],
            'ict'        => ['fill'=>'#99f6e4','stroke'=>'#0d9488','text'=>'#134e4a','label'=>'ICT & digital agriculture',          'range'=>'G29–G33'],
            'ngo'        => ['fill'=>'#fca5a5','stroke'=>'#dc2626','text'=>'#7f1d1d','label'=>'Development partners & NGOs',        'range'=>'G34–G38'],
            'input'      => ['fill'=>'#d9f99d','stroke'=>'#65a30d','text'=>'#365314','label'=>'Input suppliers',                   'range'=>'G39–G44'],
            'food'       => ['fill'=>'#fbcfe8','stroke'=>'#db2777','text'=>'#831843','label'=>'Food processing & value addition',   'range'=>'G45–G50'],
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

        $cw = 34; $rh = 34;  // col-width, row-height
        $x0 = 14; $y0 = 10;
        $bw = 30; $bh = 30;  // booth dims (fits inside cell with 2px padding each side)
        $bp = 2;             // booth padding inside cell

        function cx($c, $x0, $cw){ return $x0 + ($c-1)*$cw; }
        function ry($r, $y0, $rh){ return $y0 + ($r-1)*$rh; }

        // Left column: G34(row10)→G23(row21) at col9
        $positions = [];
        $leftBooths = ['G34','G33','G32','G31','G30','G29','G28','G27','G26','G25','G24','G23'];
        foreach($leftBooths as $i => $b) {
            $positions[$b] = [cx(9,$x0,$cw)+$bp, ry(10+$i,$y0,$rh)+$bp];
        }

        // Bottom row: G22(col10)→G7(col25) at row22
        foreach(range(22,7,-1) as $i => $n) {
            $positions["G$n"] = [cx(10+$i,$x0,$cw)+$bp, ry(22,$y0,$rh)+$bp];
        }

        // Right column: G1(row16)→G6(row21) at col26
        foreach(range(1,6) as $i) {
            $positions["G$i"] = [cx(26,$x0,$cw)+$bp, ry(15+$i,$y0,$rh)+$bp];
        }
        @endphp

        {{-- ── GROUND ── --}}
        <rect width="912" height="808" fill="#edf2ed"/>

        {{-- ── VISITORS REGISTRATION — col11, row1, span 4 cols ── --}}
        <rect x="354" y="10" width="136" height="30" rx="5"
              fill="#dbeafe" stroke="#3b82f6" stroke-width="1.5"/>
        <text x="422" y="29" text-anchor="middle" font-size="9.5" font-weight="700"
              fill="#1e40af" font-family="sans-serif">VISITORS REGISTRATION</text>

        {{-- ── FIRST AID — col16, row1 ── --}}
        <rect x="524" y="10" width="102" height="30" rx="5"
              fill="#bbf7d0" stroke="#16a34a" stroke-width="1.5"/>
        <text x="575" y="29" text-anchor="middle" font-size="9.5" font-weight="700"
              fill="#14532d" font-family="sans-serif">FIRST AID</text>

        {{-- ── MAIN GATE — col1-2, row3 ── --}}
        <rect x="14" y="78" width="30" height="76" rx="5" fill="#1f2937"/>
        <text transform="translate(29,154) rotate(-90)" text-anchor="start"
              font-size="9" font-weight="700" fill="white" font-family="sans-serif">MAIN GATE</text>

        {{-- ── ROAD — col2→col26, row4 ── --}}
        <rect x="48" y="112" width="850" height="26" rx="3" fill="#9ca3af" opacity=".5"/>
        <text x="473" y="129" text-anchor="middle" font-size="10" font-weight="700"
              fill="#374151" font-family="sans-serif">R  O  A  D</text>

        {{-- ── WATER SOURCE — col9, row7, span ~4 cols ── --}}
        <rect x="286" y="214" width="136" height="30" rx="5"
              fill="#bfdbfe" stroke="#3b82f6" stroke-width="1.2"/>
        <text x="354" y="233" text-anchor="middle" font-size="9.5" font-weight="700"
              fill="#1e40af" font-family="sans-serif">WATER SOURCE</text>

        {{-- ── WASTE BIN — col16, row7 ── --}}
        <rect x="524" y="214" width="85" height="30" rx="5"
              fill="#fef08a" stroke="#ca8a04" stroke-width="1.2"/>
        <text x="566" y="233" text-anchor="middle" font-size="9.5" font-weight="700"
              fill="#713f12" font-family="sans-serif">WASTE BIN</text>

        {{-- ── KALRO ROW — cols 10-25, row9 (16 blocks of col_w each) ── --}}
        @for($k = 0; $k < 16; $k++)
        @php $kx = 320 + $k * 34; @endphp
        <rect x="{{ $kx }}" y="282" width="30" height="30" rx="3"
              fill="#166534" stroke="#14532d" stroke-width="1"/>
        <text x="{{ $kx+15 }}" y="301" text-anchor="middle" dominant-baseline="central"
              font-size="7.5" font-weight="700" fill="#dcfce7" font-family="sans-serif">KALRO</text>
        @endfor

        {{-- ── LARGE MACHINERY — cols 3-8, rows 10-21 ── --}}
        <rect x="82" y="316" width="170" height="408" rx="7"
              fill="#fef9c3" stroke="#ca8a04" stroke-width="1.5" stroke-dasharray="7,3"/>
        <text transform="translate(132,520) rotate(-90)"
              text-anchor="middle" font-size="10" font-weight="700"
              fill="#713f12" font-family="sans-serif">LARGE MACHINERY VEHICLES AND TRACTORS</text>

        {{-- ── NETWORKING AREA — col15-20, rows 11-15 ── --}}
        <rect x="490" y="350" width="204" height="170" rx="7"
              fill="#fce7f3" stroke="#db2777" stroke-width="1.5" stroke-dasharray="7,3"/>
        <text x="592" y="428" text-anchor="middle" font-size="11" font-weight="700"
              fill="#831843" font-family="sans-serif">NETWORKING AREA</text>

        {{-- ── ALL BOOTHS ── --}}
        @foreach($positions as $booth => $pos)
        @php
            $cat    = $boothCat[$booth] ?? 'research';
            $fill   = $cats[$cat]['fill'];
            $stroke = $cats[$cat]['stroke'];
            $tc     = $cats[$cat]['text'];
            $lbl    = $cats[$cat]['label'];
            $px     = $pos[0]; $py = $pos[1];
            $cx2    = $px + $bw/2; $cy2 = $py + $bh/2;
        @endphp
        <g class="fp-booth" data-cat="{{ $cat }}"
           onmouseenter="fpTip(event,'{{ $booth }} — {{ $lbl }}')"
           onmouseleave="fpHide()"
           onclick="fpSel('{{ $cat }}')">
            <rect x="{{ $px }}" y="{{ $py }}" width="{{ $bw }}" height="{{ $bh }}" rx="4"
                  fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.5"/>
            <text x="{{ $cx2 }}" y="{{ $cy2 }}" text-anchor="middle" dominant-baseline="central"
                  font-size="8.5" font-weight="700" fill="{{ $tc }}" font-family="sans-serif">{{ $booth }}</text>
        </g>
        @endforeach

        {{-- ── COMPASS ── --}}
        <g transform="translate(884,778)">
            <circle cx="0" cy="0" r="18" fill="white" stroke="#d1d5db" stroke-width="1"/>
            <polygon points="0,-13 3.5,0 0,-2.5 -3.5,0" fill="#166534"/>
            <polygon points="0,13 3.5,0 0,2.5 -3.5,0" fill="#9ca3af"/>
            <text x="0" y="-3" text-anchor="middle" font-size="7.5" font-weight="700"
                  fill="#14532d" font-family="sans-serif">N</text>
        </g>

    </svg>
    </div>

    {{-- Infrastructure badges --}}
    <div class="fp-infra">
        <span class="fp-ib" style="background:#dbeafe;color:#1e40af;"><i class="bi bi-droplet-fill"></i> Water Source</span>
        <span class="fp-ib" style="background:#bbf7d0;color:#15803d;"><i class="bi bi-heart-pulse-fill"></i> First Aid</span>
        <span class="fp-ib" style="background:#fce7f3;color:#db2777;"><i class="bi bi-wifi"></i> Networking Area</span>
        <span class="fp-ib" style="background:#fef9c3;color:#713f12;"><i class="bi bi-trash3-fill"></i> Waste Bin</span>
        <span class="fp-ib" style="background:#fef9c3;color:#92400e;"><i class="bi bi-truck"></i> Large Machinery Area</span>
    </div>

    {{-- Legend --}}
    <p style="font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:700;color:#64748b;margin-bottom:7px;">
        Booth Categories — click to highlight
    </p>
    <div class="fp-legend">
        @foreach($cats as $key => $cat)
        <div class="fp-leg" data-cat="{{ $key }}" onclick="fpSel('{{ $key }}')">
            <div class="fp-swatch" style="background:{{ $cat['fill'] }};border-color:{{ $cat['stroke'] }};"></div>
            <div>
                <div style="font-weight:600;color:#1e293b;line-height:1.3;">{{ $cat['label'] }}</div>
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
        tip.textContent=t; tip.style.display='block';
        tip.style.left=(e.clientX-100)+'px'; tip.style.top=(e.clientY-44)+'px';
    };
    window.fpHide=function(){tip.style.display='none';};
    document.addEventListener('mousemove',function(e){
        if(tip.style.display==='block'){tip.style.left=(e.clientX-100)+'px';tip.style.top=(e.clientY-44)+'px';}
    });
    window.fpSel=function(cat){
        if(active===cat){active=null;reset();return;}
        active=cat;
        document.querySelectorAll('.fp-booth').forEach(function(b){b.style.opacity=b.dataset.cat===cat?'1':'0.15';});
        document.querySelectorAll('.fp-leg').forEach(function(l){l.classList.toggle('on',l.dataset.cat===cat);});
    };
    function reset(){
        document.querySelectorAll('.fp-booth').forEach(function(b){b.style.opacity='1';});
        document.querySelectorAll('.fp-leg').forEach(function(l){l.classList.remove('on');});
    }
})();
</script>
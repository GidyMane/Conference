<div class="floor-plan-wrapper mb-5">
<style>
.floor-plan-wrapper{background:white;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;border:1px solid #e2e8f0;}
.fp-header{background:linear-gradient(135deg,#1a5f3a 0%,#2d8a3e 100%);color:white;padding:24px 28px 20px;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.fp-header h3{font-size:1.2rem;font-weight:700;margin:0 0 4px;}
.fp-header p{margin:0;opacity:.8;font-size:.85rem;}
.fp-badge{background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);border-radius:20px;padding:4px 14px;font-size:.76rem;font-weight:700;letter-spacing:.04em;white-space:nowrap;}
.fp-body{padding:22px 24px;}
.fp-info{background:#f0fdf4;border:1px solid #a7f3d0;border-radius:10px;padding:11px 16px;font-size:.83rem;color:#065f46;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
.fp-scroll{overflow-x:auto;background:#eef2ef;border:1px solid #d1e0d5;border-radius:12px;padding:14px;}
.fp-scroll svg{display:block;}
.fp-booth{cursor:pointer;}
.fp-booth rect{transition:opacity .15s;}
.fp-booth:hover rect{opacity:.75;}
.fp-tooltip{position:fixed;background:#1e293b;color:white;padding:7px 13px;border-radius:8px;font-size:12px;font-weight:600;pointer-events:none;z-index:9999;display:none;white-space:nowrap;box-shadow:0 4px 14px rgba(0,0,0,.3);}
.fp-tooltip::after{content:'';position:absolute;top:100%;left:50%;transform:translateX(-50%);border:5px solid transparent;border-top-color:#1e293b;}
.fp-legend{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:7px;margin-top:16px;}
.fp-leg{display:flex;align-items:center;gap:9px;padding:8px 11px;border-radius:8px;border:1.5px solid #e8edf2;background:white;font-size:.8rem;cursor:pointer;transition:border-color .15s,background .15s;user-select:none;}
.fp-leg:hover{border-color:#2d8a3e;background:#f0fdf4;}
.fp-leg.on{border-color:#2d8a3e;background:#e8f5e9;}
.fp-swatch{width:22px;height:22px;border-radius:4px;flex-shrink:0;border:1px solid rgba(0,0,0,.1);}
.fp-range{font-family:monospace;font-size:.74rem;color:#64748b;display:block;margin-top:1px;}
.fp-infra{display:flex;flex-wrap:wrap;gap:7px;margin:14px 0;}
.fp-ib{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:16px;font-size:.76rem;font-weight:600;}
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
    <svg width="640" height="640" viewBox="0 0 640 640"
         role="img" xmlns="http://www.w3.org/2000/svg">
        <title>KALRO Exhibition Floor Plan — 50 booths G1 to G50</title>
        <desc>Exhibition floor plan showing booths arranged in a U-shape. Left column G23–G34, bottom row G7–G22, right column G1–G6. KALRO pavilion at top, main gate top-left.</desc>

        @php
        $cats = [
            'research'   => ['fill'=>'#bbf7d0','stroke'=>'#16a34a','text'=>'#14532d','label'=>'Research institutions',                    'range'=>'G01–G06'],
            'university' => ['fill'=>'#bfdbfe','stroke'=>'#2563eb','text'=>'#1e3a8a','label'=>'Universities & training institutions',       'range'=>'G07–G12'],
            'government' => ['fill'=>'#fde68a','stroke'=>'#ca8a04','text'=>'#713f12','label'=>'Government agencies',                       'range'=>'G13–G17'],
            'private'    => ['fill'=>'#fed7aa','stroke'=>'#ea580c','text'=>'#7c2d12','label'=>'Private agribusiness companies',             'range'=>'G18–G22'],
            'financial'  => ['fill'=>'#e9d5ff','stroke'=>'#7c3aed','text'=>'#4c1d95','label'=>'Financial institutions',                    'range'=>'G23–G28'],
            'ict'        => ['fill'=>'#99f6e4','stroke'=>'#0d9488','text'=>'#134e4a','label'=>'ICT & digital agriculture providers',        'range'=>'G29–G33'],
            'ngo'        => ['fill'=>'#fca5a5','stroke'=>'#dc2626','text'=>'#7f1d1d','label'=>'Development partners & NGOs',               'range'=>'G34–G38'],
            'input'      => ['fill'=>'#d9f99d','stroke'=>'#65a30d','text'=>'#365314','label'=>'Input suppliers',                           'range'=>'G39–G44'],
            'food'       => ['fill'=>'#fbcfe8','stroke'=>'#db2777','text'=>'#831843','label'=>'Food processing & value addition',           'range'=>'G45–G50'],
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

        $bw = 31; $bh = 28; $gap = 4;

        // Left column: G34 (top) → G23 (bottom), x=16
        $leftBooths = ['G34','G33','G32','G31','G30','G29','G28','G27','G26','G25','G24','G23'];
        $leftX = 16; $leftStartY = 132;
        $positions = [];
        foreach($leftBooths as $i => $b) {
            $positions[$b] = ['x'=>$leftX, 'y'=>$leftStartY + $i*($bh+$gap)];
        }

        // Bottom row: G22 (left) → G7 (right), y = leftStartY + 12*(bh+gap) + gap
        $bottomY = $leftStartY + 12*($bh+$gap) + $gap;
        $bottomBooths = range(22, 7, -1); // 22,21,...,7
        foreach($bottomBooths as $i => $n) {
            $positions["G$n"] = ['x'=>$leftX + $i*($bw+$gap), 'y'=>$bottomY];
        }

        // Right column: G1 (top) → G6 (bottom), x = leftX + 16*(bw+gap) + gap
        $rightX = $leftX + 16*($bw+$gap) + $gap;
        foreach(range(1,6) as $i) {
            $positions["G$i"] = ['x'=>$rightX, 'y'=>$leftStartY + ($i-1)*($bh+$gap)];
        }

        // KALRO blocks across top: 16 blocks spanning left col to right col
        $kalroTotal = $rightX + $bw - $leftX;
        $kbw = (int)(($kalroTotal - 15*$gap) / 16);
        $kalroY = 88;
        @endphp

        {{-- ── GROUND FILL ── --}}
        <rect width="640" height="640" fill="#eef5ed" rx="0"/>

        {{-- ── MAIN GATE ── --}}
        <rect x="10" y="10" width="108" height="34" rx="6" fill="#1f2937"/>
        <text x="64" y="32" text-anchor="middle" font-size="11" font-weight="700" fill="white" font-family="sans-serif">MAIN GATE</text>

        {{-- ── ROAD ── --}}
        <rect x="10" y="46" width="620" height="20" rx="3" fill="#9ca3af" opacity=".45"/>
        <text x="320" y="60" text-anchor="middle" font-size="10" fill="#374151" font-weight="700" font-family="sans-serif">R O A D</text>

        {{-- ── VISITORS REGISTRATION ── --}}
        <rect x="370" y="10" width="140" height="32" rx="6" fill="#ede9fe" stroke="#7c3aed" stroke-width="1.5"/>
        <text x="440" y="30" text-anchor="middle" font-size="10" font-weight="700" fill="#4c1d95" font-family="sans-serif">VISITORS REGISTRATION</text>

        {{-- ── FIRST AID ── --}}
        <rect x="518" y="10" width="112" height="32" rx="6" fill="#fee2e2" stroke="#dc2626" stroke-width="1.5"/>
        <text x="574" y="30" text-anchor="middle" font-size="11" font-weight="700" fill="#991b1b" font-family="sans-serif">✚ FIRST AID</text>

        {{-- ── KALRO PAVILION — 16 individual blocks ── --}}
        <rect x="{{ $leftX - 2 }}" y="{{ $kalroY - 4 }}" width="{{ $kalroTotal + 4 }}" height="{{ $bh + 8 }}" rx="6" fill="#14532d" opacity=".08"/>
        @for($k = 0; $k < 16; $k++)
        @php $kx = $leftX + $k * ($kbw + $gap); @endphp
        <rect x="{{ $kx }}" y="{{ $kalroY }}" width="{{ $kbw }}" height="{{ $bh }}"
              rx="3" fill="#dcfce7" stroke="#16a34a" stroke-width="1"/>
        <text x="{{ $kx + $kbw/2 }}" y="{{ $kalroY + $bh/2 }}"
              text-anchor="middle" dominant-baseline="central"
              font-size="8.5" font-weight="700" fill="#14532d" font-family="sans-serif">KALRO</text>
        @endfor

        {{-- ── LARGE MACHINERY AREA ── --}}
        @php $machW = 110; $machH = $bottomY - $leftStartY + $bh; @endphp
        <rect x="{{ $leftX + $bw + 8 }}" y="{{ $leftStartY }}"
              width="{{ $machW }}" height="{{ $machH }}"
              rx="8" fill="#d1fae5" stroke="#6ee7b7" stroke-width="1.5" stroke-dasharray="6,3"/>
        <text x="{{ $leftX + $bw + 8 + $machW/2 }}" y="{{ $leftStartY + $machH/2 - 8 }}"
              text-anchor="middle" font-size="10" font-weight="700" fill="#065f46" font-family="sans-serif">LARGE MACHINERY</text>
        <text x="{{ $leftX + $bw + 8 + $machW/2 }}" y="{{ $leftStartY + $machH/2 + 8 }}"
              text-anchor="middle" font-size="9" fill="#065f46" font-family="sans-serif">Vehicles &amp; Tractors</text>

        {{-- ── NETWORKING AREA ── --}}
        @php
        $netX = $leftX + $bw + $machW + 28;
        $netY = $leftStartY + 20;
        $netW = 160; $netH = 90;
        @endphp
        <rect x="{{ $netX }}" y="{{ $netY }}" width="{{ $netW }}" height="{{ $netH }}"
              rx="8" fill="#dbeafe" stroke="#3b82f6" stroke-width="1.5" stroke-dasharray="6,3"/>
        <text x="{{ $netX + $netW/2 }}" y="{{ $netY + $netH/2 - 8 }}"
              text-anchor="middle" font-size="10.5" font-weight="700" fill="#1e40af" font-family="sans-serif">NETWORKING AREA</text>
        <text x="{{ $netX + $netW/2 }}" y="{{ $netY + $netH/2 + 10 }}"
              text-anchor="middle" font-size="9" fill="#3b82f6" font-family="sans-serif">Wi-Fi · Lounge</text>

        {{-- ── WATER SOURCE ── --}}
        @php $wsX = $leftX + $bw + $machW + 28; $wsY = $netY + $netH + 16; @endphp
        <rect x="{{ $wsX }}" y="{{ $wsY }}" width="100" height="26" rx="5" fill="#bfdbfe" stroke="#3b82f6" stroke-width="1.2"/>
        <text x="{{ $wsX + 50 }}" y="{{ $wsY + 13 }}"
              text-anchor="middle" dominant-baseline="central"
              font-size="9.5" font-weight="700" fill="#1e40af" font-family="sans-serif">💧 WATER SOURCE</text>

        {{-- ── WASTE BIN ── --}}
        @php $wbX = $rightX - 110; $wbY = $leftStartY + 20; @endphp
        <rect x="{{ $wbX }}" y="{{ $wbY }}" width="100" height="26" rx="5" fill="#fef08a" stroke="#ca8a04" stroke-width="1.2"/>
        <text x="{{ $wbX + 50 }}" y="{{ $wbY + 13 }}"
              text-anchor="middle" dominant-baseline="central"
              font-size="9.5" font-weight="700" fill="#713f12" font-family="sans-serif">🗑 WASTE BIN</text>

        {{-- ── ALL BOOTHS ── --}}
        @foreach($positions as $booth => $pos)
        @php
            $cat    = $boothCat[$booth] ?? 'research';
            $fill   = $cats[$cat]['fill'];
            $stroke = $cats[$cat]['stroke'];
            $txtClr = $cats[$cat]['text'];
            $cx     = $pos['x'] + $bw/2;
            $cy     = $pos['y'] + $bh/2;
            $lbl    = $cats[$cat]['label'];
        @endphp
        <g class="fp-booth" data-cat="{{ $cat }}"
           onmouseenter="fpTip(event,'{{ $booth }} — {{ $lbl }}')"
           onmouseleave="fpHide()"
           onclick="fpSel('{{ $cat }}')">
            <rect x="{{ $pos['x'] }}" y="{{ $pos['y'] }}"
                  width="{{ $bw }}" height="{{ $bh }}" rx="4"
                  fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.2"/>
            <text x="{{ $cx }}" y="{{ $cy }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="8.5" font-weight="700" fill="{{ $txtClr }}" font-family="sans-serif">{{ $booth }}</text>
        </g>
        @endforeach

        {{-- ── COMPASS ── --}}
        <g transform="translate(615,605)">
            <circle cx="0" cy="0" r="19" fill="white" stroke="#d1d5db" stroke-width="1"/>
            <polygon points="0,-14 4,0 0,-3 -4,0" fill="#16a34a"/>
            <polygon points="0,14  4,0 0, 3 -4,0" fill="#9ca3af"/>
            <text x="0" y="-4" text-anchor="middle" font-size="8" font-weight="700" fill="#14532d" font-family="sans-serif">N</text>
        </g>

        {{-- ── SCALE NOTE ── --}}
        <text x="320" y="625" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="sans-serif">
            50 exhibition booths (G1–G50) · hover any booth for details
        </text>

    </svg>
    </div>

    {{-- Infrastructure badges --}}
    <div class="fp-infra">
        <span class="fp-ib" style="background:#dbeafe;color:#1e40af;"><i class="bi bi-droplet-fill"></i> Water Source</span>
        <span class="fp-ib" style="background:#dcfce7;color:#15803d;"><i class="bi bi-wifi"></i> Networking Area</span>
        <span class="fp-ib" style="background:#fee2e2;color:#dc2626;"><i class="bi bi-heart-pulse-fill"></i> First Aid</span>
        <span class="fp-ib" style="background:#fef9c3;color:#713f12;"><i class="bi bi-trash3-fill"></i> Waste Bins</span>
        <span class="fp-ib" style="background:#f0fdf4;color:#15803d;"><i class="bi bi-truck"></i> Large Machinery Area</span>
    </div>

    {{-- Legend --}}
    <p style="font-size:.76rem;text-transform:uppercase;letter-spacing:.08em;font-weight:700;color:#64748b;margin-bottom:8px;">
        Booth Categories — click to highlight
    </p>
    <div class="fp-legend">
        @foreach($cats as $key => $cat)
        <div class="fp-leg" data-cat="{{ $key }}" onclick="fpSel('{{ $key }}')">
            <div class="fp-swatch" style="background:{{ $cat['fill'] }};border-color:{{ $cat['stroke'] }};"></div>
            <div>
                <div style="font-weight:600;color:#1e293b;line-height:1.3;font-size:.8rem;">{{ $cat['label'] }}</div>
                <span class="fp-range">{{ $cat['range'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>

<script>
(function(){
    var tip = document.getElementById('fpTip');
    var active = null;
    window.fpTip = function(e, txt){
        tip.textContent = txt;
        tip.style.display = 'block';
        tip.style.left = (e.clientX - 100) + 'px';
        tip.style.top  = (e.clientY - 46) + 'px';
    };
    window.fpHide = function(){ tip.style.display = 'none'; };
    document.addEventListener('mousemove', function(e){
        if(tip.style.display==='block'){
            tip.style.left=(e.clientX-100)+'px';
            tip.style.top=(e.clientY-46)+'px';
        }
    });
    window.fpSel = function(cat){
        if(active===cat){ active=null; reset(); return; }
        active=cat;
        document.querySelectorAll('.fp-booth').forEach(function(b){
            b.style.opacity = b.dataset.cat===cat ? '1' : '0.18';
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
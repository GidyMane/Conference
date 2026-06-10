<div class="floor-plan-wrapper mb-5">

<style>
.floor-plan-wrapper {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,.08);
    overflow: hidden;
    border: 1px solid #e2e8f0;
}
.floor-plan-header {
    background: linear-gradient(135deg, #1a5f3a 0%, #2d8a3e 100%);
    color: white;
    padding: 24px 28px 20px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.floor-plan-header h3 { font-size: 1.25rem; font-weight: 700; margin: 0 0 4px; }
.floor-plan-header p  { margin: 0; opacity: .8; font-size: .88rem; }
.fp-badge {
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    border-radius: 20px;
    padding: 4px 14px;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .04em;
    white-space: nowrap;
}
.floor-plan-body {
    padding: 24px 28px;
}
.fp-map-container {
    background: #f8faf9;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: auto;
    padding: 16px;
    margin-bottom: 20px;
    cursor: grab;
}
.fp-map-container:active { cursor: grabbing; }
.fp-svg { min-width: 560px; }

/* Booth styles */
.fp-booth {
    cursor: pointer;
    transition: filter .15s;
}
.fp-booth:hover rect { filter: brightness(.92); }
.fp-booth rect { rx: 4; transition: fill .2s; }
.fp-booth.selected rect { stroke-width: 2.5 !important; stroke: #1a5f3a !important; }

/* Tooltip */
.fp-tooltip {
    position: fixed;
    background: #1e293b;
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    pointer-events: none;
    z-index: 9999;
    display: none;
    white-space: nowrap;
    box-shadow: 0 4px 16px rgba(0,0,0,.25);
}
.fp-tooltip::after {
    content: '';
    position: absolute;
    top: 100%; left: 50%; transform: translateX(-50%);
    border: 6px solid transparent;
    border-top-color: #1e293b;
}

/* Legend */
.fp-legend {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 8px;
}
.fp-legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #e8edf2;
    background: white;
    font-size: .82rem;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    user-select: none;
}
.fp-legend-item:hover    { border-color: #2d8a3e; background: #f0fdf4; }
.fp-legend-item.active   { border-color: #2d8a3e; background: #e8f5e9; }
.fp-legend-swatch {
    width: 24px; height: 24px; border-radius: 5px; flex-shrink: 0;
    border: 1px solid rgba(0,0,0,.08);
}
.fp-legend-range {
    font-family: monospace;
    font-size: .78rem;
    color: #64748b;
    margin-top: 1px;
    display: block;
}
.fp-info-bar {
    background: #f0fdf4;
    border: 1px solid #a7f3d0;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: .85rem;
    color: #065f46;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}
.fp-infrastructure {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 14px;
}
.fp-infra-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: .78rem;
    font-weight: 600;
}
</style>

<div class="fp-tooltip" id="fpTooltip"></div>

{{-- Header --}}
<div class="floor-plan-header">
    <div>
        <h3><i class="bi bi-map me-2"></i>Exhibition Ground Floor Plan</h3>
        <p>Review the layout and available booth positions before registering. Hover over a booth to see its category.</p>
    </div>
    <span class="fp-badge">50 Booths · KALRO Conference Grounds</span>
</div>

<div class="floor-plan-body">

    {{-- Info bar --}}
    <div class="fp-info-bar">
        <i class="bi bi-info-circle-fill fs-5 flex-shrink-0"></i>
        <span>Hover over any booth number to see its category. Click a legend item to highlight that category on the map.</span>
    </div>

    {{-- SVG Floor Plan --}}
    <div class="fp-map-container">
    <svg class="fp-svg" width="100%" viewBox="0 0 680 520"
         role="img" xmlns="http://www.w3.org/2000/svg">
        <title>KALRO Conference Exhibition Ground Floor Plan</title>
        <desc>A floor plan showing 50 exhibition booths (G1–G50) arranged around a central KALRO area, with a main gate at the top-left, visitor registration and first aid at the top, networking area in the centre-right, and large machinery area on the left.</desc>

        {{-- ── BACKGROUND ── --}}
        <rect width="680" height="520" fill="#f1f5f0" rx="8"/>

        {{-- ── MAIN GATE + ROAD ── --}}
        <rect x="10" y="10" width="100" height="34" rx="5" fill="#374151"/>
        <text x="60" y="32" text-anchor="middle" font-size="11" font-weight="700" fill="white">MAIN GATE</text>
        <rect x="10" y="46" width="660" height="18" rx="3" fill="#9ca3af" opacity=".5"/>
        <text x="340" y="59" text-anchor="middle" font-size="10" fill="#374151" font-weight="600">ROAD</text>

        {{-- ── KALRO PAVILION (top centre, row of 16 booths) ── --}}
        <rect x="200" y="70" width="390" height="30" rx="4" fill="#166534" opacity=".15" stroke="#166534" stroke-width="1"/>
        <text x="395" y="90" text-anchor="middle" font-size="10" fill="#166534" font-weight="700">KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO KALRO</text>

        {{-- ── LARGE MACHINERY AREA (left block) ── --}}
        <rect x="10" y="110" width="150" height="200" rx="6" fill="#d1fae5" stroke="#6ee7b7" stroke-width="1" stroke-dasharray="5,3"/>
        <text x="85" y="168" text-anchor="middle" font-size="9.5" font-weight="700" fill="#065f46">LARGE MACHINERY</text>
        <text x="85" y="182" text-anchor="middle" font-size="9" fill="#065f46">VEHICLES &amp; TRACTORS</text>

        {{-- ── NETWORKING AREA (centre-right) ── --}}
        <rect x="340" y="145" width="145" height="70" rx="6" fill="#dbeafe" stroke="#93c5fd" stroke-width="1" stroke-dasharray="5,3"/>
        <text x="412" y="178" text-anchor="middle" font-size="10" font-weight="700" fill="#1e40af">NETWORKING AREA</text>

        {{-- ── VISITORS REGISTRATION (top right) ── --}}
        <rect x="490" y="10" width="120" height="28" rx="5" fill="#7c3aed" opacity=".15" stroke="#7c3aed" stroke-width="1"/>
        <text x="550" y="28" text-anchor="middle" font-size="9.5" font-weight="700" fill="#4c1d95">VISITORS REG.</text>

        {{-- ── FIRST AID (top far right) ── --}}
        <rect x="618" y="10" width="54" height="28" rx="5" fill="#dc2626" opacity=".15" stroke="#dc2626" stroke-width="1"/>
        <text x="645" y="28" text-anchor="middle" font-size="9.5" font-weight="700" fill="#991b1b">FIRST AID</text>

        {{-- ── WATER SOURCE ── --}}
        <rect x="195" y="110" width="80" height="22" rx="4" fill="#bfdbfe" stroke="#60a5fa" stroke-width="1"/>
        <text x="235" y="125" text-anchor="middle" font-size="9" font-weight="600" fill="#1e40af">WATER SOURCE</text>

        {{-- ── WASTE BIN ── --}}
        <rect x="590" y="110" width="70" height="22" rx="4" fill="#fef9c3" stroke="#facc15" stroke-width="1"/>
        <text x="625" y="125" text-anchor="middle" font-size="9" font-weight="600" fill="#713f12">WASTE BIN</text>

        {{-- ════════════════════════════════════
             BOOTH RENDERING
             Layout from Excel:
             LEFT COLUMN  (G23–G34): x=170, y stacks top-to-bottom
             BOTTOM ROW   (G7–G22) : y=350, x goes right-to-left
             RIGHT COLUMN (G1–G6)  : x=620, y stacks top-to-bottom
        ════════════════════════════════════ --}}

        @php
        $categories = [
            'research'    => ['label'=>'Research institutions',           'range'=>'G01–G06', 'fill'=>'#bbf7d0','stroke'=>'#16a34a','text'=>'#14532d'],
            'university'  => ['label'=>'Universities & training',          'range'=>'G07–G12', 'fill'=>'#bfdbfe','stroke'=>'#2563eb','text'=>'#1e3a8a'],
            'government'  => ['label'=>'Government agencies',              'range'=>'G13–G17', 'fill'=>'#fde68a','stroke'=>'#d97706','text'=>'#78350f'],
            'private'     => ['label'=>'Private agribusiness',             'range'=>'G18–G22', 'fill'=>'#fed7aa','stroke'=>'#ea580c','text'=>'#7c2d12'],
            'financial'   => ['label'=>'Financial institutions',           'range'=>'G23–G28', 'fill'=>'#e9d5ff','stroke'=>'#7c3aed','text'=>'#4c1d95'],
            'ict'         => ['label'=>'ICT & digital agriculture',        'range'=>'G29–G33', 'fill'=>'#a5f3fc','stroke'=>'#0891b2','text'=>'#164e63'],
            'ngo'         => ['label'=>'Development partners & NGOs',      'range'=>'G34–G38', 'fill'=>'#fda4af','stroke'=>'#e11d48','text'=>'#881337'],
            'input'       => ['label'=>'Input suppliers',                  'range'=>'G39–G44', 'fill'=>'#d9f99d','stroke'=>'#65a30d','text'=>'#365314'],
            'food'        => ['label'=>'Food processing & value addition',  'range'=>'G45–G50', 'fill'=>'#fbcfe8','stroke'=>'#db2777','text'=>'#831843'],
        ];

        // Map booth number → category key
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

        // Booth dimensions
        $bw = 38; $bh = 32;

        // LEFT COLUMN: G23–G34 at x=170, starting y=105 going down
        // (G34 is top, G23 bottom per Excel rows 10–21)
        $leftBooths = ['G34','G33','G32','G31','G30','G29','G28','G27','G26','G25','G24','G23'];
        $leftPositions = [];
        foreach($leftBooths as $i => $b) {
            $leftPositions[$b] = ['x'=>170, 'y'=> 105 + $i * ($bh + 4)];
        }

        // BOTTOM ROW: G7–G22 at y=365 from right (G7 far right) to left (G22 leftmost)
        // G22 G21 G20 G19 G18 G17 G16 G15 G14 G13 G12 G11 G10 G9 G8 G7
        $bottomRowOrder = array_reverse(range(7, 22));
        $bottomPositions = [];
        foreach($bottomRowOrder as $i => $n) {
            $bottomPositions["G$n"] = ['x' => 215 + $i * ($bw + 4), 'y' => 365];
        }

        // RIGHT COLUMN: G1–G6 at x=626, starting y=145 going down
        $rightBooths = ['G1','G2','G3','G4','G5','G6'];
        $rightPositions = [];
        foreach($rightBooths as $i => $b) {
            $rightPositions[$b] = ['x' => 626, 'y' => 145 + $i * ($bh + 4)];
        }

        $allPositions = array_merge($leftPositions, $bottomPositions, $rightPositions);
        @endphp

        {{-- Render every booth --}}
        @foreach($allPositions as $booth => $pos)
        @php
            $cat = $boothCat[$booth] ?? 'research';
            $fill   = $categories[$cat]['fill'];
            $stroke = $categories[$cat]['stroke'];
            $txtClr = $categories[$cat]['text'];
            $cx = $pos['x'] + $bw/2;
            $cy = $pos['y'] + $bh/2;
            $catLabel = $categories[$cat]['label'];
        @endphp
        <g class="fp-booth" data-booth="{{ $booth }}" data-cat="{{ $cat }}" data-label="{{ $catLabel }}"
           onmouseenter="fpShowTip(event, '{{ $booth }} — {{ $catLabel }}')"
           onmouseleave="fpHideTip()"
           onclick="fpSelectBooth('{{ $cat }}')">
            <rect x="{{ $pos['x'] }}" y="{{ $pos['y'] }}"
                  width="{{ $bw }}" height="{{ $bh }}" rx="4"
                  fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1"/>
            <text x="{{ $cx }}" y="{{ $cy }}" text-anchor="middle"
                  dominant-baseline="central"
                  font-size="9" font-weight="700" fill="{{ $txtClr }}">{{ $booth }}</text>
        </g>
        @endforeach

        {{-- Booth count label --}}
        <text x="340" y="420" text-anchor="middle" font-size="10" fill="#64748b" font-style="italic">
            50 exhibition booths · hover a booth for details
        </text>

        {{-- Compass --}}
        <g transform="translate(640,450)">
            <circle cx="0" cy="0" r="22" fill="white" stroke="#e2e8f0" stroke-width="1"/>
            <polygon points="0,-18 5,0 0,-4 -5,0" fill="#1a5f3a"/>
            <polygon points="0,18 5,0 0,4 -5,0"   fill="#94a3b8"/>
            <text x="0" y="-6" text-anchor="middle" font-size="9" font-weight="700" fill="#1a5f3a">N</text>
        </g>

    </svg>
    </div>

    {{-- Infrastructure badges --}}
    <div class="fp-infrastructure mb-4">
        <span class="fp-infra-badge" style="background:#dbeafe;color:#1e40af;">
            <i class="bi bi-droplet-fill"></i> Water Source
        </span>
        <span class="fp-infra-badge" style="background:#dcfce7;color:#15803d;">
            <i class="bi bi-wifi"></i> Networking Area
        </span>
        <span class="fp-infra-badge" style="background:#fee2e2;color:#dc2626;">
            <i class="bi bi-heart-pulse-fill"></i> First Aid Station
        </span>
        <span class="fp-infra-badge" style="background:#fef9c3;color:#713f12;">
            <i class="bi bi-trash3-fill"></i> Waste Bins
        </span>
        <span class="fp-infra-badge" style="background:#f1f5f9;color:#475569;">
            <i class="bi bi-truck"></i> Large Machinery Area
        </span>
    </div>

    {{-- Legend --}}
    <p style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;font-weight:700;color:#64748b;margin-bottom:10px;">
        <i class="bi bi-info-circle me-1"></i> Booth Categories — click to highlight on map
    </p>
    <div class="fp-legend">
        @foreach($categories as $key => $cat)
        <div class="fp-legend-item" data-cat="{{ $key }}" onclick="fpSelectBooth('{{ $key }}')">
            <div class="fp-legend-swatch" style="background:{{ $cat['fill'] }};border-color:{{ $cat['stroke'] }};"></div>
            <div>
                <div style="font-weight:600;color:#1e293b;line-height:1.3;">{{ $cat['label'] }}</div>
                <span class="fp-legend-range">{{ $cat['range'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

</div>
</div>

<script>
(function(){
    const tooltip  = document.getElementById('fpTooltip');
    let activeCat  = null;

    window.fpShowTip = function(e, text) {
        tooltip.textContent = text;
        tooltip.style.display = 'block';
        tooltip.style.left = (e.clientX - tooltip.offsetWidth/2) + 'px';
        tooltip.style.top  = (e.clientY - tooltip.offsetHeight - 14) + 'px';
    };
    window.fpHideTip = function() {
        tooltip.style.display = 'none';
    };
    document.addEventListener('mousemove', function(e) {
        if (tooltip.style.display === 'block') {
            tooltip.style.left = (e.clientX - tooltip.offsetWidth/2) + 'px';
            tooltip.style.top  = (e.clientY - tooltip.offsetHeight - 14) + 'px';
        }
    });

    window.fpSelectBooth = function(cat) {
        if (activeCat === cat) {
            // deselect
            activeCat = null;
            document.querySelectorAll('.fp-booth').forEach(b => b.style.opacity = '1');
            document.querySelectorAll('.fp-legend-item').forEach(l => l.classList.remove('active'));
        } else {
            activeCat = cat;
            document.querySelectorAll('.fp-booth').forEach(b => {
                b.style.opacity = b.dataset.cat === cat ? '1' : '0.25';
            });
            document.querySelectorAll('.fp-legend-item').forEach(l => {
                l.classList.toggle('active', l.dataset.cat === cat);
            });
        }
    };
})();
</script>

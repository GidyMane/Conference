<div class="fp-wrap mb-5">
<style>
.fp-wrap{border-radius:18px;overflow:hidden;border:1px solid #d1fae5;background:#fff;box-shadow:0 4px 32px rgba(0,0,0,.09);}
.fp-head{background:#14532d;color:#fff;padding:22px 28px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.fp-head h3{font-size:1.1rem;font-weight:700;margin:0 0 3px;display:flex;align-items:center;gap:8px;}
.fp-head p{margin:0;opacity:.72;font-size:.82rem;}
.fp-badge{background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);border-radius:20px;padding:4px 14px;font-size:.74rem;font-weight:700;letter-spacing:.04em;}
.fp-body{padding:20px 24px 24px;}
.fp-hint{background:#f0fdf4;border:1px solid #86efac;border-radius:9px;padding:10px 14px;font-size:.82rem;color:#166534;display:flex;align-items:center;gap:9px;margin-bottom:16px;font-weight:500;}
.fp-map{overflow-x:auto;border-radius:12px;border:1px solid #d1e7d4;background:#e8efe8;}
.fp-map::-webkit-scrollbar{height:5px;}
.fp-map::-webkit-scrollbar-thumb{background:#a5c4a5;border-radius:3px;}
.fp-booth{cursor:pointer;}
.fp-booth:hover .fp-b{filter:brightness(.85);}
.fp-tip{position:fixed;background:#0f172a;color:#fff;padding:7px 13px;border-radius:8px;font-size:12px;font-weight:600;pointer-events:none;z-index:9999;display:none;white-space:nowrap;box-shadow:0 4px 16px rgba(0,0,0,.35);}
.fp-tip::after{content:'';position:absolute;top:100%;left:50%;transform:translateX(-50%);border:5px solid transparent;border-top-color:#0f172a;}
.fp-divider{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;display:flex;align-items:center;gap:10px;margin:18px 0 10px;}
.fp-divider::before,.fp-divider::after{content:'';flex:1;height:1px;background:#e2e8f0;}
.fp-infra{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:4px;}
.fp-ib{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:.76rem;font-weight:600;border:1px solid transparent;}
.fp-legend{display:grid;grid-template-columns:repeat(auto-fill,minmax(205px,1fr));gap:7px;}
.fp-leg{display:flex;align-items:center;gap:9px;padding:8px 11px;border-radius:9px;border:1.5px solid #f1f5f9;background:#fafbfc;font-size:.79rem;cursor:pointer;transition:all .14s;user-select:none;}
.fp-leg:hover{border-color:#6ee7b7;background:#f0fdf4;transform:translateY(-1px);}
.fp-leg.on{border-color:#16a34a;background:#dcfce7;}
.fp-sw{width:20px;height:20px;border-radius:4px;flex-shrink:0;}
.fp-rng{font-family:monospace;font-size:.7rem;color:#94a3b8;display:block;margin-top:1px;}
.fp-lname{font-weight:600;color:#1e293b;line-height:1.3;}
</style>

<div class="fp-tip" id="fpTip"></div>

<div class="fp-head">
    <div>
        <h3>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
            Exhibition Ground Floor Plan
        </h3>
        <p>Review booth positions and categories before registering</p>
    </div>
    <span class="fp-badge">50 Booths &nbsp;·&nbsp; KALRO Conference Grounds</span>
</div>

<div class="fp-body">

<div class="fp-hint">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    Hover any booth to see its category. Click a legend tile to highlight that group on the map.
</div>

<div class="fp-map">
<svg width="950" height="820" viewBox="0 0 950 820"
     role="img" xmlns="http://www.w3.org/2000/svg" style="display:block;">
<title>KALRO Exhibition Ground Floor Plan</title>
<desc>U-shaped layout of 50 exhibition booths. Left column G23-G34, bottom row G7-G22, right column G1-G6. KALRO pavilion along the top. Large machinery area on the left. Networking area centre-right.</desc>

@php
$cats=[
  'research'  =>['f'=>'#bbf7d0','s'=>'#15803d','t'=>'#14532d','label'=>'Research institutions',             'range'=>'G01–G06'],
  'university'=>['f'=>'#bfdbfe','s'=>'#2563eb','t'=>'#1e3a8a','label'=>'Universities & training institutions','range'=>'G07–G12'],
  'government'=>['f'=>'#fde68a','s'=>'#ca8a04','t'=>'#713f12','label'=>'Government agencies',               'range'=>'G13–G17'],
  'private'   =>['f'=>'#fed7aa','s'=>'#ea580c','t'=>'#7c2d12','label'=>'Private agribusiness companies',    'range'=>'G18–G22'],
  'financial' =>['f'=>'#e9d5ff','s'=>'#7c3aed','t'=>'#4c1d95','label'=>'Financial institutions',           'range'=>'G23–G28'],
  'ict'       =>['f'=>'#99f6e4','s'=>'#0d9488','t'=>'#134e4a','label'=>'ICT & digital agriculture',        'range'=>'G29–G33'],
  'ngo'       =>['f'=>'#fca5a5','s'=>'#dc2626','t'=>'#7f1d1d','label'=>'Development partners & NGOs',      'range'=>'G34–G38'],
  'input'     =>['f'=>'#d9f99d','s'=>'#65a30d','t'=>'#365314','label'=>'Input suppliers',                  'range'=>'G39–G44'],
  'food'      =>['f'=>'#fbcfe8','s'=>'#db2777','t'=>'#831843','label'=>'Food processing & value addition', 'range'=>'G45–G50'],
];
$bc=[];
foreach(range(1,6)  as $n) $bc["G$n"]='research';
foreach(range(7,12) as $n) $bc["G$n"]='university';
foreach(range(13,17)as $n) $bc["G$n"]='government';
foreach(range(18,22)as $n) $bc["G$n"]='private';
foreach(range(23,28)as $n) $bc["G$n"]='financial';
foreach(range(29,33)as $n) $bc["G$n"]='ict';
foreach(range(34,38)as $n) $bc["G$n"]='ngo';
foreach(range(39,44)as $n) $bc["G$n"]='input';
foreach(range(45,50)as $n) $bc["G$n"]='food';

// Grid: col_w=36, row_h=36, x0=16, y0=12
$cw=36;$rh=36;$x0=16;$y0=12;
$bw=32;$bh=32;$bp=2;
function gx($c,$x0,$cw){return $x0+($c-1)*$cw;}
function gy($r,$y0,$rh){return $y0+($r-1)*$rh;}

$pos=[];
// Left col G34(r10)→G23(r21) at col9
foreach(['G34','G33','G32','G31','G30','G29','G28','G27','G26','G25','G24','G23'] as $i=>$b)
    $pos[$b]=[gx(9,$x0,$cw)+$bp, gy(10+$i,$y0,$rh)+$bp];
// Bottom row G22(c10)→G7(c25) at row22
foreach(range(22,7,-1) as $i=>$n)
    $pos["G$n"]=[gx(10+$i,$x0,$cw)+$bp, gy(22,$y0,$rh)+$bp];
// Right col G1(r16)→G6(r21) at col26
foreach(range(1,6) as $i)
    $pos["G$i"]=[gx(26,$x0,$cw)+$bp, gy(15+$i,$y0,$rh)+$bp];
@endphp

{{-- GROUND --}}
<rect width="950" height="820" fill="#ebf2eb"/>
{{-- Subtle grid lines for floor-plan feel --}}
@for($gxi=0;$gxi<=950;$gxi+=36)
<line x1="{{ $gxi }}" y1="0" x2="{{ $gxi }}" y2="820" stroke="#d4e4d4" stroke-width="0.4"/>
@endfor
@for($gyi=0;$gyi<=820;$gyi+=36)
<line x1="0" y1="{{ $gyi }}" x2="950" y2="{{ $gyi }}" stroke="#d4e4d4" stroke-width="0.4"/>
@endfor

{{-- ══ MAIN GATE — horizontal pill top-left, fully readable ══ --}}
<rect x="14" y="80" width="92" height="36" rx="8" fill="#1e293b"/>
<text x="60" y="98" text-anchor="middle" dominant-baseline="central"
      font-size="11" font-weight="700" fill="#ffffff" font-family="sans-serif"
      letter-spacing="0.5">MAIN GATE</text>

{{-- Gate posts --}}
<rect x="14" y="117" width="10" height="20" rx="2" fill="#374151"/>
<rect x="96" y="117" width="10" height="20" rx="2" fill="#374151"/>

{{-- ══ ROAD ══ --}}
<rect x="14" y="120" width="922" height="30" rx="4" fill="#b0bec5" opacity=".55"/>
{{-- dashes --}}
@for($d=0;$d<22;$d++)
<rect x="{{ 50+$d*42 }}" y="133" width="26" height="4" rx="2" fill="#fff" opacity=".6"/>
@endfor
<text x="480" y="136" text-anchor="middle" dominant-baseline="central"
      font-size="11" font-weight="700" fill="#37474f" font-family="sans-serif"
      letter-spacing="4">ROAD</text>

{{-- ══ VISITORS REGISTRATION ══ --}}
<rect x="{{gx(11,$x0,$cw)}}" y="{{ gy(1,$y0,$rh) }}" width="152" height="36" rx="7"
      fill="#eff6ff" stroke="#93c5fd" stroke-width="1.5"/>
<text x="{{ gx(11,$x0,$cw)+76 }}" y="{{ gy(1,$y0,$rh)+18 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="10" font-weight="700" fill="#1d4ed8" font-family="sans-serif">VISITORS REGISTRATION</text>

{{-- ══ FIRST AID ══ --}}
<rect x="{{ gx(16,$x0,$cw) }}" y="{{ gy(1,$y0,$rh) }}" width="100" height="36" rx="7"
      fill="#fef2f2" stroke="#fca5a5" stroke-width="1.5"/>
<text x="{{ gx(16,$x0,$cw)+50 }}" y="{{ gy(1,$y0,$rh)+18 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="10" font-weight="700" fill="#dc2626" font-family="sans-serif">+ FIRST AID</text>

{{-- ══ WATER SOURCE ══ --}}
<rect x="{{ gx(9,$x0,$cw) }}" y="{{ gy(7,$y0,$rh) }}" width="138" height="34" rx="7"
      fill="#e0f2fe" stroke="#7dd3fc" stroke-width="1.5"/>
<text x="{{ gx(9,$x0,$cw)+69 }}" y="{{ gy(7,$y0,$rh)+17 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="10" font-weight="700" fill="#0369a1" font-family="sans-serif">WATER SOURCE</text>

{{-- ══ WASTE BIN ══ --}}
<rect x="{{ gx(16,$x0,$cw) }}" y="{{ gy(7,$y0,$rh) }}" width="90" height="34" rx="7"
      fill="#fefce8" stroke="#fcd34d" stroke-width="1.5"/>
<text x="{{ gx(16,$x0,$cw)+45 }}" y="{{ gy(7,$y0,$rh)+17 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="10" font-weight="700" fill="#92400e" font-family="sans-serif">WASTE BIN</text>

{{-- ══ KALRO PAVILION — 16 rich dark-green blocks ══ --}}
@for($k=0;$k<16;$k++)
@php $kx=gx(10+$k,$x0,$cw); $ky=gy(9,$y0,$rh); @endphp
<rect x="{{ $kx }}" y="{{ $ky }}" width="{{ $bw }}" height="{{ $bh }}" rx="5"
      fill="#14532d" stroke="#052e16" stroke-width="1"/>
<rect x="{{ $kx+1 }}" y="{{ $ky+1 }}" width="{{ $bw-2 }}" height="10" rx="4"
      fill="rgba(255,255,255,.08)"/>
<text x="{{ $kx+$bw/2 }}" y="{{ $ky+$bh/2+1 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="7" font-weight="700" fill="#86efac" font-family="sans-serif"
      letter-spacing="0.3">KALRO</text>
@endfor

{{-- ══ LARGE MACHINERY — taller box with rotated label ══ --}}
@php
$lmx=gx(3,$x0,$cw); $lmy=gy(10,$y0,$rh);
$lmw=gx(8,$x0,$cw)-$lmx+$cw; $lmh=gy(21,$y0,$rh)-$lmy+$bh+4;
@endphp
<rect x="{{ $lmx }}" y="{{ $lmy }}" width="{{ $lmw }}" height="{{ $lmh }}" rx="10"
      fill="#fef9c3" stroke="#f59e0b" stroke-width="1.5" stroke-dasharray="9,4"/>
<rect x="{{ $lmx }}" y="{{ $lmy }}" width="{{ $lmw }}" height="22" rx="10"
      fill="#fde68a" opacity=".6"/>
{{-- Horizontal label centred inside the box --}}
<text x="{{ $lmx+$lmw/2 }}" y="{{ $lmy+$lmh/2-8 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="11" font-weight="700" fill="#92400e" font-family="sans-serif">LARGE MACHINERY</text>
<text x="{{ $lmx+$lmw/2 }}" y="{{ $lmy+$lmh/2+10 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="9.5" fill="#b45309" font-family="sans-serif">Vehicles &amp; Tractors</text>

{{-- ══ NETWORKING AREA ══ --}}
@php $nx=gx(15,$x0,$cw); $ny=gy(11,$y0,$rh); $nw=gx(20,$x0,$cw)-$nx+$cw+4; $nh=gy(15,$y0,$rh)-$ny+$rh; @endphp
<rect x="{{ $nx }}" y="{{ $ny }}" width="{{ $nw }}" height="{{ $nh }}" rx="10"
      fill="#fdf4ff" stroke="#c084fc" stroke-width="1.5" stroke-dasharray="9,4"/>
<rect x="{{ $nx }}" y="{{ $ny }}" width="{{ $nw }}" height="22" rx="10"
      fill="#e9d5ff" opacity=".6"/>
<text x="{{ $nx+$nw/2 }}" y="{{ $ny+$nh/2-8 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="11" font-weight="700" fill="#7e22ce" font-family="sans-serif">NETWORKING AREA</text>
<text x="{{ $nx+$nw/2 }}" y="{{ $ny+$nh/2+10 }}"
      text-anchor="middle" dominant-baseline="central"
      font-size="9" fill="#a21caf" font-family="sans-serif">Wi-Fi · Lounge</text>

{{-- ══ ALL 50 BOOTHS ══ --}}
@foreach($pos as $booth=>$p)
@php
  $cat=$bc[$booth]??'research';
  $c=$cats[$cat];
  $px=$p[0];$py=$p[1];
  $cx2=$px+$bw/2;$cy2=$py+$bh/2;
@endphp
<g class="fp-booth" data-cat="{{ $cat }}"
   onmouseenter="fpT(event,'{{ $booth }} — {{ $c['label'] }}')"
   onmouseleave="fpH()"
   onclick="fpS('{{ $cat }}')">
  {{-- Booth rectangle --}}
  <rect class="fp-b" x="{{ $px }}" y="{{ $py }}" width="{{ $bw }}" height="{{ $bh }}" rx="5"
        fill="{{ $c['f'] }}" stroke="{{ $c['s'] }}" stroke-width="1.5"/>
  {{-- Inner shine --}}
  <rect x="{{ $px+2 }}" y="{{ $py+2 }}" width="{{ $bw-4 }}" height="9" rx="3"
        fill="rgba(255,255,255,.38)" pointer-events="none"/>
  {{-- Label --}}
  <text x="{{ $cx2 }}" y="{{ $cy2+1 }}" text-anchor="middle" dominant-baseline="central"
        font-size="8.5" font-weight="700" fill="{{ $c['t'] }}" font-family="sans-serif"
        pointer-events="none">{{ $booth }}</text>
</g>
@endforeach

{{-- ══ COMPASS ══ --}}
<g transform="translate(920,790)">
  <circle cx="0" cy="0" r="22" fill="white" stroke="#d1d5db" stroke-width="1.5"/>
  <polygon points="0,-16 4,2 0,-2 -4,2" fill="#166534"/>
  <polygon points="0,16 4,-2 0,2 -4,-2" fill="#94a3b8"/>
  <line x1="-16" y1="0" x2="16" y2="0" stroke="#e2e8f0" stroke-width="0.8"/>
  <line x1="0" y1="-16" x2="0" y2="16" stroke="#e2e8f0" stroke-width="0.8"/>
  <text x="0" y="-7" text-anchor="middle" dominant-baseline="central"
        font-size="8" font-weight="700" fill="#166534" font-family="sans-serif">N</text>
  <text x="0" y="13" text-anchor="middle" dominant-baseline="central"
        font-size="7" fill="#9ca3af" font-family="sans-serif">S</text>
  <text x="-13" y="1" text-anchor="middle" dominant-baseline="central"
        font-size="7" fill="#9ca3af" font-family="sans-serif">W</text>
  <text x="13" y="1" text-anchor="middle" dominant-baseline="central"
        font-size="7" fill="#9ca3af" font-family="sans-serif">E</text>
</g>

{{-- Caption --}}
<text x="475" y="812" text-anchor="middle" dominant-baseline="central"
      font-size="9.5" fill="#9ca3af" font-family="sans-serif" letter-spacing=".5">
    50 exhibition booths (G1–G50) · hover any booth for details
</text>

</svg>
</div>

<div class="fp-divider">Venue Infrastructure</div>
<div class="fp-infra">
    <span class="fp-ib" style="background:#e0f2fe;color:#0369a1;border-color:#7dd3fc;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="#0369a1" aria-hidden="true"><path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/></svg>
        Water Source
    </span>
    <span class="fp-ib" style="background:#fef2f2;color:#dc2626;border-color:#fca5a5;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" aria-hidden="true"><path d="M12 2v7M12 2l-3 3M12 2l3 3"/><rect x="5" y="9" width="14" height="13" rx="2"/><line x1="9" y1="14" x2="15" y2="14"/><line x1="12" y1="11" x2="12" y2="17"/></svg>
        First Aid
    </span>
    <span class="fp-ib" style="background:#fdf4ff;color:#7e22ce;border-color:#c084fc;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#7e22ce" stroke-width="2" aria-hidden="true"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1" fill="#7e22ce"/></svg>
        Networking Area
    </span>
    <span class="fp-ib" style="background:#fefce8;color:#92400e;border-color:#fde68a;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        Waste Bin
    </span>
    <span class="fp-ib" style="background:#fef9c3;color:#713f12;border-color:#fde68a;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#713f12" stroke-width="2" aria-hidden="true"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        Large Machinery
    </span>
    <span class="fp-ib" style="background:#f0fdf4;color:#166534;border-color:#86efac;">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2" aria-hidden="true"><rect x="3" y="7" width="18" height="14" rx="1.5"/><path d="M3 7l9-4 9 4"/></svg>
        KALRO Pavilion
    </span>
</div>

<div class="fp-divider">Booth Categories — click to highlight</div>
<div class="fp-legend">
    @foreach($cats as $key=>$cat)
    <div class="fp-leg" data-cat="{{ $key }}" onclick="fpS('{{ $key }}')">
        <div class="fp-sw" style="background:{{ $cat['f'] }};box-shadow:inset 0 0 0 1.5px {{ $cat['s'] }};"></div>
        <div>
            <div class="fp-lname">{{ $cat['label'] }}</div>
            <span class="fp-rng">{{ $cat['range'] }}</span>
        </div>
    </div>
    @endforeach
</div>

</div>
</div>

<script>
(function(){
var tip=document.getElementById('fpTip'),act=null;
window.fpT=function(e,t){
    tip.textContent=t;tip.style.display='block';
    var hw=tip.offsetWidth||120;
    tip.style.left=Math.max(4,e.clientX-Math.round(hw/2))+'px';
    tip.style.top=(e.clientY-50)+'px';
};
window.fpH=function(){tip.style.display='none';};
document.addEventListener('mousemove',function(e){
    if(tip.style.display!=='none'){
        var hw=tip.offsetWidth||120;
        tip.style.left=Math.max(4,e.clientX-Math.round(hw/2))+'px';
        tip.style.top=(e.clientY-50)+'px';
    }
});
window.fpS=function(cat){
    if(act===cat){act=null;rst();return;}
    act=cat;
    document.querySelectorAll('.fp-booth').forEach(function(b){
        b.style.opacity=b.dataset.cat===cat?'1':'0.1';
    });
    document.querySelectorAll('.fp-leg').forEach(function(l){
        l.classList.toggle('on',l.dataset.cat===cat);
    });
};
function rst(){
    document.querySelectorAll('.fp-booth').forEach(function(b){b.style.opacity='1';});
    document.querySelectorAll('.fp-leg').forEach(function(l){l.classList.remove('on');});
}
})();
</script>
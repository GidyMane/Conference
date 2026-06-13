@extends('layouts.header')

@section('title', 'Exhibition Floor Plan')

@section('content')

@php
$cats = [
    'research'   => ['f'=>'#bbf7d0','s'=>'#15803d','t'=>'#14532d','label'=>'Research institutions',             'range'=>'G01–G06'],
    'university' => ['f'=>'#bfdbfe','s'=>'#2563eb','t'=>'#1e3a8a','label'=>'Universities & training institutions','range'=>'G07–G12'],
    'government' => ['f'=>'#fde68a','s'=>'#ca8a04','t'=>'#713f12','label'=>'Government agencies',               'range'=>'G13–G17'],
    'private'    => ['f'=>'#fed7aa','s'=>'#ea580c','t'=>'#7c2d12','label'=>'Private agribusiness companies',    'range'=>'G18–G22'],
    'financial'  => ['f'=>'#e9d5ff','s'=>'#7c3aed','t'=>'#4c1d95','label'=>'Financial institutions',           'range'=>'G23–G28'],
    'ict'        => ['f'=>'#99f6e4','s'=>'#0d9488','t'=>'#134e4a','label'=>'ICT & digital agriculture',        'range'=>'G29–G33'],
    'ngo'        => ['f'=>'#fca5a5','s'=>'#dc2626','t'=>'#7f1d1d','label'=>'Development partners & NGOs',      'range'=>'G34–G38'],
    'input'      => ['f'=>'#d9f99d','s'=>'#65a30d','t'=>'#365314','label'=>'Input suppliers',                  'range'=>'G39–G44'],
    'food'       => ['f'=>'#fbcfe8','s'=>'#db2777','t'=>'#831843','label'=>'Food processing & value addition', 'range'=>'G45–G50'],
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

// Grid: col_w=52, row_h=50 — large enough to fill a full page
$cw=52; $rh=50; $x0=20; $y0=16;
$bw=48; $bh=46; $bp=2;
function gx2($c,$x0,$cw){ return $x0+($c-1)*$cw; }
function gy2($r,$y0,$rh){ return $y0+($r-1)*$rh; }

$pos=[];
foreach(['G34','G33','G32','G31','G30','G29','G28','G27','G26','G25','G24','G23'] as $i=>$b)
    $pos[$b]=[gx2(9,$x0,$cw)+$bp, gy2(10+$i,$y0,$rh)+$bp];
foreach(range(22,7,-1) as $i=>$n)
    $pos["G$n"]=[gx2(10+$i,$x0,$cw)+$bp, gy2(22,$y0,$rh)+$bp];
foreach(range(1,6) as $i)
    $pos["G$i"]=[gx2(26,$x0,$cw)+$bp, gy2(15+$i,$y0,$rh)+$bp];

// SVG canvas size
$svgW = gx2(26,$x0,$cw) + $bw + $x0 + 20;  // ~1400px
$svgH = gy2(22,$y0,$rh) + $bh + 80;          // ~1150px
@endphp

<style>
/* ── Page ── */
body { background: #f0f4f0; }

/* ── Hero ── */
.fp-page-hero {
    background: linear-gradient(135deg, #052e16 0%, #14532d 50%, #166534 100%);
    padding: 52px 0 44px;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.fp-page-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.fp-page-hero h1 { font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; margin-bottom: 10px; position: relative; }
.fp-page-hero p  { font-size: 1.05rem; opacity: .82; margin-bottom: 0; position: relative; }
.fp-hero-badges  { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-top: 18px; position: relative; }
.fp-hero-badge {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 20px;
    padding: 5px 16px;
    font-size: .78rem; font-weight: 600;
}

/* ── Booking CTA ── */
.fp-booking-bar {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    padding: 18px 0;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.fp-booking-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
}
.fp-booking-text { font-size: .9rem; color: #374151; }
.fp-booking-text strong { color: #14532d; font-size: 1rem; }
.fp-booking-emails { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.fp-email-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    border-radius: 22px;
    font-size: .84rem; font-weight: 700;
    text-decoration: none;
    transition: all .16s;
    border: 2px solid transparent;
}
.fp-email-btn.primary {
    background: #14532d; color: white;
}
.fp-email-btn.primary:hover { background: #166534; color: white; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(20,83,45,.25); }
.fp-email-btn.secondary {
    background: white; color: #14532d; border-color: #86efac;
}
.fp-email-btn.secondary:hover { background: #f0fdf4; color: #14532d; transform: translateY(-1px); }

/* ── Map area ── */
.fp-map-section { padding: 32px 0 20px; }
.fp-map-hint {
    display: flex; align-items: center; gap: 10px;
    background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px;
    padding: 11px 16px; font-size: .84rem; color: #166534; font-weight: 500;
    margin-bottom: 18px;
}
.fp-map-scroll {
    background: #e8efe8;
    border-radius: 14px;
    border: 1px solid #c8d8c8;
    overflow-x: auto;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
}
.fp-map-scroll::-webkit-scrollbar { height: 7px; }
.fp-map-scroll::-webkit-scrollbar-track { background: #dceadc; border-radius: 4px; }
.fp-map-scroll::-webkit-scrollbar-thumb { background: #86b886; border-radius: 4px; }

/* ── Booth ── */
.fp-booth { cursor: pointer; }
.fp-booth rect.fp-br { transition: filter .14s, transform .14s; transform-box: fill-box; transform-origin: center; }
.fp-booth:hover rect.fp-br { filter: brightness(.82) drop-shadow(0 3px 6px rgba(0,0,0,.2)); transform: scale(1.06); }

/* ── Tooltip ── */
.fp-tip {
    position: fixed; background: #0f172a; color: white;
    padding: 8px 15px; border-radius: 9px; font-size: 12.5px; font-weight: 600;
    pointer-events: none; z-index: 9999; display: none; white-space: nowrap;
    box-shadow: 0 6px 22px rgba(0,0,0,.35);
    border: 1px solid rgba(255,255,255,.08);
}
.fp-tip::after {
    content:''; position:absolute; top:100%; left:50%; transform:translateX(-50%);
    border:6px solid transparent; border-top-color:#0f172a;
}

/* ── Infra / Legend sections ── */
.fp-section-title {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: #94a3b8;
    display: flex; align-items: center; gap: 10px;
    margin: 28px 0 12px;
}
.fp-section-title::before, .fp-section-title::after {
    content: ''; flex: 1; height: 1px; background: #e2e8f0;
}
.fp-infra { display: flex; flex-wrap: wrap; gap: 8px; }
.fp-ib {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 20px;
    font-size: .79rem; font-weight: 600; border: 1px solid transparent;
}
.fp-legend {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 8px;
    margin-bottom: 40px;
}
.fp-leg {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    border: 1.5px solid #f1f5f9; background: white;
    font-size: .81rem; cursor: pointer;
    transition: all .14s; user-select: none;
}
.fp-leg:hover { border-color: #6ee7b7; background: #f0fdf4; transform: translateY(-1px); box-shadow: 0 3px 10px rgba(0,0,0,.06); }
.fp-leg.on { border-color: #16a34a; background: #dcfce7; }
.fp-sw { width: 24px; height: 24px; border-radius: 5px; flex-shrink: 0; }
.fp-rng { font-family: monospace; font-size: .73rem; color: #94a3b8; display: block; margin-top: 1px; }
.fp-lname { font-weight: 600; color: #1e293b; line-height: 1.3; }
</style>

<div class="fp-tip" id="fpTip"></div>

{{-- ── HERO ── --}}
<div class="fp-page-hero">
    <div class="container">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:10px;opacity:.9"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
            Exhibition Ground Floor Plan
        </h1>
        <p>2nd KALRO Scientific Conference and Innovation Expo · Exhibition Grounds</p>
        <div class="fp-hero-badges">
            <span class="fp-hero-badge">🏛 50 Exhibition Booths</span>
            <span class="fp-hero-badge">📍 KALRO Conference Grounds</span>
            <span class="fp-hero-badge">🗺 Hover booths to explore</span>
            <span class="fp-hero-badge" style="background:rgba(251,191,36,.22);border-color:rgba(251,191,36,.4);color:#fef9c3;">
                🕑 Setup begins Sunday from 2:00 PM
            </span>
        </div>
    </div>
</div>

{{-- ── SETUP NOTICE BANNER ── --}}
<div style="background:#fffbeb;border-bottom:2px solid #fde68a;padding:14px 0;">
    <div class="container" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <div style="width:36px;height:36px;background:#fef08a;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.1rem;">🕑</div>
        <div>
            <strong style="color:#92400e;font-size:.95rem;">Exhibitor Setup Notice</strong>
            <span style="color:#78350f;font-size:.9rem;margin-left:8px;">Exhibitors can start setting up on <strong>Sunday from 2:00 PM</strong>. Please plan your arrival accordingly.</span>
        </div>
    </div>
</div>

{{-- ── STICKY BOOKING BAR ── --}}
<div class="fp-booking-bar">
    <div class="container fp-booking-inner">
        <div class="fp-booking-text">
            <strong>Want to book a specific booth?</strong><br>
            Send an email to reserve your preferred position on the floor plan.
        </div>
        <div class="fp-booking-emails">
            <a href="mailto:kalroexpo2026@gmail.com" class="fp-email-btn primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                kalroexpo2026@gmail.com
            </a>
            <a href="mailto:kalroconference2026@gmail.com" class="fp-email-btn secondary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                kalroconference2026@gmail.com
            </a>
        </div>
    </div>
</div>

{{-- ── MAP ── --}}
<div class="fp-map-section">
    <div class="container-fluid px-4">

        <div class="fp-map-hint">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#166634" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Hover any booth for its category. Click a legend tile to highlight that group. Click again to reset.
        </div>

        <div class="fp-map-scroll">
        <svg width="{{ $svgW }}" height="{{ $svgH }}" viewBox="0 0 {{ $svgW }} {{ $svgH }}"
             role="img" xmlns="http://www.w3.org/2000/svg" style="display:block;">
            <title>KALRO Exhibition Ground Floor Plan — 50 booths G1–G50</title>

            {{-- Grid background --}}
            <rect width="{{ $svgW }}" height="{{ $svgH }}" fill="#ebf2eb"/>
            @for($gxi=0; $gxi<=$svgW; $gxi+=$cw)
            <line x1="{{ $gxi }}" y1="0" x2="{{ $gxi }}" y2="{{ $svgH }}" stroke="#cfdecf" stroke-width="0.5"/>
            @endfor
            @for($gyi=0; $gyi<=$svgH; $gyi+=$rh)
            <line x1="0" y1="{{ $gyi }}" x2="{{ $svgW }}" y2="{{ $gyi }}" stroke="#cfdecf" stroke-width="0.5"/>
            @endfor

            {{-- MAIN GATE --}}
            <rect x="14" y="{{ gy2(3,$y0,$rh) }}" width="130" height="48" rx="9" fill="#1e293b"/>
            <text x="79" y="{{ gy2(3,$y0,$rh)+24 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="15" font-weight="700" fill="#ffffff" font-family="sans-serif"
                  letter-spacing="1.5">MAIN GATE</text>
            {{-- Gate posts --}}
            <rect x="14"  y="{{ gy2(3,$y0,$rh)+50 }}" width="14" height="26" rx="3" fill="#374151"/>
            <rect x="130" y="{{ gy2(3,$y0,$rh)+50 }}" width="14" height="26" rx="3" fill="#374151"/>

            {{-- ROAD --}}
            <rect x="14" y="{{ gy2(4,$y0,$rh) }}" width="{{ $svgW - 28 }}" height="38" rx="5" fill="#9ca3af" opacity=".5"/>
            @for($d=0; $d<28; $d++)
            <rect x="{{ 60+$d*54 }}" y="{{ gy2(4,$y0,$rh)+17 }}" width="34" height="5" rx="3" fill="white" opacity=".65"/>
            @endfor
            <text x="{{ $svgW/2 }}" y="{{ gy2(4,$y0,$rh)+19 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="14" font-weight="700" fill="#374151" font-family="sans-serif"
                  letter-spacing="6">ROAD</text>

            {{-- VISITORS REGISTRATION --}}
            @php $vx = gx2(11,$x0,$cw); $vy = gy2(1,$y0,$rh); @endphp
            <rect x="{{ $vx }}" y="{{ $vy }}" width="220" height="46" rx="9" fill="#eff6ff" stroke="#93c5fd" stroke-width="2"/>
            <text x="{{ $vx+110 }}" y="{{ $vy+23 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="13" font-weight="700" fill="#1d4ed8" font-family="sans-serif">VISITORS REGISTRATION</text>

            {{-- FIRST AID --}}
            @php $fx = gx2(16,$x0,$cw); $fy = gy2(1,$y0,$rh); @endphp
            <rect x="{{ $fx }}" y="{{ $fy }}" width="148" height="46" rx="9" fill="#fef2f2" stroke="#fca5a5" stroke-width="2"/>
            <text x="{{ $fx+74 }}" y="{{ $fy+23 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="13" font-weight="700" fill="#dc2626" font-family="sans-serif">+ FIRST AID</text>

            {{-- WATER SOURCE --}}
            @php $wx = gx2(9,$x0,$cw); $wy = gy2(7,$y0,$rh); @endphp
            <rect x="{{ $wx }}" y="{{ $wy }}" width="200" height="44" rx="9" fill="#e0f2fe" stroke="#7dd3fc" stroke-width="2"/>
            <text x="{{ $wx+100 }}" y="{{ $wy+22 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="13" font-weight="700" fill="#0369a1" font-family="sans-serif">💧 WATER SOURCE</text>

            {{-- WASTE BIN --}}
            @php $wbx = gx2(16,$x0,$cw); $wby = gy2(7,$y0,$rh); @endphp
            <rect x="{{ $wbx }}" y="{{ $wby }}" width="130" height="44" rx="9" fill="#fefce8" stroke="#fcd34d" stroke-width="2"/>
            <text x="{{ $wbx+65 }}" y="{{ $wby+22 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="13" font-weight="700" fill="#92400e" font-family="sans-serif">🗑 WASTE BIN</text>

            {{-- KALRO PAVILION — 16 blocks --}}
            @for($k=0; $k<16; $k++)
            @php $kx=gx2(10+$k,$x0,$cw); $ky=gy2(9,$y0,$rh); @endphp
            <rect x="{{ $kx }}" y="{{ $ky }}" width="{{ $bw }}" height="{{ $bh }}" rx="6" fill="#14532d" stroke="#052e16" stroke-width="1.5"/>
            <rect x="{{ $kx+2 }}" y="{{ $ky+2 }}" width="{{ $bw-4 }}" height="14" rx="5" fill="rgba(255,255,255,.09)"/>
            <text x="{{ $kx+$bw/2 }}" y="{{ $ky+$bh/2+1 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="11" font-weight="700" fill="#86efac" font-family="sans-serif"
                  letter-spacing="0.5">KALRO</text>
            @endfor

            {{-- LARGE MACHINERY --}}
            @php
            $lmx = gx2(3,$x0,$cw);
            $lmy = gy2(10,$y0,$rh);
            $lmw = gx2(8,$x0,$cw) - $lmx + $cw + 4;
            $lmh = gy2(21,$y0,$rh) - $lmy + $bh + 4;
            @endphp
            <rect x="{{ $lmx }}" y="{{ $lmy }}" width="{{ $lmw }}" height="{{ $lmh }}" rx="12"
                  fill="#fef9c3" stroke="#f59e0b" stroke-width="2" stroke-dasharray="10,5"/>
            <rect x="{{ $lmx }}" y="{{ $lmy }}" width="{{ $lmw }}" height="28" rx="12" fill="#fde68a" opacity=".6"/>
            <text x="{{ $lmx+$lmw/2 }}" y="{{ $lmy+$lmh/2-14 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="15" font-weight="700" fill="#92400e" font-family="sans-serif">LARGE MACHINERY</text>
            <text x="{{ $lmx+$lmw/2 }}" y="{{ $lmy+$lmh/2+10 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="12" fill="#b45309" font-family="sans-serif">Vehicles &amp; Tractors</text>

            {{-- NETWORKING AREA --}}
            @php
            $nx = gx2(15,$x0,$cw);
            $ny = gy2(11,$y0,$rh);
            $nw = gx2(20,$x0,$cw) - $nx + $cw + 6;
            $nh = gy2(15,$y0,$rh) - $ny + $rh;
            @endphp
            <rect x="{{ $nx }}" y="{{ $ny }}" width="{{ $nw }}" height="{{ $nh }}" rx="12"
                  fill="#fdf4ff" stroke="#c084fc" stroke-width="2" stroke-dasharray="10,5"/>
            <rect x="{{ $nx }}" y="{{ $ny }}" width="{{ $nw }}" height="28" rx="12" fill="#e9d5ff" opacity=".65"/>
            <text x="{{ $nx+$nw/2 }}" y="{{ $ny+$nh/2-14 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="15" font-weight="700" fill="#7e22ce" font-family="sans-serif">NETWORKING AREA</text>
            <text x="{{ $nx+$nw/2 }}" y="{{ $ny+$nh/2+12 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="11" fill="#a21caf" font-family="sans-serif">Wi-Fi · Lounge · Refreshments</text>

            {{-- ALL 50 BOOTHS --}}
            @foreach($pos as $booth=>$p)
            @php
              $cat=$bc[$booth]??'research'; $c=$cats[$cat];
              $px=$p[0]; $py=$p[1];
              $cx2=$px+$bw/2; $cy2=$py+$bh/2;
            @endphp
            <g class="fp-booth" data-cat="{{ $cat }}"
               onmouseenter="fpT(event,'{{ $booth }} — {{ $c['label'] }}')"
               onmouseleave="fpH()"
               onclick="fpS('{{ $cat }}')">
              <rect x="{{ $px+1 }}" y="{{ $py+3 }}" width="{{ $bw }}" height="{{ $bh }}" rx="7"
                    fill="rgba(0,0,0,.1)"/>
              <rect class="fp-br" x="{{ $px }}" y="{{ $py }}" width="{{ $bw }}" height="{{ $bh }}" rx="7"
                    fill="{{ $c['f'] }}" stroke="{{ $c['s'] }}" stroke-width="1.8"/>
              <rect x="{{ $px+3 }}" y="{{ $py+3 }}" width="{{ $bw-6 }}" height="13" rx="4"
                    fill="rgba(255,255,255,.38)" pointer-events="none"/>
              <text x="{{ $cx2 }}" y="{{ $cy2+2 }}" text-anchor="middle" dominant-baseline="central"
                    font-size="12" font-weight="700" fill="{{ $c['t'] }}" font-family="sans-serif"
                    pointer-events="none">{{ $booth }}</text>
            </g>
            @endforeach

            {{-- COMPASS --}}
            <g transform="translate({{ $svgW - 44 }},{{ $svgH - 44 }})">
              <circle cx="0" cy="0" r="34" fill="white" stroke="#d1d5db" stroke-width="1.5" opacity=".92"/>
              <polygon points="0,-24 6,4 0,-6 -6,4" fill="#166534"/>
              <polygon points="0,24 6,-4 0,6 -6,-4" fill="#94a3b8"/>
              <line x1="-24" y1="0" x2="24" y2="0" stroke="#e2e8f0" stroke-width="1"/>
              <line x1="0" y1="-24" x2="0" y2="24" stroke="#e2e8f0" stroke-width="1"/>
              <text x="0" y="-10" text-anchor="middle" dominant-baseline="central"
                    font-size="12" font-weight="700" fill="#166534" font-family="sans-serif">N</text>
              <text x="0" y="20"  text-anchor="middle" dominant-baseline="central"
                    font-size="10" fill="#9ca3af" font-family="sans-serif">S</text>
              <text x="-20" y="2" text-anchor="middle" dominant-baseline="central"
                    font-size="10" fill="#9ca3af" font-family="sans-serif">W</text>
              <text x="20" y="2"  text-anchor="middle" dominant-baseline="central"
                    font-size="10" fill="#9ca3af" font-family="sans-serif">E</text>
            </g>

            {{-- CAPTION --}}
            <text x="{{ $svgW/2 }}" y="{{ $svgH - 16 }}"
                  text-anchor="middle" dominant-baseline="central"
                  font-size="13" fill="#94a3b8" font-family="sans-serif" letter-spacing=".5">
                50 exhibition booths (G1–G50) · hover any booth for details · click legend to highlight category
            </text>

        </svg>
        </div>

        {{-- Infrastructure --}}
        <div class="fp-section-title">Venue Infrastructure</div>
        <div class="fp-infra">
            <span class="fp-ib" style="background:#e0f2fe;color:#0369a1;border-color:#7dd3fc;">💧 Water Source</span>
            <span class="fp-ib" style="background:#fef2f2;color:#dc2626;border-color:#fca5a5;">+ First Aid</span>
            <span class="fp-ib" style="background:#fdf4ff;color:#7e22ce;border-color:#c084fc;">📶 Networking Area · Wi-Fi</span>
            <span class="fp-ib" style="background:#fefce8;color:#92400e;border-color:#fde68a;">🗑 Waste Bins</span>
            <span class="fp-ib" style="background:#fef9c3;color:#713f12;border-color:#fde68a;">🚜 Large Machinery Area</span>
            <span class="fp-ib" style="background:#dcfce7;color:#14532d;border-color:#86efac;">🏛 KALRO Pavilion</span>
        </div>

        {{-- Legend --}}
        <div class="fp-section-title">Booth Categories — click to highlight on map</div>
        <div class="fp-legend">
            @foreach($cats as $key=>$cat)
            <div class="fp-leg" data-cat="{{ $key }}" onclick="fpS('{{ $key }}')">
                <div class="fp-sw" style="background:{{ $cat['f'] }};box-shadow:inset 0 0 0 2px {{ $cat['s'] }};"></div>
                <div>
                    <div class="fp-lname">{{ $cat['label'] }}</div>
                    <span class="fp-rng">{{ $cat['range'] }}</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom booking CTA --}}
        <div style="background:linear-gradient(135deg,#052e16,#14532d);border-radius:16px;padding:36px 40px;margin-bottom:48px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;">
            <div style="color:white;">
                <h4 style="font-weight:700;margin-bottom:6px;">Ready to book your booth?</h4>
                <p style="opacity:.8;margin:0;font-size:.93rem;">Reach out to us by email to reserve your preferred position. We'll confirm your booking and send next steps.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <a href="mailto:kalroexpo2026@gmail.com" class="fp-email-btn primary" style="font-size:.9rem;padding:11px 22px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    kalroexpo2026@gmail.com
                </a>
                <a href="mailto:kalroconference2026@gmail.com" class="fp-email-btn secondary" style="font-size:.9rem;padding:11px 22px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    kalroconference2026@gmail.com
                </a>
            </div>
        </div>

    </div>
</div>

<script>
(function(){
    var tip=document.getElementById('fpTip'),act=null;
    window.fpT=function(e,t){
        tip.textContent=t; tip.style.display='block';
        var hw=tip.offsetWidth||140;
        tip.style.left=Math.max(4,e.clientX-Math.round(hw/2))+'px';
        tip.style.top=(e.clientY-52)+'px';
    };
    window.fpH=function(){ tip.style.display='none'; };
    document.addEventListener('mousemove',function(e){
        if(tip.style.display!=='none'){
            var hw=tip.offsetWidth||140;
            tip.style.left=Math.max(4,e.clientX-Math.round(hw/2))+'px';
            tip.style.top=(e.clientY-52)+'px';
        }
    });
    window.fpS=function(cat){
        if(act===cat){ act=null; rst(); return; }
        act=cat;
        document.querySelectorAll('.fp-booth').forEach(function(b){
            b.style.opacity=b.dataset.cat===cat?'1':'0.1';
        });
        document.querySelectorAll('.fp-leg').forEach(function(l){
            l.classList.toggle('on',l.dataset.cat===cat);
        });
    };
    function rst(){
        document.querySelectorAll('.fp-booth').forEach(function(b){ b.style.opacity='1'; });
        document.querySelectorAll('.fp-leg').forEach(function(l){ l.classList.remove('on'); });
    }
})();
</script>

@endsection
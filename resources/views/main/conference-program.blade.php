@extends('layouts.header')

@section('title', 'Conference Program')

@section('content')
<style>
/* ── Hero ── */
.prog-hero {
    background: linear-gradient(135deg, #052e16 0%, #14532d 55%, #166534 100%);
    color: white;
    padding: 56px 0 44px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.prog-hero::before {
    content:'';
    position:absolute; inset:0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M20 20.5V18H0v5h5v5H0v5h20v-9.5zm-2 4.5H7v-4h11v4zm2-10H7V10h13v5zM20 0H0v5h5V0h5v5h5V0h5z'/%3E%3C/g%3E%3C/svg%3E");
}
.prog-hero h1 { font-size: clamp(1.8rem, 4vw, 2.9rem); font-weight: 800; margin-bottom: 10px; position:relative; }
.prog-hero p  { opacity:.8; font-size:1rem; margin-bottom:0; position:relative; }
.prog-hero-meta { display:flex; justify-content:center; gap:10px; flex-wrap:wrap; margin-top:18px; position:relative; }
.prog-meta-badge {
    background:rgba(255,255,255,.13);
    border:1px solid rgba(255,255,255,.22);
    border-radius:20px; padding:5px 16px;
    font-size:.78rem; font-weight:600;
}
.prog-meta-badge.amber { background:rgba(251,191,36,.2); border-color:rgba(251,191,36,.35); }

/* ── Day Tabs ── */
.prog-tabs-bar {
    background: white;
    border-bottom: 2px solid #e2e8f0;
    position: sticky;
    top: 0;
    z-index: 90;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
}
.prog-tabs {
    display: flex;
    gap: 0;
    overflow-x: auto;
    scrollbar-width: none;
}
.prog-tabs::-webkit-scrollbar { display:none; }
.prog-tab {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 14px 22px;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: all .18s;
    text-decoration: none;
    color: #64748b;
    flex-shrink: 0;
    border-radius: 0;
    background: none;
    border-left: none; border-right: none; border-top: none;
}
.prog-tab .day-label { font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; font-weight:600; }
.prog-tab .day-name  { font-size:.9rem; font-weight:700; color:#1e293b; margin-top:2px; }
.prog-tab .day-date  { font-size:.72rem; color:#94a3b8; margin-top:1px; }
.prog-tab:hover { background:#f8fafc; border-bottom-color:#86efac; }
.prog-tab.active { border-bottom-color:#16a34a; background:#f0fdf4; }
.prog-tab.active .day-label { color:#16a34a; }
.prog-tab.active .day-name  { color:#14532d; }

/* ── Page body ── */
.prog-body { padding: 32px 0 60px; }
.prog-day { display:none; }
.prog-day.active { display:block; }

/* ── Plenary block ── */
.plenary-block {
    background: white;
    border-radius: 14px;
    border-left: 5px solid #14532d;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
    margin-bottom: 22px;
    overflow: hidden;
}
.plenary-head {
    background: linear-gradient(90deg, #052e16, #14532d);
    color: white;
    padding: 18px 24px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}
.plenary-head h4 { margin:0; font-size:1rem; font-weight:700; }
.plenary-head .venue-badge {
    background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.25);
    border-radius:14px; padding:3px 12px; font-size:.74rem; font-weight:600;
    white-space:nowrap;
}
.plenary-meta {
    background:#f0fdf4; padding:12px 24px; border-bottom:1px solid #dcfce7;
    font-size:.82rem; color:#166534; display:flex; gap:20px; flex-wrap:wrap;
}
.plenary-meta span { display:flex; align-items:center; gap:6px; }
.prog-table { width:100%; border-collapse:collapse; }
.prog-table th {
    background:#f8fafc; color:#64748b; font-size:.73rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.07em;
    padding:10px 16px; border-bottom:2px solid #e2e8f0; text-align:left;
}
.prog-table td {
    padding: 11px 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: .86rem;
    vertical-align: top;
}
.prog-table tr:last-child td { border-bottom:none; }
.prog-table tr:hover td { background:#fafbfc; }
.prog-table .time-cell { white-space:nowrap; color:#64748b; font-size:.82rem; width:130px; font-weight:500; }
.prog-table .code-cell { color:#7c3aed; font-family:monospace; font-size:.76rem; white-space:nowrap; }
.prog-table .highlight td { background:#fef9f0; font-weight:600; }
.prog-table .break-row td { background:#f0fdf4; color:#166534; font-weight:600; font-size:.84rem; }

/* ── Parallel sessions ── */
.parallel-wrapper { margin-bottom: 22px; }
.parallel-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.parallel-num {
    width:36px; height:36px; border-radius:50%;
    background:#14532d; color:white;
    display:flex; align-items:center; justify-content:center;
    font-weight:700; font-size:.9rem; flex-shrink:0;
}
.parallel-heading h5 { margin:0; font-size:.98rem; font-weight:700; color:#1e293b; }
.parallel-heading .room-tag {
    background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd;
    border-radius:12px; padding:3px 11px; font-size:.74rem; font-weight:600;
}
.parallel-heading .time-tag {
    background:#f3f4f6; color:#374151;
    border-radius:12px; padding:3px 11px; font-size:.74rem; font-weight:600;
}
.parallel-card {
    background:white;
    border-radius:12px;
    border:1px solid #e2e8f0;
    box-shadow:0 1px 8px rgba(0,0,0,.05);
    overflow:hidden;
    margin-bottom:8px;
}
.parallel-subhead {
    background:#f8fafc; padding:12px 18px; border-bottom:1px solid #e2e8f0;
    font-size:.82rem; display:flex; align-items:center; gap:10px; flex-wrap:wrap;
}
.subtheme-tag {
    background:#dcfce7; color:#14532d; border-radius:10px;
    padding:3px 12px; font-size:.75rem; font-weight:700;
}
.chair-info { color:#64748b; font-size:.78rem; }
.chair-info strong { color:#374151; }

/* ── Collapsible sessions grid ── */
.sessions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 14px;
}
@media(max-width:640px){ .sessions-grid { grid-template-columns:1fr; } }

/* ── Side events ── */
.side-event-card {
    background: white;
    border-radius: 14px;
    border-left: 5px solid #7c3aed;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
    margin-bottom: 22px;
    overflow: hidden;
}
.side-event-head {
    background: linear-gradient(90deg, #4c1d95, #7c3aed);
    color: white;
    padding: 16px 24px;
}
.side-event-head h4 { margin:0; font-size:1rem; font-weight:700; }

/* ── Poster badge ── */
.poster-tag {
    background:#fef3c7; color:#92400e;
    border-radius:8px; padding:1px 7px;
    font-size:.7rem; font-weight:700;
    vertical-align:middle; margin-left:4px;
}

/* ── Closing ── */
.closing-card {
    background: linear-gradient(135deg, #14532d, #166534);
    border-radius:14px; color:white; padding:32px 36px;
    text-align:center; margin-bottom:22px;
}
.closing-card h4 { font-size:1.2rem; font-weight:700; margin-bottom:6px; }
.closing-card p  { opacity:.8; margin:0; }

/* ── Print ── */
@media print {
    .prog-tabs-bar, .prog-hero-meta { display:none; }
    .prog-day { display:block !important; }
}
</style>

{{-- ── HERO ── --}}
<div class="prog-hero">
    <div class="container">
        <div style="margin-bottom:10px;font-size:.8rem;opacity:.7;font-weight:600;letter-spacing:.15em;text-transform:uppercase;">2nd KALRO Scientific Conference and Innovation Expo</div>
        <h1>
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:10px;opacity:.9"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Conference Program
        </h1>
        <p><em>Theme: Innovations for Sustainable Agri-food Systems, Climate Change Resilience and Improved Livelihoods</em></p>
        <div class="prog-hero-meta">
            <span class="prog-meta-badge">📍 KALRO Headquarters, Nairobi</span>
            <span class="prog-meta-badge">📅 15–19 June 2026</span>
            <span class="prog-meta-badge">5 Days · 4 Parallel Tracks</span>
            <span class="prog-meta-badge amber">🕑 Exhibition setup: Sunday from 2:00 PM</span>
        </div>
    </div>
</div>

{{-- ── DOWNLOAD BAR ── --}}
<div style="background:#f0fdf4;border-bottom:1px solid #86efac;padding:14px 0;">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            {{-- QR Code --}}
            <img src="{{ asset('program/kalro_program_qr.png') }}"
                 alt="QR Code for Conference Program"
                 style="width:70px;height:70px;border-radius:8px;border:2px solid #86efac;background:white;padding:3px;">
            <div>
                <div style="font-weight:700;color:#14532d;font-size:.95rem;">Conference Documents</div>
                <div style="font-size:.8rem;color:#166534;">Scan QR for the full program · or download below</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ asset('program/KALRO_Conference_Program_2026.pdf') }}"
               download="KALRO_Conference_Program_2026.pdf"
               style="display:inline-flex;align-items:center;gap:7px;background:#14532d;color:white;font-weight:700;font-size:.82rem;padding:9px 18px;border-radius:22px;text-decoration:none;white-space:nowrap;transition:background .15s;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Conference Program
            </a>
            <a href="{{ asset('program/Book of Abstract 2026 conference last updt 13-6.pdf') }}"
               download="Book_of_Abstracts_2026.pdf"
               style="display:inline-flex;align-items:center;gap:7px;background:#14532d;color:white;font-weight:700;font-size:.82rem;padding:9px 18px;border-radius:22px;text-decoration:none;white-space:nowrap;transition:background .15s;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Book of Abstracts
            </a>
            <a href="{{ asset('program/Program_Side_event.pdf') }}"
               download="Program_Side_event.pdf"
               style="display:inline-flex;align-items:center;gap:7px;background:#5b21b6;color:white;font-weight:700;font-size:.82rem;padding:9px 18px;border-radius:22px;text-decoration:none;white-space:nowrap;transition:background .15s;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Side Events
            </a>
        </div>
    </div>
</div>

{{-- ── DAY TABS ── --}}
<div class="prog-tabs-bar">
    <div class="container">
        <div class="prog-tabs">
            <button class="prog-tab active" onclick="showDay('day1',this)">
                <span class="day-label">Day 1</span>
                <span class="day-name">Monday</span>
                <span class="day-date">15 June</span>
            </button>
            <button class="prog-tab" onclick="showDay('day2',this)">
                <span class="day-label">Day 2</span>
                <span class="day-name">Tuesday</span>
                <span class="day-date">16 June</span>
            </button>
            <button class="prog-tab" onclick="showDay('day3',this)">
                <span class="day-label">Day 3</span>
                <span class="day-name">Wednesday</span>
                <span class="day-date">17 June</span>
            </button>
            <button class="prog-tab" onclick="showDay('day4',this)">
                <span class="day-label">Day 4</span>
                <span class="day-name">Thursday</span>
                <span class="day-date">18 June</span>
            </button>
            <button class="prog-tab" onclick="showDay('day5',this)">
                <span class="day-label">Day 5</span>
                <span class="day-name">Friday</span>
                <span class="day-date">19 June</span>
            </button>
        </div>
    </div>
</div>

<div class="prog-body">
<div class="container">

{{-- ══════════════════════════════════════════════
     DAY 1 — Monday 15 June 2026
══════════════════════════════════════════════ --}}
<div class="prog-day active" id="day1">

    <div class="plenary-block">
        <div class="plenary-head">
            <div>
                <h4>Session One: Plenary Keynote Presentation &amp; Opening Ceremony</h4>
                <div style="opacity:.75;font-size:.82rem;margin-top:4px;">Chairperson: Dr. Alice Murage &nbsp;·&nbsp; Rapporteur: Ms. Tabby Karanja-Lumumba</div>
            </div>
            <span class="venue-badge">📍 Main Conference Hall</span>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Activity</th><th>Facilitator</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">7:30 AM – 8:15 AM</td><td>Registration</td><td>All</td></tr>
                <tr><td class="time-cell">8:15 AM – 9:15 AM</td><td>Introduction of participants and setting the scene / Entertainment</td><td></td></tr>
                <tr><td class="time-cell">9:15 AM – 9:45 AM</td><td>Keynote: <strong>Building a Research-Driven Climate-Smart, Agricultural Food Systems for Kenya</strong><br><em>Dr. Nancy Laibuni – Associate Member, Council of Economic Advisors, Executive Office of the President</em></td><td><strong>Deputy Director General – Livestock</strong></td></tr>
                <tr class="break-row"><td class="time-cell">9:45 AM – 10:15 AM</td><td colspan="2">☕ Tea Break</td></tr>
                <tr><td class="time-cell">10:15 AM – 12:00 Noon</td><td>Opening Ceremony<br>
                    <ul style="margin:6px 0 0 16px;font-size:.84rem;">
                        <li>Welcoming remarks by KALRO Director General</li>
                        <li>Representative from NARs</li>
                        <li>Dr. Appolinaire Djikeng – Director General ILRI representative of CGIAR</li>
                        <li>Student presentation – Harriet Blessing, Loresho Secondary</li>
                        <li>Keynote Address: <em>Bridging Science and Productivity for Agricultural Transformation</em>, Mr. Simon Angote, OGW</li>
                        <li>Dr. Thuo Mathenge – Chairperson KALRO BoM</li>
                        <li>Hon. Jonathan Mueke – PS, State Department for Livestock Development</li>
                        <li>Dr. Kipronoh Ronoh P., PhD – PS, State Department for Agriculture</li>
                        <li>Chief Guest – Sen. Mutahi Kagwe, EGH, Cabinet Secretary, MoALD</li>
                        <li>Commissioning of KALRO Sorghum Varieties and Aflasafe, Cabinet Secretary, MoALD</li>
                    </ul>
                </td><td><strong>Director General</strong></td></tr>
                <tr><td class="time-cell">12:00 – 1:00 PM</td><td>Photo Session &nbsp;·&nbsp; Tour of the Exhibition &nbsp;·&nbsp; Tree Planting &nbsp;·&nbsp; Signing of Visitors Book &nbsp;·&nbsp; Media Briefs</td><td></td></tr>
                <tr class="break-row"><td class="time-cell">1:00 – 2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody>
        </table>
    </div>

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 2:00–5:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div>
                    <span class="room-tag">Conference Hall</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy, Adoption &amp; Socio-Economic Dimensions</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Charles Bett</strong> &nbsp;·&nbsp; Rapporteurs: Titus Ngetich &amp; Judith Mutheu Mboya</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15 PM</td><td>Factors influencing the Adoption of Green Grams in Machakos County <br><span class="code-cell">KALROCONF_SUB17_001</span> &nbsp; Rosemary Akhungu Emongor</td></tr>
                    <tr><td class="time-cell">2:15–2:30 PM</td><td>Measuring Women's Agricultural Empowerment Using A-WEAI: Evidence from Smallholder Farmers Participating in Homegrown School Feeding Programs in Kenya <br><span class="code-cell">KALROCONF_SUB17_002</span> &nbsp; Berit Auma</td></tr>
                    <tr><td class="time-cell">2:30–2:45 PM</td><td>Livestock Production and Methane Emissions in Kenya: ARDL Evidence of Long- and Short-Run Dynamics <br><span class="code-cell">KALROCONF_SUB17_004</span> &nbsp; Manyeki John Kibara</td></tr>
                    <tr><td class="time-cell">2:45–3:00 PM</td><td>Analysis of Risk and Returns of Tea Cultivar Portfolios Across Different Agro-Ecological Zones in Kenya <br><span class="code-cell">KALROCONF_SUB17_006</span> &nbsp; Paul Ayiemba Odongo</td></tr>
                    <tr><td class="time-cell">3:00–3:15 PM</td><td>Performance Evaluation of Climate Smart Agricultural Programs in Kenya. A case of AgriFI Kenya Climate Smart Agricultural Productivity Project (2019–2024) <br><span class="code-cell">KALROCONF_SUB17_007</span> &nbsp; Peter K. Nduati</td></tr>
                    <tr><td class="time-cell">3:15–3:30 PM</td><td>Evaluation of TMR finishing of Improved Boran steers in a Kenyan feedlot: performance, partial budget analysis, implications for profitability <br><span class="code-cell">KALROCONF_SUB17_008</span> &nbsp; Veronica Chemutai Metto</td></tr>
                    <tr><td class="time-cell">3:30–3:45 PM</td><td>Machine Learning Insights into Crop Yield Determinants in Kenyan Agriculture <br><span class="code-cell">KALROCONF_SUB17_009</span> &nbsp; Joan Achieng Abwao</td></tr>
                    <tr><td class="time-cell">3:45–4:00 PM</td><td>Agro-Dealer Profiles and Operational Practices in Kirinyaga, Kajiado, and Nairobi Counties, Kenya <br><span class="code-cell">KALROCONF_SUB17_012</span> &nbsp; John Ndungu</td></tr>
                    <tr><td class="time-cell">4:00–4:15 PM</td><td>Contribution of Mango Production to the Livelihood Outcomes of Households in South Kerio Basin <br><span class="code-cell">KALROCONF_SUB17_013</span> &nbsp; Gitonga K.J.</td></tr>
                    <tr><td class="time-cell">4:15–4:30 PM</td><td>Economic potential of Alpine Goat Milk Production in Kenya: a review <br><span class="code-cell">KALROCONF_SUB17_014</span> &nbsp; Mwangi Wilson Maina</td></tr>
                    <tr><td class="time-cell">4:30–4:45 PM</td><td>Participatory Varietal Selection of Drought-Resilient Sorghum in Kenya's ASALs: Gendered Preferences in Makueni and Kitui Counties <br><span class="code-cell">KALROCONF_SUB17_015</span> &nbsp; Winnie Rapada Agola</td></tr>
                    <tr><td class="time-cell">4:45–5:00 PM</td><td>Profitability of Differentiated Fertilizer Options in Maize Production in Kenya: Evidence from Socioeconomic and Biophysical Data <br><span class="code-cell">KALROCONF_SUB17_026</span> &nbsp; Josephat Chengole Mulindo</td></tr>
                </tbody>
            </table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div>
                    <span class="room-tag">Main Board Room</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Crop Varieties, Increased Productivity &amp; Production Management</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Rachel Kisilu</strong> &nbsp;·&nbsp; Rapporteurs: Harun Odhiambo &amp; Sheila Siele</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15 PM</td><td>Seasonal Variation in the Biochemical Composition of Second-Generation Tea Cultivars Grown at the KALRO–Tea Research Institute Germplasm in Kenya <br><span class="code-cell">KALROCONF_SUB1_002</span> &nbsp; Simon Mwangi Kingori</td></tr>
                    <tr><td class="time-cell">2:15–2:30 PM</td><td>Evaluation of Locally Bred Improved Sugarcane Varieties for Enhanced Productivity in Western Kenya <br><span class="code-cell">KALROCONF_SUB1_016</span> &nbsp; Edwin Shikanda</td></tr>
                    <tr><td class="time-cell">2:30–2:45 PM</td><td>Genetic Variability, Heritability and Genetic Advance in Eight Safflower (<em>Carthamus Tinctorius</em> L.) Genotypes <br><span class="code-cell">KALROCONF_SUB1_038</span> &nbsp; Peter Njuguna</td></tr>
                    <tr><td class="time-cell">2:45–3:00 PM</td><td>Effects of variety and potassium fertilization on yield of Watermelon (<em>Citrullus lanatus</em>) under irrigated conditions <br><span class="code-cell">KALROCONF_SUB1_036</span> &nbsp; Jimmy Kiprop Yegon</td></tr>
                    <tr><td class="time-cell">3:00–3:15 PM</td><td>Integrating Disease Resistance and Agronomic Performance for Parental Selection in Bread Wheat (<em>Triticum aestivum</em> L.) Using a Coefficient of Infection–Based Multivariate Framework <br><span class="code-cell">KALROCONF_SUB1_006</span> &nbsp; Godwin Macharia</td></tr>
                    <tr><td class="time-cell">3:15–3:30 PM</td><td>Comparative Performance of Early Brown Finger Millet (<em>Eleusine Coracana</em>) Genotypes in Lanet, Nakuru County <br><span class="code-cell">KALROCONF_SUB1_021</span> &nbsp; Rhoda Alima Omariba</td></tr>
                    <tr><td class="time-cell">3:30–3:45 PM</td><td>Validation of yield-related and blast resistance genes for improvement of Kenyan Basmati rice <br><span class="code-cell">KALROCONF_SUB1_039</span> &nbsp; Emily Gichuhi</td></tr>
                    <tr><td class="time-cell">4:00–4:08 PM</td><td>Comparative Evaluation of Pruning Systems on Vegetative Growth and Fruit Yield of Tomato (<em>Solanum lycopersicum</em> L.) <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_023</span> &nbsp; Isaiah Kiprop Keter</td></tr>
                    <tr><td class="time-cell">4:08–4:16 PM</td><td>Genetic characterization of <em>Coffea canephora</em> germplasm conservation in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_031</span> &nbsp; James Gimase</td></tr>
                    <tr><td class="time-cell">4:16–4:24 PM</td><td>Evaluation of Sorghum Newly Released Varieties in Makueni County using Tricot Approach <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_019</span> &nbsp; Benard Masila Mbuvi</td></tr>
                    <tr><td class="time-cell">4:24–4:32 PM</td><td>Confronting the Breeding Challenges for Next-Generation Pyrethrum (<em>Tanacetum cinerariifolium</em>) Seedling Varieties in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_015</span> &nbsp; Wilfred Abincha Magangi</td></tr>
                    <tr><td class="time-cell">4:32–4:40 PM</td><td>Comparative Efficiency of Split-Plot vs. Randomized Complete Block Designs for Factorial Sorghum Yield Experiments in Siakago, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_037</span> &nbsp; Elias Gitonga Thuranira</td></tr>
                    <tr><td class="time-cell">4:40–4:48 PM</td><td>Evaluation of advanced wheat (<em>Triticum aestivum</em>, L.) lines for yield and rust resistance <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_041</span> &nbsp; Martin Lagat</td></tr>
                    <tr><td class="time-cell">4:48–4:56 PM</td><td>Effect of defloration levels on potato yield, tuber quality and economic returns: A case study in Ol Joro Orok, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_042</span> &nbsp; Godfrey Juma</td></tr>
                    <tr><td class="time-cell">4:56–5:04 PM</td><td>Evaluation of Seedball Technology in Propagation of Cashew <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_048</span> &nbsp; Francis Muniu</td></tr>
                </tbody>
            </table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div>
                    <span class="room-tag">Big Seminar Room</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Animal Health, Sanitary Systems &amp; Emerging Livestock Pests and Diseases</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Monicah Maichomo</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Esther Kimani</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15 PM</td><td>Rebreedx <br><span class="code-cell">KALROCONF_SUB11_002</span> &nbsp; Luke Kipyego</td></tr>
                    <tr><td class="time-cell">2:15–2:30 PM</td><td>Integrated Investigation of Haemoparasitic Infections with Emphasis on African Animal Trypanosomiasis of Boran crosses in Kenya <br><span class="code-cell">KALROCONF_SUB11_003</span> &nbsp; Chege Patriciah Waithira</td></tr>
                    <tr><td class="time-cell">2:30–2:45 PM</td><td>Evaluation of the immunogenicity and safety of an inactivated mucosal Capripoxvirus vaccine candidate against sheep and goat pox diseases <br><span class="code-cell">KALROCONF_SUB11_004</span> &nbsp; Kenneth Koome</td></tr>
                    <tr><td class="time-cell">2:45–3:00 PM</td><td>Mechanical Amplifiers of Hemopathogen Transmission: Diversity, Abundance, and Vectorial Competence of <em>Stomoxys</em> spp. in Livestock Systems of Western Kenya <br><span class="code-cell">KALROCONF_SUB11_005</span> &nbsp; Stephen Burudi Shirengo</td></tr>
                    <tr><td class="time-cell">3:00–3:15 PM</td><td>Integrated Serological and Entomological Assessment of Nairobi Sheep Disease Virus in Kenya <br><span class="code-cell">KALROCONF_SUB11_009</span> &nbsp; Paul Ngari Muriuki</td></tr>
                    <tr><td class="time-cell">3:15–3:30 PM</td><td>Hiding in Plain Sight: Uncovering Overlooked Bacteria in Intensive Pig Farming Systems in Kenya Using Matrix-Assisted Laser Desorption/Ionization Time-of-Flight Mass Spectroscopy (MALDI-TOF MS) <br><span class="code-cell">KALROCONF_SUB11_010</span> &nbsp; Nathan Langat</td></tr>
                    <tr><td class="time-cell">3:30–3:45 PM</td><td>Shotgun Metagenomics reveals Deep insight into Diversity and Age-based Dynamics of Potentially Beneficial and One Health Microbial Taxa in Gut of Pastured Goats <br><span class="code-cell">KALROCONF_SUB11_011</span> &nbsp; Eunice Ndegwa</td></tr>
                    <tr><td class="time-cell">3:45–4:00 PM</td><td>Integrating Medicinal Maggot Therapy into Climate-Resilient Health Systems in Africa: A Policy Review <br><span class="code-cell">KALROCONF_SUB11_012</span> &nbsp; Paul Ngari Muriuki</td></tr>
                    <tr><td class="time-cell">4:00–4:15 PM</td><td>Antimicrobial Activity of Polyphenolic Extracts from Kenya Specialty Teas Against Pathogenic Bacteria and Fungi <br><span class="code-cell">KALROCONF_SUB11_014</span> &nbsp; Emily Kipsura</td></tr>
                    <tr><td class="time-cell">4:15–4:30 PM</td><td>From Farm to Crisis: Tackling Antibiotic Overuse through Community-Led Behavioural Interventions among Smallholder Livestock Farmers in East Karateng' and Marera Sub-Locations, Kisumu West Sub-County, Kenya <br><span class="code-cell">KALROCONF_SUB11_015</span> &nbsp; Janet Akinyi Otieno</td></tr>
                    <tr><td class="time-cell">4:30–4:45 PM</td><td>Reimagining Chronic Wound Management and Multimorbidity: One Health Paradigm Shifts toward Sustainable, Antibiotic-Sparing Interventions including Maggot Debridement Therapy – A Review <br><span class="code-cell">KALROCONF_SUB11_016</span> &nbsp; Patrick Gachie Wanjiku</td></tr>
                    <tr><td class="time-cell">4:45–5:00 PM</td><td>Current Status and Progress of East Coast Fever Vaccination in Africa (2023–2026): Comparative Insights on the Muguga Cocktail and <em>Theileria parva</em> Marikebuni Vaccines. A Review <br><span class="code-cell">KALROCONF_SUB11_018</span> &nbsp; Pius Tarus</td></tr>
                    <tr><td class="time-cell">5:00–5:15 PM</td><td>Novel Tsetse Fly Repellent for Control of Savannah Tsetse Fly in East Africa <br><span class="code-cell">KALROCONF_SUB11_025</span> &nbsp; Paul O Mireji</td></tr>
                </tbody>
            </table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div>
                    <span class="room-tag">Room 207</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Technology Transfer Approaches, Knowledge Co-Creation and Scaling Pathways, ICT-Enabled Precision Systems</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Everlyne Kirwa</strong> &nbsp;·&nbsp; Rapporteurs: Nicholas Kibunyi &amp; Tuila Esese</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15 PM</td><td>Training Lead Farmers as Agents for Dissemination of TIMPs: Evidence from Kajiado County <br><span class="code-cell">KALROCONF_SUB16_002</span> &nbsp; Paul Katiku</td></tr>
                    <tr><td class="time-cell">2:15–2:30 PM</td><td>Digital Market Information Systems and Availability of Nutritious Food: A Systems-based Analysis of Kenya Agricultural Market Information System (KAMIS) <br><span class="code-cell">KALROCONF_SUB16_004</span> &nbsp; Hannington Odido Ochieng</td></tr>
                    <tr><td class="time-cell">2:30–2:45 PM</td><td>Catalysing Sustainable Livelihoods: A Multi-Stakeholder Model for Agricultural Technology Transfer and Commercialisation in Kenya <br><span class="code-cell">KALROCONF_SUB16_005</span> &nbsp; Peter Nduati</td></tr>
                    <tr><td class="time-cell">2:45–3:00 PM</td><td>Use of Precision Digital Technologies in Veterinary Health and Research: The KILIMMA Digital Platform <br><span class="code-cell">KALROCONF_SUB16_007</span> &nbsp; Rosemary Ngotho-Esilaba</td></tr>
                    <tr><td class="time-cell">3:00–3:15 PM</td><td>GRIN-Global Community Edition: Advancing ICT-Enabled Plant Genetic Resources Conservation at KALRO's Genetic Resources Research Institute <br><span class="code-cell">KALROCONF_SUB16_010</span> &nbsp; Joseph Ndungu Kimani</td></tr>
                    <tr><td class="time-cell">3:15–3:30 PM</td><td>Enhancing Youth Engagement in Agriculture: A Training and Innovation Model for Food Security awareness and action in Kenya <br><span class="code-cell">KALROCONF_SUB16_031</span> &nbsp; Kenneth Monjero Igadwa</td></tr>
                    <tr><td class="time-cell">3:30–3:45 PM</td><td>From Tech to Tacit: A Community Engagement Framework for Co-Creating and Scaling Digital Knowledge for Climate-Resilient Agriculture <br><span class="code-cell">KALROCONF_SUB16_021</span> &nbsp; Emma Nyaola</td></tr>
                    <tr><td class="time-cell">3:45–4:00 PM</td><td>Music, Drama, and Poetry as Innovative Platforms for Agricultural Knowledge Dissemination at KALRO <br><span class="code-cell">KALROCONF_SUB16_023</span> &nbsp; Peterson Mwangi</td></tr>
                    <tr><td class="time-cell">4:00–4:15 PM</td><td>Digitally Enabled Agripreneurship for Agricultural Service Delivery: Implementation Lessons from Kenya's Food Systems Resilience Programme <br><span class="code-cell">KALROCONF_SUB16_026</span> &nbsp; Irene Wambui Kimani</td></tr>
                    <tr><td class="time-cell">4:15–4:30 PM</td><td>Application of Triadic Comparisons of Technologies (TRICOT) in Finger Millet Technologies Dissemination Among Smallholder Farmers in Western Kenya <br><span class="code-cell">KALROCONF_SUB16_030</span> &nbsp; David Otieno Odhiambo</td></tr>
                    <tr><td class="time-cell">4:30–4:45 PM</td><td>Exploring a Market-Led Extension Model for Enhancing Adoption of Good Agricultural Practices: A Case Study of Lari Sub-County, Kenya <br><span class="code-cell">KALROCONF_SUB16_011</span> &nbsp; Christine Wangeci Ndiritu</td></tr>
                    <tr><td class="time-cell">4:45–4:53 PM</td><td>Artificial Intelligence-Enhanced Farmer Feedback Systems: Predictive Analytics and Personalized Approaches for Technology Adoption and Commercialization <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB16_009</span> &nbsp; Chepkania Miriam Nangila</td></tr>
                    <tr><td class="time-cell">4:53–5:01 PM</td><td>Assessment of Farmers' Desired Attributes in Adoption of Soil and Water Technologies and Innovations <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB16_046</span> &nbsp; Seth Chasimba Amboga</td></tr>
                </tbody>
            </table>
        </div>

    </div><!-- /sessions-grid day1 -->
</div><!-- /day1 -->

{{-- ══════════════════════════════════════════════
     DAY 2 — Tuesday 16 June 2026
══════════════════════════════════════════════ --}}
<div class="prog-day" id="day2">

    <div class="plenary-block">
        <div class="plenary-head">
            <div>
                <h4>Session One: Plenary Keynote Presentation</h4>
                <div style="opacity:.75;font-size:.82rem;margin-top:4px;">Chairperson: Dr. Benjamin Kivuva &nbsp;·&nbsp; Rapporteur: Henry Wanyama</div>
            </div>
            <span class="venue-badge">📍 Main Conference Hall</span>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Event</th><th>Facilitator</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">7:30 AM – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 AM – 9:30 AM</td><td><strong>Chief Guest Address: Funding Research to drive the Next Generation socioeconomic development.</strong><br>
                    <em>Prof. Shaukat Abdulrazak, PhD, EBS – Principal Secretary, State Department for Science, Research and Innovation</em><br><br>
                    <strong>Moderator:</strong> Dr. David Golicha<br><br>
                    <strong>Panelists:</strong><br>
                    <ul style="margin:4px 0 0 16px;font-size:.84rem;">
                        <li>Dr. Margaret Karembu (MBS) – Director ISAAA-AfriCenter, Africa region Chair and pioneering Chair, OFAB – Kenya chapter</li>
                        <li>Prof. Ratemo Michieka, PhD, EBS – Chancellor (and Chairman) Tharaka University, President, National Academy of Sciences</li>
                        <li>Dr. Sanda Cristina Kothe Milach, Chief Scientist, CGIAR</li>
                    </ul>
                </td><td>Moderator: Dr. David Golicha</td></tr>
                <tr><td class="time-cell">9:30 AM – 10:00 AM</td><td><strong>Keynote Presentation: <em>Transforming Crop-based value chains through practical application of technologies, innovations and management practices</em></strong><br>Prof. Richard Mulwa, Egerton University</td><td></td></tr>
                <tr><td class="time-cell">10:00 AM – 10:30 AM</td><td>Chief Guest visit to Business session &amp; <strong>Launch of KALRO Commercialization Strategy 2026–2031</strong></td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:30 AM – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
            </tbody>
        </table>
    </div>

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 11:00 AM – 1:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div>
                    <span class="room-tag">Conference Hall</span><br>
                    <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy, Adoption &amp; Socio-Economic Dimensions</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Martins Odendo</strong> &nbsp;·&nbsp; Rapporteurs: Tabby Karanja-Lumumba &amp; Judith Mutheu Mboya</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Market Pathways for Bio-fortified Bean Seeds: Evidence from Agro-Dealers Survey in Kenya <br><span class="code-cell">KALROCONF_SUB17_027</span> &nbsp; Eliud Kipkosgei Rotich</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Seasonal Demand Dynamics and Revenue Structure of Public Agricultural Research Products: Evidence from KALRO-Njoro, Kenya <br><span class="code-cell">KALROCONF_SUB17_028</span> &nbsp; Ruth Chepngeno</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Gender, Scale, and Seasonality in Smallholder Tree Crop Input Markets: Insights from Coastal Kenya <br><span class="code-cell">KALROCONF_SUB17_092</span> &nbsp; Christine Kasichana</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Towards Disability-Inclusive Agricultural Innovation Systems in Kenya: Integrating Farmers with Disabilities into Research, Digital Agriculture, and Value Chains <br><span class="code-cell">KALROCONF_SUB17_090</span> &nbsp; Peterson Mwangi</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Gender and Social Inclusion in Adoption of Climate-Smart Irish Potato Production in Nyeri County <br><span class="code-cell">KALROCONF_SUB17_030</span> &nbsp; Stella J. Matere</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Evaluating the Financial and Economic Feasibility of Maize Productivity Project in Kenya <br><span class="code-cell">KALROCONF_SUB17_031</span> &nbsp; Stella Makokha</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Unlocking the Potential and Optimizing Available Land Resources for Market-Oriented Production, Revenue Generation, and Enhancing Livestock Feed Production <br><span class="code-cell">KALROCONF_SUB17_034</span> &nbsp; Mercy Kaimenyi Bett</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div>
                    <span class="room-tag">Main Board Room</span><br>
                    <span class="subtheme-tag mt-1">Plant Nutrition, Soil Health &amp; Conservation Agriculture</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Golicha Duba</strong> &nbsp;·&nbsp; Rapporteurs: Priscila Kanza Mwangangi &amp; Robert Tabu</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Linking Specific Nutrient Elements and Lime to Irish Potatoes (<em>Solanum tuberosum</em>. L) Yield Parameters in Acidic Soils of Uasin Gishu County <br><span class="code-cell">KALROCONF_SUB4_001</span> &nbsp; Mary Koech</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Effect of pH and Organic Amendments on Phosphorus Sorption in Acidic Soils of Kiambu County, Kenya <br><span class="code-cell">KALROCONF_SUB4_004</span> &nbsp; Priscila Mwangangi</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Maize Yield Variability in Kabete Long-Term Soil Fertility Experiment: A Comparison of 2015, 2020 And 2025 Long Rains Seasons <br><span class="code-cell">KALROCONF_SUB4_005</span> &nbsp; Joyce Addah Omwakwe</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Identifying Soil Fertility Constraints to Maize Production in Kenya Using Nutrient Omission Trials <br><span class="code-cell">KALROCONF_SUB4_007</span> &nbsp; Joyce Addah Omwakwe</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Assessment of Blended and Conventional Formulations for Enhanced Maize Production in Western Kenya <br><span class="code-cell">KALROCONF_SUB4_008</span> &nbsp; Kelele Faida John</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Application of blended fertilizers for improved maize production in semi-arid eastern Kenya <br><span class="code-cell">KALROCONF_SUB4_011</span> &nbsp; Emerita Njiru</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Maize growth and yield response to separate fertilizer application in Uasin Gishu and Trans Nzoia counties of Kenya <br><span class="code-cell">KALROCONF_SUB4_013</span> &nbsp; Mary Koech</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Influence of CBX Bio-stimulant and Soil Conditioner on Coffee Growth and Yield <br><span class="code-cell">KALROCONF_SUB4_014</span> &nbsp; Danstan Odeny</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div>
                    <span class="room-tag">Big Seminar Room</span><br>
                    <span class="subtheme-tag mt-1">Food Safety, Value Addition &amp; Cottage Industries</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Samson Kamunya</strong> &nbsp;·&nbsp; Rapporteurs: Titus Ngetich &amp; Judith Mutheu Mboya</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Pesticide Residues in <em>Catha edulis</em> (Muguka): A Multidimensional Threat to Health, Livelihoods, and Environmental Sustainability in Kenya <br><span class="code-cell">KALROCONF_SUB14_015</span> &nbsp; Richard Mwaniki Njue</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Occurrence and Distribution of Soil-Borne Mycotoxigenic Fungi in Maize Farms of Makueni County, Kenya <br><span class="code-cell">KALROCONF_SUB14_016</span> &nbsp; Nicholas Odhiambo Owiro</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Food Safety Assessment of Fungal and Aflatoxin Contamination in Black CTC Teas from Selected KTDA Tea Factories in the East and West of Rift Valley, Kenya <br><span class="code-cell">KALROCONF_SUB14_019</span> &nbsp; Mercy Cherotich</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Integrating soil management practices and screening maize varieties to reduce aflatoxin contamination in Makueni County, Kenya <br><span class="code-cell">KALROCONF_SUB14_021</span> &nbsp; Fatuma Sharamo Fora</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Optimisation of harvesting and post-harvest handling of cashew apple in coastal Kenya <br><span class="code-cell">KALROCONF_SUB14_022</span> &nbsp; Francis Muniu</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Consumption of Sweetpotato Leaves Improve Iron Status Among Women of Reproductive Age in Bomet County, Kenya <br><span class="code-cell">KALROCONF_SUB14_023</span> &nbsp; Rosemary Jepkosgei Cheboswony</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Total Monomeric Anthocyanin (TMA) in Purple Tea Infusions: Influence of Water Source Composition <br><span class="code-cell">KALROCONF_SUB14_005</span> &nbsp; Simon Oduor Ochanda</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Determination of Tomato Post-Harvest Losses and Packaging Effects on Fruit Quality in Rombo, Kajiado County, Kenya <br><span class="code-cell">KALROCONF_SUB14_007</span> &nbsp; Robert Tabu</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div>
                    <span class="room-tag">Room 207</span><br>
                    <span class="subtheme-tag mt-1">Plant Health, Emerging Crop Pests &amp; Diseases, Biosecurity &amp; Phytosanitary Systems</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Harun Muriithi, IITA</strong> &nbsp;·&nbsp; Rapporteurs: Hillary Rotich &amp; Miriam Mbiyu</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Bridging the Last Mile: A Farmer-Trainer Mediated Remote Diagnosis and Documentation Model for Smallholder Crop Health — Pilot Cases from Kenya <br><span class="code-cell">KALROCONF_SUB3_010</span> &nbsp; Rong Coco Feng</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Knowledge Gaps in Mango Pathology in Kenya: A Review with Focus on The South-Eastern Production Zone <br><span class="code-cell">KALROCONF_SUB3_011</span> &nbsp; Barbra Nyakowa Khainga</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Surveillance of Wheat Diseases and Characterization of Stem Rust Isolates in Kenya <br><span class="code-cell">KALROCONF_SUB3_012</span> &nbsp; Zennah Kosgey</td></tr>
                <tr><td class="time-cell">11:45–11:53 AM</td><td>Documentation Of Cashew Pests and Diseases and their Economic Importance in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_017</span> &nbsp; Naomi Mburu</td></tr>
                <tr><td class="time-cell">11:53 AM–12:01 PM</td><td>Emerging Insect Pests Threatening Indigenous Vegetables in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_018</span> &nbsp; Denis Mwiti Prichard</td></tr>
                <tr><td class="time-cell">12:01–12:09 PM</td><td>Incidences of <em>Phytophthora cinnamomi</em>, the Causal Agent of Avocado Root Rot, in Soils Analyzed at KALRO Kabete in 2023–2025 <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_013</span> &nbsp; Mercyline Orayo</td></tr>
                <tr><td class="time-cell">12:09–12:17 PM</td><td>Evaluation of YUKON 720 SC (Sulphur 640 g/L + Copper 80 g/L) for the Control of Late Blight (<em>Phytophthora infestans</em>) and Early Blight of Potato (<em>Solanum tuberosum</em>) <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_014</span> &nbsp; Charity Nzilani</td></tr>
                <tr><td class="time-cell">12:17–12:25 PM</td><td>Use of Botanical Plant Extracts in the Control of Potato Tuber Moth. (<em>Phthorimaea Operculella</em>) <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_016</span> &nbsp; Robert Kipprotich Lagat</td></tr>
                <tr><td class="time-cell">12:25–12:33 PM</td><td>Characterisation of audible sound behaviour of rodents with and without food under laboratory conditions <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_019</span> &nbsp; Paddy Likhayo</td></tr>
                <tr><td class="time-cell">12:33–12:41 PM</td><td>Residual Efficacy of Actellic Gold Dust Against <em>Prostephanus truncatus</em> (Horn), <em>Sitophilus zeamais</em> (Motschulsky), and <em>Tribolium castaneum</em> (Herbst) in Stored Grain Under Laboratory Conditions <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_020</span> &nbsp; Paddy Likhayo</td></tr>
                <tr><td class="time-cell">12:41–12:49 PM</td><td>Virulence of <em>Fusarium oxysporum</em> f. sp. <em>cubense</em> Strains Isolated from Infected Bananas in Tharaka Nithi County, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB3_035</span> &nbsp; Samuel Musime Malaka</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

    </div><!-- /morning sessions grid -->

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 2:00–5:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div>
                    <span class="room-tag">Conference Hall</span><br>
                    <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy, Adoption &amp; Socio-Economic Dimensions</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Stella Makokha</strong> &nbsp;·&nbsp; Rapporteurs: Judith Mboya &amp; Peterson Mwangi</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Rethinking Agricultural Research: From Traditional Experimental Designs to Context-Sensitive Approaches <br><span class="code-cell">KALROCONF_SUB17_035</span> &nbsp; Hannington Odido Ochieng</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Why are Farmers and Agricultural SMEs Credit Constrained in Africa? A Systematic Review of Literature <br><span class="code-cell">KALROCONF_SUB17_037</span> &nbsp; Joel Agutu Omollo</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Impact of Integrated Poultry and Nutrition Education Interventions on Dietary Diversity among Women of Reproductive Age in Bomet and Kakamega Counties, Kenya <br><span class="code-cell">KALROCONF_SUB17_038</span> &nbsp; Mercy Chelangat Soi</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Does Attitude towards Domestic Gender Based Violence on Smallholder farms affect Crop Productivity? Evidence from Central Kenya <br><span class="code-cell">KALROCONF_SUB17_039</span> &nbsp; Martins Odendo</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Effect of Climate Change on Gender Segregated Households in Kenya <br><span class="code-cell">KALROCONF_SUB17_040</span> &nbsp; Bernard Rono</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Evaluation of Cassava Farming as a Climate Smart Technology in Murang'a County, Kenya <br><span class="code-cell">KALROCONF_SUB17_041</span> &nbsp; Antony Ngaruiya</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>From Subsistence to Sustainable Livelihoods: Constraints, Opportunities, and Innovation Pathways for Climate Resilient and Commercialized Smallholder Rice Systems in Kilifi County, Kenya <br><span class="code-cell">KALROCONF_SUB17_042</span> &nbsp; Kadenge Lewa</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Gender Mainstreaming in Poultry Production and Marketing in Nyandarua County in Kenya <br><span class="code-cell">KALROCONF_SUB17_044</span> &nbsp; Jessica Ndubi</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Gender Dynamics in The Adoption and Replacement of Improved Wheat Varieties in Kenya <br><span class="code-cell">KALROCONF_SUB17_045</span> &nbsp; Anne Gichangi</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Economic evaluation of Friesian and their crosses fed on locally formulated Total Mixed Ration at Beef Research Institute, Lanet <br><span class="code-cell">KALROCONF_SUB17_016</span> &nbsp; Andrew Kiplagat Kosgei</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Economic Evaluation of Locally Formulated Total Mixed Ration (TMR) on Red Maasai Sheep Fed <br><span class="code-cell">KALROCONF_SUB17_017</span> &nbsp; Scolastica Nanjala Nambafu</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Local Value Chain Analysis and Mapping for Improved Productivity: A Study of Baringo County <br><span class="code-cell">KALROCONF_SUB17_018</span> &nbsp; Paul Kiprono</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div>
                    <span class="room-tag">Main Board Room</span><br>
                    <span class="subtheme-tag mt-1">Crop Varieties, Increased Productivity &amp; Production Management (2:00–3:45) → Agrodiversity &amp; Genetic Resources (4:00–5:15)</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Susan Otieno</strong> / <strong>Dr. Harrison Lutta</strong> &nbsp;·&nbsp; Rapporteurs: Sheila Siele &amp; Robert Tabu</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Contribution of Underutilized Crops to Diversity and Resilience in Modern Cropping Systems in Kenya <br><span class="code-cell">KALROCONF_SUB1_044</span> &nbsp; Judy Chepkoech Mutai</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Delayed Research Undermining the Production and Productivity of Pyrethrum Revival in Kenya <br><span class="code-cell">KALROCONF_SUB1_046</span> &nbsp; Irene</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Evaluation of Cashew Clones for Rootstock Suitability <br><span class="code-cell">KALROCONF_SUB1_047</span> &nbsp; Francis Muniu</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Evaluation of Promising Rice Lines for Ratooning Ability to Improve Productivity in Kenya <br><span class="code-cell">KALROCONF_SUB1_049</span> &nbsp; John Kalume</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Tea quality assessment in multiple environments based on AMMi and GGE biplot analyses <br><span class="code-cell">KALROCONF_SUB1_051</span> &nbsp; Robert Kiplangat Korir</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Effect of Harvesting Frequency On Cowpea Leaf Quality and Nutrition: The Case of Trans Nzoia County, Kenya <br><span class="code-cell">KALROCONF_SUB1_056</span> &nbsp; Anastacia Masinde</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Evaluation of Elite Finger Millet Genotypes Across Locations in Western Kenya for Improved Productivity <br><span class="code-cell">KALROCONF_SUB1_061</span> &nbsp; Chrispus O.A. Oduori</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Retrospective analysis for parental line selection for rice breeding in Kenya <br><span class="code-cell">KALROCONF_SUB1_064</span> &nbsp; Roselyne Juma</td></tr>
                <tr style="background:#fdf4ff;"><td class="time-cell" style="color:#7c3aed;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#7c3aed;font-weight:600;font-size:.8rem;">Agrodiversity &amp; Genetic Resources (Chair: Dr. Harrison Lutta)</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Role of Digital Sequence Information in Climate-Resilient Utilization of Crop Genetic Resources <br><span class="code-cell">KALROCONF_SUB8_003</span> &nbsp; Dancun Muchira</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Characterization of Second-Generation Purple Tea Cultivars (<em>Camellia sinensis</em>) in Kenya <br><span class="code-cell">KALROCONF_SUB8_006</span> &nbsp; Lilian Kerio</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Molecular Characterization of <em>Neonotonia wightii</em> in Arid and Semi-Arid Lands <br><span class="code-cell">KALROCONF_SUB8_007</span> &nbsp; David Musyimi</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Enhancing Farmers' Access to Sorghum Diversity in Western Kenya Using National Germplasm Collection <br><span class="code-cell">KALROCONF_SUB8_008</span> &nbsp; Peterson Wambugu</td></tr>
                <tr><td class="time-cell">5:00–5:15 PM</td><td>Genetic Architecture and Inheritance of Major Agronomic and Yield-Related Traits in Snap Beans (<em>Phaseolus vulgaris</em> L.) <br><span class="code-cell">KALROCONF_SUB8_012</span> &nbsp; Lucas Suva</td></tr>
                <tr><td class="time-cell">5:15–5:30 PM</td><td>Assessment of the post-harvest attributes of leafy amaranth landraces under ambient storage conditions <br><span class="code-cell">KALROCONF_SUB1_018</span> &nbsp; Christine Wangeci Ndiritu</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div>
                    <span class="room-tag">Big Seminar Room</span><br>
                    <span class="subtheme-tag mt-1">Biotechnological Solutions to Crop, Livestock &amp; Natural Resource Management Challenges</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Henry Kariithi</strong> &nbsp;·&nbsp; Rapporteurs: Esther Kimani &amp; Harun Odhiambo</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Improving Propagation Efficiency for Sustainable Pineapple Farming in Kenya <br><span class="code-cell">KALROCONF_SUB13_001</span> &nbsp; Lilian Mwende Mwaniki</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>In Vitro Shoot Multiplication of Three Plantain Banana Varieties in Kenya <br><span class="code-cell">KALROCONF_SUB13_003</span> &nbsp; Davis Wekesa Makhanu</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Feasibility of GMO Maize Adoption Among Smallholder Farmers in Kenya: Policy, Institutional, and Farm-Level Insights <br><span class="code-cell">KALROCONF_SUB13_005</span> &nbsp; Miriam Saur</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Towards Sustainable Postharvest Systems: The Role of Natural Preservatives <br><span class="code-cell">KALROCONF_SUB13_007</span> &nbsp; Fatuma Adam Mohammed</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Biotechnological Utilisation of Silk Proteins in Cosmetic Soap Fabrication for Sustainable Livelihood and Industrial Innovation <br><span class="code-cell">KALROCONF_SUB13_008</span> &nbsp; Nicholus Mutuma</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>The Effects of Different Concentrations of BAP, BAP + NAA, and BAP + TDZ Hormones on the In Vitro Multiplication of Plantain (<em>Musa</em> sp.) <br><span class="code-cell">KALROCONF_SUB13_011</span> &nbsp; Rose Nduku Mayoli</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Evaluation of Three Biotech Potato for Late Blight Resistance <br><span class="code-cell">KALROCONF_SUB13_013</span> &nbsp; Miriam Mbiyu</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Evaluation of promoters for storage root specific expression in cassava <br><span class="code-cell">KALROCONF_SUB13_022</span> &nbsp; Irene Wangari Njagi</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Fr Agricultural Biotechnology to Human Health: Maggot Debridement Therapy for Chronic Wound Healing in Kenya <br><span class="code-cell">KALROCONF_SUB13_019</span> &nbsp; Kelvin Malimo</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Isolation and Characterization of Bacteriophages Targeting Methicillin-Resistant <em>Staphylococcus aureus</em> (MRSA): A Pathway Toward Phage-Based Therapeutics <br><span class="code-cell">KALROCONF_SUB13_024</span> &nbsp; Lyluck Christabel Otuoma</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Molecular Characterization of MATE Membrane Transporters Involved in Anthocyanin and Proanthocyanidin Accumulation in Peach Fruit for Climate-Resilient Fruit Quality Improvement <br><span class="code-cell">KALROCONF_SUB13_028</span> &nbsp; Sylvia Cherono</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Banana Pseudo-stems as a Source of Natural Fibres with Potential Food, Textile, Cosmetic and Biomedical Applications. A Review <br><span class="code-cell">KALROCONF_SUB13_033</span> &nbsp; Kelvin Moseti</td></tr>
                <tr><td class="time-cell">5:00–5:08 PM</td><td>Maggot Debridement Therapy in Africa: Clinical Potential, Implementation Challenges, and Global Context – A Review <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB13_020</span> &nbsp; Regina Karanja</td></tr>
                <tr><td class="time-cell">5:08–5:16 PM</td><td>Role of Microclimate Regulation and Planting System Design on Survival Rate During Primary Hardening of Tissue-Cultured Banana (<em>Musa</em> spp.) <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB13_012</span> &nbsp; Dancun Muchira</td></tr>
                <tr><td class="time-cell">5:16–5:24 PM</td><td>Comparative Analysis of Early Growth, Maturity, Yield and Disease Incidence between Tissue Culture-Derived and Conventionally Propagated Shangi Potatoes in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB13_031</span> &nbsp; Diana Imbala</td></tr>
                <tr><td class="time-cell">5:24–5:32 PM</td><td>Effects of Plant Growth Regulators on Callus Formation and Plant Regeneration in Nodal Explants of Three Blackberry Species (<em>Rubus</em> spp.) <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB13_035</span> &nbsp; Gichaba Sarah Nyamoita</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div>
                    <span class="room-tag">Room 207</span><br>
                    <span class="subtheme-tag mt-1">Apiculture, Beneficial Insects &amp; Ecosystem Services (2:00–4:08) → Climate Change &amp; Land Degradation (4:08–5:46)</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Charles Bett</strong> / <strong>Dr. David Kamau</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Nicholas Kibunyi / Gladys Chelangat &amp; Titus Ngetich</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Emerging Honey Bee Health Challenges in a Changing Climate <br><span class="code-cell">KALROCONF_SUB12_004</span> &nbsp; Daniel Toroitich</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Outlook on Bee Occupancy of Beekeepers Apiaries in Baringo County <br><span class="code-cell">KALROCONF_SUB12_005</span> &nbsp; Caroline Waiyego Kimani</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>The Effects of Hive Materials on Phytochemical and Biological Properties of Honeybee Propolis <br><span class="code-cell">KALROCONF_SUB12_006</span> &nbsp; Timothy Kegode Mugodo</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Performance of Chemically Treated Hive Entrance Devices (Oxalic Acid, Amitraz) for Integrated Control of <em>Varroa destructor</em> in <em>Apis mellifera</em> Colonies <br><span class="code-cell">KALROCONF_SUB12_009</span> &nbsp; Rotich Godfrey</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Outlook on Bee Occupancy of Beekeepers Apiaries in Baringo County <br><span class="code-cell">KALROCONF_SUB12_010</span> &nbsp; Caroline Waiyego Kimani</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Understanding Bee Absconding: Environmental, Management, and Technological Drivers <br><span class="code-cell">KALROCONF_SUB12_012</span> &nbsp; Daniel Toroitich</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td><em>Apis mellifera</em> Honey Varieties in Kenya: Legislation, Production, Processing, and Labeling <br><span class="code-cell">KALROCONF_SUB12_015</span> &nbsp; Victoria Atieno Kimindu</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Evaluating the Profit Potential of Honeybees (<em>Apis mellifera</em>): Income Over Feed Cost (IOFC) Analysis of Chickpea (<em>Cicer arietinum</em> L.), Propolis Pod Flour (<em>Prosopis juliflora</em>), and Soybean (<em>Glycine max</em>)-Based Diets <br><span class="code-cell">KALROCONF_SUB12_016</span> &nbsp; Haron Juma Masai</td></tr>
                <tr><td class="time-cell">4:00–4:08 PM</td><td>Characterisation of <em>Apis mellifera scutellata</em>: Morphological, Genetic, Behavioural, and Ecological Perspectives <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB12_003</span> &nbsp; Daniel Toroitich</td></tr>
                <tr style="background:#f0fdf4;"><td class="time-cell" style="color:#14532d;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#14532d;font-weight:600;font-size:.8rem;">Climate Change, Land Degradation &amp; Reclamation (Chair: Dr. David Kamau)</td></tr>
                <tr><td class="time-cell">4:08–4:23 PM</td><td>Pastoral and Agropastoral Knowledge of Forage Dynamics and Holistic Planned Grazing in the Mgeno Ranch Landscape, Kenya <br><span class="code-cell">KALROCONF_SUB7_015</span> &nbsp; Benson Mulei</td></tr>
                <tr><td class="time-cell">4:23–4:38 PM</td><td>The Underground Advantage: Root Biomass and Carbon Under Perennial Grasses in Semi-Arid Kenya <br><span class="code-cell">KALROCONF_SUB7_016</span> &nbsp; Bosco K. Kisambo</td></tr>
                <tr><td class="time-cell">4:38–4:53 PM</td><td>Evaluation of Cassava Farming as Climate-Smart Technology in Murang'a County, Kenya <br><span class="code-cell">KALROCONF_SUB7_018</span> &nbsp; Antony Kamau Ngaruiya</td></tr>
                <tr><td class="time-cell">4:53–5:08 PM</td><td>Adoption Rate and Impacts of Climate Smart Agriculture Technologies on Productivity and Adaptation in Kitui and Tharaka Nithi Counties <br><span class="code-cell">KALROCONF_SUB7_019</span> &nbsp; Joyce Adhiambo Nyangao</td></tr>
                <tr><td class="time-cell">5:08–5:23 PM</td><td>Best Management Practices for Improved Land and Water Sustainability Under Changing Climate in Semiarid Environment <br><span class="code-cell">KALROCONF_SUB7_020</span> &nbsp; Reuben Ruttoh</td></tr>
                <tr><td class="time-cell">5:23–5:38 PM</td><td>Rangeland Management Practices and Strategies to Enhance Livestock Production in Kenya in the Face of Climate Change: A Review <br><span class="code-cell">KALROCONF_SUB7_024</span> &nbsp; Isaiah Barile</td></tr>
                <tr><td class="time-cell">5:38–5:46 PM</td><td>Adoption and Impact Assessment of In Situ Soil and Water Conservation Technologies in Crop Production in Kajiado County <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB7_021</span> &nbsp; Gladys Chelangat</td></tr>
                <tr><td class="time-cell">5:46–6:01 PM</td><td>Variation in Soil Properties across Land Uses and Slope Gradients: Implications for Sustainable Land and Water Management in the Kibwezi Watershed <br><span class="code-cell">KALROCONF_SUB7_014</span> &nbsp; Reuben Ruttoh</td></tr>
            </tbody></table>
        </div>

    </div><!-- /afternoon sessions grid day2 -->

    <div style="background:#1e293b;color:white;border-radius:12px;padding:18px 24px;margin-top:16px;text-align:center;">
        <strong>🥂 Cocktails — End of Day 2</strong>
    </div>

</div><!-- /day2 -->

{{-- ══════════════════════════════════════════════
     DAY 3 — Wednesday 17 June 2026
══════════════════════════════════════════════ --}}
<div class="prog-day" id="day3">

    <div class="plenary-block">
        <div class="plenary-head">
            <div>
                <h4>Session One: Plenary Keynote Presentation</h4>
                <div style="opacity:.75;font-size:.82rem;margin-top:4px;">Chairperson: Dr. David Kamau &nbsp;·&nbsp; Rapporteur: Gladys Cheruto</div>
            </div>
            <span class="venue-badge">📍 Main Conference Hall</span>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Activity</th><th></th></tr></thead>
            <tbody>
                <tr><td class="time-cell">7:30 AM – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 AM – 9:30 AM</td><td><strong>Chief Guest address: <em>The role of Parliament in driving Agricultural Research Ecosystem and Transformations.</em></strong><br>
                    Hon. (Dr.) John Mutunga – Chairperson, Departmental Committee on Agriculture and Livestock, National Assembly of Kenya<br><br>
                    <strong>Panelists:</strong><br>
                    <ul style="margin:4px 0 0 16px;font-size:.84rem;">
                        <li>Dr. David Ngigi – Director General, NACOSTI</li>
                        <li>Ms. Farayi Constance Zimudzi – FAO, Kenya Rep</li>
                    </ul>
                </td><td>Moderator: Dr. Margaret Makelo</td></tr>
                <tr><td class="time-cell">9:30 AM – 10:00 AM</td><td><strong>Keynote address: <em>Sustainable ecological innovations for crop-livestock production systems to enhance resilience and low-carbon agriculture.</em></strong><br>Dr. Boaz Waswa – CIAT</td><td></td></tr>
                <tr><td class="time-cell">10:00 AM – 10:30 AM</td><td>Chief Guest visit to Business session &amp; <strong>Official Launch of KALRO Tsetse Repellent &amp; Attractant Technology</strong> — including <a href="#side-events" style="color:var(--green-main);font-weight:600;">Tsetse Repellent Official Launch ↓</a></td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:30 AM – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
                <tr><td class="time-cell">11:00 AM</td><td><strong>Session Breakouts</strong></td><td></td></tr>
            </tbody>
        </table>
    </div>

    {{-- Side Events --}}
    <div class="side-event-card" id="side-events">
        <div class="side-event-head" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
            <h4 style="margin:0;">⚡ Side Events — Wednesday 17 June 2026</h4>
            <a href="{{ asset('program/Program_Side_event.pdf') }}"
               download="Program_Side_event.pdf"
               style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.4);color:white;font-size:.78rem;font-weight:700;padding:6px 14px;border-radius:20px;text-decoration:none;white-space:nowrap;transition:background .15s;"
               onmouseover="this.style.background='rgba(255,255,255,0.28)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download Side Events PDF
            </a>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Session Title</th><th>Host</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">09:30–14:30</td><td>Better Analytics for Reduced Impact of Extreme Weather Events</td><td><strong>KALRO/FAO</strong></td></tr>
                <tr style="background:#fffbf0;">
                    <td class="time-cell">10:00–13:00</td>
                    <td>
                        <span class="badge bg-warning text-dark me-1" style="font-size:.7rem;">Launch</span>
                        Tsetse Repellent Business Session &amp; Official Launch
                        <br><small class="text-muted">Chief Guest launch of KALRO Tsetse Repellent Technology for humans &amp; animals</small>
                    </td>
                    <td><strong>KALRO</strong></td>
                </tr>
                <tr><td class="time-cell">11:00–13:00</td><td>AI in Agriculture: Opportunities, Implications and Risks</td><td><strong>SAFIC</strong></td></tr>
                <tr><td class="time-cell">11:00–13:00</td><td>Aflasafe Distributorship Business Session</td><td><strong>KALRO</strong></td></tr>
                <tr><td class="time-cell">13:00–16:00</td><td>From Research to Impact: How KALRO &amp; CIMMYT Are Advancing Agricultural Innovation</td><td><strong>CIMMYT</strong></td></tr>
                <tr><td class="time-cell">14:00–17:00</td><td>Emerging Trends in Food Safety: Challenges, Innovations, Regulation &amp; Policy</td><td><strong>KALRO / Egerton University / IITA</strong></td></tr>
            </tbody>
        </table>
    </div>

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 11:00 AM – 1:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div><span class="room-tag">Conference Hall</span><br>
                <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy, Adoption &amp; Socio-Economic Dimensions</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Juma Magogo</strong> &nbsp;·&nbsp; Rapporteurs: Hillary Rotich &amp; Peterson Mwangi</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Perceptions of Climate Change Among Smallholder Farmers: Insights from Home Garden Agroforestry in Gedeo Zone, Ethiopia <br><span class="code-cell">KALROCONF_SUB17_062</span> &nbsp; Aberham Kebedom Darge</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Public Policy Preferences for Enhancing Maize Productivity Among Smallholder Farmers: Evidence from Western Kenya <br><span class="code-cell">KALROCONF_SUB17_064</span> &nbsp; Fido Orawo</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Determinants of Soil Testing Decisions Among Smallholder Maize Farmers in Western Kenya <br><span class="code-cell">KALROCONF_SUB17_065</span> &nbsp; Fido Orawo</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Choice of Market Outlets Among Smallholder Cassava Farmers in Kilifi County, Kenya: A Multivariate Analysis <br><span class="code-cell">KALROCONF_SUB17_067</span> &nbsp; Abigail Chepchumba</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Modelling and Forecasting Agricultural Research Capacity in Kenya: A Comparative Analysis of CAGR and ARDL Model (2000–2025) <br><span class="code-cell">KALROCONF_SUB17_068</span> &nbsp; Titus Ngetich</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Adoption of Improved Rice Varieties and Effects on Smallholder Income in Busia County, Kenya <br><span class="code-cell">KALROCONF_SUB17_070</span> &nbsp; Ibrahim Omondi</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Varietal Bias in Coffee Production Systems in Kenya: Evidence from Kericho County <br><span class="code-cell">KALROCONF_SUB17_071</span> &nbsp; James Minai Maina</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Gendered Roles, Resource Access and Control, and Cultural–Socioeconomic Constraints in Climate-Resilient Sorghum Value Chains in Kisumu and Kericho Counties, Kenya <br><span class="code-cell">KALROCONF_SUB17_021</span> &nbsp; Anastasia W. Kagunyu</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Animal Health, Sanitary Systems &amp; Emerging Livestock Pests (11:00–12:15) → Mechanization in Agricultural Systems (12:15–1:00)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Joseph Nginyi</strong> / <strong>Wycliffe Kiprono Lang'at</strong> &nbsp;·&nbsp; Rapporteurs: Judith Mboya &amp; Joyce Addah / Gladys Chelangat &amp; Tuila Esese</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Antibacterial Potential of <em>Eucalyptus globulus</em> Leaf Extracts Against Multidrug-Resistant Clinical Isolates: A Natural Alternative for AMR Management <br><span class="code-cell">KALROCONF_SUB11_019</span> &nbsp; Elsy Kendi</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Population Genetics Insights to Inform Tsetse Fly Control in Kenya <br><span class="code-cell">KALROCONF_SUB11_021</span> &nbsp; Winnie Okeyo</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Slow and Controlled Release of Tsetse Repellent Blends in Cattle Protection Against Tsetse Flies and Trypanosomosis <br><span class="code-cell">KALROCONF_SUB11_022</span> &nbsp; Benson Wachira</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Host Preference of <em>Glossina austeni</em> at the Wildlife–Livestock–Human Interface: A One Health Approach to Trypanosome Transmission in Coastal Kenya <br><span class="code-cell">KALROCONF_SUB11_024</span> &nbsp; Erick Kibichiy Serem</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Endectocide Run-Off from East African Livestock: A One Health Assessment of Potential Mosquito Larvicide or an Ecotoxicological Threat <br><span class="code-cell">KALROCONF_SUB11_026</span> &nbsp; Clarence M. Mang'era</td></tr>
                <tr style="background:#fef9f0;"><td class="time-cell" style="color:#d97706;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#d97706;font-weight:600;font-size:.8rem;">Mechanization in Agricultural Systems (Chair: Wycliffe Kiprono Lang'at)</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Adopting Sustainable Mechanized Agriculture for Mitigation and Adaption to Climate Change <br><span class="code-cell">KALROCONF_SUB15_002</span> &nbsp; James Indika Saya</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Agricultural Mechanization Trends in Kenya's Tea Sub-sector: A Review <br><span class="code-cell">KALROCONF_SUB15_003</span> &nbsp; Wycliffe Kiprono Lang'at</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Performance Evaluation of Smallholder Dryers and their Effects on Quality of Maize and Cassava dried products <br><span class="code-cell">KALROCONF_SUB15_004</span> &nbsp; Eliud Kisito Otieno</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div><span class="room-tag">Big Seminar Room</span><br>
                <span class="subtheme-tag mt-1">Livestock Breeds, Breeding Practices &amp; Emerging Livestock Species</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Ruth Waineina</strong> &nbsp;·&nbsp; Rapporteurs: Gladys Cheruto &amp; Berrick Otieno</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Development and Application of a Bio-Economic Dairy Farm Simulation Model to Support Policy Analysis in Kenya <br><span class="code-cell">KALROCONF_SUB10_001</span> &nbsp; Samson Mwangi</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Reproductive and Birth Weight Performance for Orma Boran Cattle <br><span class="code-cell">KALROCONF_SUB10_005</span> &nbsp; Catherine Ndung'u</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Mitochondrial DNA D-Loop Polymorphisms Among Galla Goats Reveal Multiple Maternal Origins with Implications for the Functional Diversity of the HSP70 Gene <br><span class="code-cell">KALROCONF_SUB10_006</span> &nbsp; Ednah M Masila</td></tr>
                <tr><td class="time-cell">11:45–11:53 AM</td><td>Livestock performance indices as a determinant of animal improvement in ranching enterprise in a semi arid area of Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB10_002</span> &nbsp; Wilfred Saidimu Lelgut</td></tr>
                <tr><td class="time-cell">11:53 AM–12:01 PM</td><td>Farmer preferential traits in the breeding Goals of Chicken: A Case Study in Bomet County, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB10_007</span> &nbsp; Mawira George</td></tr>
                <tr><td class="time-cell">12:01–12:09 PM</td><td>Evaluation of Milk Production Potential of Sahiwal Crosses during First Lactation in Arid and Semi-Arid Areas of Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB10_008</span> &nbsp; Stephen Karanja Njenga</td></tr>
                <tr><td class="time-cell">12:09–12:17 PM</td><td>Plastic Pollution in Agriculture: Harnessing Plastivores and their Gut Microbial Adaptation for Sustainable Soil Health – A Review <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB7_031</span> &nbsp; Owen Muuo Winfred</td></tr>
                <tr><td class="time-cell">12:17–12:32 PM</td><td>Architecture for livestock production in Bomet County <br><span class="code-cell">KALROCONF_SUB7_038</span> &nbsp; Japheth Cheruiyot</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Plant Nutrition, Soil Health &amp; Conservation Agriculture</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. David Kamau</strong> &nbsp;·&nbsp; Rapporteurs: Priscila Kanza Mwangangi &amp; Robert Tabu</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Soil Fertility Status and Optimized Fertilizer Use in Marachi Central and Kingandole In Butula Sub-County, Busia County, Kenya <br><span class="code-cell">KALROCONF_SUB4_030</span> &nbsp; Kelvin Musundi</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Assessing Improved Cropping Practices on Soil Microbial Biomass in Four Contrasting Pedoclimatic Zones in Kenya <br><span class="code-cell">KALROCONF_SUB4_032</span> &nbsp; Koskei Kipkoech Silvanuss</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Soil Fertility Status and Micronutrient Dynamics Under OCP Compound Fertilizer Use in Wheat Systems of Kenya's Rift Valley Counties <br><span class="code-cell">KALROCONF_SUB4_038</span> &nbsp; Brian Imisa Sakwa</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Site Specific Wheat Yield Responses to Phosphorus–Sulfur Co application in Major Wheat Growing Counties of Kenya <br><span class="code-cell">KALROCONF_SUB4_016</span> &nbsp; Brian Imisa Sakwa</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Eco-Functional Integration: Conceptual Framework for Predictable Bioproduct-Microbiome Outcomes in Agricultural Soils <br><span class="code-cell">KALROCONF_SUB4_019</span> &nbsp; Sharon Mutua</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Analysis of Soil Nutrient Contents at Kisumu and Vihiga Counties in Western Kenya <br><span class="code-cell">KALROCONF_SUB4_028</span> &nbsp; Christine Ndinya</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Responses of Advanced Maize (<em>Zea Mays</em> L.) Hybrids to Fertilizer Combinations at Early to Mid-Vegetative Stages Across Three Environments in Kenya <br><span class="code-cell">KALROCONF_SUB4_029</span> &nbsp; Enock Kipkorir Rugut</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Effects of AMF–PGPR Co-Inoculation on Plant Recovery across Degraded Soils: A Global Meta-Analysis <br><span class="code-cell">KALROCONF_SUB4_040</span> &nbsp; Erastus Mak-Mensah</td></tr>
                <tr><td class="time-cell">1:00–1:15 PM</td><td>Efficacy of Bio stimulant and Zinc Coated fertilizers on maize seed production in Trans Nzoia and Uasin Gishu, Kenya <br><span class="code-cell">KALROCONF_SUB4_041</span> &nbsp; Keziah W. Ndungu-Magiroi</td></tr>
                <tr><td class="time-cell">1:15–1:23 PM</td><td>From the Field to a Museum: Documenting a Humic Nitisol Monolith and Proposing a Kenya Soil Museum at KALRO Kabete <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB4_024</span> &nbsp; Hillary Rotich</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

    </div><!-- /day3 morning grid -->

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 2:00–5:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div><span class="room-tag">Conference Hall</span><br>
                <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy, Adoption &amp; Socio-Economic Dimensions</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Jessica Ndubi</strong> &nbsp;·&nbsp; Rapporteurs: Judith Mutheu Mboya &amp; Tabby Karanja-Lumumba</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Farm-Level Technical Efficiency in Smallholder Tomato Production in Kenya <br><span class="code-cell">KALROCONF_SUB17_046</span> &nbsp; Michael M Mwati</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Institutional Determinants of Cotton Agribusiness Commercialization in Western Kenya: A Mixed-Methods Systematic Review and Quantitative Meta-Synthesis <br><span class="code-cell">KALROCONF_SUB17_047</span> &nbsp; Dymphina Andima</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Finger Millet (<em>Eleusine coracana</em>) Production under Climate-Smart Agriculture in Kenya: A Structured Literature Review of Agronomic, Economic, and Socioeconomic Evidence <br><span class="code-cell">KALROCONF_SUB17_048</span> &nbsp; Dymphina Andima</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Socioeconomic Determinants of Pyrethrum Farming Adoption among Small-Scale Farmers in Nakuru County, Kenya <br><span class="code-cell">KALROCONF_SUB17_049</span> &nbsp; Dominic Mokaya Mitinda</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Determinants of Potato Productivity Among Smallholder Farmers in Kenya: Evidence From Cross-Sectional Analysis <br><span class="code-cell">KALROCONF_SUB17_074</span> &nbsp; Tabby Karanja-Lumumba</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Integrating Sweet Potato (<em>Ipomea Batatas</em>) Leaves into Nutrition Policy to Reduce Anaemia among Women of Reproductive Age in Kenya <br><span class="code-cell">KALROCONF_SUB17_051</span> &nbsp; Rosemary Jepkosgei Cheboswony</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Farmer Varietal Preferences, Yield Performance, and Revenue Outcomes in Smallholder Potato Systems in Kenya <br><span class="code-cell">KALROCONF_SUB17_052</span> &nbsp; Paulatte Chelagat Kipchirchir</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Upscaling High-Iron Beans for Nutrition and Livelihoods Among Smallholder Farmers in Kenya <br><span class="code-cell">KALROCONF_SUB17_053</span> &nbsp; Korir Vicky Jepchirchir</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Impact of Marketing Policy Change on the Market Share of Coffee Marketing Agents in Kenya <br><span class="code-cell">KALROCONF_SUB17_056</span> &nbsp; James Minai</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Demand Drivers for Rice Seed in Kenya: Evidence from a Review of the Rice Sub-Sector and an Empirical Study in the Rice-Growing Regions <br><span class="code-cell">KALROCONF_SUB17_058</span> &nbsp; Anita Nunu</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Understanding Sheep Price Formation in Pastoral Markets: A Study of Rumuruti Market, Kenya <br><span class="code-cell">KALROCONF_SUB17_059</span> &nbsp; Zachary Muturi</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Enhancing Smallholder Chicken Productivity Through Targeted Capacity Building: Evidence from Bomet County, Kenya <br><span class="code-cell">KALROCONF_SUB17_061</span> &nbsp; Mercy Soi</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Plant Health, Emerging Crop Pests &amp; Diseases, Biosecurity &amp; Phytosanitary Systems</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Victor Jaoko – KEFRI</strong> &nbsp;·&nbsp; Rapporteurs: George Mukhwana &amp; Titus Ngetich</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Effect of Application of Different Doses of Atrazine Herbicide on Weed Control, Productivity and Economics of Sugarcane <br><span class="code-cell">KALROCONF_SUB3_001</span> &nbsp; Ginson Riungu</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Combating Potato Late Blight Disease: Effective Strategies for Crop Protection <br><span class="code-cell">KALROCONF_SUB3_003</span> &nbsp; Robert Tabu</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Preliminary observation of amaranth diseases in Eastern and Western Kenya <br><span class="code-cell">KALROCONF_SUB3_004</span> &nbsp; Henry Nzioki</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Reaching Out to Farmers using an Innovative Tool: Plant Clinics <br><span class="code-cell">KALROCONF_SUB3_006</span> &nbsp; Miriam Judith Otipa</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Evaluation of Garlic Extract as Potential Pyrethrum Synergist Against Maize weevils <br><span class="code-cell">KALROCONF_SUB3_021</span> &nbsp; Dr. Janet Obanyi</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Evaluation of <em>Trichoderma</em> spp. propagules in the soil and colonization of mycorrhizal structures in tea roots as biofertilizer <br><span class="code-cell">KALROCONF_SUB3_022</span> &nbsp; Samuel Tanui</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Pathogenic Diversity of Bean Anthracnose Pathogen, <em>Colletotrichum lindemuthianum</em>, in Selected Bean Growing Areas of Muranga County <br><span class="code-cell">KALROCONF_SUB3_023</span> &nbsp; Patrick Musyoka</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Biological Control Approach For Tea Weevils in Kenya <br><span class="code-cell">KALROCONF_SUB3_024</span> &nbsp; Joel K. Langat</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Host Specificity and Resistance of Cowpea to Scab Caused by <em>Elsinoé</em> spp <br><span class="code-cell">KALROCONF_SUB3_026</span> &nbsp; Shadrack Odikara Oriama</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Comparative Assessment of Sample Types and Preparation Techniques in ELISA Detection of Maize Chlorotic Mottle Virus in Seed <br><span class="code-cell">KALROCONF_SUB3_033</span> &nbsp; Esther Nyambura Kimani</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Morphological and Pathological Characterization of Finger Millet Blast in Baringo and Elgeyo Marakwet Counties, Kenya <br><span class="code-cell">KALROCONF_SUB3_028</span> &nbsp; Angela Cherunya</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Screening Different Leafy Vegetables for Suitability as Trap Crops for Root-Knot Nematodes in Greenhouse Tomato <br><span class="code-cell">KALROCONF_SUB3_029</span> &nbsp; George Mukhwana</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div><span class="room-tag">Big Seminar Room</span><br>
                <span class="subtheme-tag mt-1">Crop Varieties, Increased Productivity &amp; Production Management</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Samson Kamunya</strong> &nbsp;·&nbsp; Rapporteurs: Berrick Otieno &amp; Esther Kimani</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Optimising Cropping Systems for Enhanced Productivity in Smallholder Farming Systems <br><span class="code-cell">KALROCONF_SUB1_093</span> &nbsp; Siyabusa Mkuhlani</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Temperature Influences Hydrocyanic Acid Potential in Sorghum <br><span class="code-cell">KALROCONF_SUB1_070</span> &nbsp; Lilian Atieno Ouma</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Effect of Weed Management Practices on Green Gram Yield in the Semi-Arid Regions of Tharaka-Nithi County, Kenya <br><span class="code-cell">KALROCONF_SUB1_071</span> &nbsp; Peter Waweru</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Effect of Plant Density and Weed Management on Cotton Performance <br><span class="code-cell">KALROCONF_SUB1_072</span> &nbsp; Marion Awuor Okwado</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Evaluation of Adaptability, Participatory Variety Selection, and Consumer Acceptability of Quinoa across Agro-Ecological Zones in Kenya <br><span class="code-cell">KALROCONF_SUB1_074</span> &nbsp; Susan Wanderi</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Harnessing Halotolerant Microorganisms to Improve Crop Productivity in Salinity-Affected Agro ecosystems in Kenya <br><span class="code-cell">KALROCONF_SUB1_076</span> &nbsp; Moses Nyangau Mandere</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Genetic Gain in Kenyan Wheat Breeding: Evidence from Two Environments <br><span class="code-cell">KALROCONF_SUB1_078</span> &nbsp; Godwin Macharia</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Fruit and Vegetable Production in Nyanza and Western Kenya: Systems, Constraints, and Opportunities <br><span class="code-cell">KALROCONF_SUB1_079</span> &nbsp; Timon Kipkorir Moi</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Harnessing Artificial Intelligence in Common Bean Breeding: A Review of Potential to Enhance Nutrition and Yield in Kenya <br><span class="code-cell">KALROCONF_SUB1_080</span> &nbsp; Simon Meso Obila</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Yield Performance of Oyster Mushroom Genotypes Under Varied Cultivation Conditions and Seasonal Changes <br><span class="code-cell">KALROCONF_SUB1_087</span> &nbsp; Gladwel Chepg'etich Ng'eno</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Phenotypic Characterization of Snap Beans for Yield and Yield-Related Traits <br><span class="code-cell">KALROCONF_SUB1_099</span> &nbsp; Lucas Suva</td></tr>
                <tr><td class="time-cell">4:45–4:53 PM</td><td>Comparative Evaluation of the Performance of four forage Sorghum Varieties in Mariakani, Kilifi County <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_085</span> &nbsp; Robert Kiptoo</td></tr>
                <tr><td class="time-cell">4:53–5:01 PM</td><td>Effect of OCP Fertilizers on Growth and Yield of Potato in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_065</span> &nbsp; Judith Oyoo</td></tr>
                <tr><td class="time-cell">5:01–5:09 PM</td><td>Influence of Land Preparation Techniques on Sugarcane Yield and Farm Level Production Costs in South Nyanza, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB1_088</span> &nbsp; Carolyne Kasisi</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Technology Transfer, ICT-Enabled Precision Systems (2:00–4:39) → Food Safety, Value Addition &amp; Cottage Industries (4:40–5:40)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Karl Nyabundi</strong> / <strong>Dr. Willis Adero</strong> &nbsp;·&nbsp; Rapporteurs: Nicholas Kibunyi &amp; Tuila Esese / Titus Ngetich &amp; Judith Mutheu Mboya</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Drivers of Push-Pull Integrated Pest Management Adoption among Smallholder Maize Framers in Western Kenya and Eastern Uganda: A Binary Logit Analysis <br><span class="code-cell">KALROCONF_SUB16_036</span> &nbsp; Joseph Mutungati Mugendi</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>From Research to Market: Commercializing the Komboka Rice Variety for Kenya's Food Security – A Success Story <br><span class="code-cell">KALROCONF_SUB16_038</span> &nbsp; Ruth Musila</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Leveraging KALRO Open Week To Strengthen Extension Architecture for Resilience Building: A Case of KALRO Kabete Open Week <br><span class="code-cell">KALROCONF_SUB16_039</span> &nbsp; Simion Dancan Orare</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>The Role of Digitization in Enhancing Dissemination of Modern Livestock Technologies <br><span class="code-cell">KALROCONF_SUB16_047</span> &nbsp; Jimmy Gachanja Musyoki</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Enabling the Transition from Traditional to AI-Supported Farming: Baseline Insights on Smallholder Decision-Making <br><span class="code-cell">KALROCONF_SUB16_050</span> &nbsp; Elizabeth Mwashuma</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Farming at the Edge of the Wild: Assessing Agroecological Transition in the Southern Kenya–Northern Tanzania (SOKNOT) Transboundary Conservation Landscape Using F-ACT <br><span class="code-cell">KALROCONF_SUB16_051</span> &nbsp; Ogalo Baka</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>From Research Station to Field Application: The Role of a Dairy Innovation Support Unit in Forage-Based Dairying in Kenya <br><span class="code-cell">KALROCONF_SUB16_053</span> &nbsp; Fredrick Agutu</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Impact of Ward Coffee Champions Trainings on Youth Involvement and Performance in the Coffee Value Chain <br><span class="code-cell">KALROCONF_SUB16_055</span> &nbsp; Emmanuel Kimeu</td></tr>
                <tr><td class="time-cell">4:00–4:08 PM</td><td>Farmers' Perceptions of Fall Armyworm Mitigation Technologies in the Imbo Plain, Burundi <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB16_034</span> &nbsp; Arthemon Manariyo</td></tr>
                <tr><td class="time-cell">4:08–4:16 PM</td><td>Leveraging on ICT-Based Webinars for Dissemination of Sericulture Technologies to Farmers in Bungoma County, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB16_035</span> &nbsp; Noel Makete</td></tr>
                <tr><td class="time-cell">4:16–4:24 PM</td><td>Kibos ICT Management System <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB16_045</span> &nbsp; David Muliatsi Inonda</td></tr>
                <tr><td class="time-cell">4:24–4:39 PM</td><td>Shamba Bot: A Climate-Smart Agritech and Fintech Super-Platform for Enhancing Smallholder Farmer Productivity, Market Access, and Financial Inclusion in Kenya <br><span class="code-cell">KALROCONF_SUB16_037</span> &nbsp; Morgan Onyango Bala</td></tr>
                <tr style="background:#fef2f2;"><td class="time-cell" style="color:#dc2626;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#dc2626;font-weight:600;font-size:.8rem;">Food Safety, Value Addition &amp; Cottage Industries (Chair: Dr. Willis Adero)</td></tr>
                <tr><td class="time-cell">4:40–4:55 PM</td><td>Integrating Biological Control, Farmer Capacity Building and Surveillance for Mycotoxin Management in Kenya <br><span class="code-cell">KALROCONF_SUB14_025</span> &nbsp; Nancy Karimi Njeru</td></tr>
                <tr><td class="time-cell">4:55–5:10 PM</td><td>Prevalence, Genotypic Characterization and Hygiene Related Risk Factors of <em>Salmonella Enterica</em> Along the Broiler Slaughter Continuum in Peri-Urban Kenya <br><span class="code-cell">KALROCONF_SUB14_026</span> &nbsp; Angela Wanjiku Mwangi</td></tr>
                <tr><td class="time-cell">5:10–5:25 PM</td><td>Sympathomimetic Action of Khat (<em>Catha Edulis</em>): A Mechanistic Overview of its Adrenergic Agonist Activity <br><span class="code-cell">KALROCONF_SUB14_034</span> &nbsp; Kevin Nthiga Muchangi</td></tr>
                <tr><td class="time-cell">5:25–5:40 PM</td><td>Influence of Cutting Intensity and Fermentation Duration on Polyphenols, Catechins, Caffeine, and Grade Yield in Black CTC Tea <br><span class="code-cell">KALROCONF_SUB14_035</span> &nbsp; Henrik Ruto</td></tr>
            </tbody></table>
        </div>

    </div><!-- /day3 afternoon grid -->

</div><!-- /day3 -->

{{-- ══════════════════════════════════════════════
     DAY 4 — Thursday 18 June 2026
══════════════════════════════════════════════ --}}
<div class="prog-day" id="day4">

    <div class="plenary-block">
        <div class="plenary-head">
            <div>
                <h4>Session One: Plenary Keynote Presentation</h4>
                <div style="opacity:.75;font-size:.82rem;margin-top:4px;">Chairperson: Dr. Kipkemoi Changwony &nbsp;·&nbsp; Rapporteur: Phyllis Alusi</div>
            </div>
            <span class="venue-badge">📍 Main Conference Hall</span>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Event</th><th>Facilitator</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">7:30 AM – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 AM – 9:30 AM</td><td><strong>Chief Guest Address: <em>Embracing Agricultural Science, Technologies and Innovations to Drive Commercialization Initiatives.</em></strong><br>
                    Dr. Erick Kipkoech Rutto – President, Kenya National Chamber of Commerce and Industry (KNCCI)<br><br>
                    <strong>Moderator:</strong> Dr. Michael Okoti<br><br>
                    <strong>Panelists:</strong><br>
                    <ul style="margin:4px 0 0 16px;font-size:.84rem;">
                        <li>Dr. Tonny Omwansa CEO, KENIA</li>
                        <li>Dr. James Reagan Mwaura, County Chairman, KNCCI – Nairobi County Chapter</li>
                        <li>Mr. Sriram Bharatam, Founder and CEO, Kuza One / Kuza Biashara</li>
                    </ul>
                </td><td>Moderator: Dr. Michael Okoti</td></tr>
                <tr><td class="time-cell">9:30 AM – 10:00 AM</td><td><strong>Keynote address: <em>Resilient Livestock Systems in a Changing Climate: Nutrition and Health Perspectives.</em></strong><br>Prof. Levi Musalia – Tharaka University</td><td></td></tr>
                <tr><td class="time-cell">10:00 AM – 10:10 AM</td><td>Signing of Soya bean commercialisation agreement between Shirika Vini and KALRO</td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:10 AM – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
                <tr><td class="time-cell">11:00 AM</td><td><strong>Session Breakouts</strong></td><td></td></tr>
            </tbody>
        </table>
    </div>

    <div class="side-event-card">
        <div class="side-event-head" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
            <h4 style="margin:0;">⚡ Side Events — Thursday 18 June 2026</h4>
            <a href="{{ asset('program/Program_Side_event.pdf') }}"
               download="Program_Side_event.pdf"
               style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.4);color:white;font-size:.78rem;font-weight:700;padding:6px 14px;border-radius:20px;text-decoration:none;white-space:nowrap;transition:background .15s;"
               onmouseover="this.style.background='rgba(255,255,255,0.28)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download Side Events PDF
            </a>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Session Title</th><th>Host</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">09:00–11:00</td><td>Sustainable Livestock in Kenya: Unlocking Economic, Environmental &amp; Social Benefits</td><td><strong>ILRI</strong></td></tr>
                <tr><td class="time-cell">10:00–12:30</td><td>Accelerating Sustainable Production, Market Trade &amp; Consumption</td><td><strong>Alliance of Bioversity International &amp; CIAT</strong></td></tr>
                <tr><td class="time-cell">11:00–13:00</td><td>Business Session: Cassava Starch Processing — Which Way Forward?</td><td><strong>KALRO / AFA</strong></td></tr>
                <tr><td class="time-cell">14:00–16:00</td><td>Business Session: ECF Vaccine Commercialisation</td><td><strong>KALRO (VSRI)</strong></td></tr>
            </tbody>
        </table>
    </div>

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 11:00 AM – 1:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div><span class="room-tag">Conference Hall</span><br>
                <span class="subtheme-tag mt-1">Animal Feed Resources, Nutrition &amp; Husbandry Practices</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Elkanah Nyambati</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Nicholas Kibunyi</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Effects of Urea-Molasses Mineral Block Supplementation on Digestibility of Dorper Sheep on Buffelgrass Diet in Kenya <br><span class="code-cell">KALROCONF_SUB9_024</span> &nbsp; Sally Nduta</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Milk Offtake, Compensatory Growth, and Dual-Purpose Productivity of Boran Cattle Under Extensive Grazing <br><span class="code-cell">KALROCONF_SUB9_026</span> &nbsp; Jack Ouda</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Concentrate Supplementation of Lactating Dairy Goats Improves Nutritional and Therapeutic Value of Goat Milk: A Case in Kenya <br><span class="code-cell">KALROCONF_SUB9_027</span> &nbsp; Joseph Ndwiga Kiura</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Nutritive value and Effects of Total Mixed Ration compared with grazing on Milk Composition of Mid-Lactation Dairy cows <br><span class="code-cell">KALROCONF_SUB9_029</span> &nbsp; Ezra Kiplangat Sang</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Performance of Sheep Fed on Different Diets and Relationships Among In Vivo and In Vitro Gas Production Technique-Derived Measurements <br><span class="code-cell">KALROCONF_SUB9_002</span> &nbsp; Jack Ouda</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Evaluation of Megathyrus spp and Urochloa spp Forage Grasses under Research and Farmer-Managed Conditions in Western Kenya <br><span class="code-cell">KALROCONF_SUB9_003</span> &nbsp; Peggy Karimi</td></tr>
                <tr><td class="time-cell">12:30–12:38 PM</td><td>Evaluation of Growth Performance of Two Improved Kienyeji Breeds (KALRO KC1 and KALRO KC3) Reared Under Coastal Environmental Conditions <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_022</span> &nbsp; Isaac Kenga</td></tr>
                <tr><td class="time-cell">12:38–12:46 PM</td><td>Comparison of Natural Egg Yolk–Based Feeding Media and Wheat Bran–Liver Substrate for Efficient Production of Lucilia Sericata Larvae as A Sustainable Livestock Protein Source <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_031</span> &nbsp; Kipkirui Billy</td></tr>
                <tr><td class="time-cell">12:46–12:54 PM</td><td>Black Soldier Fly Larval Meal as an Affordable and Cost-Effective Protein Source for Enhancing Rainbow Trout (<em>Oncorhynchus mykiss</em>) Growth: A Case Study of KALRO Oljoroorok <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_037</span> &nbsp; Sambu Saitoti</td></tr>
                <tr><td class="time-cell">12:54–1:02 PM</td><td>Laying Trends and Factors Influencing Productivity in the KALRO Improved Indigenous KC3 Breed line <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_008</span> &nbsp; Sharona Imali</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Ecological-Organic Farming Systems, Renewable Energy Integration &amp; Circular Economy (11:00–11:54) → Plant Health (12:00–1:15)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Duba Golicha</strong> / <strong>Dr. David Thuranira</strong> &nbsp;·&nbsp; Rapporteurs: Joyce Addah &amp; Gladys Cheruto / Berrick Otieno &amp; George Mukhwana</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Ammonia as a Source of Bioenergy to Power Agriculture and Food Systems in Kenya <br><span class="code-cell">KALROCONF_SUB6_005</span> &nbsp; Tabeel Nandokha</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Fungal Enzyme-Assisted Bioconversion of Agricultural Waste for Sustainable Soil Fertility Management in Kenya <br><span class="code-cell">KALROCONF_SUB6_010</span> &nbsp; Moses Mandere</td></tr>
                <tr><td class="time-cell">11:30–11:38 AM</td><td>Organic Conservation Agricultural Practices as Pathways for Soil Fertility Restoration and Sustainable Land Resource Replenishment: Case of Subsistence Farmers in Kakamega County, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB6_002</span> &nbsp; Chepkania Miriam Nangila</td></tr>
                <tr><td class="time-cell">11:38–11:46 AM</td><td>Enhancing Soil Health and Food Safety through Organic Waste Composting in Urban and Peri-Urban Farming <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB6_003</span> &nbsp; Esther K. Muriuki</td></tr>
                <tr><td class="time-cell">11:46–11:54 AM</td><td>Vegetable Production Using Organic Manures (Frass) Produced from Black Soldier Fly (BSF) Using Different Substrates (Mango, Avocado, Chicken Waste, and Brewers Waste) <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB6_007</span> &nbsp; Elizabeth W. Okwach</td></tr>
                <tr style="background:#fef2f2;"><td class="time-cell" style="color:#dc2626;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#dc2626;font-weight:600;font-size:.8rem;">Plant Health, Emerging Crop Pests &amp; Diseases (Chair: Dr. David Thuranira)</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Crop Health as Human Health: Redefining Food Safety Through the Lens of Plant Disease Management and Nutritional Security <br><span class="code-cell">KALROCONF_SUB3_007</span> &nbsp; Harun Odhiambo</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Climate Vulnerability and the Burden of Pests Among Smallholder Coffee Farmers in Eight Coffee-Growing Counties of Kenya <br><span class="code-cell">KALROCONF_SUB3_008</span> &nbsp; Getrude Alworah</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Survey of Phytophthora Root Rot Disease of Avocado in Kandara and Kigumo Sub-Counties of Murang'a County <br><span class="code-cell">KALROCONF_SUB3_009</span> &nbsp; Ruth Amata</td></tr>
                <tr><td class="time-cell">12:45–1:00 PM</td><td>Elucidating Mechanisms of Resistance to Fall Armyworm (<em>Spodoptera frugiperda</em>) in Maize Through Laboratory Feeding and Life Table Analysis <br><span class="code-cell">KALROCONF_SUB3_040</span> &nbsp; Gerphas Ogola</td></tr>
                <tr><td class="time-cell">1:00–1:15 PM</td><td>Screening for Cashew Powdery Mildew Tolerance in Cashew Varieties in Coastal Kenya <br><span class="code-cell">KALROCONF_SUB3_041</span> &nbsp; Alfred Mumba</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div><span class="room-tag">Big Seminar Room</span><br>
                <span class="subtheme-tag mt-1">Water Harvesting, Conservation &amp; Irrigation Systems</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Carolyne Kundu</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Tuila Esese</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Determinants of Uptake of Climate-Resilient Irrigation Practices Among Smallholder Onion Farmers in Laikipia County, Kenya <br><span class="code-cell">KALROCONF_SUB5_001</span> &nbsp; Ian Kiplagat Katui</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Smart Irrigation Technologies for Improved Water Use Efficiency in Fodder Production Among Livestock Farmers in Kenya: A Review <br><span class="code-cell">KALROCONF_SUB5_002</span> &nbsp; Beatrice Cherono Langat</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Grey Water Management for Irrigation in Semi-Arid Areas of Kenya <br><span class="code-cell">KALROCONF_SUB5_003</span> &nbsp; Okoth Felix Odiwuor</td></tr>
                <tr><td class="time-cell">11:45–12:00 Noon</td><td>Low-Cost Wastewater Treatment and Re Use System for Sustainable Irrigation using a Treated Water Basin and DIY Pump Technology <br><span class="code-cell">KALROCONF_SUB5_007</span> &nbsp; Samuel Mukanga</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Optimizing Water Use in Farming Systems: A review of Tools and Methods <br><span class="code-cell">KALROCONF_SUB5_008</span> &nbsp; Maingi Susan</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Promoting Lined Water Pans for Climate-Resilient Small-Scale Irrigation in Kenya <br><span class="code-cell">KALROCONF_SUB5_009</span> &nbsp; Francis Karanja</td></tr>
                <tr><td class="time-cell">12:30–12:38 PM</td><td>Effect of Superabsorbent Polymers on the Production of African Nightshade in Mollic Nitisols, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB5_011</span> &nbsp; Geoffrey Kibiri</td></tr>
                <tr class="break-row"><td class="time-cell">1:00 AM–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy, Adoption &amp; Socio-Economic Dimensions</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Scholastica Wambua</strong> &nbsp;·&nbsp; Rapporteurs: Gladys Chelangat &amp; Tabby Karanja</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15 AM</td><td>Economic Implication of Post-Harvest Losses in Tomato Production in Kenya <br><span class="code-cell">KALROCONF_SUB17_073</span> &nbsp; Moses Kimani</td></tr>
                <tr><td class="time-cell">11:15–11:30 AM</td><td>Gender Differences in Market-Oriented Smallholder Tomato Productivity in Kenya: An Oaxaca-Blinder Decomposition Approach <br><span class="code-cell">KALROCONF_SUB17_050</span> &nbsp; Purity Kawira Muriuki</td></tr>
                <tr><td class="time-cell">11:30–11:45 AM</td><td>Insights on the Effects on Mechanization in the Tea Industry in Kenya <br><span class="code-cell">KALROCONF_SUB17_079</span> &nbsp; Simon Oduor Ochanda</td></tr>
                <tr><td class="time-cell">11:45–12:00 PM</td><td>Restructuring KALRO's Seeds For Enhanced Production, Quality Assurance and Distribution of Seeds Ensuring Sustainability <br><span class="code-cell">KALROCONF_SUB17_080</span> &nbsp; Robert Musyoki</td></tr>
                <tr><td class="time-cell">12:00–12:15 PM</td><td>Does the Plot Manager Matter? An Assessment of Household Productivity of Maize–Legume Systems in West Alego Ward, Siaya County, Kenya <br><span class="code-cell">KALROCONF_SUB17_081</span> &nbsp; Martha Akello Opondo</td></tr>
                <tr><td class="time-cell">12:15–12:30 PM</td><td>Gender Differentials in Yield and Productivity among Contracted Bean Seed Growers in West Pokot County, Kenya <br><span class="code-cell">KALROCONF_SUB17_023</span> &nbsp; Jerop Edith</td></tr>
                <tr><td class="time-cell">12:30–12:45 PM</td><td>Leveraging Routine Sales Data to Understand Gendered, Spatial, and Temporal Demand in Smallholder Agricultural Input Markets: A Replicable Analytics Framework <br><span class="code-cell">KALROCONF_SUB17_025</span> &nbsp; Isaac Kenga</td></tr>
                <tr><td class="time-cell">12:45–12:53 PM</td><td>Dynamics of marketing of Green Shelled Beans Among urban traders in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB17_022</span> &nbsp; Beth Ndungu</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

    </div><!-- /day4 morning sessions -->

    <h5 style="font-size:1rem;font-weight:700;color:#14532d;margin:28px 0 14px;display:flex;align-items:center;gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#14532d" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Parallel Sessions — 2:00–5:00 PM
    </h5>
    <div class="sessions-grid">

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">1</div>
                <div><span class="room-tag">Conference Hall</span><br>
                <span class="subtheme-tag mt-1">Animal Feed Resources, Nutrition &amp; Husbandry Practices (2:00–4:00) → Plant Health (4:00–5:00)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Tura Isako</strong> / <strong>Dr. Miriam Otipa</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Nicholas Kibunyi / Hillary Rotich &amp; Miriam Mbiyu</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Seasonal Dynamics of Pasture Productivity and Feed Availability in Kenyan Rangelands: A Data-Driven Analysis Using Satellite and Climate Data <br><span class="code-cell">KALROCONF_SUB9_033</span> &nbsp; Lenah Muema</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Spineless Cactus (<em>Opuntia ficus-indica</em>) as a Climate-Smart Forage Crop: Effects of Planting Method and Integrated Nutrient Management in Kenya's ASALs <br><span class="code-cell">KALROCONF_SUB9_036</span> &nbsp; John Irungu</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Yield and Quality of Napier Varieties under Different Moisture Conservation Practices in Machakos County, Kenya <br><span class="code-cell">KALROCONF_SUB9_038</span> &nbsp; Robert Ouko Owano</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Evaluation of Phenotypic and Genotypic Diversity in Forage and Dual-Purpose Sorghums in Kenya: A Review <br><span class="code-cell">KALROCONF_SUB9_021</span> &nbsp; Mercy Jerop</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Assessment of nutritive attributes and in vitro dry matter digestibility of Pakchong Napier, Juncao Napier, Kakamega 1, and Red Napier Grass varieties as feed sources <br><span class="code-cell">KALROCONF_SUB9_004</span> &nbsp; Lorna Chemutai Chesir</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Feed Efficiency and Body Condition Responses of Red Maasai Sheep Fed Total Mixed Ration versus Grazing on Natural Pastures <br><span class="code-cell">KALROCONF_SUB9_005</span> &nbsp; Fred Kemboi</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Comparative Performance of Improved Boran Steers Finished on Total Mixed Ration in the feedlot system and the Free-Range Grazing system in Kenya <br><span class="code-cell">KALROCONF_SUB9_006</span> &nbsp; Tura Isako</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Apparent Nutrient Digestibility and Productivity in Chicken Fed on High Quality and Affordable Feed Rations <br><span class="code-cell">KALROCONF_SUB9_007</span> &nbsp; Innocent Kariuki</td></tr>
                <tr style="background:#f0fdf4;"><td class="time-cell" style="color:#14532d;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#14532d;font-weight:600;font-size:.8rem;">Plant Health, Emerging Crop Pests &amp; Diseases (Chair: Dr. Miriam Otipa)</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Banana Weevil Infestation in Different Banana Cultivars and Use Types: Implications for Host Plant Resistance and Management <br><span class="code-cell">KALROCONF_SUB3_030</span> &nbsp; Ceciliah Ngugi</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Integrated evaluation of Blast in Combined Diverse and Elite Rice Panel using Kenya Isolates of <em>Magnaporthe oryzea</em> <br><span class="code-cell">KALROCONF_SUB3_031</span> &nbsp; Roselyne Juma</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Pathogenicity of Rice Yellow Mottle Virus Isolates and Response of Selected Rice Cultivars under Screen House Conditions in Kenya <br><span class="code-cell">KALROCONF_SUB3_032</span> &nbsp; Simon Meso Obila</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Comparative Efficacy of Botanical And Synthetic Dust Treatments Against Major Stored-Product Pests of Maize, Wheat and Beans <br><span class="code-cell">KALROCONF_SUB3_039</span> &nbsp; Mark Limo</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Sustainable Seed Systems, Quality Assurance &amp; Scalability (2:00–3:39) → Climate Change &amp; Land Degradation (3:39–5:17)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Godwin Macharia</strong> / <strong>Dr. Golicha Dub</strong> &nbsp;·&nbsp; Rapporteurs: Harun Odhiambo &amp; Sheila Siele / Peterson Mwangi &amp; Tuila Esese</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>A Sustainable Forage Seed Systems as a Pathway to Address Livestock Feed Shortages in Arid and Semi-Arid Areas of Kenya <br><span class="code-cell">KALROCONF_SUB2_001</span> &nbsp; Rose Nelima Wekesa</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Optimising Nutrient Management for Enhanced Seed Yield and Quality of <em>Enteropogon macrostachyus</em> in Semi-Arid Rangelands <br><span class="code-cell">KALROCONF_SUB2_002</span> &nbsp; Bryan Peter Ogillo</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Breaking Oil Palm Seed Dormancy: A Comparative Review of Heat, Chemical, and Mechanical Pretreatments <br><span class="code-cell">KALROCONF_SUB2_003</span> &nbsp; Lynet Nasiroli Navangi</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Validation and Performance Analysis of Single Eye Bud Technology for Improved Sugarcane Seed Production Efficiency in Kibos Kenya <br><span class="code-cell">KALROCONF_SUB2_009</span> &nbsp; Edwin Shikanda</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Overcoming Brachiaria Seed Bottlenecks: Nursery Rapid Multiplication of Root Splits for Accelerated Climate-Smart Forage Dissemination <br><span class="code-cell">KALROCONF_SUB2_010</span> &nbsp; Meshack Kipngetich Rutto</td></tr>
                <tr><td class="time-cell">3:15–3:23 PM</td><td>Development and promotion of finger millet seed system in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB2_020</span> &nbsp; Peninah Chelangat Langat</td></tr>
                <tr><td class="time-cell">3:23–3:31 PM</td><td>Structure and Constraints of the Pyrethrum Seed Systems in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB2_021</span> &nbsp; Peter Kimutai Kirwa</td></tr>
                <tr><td class="time-cell">3:31–3:39 PM</td><td>Bridging the Last-Mile Gap in Sustainable Seed Systems: A Case Study of KALRO Mkulima Shops Model <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB2_027</span> &nbsp; Stephen Irungu</td></tr>
                <tr style="background:#fef9f0;"><td class="time-cell" style="color:#d97706;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#d97706;font-weight:600;font-size:.8rem;">Climate Change, Land Degradation &amp; Reclamation (Chair: Dr. Golicha Dub)</td></tr>
                <tr><td class="time-cell">3:39–3:54 PM</td><td>Land Use Changes and Vegetation Decline: Investigating Rangeland Degradation in Gursum District, Somali Region, Ethiopia <br><span class="code-cell">KALROCONF_SUB7_001</span> &nbsp; Mahamud Fuad Fuad</td></tr>
                <tr><td class="time-cell">3:54–4:09 PM</td><td>Decoding the Factors Influencing Transition from Awareness to Adoption of Climate-Smart Technologies and Management Practices among Smallholder Farmers Linked to School Feeding Programmes in Kenya <br><span class="code-cell">KALROCONF_SUB7_003</span> &nbsp; Shirley Auma Oloo</td></tr>
                <tr><td class="time-cell">4:09–4:24 PM</td><td>Morphological and Yield Performance of Certified Range Grasses in Arid and Semi-Arid lands of Kenya <br><span class="code-cell">KALROCONF_SUB7_004</span> &nbsp; Rop Daniel</td></tr>
                <tr><td class="time-cell">4:24–4:39 PM</td><td>Integrated Bush Management and Reseeding for Restoring Forage Productivity in Semi-Arid Rangelands of Kenya <br><span class="code-cell">KALROCONF_SUB7_006</span> &nbsp; Mercy Chebet</td></tr>
                <tr><td class="time-cell">4:39–4:54 PM</td><td>Adoption and Impact of Climate Smart Agriculture Practices in Kigumo Sub-County Murang'a County, Kenya <br><span class="code-cell">KALROCONF_SUB7_007</span> &nbsp; Lilian Weisiko Nyamohanga</td></tr>
                <tr><td class="time-cell">4:54–5:09 PM</td><td>How Agribusiness SMEs in Kiambu and Kajiado Counties, Kenya are Adapting to Weather Effects <br><span class="code-cell">KALROCONF_SUB7_008</span> &nbsp; Nancy Mwihaki Ng'ang'a</td></tr>
                <tr><td class="time-cell">5:09–5:17 PM</td><td>Bio-Energy Innovation using Agricultural Residues as Sustainable Alternatives to Charcoal for Climate-Resilient Livelihoods in Tenges Ward, Baringo County, Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB7_002</span> &nbsp; Dennis Kipng'etich Kandie</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div><span class="room-tag">Big Seminar Room</span><br>
                <span class="subtheme-tag mt-1">Climate Change, Land Degradation &amp; Reclamation (2:00–3:15) → Agribusiness &amp; Socio-Economics (3:15–4:15) → Food Safety (4:15–5:30)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. David Kamau</strong> / <strong>Dr. Scholastica Wambua</strong> / <strong>Mr. John Irungu</strong> &nbsp;·&nbsp; Rapporteurs: Harun Odhiambo &amp; Robert Tabu</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Understanding Climate Variability Effects and Perceptions on Post-Harvest Management in Horticultural Value Chains in Kenya <br><span class="code-cell">KALROCONF_SUB7_010</span> &nbsp; Daniel Musyoka</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Influence of Weather and Climate Information Services (WCIS) On The Adoption Of Climate-Smart Technologies (CST) Among Bean Farmers <br><span class="code-cell">KALROCONF_SUB7_011</span> &nbsp; Millicent Kalenya</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Effect of Rainfall Variation on Demand and Sales of Avocado Seedlings at KALRO Kandara Nursery <br><span class="code-cell">KALROCONF_SUB7_027</span> &nbsp; Faith Wambui Mucunu</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Validating Multi-Storey Gardens for Climate-Resilient, Nutritious, Safe, and Profitable Food Production in Kenya <br><span class="code-cell">KALROCONF_SUB7_030</span> &nbsp; Charity Kiplagat</td></tr>
                <tr style="background:#fef9f0;"><td class="time-cell" style="color:#d97706;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#d97706;font-weight:600;font-size:.8rem;">Agribusiness, Financing, Policy &amp; Socio-Economic Dimensions (Chair: Dr. Scholastica Wambua)</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Adoption of Climate-Smart Agricultural Practices by Pigeon Pea Farmers for Increased Yields in Machakos County <br><span class="code-cell">KALROCONF_SUB17_084</span> &nbsp; Agatha Mumbua Daniel</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Factors Contributing to Low Groundnut Productivity in Western Kenya Despite High Market Demand: A Review <br><span class="code-cell">KALROCONF_SUB17_086</span> &nbsp; Simon Meso Obila</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Agronomic and Farmer-Perceived Performance of Customized Fertilizers for Maize in 13 counties in Kenya <br><span class="code-cell">KALROCONF_SUB17_087</span> &nbsp; Mwathi Jane Wamaitha</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Leveraging Public Private Partnerships to Strengthen Sustainable Seed Systems: Evidence From Kilimo Biashara Expos Model <br><span class="code-cell">KALROCONF_SUB17_089</span> &nbsp; Samuel Kiiru</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Unlocking the Potential of <em>Indigofera</em> spp. in Kenya: Opportunities for Natural Dye Production, Climate-Smart Agriculture, and Smallholder Livelihoods <br><span class="code-cell">KALROCONF_SUB17_091</span> &nbsp; Christine Kasichana</td></tr>
                <tr style="background:#fef2f2;"><td class="time-cell" style="color:#dc2626;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#dc2626;font-weight:600;font-size:.8rem;">Food Safety, Value Addition &amp; Cottage Industries (Chair: Mr. John Irungu)</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Efficacy of Nixtamalization On Reduction of Fumonisin Contamination in Maize <br><span class="code-cell">KALROCONF_SUB14_009</span> &nbsp; Sylviah Nekesa</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Practices Influencing Mycotoxin Contamination in Maize and Farmers' Perceptions on the Use of Rapid Test Kits in Aflatoxin Detection <br><span class="code-cell">KALROCONF_SUB14_011</span> &nbsp; Beatrice Nafula Tenge</td></tr>
                <tr><td class="time-cell">5:00–5:15 PM</td><td>Occurrence of Aflatoxin and Fumonisin in Foods Consumed By Children Aged 6-59 Months in Transitional Pastoral Households in Marsabit County <br><span class="code-cell">KALROCONF_SUB14_012</span> &nbsp; Amos Otieno Adongo</td></tr>
                <tr><td class="time-cell">5:15–5:30 PM</td><td>A Review of Epidemiological Trends, Molecular Mechanisms, and Public Health Implications of Foodborne Aflatoxin Exposure and Cancer Prevalence in Developing Countries <br><span class="code-cell">KALROCONF_SUB14_013</span> &nbsp; Kimeu Urbanus</td></tr>
                <tr><td class="time-cell">5:30–5:45 PM</td><td>Comparative Evaluation of Physical and Cup Quality Performance of Global Coffee Varieties in Kenya <br><span class="code-cell">KALROCONF_SUB14_014</span> &nbsp; Cecilia Wagikondi Kathurima</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Plant Health, Emerging Crop Pests &amp; Diseases (2:00–4:30) → Animal Feed Resources (4:30–5:24)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Abou Togola, CIMMYT</strong> / <strong>Dr. Benard Korir</strong> &nbsp;·&nbsp; Rapporteurs: Berrick Otieno &amp; Esther Kimani / Peterson Mwangi &amp; Gladys Chelangat</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15 PM</td><td>Beyond the Gene: Understanding Climate Change-Driven Breakdown of Phyto-pathogenic Resistance in Grain Legumes <br><span class="code-cell">KALROCONF_SUB3_034</span> &nbsp; Harun Odhiambo</td></tr>
                <tr><td class="time-cell">2:15–2:30 PM</td><td>Potential of Rhizobacteria from Different Manure Sources in the Management Of Bacterial Wilt On Potatoes <br><span class="code-cell">KALROCONF_SUB3_036</span> &nbsp; Anita Nduku Mutua</td></tr>
                <tr><td class="time-cell">2:30–2:45 PM</td><td>Optimizing Potato Cultivation in a Changing Climate: An AI-Driven Integration of Large Language Models and Disease Epidemiology Model <br><span class="code-cell">KALROCONF_SUB3_037</span> &nbsp; Shadrack Odikara Oriama</td></tr>
                <tr><td class="time-cell">2:45–3:00 PM</td><td>Buried Threats Unearthed: Efficacy of Aluminum Phosphide Fumigation in Mole Population Management At KALRO Kabete Research Grounds <br><span class="code-cell">KALROCONF_SUB3_038</span> &nbsp; Mark Limo</td></tr>
                <tr><td class="time-cell">3:00–3:15 PM</td><td>Retooling Crop Health Capacity of Advisory Service Providers <br><span class="code-cell">KALROCONF_SUB3_042</span> &nbsp; Miriam Otipa</td></tr>
                <tr><td class="time-cell">3:15–3:30 PM</td><td>Evaluation of Genotypic Variation in Cowpea Scab Incidence Across Two Contrasting Kenyan Agro-Ecological Zones <br><span class="code-cell">KALROCONF_SUB3_043</span> &nbsp; Kelele Faida John</td></tr>
                <tr><td class="time-cell">3:30–3:45 PM</td><td>Integrated Fall armyworm management in Narok and Nakuru Counties in Kenya using Fall armyworm tolerant hybrids and biopesticides <br><span class="code-cell">KALROCONF_SUB3_046</span> &nbsp; Abel Too</td></tr>
                <tr><td class="time-cell">3:45–4:00 PM</td><td>Antifungal activity of actinomycetes isolates against selected fungal pathogens infecting Tomato under in-vitro conditions <br><span class="code-cell">KALROCONF_SUB3_048</span> &nbsp; Carol Gichohi</td></tr>
                <tr><td class="time-cell">4:00–4:15 PM</td><td>Machine Learning-Based Prediction of Aflatoxin Risk Using Environmental, Agronomic, and Post Harvest Factors in Kenya: Bomet and Nakuru Case Study <br><span class="code-cell">KALROCONF_SUB3_049</span> &nbsp; Kelvin Mutua Murungi</td></tr>
                <tr><td class="time-cell">4:15–4:30 PM</td><td>Bean Aphid Natural Enemies, Field Margin Vegetation and Biopesticide Role in Integrated Pest Control <br><span class="code-cell">KALROCONF_SUB3_050</span> &nbsp; Janet Obanyi</td></tr>
                <tr style="background:#f0fdf4;"><td class="time-cell" style="color:#14532d;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#14532d;font-weight:600;font-size:.8rem;">Animal Feed Resources, Nutrition &amp; Husbandry Practices (Chair: Dr. Benard Korir)</td></tr>
                <tr><td class="time-cell">4:30–4:45 PM</td><td>Effect of soil type and altitude on yield and quality of selected forage grasses in Tanzania and Kenya <br><span class="code-cell">KALROCONF_SUB9_012</span> &nbsp; Solomon Mwendia</td></tr>
                <tr><td class="time-cell">4:45–5:00 PM</td><td>Feed Efficiency and Body Condition Responses of Dairy Crosses Fed Total Mixed Rations Compared to Conventional Grazing Systems <br><span class="code-cell">KALROCONF_SUB9_014</span> &nbsp; Sarah Mkakina Mghanga</td></tr>
                <tr><td class="time-cell">5:00–5:08 PM</td><td>Optimization of Broilers Growth through Three Phase Feeding for Enhanced Food and Nutrition Security <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_009</span> &nbsp; Dr. Victor Ngaira</td></tr>
                <tr><td class="time-cell">5:08–5:16 PM</td><td>Impact of different feed resources on milk production by small-scale dairy farmers in Bungoma and Nyamira Counties <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_011</span> &nbsp; Shadrack Musembi</td></tr>
                <tr><td class="time-cell">5:16–5:24 PM</td><td>Evaluating the influence of feeding regimes on milk composition of dairy cattle. A case study of Dairy Research Institute, Naivasha <span class="poster-tag">POSTER</span><br><span class="code-cell">KALROCONF_SUB9_020</span> &nbsp; Daniel Chengo</td></tr>
            </tbody></table>
        </div>

    </div><!-- /day4 afternoon sessions -->

</div><!-- /day4 -->

{{-- ══════════════════════════════════════════════
     DAY 5 — Friday 19 June 2026
══════════════════════════════════════════════ --}}
<div class="prog-day" id="day5">

    <div class="plenary-block">
        <div class="plenary-head">
            <div>
                <h4>Session One: Plenary Keynote Presentations</h4>
                <div style="opacity:.75;font-size:.82rem;margin-top:4px;">Chairperson: Mumina Shibia &nbsp;·&nbsp; Rapporteur: Judith Mboya</div>
            </div>
            <span class="venue-badge">📍 Main Conference Hall</span>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Event</th><th>Facilitator</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">7:30 AM – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 AM – 9:00 AM</td><td><strong>Keynote Address: <em>Which way for improved and sustainable food systems in the face of Artificial Intelligence? A synergy between Agribusiness, Innovating Financing and policy for Agricultural growth.</em></strong><br>Speaker: Professor Simon Wagura Ndiritu – Strathmore University</td><td></td></tr>
                <tr><td class="time-cell">9:00 AM – 9:30 AM</td><td><strong>Keynote Address: <em>Science communication: From Evidence to Adoption: Using Science Communication to Close the Gap in Agricultural Innovation Uptake in Kenya</em></strong><br>Speaker: Dr. Margaret Karembu, Director ISAAA</td><td></td></tr>
                <tr><td class="time-cell">9:30 AM – 10:30 AM</td><td>
                    <ul style="margin:0 0 0 16px;font-size:.84rem;">
                        <li>Chair Project Evaluation Committee on project evaluation and awards</li>
                        <li>Oral presentation by best overall project</li>
                        <li>Oral presentation by second best project</li>
                        <li>Oral presentation by third best project</li>
                        <li>Students Presentation and Awards</li>
                    </ul>
                </td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:30 AM – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
            </tbody>
        </table>
    </div>

    <div class="closing-card">
        <h4>🏆 Awards &amp; Closing Ceremony</h4>
        <p style="margin-bottom:10px;">MC: Dr. Evans Ilatsia &nbsp;·&nbsp; Rapporteur: Nicholas Kibunyi</p>
        <div style="background:rgba(255,255,255,.12);border-radius:10px;padding:16px 20px;display:inline-block;text-align:left;">
            <table style="color:white;border-collapse:collapse;font-size:.88rem;">
                <tr><td style="padding:8px 24px 8px 0;vertical-align:top;white-space:nowrap;opacity:.75;">11:00 AM – 1:00 PM</td>
                    <td>
                        <strong>Communique Presentation</strong> by Director General KALRO – Dr. Patrick Ketiem<br><br>
                        <strong>Posthumous Citation</strong><br>
                        <ul style="margin:4px 0 8px 16px;">
                            <li>Dr. Lusike Wasilwa</li>
                            <li>Dr. Wellington Mulinge</li>
                        </ul>
                        <strong>Awards</strong>
                        <table style="color:white;border-collapse:collapse;font-size:.83rem;margin-top:8px;">
                            <thead><tr style="border-bottom:1px solid rgba(255,255,255,.3);">
                                <th style="padding:6px 20px 6px 0;text-align:left;">Award Category</th>
                                <th style="padding:6px 0;text-align:left;">Awards</th>
                            </tr></thead>
                            <tbody>
                                <tr><td style="padding:5px 20px 5px 0;">Best Scientific Paper (Per Sub-theme)</td><td>1 winner each per sub-theme</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Scientific Paper (Overall)</td><td>1st, 1st Runner-up, 2nd Runner-up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Upcoming Scientist</td><td>1st, 1st Runner-up, 2nd Runner-up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Industry-Oriented Presentation</td><td>1 winner + 1st runner up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Impact-Oriented Presentation</td><td>1 winner + 1st runner up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Innovation/Technology Demonstration</td><td>1 winner + 1st runner up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Policy-Relevant Research Output</td><td>1 winner + 1st runner up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Digital/Data-Driven Solution</td><td>1 winner + 1st runner up</td></tr>
                                <tr><td style="padding:5px 20px 5px 0;">Best Poster Presentation</td><td>1st, 1st Runner-up, 2nd Runner-up</td></tr>
                            </tbody>
                        </table>
                        <div style="margin-top:10px;">Closing Remarks Chief Guest, Principal Secretary, State Department for Agriculture – Dr. Kipronoh Ronoh, CBS</div>
                    </td>
                </tr>
                <tr><td style="padding:8px 24px 8px 0;white-space:nowrap;opacity:.75;">1:00 PM – 2:00 PM</td><td><strong>🍽 Lunch Break &amp; End of Conference</strong></td></tr>
            </table>
        </div>
    </div>

</div><!-- /day5 -->

</div><!-- /container -->
</div><!-- /prog-body -->

<script>
function showDay(dayId, btn) {
    document.querySelectorAll('.prog-day').forEach(function(d){ d.classList.remove('active'); });
    document.querySelectorAll('.prog-tab').forEach(function(b){ b.classList.remove('active'); });
    document.getElementById(dayId).classList.add('active');
    btn.classList.add('active');
    window.scrollTo({ top: document.querySelector('.prog-tabs-bar').offsetTop - 10, behavior: 'smooth' });
}
</script>

@endsection
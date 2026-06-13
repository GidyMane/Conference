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

    {{-- Plenary --}}
    <div class="plenary-block">
        <div class="plenary-head">
            <div>
                <h4>Session One: Plenary Keynote &amp; Opening Ceremony</h4>
                <div style="opacity:.75;font-size:.82rem;margin-top:4px;">Chairperson: Dr. Alice Murage &nbsp;·&nbsp; Rapporteur: Ms. Tabby Karanja-Lumumba</div>
            </div>
            <span class="venue-badge">📍 Main Conference Hall</span>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Activity</th><th>Facilitator</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">7:30 – 8:30 AM</td><td>Registration</td><td>All</td></tr>
                <tr><td class="time-cell">8:30 – 9:15 AM</td><td>Introduction of participants and setting the scene / Entertainment</td><td></td></tr>
                <tr><td class="time-cell">9:15 – 10:00 AM</td><td>Keynote Speech</td><td><strong>DDGL</strong></td></tr>
                <tr class="break-row"><td class="time-cell">10:00 – 10:30 AM</td><td colspan="2">☕ Health Break</td></tr>
                <tr><td class="time-cell">10:30 AM – 12:00 PM</td><td>Opening Ceremony</td><td><strong>DG</strong></td></tr>
                <tr><td class="time-cell">12:00 – 1:00 PM</td><td>Photo Session &nbsp;·&nbsp; Tour of the Exhibition &nbsp;·&nbsp; Tree Planting &nbsp;·&nbsp; Signing of Visitors Book &nbsp;·&nbsp; Media Briefs</td><td></td></tr>
                <tr class="break-row"><td class="time-cell">1:00 – 2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody>
        </table>
    </div>

    {{-- Afternoon parallel sessions --}}
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
                    <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy &amp; Socio-Economics</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Charles Bett</strong> &nbsp;·&nbsp; Rapporteurs: Tabby Karanja &amp; Judith Mutheu Mboya</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15</td><td>Factors influencing the Adoption of Green Grams in Machakos County <br><span class="code-cell">SUB17_001</span> &nbsp; Rosemary Akhungu Emongor</td></tr>
                    <tr><td class="time-cell">2:15–2:30</td><td>Measuring Women's Agricultural Empowerment Using A-WEAI <br><span class="code-cell">SUB17_002</span> &nbsp; Berit Auma</td></tr>
                    <tr><td class="time-cell">2:30–2:45</td><td>Livestock Production and Methane Emissions in Kenya: ARDL Evidence <br><span class="code-cell">SUB17_004</span> &nbsp; Manyeki John Kibara</td></tr>
                    <tr><td class="time-cell">2:45–3:00</td><td>Analysis of Risk and Returns of Tea Cultivar Portfolios <br><span class="code-cell">SUB17_006</span> &nbsp; Paul Ayiemba Odongo</td></tr>
                    <tr><td class="time-cell">3:00–3:15</td><td>Performance Evaluation of Climate Smart Agricultural Programs in Kenya <br><span class="code-cell">SUB17_007</span> &nbsp; Peter K. Nduati</td></tr>
                    <tr><td class="time-cell">3:15–3:30</td><td>Evaluation of TMR finishing of Improved Boran steers in a Kenyan feedlot <br><span class="code-cell">SUB17_008</span> &nbsp; Veronica Chemutai Metto</td></tr>
                    <tr><td class="time-cell">3:30–3:45</td><td>Machine Learning Insights into Crop Yield Determinants in Kenyan Agriculture <br><span class="code-cell">SUB17_009</span> &nbsp; Joan Achieng Abwao</td></tr>
                    <tr><td class="time-cell">3:45–4:00</td><td>Agro-Dealer Profiles and Operational Practices in Kirinyaga, Kajiado and Nairobi <br><span class="code-cell">SUB17_012</span> &nbsp; John Ndungu</td></tr>
                    <tr><td class="time-cell">4:00–4:15</td><td>Contribution of Mango Production to Livelihood Outcomes in South Kerio Basin <br><span class="code-cell">SUB17_013</span> &nbsp; Gitonga KJ</td></tr>
                    <tr><td class="time-cell">4:15–4:30</td><td>Economic potential of Alpine Goat Milk Production in Kenya: a review <br><span class="code-cell">SUB17_014</span> &nbsp; Mwangi Wilson Maina</td></tr>
                    <tr><td class="time-cell">4:30–4:45</td><td>Participatory Varietal Selection of Drought-Resilient Sorghum in Kenya's ASALs <br><span class="code-cell">SUB17_015</span> &nbsp; Winnie Rapada Agola</td></tr>
                    <tr><td class="time-cell">4:45–5:00</td><td>Profitability of Differentiated Fertilizer Options in Maize Production in Kenya <br><span class="code-cell">SUB17_026</span> &nbsp; Josephat Chengole Mulindo</td></tr>
                </tbody>
            </table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div>
                    <span class="room-tag">Main Board Room</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Crop Varieties, Productivity &amp; Production Management</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Samson Kamunya</strong> &nbsp;·&nbsp; Rapporteurs: Harun Odhiambo &amp; Sheila Siele</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15</td><td>Seasonal Variation in Biochemical Composition of Second-Generation Tea Cultivars <br><span class="code-cell">SUB1_002</span> &nbsp; Simon Mwangi Kingori</td></tr>
                    <tr><td class="time-cell">2:15–2:30</td><td>Integrating Disease Resistance and Agronomic Performance for Parental Selection in Bread Wheat <br><span class="code-cell">SUB1_006</span> &nbsp; Godwin Macharia</td></tr>
                    <tr><td class="time-cell">2:30–2:45</td><td>Evaluation of Locally Bred Improved Sugarcane Varieties for Enhanced Productivity <br><span class="code-cell">SUB1_016</span> &nbsp; Edwin Shikanda</td></tr>
                    <tr><td class="time-cell">2:45–3:00</td><td>Genetic Variability, Heritability and Genetic Advance in Eight Safflower Genotypes <br><span class="code-cell">SUB1_038</span> &nbsp; Peter Njuguna</td></tr>
                    <tr><td class="time-cell">3:00–3:15</td><td>Effects of variety and potassium fertilization on yield of Watermelon under irrigation <br><span class="code-cell">SUB1_036</span> &nbsp; Jimmy Kiprop Yegon</td></tr>
                    <tr><td class="time-cell">3:15–3:30</td><td>Assessment of post-harvest attributes of leafy amaranth landraces <br><span class="code-cell">SUB1_018</span> &nbsp; Christine Wangeci Ndiritu</td></tr>
                    <tr><td class="time-cell">3:30–3:45</td><td>Comparative Performance of Early Brown Finger Millet Genotypes in Lanet <br><span class="code-cell">SUB1_021</span> &nbsp; Rhoda Alima Omariba</td></tr>
                    <tr><td class="time-cell">3:45–4:00</td><td>Validation of yield-related and blast resistance genes for improvement of Kenyan Basmati rice <br><span class="code-cell">SUB1_039</span> &nbsp; Emily Gichuhi</td></tr>
                    <tr><td class="time-cell">4:00–4:08</td><td>Comparative Evaluation of Pruning Systems on Tomato Yield <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_023</span> &nbsp; Isaiah Kiprop Keter</td></tr>
                    <tr><td class="time-cell">4:08–4:16</td><td>Genetic characterization of Coffea canephora germplasm conservation in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_031</span> &nbsp; James Gimase</td></tr>
                    <tr><td class="time-cell">4:16–4:24</td><td>Evaluation of Sorghum Newly Released Varieties in Makueni County using Tricot <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_019</span> &nbsp; Benard Masila Mbuvi</td></tr>
                    <tr><td class="time-cell">4:24–4:32</td><td>Breeding Challenges for Next-Generation Pyrethrum Seedling Varieties <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_015</span> &nbsp; Wilfred Abincha Magangi</td></tr>
                    <tr><td class="time-cell">4:32–4:40</td><td>Comparative Efficiency of Split-Plot vs. RCBD for Factorial Sorghum Yield Experiments <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_037</span> &nbsp; Elias Gitonga Thuranira</td></tr>
                    <tr><td class="time-cell">4:40–4:48</td><td>Evaluation of advanced wheat lines for yield and rust resistance <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_041</span> &nbsp; Martin Lagat</td></tr>
                    <tr><td class="time-cell">4:48–4:56</td><td>Effect of defloration levels on potato yield, tuber quality and economic returns <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_042</span> &nbsp; Godfrey Juma</td></tr>
                    <tr><td class="time-cell">4:56–5:04</td><td>Evaluation of Seedball Technology in Propagation of Cashew <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB1_048</span> &nbsp; Francis Muniu</td></tr>
                </tbody>
            </table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div>
                    <span class="room-tag">Big Seminar Room</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Animal Health, Sanitary Systems &amp; Emerging Livestock Pests</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Monicah Maichomo</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Esther Kimani</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15</td><td>Rebreedx <br><span class="code-cell">SUB11_002</span> &nbsp; Luke Kipyego</td></tr>
                    <tr><td class="time-cell">2:15–2:30</td><td>Integrated Investigation of Haemoparasitic Infections with Emphasis on African Animal Trypanosomiasis <br><span class="code-cell">SUB11_003</span> &nbsp; Chege Patriciah Waithira</td></tr>
                    <tr><td class="time-cell">2:30–2:45</td><td>Evaluation of immunogenicity and safety of an inactivated mucosal Capripoxvirus vaccine <br><span class="code-cell">SUB11_004</span> &nbsp; Kenneth Koome</td></tr>
                    <tr><td class="time-cell">2:45–3:00</td><td>Mechanical Amplifiers of Hemopathogen Transmission: Diversity of Stomoxys spp. in Western Kenya <br><span class="code-cell">SUB11_005</span> &nbsp; Stephen Burudi Shirengo</td></tr>
                    <tr><td class="time-cell">3:00–3:15</td><td>Integrated Serological and Entomological Assessment of Nairobi Sheep Disease Virus <br><span class="code-cell">SUB11_009</span> &nbsp; Paul Muriuki</td></tr>
                    <tr><td class="time-cell">3:15–3:30</td><td>Uncovering overlooked bacteria in intensive pig farming systems using MALDI-TOF MS <br><span class="code-cell">SUB11_010</span> &nbsp; Nathan Langat</td></tr>
                    <tr><td class="time-cell">3:30–3:45</td><td>Shotgun Metagenomics reveals Deep insight into Diversity in Gut of Pastured Goats <br><span class="code-cell">SUB11_011</span> &nbsp; Eunice Ndegwa</td></tr>
                    <tr><td class="time-cell">3:45–4:00</td><td>Integrating Medicinal Maggot Therapy into Climate-Resilient Health Systems in Africa <br><span class="code-cell">SUB11_012</span> &nbsp; Paul Muriuki</td></tr>
                    <tr><td class="time-cell">4:00–4:15</td><td>Antimicrobial Activity of Polyphenolic Extracts from Kenya Specialty Teas <br><span class="code-cell">SUB11_014</span> &nbsp; Emily Kipsura</td></tr>
                    <tr><td class="time-cell">4:15–4:30</td><td>Tackling Antibiotic Overuse through Community-Led Behavioural Interventions <br><span class="code-cell">SUB11_015</span> &nbsp; Janet Akinyi Otieno</td></tr>
                    <tr><td class="time-cell">4:30–4:45</td><td>Reimagining Chronic Wound Management: One Health Paradigm including Maggot Debridement Therapy <br><span class="code-cell">SUB11_016</span> &nbsp; Patrick Gachie Wanjiku</td></tr>
                    <tr><td class="time-cell">4:45–5:00</td><td>Current Status of East Coast Fever Vaccination in Africa (2023–2026) <br><span class="code-cell">SUB11_018</span> &nbsp; Pius Tarus</td></tr>
                    <tr><td class="time-cell">5:00–5:15</td><td>Novel Tsetse Fly Repellent for Control of Savannah Tsetse Fly in East Africa <br><span class="code-cell">SUB11_025</span> &nbsp; Paul O Mireji</td></tr>
                </tbody>
            </table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div>
                    <span class="room-tag">Room 207</span>
                    <span class="time-tag ms-1">2:00–5:00 PM</span><br>
                    <span class="subtheme-tag mt-1">Technology Transfer, ICT-Enabled Precision Systems</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Everlyne Kirwa</strong> &nbsp;·&nbsp; Rapporteurs: Nicholas Kibunyi &amp; Tuila Esese</span>
                </div>
            </div>
            <table class="prog-table">
                <tbody>
                    <tr><td class="time-cell">2:00–2:15</td><td>Training lead farmers as agents for dissemination of TIMPs: Evidence from Kajiado <br><span class="code-cell">SUB16_002</span> &nbsp; Paul Katiku</td></tr>
                    <tr><td class="time-cell">2:15–2:30</td><td>Digital Market Information Systems and Availability of Nutritious Food <br><span class="code-cell">SUB16_004</span> &nbsp; Hannington Odido Ochieng</td></tr>
                    <tr><td class="time-cell">2:30–2:45</td><td>Catalysing Sustainable Livelihoods: A Multi-Stakeholder Model for Agricultural Technology Transfer <br><span class="code-cell">SUB16_005</span> &nbsp; Peter Nduati</td></tr>
                    <tr><td class="time-cell">2:45–3:00</td><td>Use of precision digital technologies in veterinary health: The KILIMMA digital platform <br><span class="code-cell">SUB16_007</span> &nbsp; Rosemary Ngotho-Esilaba</td></tr>
                    <tr><td class="time-cell">3:00–3:15</td><td>GRIN-Global: Advancing ICT-Enabled Plant Genetic Resources Conservation at KALRO <br><span class="code-cell">SUB16_010</span> &nbsp; Joseph Ndungu Kimani</td></tr>
                    <tr><td class="time-cell">3:15–3:30</td><td>Exploring a market-led extension model for enhancing adoption of good agricultural practices <br><span class="code-cell">SUB16_011</span> &nbsp; Christine Wangeci Ndiritu</td></tr>
                    <tr><td class="time-cell">3:30–3:45</td><td>From Tech to Tacit: Co-Creating Digital Knowledge for Climate-Resilient Agriculture <br><span class="code-cell">SUB16_021</span> &nbsp; Emma Nyaola</td></tr>
                    <tr><td class="time-cell">3:45–4:00</td><td>Music, Drama, And Poetry As Innovative Platforms for Agricultural Knowledge Dissemination <br><span class="code-cell">SUB16_023</span> &nbsp; Peterson Mwangi</td></tr>
                    <tr><td class="time-cell">4:00–4:15</td><td>Digitally Enabled Agripreneurship for Agricultural Service Delivery <br><span class="code-cell">SUB16_026</span> &nbsp; Irene Wambui Kimani</td></tr>
                    <tr><td class="time-cell">4:15–4:30</td><td>Application of Triadic Comparisons of Technologies (TRICOT) in Finger Millet dissemination <br><span class="code-cell">SUB16_030</span> &nbsp; David Otieno Odhiambo</td></tr>
                    <tr><td class="time-cell">4:30–4:45</td><td>Enhancing Youth Engagement in Agriculture: A Training and Innovation Model <br><span class="code-cell">SUB16_031</span> &nbsp; Kenneth Monjero Igadwa</td></tr>
                    <tr><td class="time-cell">4:45–4:53</td><td>AI-Enhanced Farmer Feedback Systems for Technology Adoption <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB16_009</span> &nbsp; Chepkania Miriam Nangila</td></tr>
                    <tr><td class="time-cell">4:53–5:01</td><td>Assessment of Farmers' Desired Attributes in Adoption of Soil and Water Technologies <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB16_046</span> &nbsp; Seth Chasimba Amboga</td></tr>
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
                <tr><td class="time-cell">7:30 – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 – 9:30 AM</td><td><strong>Chief Guest Address &amp; Panel Discussion</strong></td><td>Moderator: Dr. David Golicha</td></tr>
                <tr><td class="time-cell">9:30 – 10:00 AM</td><td>Keynote Presentation</td><td></td></tr>
                <tr><td class="time-cell">10:00 – 10:30 AM</td><td>Launching of Tsetse repellant and attractants by Chief Guest</td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:30 – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
                <tr><td class="time-cell">11:00 AM</td><td><strong>Session Breakouts</strong></td><td></td></tr>
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
                    <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy &amp; Socio-Economics</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Martins Odendo</strong> &nbsp;·&nbsp; Rapporteurs: Nancy M Nganga &amp; Judith Mutheu Mboya</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Market Pathways for Bio-fortified Bean Seeds: Evidence from Agro-Dealers Survey <br><span class="code-cell">SUB17_027</span> &nbsp; Eliud Kipkosgei Rotich</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Seasonal Demand Dynamics and Revenue Structure of Public Agricultural Research Products <br><span class="code-cell">SUB17_028</span> &nbsp; Ruth Chepngeno</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Gender, Scale, and Seasonality in Smallholder Tree Crop Input Markets in Coastal Kenya <br><span class="code-cell">SUB17_092</span> &nbsp; Christine Kasichana</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Unlocking the Potential of Indigofera spp. for Natural Dye Production in Kenya <br><span class="code-cell">SUB17_091</span> &nbsp; Christine Kasichana</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Towards Disability-Inclusive Agricultural Innovation Systems in Kenya <br><span class="code-cell">SUB17_090</span> &nbsp; Peterson Mwangi</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Gender and Social Inclusion in Adoption of Climate-Smart Irish Potato Production in Nyeri <br><span class="code-cell">SUB17_030</span> &nbsp; Stella J. Matere</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Evaluating the Financial and Economic Feasibility of Maize Productivity Project in Kenya <br><span class="code-cell">SUB17_031</span> &nbsp; Stella Makokha</td></tr>
                <tr><td class="time-cell">12:45–1:00</td><td>Unlocking and Optimizing Available Land Resources for Market Oriented Production <br><span class="code-cell">SUB17_034</span> &nbsp; Mercy Kaimenyi Bett</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div>
                    <span class="room-tag">Main Board Room</span><br>
                    <span class="subtheme-tag mt-1">Plant Nutrition, Soil Health &amp; Conservation Agriculture</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Golicha Dub</strong> &nbsp;·&nbsp; Rapporteurs: Priscila Kanza Mwangangi &amp; Robert Tabu</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Linking Specific Nutrient Elements and Lime to Irish Potatoes in Acidic Soils of Uasin Gishu <br><span class="code-cell">SUB4_001</span> &nbsp; Mary Koech</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Effect of pH and Organic Amendments on Phosphorus Sorption in Acidic Soils of Kiambu <br><span class="code-cell">SUB4_004</span> &nbsp; Priscila Mwangangi</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Maize Yield Variability in Kabete Long-Term Soil Fertility Experiment <br><span class="code-cell">SUB4_005</span> &nbsp; Joyce Addah Omwakwe</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Identifying Soil Fertility Constraints to Maize Production in Kenya Using Nutrient Omission Trials <br><span class="code-cell">SUB4_007</span> &nbsp; Joyce Addah Omwakwe</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Assessment of Blended and Conventional Formulations for Enhanced Maize Production in Western Kenya <br><span class="code-cell">SUB4_008</span> &nbsp; Kelele Faida John</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Application of blended fertilizers for improved maize production in semi-arid eastern Kenya <br><span class="code-cell">SUB4_011</span> &nbsp; Emerita Njiru</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Maize growth and yield response to separate fertilizer application in Uasin Gishu and Trans Nzoia <br><span class="code-cell">SUB4_013</span> &nbsp; Mary Koech</td></tr>
                <tr><td class="time-cell">12:45–1:00</td><td>Influence of CBX Bio-stimulant and Soil Conditioner on Coffee Growth and Yield <br><span class="code-cell">SUB4_014</span> &nbsp; Danstan Odeny</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div>
                    <span class="room-tag">Big Seminar Room</span><br>
                    <span class="subtheme-tag mt-1">Food Safety, Value Addition &amp; Cottage Industries</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Samson Kamunya</strong> &nbsp;·&nbsp; Rapporteurs: Tabby Karanja &amp; Judith Mutheu Mboya</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Pesticide Residues in Catha Edulis (Muguka): A Multidimensional Threat to Health <br><span class="code-cell">SUB14_015</span> &nbsp; Richard Mwaniki Njue</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Occurrence of Soil-Borne Mycotoxigenic Fungi In Maize Farms of Makueni County <br><span class="code-cell">SUB14_016</span> &nbsp; Nicholas Odhiambo Owiro</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Food Safety Assessment of Fungal and Aflatoxin Contamination in Black CTC Teas <br><span class="code-cell">SUB14_019</span> &nbsp; Mercy Cherotich</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Integrating soil management practices to reduce aflatoxin contamination in Makueni County <br><span class="code-cell">SUB14_021</span> &nbsp; Fatuma Sharamo Fora</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Optimisation of harvesting and post-harvest handling of cashew apple in coastal Kenya <br><span class="code-cell">SUB14_022</span> &nbsp; Francis Muniu</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Consumption of Sweetpotato Leaves Improves Iron Status Among Women of Reproductive Age <br><span class="code-cell">SUB14_023</span> &nbsp; Rosemary Jepkosgei Cheboswony</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Total Monomeric Anthocyanin (TMA) in Purple Tea Infusions: Influence of Water Source <br><span class="code-cell">SUB14_005</span> &nbsp; Simon Oduor Ochanda</td></tr>
                <tr><td class="time-cell">12:45–1:00</td><td>Determination of Tomato Post-Harvest Losses and Packaging Effects on Fruit Quality <br><span class="code-cell">SUB14_007</span> &nbsp; Robert Tabu</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div>
                    <span class="room-tag">Room 207</span><br>
                    <span class="subtheme-tag mt-1">Plant Health, Emerging Crop Pests &amp; Diseases</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Harun Muriithi, IITA</strong> &nbsp;·&nbsp; Rapporteurs: Hillary Rotich &amp; Miriam Mbiyu</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Bridging the last mile: farmer-trainer mediated remote diagnosis model for smallholder crop health <br><span class="code-cell">SUB3_010</span> &nbsp; Rong (Coco) Feng</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Knowledge Gaps in Mango Pathology in Kenya: A Review <br><span class="code-cell">SUB3_011</span> &nbsp; Barbra Nyakowa Khainga</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Surveillance of Wheat Diseases and Characterization of Stem Rust Isolates in Kenya <br><span class="code-cell">SUB3_012</span> &nbsp; Zennah Kosgey</td></tr>
                <tr><td class="time-cell">11:45–11:53</td><td>Documentation Of Cashew Pests and Diseases and their Economic Importance <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_017</span> &nbsp; Naomi Mburu</td></tr>
                <tr><td class="time-cell">11:53–12:01</td><td>Emerging Insect Pests Threatening Indigenous Vegetables in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_018</span> &nbsp; Denis Mwiti Prichard</td></tr>
                <tr><td class="time-cell">12:01–12:09</td><td>Incidences of Phytophthora cinnamomi, causal agent of Avocado Root Rot <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_013</span> &nbsp; Mercyline Orayo</td></tr>
                <tr><td class="time-cell">12:09–12:17</td><td>Evaluation of YUKON 720 SC for Control of Late Blight and Early Blight of Potato <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_014</span> &nbsp; Charity Nzilani</td></tr>
                <tr><td class="time-cell">12:17–12:25</td><td>Use of Botanical Plant Extracts in the Control of Potato Tuber Moth <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_016</span> &nbsp; Robert Kiprotich Lagat</td></tr>
                <tr><td class="time-cell">12:25–12:33</td><td>Characterisation of audible sound behaviour of rodents with and without food <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_019</span> &nbsp; Paddy Likhayo</td></tr>
                <tr><td class="time-cell">12:33–12:41</td><td>Residual efficacy of Actellic Gold dust against stored grain pests <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_020</span> &nbsp; Paddy Likhayo</td></tr>
                <tr><td class="time-cell">12:41–12:49</td><td>Virulence of Fusarium oxysporum f.sp. cubense strains in infected Bananas in Tharaka Nithi <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB3_035</span> &nbsp; Samuel Musime Malaka</td></tr>
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
                    <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy &amp; Socio-Economics</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Stella Makokha</strong> &nbsp;·&nbsp; Rapporteurs: Nancy M Nganga &amp; Peterson Mwangi</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Rethinking Agricultural Research: From Traditional to Context-Sensitive Approaches <br><span class="code-cell">SUB17_035</span> &nbsp; Hannington Odido Ochieng</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Why are Farmers and Agricultural SMEs Credit Constrained in Africa? A Systematic Review <br><span class="code-cell">SUB17_037</span> &nbsp; Joel Agutu Omollo</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Impact of Integrated Poultry and Nutrition Education Interventions on Dietary Diversity <br><span class="code-cell">SUB17_038</span> &nbsp; Mercy Chelangat Soi</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Does Attitude towards Domestic Gender Based Violence on Smallholder farms affect Crop Productivity? <br><span class="code-cell">SUB17_039</span> &nbsp; Martins Odendo</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Effect of Climate Change on Gender Segregated Households in Kenya <br><span class="code-cell">SUB17_040</span> &nbsp; Bernard Rono</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Evaluation of Cassava Farming as a Climate Smart Technology in Murang'a County <br><span class="code-cell">SUB17_041</span> &nbsp; Antony Ngaruiya</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>From Subsistence to Sustainable Livelihoods: Climate Resilient Smallholder Rice Systems in Kilifi <br><span class="code-cell">SUB17_042</span> &nbsp; Kadenge Lewa</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Gender Mainstreaming in Poultry Production and Marketing in Nyandarua County <br><span class="code-cell">SUB17_044</span> &nbsp; Jessica Ndubi</td></tr>
                <tr><td class="time-cell">4:00–4:15</td><td>Gender Dynamics in The Adoption and Replacement of Improved Wheat Varieties in Kenya <br><span class="code-cell">SUB17_045</span> &nbsp; Anne Gichangi</td></tr>
                <tr><td class="time-cell">4:15–4:30</td><td>Economic evaluation of Friesian and their crosses fed on locally formulated Total Mixed Ration <br><span class="code-cell">SUB17_016</span> &nbsp; Andrew Kiplagat Kosgei</td></tr>
                <tr><td class="time-cell">4:30–4:45</td><td>Economic Evaluation of Locally Formulated Total Mixed Ration on Red Maasai Sheep <br><span class="code-cell">SUB17_017</span> &nbsp; Scolastica Nanjala Nambafu</td></tr>
                <tr><td class="time-cell">4:45–5:00</td><td>Local Value Chain Analysis and Mapping for Improved Productivity in Baringo County <br><span class="code-cell">SUB17_018</span> &nbsp; Paul Kiprono</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div>
                    <span class="room-tag">Main Board Room</span><br>
                    <span class="subtheme-tag mt-1">Crop Varieties (2:00–3:45) → Agrodiversity &amp; Genetic Resources (4:00–5:15)</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Samson Kamunya</strong> / <strong>Dr. Harrison Lutta</strong> &nbsp;·&nbsp; Rapporteurs: Sheila Siele &amp; Robert Tabu</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Contribution of Underutilized Crops to Diversity and Resilience in Modern Cropping Systems <br><span class="code-cell">SUB1_044</span> &nbsp; Judy Chepkoech Mutai</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Delayed Research Undermining the Production and Productivity of Pyrethrum Revival in Kenya <br><span class="code-cell">SUB1_046</span> &nbsp; Irene</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Evaluation of Cashew Clones for Rootstock Suitability <br><span class="code-cell">SUB1_047</span> &nbsp; Francis Muniu</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Evaluation of Promising Rice Lines for Ratooning Ability to Improve Productivity <br><span class="code-cell">SUB1_049</span> &nbsp; John Kalume</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Tea quality assessment in multiple environments based on AMMI and GGE biplot analyses <br><span class="code-cell">SUB1_051</span> &nbsp; Robert Kiplangat Korir</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Effect of Harvesting Frequency On Cowpea Leaf Quality and Nutrition in Trans Nzoia <br><span class="code-cell">SUB1_056</span> &nbsp; Anastacia Masinde</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>Evaluation of Elite Finger Millet Genotypes Across Locations in Western Kenya <br><span class="code-cell">SUB1_061</span> &nbsp; Chrispus O.A. Oduori</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Retrospective analysis for parental line selection for rice breeding in Kenya <br><span class="code-cell">SUB1_064</span> &nbsp; Roselyne Juma</td></tr>
                <tr style="background:#fdf4ff;"><td class="time-cell" style="color:#7c3aed;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#7c3aed;font-weight:600;font-size:.8rem;">Agrodiversity &amp; Genetic Resources (Chair: Dr. Harrison Lutta)</td></tr>
                <tr><td class="time-cell">4:00–4:15</td><td>Role of Digital Sequence Information in Climate-Resilient Utilization of Crop Genetic Resources <br><span class="code-cell">SUB8_003</span> &nbsp; Dancun Muchira</td></tr>
                <tr><td class="time-cell">4:15–4:30</td><td>Characterization of second-generation purple tea cultivars (Camellia sinensis) in Kenya <br><span class="code-cell">SUB8_006</span> &nbsp; Lilian Kerio</td></tr>
                <tr><td class="time-cell">4:30–4:45</td><td>Molecular Characterization of Forage Legume (Neonotonia Wightii) in ASALs <br><span class="code-cell">SUB8_007</span> &nbsp; David Musyimi</td></tr>
                <tr><td class="time-cell">4:45–5:00</td><td>Enhancing farmers' access to sorghum diversity in western Kenya using national germplasm <br><span class="code-cell">SUB8_008</span> &nbsp; Peterson Wambugu</td></tr>
                <tr><td class="time-cell">5:00–5:15</td><td>Genetic Architecture and Inheritance of Major Agronomic Traits in Snap Beans <br><span class="code-cell">SUB8_012</span> &nbsp; Lucas Suva</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div>
                    <span class="room-tag">Big Seminar Room</span><br>
                    <span class="subtheme-tag mt-1">Biotechnological Solutions to Crop, Livestock &amp; NRM Challenges</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Henry Kariithi</strong> &nbsp;·&nbsp; Rapporteurs: Esther Kimani &amp; Harun Odhiambo</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Improving Propagation Efficiency for Sustainable Pineapple Farming in Kenya <br><span class="code-cell">SUB13_001</span> &nbsp; Lilian Mwende Mwaniki</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>In-Vitro shoot Multiplication of three Plantain Banana Varieties in Kenya <br><span class="code-cell">SUB13_003</span> &nbsp; Davis Wekesa Makhanu</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Feasibility of GMO maize adoption among smallholder farmers in Kenya <br><span class="code-cell">SUB13_005</span> &nbsp; Miriam Saur</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Towards Sustainable Postharvest Systems: The Role of Natural Preservatives <br><span class="code-cell">SUB13_007</span> &nbsp; Fatuma Adam Mohammed</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Biotechnological Utilisation of Silk Proteins in Cosmetic Soap Fabrication <br><span class="code-cell">SUB13_008</span> &nbsp; Nicholus Mutuma</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Effects of Different Concentrations of BAP, BAP+NAA And BAP+TDZ on In Vitro Multiplication of Plantain <br><span class="code-cell">SUB13_011</span> &nbsp; Rose Nduku Mayoli</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>Evaluation of Three Biotech Potato for Late Blight Resistance <br><span class="code-cell">SUB13_013</span> &nbsp; Miriam Mbiyu</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Evaluation of promoters for storage root specific expression in cassava <br><span class="code-cell">SUB13_022</span> &nbsp; Irene Wangari Njagi</td></tr>
                <tr><td class="time-cell">4:00–4:15</td><td>From Agricultural Biotechnology to Human Health: Maggot Debridement Therapy in Kenya <br><span class="code-cell">SUB13_019</span> &nbsp; Kelvin Malimo</td></tr>
                <tr><td class="time-cell">4:15–4:30</td><td>Isolation and Characterization of Bacteriophages Targeting MRSA <br><span class="code-cell">SUB13_024</span> &nbsp; Lyluck Christabel Otuoma</td></tr>
                <tr><td class="time-cell">4:30–4:45</td><td>Molecular Characterization of MATE Membrane Transporters in Peach Fruit <br><span class="code-cell">SUB13_028</span> &nbsp; Sylvia Cherono</td></tr>
                <tr><td class="time-cell">4:45–5:00</td><td>Banana Pseudo-stems as a Source of Natural Fibres: A Review <br><span class="code-cell">SUB13_033</span> &nbsp; Kelvin Moseti</td></tr>
                <tr><td class="time-cell">5:00–5:08</td><td>Maggot Debridement Therapy in Africa: Clinical Potential — A Review <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB13_020</span> &nbsp; Regina Karanja</td></tr>
                <tr><td class="time-cell">5:08–5:16</td><td>Role of Microclimate Regulation on Survival of Tissue-Cultured Banana <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB13_012</span> &nbsp; Dancun Muchira</td></tr>
                <tr><td class="time-cell">5:16–5:24</td><td>Comparative Analysis: Tissue Culture vs Conventionally Propagated Shangi Potatoes <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB13_031</span> &nbsp; Diana Imbala</td></tr>
                <tr><td class="time-cell">5:24–5:32</td><td>Effects of Plant Growth Regulators on Callus Formation in Blackberry Species <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB13_035</span> &nbsp; Gichaba Sarah Nyamoita</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div>
                    <span class="room-tag">Room 207</span><br>
                    <span class="subtheme-tag mt-1">Apiculture (2:00–4:08) → Climate Change &amp; Land Degradation (4:08–5:46)</span><br>
                    <span class="chair-info mt-1">Chair: <strong>Dr. Charles Bett</strong> / <strong>Dr. David Kamau</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Gladys Chelangat</span>
                </div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Emerging Honey Bee Health Challenges in a Changing Climate <br><span class="code-cell">SUB12_004</span> &nbsp; Daniel Toroitich</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Outlook on Bee Occupancy of Beekeepers Apiaries in Baringo County <br><span class="code-cell">SUB12_005</span> &nbsp; Caroline Waiyego Kimani</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Effects of hive materials on phytochemical and biological properties of honeybee propolis <br><span class="code-cell">SUB12_006</span> &nbsp; Timothy Kegode Mugodo</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Performance of Chemically Treated Hive Entrance Devices for Integrated Control of Varroa destructor <br><span class="code-cell">SUB12_009</span> &nbsp; Rotich Godfrey</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Outlook on Bee Occupancy of Beekeepers Apiaries in Baringo County <br><span class="code-cell">SUB12_010</span> &nbsp; Caroline Waiyego Kimani</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Understanding Bee Absconding: Environmental, Management, and Technological Drivers <br><span class="code-cell">SUB12_012</span> &nbsp; Daniel Toroitich</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>Apis mellifera Honey Varieties in Kenya: Legislation, Production, Processing, and Labeling <br><span class="code-cell">SUB12_015</span> &nbsp; Dr. Victoria Atieno Kimindu</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Evaluating the Profit Potential of Honey bees: Income over Feed Cost Analysis <br><span class="code-cell">SUB12_016</span> &nbsp; Haron Juma Masai</td></tr>
                <tr><td class="time-cell">4:00–4:08</td><td>Characterisation of Apis mellifera scutellata: Morphological, Genetic, Behavioural Perspectives <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB12_003</span> &nbsp; Daniel Toroitich</td></tr>
                <tr style="background:#f0fdf4;"><td class="time-cell" style="color:#14532d;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#14532d;font-weight:600;font-size:.8rem;">Climate Change, Land Degradation &amp; Reclamation (Chair: Dr. David Kamau)</td></tr>
                <tr><td class="time-cell">4:08–4:23</td><td>Pastoral and Agropastoral Knowledge of Forage Dynamics and Holistic Planned Grazing <br><span class="code-cell">SUB7_015</span> &nbsp; Benson Mulei</td></tr>
                <tr><td class="time-cell">4:23–4:38</td><td>The Underground Advantage: Root biomass and carbon under perennial grasses in semi-arid Kenya <br><span class="code-cell">SUB7_016</span> &nbsp; Bosco K. Kisambo</td></tr>
                <tr><td class="time-cell">4:38–4:53</td><td>Evaluation of Cassava Farming as Climate Smart Technology in Muranga County <br><span class="code-cell">SUB7_018</span> &nbsp; Antony Kamau Ngaruiya</td></tr>
                <tr><td class="time-cell">4:53–5:08</td><td>Adoption Rate and Impacts of Climate Smart Agriculture Technologies in Kitui and Tharaka Nithi <br><span class="code-cell">SUB7_019</span> &nbsp; Joyce Adhiambo Nyangao</td></tr>
                <tr><td class="time-cell">5:08–5:23</td><td>Best Management Practices for Improved Land and Water Sustainability Under Changing Climate <br><span class="code-cell">SUB7_020</span> &nbsp; Reuben Ruttoh</td></tr>
                <tr><td class="time-cell">5:23–5:38</td><td>Rangelands Management Practices and Strategies to Enhance Livestock Production: A Review <br><span class="code-cell">SUB7_024</span> &nbsp; Isaiah Barile</td></tr>
                <tr><td class="time-cell">5:38–5:46</td><td>Adoption and Impact Assessment of In Situ Soil and Water Conservation Technologies <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB7_021</span> &nbsp; Gladys Chelangat</td></tr>
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
                <tr><td class="time-cell">7:30 – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 – 9:30 AM</td><td><strong>Chief Guest Address</strong></td><td></td></tr>
                <tr><td class="time-cell">9:30 – 10:00 AM</td><td>Keynote Address</td><td></td></tr>
                <tr><td class="time-cell">10:00 – 10:30 AM</td><td>Chief Guest visit to Business session &amp; <strong>Launch of KALRO Commercialization Strategy 2026–2031</strong></td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:30 – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
                <tr><td class="time-cell">11:00 AM</td><td><strong>Session Breakouts</strong></td><td></td></tr>
            </tbody>
        </table>
    </div>

    {{-- Side Events --}}
    <div class="side-event-card">
        <div class="side-event-head">
            <h4>⚡ Side Events — Wednesday 17 June 2026</h4>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Session Title</th><th>Host</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">09:30–14:30</td><td>Better Analytics for Reduced Impact of Extreme Weather Events</td><td><strong>KALRO / FAO</strong></td></tr>
                <tr><td class="time-cell">10:00–10:30*</td><td>Digital Agriculture for Climate Smart Farming</td><td><strong>Azuresoft Solutions</strong></td></tr>
                <tr><td class="time-cell">11:00–13:00</td><td>AI in Agriculture: Opportunities, Implications and Risks</td><td><strong>SAFIC</strong></td></tr>
                <tr><td class="time-cell">13:00–16:00</td><td>From Research to Impact: How KALRO &amp; CIMMYT Are Advancing Agricultural Innovation</td><td><strong>CIMMYT</strong></td></tr>
                <tr><td class="time-cell">14:00–16:00</td><td>Emerging trends in food safety: Challenges, innovations, regulation and policy</td><td><strong>KALRO / Egerton</strong></td></tr>
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
                <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy &amp; Socio-Economics</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Juma Magogo</strong> &nbsp;·&nbsp; Rapporteurs: Nancy M Nganga &amp; Peterson Mwangi</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Perceptions of Climate Change Among Smallholder Farmers in Home Garden Agroforestry in Ethiopia <br><span class="code-cell">SUB17_062</span> &nbsp; Aberham Kebedom Darge</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Public policy preferences for enhancing maize productivity: evidence from western Kenya <br><span class="code-cell">SUB17_064</span> &nbsp; Fido Orawo</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Determinants of Soil Testing Decisions Among Smallholder Maize Farmers in western Kenya <br><span class="code-cell">SUB17_065</span> &nbsp; Fido Orawo</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Choice of Market Outlets Among Smallholder Cassava Farmers in Kilifi County <br><span class="code-cell">SUB17_067</span> &nbsp; Abigail Chepchumba</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Modelling and Forecasting Agricultural Research Capacity in Kenya (2000–2025) <br><span class="code-cell">SUB17_068</span> &nbsp; Titus Ngetich</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Adoption of Improved Rice Varieties and Effects on Smallholder Income in Busia County <br><span class="code-cell">SUB17_070</span> &nbsp; Ibrahim Omondi</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Varietal bias in coffee production systems in Kenya: Evidence from Kericho County <br><span class="code-cell">SUB17_071</span> &nbsp; James Minai Maina</td></tr>
                <tr><td class="time-cell">12:45–1:00</td><td>Gendered Roles and Cultural Constraints in Climate-Resilient Sorghum Value Chains <br><span class="code-cell">SUB17_021</span> &nbsp; Anastasia W. Kagunyu</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Animal Health (11:00–12:00) → Mechanization (12:15–1:00)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Joseph Nginyi</strong> / <strong>Dr. Golicha Dub</strong> &nbsp;·&nbsp; Rapporteurs: Judith Mboya &amp; Joyce Addah</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Antibacterial Potential of Eucalyptus globulus Leaf Extracts Against Multidrug-Resistant Isolates <br><span class="code-cell">SUB11_019</span> &nbsp; Elsy Kendi</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Population genetics insights to inform tsetse fly control in Kenya <br><span class="code-cell">SUB11_021</span> &nbsp; Winnie Okeyo</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Slow and controlled release of tsetse repellent blends in cattle protection <br><span class="code-cell">SUB11_022</span> &nbsp; Benson Wachira</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Host Preference of Glossina austeni at the Wildlife–Livestock–Human Interface <br><span class="code-cell">SUB11_024</span> &nbsp; Erick Kibichiy Serem</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Endectocide Run-off from East African Livestock: A One Health Assessment <br><span class="code-cell">SUB11_026</span> &nbsp; Clarence M Mang'era</td></tr>
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
                <tr><td class="time-cell">11:00–11:15</td><td>Determinants of Uptake of Climate-Resilient Irrigation Practices Among Onion Farmers in Laikipia <br><span class="code-cell">SUB5_001</span> &nbsp; Ian Kiplagat Katui</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Smart irrigation technologies for improved water use efficiency in fodder production: A review <br><span class="code-cell">SUB5_002</span> &nbsp; Beatrice Cherono Langat</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Grey Water Management for Irrigation in Semi-Arid Areas of Kenya <br><span class="code-cell">SUB5_003</span> &nbsp; Okoth Felix Odiwuor</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Low-Cost Wastewater Treatment and Re-Use System for Sustainable Irrigation <br><span class="code-cell">SUB5_007</span> &nbsp; Samuel Mukanga</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Optimizing Water Use in Farming Systems: A review of Tools and Methods <br><span class="code-cell">SUB5_008</span> &nbsp; Maingi Susan</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Promoting Lined Water Pans for Climate-Resilient Small-Scale Irrigation in Kenya <br><span class="code-cell">SUB5_009</span> &nbsp; Francis Karanja</td></tr>
                <tr><td class="time-cell">12:30–12:38</td><td>Effect of Superabsorbent Polymers on Production of African Nightshade in Mollic Nitisols <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB5_011</span> &nbsp; Geoffrey Kibiri</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy &amp; Socio-Economics</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Scholastica Wambua</strong> &nbsp;·&nbsp; Rapporteurs: Reuben Rutto &amp; Tabby Karanja</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Economic Implication of Post-Harvest Losses in Tomato Production in Kenya <br><span class="code-cell">SUB17_073</span> &nbsp; Moses Kimani</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Determinants Of Potato Productivity Among Smallholder Farmers in Kenya <br><span class="code-cell">SUB17_074</span> &nbsp; Purity Kawira Muriuki</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Insights on the Effects on Mechanization in the Tea Industry in Kenya <br><span class="code-cell">SUB17_079</span> &nbsp; Simon Oduor Ochanda</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Restructuring KALRO's Seeds For Enhanced Production, Quality Assurance and Distribution <br><span class="code-cell">SUB17_080</span> &nbsp; Robert Musyoki</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Does the plot manager matter? An assessment of household productivity of maize-legume systems <br><span class="code-cell">SUB17_081</span> &nbsp; Martha Akelo Opondo</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Gender Differentials in Yield and Productivity among Contracted Bean Seed Growers in West Pokot <br><span class="code-cell">SUB17_023</span> &nbsp; Jerop Edith</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Leveraging Routine Sales Data to Understand Gendered and Spatial Demand in Agricultural Input Markets <br><span class="code-cell">SUB17_025</span> &nbsp; Isaac Kenga</td></tr>
                <tr><td class="time-cell">12:45–12:53</td><td>Dynamics of marketing of Green Shelled Beans Among urban traders in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB17_022</span> &nbsp; Beth Ndungu</td></tr>
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
                <span class="subtheme-tag mt-1">Animal Feed Resources, Nutrition &amp; Husbandry Practices</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Tura Isako</strong> &nbsp;·&nbsp; Rapporteurs: Peterson Mwangi &amp; Nicholas Kibunyi</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Seasonal Dynamics of Pasture Productivity and Feed Availability in Kenyan Rangelands <br><span class="code-cell">SUB9_033</span> &nbsp; Lenah Muema</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Spineless Cactus as a Climate-Smart Forage Crop in Kenya's ASALs <br><span class="code-cell">SUB9_036</span> &nbsp; John Irungu</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Yield and Quality of Napier Varieties under Different Moisture Conservation Practices <br><span class="code-cell">SUB9_038</span> &nbsp; Robert Ouko Owano</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Evaluation of Phenotypic and Genotypic Diversity in Forage and Dual-Purpose Sorghums: A Review <br><span class="code-cell">SUB9_021</span> &nbsp; Mercy Jerop</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Assessment of nutritive attributes and in vitro dry matter digestibility of Napier Grass varieties <br><span class="code-cell">SUB9_004</span> &nbsp; Lorna Chemutai Chesir</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Feed Efficiency and Body Condition Responses of Red Maasai Sheep Fed TMR vs Grazing <br><span class="code-cell">SUB9_005</span> &nbsp; Fred Kemboi</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>Comparative Performance of Improved Boran Steers on TMR vs Free-Range Grazing <br><span class="code-cell">SUB9_006</span> &nbsp; Tura Isako</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Apparent Nutrient Digestibility and Productivity in Chicken Fed High Quality Feed Rations <br><span class="code-cell">SUB9_007</span> &nbsp; Innocent Kariuki</td></tr>
                <tr style="background:#f0fdf4;"><td class="time-cell" style="color:#14532d;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#14532d;font-weight:600;font-size:.8rem;">Plant Health (Chair: Dr. Miriam Otipa)</td></tr>
                <tr><td class="time-cell">4:00–4:15</td><td>Banana Weevil Infestation in Different Banana Cultivars: Implications for Host Plant Resistance <br><span class="code-cell">SUB3_030</span> &nbsp; Ceciliah Ngugi</td></tr>
                <tr><td class="time-cell">4:15–4:30</td><td>Integrated evaluation of Blast in Combined Diverse and Elite Rice Panel <br><span class="code-cell">SUB3_031</span> &nbsp; Roselyne Juma</td></tr>
                <tr><td class="time-cell">4:30–4:45</td><td>Pathogenicity of Rice Yellow Mottle Virus Isolates and Response of Selected Rice Cultivars <br><span class="code-cell">SUB3_032</span> &nbsp; Simon Meso Obila</td></tr>
                <tr><td class="time-cell">4:45–5:00</td><td>Comparative Efficacy of Botanical And Synthetic Dust Treatments Against Major Stored-Product Pests <br><span class="code-cell">SUB3_039</span> &nbsp; Mark Limo</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Sustainable Seed Systems (2:00–3:39) → Climate Change &amp; Land Degradation (3:39–5:09)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Godwin Macharia</strong> / <strong>Dr. Golicha Dub</strong> &nbsp;·&nbsp; Rapporteurs: Harun Odhiambo &amp; Sheila Siele</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>A Sustainable Forage Seed Systems as a Pathway to Address Livestock Feed Shortages in ASALs <br><span class="code-cell">SUB2_001</span> &nbsp; Rose Nelima Wekesa</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Optimizing nutrient management for enhanced seed yield of Enteropogon macrostachyus <br><span class="code-cell">SUB2_002</span> &nbsp; Bryan Peter Ogillo</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Breaking Oil Palm Seed Dormancy: Heat, Chemical, and Mechanical Pretreatments Review <br><span class="code-cell">SUB2_003</span> &nbsp; Lynet Nasiroli Navangi</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Validation of Single Eye Bud Technology for Improved Sugarcane Seed Production in Kibos <br><span class="code-cell">SUB2_009</span> &nbsp; Edwin Shikanda</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Overcoming Brachiaria Seed Bottlenecks: Nursery Rapid Multiplication for Climate-Smart Forage <br><span class="code-cell">SUB2_010</span> &nbsp; Meshack Kipngetich Rutto</td></tr>
                <tr><td class="time-cell">3:15–3:23</td><td>Development and promotion of finger millet seed system in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB2_020</span> &nbsp; Peninah Chelangat Langat</td></tr>
                <tr><td class="time-cell">3:23–3:31</td><td>Structure and Constraints of the Pyrethrum Seed Systems in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB2_021</span> &nbsp; Peter Kimutai Kirwa</td></tr>
                <tr><td class="time-cell">3:31–3:39</td><td>Bridging the Last-Mile Gap in Sustainable Seed Systems: KALRO Mkulima Shops Model <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB2_027</span> &nbsp; Stephen Irungu</td></tr>
                <tr style="background:#fef9f0;"><td class="time-cell" style="color:#d97706;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#d97706;font-weight:600;font-size:.8rem;">Climate Change, Land Degradation &amp; Reclamation</td></tr>
                <tr><td class="time-cell">3:39–3:54</td><td>Land Use Changes and Vegetation Decline in Gursum District, Somali Region, Ethiopia <br><span class="code-cell">SUB7_001</span> &nbsp; Mahamud Fuad</td></tr>
                <tr><td class="time-cell">3:54–4:09</td><td>Factors Influencing Transition from Awareness to Adoption of Climate-Smart Technologies <br><span class="code-cell">SUB7_003</span> &nbsp; Shirley Auma Oloo</td></tr>
                <tr><td class="time-cell">4:09–4:24</td><td>Morphological and Yield Performance of Certified Range Grasses in ASALs of Kenya <br><span class="code-cell">SUB7_004</span> &nbsp; Rop Daniel</td></tr>
                <tr><td class="time-cell">4:24–4:39</td><td>Integrated Bush Management and Reseeding for Restoring Forage Productivity in Semi-Arid Rangelands <br><span class="code-cell">SUB7_006</span> &nbsp; Mercy Chebet</td></tr>
                <tr><td class="time-cell">4:39–4:54</td><td>Adoption and Impact of Climate Smart Agriculture Practices in Kigumo Sub-County <br><span class="code-cell">SUB7_007</span> &nbsp; Lilian Weisiko Nyamohanga</td></tr>
                <tr><td class="time-cell">4:54–5:09</td><td>How Agribusiness SMEs in Kiambu and Kajiado Counties are Adapting to Weather Effects <br><span class="code-cell">SUB7_008</span> &nbsp; Nancy Mwihaki Ng'ang'a</td></tr>
                <tr><td class="time-cell">5:09–5:17</td><td>Bio-Energy Innovation using Agricultural Residues in Tenges Ward, Baringo County <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB7_002</span> &nbsp; Dennis Kipng'etich Kandie</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">3</div>
                <div><span class="room-tag">Big Seminar Room</span><br>
                <span class="subtheme-tag mt-1">Climate Change (2:00–3:15) → Agribusiness &amp; Food Safety (3:15–5:30)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. David Kamau</strong> / <strong>Dr. Scholastica Wambua</strong> / <strong>Mr. John Irungu</strong></span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Understanding climate variability effects on post-harvest management in horticultural value chains <br><span class="code-cell">SUB7_010</span> &nbsp; Daniel Musyoka</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Influence of Weather and Climate Information Services on Adoption of Climate-Smart Technologies <br><span class="code-cell">SUB7_011</span> &nbsp; Millicent Kalenya</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Variation in Soil Properties across Land Uses in the Kibwezi Watershed <br><span class="code-cell">SUB7_014</span> &nbsp; Reuben Ruttoh</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Effect of Rainfall Variation on Demand and Sales of Avocado Seedlings at KALRO Kandara Nursery <br><span class="code-cell">SUB7_027</span> &nbsp; Faith Wambui Mucunu</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Validating Multi-Storey Gardens for Climate-Resilient, Nutritious Food Production in Kenya <br><span class="code-cell">SUB7_030</span> &nbsp; Charity Kiplagat</td></tr>
                <tr style="background:#fef9f0;"><td class="time-cell" style="color:#d97706;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#d97706;font-weight:600;font-size:.8rem;">Agribusiness, Financing, Policy &amp; Socio-Economics</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Adoption of Climate Smart Agricultural practices by pigeon pea farmers in Machakos County <br><span class="code-cell">SUB17_084</span> &nbsp; Agatha Mumbua Daniel</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>Factors contributing to low groundnut productivity in Western Kenya despite high market demand <br><span class="code-cell">SUB17_086</span> &nbsp; Simon Meso Obila</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Agronomic and Farmer-Perceived Performance of Customized Fertilizers for Maize in 13 counties <br><span class="code-cell">SUB17_087</span> &nbsp; Mwathi Jane Wamaitha</td></tr>
                <tr><td class="time-cell">4:00–4:15</td><td>Leveraging Public Private Partnerships to Strengthen Sustainable Seed Systems <br><span class="code-cell">SUB17_089</span> &nbsp; Samuel Kiiru</td></tr>
                <tr style="background:#fef2f2;"><td class="time-cell" style="color:#dc2626;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#dc2626;font-weight:600;font-size:.8rem;">Food Safety, Value Addition &amp; Cottage Industries</td></tr>
                <tr><td class="time-cell">4:15–4:30</td><td>Efficacy of Nixtamalization On Reduction of Fumonisin Contamination in Maize <br><span class="code-cell">SUB14_009</span> &nbsp; Sylviah Nekesa</td></tr>
                <tr><td class="time-cell">4:30–4:45</td><td>Practices influencing mycotoxin contamination in maize and farmers' use of rapid test kits <br><span class="code-cell">SUB14_011</span> &nbsp; Beatrice Nafula Tenge</td></tr>
                <tr><td class="time-cell">4:45–5:00</td><td>Occurrence of Aflatoxin and Fumonisin in Foods Consumed By Children in Marsabit County <br><span class="code-cell">SUB14_012</span> &nbsp; Amos Otieno Adongo</td></tr>
                <tr><td class="time-cell">5:00–5:15</td><td>Epidemiological Trends of Foodborne Aflatoxin Exposure and Cancer in Developing Countries <br><span class="code-cell">SUB14_013</span> &nbsp; Kimeu Urbanus</td></tr>
                <tr><td class="time-cell">5:15–5:30</td><td>Comparative Evaluation of Physical and Cup Quality Performance of Global Coffee Varieties in Kenya <br><span class="code-cell">SUB14_014</span> &nbsp; Cecilia Wagikondi Kathurima</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Plant Health (2:00–4:30) → Animal Feed (4:30–5:24)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Abou Togola, CIMMYT</strong> / <strong>Dr. Benard Korir</strong></span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">2:00–2:15</td><td>Beyond the Gene: Climate Change-Driven Breakdown of Phyto-pathogenic Resistance in Grain Legumes <br><span class="code-cell">SUB3_034</span> &nbsp; Harun Odhiambo</td></tr>
                <tr><td class="time-cell">2:15–2:30</td><td>Potential of Rhizobacteria from Manure Sources in Management of Bacterial Wilt On Potatoes <br><span class="code-cell">SUB3_036</span> &nbsp; Anita Nduku Mutua</td></tr>
                <tr><td class="time-cell">2:30–2:45</td><td>Optimizing Potato Cultivation: An AI-Driven Integration of LLMs and Disease Epidemiology <br><span class="code-cell">SUB3_037</span> &nbsp; Shadrack Odikara Oriama</td></tr>
                <tr><td class="time-cell">2:45–3:00</td><td>Efficacy of Aluminum Phosphide Fumigation in Mole Population Management at KALRO Kabete <br><span class="code-cell">SUB3_038</span> &nbsp; Mark Limo</td></tr>
                <tr><td class="time-cell">3:00–3:15</td><td>Retooling Crop Health Capacity of Advisory Service Providers <br><span class="code-cell">SUB3_042</span> &nbsp; Miriam Otipa</td></tr>
                <tr><td class="time-cell">3:15–3:30</td><td>Evaluation of Genotypic Variation in Cowpea Scab Incidence Across Two Kenyan Agro-Ecological Zones <br><span class="code-cell">SUB3_043</span> &nbsp; Kelele Faida John</td></tr>
                <tr><td class="time-cell">3:30–3:45</td><td>Integrated Fall armyworm management in Narok and Nakuru Counties using tolerant hybrids and biopesticides <br><span class="code-cell">SUB3_046</span> &nbsp; Abel Too</td></tr>
                <tr><td class="time-cell">3:45–4:00</td><td>Antifungal activity of actinomycetes isolates against fungal pathogens infecting Tomato <br><span class="code-cell">SUB3_048</span> &nbsp; Carol Gichohi</td></tr>
                <tr><td class="time-cell">4:00–4:15</td><td>Machine Learning-Based Prediction of Aflatoxin Risk Using Environmental and Agronomic Factors <br><span class="code-cell">SUB3_049</span> &nbsp; Kelvin Mutua Murungi</td></tr>
                <tr><td class="time-cell">4:15–4:30</td><td>Bean Aphid Natural Enemies, Field Margin Vegetation and Biopesticide Role in Integrated Pest Control <br><span class="code-cell">SUB3_050</span> &nbsp; Janet Obanyi</td></tr>
                <tr style="background:#f0fdf4;"><td class="time-cell" style="color:#14532d;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#14532d;font-weight:600;font-size:.8rem;">Animal Feed Resources (Chair: Dr. Benard Korir)</td></tr>
                <tr><td class="time-cell">4:30–4:45</td><td>Effect of soil type and altitude on yield and quality of selected forage grasses in Tanzania and Kenya <br><span class="code-cell">SUB9_012</span> &nbsp; Solomon Mwendia</td></tr>
                <tr><td class="time-cell">4:45–5:00</td><td>Feed Efficiency and Body Condition of Dairy Crosses Fed TMR Compared to Conventional Grazing <br><span class="code-cell">SUB9_014</span> &nbsp; Sarah Mkakina Mghanga</td></tr>
                <tr><td class="time-cell">5:00–5:08</td><td>Optimization of Broilers Growth through Three Phase Feeding <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_009</span> &nbsp; Dr. Victor Ngaira</td></tr>
                <tr><td class="time-cell">5:08–5:16</td><td>Impact of different feed resources on milk production by small-scale dairy farmers in Bungoma &amp; Nyamira <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_011</span> &nbsp; Shadrack Musembi</td></tr>
                <tr><td class="time-cell">5:16–5:24</td><td>Evaluating the influence of feeding regimes on milk composition of dairy cattle at Naivasha <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_020</span> &nbsp; Daniel Chengo</td></tr>
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
                <tr><td class="time-cell">7:30 – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 – 9:30 AM</td><td><strong>Chief Guest Address &amp; Panel Discussion</strong></td><td>Moderator: Dr. Margaret Makelo</td></tr>
                <tr><td class="time-cell">9:30 – 10:00 AM</td><td>Keynote Address</td><td></td></tr>
                <tr><td class="time-cell">10:00 – 10:10 AM</td><td>Signing of Soya bean commercialisation agreement between Shirika Vini and KALRO</td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:10 – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
                <tr><td class="time-cell">11:00 AM</td><td><strong>Session Breakouts</strong></td><td></td></tr>
            </tbody>
        </table>
    </div>

    <div class="side-event-card">
        <div class="side-event-head">
            <h4>⚡ Side Events — Thursday 18 June 2026</h4>
        </div>
        <table class="prog-table">
            <thead><tr><th>Time</th><th>Session Title</th><th>Host</th></tr></thead>
            <tbody>
                <tr><td class="time-cell">09:00–11:00</td><td>Sustainable Livestock in Kenya: Unlocking Economic, Environmental &amp; Social Benefits</td><td><strong>ILRI</strong></td></tr>
                <tr><td class="time-cell">10:00–12:30</td><td>Accelerating Sustainable Production, Market Trade &amp; Consumption</td><td><strong>Alliance Bioversity International &amp; CIAT</strong></td></tr>
                <tr><td class="time-cell">11:00–15:00*</td><td>Nanotechnology Innovations for Climate Smart Agriculture</td><td><strong>EDDFarming</strong></td></tr>
                <tr><td class="time-cell">14:00–16:00</td><td>Cassava starch processing</td><td><strong>KALRO / AFA</strong></td></tr>
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
                <tr><td class="time-cell">11:00–11:15</td><td>Effects of Urea-Molasses Mineral Block Supplementation on Digestibility of Dorper Sheep <br><span class="code-cell">SUB9_024</span> &nbsp; Sally Nduta</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Milk offtake, compensatory growth and dual-purpose productivity of Boran cattle <br><span class="code-cell">SUB9_026</span> &nbsp; Jack Ouda</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Concentrate Supplementation of Lactating Dairy Goats Improves Nutritional and Therapeutic Value <br><span class="code-cell">SUB9_027</span> &nbsp; Joseph Ndwiga Kiura</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Nutritive value and Effects of Total Mixed Ration on Milk Composition of Dairy Cows <br><span class="code-cell">SUB9_029</span> &nbsp; Ezra Kiplangat Sang</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Performance of sheep fed on different diets: in vivo and in vitro gas production <br><span class="code-cell">SUB9_002</span> &nbsp; Jack Ouda</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Evaluation of Megathyrus spp and Urochloa spp Forage Grasses in Western Kenya <br><span class="code-cell">SUB9_003</span> &nbsp; Peggy Karimi</td></tr>
                <tr><td class="time-cell">12:30–12:38</td><td>Evaluation of Growth Performance of Two Improved Kienyeji Breeds under Coastal Conditions <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_022</span> &nbsp; Isaac Kenga</td></tr>
                <tr><td class="time-cell">12:38–12:46</td><td>Natural Egg Yolk–Based Feeding Media vs Wheat Bran–Liver Substrate for Lucilia Sericata Larvae Production <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_031</span> &nbsp; Kipkirui Billy</td></tr>
                <tr><td class="time-cell">12:46–12:54</td><td>Black Soldier Fly Larval Meal as Affordable Protein for Enhancing Rainbow Trout Growth <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_037</span> &nbsp; Sambu Saitoti</td></tr>
                <tr><td class="time-cell">12:54–1:02</td><td>Laying Trends and Factors Influencing Productivity in the KALRO Improved Indigenous KC3 Breed <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB9_008</span> &nbsp; Sharona Imali</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">2</div>
                <div><span class="room-tag">Main Board Room</span><br>
                <span class="subtheme-tag mt-1">Ecological-Organic Farming (11:00–11:54) → Plant Health (12:00–1:15)</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Duba Golicha</strong> / <strong>Dr. David Thuranira</strong></span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Ammonia as a Source of Bioenergy to Power Agriculture and Food Systems in Kenya <br><span class="code-cell">SUB6_005</span> &nbsp; Tabeel Nandokha</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Fungal Enzyme-Assisted Bioconversion of Agricultural Waste for Sustainable Soil Fertility Management <br><span class="code-cell">SUB6_010</span> &nbsp; Moses Mandere</td></tr>
                <tr><td class="time-cell">11:30–11:38</td><td>Organic Conservation Agricultural Practices as Pathways for Soil Fertility Restoration <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB6_002</span> &nbsp; Chepkania Miriam Nangila</td></tr>
                <tr><td class="time-cell">11:38–11:46</td><td>Enhancing Soil Health and Food Safety through Organic Waste Composting in Urban Farming <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB6_003</span> &nbsp; Esther K. Muriuki</td></tr>
                <tr><td class="time-cell">11:46–11:54</td><td>Vegetable Production Using Organic Manures (Frass) from Black Soldier Fly <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB6_007</span> &nbsp; Elizabeth W. Okwach</td></tr>
                <tr style="background:#fef2f2;"><td class="time-cell" style="color:#dc2626;font-weight:700;">Sub-theme shift →</td><td colspan="1" style="color:#dc2626;font-weight:600;font-size:.8rem;">Plant Health (Chair: Dr. David Thuranira)</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Crop Health as Human Health: Redefining Food Safety Through Plant Disease Management <br><span class="code-cell">SUB3_007</span> &nbsp; Harun Odhiambo</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Climate vulnerability and the burden of pests among smallholder coffee farmers in Kenya <br><span class="code-cell">SUB3_008</span> &nbsp; Getrude Alworah</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Survey of Phytophthora Root Rot Disease of Avocado in Kandara and Kigumo Sub-Counties <br><span class="code-cell">SUB3_009</span> &nbsp; Ruth Amata</td></tr>
                <tr><td class="time-cell">12:45–1:00</td><td>Elucidating Mechanisms of Resistance to Fall Armyworm in Maize <br><span class="code-cell">SUB3_040</span> &nbsp; Gerphas Ogola</td></tr>
                <tr><td class="time-cell">1:00–1:15</td><td>Screening for cashew powdery mildew tolerance in cashew varieties in coastal Kenya <br><span class="code-cell">SUB3_041</span> &nbsp; Alfred Mumba</td></tr>
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
                <tr><td class="time-cell">11:00–11:15</td><td>Determinants of Uptake of Climate-Resilient Irrigation Practices Among Onion Farmers in Laikipia <br><span class="code-cell">SUB5_001</span> &nbsp; Ian Kiplagat Katui</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Smart irrigation technologies for improved water use efficiency in fodder production: A review <br><span class="code-cell">SUB5_002</span> &nbsp; Beatrice Cherono Langat</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Grey Water Management for Irrigation in Semi-Arid Areas of Kenya <br><span class="code-cell">SUB5_003</span> &nbsp; Okoth Felix Odiwuor</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Low-Cost Wastewater Treatment and Re-Use System for Sustainable Irrigation <br><span class="code-cell">SUB5_007</span> &nbsp; Samuel Mukanga</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Optimizing Water Use in Farming Systems: A review of Tools and Methods <br><span class="code-cell">SUB5_008</span> &nbsp; Maingi Susan</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Promoting Lined Water Pans for Climate-Resilient Small-Scale Irrigation in Kenya <br><span class="code-cell">SUB5_009</span> &nbsp; Francis Karanja</td></tr>
                <tr><td class="time-cell">12:30–12:38</td><td>Effect of Superabsorbent Polymers on Production of African Nightshade in Mollic Nitisols <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB5_011</span> &nbsp; Geoffrey Kibiri</td></tr>
            </tbody></table>
        </div>

        <div class="parallel-card">
            <div class="parallel-subhead">
                <div class="parallel-num">4</div>
                <div><span class="room-tag">Room 207</span><br>
                <span class="subtheme-tag mt-1">Agribusiness, Financing, Policy &amp; Socio-Economics</span><br>
                <span class="chair-info mt-1">Chair: <strong>Dr. Scholastica Wambua</strong> &nbsp;·&nbsp; Rapporteurs: Reuben Rutto &amp; Tabby Karanja</span></div>
            </div>
            <table class="prog-table"><tbody>
                <tr><td class="time-cell">11:00–11:15</td><td>Economic Implication of Post-Harvest Losses in Tomato Production in Kenya <br><span class="code-cell">SUB17_073</span> &nbsp; Moses Kimani</td></tr>
                <tr><td class="time-cell">11:15–11:30</td><td>Determinants Of Potato Productivity Among Smallholder Farmers in Kenya <br><span class="code-cell">SUB17_074</span> &nbsp; Purity Kawira Muriuki</td></tr>
                <tr><td class="time-cell">11:30–11:45</td><td>Insights on the Effects on Mechanization in the Tea Industry in Kenya <br><span class="code-cell">SUB17_079</span> &nbsp; Simon Oduor Ochanda</td></tr>
                <tr><td class="time-cell">11:45–12:00</td><td>Restructuring KALRO's Seeds For Enhanced Production, Quality Assurance and Distribution <br><span class="code-cell">SUB17_080</span> &nbsp; Robert Musyoki</td></tr>
                <tr><td class="time-cell">12:00–12:15</td><td>Does the plot manager matter? Household productivity of maize-legume systems in West Alego <br><span class="code-cell">SUB17_081</span> &nbsp; Martha Akelo Opondo</td></tr>
                <tr><td class="time-cell">12:15–12:30</td><td>Gender Differentials in Yield and Productivity among Contracted Bean Seed Growers in West Pokot <br><span class="code-cell">SUB17_023</span> &nbsp; Jerop Edith</td></tr>
                <tr><td class="time-cell">12:30–12:45</td><td>Leveraging Routine Sales Data to Understand Demand in Smallholder Agricultural Input Markets <br><span class="code-cell">SUB17_025</span> &nbsp; Isaac Kenga</td></tr>
                <tr><td class="time-cell">12:45–12:53</td><td>Dynamics of marketing of Green Shelled Beans Among urban traders in Kenya <span class="poster-tag">POSTER</span><br><span class="code-cell">SUB17_022</span> &nbsp; Beth Ndungu</td></tr>
                <tr class="break-row"><td class="time-cell">1:00–2:00 PM</td><td colspan="2">🍽 Lunch Break</td></tr>
            </tbody></table>
        </div>

    </div><!-- /day4 morning sessions -->

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
                <tr><td class="time-cell">7:30 – 8:30 AM</td><td>Registration</td><td></td></tr>
                <tr><td class="time-cell">8:30 – 9:00 AM</td><td><strong>Keynote Address 1</strong></td><td></td></tr>
                <tr><td class="time-cell">9:00 – 9:30 AM</td><td><strong>Keynote Address 2</strong></td><td></td></tr>
                <tr><td class="time-cell">9:30 – 10:30 AM</td><td>Best project – presentations and students session</td><td></td></tr>
                <tr class="break-row"><td class="time-cell">10:30 – 11:00 AM</td><td colspan="2">☕ Health Break</td></tr>
            </tbody>
        </table>
    </div>

    <div class="closing-card">
        <h4>🏆 Awards &amp; Closing Ceremony</h4>
        <p style="margin-bottom:10px;">MC: Dr. Evans Ilatsia &nbsp;·&nbsp; Rapporteur: Nicholas Kibunyi</p>
        <div style="background:rgba(255,255,255,.12);border-radius:10px;padding:16px 20px;display:inline-block;">
            <table style="color:white;border-collapse:collapse;text-align:left;font-size:.9rem;">
                <tr><td style="padding:6px 20px 6px 0;opacity:.75;white-space:nowrap;">11:00 AM – 1:00 PM</td><td><strong>Awards and Closing Ceremony by Chief Guest</strong></td></tr>
                <tr><td style="padding:6px 20px 6px 0;opacity:.75;white-space:nowrap;">1:00 PM – 2:00 PM</td><td><strong>🍽 Lunch Break &amp; End of Conference</strong></td></tr>
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

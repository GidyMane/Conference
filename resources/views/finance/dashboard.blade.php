@extends('reviewer.layout')

@section('title', 'Finance Dashboard – Revenue Summary')
@section('page-title', 'Finance Dashboard')

@section('content')
<style>
:root {
    --green:  #16a34a;
    --dgreen: #14532d;
    --lgreen: #dcfce7;
    --amber:  #d97706;
    --lamber: #fef3c7;
    --blue:   #1e5a96;
    --lblue:  #dbeafe;
    --purple: #7c3aed;
    --lpurple:#ede9fe;
    --red:    #dc2626;
    --lred:   #fee2e2;
}

/* ── Hero ── */
.rev-hero {
    background: linear-gradient(135deg, #14532d 0%, #16a34a 60%, #22c55e 100%);
    border-radius: 18px;
    padding: 36px 40px;
    color: white;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
}
.rev-hero::after {
    content: '\f155';
    font-family: 'Font Awesome 6 Free'; font-weight: 900;
    position: absolute; right: 48px; top: 50%; transform: translateY(-50%);
    font-size: 180px; opacity: .05;
}
.rev-hero h2 { font-size: 1.8rem; font-weight: 800; margin-bottom: 6px; }
.rev-hero p  { opacity: .8; margin: 0; }

/* ── Grand Total tiles ── */
.grand-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}
.grand-tile {
    border-radius: 16px;
    padding: 28px 24px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,.12);
}
.grand-tile.kes  { background: linear-gradient(135deg,#14532d,#16a34a); }
.grand-tile.usd  { background: linear-gradient(135deg,#1e3a8a,#2563eb); }
.grand-tile.pend { background: linear-gradient(135deg,#92400e,#d97706); }
.grand-tile .gt-label { font-size: .8rem; text-transform: uppercase; letter-spacing:.08em; opacity:.75; margin-bottom:6px; }
.grand-tile .gt-amount { font-size: 2.2rem; font-weight: 800; letter-spacing:-.02em; line-height:1; }
.grand-tile .gt-sub { font-size: .8rem; opacity:.7; margin-top:8px; }
.grand-tile .gt-icon { position:absolute; right:20px; top:50%; transform:translateY(-50%);
                        font-size:56px; opacity:.12; }

/* ── Section cards ── */
.rev-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    margin-bottom: 28px;
    overflow: hidden;
}
.rev-card-header {
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.rev-card-header h5 { margin:0; font-weight:700; font-size:1rem; }
.rev-card-body { padding: 0 24px 24px; }

.rch-single  { background: var(--lgreen);  border-bottom: 3px solid var(--green); }
.rch-group   { background: var(--lblue);   border-bottom: 3px solid var(--blue);  }
.rch-exhibit { background: var(--lpurple); border-bottom: 3px solid var(--purple);}

.rch-single  h5 { color: var(--dgreen); }
.rch-group   h5 { color: var(--blue);   }
.rch-exhibit h5 { color: var(--purple); }

/* ── Metric rows ── */
.metric-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: .93rem;
}
.metric-row:last-child { border-bottom: none; }
.metric-label { color: #64748b; display: flex; align-items: center; gap: 8px; }
.metric-value { font-weight: 700; color: #1e293b; font-size: 1rem; }
.metric-value.big { font-size: 1.3rem; color: var(--dgreen); }
.metric-value.blue { color: var(--blue); }
.metric-value.purple { color: var(--purple); }

/* ── Sub breakdown table ── */
.breakdown-table { width:100%; border-collapse:collapse; font-size:.88rem; margin-top:12px; }
.breakdown-table th {
    background:#f8fafc; color:#64748b; font-weight:700;
    text-transform:uppercase; letter-spacing:.06em; font-size:.75rem;
    padding:10px 14px; border-bottom:2px solid #e2e8f0; text-align:left;
}
.breakdown-table td { padding:12px 14px; border-bottom:1px solid #f1f5f9; }
.breakdown-table tr:last-child td { border-bottom:none; }
.breakdown-table .amt { font-weight:700; color:#1e293b; }
.breakdown-table .tag {
    display:inline-block; padding:3px 10px; border-radius:20px;
    font-size:.75rem; font-weight:700;
}

/* ── Pending block ── */
.pending-block {
    background: var(--lamber);
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 28px;
}
.pending-block h6 { color: var(--amber); font-weight:700; margin-bottom:14px; }

/* ── Recent activity ── */
.activity-list { list-style:none; padding:0; margin:0; }
.activity-item {
    display:flex; align-items:center; gap:14px;
    padding:12px 0; border-bottom:1px solid #f1f5f9;
}
.activity-item:last-child { border-bottom:none; }
.activity-dot {
    width:38px; height:38px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:.85rem; flex-shrink:0; font-weight:700;
}
.ad-single  { background:var(--lgreen);  color:var(--dgreen); }
.ad-group   { background:var(--lblue);   color:var(--blue);   }
.ad-exhibit { background:var(--lpurple); color:var(--purple); }
.activity-name { font-weight:600; font-size:.9rem; color:#1e293b; }
.activity-meta { font-size:.78rem; color:#94a3b8; margin-top:2px; }
.activity-amt  { font-weight:700; margin-left:auto; font-size:.9rem; color:var(--dgreen); white-space:nowrap; }
</style>

{{-- Hero --}}
<div class="rev-hero">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h2><i class="fas fa-chart-line me-2"></i>Revenue Summary</h2>
            <p>Approved payments only &mdash; as of {{ now()->format('M d, Y H:i') }}</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('finance.registrations.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-users me-1"></i> Registrations
            </a>
            <a href="{{ route('finance.exhibitions.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-store me-1"></i> Exhibitions
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     GRAND TOTAL TILES
════════════════════════════════════════ --}}
<div class="grand-grid">

    <div class="grand-tile kes">
        <i class="fas fa-coins gt-icon"></i>
        <div class="gt-label">Total Collected (KES)</div>
        <div class="gt-amount">KES {{ number_format($grandTotalKES) }}</div>
        <div class="gt-sub">
            Single + Group + Exhibition &nbsp;·&nbsp;
            {{ $singleCount + $groupCount + $exhibitionCount }} approved registrations
        </div>
    </div>

    @if($grandTotalUSD > 0)
    <div class="grand-tile usd">
        <i class="fas fa-dollar-sign gt-icon"></i>
        <div class="gt-label">Total Collected (USD)</div>
        <div class="gt-amount">USD {{ number_format($grandTotalUSD) }}</div>
        <div class="gt-sub">International participants</div>
    </div>
    @endif

    <div class="grand-tile pend">
        <i class="fas fa-hourglass-half gt-icon"></i>
        <div class="gt-label">Pending (not yet approved)</div>
        <div class="gt-amount">KES {{ number_format($pendingSingleKES + $pendingGroupKES + $pendingExhibitionKES) }}</div>
        @if($pendingSingleUSD > 0)
        <div class="gt-sub">+ USD {{ number_format($pendingSingleUSD) }} pending</div>
        @else
        <div class="gt-sub">Awaiting payment verification</div>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════
     SINGLE / INDIVIDUAL REGISTRATIONS
════════════════════════════════════════ --}}
<div class="rev-card">
    <div class="rev-card-header rch-single">
        <div class="d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;background:var(--lgreen);border-radius:10px;
                        display:flex;align-items:center;justify-content:center;border:2px solid #86efac;">
                <i class="fas fa-user" style="color:var(--dgreen);font-size:1.1rem;"></i>
            </div>
            <div>
                <h5>Individual Registrations</h5>
                <small style="color:#166534;">{{ $singleCount }} approved registrations</small>
            </div>
        </div>
        <div class="text-end">
            <div style="font-size:1.4rem;font-weight:800;color:var(--dgreen);">KES {{ number_format($singleKES) }}</div>
            @if($singleUSD > 0)
            <div style="font-size:.85rem;color:#166534;">+ USD {{ number_format($singleUSD) }}</div>
            @endif
        </div>
    </div>
    <div class="rev-card-body pt-3">

        {{-- Platform breakdown --}}
        <p class="text-muted mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;">By Platform</p>
        <table class="breakdown-table mb-4">
            <thead>
                <tr>
                    <th>Platform</th>
                    <th>KES Collected</th>
                    <th>USD Collected</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="tag" style="background:#f0fdf4;color:#166534;border:1px solid #86efac;">🏢 Physical</span></td>
                    <td class="amt">KES {{ number_format($singlePhysicalKES) }}</td>
                    <td class="amt">{{ $singlePhysicalUSD > 0 ? 'USD '.number_format($singlePhysicalUSD) : '—' }}</td>
                </tr>
                <tr>
                    <td><span class="tag" style="background:#eff6ff;color:#1d4ed8;border:1px solid #93c5fd;">🖥 Virtual</span></td>
                    <td class="amt">KES {{ number_format($singleVirtualKES) }}</td>
                    <td class="amt">{{ $singleVirtualUSD > 0 ? 'USD '.number_format($singleVirtualUSD) : '—' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Attendance type breakdown --}}
        <p class="text-muted mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;">By Attendance Type</p>
        <table class="breakdown-table mb-4">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Registrants</th>
                    <th>KES Collected</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="tag" style="background:#dcfce7;color:#14532d;border:1px solid #86efac;">📅 Full Week</span></td>
                    <td>{{ $singleFullWeekCount }}</td>
                    <td class="amt">KES {{ number_format($singleFullWeekKES) }}</td>
                </tr>
                <tr>
                    <td><span class="tag" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;">🗓 Partial Days</span></td>
                    <td>{{ $singlePartialCount }}</td>
                    <td class="amt">KES {{ number_format($singlePartialKES) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Partial days drill-down (only if there are partial registrations) --}}
        @if($partialByDays->count() > 0)
        <p class="text-muted mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;">Partial Days Detail</p>
        <table class="breakdown-table">
            <thead>
                <tr>
                    <th>Days</th>
                    <th>Rate / Day</th>
                    <th>Registrants</th>
                    <th>KES Collected</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partialByDays as $row)
                @php $rate = $row->days_count <= 2 ? 4500 : 4000; @endphp
                <tr>
                    <td>
                        <span class="tag" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;">
                            {{ $row->days_count }} day{{ $row->days_count != 1 ? 's' : '' }}
                        </span>
                    </td>
                    <td>KES {{ number_format($rate) }}</td>
                    <td>{{ $row->registrants }}</td>
                    <td class="amt">KES {{ number_format($row->collected) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- Pending --}}
        @if($pendingSingleKES > 0 || $pendingSingleUSD > 0)
        <div class="mt-4 p-3 rounded" style="background:#fff7ed;border:1px solid #fed7aa;">
            <small class="fw-bold" style="color:#c2410c;">
                <i class="fas fa-hourglass-half me-1"></i>
                Pending (not yet approved): KES {{ number_format($pendingSingleKES) }}
                {{ $pendingSingleUSD > 0 ? '+ USD '.number_format($pendingSingleUSD) : '' }}
            </small>
        </div>
        @endif

    </div>
</div>

{{-- ══════════════════════════════════════
     GROUP REGISTRATIONS
════════════════════════════════════════ --}}
<div class="rev-card">
    <div class="rev-card-header rch-group">
        <div class="d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;background:var(--lblue);border-radius:10px;
                        display:flex;align-items:center;justify-content:center;border:2px solid #93c5fd;">
                <i class="fas fa-users" style="color:var(--blue);font-size:1.1rem;"></i>
            </div>
            <div>
                <h5>Group Registrations</h5>
                <small style="color:#1e40af;">
                    {{ $groupCount }} approved group{{ $groupCount != 1 ? 's' : '' }}
                    &nbsp;·&nbsp; {{ $groupMemberCount }} total members
                </small>
            </div>
        </div>
        <div class="text-end">
            <div style="font-size:1.4rem;font-weight:800;color:var(--blue);">KES {{ number_format($groupKES) }}</div>
            @if($groupUSD > 0)
            <div style="font-size:.85rem;color:#1e40af;">+ USD {{ number_format($groupUSD) }}</div>
            @endif
        </div>
    </div>
    <div class="rev-card-body pt-3">

        <div class="metric-row">
            <span class="metric-label"><i class="fas fa-layer-group text-primary"></i> Approved Groups</span>
            <span class="metric-value blue">{{ $groupCount }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label"><i class="fas fa-user-friends text-primary"></i> Total Members in Approved Groups</span>
            <span class="metric-value blue">{{ $groupMemberCount }}</span>
        </div>
        <div class="metric-row">
            <span class="metric-label"><i class="fas fa-calculator text-primary"></i> Average Fee per Group</span>
            <span class="metric-value blue">
                {{ $groupCount > 0 ? 'KES '.number_format($groupKES / $groupCount) : '—' }}
            </span>
        </div>
        <div class="metric-row">
            <span class="metric-label"><i class="fas fa-user text-primary"></i> Average Fee per Member</span>
            <span class="metric-value blue">
                {{ $groupMemberCount > 0 ? 'KES '.number_format($groupKES / $groupMemberCount) : '—' }}
            </span>
        </div>

        @if($pendingGroupKES > 0)
        <div class="mt-3 p-3 rounded" style="background:#fff7ed;border:1px solid #fed7aa;">
            <small class="fw-bold" style="color:#c2410c;">
                <i class="fas fa-hourglass-half me-1"></i>
                Pending (not yet approved): KES {{ number_format($pendingGroupKES) }}
            </small>
        </div>
        @endif

    </div>
</div>

{{-- ══════════════════════════════════════
     EXHIBITION REGISTRATIONS
════════════════════════════════════════ --}}
<div class="rev-card">
    <div class="rev-card-header rch-exhibit">
        <div class="d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;background:var(--lpurple);border-radius:10px;
                        display:flex;align-items:center;justify-content:center;border:2px solid #c4b5fd;">
                <i class="fas fa-store" style="color:var(--purple);font-size:1.1rem;"></i>
            </div>
            <div>
                <h5>Exhibition Registrations</h5>
                <small style="color:#5b21b6;">{{ $exhibitionCount }} approved booth{{ $exhibitionCount != 1 ? 's' : '' }}</small>
            </div>
        </div>
        <div class="text-end">
            <div style="font-size:1.4rem;font-weight:800;color:var(--purple);">KES {{ number_format($exhibitionKES) }}</div>
        </div>
    </div>
    <div class="rev-card-body pt-3">

        @if($exhibitionByType->count() > 0)
        <p class="text-muted mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;">By Booth Type</p>
        <table class="breakdown-table mb-3">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Booths</th>
                    <th>KES Collected</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exhibitionByType as $type)
                <tr>
                    <td>
                        <span class="tag" style="background:var(--lpurple);color:var(--purple);border:1px solid #c4b5fd;">
                            {{ ucfirst(str_replace('_',' ',$type->registration_type)) }}
                        </span>
                    </td>
                    <td>{{ $type->count }}</td>
                    <td class="amt" style="color:var(--purple);">KES {{ number_format($type->total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if($pendingExhibitionKES > 0)
        <div class="mt-3 p-3 rounded" style="background:#fff7ed;border:1px solid #fed7aa;">
            <small class="fw-bold" style="color:#c2410c;">
                <i class="fas fa-hourglass-half me-1"></i>
                Pending (not yet approved): KES {{ number_format($pendingExhibitionKES) }}
            </small>
        </div>
        @endif

    </div>
</div>

{{-- ══════════════════════════════════════
     CONSOLIDATED SUMMARY TABLE
════════════════════════════════════════ --}}
<div class="rev-card">
    <div class="rev-card-header" style="background:#f8fafc;border-bottom:2px solid #e2e8f0;">
        <h5 style="color:#1e293b;"><i class="fas fa-table me-2 text-success"></i>Consolidated Revenue Summary</h5>
        <small class="text-muted">Approved payments only</small>
    </div>
    <div class="rev-card-body pt-3">
        <table class="breakdown-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Registrations</th>
                    <th>KES Collected</th>
                    <th>USD Collected</th>
                    <th>KES Pending</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="tag" style="background:var(--lgreen);color:var(--dgreen);border:1px solid #86efac;">👤 Individual – Full Week</span></td>
                    <td>{{ $singleFullWeekCount }}</td>
                    <td class="amt">KES {{ number_format($singleFullWeekKES) }}</td>
                    <td class="amt">{{ ($singlePhysicalUSD + $singleVirtualUSD) > 0 ? 'USD '.number_format($singlePhysicalUSD + $singleVirtualUSD) : '—' }}</td>
                    <td style="color:var(--amber);">KES {{ number_format($pendingSingleKES) }}</td>
                </tr>
                <tr>
                    <td><span class="tag" style="background:var(--lamber);color:#92400e;border:1px solid #fde68a;">🗓 Individual – Partial Days</span></td>
                    <td>{{ $singlePartialCount }}</td>
                    <td class="amt">KES {{ number_format($singlePartialKES) }}</td>
                    <td>—</td>
                    <td>—</td>
                </tr>
                <tr>
                    <td><span class="tag" style="background:var(--lblue);color:var(--blue);border:1px solid #93c5fd;">👥 Group</span></td>
                    <td>{{ $groupCount }} groups ({{ $groupMemberCount }} members)</td>
                    <td class="amt">KES {{ number_format($groupKES) }}</td>
                    <td class="amt">{{ $groupUSD > 0 ? 'USD '.number_format($groupUSD) : '—' }}</td>
                    <td style="color:var(--amber);">KES {{ number_format($pendingGroupKES) }}</td>
                </tr>
                <tr>
                    <td><span class="tag" style="background:var(--lpurple);color:var(--purple);border:1px solid #c4b5fd;">🏪 Exhibition</span></td>
                    <td>{{ $exhibitionCount }} booths</td>
                    <td class="amt">KES {{ number_format($exhibitionKES) }}</td>
                    <td>—</td>
                    <td style="color:var(--amber);">KES {{ number_format($pendingExhibitionKES) }}</td>
                </tr>
            </tbody>
            <tfoot style="background:#f0fdf4;border-top:3px solid #86efac;">
                <tr>
                    <td class="fw-bold" style="color:var(--dgreen);">GRAND TOTAL</td>
                    <td class="fw-bold">{{ $singleCount + $groupCount + $exhibitionCount }}</td>
                    <td class="fw-bold" style="color:var(--dgreen);font-size:1.05rem;">KES {{ number_format($grandTotalKES) }}</td>
                    <td class="fw-bold" style="color:var(--blue);">{{ $grandTotalUSD > 0 ? 'USD '.number_format($grandTotalUSD) : '—' }}</td>
                    <td class="fw-bold" style="color:var(--amber);">KES {{ number_format($pendingSingleKES + $pendingGroupKES + $pendingExhibitionKES) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- ══════════════════════════════════════
     RECENT APPROVED PAYMENTS
════════════════════════════════════════ --}}
<div class="rev-card">
    <div class="rev-card-header" style="background:#f8fafc;border-bottom:2px solid #e2e8f0;">
        <h5 style="color:#1e293b;"><i class="fas fa-clock me-2 text-success"></i>Recent Approved Payments</h5>
    </div>
    <div class="rev-card-body pt-2">
        <ul class="activity-list">

            @foreach($recentSingle as $r)
            <li class="activity-item">
                <div class="activity-dot ad-single"><i class="fas fa-user"></i></div>
                <div>
                    <div class="activity-name">{{ $r->first_name }} {{ $r->last_name }}</div>
                    <div class="activity-meta">
                        Individual
                        @if(($r->attendance_type ?? 'full_week') === 'partial')
                            &nbsp;·&nbsp; Partial – {{ $r->days_count }} day{{ $r->days_count != 1 ? 's' : '' }}
                        @else
                            &nbsp;·&nbsp; Full Week
                        @endif
                        &nbsp;·&nbsp; {{ $r->verified_at ? \Carbon\Carbon::parse($r->verified_at)->format('M d, Y H:i') : '—' }}
                    </div>
                </div>
                <div class="activity-amt">{{ $r->fee_currency }} {{ number_format($r->fee) }}</div>
            </li>
            @endforeach

            @foreach($recentGroup as $g)
            <li class="activity-item">
                <div class="activity-dot ad-group"><i class="fas fa-users"></i></div>
                <div>
                    <div class="activity-name">{{ $g->first_name }} {{ $g->last_name }}</div>
                    <div class="activity-meta">
                        Group &nbsp;·&nbsp; {{ $g->verified_at ? \Carbon\Carbon::parse($g->verified_at)->format('M d, Y H:i') : '—' }}
                    </div>
                </div>
                <div class="activity-amt">{{ $g->currency }} {{ number_format($g->total_fee) }}</div>
            </li>
            @endforeach

            @foreach($recentExhibition as $e)
            <li class="activity-item">
                <div class="activity-dot ad-exhibit"><i class="fas fa-store"></i></div>
                <div>
                    <div class="activity-name">{{ $e->organization_name }}</div>
                    <div class="activity-meta">
                        Exhibition &nbsp;·&nbsp; {{ $e->approved_at ? \Carbon\Carbon::parse($e->approved_at)->format('M d, Y H:i') : '—' }}
                    </div>
                </div>
                <div class="activity-amt">KES {{ number_format($e->total_amount) }}</div>
            </li>
            @endforeach

            @if($recentSingle->isEmpty() && $recentGroup->isEmpty() && $recentExhibition->isEmpty())
            <li class="activity-item">
                <p class="text-muted py-3 mb-0 w-100 text-center">No approved payments yet.</p>
            </li>
            @endif

        </ul>
    </div>
</div>

@endsection

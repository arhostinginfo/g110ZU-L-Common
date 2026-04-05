@extends('superadmin.layout.master-admin')

@section('content')

<style>
/* ══════════════════════════════════
   Dashboard — GP Summary
══════════════════════════════════ */

/* Section header */
.dash-section-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px;
    margin-bottom: 20px;
}
.dash-section-title {
    display: flex; align-items: center; gap: 10px;
}
.dash-section-title .section-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(26,115,232,0.3);
}
.dash-section-title h5 {
    margin: 0; font-size: 1.15rem; font-weight: 700; color: #1e293b;
}
.dash-section-title p {
    margin: 0; font-size: 0.78rem; color: #94a3b8;
}
.btn-view-all {
    background: #fff; border: 1.5px solid #1a73e8;
    color: #1a73e8; border-radius: 8px; padding: 7px 16px;
    font-size: 0.82rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: 5px;
    transition: all 0.18s; white-space: nowrap;
}
.btn-view-all:hover { background: #1a73e8; color: #fff; text-decoration: none; }

/* ── Stat cards ── */
.stat-card {
    border-radius: 14px; padding: 20px 22px;
    display: flex; align-items: center; gap: 16px;
    position: relative; overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    border: none; height: 100%;
}
.stat-card::after {
    content: ''; position: absolute;
    right: -18px; top: -18px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(255,255,255,0.12);
}
.stat-card:hover { transform: translateY(-3px); }
.stat-card .stat-icon {
    width: 52px; height: 52px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; flex-shrink: 0;
    background: rgba(255,255,255,0.22);
    color: #fff;
}
.stat-card .stat-val {
    font-size: 2rem; font-weight: 800; line-height: 1;
    color: #fff; letter-spacing: -0.03em;
}
.stat-card .stat-lbl {
    font-size: 0.8rem; color: rgba(255,255,255,0.82);
    margin-top: 4px; font-weight: 500;
}
.stat-card .stat-arrow {
    margin-left: auto; color: rgba(255,255,255,0.5);
    font-size: 1.1rem; flex-shrink: 0;
}

.sc-total    { background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%); box-shadow: 0 6px 20px rgba(26,115,232,0.3); }
.sc-active   { background: linear-gradient(135deg, #27ae60 0%, #1a7d45 100%); box-shadow: 0 6px 20px rgba(39,174,96,0.28); }
.sc-inactive { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 6px 20px rgba(245,158,11,0.28); }
.sc-expired  { background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); box-shadow: 0 6px 20px rgba(239,68,68,0.28); }

.stat-card-link { text-decoration: none !important; display: block; height: 100%; }
.stat-card-link:hover .stat-card { transform: translateY(-3px); }

/* ── Summary tabs card ── */
.summary-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #e8ecf3;
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06);
}
.summary-card-header {
    padding: 0 20px;
    background: #f8f9fb;
    border-bottom: 1px solid #eef0f5;
}
.summary-nav .nav-link {
    font-size: 0.85rem; font-weight: 600; color: #64748b;
    border-radius: 0; padding: 13px 20px;
    border: none; border-bottom: 3px solid transparent;
    transition: color 0.15s, border-color 0.15s;
}
.summary-nav .nav-link i { margin-right: 5px; font-size: 1rem; }
.summary-nav .nav-link:hover { color: #1a73e8; border-bottom-color: rgba(26,115,232,0.3); }
.summary-nav .nav-link.active { color: #1a73e8; border-bottom-color: #1a73e8; background: transparent; }

/* ── Summary table ── */
.summary-table { margin-bottom: 0; }
.summary-table thead th {
    background: #f1f5f9; color: #475569;
    font-size: 0.76rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.05em;
    padding: 11px 14px; white-space: nowrap;
    border-bottom: 2px solid #dde3ea !important;
}
.summary-table tbody td {
    font-size: 0.83rem; vertical-align: middle;
    padding: 10px 14px; color: #374151;
    border-bottom: 1px solid #f1f4f8 !important;
}
.summary-table tbody tr:last-child td { border-bottom: none !important; }
.summary-table tbody tr:hover { background: #f8faff; }
.summary-table tfoot td {
    font-size: 0.83rem; font-weight: 700;
    background: #f1f5f9; padding: 10px 14px;
    border-top: 2px solid #dde3ea !important;
}

/* ── Stat badges in table ── */
.sb { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.76rem; font-weight: 700; }
.sb-total    { background: #dbeafe; color: #1d4ed8; }
.sb-active   { background: #dcfce7; color: #166534; }
.sb-inactive { background: #fef3c7; color: #92400e; }
.sb-expired  { background: #fee2e2; color: #991b1b; }

/* ── Progress bar ── */
.pg-wrap { height: 7px; background: #e8ecf0; border-radius: 20px; overflow: hidden; min-width: 60px; }
.pg-fill  { height: 100%; background: linear-gradient(90deg, #27ae60, #1a7d45); border-radius: 20px; transition: width 0.5s ease; }
.pg-group { display: flex; align-items: center; gap: 8px; }
.pg-pct   { font-size: 0.76rem; font-weight: 700; color: #475569; white-space: nowrap; min-width: 32px; text-align: right; }

/* ── Responsive ── */
@media (max-width: 575px) {
    .stat-card { padding: 16px; gap: 12px; }
    .stat-card .stat-val { font-size: 1.6rem; }
    .stat-card .stat-icon { width: 44px; height: 44px; font-size: 1.25rem; }
    .dash-section-title h5 { font-size: 1rem; }
}
</style>

{{-- ════════════════════════════════════════
     GP Summary Section
════════════════════════════════════════ --}}
<div class="row">
    <div class="col-12">

        {{-- Section header --}}
        <div class="dash-section-header">
            <div class="dash-section-title">
                <div class="section-icon"><i class="mdi mdi-domain"></i></div>
                <div>
                    <h5>GP Summary</h5>
                    <p>Overview of all Gram Panchayats</p>
                </div>
            </div>
            <a href="{{ route('superadmin.admin-gp.list') }}" class="btn-view-all">
                <i class="mdi mdi-format-list-bulleted"></i> View All GPs
            </a>
        </div>

        {{-- Stat cards --}}
        <div class="row mb-4" style="row-gap: 16px;">

            <div class="col-6 col-md-3">
                <div class="stat-card sc-total">
                    <div class="stat-icon"><i class="mdi mdi-domain"></i></div>
                    <div>
                        <div class="stat-val">{{ $gpStats['total'] }}</div>
                        <div class="stat-lbl">Total GPs</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card sc-active">
                    <div class="stat-icon"><i class="mdi mdi-check-circle-outline"></i></div>
                    <div>
                        <div class="stat-val">{{ $gpStats['active'] }}</div>
                        <div class="stat-lbl">Active</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('superadmin.admin-gp.filter', 'inactive') }}" class="stat-card-link">
                    <div class="stat-card sc-inactive">
                        <div class="stat-icon"><i class="mdi mdi-pause-circle-outline"></i></div>
                        <div>
                            <div class="stat-val">{{ $gpStats['inactive'] }}</div>
                            <div class="stat-lbl">Inactive</div>
                        </div>
                        <i class="mdi mdi-arrow-right stat-arrow"></i>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a href="{{ route('superadmin.admin-gp.filter', 'expired') }}" class="stat-card-link">
                    <div class="stat-card sc-expired">
                        <div class="stat-icon"><i class="mdi mdi-calendar-remove-outline"></i></div>
                        <div>
                            <div class="stat-val">{{ $gpStats['expired'] }}</div>
                            <div class="stat-lbl">Expired</div>
                        </div>
                        <i class="mdi mdi-arrow-right stat-arrow"></i>
                    </div>
                </a>
            </div>

        </div>

        {{-- District / Taluka tabs --}}
        <div class="summary-card">
            <div class="summary-card-header">
                <ul class="nav summary-nav border-0" id="summaryTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#districtPane" role="tab">
                            <i class="mdi mdi-map-marker-multiple"></i> District-wise
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#talukaPane" role="tab">
                            <i class="mdi mdi-map-outline"></i> Taluka-wise
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">

                {{-- District-wise pane --}}
                <div class="tab-pane fade show active" id="districtPane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table summary-table">
                            <thead>
                                <tr>
                                    <th style="width:42px;">#</th>
                                    <th>District</th>
                                    <th>Total</th>
                                    <th>Active</th>
                                    <th>Inactive</th>
                                    <th>Expired</th>
                                    <th style="min-width:140px;">Active %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gpDistrictStats as $i => $row)
                                    @php $pct = $row['total'] > 0 ? round(($row['active'] / $row['total']) * 100) : 0; @endphp
                                    <tr>
                                        <td style="color:#94a3b8; font-weight:600; font-size:0.78rem;">{{ $i + 1 }}</td>
                                        <td><strong style="color:#1e293b;">{{ $row['district'] }}</strong></td>
                                        <td><span class="sb sb-total">{{ $row['total'] }}</span></td>
                                        <td><span class="sb sb-active">{{ $row['active'] }}</span></td>
                                        <td><span class="sb sb-inactive">{{ $row['inactive'] }}</span></td>
                                        <td><span class="sb sb-expired">{{ $row['expired'] }}</span></td>
                                        <td>
                                            <div class="pg-group">
                                                <div class="pg-wrap flex-grow-1">
                                                    <div class="pg-fill" style="width:{{ $pct }}%;"></div>
                                                </div>
                                                <span class="pg-pct">{{ $pct }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted py-4">No data available</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="font-weight:700; color:#1e293b;">Total</td>
                                    <td><span class="sb sb-total">{{ $gpStats['total'] }}</span></td>
                                    <td><span class="sb sb-active">{{ $gpStats['active'] }}</span></td>
                                    <td><span class="sb sb-inactive">{{ $gpStats['inactive'] }}</span></td>
                                    <td><span class="sb sb-expired">{{ $gpStats['expired'] }}</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Taluka-wise pane --}}
                <div class="tab-pane fade" id="talukaPane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table summary-table">
                            <thead>
                                <tr>
                                    <th style="width:42px;">#</th>
                                    <th>District</th>
                                    <th>Taluka</th>
                                    <th>Total</th>
                                    <th>Active</th>
                                    <th>Inactive</th>
                                    <th>Expired</th>
                                    <th style="min-width:140px;">Active %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gpTalukaStats as $i => $row)
                                    @php $pct = $row['total'] > 0 ? round(($row['active'] / $row['total']) * 100) : 0; @endphp
                                    <tr>
                                        <td style="color:#94a3b8; font-weight:600; font-size:0.78rem;">{{ $i + 1 }}</td>
                                        <td style="color:#64748b; font-size:0.82rem;">{{ $row['district'] }}</td>
                                        <td><strong style="color:#1e293b;">{{ $row['taluka'] }}</strong></td>
                                        <td><span class="sb sb-total">{{ $row['total'] }}</span></td>
                                        <td><span class="sb sb-active">{{ $row['active'] }}</span></td>
                                        <td><span class="sb sb-inactive">{{ $row['inactive'] }}</span></td>
                                        <td><span class="sb sb-expired">{{ $row['expired'] }}</span></td>
                                        <td>
                                            <div class="pg-group">
                                                <div class="pg-wrap flex-grow-1">
                                                    <div class="pg-fill" style="width:{{ $pct }}%;"></div>
                                                </div>
                                                <span class="pg-pct">{{ $pct }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted py-4">No data available</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="font-weight:700; color:#1e293b;">Total</td>
                                    <td><span class="sb sb-total">{{ $gpStats['total'] }}</span></td>
                                    <td><span class="sb sb-active">{{ $gpStats['active'] }}</span></td>
                                    <td><span class="sb sb-inactive">{{ $gpStats['inactive'] }}</span></td>
                                    <td><span class="sb sb-expired">{{ $gpStats['expired'] }}</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        {{-- end summary card --}}

    </div>
</div>

@endsection

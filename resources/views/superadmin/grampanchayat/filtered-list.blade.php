@extends('superadmin.layout.master-admin')

@section('title', $label)

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
/* ── Banner ── */
.filter-banner {
    display: flex; align-items: center; flex-wrap: wrap; gap: 12px;
    padding: 16px 22px; border-radius: 12px; margin-bottom: 22px;
    font-weight: 700; font-size: 0.95rem;
}
.filter-banner .banner-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; flex-shrink: 0;
}
.filter-banner .banner-text { flex: 1; }
.filter-banner .banner-text small { display: block; font-size: 0.78rem; font-weight: 500; opacity: 0.75; margin-top: 1px; }
.banner-inactive { background: linear-gradient(135deg, #fff7ed, #ffedd5); border: 1.5px solid #fed7aa; color: #92400e; }
.banner-inactive .banner-icon { background: #f59e0b; color: #fff; }
.banner-expired  { background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 1.5px solid #fecaca; color: #991b1b; }
.banner-expired  .banner-icon { background: #ef4444; color: #fff; }
.btn-back-banner {
    display: inline-flex; align-items: center; gap: 5px;
    border: 1.5px solid currentColor; border-radius: 8px;
    padding: 7px 14px; font-size: 0.82rem; font-weight: 600;
    opacity: 0.75; transition: opacity 0.18s; color: inherit; white-space: nowrap;
}
.btn-back-banner:hover { opacity: 1; text-decoration: none; color: inherit; }

/* ── Table card ── */
.table-card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf0; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
.table-card-header {
    padding: 14px 20px; border-bottom: 1px solid #eef0f3; background: #f8f9fb;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;
}

/* ── DataTable ── */
#filteredTable { border-collapse: collapse !important; }
#filteredTable thead th {
    background: #f1f4f8 !important; color: #374151;
    font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.04em; padding: 11px 12px;
    border-bottom: 2px solid #dde3ea !important; white-space: nowrap;
}
#filteredTable tbody tr:hover { background: #f5f8ff !important; }
#filteredTable tbody td { font-size: 0.84rem; vertical-align: middle; padding: 10px 12px; color: #374151; border-bottom: 1px solid #f0f2f5 !important; }
#filteredTable tbody tr:last-child td { border-bottom: none !important; }

.gp-url-pill { display: inline-block; background: #e8f0fe; color: #1a73e8; border-radius: 6px; padding: 2px 8px; font-size: 0.8rem; font-weight: 700; }
.cred-block { font-size: 0.79rem; line-height: 1.8; color: #555; }
.cred-block .cred-row { display: flex; align-items: baseline; gap: 4px; }
.cred-block .cred-lbl { font-weight: 700; color: #374151; min-width: 38px; }

.days-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.77rem; font-weight: 700; }
.days-expired { background: #fde8e8; color: #c0392b; }
.days-warning { background: #fef3cd; color: #856404; }
.days-ok      { background: #dcfce7; color: #166534; }
.date-expired { color: #c0392b; font-weight: 700; }
.date-warning { color: #856404; font-weight: 600; }

.toggle-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #cbd5e1; border-radius: 24px; transition: 0.25s; }
.toggle-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.25s; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
input:checked + .toggle-slider { background: #27ae60; }
input:checked + .toggle-slider:before { transform: translateX(24px); }
.status-tag { font-size: 0.72rem; font-weight: 700; display: block; margin-top: 3px; }

.action-group { display: flex; flex-wrap: wrap; gap: 4px; }
.btn-action { font-size: 0.76rem; padding: 4px 9px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 3px; white-space: nowrap; transition: all 0.15s; }
.btn-action i { font-size: 0.85rem; }

.empty-state { padding: 60px 20px; text-align: center; color: #94a3b8; }
.empty-state i { font-size: 3rem; display: block; margin-bottom: 12px; }
.empty-state p { font-size: 0.92rem; font-weight: 500; margin: 0; }
</style>

{{-- Banner --}}
<div class="filter-banner banner-{{ $type }}">
    <div class="banner-icon">
        @if($type === 'inactive')
            <i class="mdi mdi-pause-circle-outline"></i>
        @else
            <i class="mdi mdi-calendar-remove-outline"></i>
        @endif
    </div>
    <div class="banner-text">
        {{ $label }}
        <small>{{ $filtered->count() }} record(s) found</small>
    </div>
    <a href="{{ route('superadmin.admin-gp.list') }}" class="btn-back-banner">
        <i class="mdi mdi-arrow-left"></i> All GPs
    </a>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-card-header">
        <span style="font-size:0.85rem; font-weight:600; color:#374151;">
            <i class="mdi mdi-table-large mr-1" style="color:{{ $type === 'inactive' ? '#f59e0b' : '#ef4444' }};"></i>
            <strong>{{ $filtered->count() }}</strong> {{ strtolower($label) }}
        </span>
        <span style="font-size:0.78rem; color:#aaa;">Scroll horizontally on small screens</span>
    </div>

    @if($filtered->isEmpty())
        <div class="empty-state">
            <i class="mdi mdi-check-circle-outline" style="color:#27ae60;"></i>
            <p>No {{ strtolower($label) }} found. Everything looks good!</p>
        </div>
    @else
    <div class="table-responsive">
        <table id="filteredTable" class="table table-hover mb-0" style="width:100%;">
            <thead>
                <tr>
                    <th style="width:42px;">#</th>
                    <th>District</th>
                    <th>Taluka</th>
                    <th>GP URL Name</th>
                    <th>Navbar Name</th>
                    <th>GP Name</th>
                    <th>Credentials</th>
                    <th>Valid Till</th>
                    <th>Days Left</th>
                    <th>Status</th>
                    <th style="min-width:170px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filtered as $i => $gp)
                    @php
                        $daysLeft  = $gp->days_pending;
                        $validTill = \Carbon\Carbon::parse($gp->gp_valid_till);
                        $isExpired = $gp->is_expired;
                        $isWarning = !$isExpired && $daysLeft <= 30;
                        $dayClass  = $isExpired ? 'days-expired' : ($isWarning ? 'days-warning' : 'days-ok');
                        $dateClass = $isExpired ? 'date-expired' : ($isWarning ? 'date-warning' : '');
                        $copyText  = "GP Website Link: " . env('APP_URL') . $gp->gp_name_in_url . "\n"
                                   . "GP Admin Login: " . env('APP_URL') . "login\n"
                                   . "Username: " . $gp->employee_email . "\n"
                                   . "Password: " . $gp->employee_password;
                    @endphp
                    <tr>
                        <td style="color:#aaa; font-size:0.78rem; font-weight:600;">{{ $i + 1 }}</td>
                        <td style="font-size:0.83rem;">{{ $gp->district_name ?? '—' }}</td>
                        <td style="font-size:0.83rem;">{{ $gp->taluka_name ?? '—' }}</td>
                        <td><span class="gp-url-pill">{{ $gp->gp_name_in_url }}</span></td>
                        <td style="font-size:0.83rem;">{{ $gp->name ?? '—' }}</td>
                        <td style="font-size:0.83rem; font-weight:600;">{{ $gp->gp_name }}</td>

                        <td>
                            <div class="cred-block">
                                <div class="cred-row"><span class="cred-lbl">Email</span><span>{{ $gp->employee_email }}</span></div>
                                <div class="cred-row"><span class="cred-lbl">Pass</span><span>{{ $gp->employee_password }}</span></div>
                            </div>
                            <button class="btn btn-action btn-outline-secondary copy-btn mt-1" data-copy="{{ $copyText }}">
                                <i class="mdi mdi-content-copy"></i> Copy
                            </button>
                        </td>

                        <td>
                            <span class="{{ $dateClass }}" style="font-size:0.83rem;">{{ $validTill->format('d-m-Y') }}</span>
                            @if($isExpired)
                                <br><span class="days-badge days-expired" style="margin-top:3px; display:inline-block; font-size:0.7rem; padding:1px 7px;">Expired</span>
                            @endif
                        </td>

                        <td><span class="days-badge {{ $dayClass }}">{{ $isExpired ? '0' : $daysLeft }} days</span></td>

                        <td style="min-width:80px;">
                            <form action="{{ route('superadmin.admin-gp.updatestatus') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="encodedId" value="{{ base64_encode($gp->id) }}">
                                <label class="toggle-switch" title="{{ $gp->is_active ? 'Click to Deactivate' : 'Click to Activate' }}">
                                    <input type="checkbox" class="status-toggle-cb"
                                        data-name="{{ $gp->gp_name_in_url }}"
                                        data-active="{{ (int)$gp->is_active }}"
                                        {{ (int)$gp->is_active === 1 ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </form>
                            <span class="status-tag" style="color:{{ (int)$gp->is_active === 1 ? '#27ae60' : '#94a3b8' }};">
                                {{ (int)$gp->is_active === 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td>
                            <div class="action-group">
                                <form action="{{ route('superadmin.supergpautologin') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="gp_id" value="{{ $gp->id }}">
                                    <button type="submit" class="btn btn-action btn-outline-info" title="Login as GP Admin">
                                        <i class="mdi mdi-login"></i> Login
                                    </button>
                                </form>
                                <a href="{{ env('APP_URL') . $gp->gp_name_in_url }}" target="_blank" class="btn btn-action btn-outline-secondary">
                                    <i class="mdi mdi-web"></i> Site
                                </a>
                                <a href="{{ route('superadmin.admin-gp.edit', base64_encode($gp->id)) }}" class="btn btn-action btn-outline-primary">
                                    <i class="mdi mdi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('superadmin.admin-gp.delete') }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    <input type="hidden" name="encodedId" value="{{ base64_encode($gp->id) }}">
                                    <button type="submit" class="btn btn-action btn-outline-danger">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {

    @if(!$filtered->isEmpty())
    $('#filteredTable').DataTable({
        responsive: true, paging: true, scrollX: true,
        searching: true, lengthChange: true, pageLength: 25, ordering: true,
        columnDefs: [{ orderable: false, targets: [6, 9, 10] }]
    });
    @endif

    $(document).on('change', '.status-toggle-cb', function () {
        const cb = $(this), name = cb.data('name'), isActive = parseInt(cb.data('active'));
        if (confirm((isActive ? 'Deactivate' : 'Activate') + ' GP "' + name + '"?')) {
            cb.closest('form').submit();
        } else { cb.prop('checked', isActive === 1); }
    });

    $(document).on('submit', '.delete-form', function (e) {
        if (!confirm('Delete this GP? This cannot be undone.')) e.preventDefault();
    });

    $(document).on('click', '.copy-btn', function () { copyToClipboard($(this).data('copy'), this); });
});

function copyToClipboard(text, btn) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => flashBtn(btn));
    } else {
        const ta = document.createElement('textarea');
        ta.value = text; ta.style.cssText = 'position:fixed;opacity:0;';
        document.body.appendChild(ta); ta.focus(); ta.select();
        try { document.execCommand('copy'); flashBtn(btn); } catch(e) {}
        document.body.removeChild(ta);
    }
}
function flashBtn(btn) {
    const orig = $(btn).html();
    $(btn).html('<i class="mdi mdi-check"></i> Copied!').addClass('btn-success').removeClass('btn-outline-secondary');
    setTimeout(() => { $(btn).html(orig).removeClass('btn-success').addClass('btn-outline-secondary'); }, 2000);
}
</script>

@endsection

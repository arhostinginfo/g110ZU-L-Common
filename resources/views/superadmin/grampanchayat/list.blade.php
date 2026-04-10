@extends('superadmin.layout.master-admin')

@section('title', 'GP Details')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
/* ── Page title bar ── */
.gp-page-title {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
    padding: 18px 24px;
    background: transparent;
    border-radius: 12px;
    margin-bottom: 24px;
}
.gp-page-title h3 {
    margin: 0; color: #0D3D47; font-size: 1.35rem; font-weight: 700;
    display: flex; align-items: center; gap: 8px;
}
.gp-page-title h3 i { font-size: 1.5rem; color: #00BFC5; }
.gp-page-title .title-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.gp-page-title .btn-title {
    border: 1.5px solid #0F5C7B;
    color: #0F5C7B; background: transparent;
    border-radius: 8px; padding: 6px 14px;
    font-size: 0.82rem; font-weight: 600;
    transition: background 0.2s, border-color 0.2s;
    white-space: nowrap;
}
.gp-page-title .btn-title:hover { background: #0F5C7B; color: #fff; text-decoration: none; }
.gp-page-title .btn-title-primary { background: #0F5C7B; color: #fff; border-color: #0F5C7B; }
.gp-page-title .btn-title-primary:hover { background: #0D3D47; border-color: #0D3D47; color: #fff; }

/* ── Filter card ── */
.filter-card {
    background: #fff; border-radius: 10px;
    border: 1px solid #e8ecf0;
    padding: 16px 20px; margin-bottom: 20px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
}
.filter-card .filter-title {
    font-size: 0.78rem; font-weight: 700; color: #374151 !important;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 12px; display: flex; align-items: center; gap: 6px;
}
.filter-card label { font-size: 0.82rem !important; font-weight: 600 !important; color: #1a73e8 !important; margin-bottom: 4px !important; }
.filter-card .form-control {
    border-radius: 7px; border: 1.5px solid #dce3ea;
    font-size: 0.85rem; color: #1e293b !important;
    height: 44px !important; padding: 10px 13px !important;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.filter-card .form-control:focus { border-color: #1a73e8; box-shadow: 0 0 0 3px rgba(26,115,232,0.1); }

/* ── Table card ── */
.table-card {
    background: #fff; border-radius: 12px;
    border: 1px solid #e8ecf0;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.table-card .table-card-header {
    padding: 14px 20px; border-bottom: 1px solid #eef0f3;
    background: #f8f9fb;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;
}
.table-card .table-card-header span {
    font-size: 0.82rem; color: #888; font-weight: 500;
}

/* ── DataTable overrides ── */
#gpTable { border-collapse: collapse !important; }
#gpTable thead th {
    background: #f1f4f8 !important; color: #374151;
    font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.04em; padding: 11px 12px;
    border-bottom: 2px solid #dde3ea !important;
    white-space: nowrap;
}
#gpTable tbody tr { transition: background 0.15s; }
#gpTable tbody tr:hover { background: #f5f8ff !important; }
#gpTable tbody td { font-size: 0.84rem; vertical-align: middle; padding: 10px 12px; color: #374151; border-bottom: 1px solid #f0f2f5 !important; }
#gpTable tbody tr:last-child td { border-bottom: none !important; }

/* ── GP name pill ── */
.gp-url-pill {
    display: inline-block;
    background: #e8f0fe; color: #1a73e8;
    border-radius: 6px; padding: 2px 8px;
    font-size: 0.8rem; font-weight: 700;
}

/* ── Credential block ── */
.cred-block { font-size: 0.79rem; line-height: 1.8; color: #555; }
.cred-block .cred-row { display: flex; align-items: baseline; gap: 4px; }
.cred-block .cred-lbl { font-weight: 700; color: #374151; min-width: 38px; }

/* ── Days / date badges ── */
.days-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.77rem; font-weight: 700; }
.days-expired { background: #fde8e8; color: #c0392b; }
.days-warning { background: #fef3cd; color: #856404; }
.days-ok      { background: #dcfce7; color: #166534; }
.date-expired { color: #c0392b; font-weight: 700; }
.date-warning { color: #856404; font-weight: 600; }
.date-ok      { color: #374151; }

/* ── Status tag ── */
.status-tag { font-size: 0.72rem; font-weight: 700; display: block; margin-top: 3px; }

/* ── Toggle switch ── */
.toggle-switch { position: relative; display: inline-block; width: 48px; height: 24px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute; cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #cbd5e1; border-radius: 24px; transition: 0.25s;
}
.toggle-slider:before {
    position: absolute; content: "";
    height: 18px; width: 18px; left: 3px; bottom: 3px;
    background: white; border-radius: 50%; transition: 0.25s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
}
input:checked + .toggle-slider { background: #27ae60; }
input:checked + .toggle-slider:before { transform: translateX(24px); }

/* ── Action buttons ── */
.action-group { display: flex; flex-wrap: wrap; gap: 4px; }
.btn-action {
    font-size: 0.76rem; padding: 4px 9px;
    border-radius: 6px; font-weight: 600;
    display: inline-flex; align-items: center; gap: 3px;
    white-space: nowrap; transition: all 0.15s;
}
.btn-action i { font-size: 0.85rem; }

/* ── Floating alert ── */
.alert-float {
    position: fixed; top: 80px; right: 20px; z-index: 9999;
    min-width: 280px; max-width: 380px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.13); border-radius: 10px;
    animation: slideInAlert 0.3s ease;
}
@keyframes slideInAlert {
    from { opacity: 0; transform: translateX(50px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* ── Responsive tweaks ── */
@media (max-width: 575px) {
    .gp-page-title { padding: 14px 16px; }
    .gp-page-title h3 { font-size: 1.1rem; }
    .gp-page-title .btn-title { padding: 5px 10px; font-size: 0.78rem; }
    .filter-card { padding: 12px 14px; }
}
</style>

{{-- Flash --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible alert-float" role="alert">
    <i class="mdi mdi-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

{{-- Page title bar --}}
<div class="gp-page-title">
    <h3><i class="mdi mdi-domain"></i> GP Details</h3>
    <div class="title-actions">
        <button class="btn-title" onclick="copyTableToClipboard()">
            <i class="mdi mdi-content-copy"></i> Copy
        </button>
        <a href="{{ route('superadmin.admin-gp.export') }}" class="btn-title">
            <i class="mdi mdi-file-excel"></i> Export CSV
        </a>
        <a href="{{ route('superadmin.admin-gp.add') }}" class="btn-title btn-title-primary">
            <i class="mdi mdi-plus"></i> Add GP
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="filter-card">
    <div class="filter-title"><i class="mdi mdi-filter-variant"></i> Filter Records</div>
    <div class="row align-items-end">
        <div class="col-12 col-sm-6 col-lg-4 mb-2">
            <label>District</label>
            <select id="filterDistrict" class="form-control form-control-sm">
                <option value="">All Districts</option>
                @foreach($districts as $d)
                    <option value="{{ $d->district_name }}">{{ $d->district_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 mb-2">
            <label>Taluka</label>
            <select id="filterTaluka" class="form-control form-control-sm">
                <option value="">All Talukas</option>
                @foreach($talukas as $t)
                    <option value="{{ $t->taluka_name }}"
                        data-district-name="{{ $t->district->district_name ?? '' }}">
                        {{ $t->taluka_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-4 col-lg-2 mb-2">
            <button id="clearFilters" class="btn btn-sm btn-outline-secondary w-100" style="border-radius:7px; font-weight:600;">
                <i class="mdi mdi-close"></i> Clear
            </button>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-card-header">
        <span id="rowCountLabel" class="font-weight-600" style="color:#374151; font-size:0.85rem;">
            <i class="mdi mdi-table-large mr-1" style="color:#1a73e8;"></i>
            <strong>{{ $gpdetails->count() }}</strong> records
        </span>
        <span style="font-size:0.78rem; color:#aaa;">Scroll horizontally on small screens</span>
    </div>
    <table id="gpTable" class="table table-hover mb-0" style="width:100%;">
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
                @foreach ($gpdetails as $i => $gp)
                    @php
                        $daysLeft  = $gp->days_pending;
                        $validTill = \Carbon\Carbon::parse($gp->gp_valid_till);
                        $isExpired = $gp->is_expired;
                        $isWarning = !$isExpired && $daysLeft <= 30;
                        $dayClass  = $isExpired ? 'days-expired' : ($isWarning ? 'days-warning' : 'days-ok');
                        $dateClass = $isExpired ? 'date-expired' : ($isWarning ? 'date-warning' : 'date-ok');
                        $copyText  = "GP Website Link: " . env('APP_URL') . $gp->gp_name_in_url . "\n"
                                   . "GP Admin Login: " . env('APP_URL') . "login\n"
                                   . "Username: " . $gp->employee_email . "\n"
                                   . "Password: " . $gp->employee_password;
                    @endphp
                    <tr>
                        <td style="color:#aaa; font-size:0.78rem; font-weight:600;">{{ $i + 1 }}</td>
                        <td>
                            <span style="font-size:0.83rem; color:#374151;">{{ $gp->district_name ?? '—' }}</span>
                        </td>
                        <td>
                            <span style="font-size:0.83rem; color:#374151;">{{ $gp->taluka_name ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="gp-url-pill">{{ $gp->gp_name_in_url }}</span>
                        </td>
                        <td style="font-size:0.83rem; color:#374151;">{{ $gp->name ?? '—' }}</td>
                        <td style="font-size:0.83rem; color:#374151; font-weight:600;">{{ $gp->gp_name }}</td>

                        {{-- Credentials --}}
                        <td>
                            <div class="cred-block">
                                <div class="cred-row"><span class="cred-lbl">Email</span><span>{{ $gp->employee_email }}</span></div>
                                <div class="cred-row"><span class="cred-lbl">Pass</span><span>{{ $gp->employee_password }}</span></div>
                            </div>
                            <button class="btn btn-action btn-outline-secondary copy-btn mt-1" data-copy="{{ $copyText }}">
                                <i class="mdi mdi-content-copy"></i> Copy
                            </button>
                        </td>

                        {{-- Valid Till --}}
                        <td>
                            <span class="{{ $dateClass }}" style="font-size:0.83rem;">{{ $validTill->format('d-m-Y') }}</span>
                            @if($isExpired)
                                <br><span class="days-badge days-expired" style="margin-top:3px; display:inline-block; font-size:0.7rem; padding:1px 7px;">Expired</span>
                            @endif
                        </td>

                        {{-- Days Left --}}
                        <td>
                            <span class="days-badge {{ $dayClass }}">
                                {{ $isExpired ? '0' : $daysLeft }} days
                            </span>
                        </td>

                        {{-- Status Toggle --}}
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

                        {{-- Actions --}}
                        <td>
                            <div class="action-group">
                                <form action="{{ route('superadmin.supergpautologin') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="gp_id" value="{{ $gp->id }}">
                                    <button type="submit" class="btn btn-action btn-outline-info" title="Login as GP Admin">
                                        <i class="mdi mdi-login"></i> Login
                                    </button>
                                </form>
                                <a href="{{ env('APP_URL') . $gp->gp_name_in_url }}" target="_blank"
                                    class="btn btn-action btn-outline-secondary" title="View Website">
                                    <i class="mdi mdi-web"></i> Site
                                </a>
                                <a href="{{ route('superadmin.admin-gp.edit', base64_encode($gp->id)) }}"
                                    class="btn btn-action btn-outline-primary">
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

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {

    var table = $('#gpTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        lengthChange: true,
        pageLength: 25,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: [6, 9, 10] },
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 5 },
            { responsivePriority: 3, targets: 10 },
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/en-GB.json" },
        drawCallback: function () {
            var info = this.api().page.info();
            $('#rowCountLabel').html('<i class="mdi mdi-table-large mr-1" style="color:#1a73e8;"></i><strong>' + info.recordsDisplay + '</strong> of ' + info.recordsTotal + ' records');
        }
    });

    // District filter
    $('#filterDistrict').on('change', function () {
        var selected = $(this).val();
        table.column(1).search(selected, false, false).draw();
        table.column(2).search('', false, false).draw();
        var $taluka = $('#filterTaluka');
        $taluka.val('');
        $taluka.find('option').each(function () {
            if (!$(this).val()) return;
            var dn = $(this).data('district-name');
            $(this).toggle(!selected || dn === selected);
        });
    });

    // Taluka filter
    $('#filterTaluka').on('change', function () {
        table.column(2).search($(this).val(), false, false).draw();
    });

    // Clear filters
    $('#clearFilters').on('click', function () {
        $('#filterDistrict').val('');
        $('#filterTaluka').val('').find('option').show();
        table.column(1).search('').column(2).search('').draw();
    });

    // Status toggle
    $(document).on('change', '.status-toggle-cb', function () {
        const cb = $(this), name = cb.data('name'), isActive = parseInt(cb.data('active'));
        if (confirm((isActive ? 'Deactivate' : 'Activate') + ' GP "' + name + '"?')) {
            cb.closest('form').submit();
        } else {
            cb.prop('checked', isActive === 1);
        }
    });

    // Delete confirm
    $(document).on('submit', '.delete-form', function (e) {
        if (!confirm('Delete this GP? This cannot be undone.')) e.preventDefault();
    });

    // Copy credentials
    $(document).on('click', '.copy-btn', function () {
        copyToClipboard($(this).data('copy'), this);
    });

    setTimeout(() => { $('.alert-float').fadeOut(400); }, 4000);
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

function copyTableToClipboard() {
    const dt = $('#gpTable').DataTable();
    const headers = dt.columns().header().toArray().map(th => th.innerText.trim());
    let text = headers.join('\t') + '\n';
    dt.rows({ search: 'applied' }).data().each(row => {
        text += row.map(col => col.toString().replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim()).join('\t') + '\n';
    });
    copyToClipboard(text, document.querySelector('[onclick="copyTableToClipboard()"]'));
}
</script>

@endsection

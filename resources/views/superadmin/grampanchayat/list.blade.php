@extends('superadmin.layout.master-admin')

@section('title', 'GP Details')

@section('content')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .page-header h3 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

        /* Toggle Switch */
        .toggle-switch { position: relative; display: inline-block; width: 52px; height: 26px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #ccc;
            border-radius: 26px;
            transition: 0.3s;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px; width: 20px;
            left: 3px; bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }
        input:checked + .toggle-slider { background: #27ae60; }
        input:checked + .toggle-slider:before { transform: translateX(26px); }

        /* Days badge */
        .days-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .days-expired  { background: #fde8e8; color: #c0392b; }
        .days-warning  { background: #fef3cd; color: #856404; }
        .days-ok       { background: #d4edda; color: #155724; }

        /* Valid Till */
        .date-expired { color: #c0392b; font-weight: 600; }
        .date-warning { color: #856404; font-weight: 600; }

        /* GP Info box */
        .gp-info-block { font-size: 0.8rem; line-height: 1.7; }
        .gp-info-block strong { color: #555; }

        /* Action buttons */
        .action-group { display: flex; gap: 4px; flex-wrap: wrap; align-items: center; }

        /* Table tweaks */
        #gpTable th { white-space: nowrap; background: #f8f9fa; font-size: 0.82rem; }
        #gpTable td { font-size: 0.85rem; vertical-align: middle; }

        /* Alert */
        .alert-float {
            position: fixed; top: 80px; right: 20px; z-index: 9999;
            min-width: 280px; max-width: 380px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            border-radius: 10px;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible alert-float" role="alert">
            <strong>✓</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="page-header">
                        <h3><i class="mdi mdi-domain mr-1"></i> GP Details</h3>
                        <div class="header-actions">
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyTableToClipboard()">
                                <i class="mdi mdi-content-copy"></i> Copy to Excel
                            </button>
                            <a href="{{ route('superadmin.admin-gp.export') }}" class="btn btn-sm btn-outline-success">
                                <i class="mdi mdi-file-excel"></i> Export Excel
                            </a>
                            <a href="{{ route('superadmin.admin-gp.add') }}" class="btn btn-sm btn-primary">
                                <i class="mdi mdi-plus"></i> Add GP
                            </a>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="row mb-3 align-items-end">
                        <div class="col-md-4 col-sm-6 mb-2">
                            <label class="form-label" style="font-size:0.85rem; font-weight:600; color:#555;">District</label>
                            <select id="filterDistrict" class="form-control form-control-sm">
                                <option value="">-- All Districts --</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->district_name }}">{{ $district->district_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-2">
                            <label class="form-label" style="font-size:0.85rem; font-weight:600; color:#555;">Taluka</label>
                            <select id="filterTaluka" class="form-control form-control-sm">
                                <option value="">-- All Talukas --</option>
                                @foreach($talukas as $taluka)
                                    <option value="{{ $taluka->taluka_name }}"
                                        data-district="{{ $taluka->district_id }}"
                                        data-district-name="{{ $taluka->district->district_name ?? '' }}">
                                        {{ $taluka->taluka_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-2">
                            <button id="clearFilters" class="btn btn-sm btn-outline-secondary w-100">
                                <i class="mdi mdi-close"></i> Clear
                            </button>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table id="gpTable" class="table table-bordered table-hover" style="min-width: 1100px; width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>District</th>
                                    <th>Taluka</th>
                                    <th>GP Name In URL</th>
                                    <th>GP Name</th>
                                    <th>GP Name</th>
                                    <th>GP Name In URL</th>
                                    <th>Credentials</th>
                                    <th>Valid Till</th>
                                    <th>Days Left</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gpdetails as $i => $gp)
                                    @php
                                        $daysLeft    = $gp->days_pending;
                                        $validTill   = \Carbon\Carbon::parse($gp->gp_valid_till);
                                        $isExpired   = \Carbon\Carbon::today()->gt($validTill->startOfDay());
                                        $isWarning   = !$isExpired && $daysLeft <= 30;
                                        $dayClass    = $isExpired ? 'days-expired' : ($isWarning ? 'days-warning' : 'days-ok');
                                        $dateClass   = $isExpired ? 'date-expired' : ($isWarning ? 'date-warning' : '');
                                        $copyText    = "GP Website Link: " . env('APP_URL') . $gp->gp_name_in_url . "\n"
                                                     . "GP Admin Login: " . env('APP_URL') . "login\n"
                                                     . "Username: " . $gp->employee_email . "\n"
                                                     . "Password: " . $gp->employee_password;
                                    @endphp
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $gp->district_name }}</td>
                                        <td>{{ $gp->taluka_name }}</td>
                                        <td>
                                            <span style="font-weight:600; color:#2c3e50;">{{ $gp->gp_name_in_url }}</span>
                                        </td>
                                        <td>{{ $gp->name ?? $gp->gp_name }}</td>
                                        <td>{{ $gp->gp_name }}</td>
                                        <td>{{ $gp->gp_name_in_url }}</td>

                                        {{-- Credentials --}}
                                        <td>
                                            <div class="gp-info-block">
                                                <strong>Email:</strong> {{ $gp->employee_email }}<br>
                                                <strong>Pass:</strong> {{ $gp->employee_password }}
                                            </div>
                                            <button class="btn btn-xs btn-outline-secondary mt-1 copy-btn"
                                                style="font-size:0.75rem; padding:2px 8px;"
                                                data-copy="{{ $copyText }}">
                                                <i class="mdi mdi-content-copy"></i> Copy
                                            </button>
                                        </td>

                                        {{-- Valid Till --}}
                                        <td class="{{ $dateClass }}">
                                            {{ $validTill->format('d-m-Y') }}
                                            @if($isExpired)
                                                <br><small style="font-size:0.72rem; color:#c0392b;">Expired</small>
                                            @endif
                                        </td>

                                        {{-- Days Left --}}
                                        <td>
                                            <span class="days-badge {{ $dayClass }}">
                                                {{ $isExpired ? '0' : $daysLeft }} days
                                            </span>
                                        </td>

                                        {{-- Status Toggle --}}
                                        <td>
                                            <form action="{{ route('superadmin.admin-gp.updatestatus') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="encodedId" value="{{ base64_encode($gp->id) }}">
                                                <label class="toggle-switch" title="{{ $gp->is_active ? 'Click to Deactivate' : 'Click to Activate' }}">
                                                    <input type="checkbox"
                                                        class="status-toggle-cb"
                                                        data-name="{{ $gp->gp_name_in_url }}"
                                                        data-active="{{ (int)$gp->is_active }}"
                                                        {{ (int)$gp->is_active === 1 ? 'checked' : '' }}>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </form>
                                            <small class="d-block mt-1" style="font-size:0.72rem; color:{{ (int)$gp->is_active === 1 ? '#27ae60' : '#999' }};">
                                                {{ (int)$gp->is_active === 1 ? 'Active' : 'Inactive' }}
                                            </small>
                                        </td>

                                        {{-- Actions --}}
                                        <td>
                                            <div class="action-group">
                                                {{-- GP Admin Login --}}
                                                <form action="{{ route('superadmin.supergpautologin') }}" method="POST" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="gp_id" value="{{ $gp->id }}">
                                                    <button type="submit" class="btn btn-xs btn-outline-info"
                                                        style="font-size:0.75rem; padding:3px 8px;"
                                                        title="Login as GP Admin">
                                                        <i class="mdi mdi-login"></i> Login
                                                    </button>
                                                </form>

                                                {{-- Website --}}
                                                <a href="{{ env('APP_URL') . $gp->gp_name_in_url }}" target="_blank"
                                                    class="btn btn-xs btn-outline-secondary"
                                                    style="font-size:0.75rem; padding:3px 8px;"
                                                    title="View Website">
                                                    <i class="mdi mdi-web"></i> Site
                                                </a>

                                                {{-- Edit --}}
                                                <a href="{{ route('superadmin.admin-gp.edit', base64_encode($gp->id)) }}"
                                                    class="btn btn-xs btn-outline-primary"
                                                    style="font-size:0.75rem; padding:3px 8px;">
                                                    <i class="mdi mdi-pencil"></i> Edit
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('superadmin.admin-gp.delete') }}" method="POST"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    <input type="hidden" name="encodedId" value="{{ base64_encode($gp->id) }}">
                                                    <button type="submit" class="btn btn-xs btn-outline-danger"
                                                        style="font-size:0.75rem; padding:3px 8px;">
                                                        <i class="mdi mdi-delete"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function () {

            var table = $('#gpTable').DataTable({
                responsive: true,
                paging: true,
                scrollX: true,
                searching: true,
                lengthChange: true,
                pageLength: 25,
                ordering: true,
                columnDefs: [
                    { orderable: false, targets: [7, 10, 11] }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/en-GB.json"
                }
            });

            // District filter — filters DataTable column 1 (District)
            $('#filterDistrict').on('change', function () {
                var selected = $(this).val();

                // Filter DataTable by district column
                table.column(1).search(selected, false, false).draw();

                // Reset taluka column filter
                table.column(2).search('', false, false).draw();

                // Update taluka dropdown options
                var $taluka = $('#filterTaluka');
                $taluka.val('');
                $taluka.find('option').each(function () {
                    if (!$(this).val()) return; // keep "All" option
                    var districtName = $(this).data('district-name');
                    if (!selected || districtName === selected) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Taluka filter — filters DataTable column 2 (Taluka)
            $('#filterTaluka').on('change', function () {
                var selected = $(this).val();
                table.column(2).search(selected, false, false).draw();
            });

            // Clear filters
            $('#clearFilters').on('click', function () {
                $('#filterDistrict').val('');
                $('#filterTaluka').val('');
                // Show all taluka options
                $('#filterTaluka option').show();
                table.column(1).search('').column(2).search('').draw();
            });

            // Status toggle — delegated so it works inside DataTables
            $(document).on('change', '.status-toggle-cb', function () {
                const cb       = $(this);
                const name     = cb.data('name');
                const isActive = parseInt(cb.data('active'));
                const action   = isActive ? 'Deactivate' : 'Activate';

                if (confirm(action + ' GP "' + name + '"?')) {
                    cb.closest('form').submit();
                } else {
                    // revert checkbox to original state
                    cb.prop('checked', isActive === 1);
                }
            });

            // Delete confirm — delegated
            $(document).on('submit', '.delete-form', function (e) {
                if (!confirm('Are you sure you want to delete this GP?')) {
                    e.preventDefault();
                }
            });

            // Copy credentials — delegated
            $(document).on('click', '.copy-btn', function () {
                copyToClipboard($(this).data('copy'), this);
            });

            // Auto-dismiss flash alert after 4s
            setTimeout(() => { $('.alert-float').fadeOut(400); }, 4000);
        });

        function copyToClipboard(text, btn) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => flashBtn(btn));
            } else {
                const ta = document.createElement('textarea');
                ta.value = text; ta.style.position = 'fixed'; ta.style.opacity = '0';
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

        // Copy full table to Excel
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

@extends('superadmin.layout.master-admin')

@section('title', 'Talukas')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
.gp-page-title {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; padding: 18px 0;
    margin-bottom: 20px;
}
.gp-page-title h3 { margin: 0; color: #0D3D47; font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 8px; }
.gp-page-title h3 i { color: #00BFC5; }
.btn-title { border: 1.5px solid #0F5C7B; color: #0F5C7B; background: transparent; border-radius: 8px; padding: 7px 16px; font-size: 0.83rem; font-weight: 600; transition: background 0.2s; white-space: nowrap; }
.btn-title:hover { background: #0F5C7B; color: #fff; text-decoration: none; }
.btn-title-primary { background: #0F5C7B; color: #fff; border-color: #0F5C7B; }
.btn-title-primary:hover { background: #0D3D47; border-color: #0D3D47; color: #fff; }

.table-card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf0; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
.table-card-header { padding: 14px 20px; border-bottom: 1px solid #eef0f3; background: #f8f9fb; }
.table-card-header span { font-size: 0.85rem; font-weight: 600; color: #374151; }

#talukaTable thead th { background: #f1f4f8 !important; color: #374151; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 11px 14px; border-bottom: 2px solid #dde3ea !important; white-space: nowrap; }
#talukaTable tbody tr:hover { background: #f5f8ff !important; }
#talukaTable tbody td { font-size: 0.84rem; vertical-align: middle; padding: 10px 14px; color: #374151; border-bottom: 1px solid #f0f2f5 !important; }
#talukaTable tbody tr:last-child td { border-bottom: none !important; }

.btn-action { font-size: 0.76rem; padding: 4px 9px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 3px; white-space: nowrap; }

/* Toggle switch */
.toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #cbd5e1; border-radius: 24px; transition: 0.25s; }
.toggle-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.25s; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
input:checked + .toggle-slider { background: #27ae60; }
input:checked + .toggle-slider:before { transform: translateX(20px); }
</style>

@if(session('success'))
<div class="alert alert-success" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <i class="mdi mdi-check-circle mr-1"></i> {{ session('success') }}
</div>
@endif

<div class="gp-page-title">
    <h3><i class="mdi mdi-map"></i> Talukas</h3>
    <a href="{{ route('talukas.create') }}" class="btn-title btn-title-primary">
        <i class="mdi mdi-plus"></i> Add Taluka
    </a>
</div>

<div class="table-card">
    <div class="table-card-header">
        <span><i class="mdi mdi-table-large mr-1" style="color:#00BFC5;"></i><strong>{{ $talukas->count() }}</strong> talukas</span>
    </div>
    <table id="talukaTable" class="table table-hover mb-0" style="width:100%;">
        <thead>
            <tr>
                <th style="width:50px;">#</th>
                <th>Taluka Name</th>
                <th>District</th>
                <th style="width:100px;">Status</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($talukas as $i => $taluka)
            <tr>
                <td style="color:#aaa; font-size:0.78rem; font-weight:600;">{{ $i + 1 }}</td>
                <td><strong style="color:#1e293b;">{{ $taluka->taluka_name }}</strong></td>
                <td>
                    <span style="background:#e0f5f5; color:#0F5C7B; padding:2px 9px; border-radius:6px; font-size:0.8rem; font-weight:600;">
                        {{ $taluka->district->district_name ?? '—' }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('talukas.updateStatus', $taluka->id) }}" method="POST" class="d-inline-block status-form">
                        @csrf
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggle-status-cb"
                                {{ $taluka->is_active ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <input type="hidden" name="is_active" value="{{ $taluka->is_active ? 1 : 0 }}">
                    </form>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('talukas.edit', $taluka->id) }}" class="btn btn-action btn-outline-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('talukas.destroy', $taluka->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
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
    $('#talukaTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        pageLength: 25,
        ordering: true,
        columnDefs: [{ orderable: false, targets: [3, 4] }]
    });

    // Toggle status
    $(document).on('change', '.toggle-status-cb', function () {
        const cb = $(this);
        const form = cb.closest('form');
        const newVal = cb.is(':checked') ? 1 : 0;
        Swal.fire({
            title: 'Change Status?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#27ae60',
            cancelButtonColor: '#708090',
            confirmButtonText: 'Yes, change it',
            cancelButtonText: 'Cancel'
        }).then(result => {
            if (result.isConfirmed) {
                form.find('input[name="is_active"]').val(newVal);
                form.submit();
            } else {
                cb.prop('checked', !cb.is(':checked'));
            }
        });
    });

    // Delete confirm
    $(document).on('submit', '.delete-form', function (e) {
        e.preventDefault();
        const form = $(this);
        Swal.fire({
            title: 'Delete this taluka?',
            text: 'This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E54545',
            cancelButtonColor: '#708090',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});
</script>

@endsection

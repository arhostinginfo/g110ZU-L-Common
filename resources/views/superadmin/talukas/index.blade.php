@extends('superadmin.layout.master-admin')

@section('title', 'Talukas')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
.gp-page-title {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; padding: 18px 24px;
    background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
    border-radius: 12px; margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(26,115,232,0.25);
}
.gp-page-title h3 { margin: 0; color: #fff; font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 8px; }
.btn-title { border: 1.5px solid rgba(255,255,255,0.55); color: #fff; background: rgba(255,255,255,0.12); border-radius: 8px; padding: 7px 16px; font-size: 0.83rem; font-weight: 600; transition: background 0.2s; white-space: nowrap; }
.btn-title:hover { background: rgba(255,255,255,0.25); color: #fff; text-decoration: none; }
.btn-title-primary { background: #fff; color: #1a73e8; border-color: #fff; }
.btn-title-primary:hover { background: #e8f0fe; color: #1a73e8; }

.table-card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf0; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
.table-card-header { padding: 14px 20px; border-bottom: 1px solid #eef0f3; background: #f8f9fb; }
.table-card-header span { font-size: 0.85rem; font-weight: 600; color: #374151; }

#talukaTable thead th { background: #f1f4f8 !important; color: #374151; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 11px 14px; border-bottom: 2px solid #dde3ea !important; white-space: nowrap; }
#talukaTable tbody tr:hover { background: #f5f8ff !important; }
#talukaTable tbody td { font-size: 0.84rem; vertical-align: middle; padding: 10px 14px; color: #374151; border-bottom: 1px solid #f0f2f5 !important; }
#talukaTable tbody tr:last-child td { border-bottom: none !important; }

.btn-action { font-size: 0.76rem; padding: 4px 9px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 3px; white-space: nowrap; }
</style>

<div class="gp-page-title">
    <h3><i class="mdi mdi-map"></i> Talukas</h3>
    <div class="d-flex gap-2">
        <a href="{{ route('talukas.create') }}" class="btn-title btn-title-primary">
            <i class="mdi mdi-plus"></i> Add Taluka
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <i class="mdi mdi-check-circle mr-1"></i> {{ session('success') }}
</div>
@endif

<div class="table-card">
    <div class="table-card-header">
        <span><i class="mdi mdi-table-large mr-1" style="color:#1a73e8;"></i><strong>{{ $talukas->count() }}</strong> talukas</span>
    </div>
    <div class="table-responsive">
        <table id="talukaTable" class="table table-hover mb-0" style="width:100%;">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Taluka Name</th>
                    <th>District</th>
                    <th style="width:130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($talukas as $i => $taluka)
                <tr>
                    <td style="color:#aaa; font-size:0.78rem; font-weight:600;">{{ $i + 1 }}</td>
                    <td><strong style="color:#1e293b;">{{ $taluka->taluka_name }}</strong></td>
                    <td>
                        <span style="background:#e8f0fe; color:#1a73e8; padding:2px 9px; border-radius:6px; font-size:0.8rem; font-weight:600;">
                            {{ $taluka->district->district_name }}
                        </span>
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
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#talukaTable').DataTable({ responsive: true, paging: true, searching: true, pageLength: 25, ordering: true, columnDefs: [{ orderable: false, targets: [3] }] });
    $(document).on('submit', '.delete-form', function (e) {
        if (!confirm('Delete this taluka? This cannot be undone.')) e.preventDefault();
    });
});
</script>

@endsection

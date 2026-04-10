@extends('superadmin.layout.master-admin')

@section('title', 'Edit GP')

@section('content')

<style>
.form-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.form-page-title { display: flex; align-items: center; gap: 12px; }
.form-page-title .form-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.25rem;
    box-shadow: 0 3px 10px rgba(245,158,11,0.3); flex-shrink: 0;
}
.form-page-title h4 { margin: 0; font-size: 1.2rem; font-weight: 700; color: #1e293b; }
.form-page-title p  { margin: 0; font-size: 0.78rem; color: #94a3b8; }
.btn-back {
    display: inline-flex; align-items: center; gap: 5px;
    border: 1.5px solid #cbd5e1; background: #fff; color: #475569;
    border-radius: 8px; padding: 7px 14px;
    font-size: 0.82rem; font-weight: 600; transition: all 0.18s;
}
.btn-back:hover { border-color: #1a73e8; color: #1a73e8; text-decoration: none; }

.form-card { background: #fff; border-radius: 14px; border: 1px solid #e8ecf0; box-shadow: 0 2px 14px rgba(0,0,0,0.06); overflow: hidden; }
.form-card .form-card-body { padding: 28px 32px; }
.form-section-title {
    font-size: 0.72rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin-bottom: 16px; padding-bottom: 10px;
    border-bottom: 1px solid #f1f4f8;
}
.form-group label { font-size: 0.83rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
.form-group .form-control {
    border-radius: 8px; border: 1.5px solid #dce3ea;
    font-size: 0.87rem; color: #1e293b; padding: 9px 12px;
    transition: border-color 0.2s, box-shadow 0.2s; background: #fafbfc;
}
.form-group .form-control:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.12); background: #fff; }
.form-group .form-control.is-invalid { border-color: #ef4444; }
.invalid-feedback { font-size: 0.78rem; color: #ef4444; margin-top: 4px; }
.status-check-wrap {
    display: flex; align-items: center; gap: 12px;
    background: #f8faff; border: 1.5px solid #e0e9ff; border-radius: 10px; padding: 12px 16px;
}
.status-check-wrap .form-check-input { width: 18px; height: 18px; margin: 0; cursor: pointer; accent-color: #1a73e8; }
.status-check-wrap label { font-size: 0.85rem; font-weight: 600; color: #374151; margin: 0; cursor: pointer; }
.field-hint { font-size: 0.76rem; color: #94a3b8; margin-top: 4px; }

.form-footer {
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    padding: 18px 32px; background: #f8f9fb;
    border-top: 1px solid #eef0f5; flex-wrap: wrap;
}
.btn-cancel {
    border: 1.5px solid #cbd5e1; background: #fff; color: #475569;
    border-radius: 8px; padding: 9px 22px;
    font-size: 0.87rem; font-weight: 600; transition: all 0.18s;
    display: inline-flex; align-items: center; gap: 5px;
}
.btn-cancel:hover { border-color: #94a3b8; color: #1e293b; text-decoration: none; }
.btn-save {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; border: none; border-radius: 8px;
    padding: 9px 24px; font-size: 0.87rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(245,158,11,0.3);
    transition: opacity 0.18s, transform 0.18s; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-save:hover { opacity: 0.9; transform: translateY(-1px); }

@media (max-width: 575px) {
    .form-card .form-card-body { padding: 18px 16px; }
    .form-footer { padding: 14px 16px; }
}
</style>

{{-- Page header --}}
<div class="form-page-header">
    <div class="form-page-title">
        <div class="form-icon"><i class="mdi mdi-pencil"></i></div>
        <div>
            <h4>Edit GP &mdash; {{ $gpdetail->gp_name_in_url }}</h4>
            <p>Update the details for this Gram Panchayat</p>
        </div>
    </div>
    <a href="{{ route('superadmin.admin-gp.list') }}" class="btn-back">
        <i class="mdi mdi-arrow-left"></i> Back to List
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <i class="mdi mdi-alert-circle mr-1"></i>
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-1 pl-3">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">

        <div class="form-card">
            <form action="{{ route('superadmin.admin-gp.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="encodedId" value="{{ $encodedId }}">

                <div class="form-card-body">

                    {{-- GP Identity --}}
                    <div class="form-section-title"><i class="mdi mdi-domain mr-1"></i> GP Identity</div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>GP Name in URL</label>
                                <input type="text" name="gp_name_in_url"
                                    value="{{ old('gp_name_in_url', $gpdetail->gp_name_in_url ?? '') }}"
                                    class="form-control @error('gp_name_in_url') is-invalid @enderror">
                                <div class="field-hint">Lowercase, no spaces.</div>
                                @error('gp_name_in_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>GP Name</label>
                                <input type="text" name="gp_name"
                                    value="{{ old('gp_name', $gpdetail->gp_name ?? '') }}"
                                    class="form-control @error('gp_name') is-invalid @enderror">
                                @error('gp_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="form-section-title mt-2"><i class="mdi mdi-map-marker-outline mr-1"></i> Location</div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>District</label>
                                <select name="gp_under_district" class="form-control @error('gp_under_district') is-invalid @enderror">
                                    <option value="">Select District</option>
                                    @foreach ($districts as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('gp_under_district', $gpdetail->gp_under_district ?? '') == $d->id ? 'selected' : '' }}>
                                            {{ $d->district_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gp_under_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Taluka</label>
                                <select name="gp_under_taluka" class="form-control @error('gp_under_taluka') is-invalid @enderror">
                                    <option value="">Select Taluka</option>
                                    @foreach ($talukas as $t)
                                        <option value="{{ $t->id }}"
                                            {{ old('gp_under_taluka', $gpdetail->gp_under_taluka ?? '') == $t->id ? 'selected' : '' }}>
                                            {{ $t->taluka_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gp_under_taluka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Credentials --}}
                    <div class="form-section-title mt-2"><i class="mdi mdi-shield-key-outline mr-1"></i> Login Credentials</div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="employee_email"
                                    value="{{ old('employee_email', $gpdetail->employee_email ?? '') }}"
                                    class="form-control @error('employee_email') is-invalid @enderror">
                                @error('employee_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Password <small style="font-weight:400; color:#94a3b8;">(leave blank to keep current)</small></label>
                                <input type="text" name="employee_password"
                                    class="form-control @error('employee_password') is-invalid @enderror"
                                    placeholder="Enter new password">
                                @error('employee_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Validity & Status --}}
                    <div class="form-section-title mt-2"><i class="mdi mdi-calendar-check-outline mr-1"></i> Validity & Status</div>
                    <div class="row align-items-end">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Valid Till</label>
                                <input type="date" name="gp_valid_till"
                                    value="{{ old('gp_valid_till', isset($gpdetail->gp_valid_till) ? \Carbon\Carbon::parse($gpdetail->gp_valid_till)->format('Y-m-d') : '') }}"
                                    class="form-control @error('gp_valid_till') is-invalid @enderror">
                                @error('gp_valid_till')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1" {{ old('is_active', $gpdetail->is_active ?? 1) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $gpdetail->is_active ?? 1) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="is_deleted" value="{{ old('is_deleted', $gpdetail->is_deleted ?? 0) }}">

                </div>

                <div class="form-footer">
                    <a href="{{ route('superadmin.admin-gp.list') }}" class="btn-cancel">
                        <i class="mdi mdi-close"></i> Cancel
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="mdi mdi-content-save-outline"></i> Update GP
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

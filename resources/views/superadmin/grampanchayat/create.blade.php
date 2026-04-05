@extends('superadmin.layout.master-admin')

@section('title', 'Add GP')

@section('content')

<style>
/* ── Form page shared styles ── */
.form-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.form-page-title {
    display: flex; align-items: center; gap: 12px;
}
.form-page-title .form-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.25rem;
    box-shadow: 0 3px 10px rgba(26,115,232,0.3); flex-shrink: 0;
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

/* ── Form card ── */
.form-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #e8ecf0;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06);
    overflow: hidden;
}
.form-card .form-card-body { padding: 28px 32px; }
.form-section-title {
    font-size: 0.72rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin-bottom: 16px; padding-bottom: 10px;
    border-bottom: 1px solid #f1f4f8;
}
.form-group label {
    font-size: 0.83rem; font-weight: 600; color: #374151; margin-bottom: 5px;
}
.form-group .form-control {
    border-radius: 8px; border: 1.5px solid #dce3ea;
    font-size: 0.87rem; color: #1e293b; padding: 9px 12px;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fafbfc;
}
.form-group .form-control:focus {
    border-color: #1a73e8; box-shadow: 0 0 0 3px rgba(26,115,232,0.1);
    background: #fff;
}
.form-group .form-control.is-invalid { border-color: #ef4444; }
.form-group .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.12); }
.invalid-feedback { font-size: 0.78rem; color: #ef4444; margin-top: 4px; }

/* Status checkbox */
.status-check-wrap {
    display: flex; align-items: center; gap: 12px;
    background: #f8faff; border: 1.5px solid #e0e9ff;
    border-radius: 10px; padding: 12px 16px;
}
.status-check-wrap .form-check-input {
    width: 18px; height: 18px; margin: 0; cursor: pointer;
    accent-color: #1a73e8;
}
.status-check-wrap label { font-size: 0.85rem; font-weight: 600; color: #374151; margin: 0; cursor: pointer; }

/* Form footer */
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
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    color: #fff; border: none; border-radius: 8px;
    padding: 9px 24px; font-size: 0.87rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(26,115,232,0.3);
    transition: opacity 0.18s, transform 0.18s; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-save:hover { opacity: 0.9; transform: translateY(-1px); }

/* Hint text */
.field-hint { font-size: 0.76rem; color: #94a3b8; margin-top: 4px; }

@media (max-width: 575px) {
    .form-card .form-card-body { padding: 18px 16px; }
    .form-footer { padding: 14px 16px; }
}
</style>

{{-- Page header --}}
<div class="form-page-header">
    <div class="form-page-title">
        <div class="form-icon"><i class="mdi mdi-plus"></i></div>
        <div>
            <h4>Add New GP</h4>
            <p>Fill in the details to register a new Gram Panchayat</p>
        </div>
    </div>
    <a href="{{ route('superadmin.admin-gp.list') }}" class="btn-back">
        <i class="mdi mdi-arrow-left"></i> Back to List
    </a>
</div>

{{-- Error alert --}}
@if ($errors->any())
<div class="alert alert-danger" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <i class="mdi mdi-alert-circle mr-1"></i>
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-1 pl-3">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">

        <div class="form-card">
            <form action="{{ route('superadmin.admin-gp.save') }}" method="POST">
                @csrf
                <div class="form-card-body">

                    {{-- GP Identity --}}
                    <div class="form-section-title"><i class="mdi mdi-domain mr-1"></i> GP Identity</div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="gp_name_in_url">GP Name in URL</label>
                                <input type="text" name="gp_name_in_url" id="gp_name_in_url"
                                    value="{{ old('gp_name_in_url') }}"
                                    class="form-control @error('gp_name_in_url') is-invalid @enderror"
                                    placeholder="e.g. shirsuphal">
                                <div class="field-hint">Lowercase, no spaces. Used in website URL.</div>
                                @error('gp_name_in_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="gp_name">GP Name</label>
                                <input type="text" name="gp_name" id="gp_name"
                                    value="{{ old('gp_name') }}"
                                    class="form-control @error('gp_name') is-invalid @enderror"
                                    placeholder="Display name">
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
                                        <option value="{{ $d->id }}" {{ old('gp_under_district') == $d->id ? 'selected' : '' }}>
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
                                        <option value="{{ $t->id }}" {{ old('gp_under_taluka') == $t->id ? 'selected' : '' }}>
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
                                <label for="employee_email">Email</label>
                                <input type="email" name="employee_email" id="employee_email"
                                    value="{{ old('employee_email') }}"
                                    class="form-control @error('employee_email') is-invalid @enderror"
                                    placeholder="admin@gmail.com">
                                @error('employee_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="employee_password">Password</label>
                                <input type="text" name="employee_password" id="employee_password"
                                    class="form-control @error('employee_password') is-invalid @enderror"
                                    placeholder="Auto-generated on URL input">
                                @error('employee_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Validity & Status --}}
                    <div class="form-section-title mt-2"><i class="mdi mdi-calendar-check-outline mr-1"></i> Validity & Status</div>
                    <div class="row align-items-end">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="gp_valid_till">Valid Till</label>
                                <input type="date" name="gp_valid_till" id="gp_valid_till"
                                    value="{{ old('gp_valid_till', '2026-10-30') }}"
                                    class="form-control @error('gp_valid_till') is-invalid @enderror">
                                @error('gp_valid_till')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <div class="status-check-wrap">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                    <label for="is_active">Mark as Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="is_deleted" value="0">

                </div>

                <div class="form-footer">
                    <a href="{{ route('superadmin.admin-gp.list') }}" class="btn-cancel">
                        <i class="mdi mdi-close"></i> Cancel
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="mdi mdi-content-save-outline"></i> Save GP
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const gpUrlInput   = document.getElementById("gp_name_in_url");
    const emailInput   = document.getElementById("employee_email");
    const passwordInput = document.getElementById("employee_password");
    const gpNameInput  = document.getElementById("gp_name");

    function toTitleCase(str) {
        return str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.substring(1).toLowerCase());
    }
    function generatePassword(len = 12) {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
        return Array.from({ length: len }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
    }

    gpUrlInput.addEventListener("input", function () {
        const url = gpUrlInput.value.toLowerCase().replace(/\s+/g, '');
        gpUrlInput.value   = url;
        emailInput.value   = url ? `${url}@gmail.com` : '';
        gpNameInput.value  = url ? toTitleCase(url.replace(/-/g, ' ')) : '';
        passwordInput.value = url ? generatePassword() : '';
    });
});
</script>

@endsection

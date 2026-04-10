@extends('superadmin.layout.master-admin')

@section('title', 'Edit Taluka')

@section('content')

<style>
.form-page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
.form-page-title { display: flex; align-items: center; gap: 12px; }
.form-page-title .form-icon { width: 44px; height: 44px; border-radius: 11px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.25rem; box-shadow: 0 3px 10px rgba(245,158,11,0.3); flex-shrink: 0; }
.form-page-title h4 { margin: 0; font-size: 1.2rem; font-weight: 700; color: #1e293b; }
.form-page-title p  { margin: 0; font-size: 0.78rem; color: #94a3b8; }
.btn-back { display: inline-flex; align-items: center; gap: 5px; border: 1.5px solid #cbd5e1; background: #fff; color: #475569; border-radius: 8px; padding: 7px 14px; font-size: 0.82rem; font-weight: 600; transition: all 0.18s; }
.btn-back:hover { border-color: #1a73e8; color: #1a73e8; text-decoration: none; }
.form-card { background: #fff; border-radius: 14px; border: 1px solid #e8ecf0; box-shadow: 0 2px 14px rgba(0,0,0,0.06); overflow: hidden; }
.form-card .form-card-body { padding: 28px 32px; }
.form-group label { font-size: 0.83rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
.form-group .form-control { border-radius: 8px; border: 1.5px solid #dce3ea; font-size: 0.87rem; color: #1e293b; padding: 9px 12px; transition: border-color 0.2s, box-shadow 0.2s; background: #fafbfc; }
.form-group .form-control:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.12); background: #fff; }
.form-group .form-control.is-invalid { border-color: #ef4444; }
.invalid-feedback { font-size: 0.78rem; color: #ef4444; margin-top: 4px; }
.form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 18px 32px; background: #f8f9fb; border-top: 1px solid #eef0f5; flex-wrap: wrap; }
.btn-cancel { border: 1.5px solid #cbd5e1; background: #fff; color: #475569; border-radius: 8px; padding: 9px 22px; font-size: 0.87rem; font-weight: 600; transition: all 0.18s; display: inline-flex; align-items: center; gap: 5px; }
.btn-cancel:hover { border-color: #94a3b8; color: #1e293b; text-decoration: none; }
.btn-save { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; border: none; border-radius: 8px; padding: 9px 24px; font-size: 0.87rem; font-weight: 700; box-shadow: 0 3px 10px rgba(245,158,11,0.3); transition: opacity 0.18s, transform 0.18s; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-save:hover { opacity: 0.9; transform: translateY(-1px); }
@media (max-width: 575px) { .form-card .form-card-body { padding: 18px 16px; } .form-footer { padding: 14px 16px; } }
</style>

<div class="form-page-header">
    <div class="form-page-title">
        <div class="form-icon"><i class="mdi mdi-pencil"></i></div>
        <div>
            <h4>Edit Taluka &mdash; {{ $taluka->taluka_name }}</h4>
            <p>Update taluka details</p>
        </div>
    </div>
    <a href="{{ route('superadmin.talukas.index') }}" class="btn-back"><i class="mdi mdi-arrow-left"></i> Back</a>
</div>

@if ($errors->any())
<div class="alert alert-danger" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="form-card">
            <form action="{{ route('superadmin.talukas.update', $taluka->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-card-body">
                    <div class="form-group">
                        <label>Taluka Name</label>
                        <input type="text" name="taluka_name"
                            value="{{ old('taluka_name', $taluka->taluka_name) }}"
                            class="form-control @error('taluka_name') is-invalid @enderror" required>
                        @error('taluka_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>District</label>
                        <select name="district_id" class="form-control @error('district_id') is-invalid @enderror" required>
                            <option value="">Select District</option>
                            @foreach($districts as $d)
                                <option value="{{ $d->id }}" {{ (old('district_id', $taluka->district_id) == $d->id) ? 'selected' : '' }}>{{ $d->district_name }}</option>
                            @endforeach
                        </select>
                        @error('district_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $taluka->is_active ?? 1) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $taluka->is_active ?? 1) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-footer">
                    <a href="{{ route('superadmin.talukas.index') }}" class="btn-cancel"><i class="mdi mdi-close"></i> Cancel</a>
                    <button type="submit" class="btn-save"><i class="mdi mdi-content-save-outline"></i> Update Taluka</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

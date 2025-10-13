@extends('superadmin.layout.master-admin')

@section('title', 'Edit GP Details')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Edit GP Details</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('superadmin.admin-gp.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Employee Email</label>
                            <input type="email" name="employee_email"
                                value="{{ old('employee_email', $gpdetail->employee_email ?? '') }}"
                                class="form-control @error('employee_email') is-invalid @enderror">
                            @error('employee_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Employee Password <small>(Leave blank to keep current password)</small></label>
                            <input type="password" name="employee_password"
                                class="form-control @error('employee_password') is-invalid @enderror">
                            @error('employee_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- District Dropdown --}}
                        <div class="mb-3">
                            <label class="form-label">District</label>
                            <select name="gp_under_district" class="form-control @error('gp_under_district') is-invalid @enderror">
                                <option value="">Select District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ old('gp_under_district', $gpdetail->gp_under_district ?? '') == $district->id ? 'selected' : '' }}>
                                        {{ $district->district_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gp_under_district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Taluka Dropdown --}}
                        <div class="mb-3">
                            <label class="form-label">Taluka</label>
                            <select name="gp_under_taluka" class="form-control @error('gp_under_taluka') is-invalid @enderror">
                                <option value="">Select Taluka</option>
                                @foreach ($talukas as $taluka)
                                    <option value="{{ $taluka->id }}"
                                        {{ old('gp_under_taluka', $gpdetail->gp_under_taluka ?? '') == $taluka->id ? 'selected' : '' }}>
                                        {{ $taluka->taluka_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gp_under_taluka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">GP Name</label>
                            <input type="text" name="gp_name" value="{{ old('gp_name', $gpdetail->gp_name ?? '') }}"
                                class="form-control @error('gp_name') is-invalid @enderror">
                            @error('gp_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">GP Name In URL</label>
                            <input type="text" name="gp_name_in_url" value="{{ old('gp_name_in_url', $gpdetail->gp_name_in_url ?? '') }}"
                                class="form-control @error('gp_name_in_url') is-invalid @enderror">
                            @error('gp_name_in_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Valid Till</label>
                            <input type="date" name="gp_valid_till" value="{{ old('gp_valid_till', isset($gpdetail->gp_valid_till) ? \Carbon\Carbon::parse($gpdetail->gp_valid_till)->format('Y-m-d') : '') }}"
                                class="form-control @error('gp_valid_till') is-invalid @enderror">
                            @error('gp_valid_till')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $gpdetail->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>

                        <input type="hidden" name="is_deleted" value="{{ old('is_deleted', $gpdetail->is_deleted ?? 0) }}">

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('superadmin.admin-gp.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

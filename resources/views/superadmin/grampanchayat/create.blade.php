@extends('superadmin.layout.master-admin')

@section('title', 'Add GP Details')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Add GP Details</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('superadmin.admin-gp.save') }}" method="POST" class="mt-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Employee Email</label>
                            <input type="email" name="employee_email" id="employee_email" value="{{ old('employee_email') }}"
                                class="form-control @error('employee_email') is-invalid @enderror">
                            @error('employee_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Employee Password</label>
                            <input type="password" name="employee_password" id="employee_password"
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
                                    <option value="{{ $district->id }}" {{ old('gp_under_district') == $district->id ? 'selected' : '' }}>
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
                                    <option value="{{ $taluka->id }}" {{ old('gp_under_taluka') == $taluka->id ? 'selected' : '' }}>
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
                            <input type="text" name="gp_name" id="gp_name" value="{{ old('gp_name') }}"
                                class="form-control @error('gp_name') is-invalid @enderror">
                            @error('gp_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                          <div class="mb-3">
                            <label class="form-label">GP Name In URL</label>
                            <input type="text" name="gp_name_in_url" id="gp_name_in_url" value="{{ old('gp_name_in_url') }}"
                                class="form-control @error('gp_name_in_url') is-invalid @enderror">
                            @error('gp_name_in_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Valid Till</label>
                            <input type="date" name="gp_valid_till" id="gp_valid_till" 
                            value="{{ old('gp_valid_till', '2026-10-30') }}"
                            class="form-control @error('gp_valid_till') is-invalid @enderror">
                            @error('gp_valid_till')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>

                        <input type="hidden" name="is_deleted" value="0">

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('superadmin.admin-gp.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const gpUrlInput = document.getElementById("gp_name_in_url");
        const emailInput = document.getElementById("employee_email");
        const passwordInput = document.getElementById("employee_password");
        const gpNameInput = document.getElementById("gp_name");

        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substring(1).toLowerCase();
            });
        }


        function generatePassword(length = 12) {
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
            let password = "";
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            return password;
        }

        gpUrlInput.addEventListener("input", function () {
            let urlText = gpUrlInput.value.toLowerCase().replace(/\s+/g, '');

            // Update URL field in lowercase
            gpUrlInput.value = urlText;

            // Set email
            emailInput.value = `${urlText}@gmail.com`;

            // Set GP Name (you can use capitalize here if needed)
            gpNameInput.value = toTitleCase(urlText.replace(/-/g, ' '));

            // Set password
            passwordInput.value = generatePassword();
        });
    });
</script>
@endsection

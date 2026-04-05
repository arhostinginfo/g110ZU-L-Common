@extends('superadmin.layout.master-admin')

@section('title', 'Change Password')

@section('content')

<style>
.form-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.form-page-title { display: flex; align-items: center; gap: 12px; }
.form-page-title .form-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: linear-gradient(135deg, #7c3aed, #4f46e5);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.25rem;
    box-shadow: 0 3px 10px rgba(124,58,237,0.3); flex-shrink: 0;
}
.form-page-title h4 { margin: 0; font-size: 1.2rem; font-weight: 700; color: #1e293b; }
.form-page-title p  { margin: 0; font-size: 0.78rem; color: #94a3b8; }

.form-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #e8ecf0;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06);
    overflow: hidden;
}
.form-card-body { padding: 30px 32px; }

.form-group label { font-size: 0.83rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
.input-wrap { position: relative; }
.input-wrap .form-control {
    border-radius: 8px; border: 1.5px solid #dce3ea;
    font-size: 0.87rem; color: #1e293b;
    padding: 10px 42px 10px 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fafbfc; width: 100%;
}
.input-wrap .form-control:focus {
    border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
    background: #fff; outline: none;
}
.input-wrap .form-control.is-invalid { border-color: #ef4444; }
.input-wrap .toggle-pw {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #94a3b8; font-size: 1rem; padding: 0; line-height: 1;
    transition: color 0.18s;
}
.input-wrap .toggle-pw:hover { color: #7c3aed; }
.invalid-feedback { font-size: 0.78rem; color: #ef4444; margin-top: 4px; display: block; }

.pw-rules {
    background: #f8f9fb; border: 1px solid #e8ecf0;
    border-radius: 10px; padding: 14px 16px; margin-bottom: 20px;
}
.pw-rules p { font-size: 0.8rem; font-weight: 700; color: #374151; margin: 0 0 8px; }
.pw-rules ul { margin: 0; padding-left: 16px; }
.pw-rules ul li { font-size: 0.78rem; color: #64748b; margin-bottom: 3px; }

.form-footer {
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    padding: 18px 32px; background: #f8f9fb;
    border-top: 1px solid #eef0f5; flex-wrap: wrap;
}
.btn-save {
    background: linear-gradient(135deg, #7c3aed, #4f46e5);
    color: #fff; border: none; border-radius: 8px;
    padding: 10px 26px; font-size: 0.88rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(124,58,237,0.3);
    transition: opacity 0.18s, transform 0.18s; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-save:hover { opacity: 0.9; transform: translateY(-1px); }

@media (max-width: 575px) {
    .form-card-body { padding: 18px 16px; }
    .form-footer { padding: 14px 16px; }
}
</style>

{{-- Page header --}}
<div class="form-page-header">
    <div class="form-page-title">
        <div class="form-icon"><i class="mdi mdi-lock-reset"></i></div>
        <div>
            <h4>Change Password</h4>
            <p>Update your admin account password</p>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <i class="mdi mdi-check-circle mr-1"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger" style="border-radius:10px; border:none; font-size:0.85rem; margin-bottom:20px;">
    <i class="mdi mdi-alert-circle mr-1"></i> {{ session('error') }}
</div>
@endif

<div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

        <div class="form-card">
            <form action="{{ route('superadmin.update-password') }}" method="POST" novalidate>
                @csrf
                <div class="form-card-body">

                    {{-- Password rules --}}
                    <div class="pw-rules">
                        <p><i class="mdi mdi-information-outline mr-1" style="color:#7c3aed;"></i> Password requirements</p>
                        <ul>
                            <li>Minimum 8 characters</li>
                            <li>At least 5 letters (A–Z or a–z)</li>
                            <li>At least 2 digits (0–9)</li>
                            <li>At least 1 special character (!@#$%^&* etc.)</li>
                        </ul>
                    </div>

                    {{-- New Password --}}
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div class="input-wrap">
                            <input type="password" name="new_password" id="new_password"
                                class="form-control @error('new_password') is-invalid @enderror"
                                placeholder="Enter new password" autocomplete="new-password">
                            <button type="button" class="toggle-pw" onclick="togglePw('new_password', this)">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group" style="margin-top:16px;">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="input-wrap">
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="form-control @error('confirm_password') is-invalid @enderror"
                                placeholder="Re-enter new password" autocomplete="new-password">
                            <button type="button" class="toggle-pw" onclick="togglePw('confirm_password', this)">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>
                        @error('confirm_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-save">
                        <i class="mdi mdi-lock-check-outline"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
function togglePw(fieldId, btn) {
    var field = document.getElementById(fieldId);
    var icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('mdi-eye-outline', 'mdi-eye-off-outline');
    } else {
        field.type = 'password';
        icon.classList.replace('mdi-eye-off-outline', 'mdi-eye-outline');
    }
}
</script>

@endsection

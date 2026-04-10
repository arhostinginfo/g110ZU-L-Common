@extends('gpadmin.layout.master')
@section('title', 'Add Website Details')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Add Website Details</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('gpadmin.navbar.save') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Footer Description <span class="text-danger">*</span></label>
                            <input type="text" name="footer_desc" value="{{ old('footer_desc') }}"
                                class="form-control @error('footer_desc') is-invalid @enderror">
                            @error('footer_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                class="form-control @error('contact_number') is-invalid @enderror">
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Id <span class="text-danger">*</span></label>
                            <input type="text" name="email_id" value="{{ old('email_id') }}"
                                class="form-control @error('email_id') is-invalid @enderror">
                            @error('email_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Color <span class="text-danger">*</span></label>
                            <input name="color" value="{{ old('color', '#0F5C7B') }}" class="form-control" type="color"
                                style="height:42px;padding:4px 8px;">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Latitude <span class="text-danger">*</span></label>
                            <input type="text" name="lat" value="{{ old('lat') }}"
                                class="form-control @error('lat') is-invalid @enderror">
                            @error('lat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Longitude <span class="text-danger">*</span></label>
                            <input type="text" name="lon" value="{{ old('lon') }}"
                                class="form-control @error('lon') is-invalid @enderror">
                            @error('lon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', '1') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.navbar.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

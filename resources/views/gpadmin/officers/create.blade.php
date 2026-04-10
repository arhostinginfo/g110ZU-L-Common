@extends('gpadmin.layout.master')

@section('title', 'Add New Member')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Add New Member</h3>

                    <form action="{{ route('gpadmin.officers.save') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Post <span class="text-danger">*</span></label>
                            <input type="text" name="designation" value="{{ old('designation') }}"
                                class="form-control @error('designation') is-invalid @enderror">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile No <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                class="form-control @error('mobile') is-invalid @enderror">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Id <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo (optional)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Choose Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="Officer" {{ old('type') == 'Officer' ? 'selected' : '' }}>Officer</option>
                                <option value="Sadsya" {{ old('type') == 'Sadsya' ? 'selected' : '' }}>Sadsya</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sequence Officer <span class="text-danger">*</span></label>
                            <input type="number" name="sequence_officer" value="{{ old('sequence_officer') }}"
                                class="form-control @error('sequence_officer') is-invalid @enderror">
                            @error('sequence_officer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sequence General <span class="text-danger">*</span></label>
                            <input type="number" name="sequence_general" value="{{ old('sequence_general') }}"
                                class="form-control @error('sequence_general') is-invalid @enderror">
                            @error('sequence_general')
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
                            <a href="{{ route('gpadmin.officers.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

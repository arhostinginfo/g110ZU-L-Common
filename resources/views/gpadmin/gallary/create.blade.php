@extends('gpadmin.layout.master')

@section('title', 'Add Gallery')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Add Gallery</h3>

                    <form action="{{ route('gpadmin.gallary.save') }}" method="POST" enctype="multipart/form-data" class="mt-3">
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
                            <label class="form-label">Attachment (optional)</label>
                            <input type="file" name="attachment"
                                class="form-control @error('attachment') is-invalid @enderror">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Choose Type <span class="text-danger">*</span></label>
                            <select name="type_attachment" id="type_attachment"
                                class="form-control @error('type_attachment') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="Video" {{ old('type_attachment') == 'Video' ? 'selected' : '' }}>Video</option>
                                <option value="Image" {{ old('type_attachment') == 'Image' ? 'selected' : '' }}>Image</option>
                            </select>
                            @error('type_attachment')
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
                            <a href="{{ route('gpadmin.gallary.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

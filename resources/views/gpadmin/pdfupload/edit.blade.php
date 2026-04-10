@extends('gpadmin.layout.master')

@section('title', 'Edit PDF Upload')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <h3>Edit PDF Upload — {{ $gallaries->name }}</h3>
                    <form action="{{ route('gpadmin.pdfupload.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $gallaries->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($gallaries->type_attachment == 'pdf' && $gallaries->attachment)
                            <div class="mb-3">
                                <a href="{{ asset('storage/' . $gallaries->attachment) }}" target="_blank"
                                    class="btn btn-sm btn-outline-danger">
                                    <i class="mdi mdi-file-pdf-box"></i> View Current PDF
                                </a>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Add New PDF File (optional)</label>
                            <input type="file" name="attachment"
                                class="form-control @error('attachment') is-invalid @enderror" accept=".pdf">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Choose Type <span class="text-danger">*</span></label>
                            <select name="type_attachment" id="type_attachment"
                                class="form-control @error('type_attachment') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="pdf" {{ old('type_attachment', $gallaries->type_attachment) == 'pdf' ? 'selected' : '' }}>PDF</option>
                            </select>
                            @error('type_attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', $gallaries->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $gallaries->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.pdfupload.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

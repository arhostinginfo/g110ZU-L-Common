@extends('gpadmin.layout.master')

@section('title', 'Edit Yojna')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <h3>Edit Yojna — {{ $yojna->name }}</h3>
                    <form action="{{ route('gpadmin.yojna.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $yojna->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($yojna->type_attachment == 'Image' && $yojna->attachment)
                            <div class="mb-3">
                                <label class="form-label d-block">Current Image</label>
                                <img src="{{ asset('storage/' . $yojna->attachment) }}"
                                    alt="attachment"
                                    style="height:120px;width:120px;object-fit:cover;border-radius:8px;cursor:pointer;"
                                    onclick="openImgModal('{{ asset('storage/' . $yojna->attachment) }}')"
                                    class="table-img mb-2">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Add New Attachment (optional)</label>
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
                                <option value="PDF" {{ old('type_attachment', $yojna->type_attachment) == 'PDF' ? 'selected' : '' }}>PDF</option>
                                <option value="Image" {{ old('type_attachment', $yojna->type_attachment) == 'Image' ? 'selected' : '' }}>Image</option>
                                <option value="Link" {{ old('type_attachment', $yojna->type_attachment) == 'Link' ? 'selected' : '' }}>Link</option>
                            </select>
                            @error('type_attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link (optional)</label>
                            <input type="text" name="attachment_link"
                                value="{{ old('attachment_link', $yojna->attachment_link) }}"
                                class="form-control @error('attachment_link') is-invalid @enderror">
                            @error('attachment_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', $yojna->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $yojna->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.yojna.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

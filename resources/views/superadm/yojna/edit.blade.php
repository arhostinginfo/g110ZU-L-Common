@extends('superadm.layout.master')

@section('title', 'Yojna Edit')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <h3>Save Yojana — {{ $yojna->name }}</h3>
                    <form action="{{ route('yojna.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" class="form-control" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $yojna->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($yojna->attachment == 'Image')
                            <div class="mb-3">
                                <label class="form-label d-block">Current Image</label>
                                <img style="height: 250px;width: 250px;" src="{{ asset('storage/' . $yojna->attachment) }}"
                                    alt="attachment" class="table-img mb-2">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Add New Attachment(optional)</label>
                            <input type="file" name="attachment"
                                class="form-control @error('attachment') is-invalid @enderror">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type">Choose Type</label>
                            <select name="type_attachment" id="type_attachment"
                                class="form-control @error('type_attachment') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="PDF"
                                    {{ old('type_attachment', $yojna->type_attachment) == 'PDF' ? 'selected' : '' }}>PDF
                                </option>
                                <option value="Image"
                                    {{ old('type_attachment', $yojna->type_attachment) == 'Image' ? 'selected' : '' }}>Image
                                </option>
                                <option value="Link"
                                    {{ old('type_attachment', $yojna->type_attachment) == 'Link' ? 'selected' : '' }}>Link
                                </option>
                            </select>
                            @error('type_attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Link</label>
                            <input type="text" name="attachment_link"
                                value="{{ old('attachment_link', $yojna->attachment_link) }}"
                                class="form-control @error('attachment_link') is-invalid @enderror">
                            @error('attachment_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('yojna.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

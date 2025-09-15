@extends('superadm.layout.master')

@section('title', 'Yojna')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Yojna</h3>

                    <form action="{{ route('yojna.save') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
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
                            <label for="type_attachment">Choose Type</label>
                            <select name="type_attachment" id="type_attachment"
                                class="form-control @error('type_attachment') is-invalid @enderror">
                                <option value="">select</option>
                                <option value="PDF">PDF</option>
                                <option value="Image">Image</option>
                                <option value="Link">Link</option>
                            </select>

                            <div class="mb-3">
                                <label class="form-label">Link</label>
                                <input type="text" name="attachment_link" value="{{ old('attachment_link') }}"
                                    class="form-control @error('attachment_link') is-invalid @enderror">
                                @error('attachment_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('yojna.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

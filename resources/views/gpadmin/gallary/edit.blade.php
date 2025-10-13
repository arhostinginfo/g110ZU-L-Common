@extends('gpadmin.layout.master')

@section('title', 'Gallary Edit')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <h3>Save Gallary — {{ $gallaries->name }}</h3>
                    <form action="{{ route('gpadmin.gallary.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" class="form-control" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $gallaries->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($gallaries->type_attachment == 'Image')
                            <div class="mb-3">
                                <label class="form-label d-block">Current Image</label>
                                <img style="height: 250px;width: 250px;"
                                    src="{{ asset('storage/' . $gallaries->attachment) }}" alt="attachment"
                                    class="table-img mb-2">
                            </div>
                        @elseif ($gallaries->type_attachment == 'Video')
                            <video controls>
                                <source src="{{ $gallaries->attachment ?? 'name of image' }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
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

                                <option value="Image"
                                    {{ old('type_attachment', $gallaries->type_attachment) == 'Image' ? 'selected' : '' }}>
                                    Image
                                </option>
                                <option value="Video"
                                    {{ old('type_attachment', $gallaries->type_attachment) == 'Video' ? 'selected' : '' }}>
                                    Video
                                </option>
                            </select>
                            @error('type_attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.gallary.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

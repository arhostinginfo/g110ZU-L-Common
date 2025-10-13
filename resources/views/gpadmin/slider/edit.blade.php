@extends('gpadmin.layout.master')

@section('title', 'Slider Edit')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">


                    <form action="{{ route('gpadmin.slider.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" class="form-control" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="name" value="{{ old('name', $slider->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($slider->photo)
                            <div class="mb-3">
                                <label class="form-label d-block">Current Photo</label>
                                <img style="height: 250px;width: 250px;" src="{{ asset('storage/' . $slider->photo) }}"
                                    alt="photo" class="table-img mb-2">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">New Photo (optional)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.slider.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

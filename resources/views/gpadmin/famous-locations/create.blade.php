@extends('gpadmin.layout.master')
@section('title', 'famous-locations')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Famous Locations</h3>

                    <form action="{{ route('gpadmin.famous-locations.save') }}" method="POST" enctype="multipart/form-data"
                        class="mt-3">
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
                            <label class="form-label">Description</label>
                            <input type="text" name="desc" value="{{ old('desc') }}"
                                class="form-control @error('desc') is-invalid @enderror" rows="6">
                            @error('desc')
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

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.famous-locations.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                             <button class="btn btn-sm btn-outline-primary" >Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@extends('gpadmin.layout.master')

@section('title', 'Edit Famous Location')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>Edit Famous Location — {{ $famouslocations->name }}</h3>

                    <form action="{{ route('gpadmin.famous-locations.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $famouslocations->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" rows="4">{{ old('desc', $famouslocations->desc) }}</textarea>
                            @error('desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($famouslocations->photo)
                            <div class="mb-3">
                                <label class="form-label d-block">Current Photo</label>
                                <img src="{{ asset('storage/' . $famouslocations->photo) }}"
                                    alt="photo"
                                    style="height:120px;width:120px;object-fit:cover;border-radius:8px;cursor:pointer;"
                                    onclick="openImgModal('{{ asset('storage/' . $famouslocations->photo) }}')"
                                    class="table-img mb-2">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">New Photo (optional)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', $famouslocations->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $famouslocations->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.famous-locations.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

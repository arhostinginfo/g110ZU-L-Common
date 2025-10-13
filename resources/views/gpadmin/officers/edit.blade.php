@extends('gpadmin.layout.master')

@section('title', 'Officer Edit')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <h3>Edit Information For — {{ $officer->name }}</h3>

                    <form action="{{ route('gpadmin.officers.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" class="form-control" value="{{ $encodedId }}">
                        <div class="mb-3">
                            <label class="form-label">Post</label>
                            <input type="text" name="designation" value="{{ old('designation', $officer->designation) }}"
                                class="form-control @error('designation') is-invalid @enderror">
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $officer->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile No</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $officer->mobile) }}"
                                class="form-control @error('mobile') is-invalid @enderror">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Id</label>
                            <input type="email" name="email" value="{{ old('email', $officer->email) }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($officer->photo)
                            <div class="mb-3">
                                <label class="form-label d-block">सध्याची फोटो</label>
                                <img style="height: 250px;width: 250px;" src="{{ asset('storage/' . $officer->photo) }}"
                                    alt="photo" class="table-img mb-2">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Upload New Photo (optional)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="type">Choose Type</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">select</option>
                                <option value="Officer" {{ old('type', $officer->type) == 'Officer' ? 'selected' : '' }}>
                                    Officer</option>
                                <option value="Sadsya" {{ old('type', $officer->type) == 'Sadsya' ? 'selected' : '' }}>
                                    Sadsya</option>
                            </select>

                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Sequence Officer</label>
                            <input type="text" name="sequence_officer"
                                value="{{ old('sequence_officer', $officer->sequence_officer) }}"
                                class="form-control @error('sequence_officer') is-invalid @enderror">
                            @error('sequence_officer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Sequence General</label>
                            <input type="text" name="sequence_general"
                                value="{{ old('sequence_general', $officer->sequence_general) }}"
                                class="form-control @error('sequence_general') is-invalid @enderror">
                            @error('sequence_general')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.officers.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

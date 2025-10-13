@extends('gpadmin.layout.master')

@section('title', 'Website Details')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">


                    <form action="{{ route('gpadmin.navbar.update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <input type="hidden" name="encodedId" class="form-control" value="{{ $encodedId }}">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $navbar->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Footer Desc </label>
                            <input type="text" name="footer_desc" value="{{ old('footer_desc', $navbar->footer_desc) }}"
                                class="form-control @error('footer_desc') is-invalid @enderror">
                            @error('footer_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Adress</label>
                            <input type="text" name="address" value="{{ old('address', $navbar->address) }}"
                                class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number"
                                value="{{ old('contact_number', $navbar->contact_number) }}"
                                class="form-control @error('contact_number') is-invalid @enderror">
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Id</label>
                            <input type="text" name="email_id" value="{{ old('email_id', $navbar->email_id) }}"
                                class="form-control @error('email_id') is-invalid @enderror">
                            @error('email_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <input type="color" name="color" value="{{ old('color', $navbar->color) }}"
                                class="color-picker" @error('color') is-invalid @enderror">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($navbar->logo)
                            <div class="mb-3">
                                <label class="form-label d-block">सध्याची फोटो</label>
                                <img style="height: 250px;width: 250px;" src="{{ asset('storage/' . $navbar->logo) }}"
                                    alt="logo" class="table-img mb-2">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">नवीन फोटो (optional)</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="lat" value="{{ old('lat', $navbar->lat) }}"
                                class="form-control @error('lat') is-invalid @enderror">
                            @error('lat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="lon" value="{{ old('lon', $navbar->lon) }}"
                                class="form-control @error('lon') is-invalid @enderror">
                            @error('lon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.navbar.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

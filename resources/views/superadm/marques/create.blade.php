@extends('superadm.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4>Add Marque</h4>
                    <form action="{{ route('marquee.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Message <span class="text-danger">*</span></label>
                            <input type="text" name="message" class="form-control" value="{{ old('role') }}">
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('marquee.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-sm btn-outline-info">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

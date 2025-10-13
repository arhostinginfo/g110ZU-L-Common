@extends('gpadmin.layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h4>Add Abhiyan</h4>
                    <form action="{{ route('gpadmin.abhiyan.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Abhiyan <span class="text-danger">*</span></label>
                            <input type="text" name="abhiyan_name" class="form-control" value="{{ old('abhiyan_name') }}">
                            @error('abhiyan_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Abhiyan Date <span class="text-danger">*</span></label>
                            <input type="date" name="abhiyan_date" class="form-control"
                                value="{{ old('abhiyan_date') }}">
                            @error('abhiyan_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.abhiyan.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-sm btn-outline-primary" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

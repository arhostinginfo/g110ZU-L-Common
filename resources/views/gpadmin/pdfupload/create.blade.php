@extends('gpadmin.layout.master')

@section('title', 'PDF Upload')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>PDF Upload</h3>

                    <form action="{{ route('gpadmin.pdfupload.save') }}" method="POST" enctype="multipart/form-data" class="mt-3">
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
                                <option value="pdf">pdf</option>
                            </select>

                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.pdfupload.list') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button class="btn btn-sm btn-outline-primary" >Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

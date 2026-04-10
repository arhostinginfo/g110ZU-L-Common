@extends('gpadmin.layout.master')

@section('title', 'Edit Welcome Note')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4>Edit Welcome Note</h4>
                    <form action="{{ route('gpadmin.welcome-note.update', $encodedId) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ old('id', $data->id) }}">

                        <div class="form-group mb-3">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $data->title) }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="editor" class="form-control" rows="6">{{ old('content', $data->content) }}</textarea>
                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', $data->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $data->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end gap-2">
                            <a href="{{ route('gpadmin.welcome-note.list') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection

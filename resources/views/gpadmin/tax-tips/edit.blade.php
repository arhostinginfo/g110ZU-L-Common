@extends('gpadmin.layout.master')

@section('title', 'कर टीप संपादन')

@section('content')
    <div class="row">
        <div class="col-lg-7 col-md-9 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>कर टीप संपादन</h3>

                    <form action="{{ route('gpadmin.gp-tax.tips.update', $tip->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">टीप मजकूर</label>
                            <textarea name="tip_text" rows="4"
                                class="form-control @error('tip_text') is-invalid @enderror">{{ old('tip_text', $tip->tip_text) }}</textarea>
                            @error('tip_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                    value="1" {{ $tip->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">सक्रिय</label>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.gp-tax.tips.index') }}" class="btn btn-secondary mr-2">रद्द करा</a>
                            <button class="btn btn-sm btn-outline-primary">अद्यतनित करा</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

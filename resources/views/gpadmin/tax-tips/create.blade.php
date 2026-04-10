@extends('gpadmin.layout.master')

@section('title', 'नवीन कर टीप')

@section('content')
    <div class="row">
        <div class="col-lg-7 col-md-9 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>नवीन कर टीप जोडा</h3>

                    <form action="{{ route('gpadmin.gp-tax.tips.store') }}" method="POST" class="mt-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">टीप मजकूर <span class="text-danger">*</span></label>
                            <textarea name="tip_text" rows="4"
                                class="form-control @error('tip_text') is-invalid @enderror"
                                placeholder="उदा. कर भरणा केल्यानंतर पावती मिळवण्यासाठी...">{{ old('tip_text') }}</textarea>
                            @error('tip_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', '1') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.gp-tax.tips.index') }}" class="btn btn-secondary mr-2">रद्द करा</a>
                            <button class="btn btn-sm btn-outline-primary">जतन करा</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

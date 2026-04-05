@extends('gpadmin.layout.master')

@section('title', 'नवीन कर मागणी')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3>नवीन कर मागणी जोडा</h3>

                    <form action="{{ route('gpadmin.gp-tax.demands.store') }}" method="POST" class="mt-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">कराचा प्रकार</label>
                            <select name="tax_type" class="form-control @error('tax_type') is-invalid @enderror">
                                <option value="">-- निवडा --</option>
                                <option value="ghar_patti" {{ old('tax_type') === 'ghar_patti' ? 'selected' : '' }}>घरपट्टी</option>
                                <option value="paani_patti" {{ old('tax_type') === 'paani_patti' ? 'selected' : '' }}>पाणीपट्टी</option>
                                <option value="other" {{ old('tax_type') === 'other' ? 'selected' : '' }}>गाळाभाडे/व्यवसायकर/इतर कर</option>
                            </select>
                            @error('tax_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">वर्ष</label>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="2000" max="2099"
                                class="form-control @error('year') is-invalid @enderror">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">कालावधी</label>
                            <select name="period" class="form-control @error('period') is-invalid @enderror">
                                <option value="">-- निवडा --</option>
                                <option value="magil" {{ old('period') === 'magil' ? 'selected' : '' }}>मागिल</option>
                                <option value="chalu" {{ old('period') === 'chalu' ? 'selected' : '' }}>चालू</option>
                            </select>
                            @error('period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">मागणी रक्कम (₹)</label>
                            <input type="number" name="demand_amount" value="{{ old('demand_amount') }}" step="0.01" min="0"
                                class="form-control @error('demand_amount') is-invalid @enderror">
                            @error('demand_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">वसूल रक्कम (₹)</label>
                            <input type="number" name="collected_amount" value="{{ old('collected_amount') }}" step="0.01" min="0"
                                class="form-control @error('collected_amount') is-invalid @enderror">
                            @error('collected_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('gpadmin.gp-tax.demands.index') }}" class="btn btn-secondary mr-2">रद्द करा</a>
                            <button class="btn btn-sm btn-outline-primary">जतन करा</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

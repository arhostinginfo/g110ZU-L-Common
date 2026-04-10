@extends('gpadmin.layout.master')

@section('title', 'कर मागणी')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>कर मागणी</h3>
                        <a href="{{ route('gpadmin.gp-tax.demands.create') }}" class="btn btn-sm btn-outline-primary">नवीन कर मागणी जोडा</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>अ.नं.</th>
                                    <th>कराचा प्रकार</th>
                                    <th>वर्ष</th>
                                    <th>कालावधी</th>
                                    <th>मागणी रक्कम (₹)</th>
                                    <th>वसूल रक्कम (₹)</th>
                                    <th>टक्केवारी %</th>
                                    <th>स्थिती</th>
                                    <th>कृती</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($demands as $i => $demand)
                                    <tr>
                                        <td>{{ $demands->firstItem() + $i }}</td>
                                        <td>
                                            @if ($demand->tax_type === 'ghar_patti') घरपट्टी
                                            @elseif ($demand->tax_type === 'paani_patti') पाणीपट्टी
                                            @else गाळाभाडे/व्यवसायकर/इतर
                                            @endif
                                        </td>
                                        <td>{{ $demand->year }}</td>
                                        <td>{{ $demand->period === 'magil' ? 'मागिल' : 'चालू' }}</td>
                                        <td>{{ number_format($demand->demand_amount, 2) }}</td>
                                        <td>{{ number_format($demand->collected_amount, 2) }}</td>
                                        <td>{{ $demand->percentage }}%</td>
                                        <td>
                                            <form action="{{ route('gpadmin.gp-tax.demands.updateStatus', $demand->id) }}" method="POST" class="d-inline-block status-form">
                                                @csrf
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-status"
                                                        {{ $demand->is_active ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                                <input type="hidden" name="is_active" value="{{ $demand->is_active ? 1 : 0 }}">
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.gp-tax.demands.edit', $demand->id) }}"
                                                class="btn btn-sm btn-outline-primary">संपादन</a>

                                            <form action="{{ route('gpadmin.gp-tax.demands.destroy', $demand->id) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">हटवा</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">कोणतीही कर मागणी आढळली नाही.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $demands->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.delete-form').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'हटवायचे आहे का?',
                    text: 'ही कर मागणी कायमची हटवली जाईल.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#E54545',
                    cancelButtonColor: '#708090',
                    confirmButtonText: 'हो, हटवा',
                    cancelButtonText: 'रद्द करा'
                }).then(result => { if (result.isConfirmed) form.submit(); });
            });

            $(document).on('change', '.toggle-status', function () {
                const cb = $(this);
                const form = cb.closest('form');
                const newVal = cb.is(':checked') ? 1 : 0;
                Swal.fire({
                    title: 'स्थिती बदलायची आहे का?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#27ae60',
                    cancelButtonColor: '#708090',
                    confirmButtonText: 'हो, बदला',
                    cancelButtonText: 'रद्द करा'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.find('input[name="is_active"]').val(newVal);
                        form.submit();
                    } else {
                        cb.prop('checked', !cb.is(':checked'));
                    }
                });
            });
        });
    </script>
@endpush

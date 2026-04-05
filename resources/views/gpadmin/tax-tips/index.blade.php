@extends('gpadmin.layout.master')

@section('title', 'कर टीप')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>कर टीप</h3>
                        <a href="{{ route('gpadmin.gp-tax.tips.create') }}" class="btn btn-sm btn-outline-primary">नवीन टीप जोडा</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>अ.नं.</th>
                                    <th>टीप मजकूर</th>
                                    <th>स्थिती</th>
                                    <th>कृती</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tips as $i => $tip)
                                    <tr>
                                        <td>{{ $tips->firstItem() + $i }}</td>
                                        <td>{{ $tip->tip_text }}</td>
                                        <td>
                                            @if ($tip->is_active)
                                                <span class="badge badge-success">सक्रिय</span>
                                            @else
                                                <span class="badge badge-secondary">निष्क्रिय</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.gp-tax.tips.edit', $tip->id) }}"
                                                class="btn btn-sm btn-outline-primary">संपादन</a>

                                            <form action="{{ route('gpadmin.gp-tax.tips.destroy', $tip->id) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">हटवा</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">कोणतीही टीप आढळली नाही.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $tips->links() }}
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
                if (!confirm('तुम्हाला ही टीप नक्की हटवायची आहे का?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush

@extends('gpadmin.layout.master')

@section('title', 'कर कागदपत्रे')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>कर कागदपत्रे व्यवस्थापन</h3>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @php
                        $taxLabels = [
                            'ghar_patti'  => 'घरपट्टी',
                            'paani_patti' => 'पाणीपट्टी',
                            'other'       => 'गाळाभाडे/व्यवसायकर/इतर कर',
                        ];
                        $docLabels = [
                            'view_pdf'   => 'PDF पहा',
                            'payment_qr' => 'QR पेमेंट',
                        ];
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>कराचा प्रकार</th>
                                    <th>PDF पहा (view_pdf)</th>
                                    <th>QR पेमेंट (payment_qr)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxTypes as $taxType)
                                    <tr>
                                        <td><strong>{{ $taxLabels[$taxType] }}</strong></td>

                                        @foreach ($documentTypes as $docType)
                                            <td>
                                                @php
                                                    $activeDoc = $activeDocuments[$taxType][$docType][0] ?? null;
                                                @endphp

                                                @if ($activeDoc)
                                                    <div class="mb-2">
                                                        <span class="badge bg-success">सक्रिय</span>
                                                        <br>
                                                        <small>{{ $activeDoc->file_name }}</small><br>
                                                        <small class="text-muted">{{ $activeDoc->created_at->format('d-m-Y') }}</small>
                                                        <br>
                                                        <a href="{{ asset('storage/' . $activeDoc->file_path) }}" target="_blank"
                                                            class="btn btn-xs btn-outline-info btn-sm mt-1">पहा</a>

                                                        <form action="{{ route('gpadmin.gp-tax.documents.destroy', $activeDoc->id) }}"
                                                            method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-xs btn-outline-danger btn-sm mt-1">हटवा</button>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                @else
                                                    <p class="text-muted small">कोणतेही सक्रिय कागदपत्र नाही.</p>
                                                @endif

                                                <form action="{{ route('gpadmin.gp-tax.documents.store') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="tax_type" value="{{ $taxType }}">
                                                    <input type="hidden" name="document_type" value="{{ $docType }}">
                                                    <div class="input-group input-group-sm">
                                                        <input type="file" name="file"
                                                            class="form-control form-control-sm @error('file') is-invalid @enderror"
                                                            accept="{{ $docType === 'view_pdf' ? '.pdf' : '.jpg,.jpeg,.png,.pdf' }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">अपलोड</button>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $docType === 'view_pdf' ? 'PDF फक्त, कमाल 10MB' : 'JPG/PNG/PDF, कमाल 5MB' }}
                                                    </small>
                                                </form>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                if (!confirm('तुम्हाला हे कागदपत्र नक्की हटवायचे आहे का?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush

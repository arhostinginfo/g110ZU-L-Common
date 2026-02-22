@extends('gpadmin.layout.master')

@section('title', 'PDF Upload')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>PDF Upload</h3>
                        <a href="{{ route('gpadmin.pdfupload.add') }}" class="btn btn-sm btn-outline-primary" >Add PDF</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gallaries as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $data->type_attachment }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                           @if ($data->type_attachment == 'pdf')
                                                <a href="{{ asset('storage/' . ($data->attachment ?? 'default.pdf')) }}" target="_blank">
                                                    <img 
                                                        src="{{ asset('images/pdf-icon.png') }}" 
                                                        alt="{{ $data->name ?? 'PDF File' }}"
                                                        class="img-fluid rounded mb-2"
                                                        style="height:150px; width:150px;">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.pdfupload.edit', base64_encode($data->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('gpadmin.pdfupload.delete') }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                <input type="hidden" name="encodedId"
                                                    value="{{ base64_encode($data->id) }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
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
        $(document).ready(function() {
            $('#officersTable').DataTable({
                responsive: true,
                paging: true,
                searching: false,
                lengthChange: false,
                pageLength: 10,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/mr.json"
                }
            });

            // simple delete confirm
            $('.delete-form').on('submit', function(e) {
                if (!confirm('तुम्हाला हा अधिकारी नक्की हटवायचा आहे का?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush

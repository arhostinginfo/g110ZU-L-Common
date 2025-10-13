@extends('gpadmin.layout.master')

@section('title', 'Gallary')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Gallary</h3>
                        <a href="{{ route('gpadmin.gallary.add') }}" class="btn btn-sm btn-outline-primary" >Add Gallary</a>
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
                                            @if ($data->type_attachment == 'Image')
                                                <img style="height: 150px;width: 150px;" style="height: 250px;width: 250px;"
                                                    src="{{ asset('storage/' . ($data->attachment ?? 'default.jpg')) }}"
                                                    alt="{{ $data->name ?? 'image name' }}" class="img-fluid rounded mb2">
                                            @elseif($data->type_attachment == 'Video')
                                                <video style="height: 150px;width: 150px;" controls>
                                                    <source src="{{ asset('storage/' . ($data->attachment ?? 'name of image')) }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.gallary.edit', base64_encode($data->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('gpadmin.gallary.delete') }}" method="POST"
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

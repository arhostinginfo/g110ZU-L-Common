@extends('gpadmin.layout.master')

@section('title', 'Yojna')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Yojna</h3>
                        <a href="{{ route('gpadmin.yojna.add') }}" class="btn btn-sm btn-outline-primary" >Add Yojna</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Link</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yojna as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $data->type_attachment }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->attachment_link }}</td>
                                       <td>
                                     @if ($data->type_attachment == 'Image')
                                         <img style="height: 250px;width: 250px;"
                                             src="{{ asset('storage/' . ($data->attachment ?? 'default.jpg')) }}"
                                             alt="{{ $data->name ?? 'image name' }}" class="img-fluid rounded mb2">
                                     @elseif($data->type_attachment == 'Link')
                                         <a class="one_rem info btn btn-primary btn-sm mt-2"
                                             href="{{ $data->attachment_link ?? 'image name' }}" target="_blank">इथे
                                             क्लिक करा</a>
                                     @elseif($data->type_attachment == 'PDF')
                                         <a href="{{ asset('storage/' . $data->attachment) }}" target="_blank"
                                             class="btn btn-danger btn-sm mt-2">
                                             PDF उघडा / डाउनलोड करा
                                         </a>
                                     @endif
                                 </td>
                                        <td>
                                            <a href="{{ route('gpadmin.yojna.edit', base64_encode($data->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('gpadmin.yojna.delete') }}" method="POST"
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

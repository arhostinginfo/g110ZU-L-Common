@extends('gpadmin.layout.master')

@section('title', 'famous-locations')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Famous Locations</h3>
                        <a href="{{ route('gpadmin.famous-locations.add') }}" class="btn btn-sm btn-outline-primary" >Add New Famous Locations</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($famouslocations as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->desc }}</td>
                                        <td>
                                            @if ($data->photo)
                                                <img style="height: 150px;width: 150px;"
                                                    src="{{ asset('storage/' . $data->photo) }}" alt="{{ $data->name }}"
                                                    class="table-img">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.famous-locations.edit', base64_encode($data->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('gpadmin.famous-locations.delete') }}" method="POST"
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
            $('#sliderTable').DataTable({
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

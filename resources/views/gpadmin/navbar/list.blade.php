@extends('gpadmin.layout.master')

@section('title', 'Website Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Website Details</h3>
                        <a href="{{ route('gpadmin.navbar.add') }}" class="btn btn-sm btn-outline-primary" >Add Website Details</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>क्र. नं.</th>
                                    <th>नाव</th>
                                    <th>फोटो</th>
                                    <th>क्रिया</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($navbar as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            @if ($data->photo)
                                                <img style="height: 250px;width: 250px;" src="{{ asset('storage/' . $data->photo) }}" alt="{{ $data->name }}"
                                                    class="table-img">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.navbar.edit', base64_encode($data->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('gpadmin.navbar.delete') }}" method="POST"
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

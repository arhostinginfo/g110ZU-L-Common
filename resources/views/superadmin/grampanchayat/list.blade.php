@extends('superadmin.layout.master-admin')

@section('title', 'GP Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>GP Details</h3>
                        <a href="{{ route('superadmin.admin-gp.add') }}" class="btn btn-sm btn-outline-primary">Add GP
                            Details</a>
                    </div>

                    <div class="table-responsive">
                        <table id="sliderTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>District</th>
                                    <th>Taluka</th>
                                    <th>GP Name</th>
                                    <th>GP Name In URL</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Valid Till</th>
                                    <th>Days Pending</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gpdetails as $i => $gp)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $gp->district_name }}</td>
                                        <td>{{ $gp->taluka_name }}</td>
                                        <td>{{ $gp->gp_name }}</td>
                                        <td>{{ $gp->gp_name_in_url }}</td>
                                        <td>{{ $gp->employee_email }}</td>
                                        <td>{{ $gp->employee_password }}</td>
                                        <td>{{ \Carbon\Carbon::parse($gp->gp_valid_till)->format('d-m-Y') }}</td>
                                        <td>
                                            <small class="text-muted"> {{ $gp->days_pending }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $gp->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $gp->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('superadmin.admin-gp.edit', base64_encode($gp->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('superadmin.admin-gp.delete') }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                <input type="hidden" name="encodedId"
                                                    value="{{ base64_encode($gp->id) }}">
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
                searching: true,
                lengthChange: false,
                pageLength: 10,
                ordering: true, // Enable sorting
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

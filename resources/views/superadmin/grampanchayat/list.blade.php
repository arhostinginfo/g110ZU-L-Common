@extends('superadmin.layout.master-admin')

@section('title', 'GP Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>GP Details</h3>
                        <a href="{{ route('superadmin.admin-gp.add') }}" class="btn btn-sm btn-outline-primary">Add GP Details</a>
                    </div>

                    <div class="table-responsive">
                        <table id="sliderTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>District</th>
                                    <th>Taluka</th>
                                    <th>GP Details</th>
                                    <th>GP Name</th>
                                    <th>GP Name In URL</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Check Website</th>
                                    <th>GP Login</th>
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
                                        <td>
                                            <div id="gp-info-{{ $gp->id }}">
                                                <strong>GP Website Link:</strong> {{ env('APP_URL') . $gp->gp_name_in_url }}<br>
                                                <strong>GP Admin Login Link:</strong> {{ env('APP_URL') }}login<br>
                                                <strong>GP Admin Username:</strong> {{ $gp->employee_email }}<br>
                                                <strong>GP Admin Password:</strong> {{ $gp->employee_password }}
                                            </div>

                                            <!-- Copy Button -->
                                            <button class="btn btn-sm btn-outline-secondary mt-1 copy-btn" data-target="gp-info-{{ $gp->id }}">
                                                📋 Copy
                                            </button>
                                        </td>

                                        <td>{{ $gp->gp_name }}</td>
                                        <td>{{ $gp->gp_name_in_url }}</td>
                                        <td>{{ $gp->employee_email }}</td>
                                        <td>{{ $gp->employee_password }}</td>
                                        <td>
                                            <a href="{{ env('APP_URL') . $gp->gp_name_in_url }}" target="_blank">
                                                Click
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('superadmin.supergpautologin') }}" method="POST" target="_blank">
                                                @csrf
                                                <input type="hidden" name="gp_id" value="{{ $gp->id }}">
                                                <button type="submit" class="btn btn-sm btn-link p-0">Click</button>
                                            </form>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($gp->gp_valid_till)->format('d-m-Y') }}</td>
                                        <td>
                                            <small class="text-muted"> {{ $gp->days_pending }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $gp->is_active ? 'text-green' : 'text-red' }}">
                                                {{ $gp->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('superadmin.admin-gp.edit', base64_encode($gp->id)) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('superadmin.admin-gp.delete') }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                <input type="hidden" name="encodedId" value="{{ base64_encode($gp->id) }}">
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
    <!-- Include jQuery and DataTables if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#sliderTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                lengthChange: false,
                pageLength: 10,
                ordering: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/mr.json"
                }
            });

            // Delete confirmation
            $('.delete-form').on('submit', function(e) {
                if (!confirm('तुम्हाला हा अधिकारी नक्की हटवायचा आहे का?')) {
                    e.preventDefault();
                }
            });

            // Copy to clipboard using modern Clipboard API
            $('.copy-btn').on('click', function() {
                const targetId = $(this).data('target');
                const text = document.getElementById(targetId).innerText;

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(function() {
                        alert('Copied!');
                    }).catch(function(err) {
                        console.error('Clipboard error:', err);
                        alert('Copy failed. Try manually.');
                    });
                } else {
                    // Fallback for old browsers
                    const tempInput = document.createElement('textarea');
                    tempInput.value = text;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    alert('Copied (fallback)!');
                }
            });
        });
    </script>
@endpush

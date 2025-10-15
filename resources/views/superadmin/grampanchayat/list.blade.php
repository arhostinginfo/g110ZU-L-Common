@extends('superadmin.layout.master-admin')

@section('title', 'GP Details')

@section('content')
    <!-- DataTables Core CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables Responsive Extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>GP Details</h3>
                        <a href="{{ route('superadmin.admin-gp.add') }}" class="btn btn-sm btn-outline-primary">Add GP
                            Details</a>
                    </div>
<div style="overflow-x: auto;">
    <table id="sliderTable" class="table table-bordered" style="min-width: 1200px;">
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
                                                <strong>GP Website Link:</strong>
                                                {{ env('APP_URL') . $gp->gp_name_in_url }}<br>
                                                <strong>GP Admin Login Link:</strong> {{ env('APP_URL') }}login<br>
                                                <strong>GP Admin Username:</strong> {{ $gp->employee_email }}<br>
                                                <strong>GP Admin Password:</strong> {{ $gp->employee_password }}
                                            </div>

                                            <!-- Copy Button -->
                                            <button class="btn btn-sm btn-outline-secondary mt-1 copy-btn"
                                                data-target="gp-info-{{ $gp->id }}">
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
                                            <form action="{{ route('superadmin.supergpautologin') }}" method="POST"
                                                target="_blank">
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // DataTable initialization
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

            // Copy button handler
            $('.copy-btn').on('click', function() {
                const targetId = $(this).data('target');
                const element = document.getElementById(targetId);
                const text = element ? element.textContent : '';

                if (!text) {
                    alert('No text found to copy.');
                    return;
                }

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Copied to clipboard!');
                    }).catch(err => {
                        console.error('Copy failed:', err);
                        fallbackCopyText(text);
                    });
                } else {
                    fallbackCopyText(text);
                }
            });

            function fallbackCopyText(text) {
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed'; // Prevent scrolling
                document.body.appendChild(textarea);
                textarea.focus();
                textarea.select();

                try {
                    const successful = document.execCommand('copy');
                    alert(successful ? 'Copied!' : 'Copy failed.');
                } catch (err) {
                    console.error('Fallback copy error:', err);
                    alert('Copy failed. Please copy manually.');
                }

                document.body.removeChild(textarea);
            }
        });
    </script>

@endsection

@extends('superadm.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                  

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>नाव</th> 
                                    <th>मोबाईल नंबर</th>
                                    <th>ईमेल</th>
                                    <th>संदेश</th>
                                    <!-- <th>Action Took</th> -->
                                    <!-- <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($abhiyans as $key => $abhiyan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $abhiyan->name }}</td>
                                        <td>{{ $abhiyan->mobile_no }}</td>
                                        <td>{{ $abhiyan->email }}</td>
                                        <td>{{ $abhiyan->message }}</td>
                                        <!-- <td>
                                            <form action="{{ route('contact.updatestatus') }}" method="POST"
                                                class="d-inline-block delete-form">
                                                @csrf
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-status"
                                                        data-id="{{ base64_encode($abhiyan->id) }}"
                                                        {{ $abhiyan->is_action_completed == 1 ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                                <input type="hidden" name="id"
                                                    value="{{ base64_encode($abhiyan->id) }}">
                                            </form>
                                        </td> -->
                                        <!-- <td>
                                            <a href="{{ route('abhiyan.edit', base64_encode($abhiyan->id)) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('abhiyan.delete') }}" method="POST"
                                                class="d-inline-block delete-form">
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ base64_encode($abhiyan->id) }}">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on("change", ".toggle-status", function(e) {
            e.preventDefault();

            let checkbox = $(this);
            let form = checkbox.closest("form");
            let id = checkbox.data("id");
            let is_active = checkbox.is(":checked") ? 1 : 0;

            // Show SweetAlert confirmation
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to change the status?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, change it!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Append or update hidden input with status
                    if (form.find("input[name='is_active']").length) {
                        form.find("input[name='is_active']").val(is_active);
                    } else {
                        form.append(
                            `<input type="hidden" name="is_active" value="${is_active}">`
                        );
                    }
                    form.submit(); // submit the form
                } else {
                    // If cancelled, revert checkbox back
                    checkbox.prop("checked", !checkbox.is(":checked"));
                }
            });
        });
    </script>
@endsection

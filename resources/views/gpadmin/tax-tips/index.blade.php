@extends('gpadmin.layout.master')

@section('title', 'कर टीप')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>कर टीप</h3>
                        <a href="{{ route('gpadmin.gp-tax.tips.create') }}" class="btn btn-sm btn-outline-primary">नवीन टीप जोडा</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatables">
                            <thead>
                                <tr>
                                    <th>अ.नं.</th>
                                    <th>टीप मजकूर</th>
                                    <th>स्थिती</th>
                                    <th>कृती</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tips as $i => $tip)
                                    <tr>
                                        <td>{{ $tips->firstItem() + $i }}</td>
                                        <td>{{ $tip->tip_text }}</td>
                                        <td>
                                            <form action="{{ route('gpadmin.gp-tax.tips.update', $tip->id) }}" method="POST" class="d-inline-block status-toggle-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="tip_text" value="{{ $tip->tip_text }}">
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-status"
                                                        {{ $tip->is_active ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('gpadmin.gp-tax.tips.edit', $tip->id) }}"
                                                class="btn btn-sm btn-outline-primary">संपादन</a>

                                            <form action="{{ route('gpadmin.gp-tax.tips.destroy', $tip->id) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn">हटवा</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">कोणतीही टीप आढळली नाही.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $tips->links() }}
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
            let is_active = checkbox.is(":checked") ? 1 : 0;
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
                    if (form.find("input[name='is_active']").length) {
                        form.find("input[name='is_active']").val(is_active);
                    } else {
                        form.append(`<input type="hidden" name="is_active" value="${is_active}">`);
                    }
                    form.submit();
                } else {
                    checkbox.prop("checked", !checkbox.is(":checked"));
                }
            });
        });
    </script>
@endsection

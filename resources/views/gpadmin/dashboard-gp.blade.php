@extends('gpadmin.layout.master')

@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <!-- Roles Card -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="{{ route('gpadmin.officers.list') }}" class="text-decoration-none text-dark">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div
                                                class="round round-lg text-white d-inline-block text-center rounded-circle bg-info">
                                              <i class="mdi mdi-account-key mdi-24px"></i>
                                            </div>
                                            <div class="ml-2 align-self-center">
                                                <h3 class="mb-0 font-weight-light">
                                                    Officers {{ $officers }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                       
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End of Page Content -->
    <!-- ============================================================== -->
@endsection

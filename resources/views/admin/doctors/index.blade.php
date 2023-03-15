@extends('layouts.app')

@section('title', 'Liste des médecins')

@include('includes.datatable', ['pageLength' => 20, 'AJAX_URL' => route('doctors.index')])

@push('scripts')
    <script>
        $(function() {
            $('#example1').on('draw.dt', function() {
                $('.edit-client-modal').on('show.bs.modal', function(event) {
                    $('.select2bs4-modal').select2({
                        theme: 'bootstrap4'
                    })
                })
            });
        });
    </script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Liste des médecins :</h3>
                            </div>

                            <div class="card-body">
                                @include('admin.doctors.includes.add')
                            </div>

                            {{ $datatable->drawTable() }}

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
@endsection

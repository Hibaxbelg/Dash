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

        let softwareVersions = @json($softwareVersions);

        function calculePrice(software_id, pc_numbers) {
            let software = softwareVersions.filter(software => software.id == software_id)[0];
            pc_numbers = Number(pc_numbers);
            if (pc_numbers == 0 || pc_numbers < software.min_pc_number) {
                return 0.0;
            }

            let price = software.price;

            // calculer le prix
            let additional_pc = pc_numbers - software.min_pc_number;

            if (additional_pc > 0) {
                price += additional_pc * software.price_per_additional_pc;
            }

            return price;
        }
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

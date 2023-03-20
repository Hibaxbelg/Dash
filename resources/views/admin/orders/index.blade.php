@extends('layouts.app')

@section('title', 'Liste des commandes')

@include('includes.datatable', ['AJAX_URL' => route('orders.index')])

<script>
    let products = @json($products);
</script>
@include('admin.doctors.includes.calcule-price')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Liste des commandes :</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

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

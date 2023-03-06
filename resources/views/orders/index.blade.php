@extends('layouts.app')


@section('title')
Commandes
@endsection

{{-- datatable --}}
@include('orders.includes.datatable')

{{-- Alert --}}
@include('includes.alert')

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

                            {{ $datatable->getSearchFields() }}

                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @foreach ($datatable->getColumns() as $column)
                                            <th>{{ $column['name'] }}</th>
                                            @endforeach
                                            <th>Etat</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

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
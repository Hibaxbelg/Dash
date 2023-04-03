@extends('layouts.app')

@section('title', 'Consulter les Tracabilités')

@include('includes.datatable', ['pageLength' => 20, 'AJAX_URL' => route('actions')])

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Consulter les Tracabilités :</h3>
                            </div>

                            <div class="card-body">
                                {{ $datatable->drawTable() }}
                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
@endsection

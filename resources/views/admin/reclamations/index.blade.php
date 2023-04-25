@extends('layouts.app')

@section('title', 'Liste des réclamations')

@include('includes.datatable', [ 'AJAX_URL' => route('reclamations.index')])

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Liste des réclamations :</h3>
                            </div>

                            <div class="card-body">
                                @include('admin.reclamations.includes.add')
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
        </section>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Liste des utilisateurs')

@include('includes.datatable', ['AJAX_URL' => route('users.index')])

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Liste des utilisateurs :</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @include('admin.users.includes.add')
                            </div>

                            {{ $datatable->drawTable() }}

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

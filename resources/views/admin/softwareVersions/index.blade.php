@extends('layouts.app')

@section('title', 'Liste versions du programme')

@include('includes.datatable', ['pageLength' => 20, 'AJAX_URL' => route('softwareVersions.index')])

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Liste versions du programme :</h3>
                            </div>

                            <div class="card-body">
                                @include('admin.softwareVersions.includes.add')

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

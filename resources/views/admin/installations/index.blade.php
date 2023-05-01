@extends('layouts.app')

@section('title', 'Liste des Installations')
@include('includes.datatable', ['AJAX_URL' => route('installations.index')])

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des installations
                        @if (!request()->type == 'demo')
                            Confirmés
                        @else
                            DEMO
                        @endif
                        :
                    </h3>
                </div>
                <div class="card-body">
                    {{ $datatable->drawTable() }}
                </div>
            </div>
        </div>
    </div>
@endsection

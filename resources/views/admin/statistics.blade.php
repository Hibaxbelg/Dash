@extends('layouts.app')

@section('title', 'Statistiques')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.6/axios.min.js"></script>
    <script>
        @php
            $colors = ['#c0392b', '#f39c12', '#16a085', '#2c3e50', '#8e44ad'];
        @endphp

        let medsGovChart = new Chart($('#meds-gov-chart').get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json(array_keys($doctors_gov->toArray())),
                datasets: [{
                        label: 'Commandes',
                        data: @json($doctors_gov->pluck('orders_count')),
                        fill: true,
                        backgroundColor: '#6777ef',
                        // borderColor: '6777ef'
                    },
                    @foreach ($products as $product)
                        {
                            // grouped: false,
                            label: '{{ $product->name }}',
                            data: @json($doctors_gov->map(fn($item) => $item['products'][$loop->index])->pluck('count')),
                            fill: true,
                            backgroundColor: '{{ $colors[$loop->index] }}',
                            // borderColor: '6777ef'
                        },
                    @endforeach
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        })


        let medsSpecChart = new Chart($('#meds-spec-chart').get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json(collect(array_keys($doctors_spec->toArray()))->map(fn($item) => str()->limit($item, 20, '...'))),
                datasets: [{
                        label: 'Commandes',
                        data: @json($doctors_spec->pluck('orders_count')),
                        fill: true,
                        backgroundColor: '#6777ef',
                        // borderColor: '6777ef'
                    },
                    @foreach ($products as $product)
                        {
                            // grouped: false,
                            label: '{{ $product->name }}',
                            data: @json($doctors_spec->map(fn($item) => $item['products'][$loop->index])->pluck('count')),
                            fill: true,
                            backgroundColor: '{{ $colors[$loop->index] }}',
                            // borderColor: '6777ef'
                        },
                    @endforeach
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        })

        let laboChart = new Chart($('#labo-chart').get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json(array_keys($labo_orders->toArray())),
                datasets: [{
                        label: 'Commandes',
                        data: @json($doctors_gov->pluck('orders_count')),
                        fill: true,
                        backgroundColor: '#6777ef',
                        // borderColor: '6777ef'
                    },
                    @foreach ($products as $product)
                        {
                            // grouped: false,
                            label: '{{ $product->name }}',
                            data: @json($labo_orders->map(fn($item) => $item['products'][$loop->index])->pluck('count')),
                            fill: true,
                            backgroundColor: '{{ $colors[$loop->index] }}',
                            // borderColor: '6777ef'
                        },
                    @endforeach
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        })
    </script>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="card">
                <div class="card-header bg-primary">
                    <i class="fa-solid fa-chart-area"></i> les commandes
                </div>
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa-solid fa-location-dot"></i> Commandes Par GouvName
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-toggle="tab" data-target="#tab-2" type="button" role="tab"
                                aria-controls="profile" aria-selected="false">
                                <i class="fa-solid fa-user-doctor"></i> Commandes Par Specialite
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-toggle="tab" data-target="#tab-3" type="button" role="tab"
                                aria-controls="profile" aria-selected="false">
                                <i class="fa-solid fa-building"></i> Commandes Par Labo
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content pt-2">
                        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            {{--  --}}
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">GouvName</th>
                                                    <th scope="col">Commandes</th>
                                                    @foreach ($products as $product)
                                                        <th scope="col">{{ $product->name }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($doctors_gov as $key => $data)
                                                    <tr>
                                                        <th scope="row">{{ $key }}</th>
                                                        <td>{{ $data['orders_count'] }}</td>
                                                        @foreach ($products as $product)
                                                            <td>{{ $data['products'][$loop->index]['count'] }}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="meds-gov-chart" style="min-height: 250px; height:1200px; max-width: 100%;">
                                    </canvas>
                                </div>
                            </div>
                            {{--  --}}
                        </div>
                        <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="tab-2">
                            {{--  --}}
                            <div class="row ">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Specialite</th>
                                                <th scope="col">Commandes</th>
                                                @foreach ($products as $product)
                                                    <th scope="col">{{ $product->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($doctors_spec as $key => $data)
                                                <tr>
                                                    <th scope="row">{{ $key }}</th>
                                                    <td>{{ $data['orders_count'] }}</td>
                                                    @foreach ($products as $product)
                                                        <td>{{ $data['products'][$loop->index]['count'] }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="meds-spec-chart" style="min-height: 250px; height:1200px; max-width: 100%;">
                                    </canvas>
                                </div>
                            </div>
                            {{--  --}}
                        </div>
                        <div class="tab-pane" id="tab-3" role="tabpanel" aria-labelledby="tab-3">
                            {{--  --}}
                            <div class="row ">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Specialite</th>
                                                <th scope="col">Commandes</th>
                                                @foreach ($products as $product)
                                                    <th scope="col">{{ $product->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($labo_orders as $key => $data)
                                                <tr>
                                                    <th scope="row">{{ $key }}</th>
                                                    <td>{{ $data['orders_count'] }}</td>
                                                    @foreach ($products as $product)
                                                        <td>{{ $data['products'][$loop->index]['count'] }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="labo-chart" style="min-width:300px;min-height: 350px;max-width: 100%;">
                                    </canvas>
                                </div>
                            </div>
                            {{--  --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

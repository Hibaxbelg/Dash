@extends('layouts.app')

@section('title', 'Acceuil')


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.6/axios.min.js"></script>
    <script>
        let ordersChart = new Chart($('#orders-chart').get(0).getContext('2d'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Commandes',
                    data: [],
                    fill: true,
                    backgroundColor: '#6777ef',
                    // borderColor: '6777ef'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        })

        let orders_select_month = document.getElementById('orders_select_month');

        function getOrdersByMonth(month) {
            orders_select_month.value = month;
            let year = new Date().getFullYear();

            const daysInThisMonth = new Date(year, month, 0).getDate();

            let dates = [];
            let orders_count = [];

            for (let i = 1; i <= daysInThisMonth; i++) {
                dates.push(`${i.toString().padStart(2,'0')}/${(month).toString().padStart(2,'0')}`);
                orders_count.push(0);
            }
            console.log(dates);
            axios.get("{{ route('statistics.orders') }}?month=" + month).then(response => {
                let data = response.data;
                console.log(data);
                // console.log(data);

                data.forEach(el => {
                    let _d = new Date(el.order_date);
                    el.order_date = (_d.getDate()).toString().padStart(2, '0') + '/' + (_d.getMonth() + 1)
                        .toString().padStart(2, '0');
                });
                console.log(data);
                // console.log(data);
                data.forEach(el => {
                    console.log(`Search for ${el.order_date}`)
                    let index = dates.findIndex((date) => date === el.order_date);
                    console.log(index);
                    orders_count[index] = el.orders_count;
                });
                ordersChart.data.labels = dates;
                ordersChart.data.datasets[0].data = orders_count;
                ordersChart.update();
            })
        }

        getOrdersByMonth(new Date().getMonth() + 1);

        orders_select_month.addEventListener('change', function() {
            getOrdersByMonth(this.value);
        });
    </script>

    <script>
        let reclamationsChart = new Chart($('#reclamations-chart').get(0).getContext('2d'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Temps en minutes',
                    data: [],
                    fill: true,
                    backgroundColor: '#6777ef',
                    // borderColor: '6777ef'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        })

        let reclamations_select_month = document.getElementById('reclamations_select_month');

        function getReclamationsByMonth(month) {
            reclamations_select_month.value = month;
            let year = new Date().getFullYear();

            const daysInThisMonth = new Date(year, month, 0).getDate();

            let dates = [];
            let response_in_minutes = [];

            for (let i = 1; i <= daysInThisMonth; i++) {
                dates.push(`${i.toString().padStart(2,'0')}/${(month).toString().padStart(2,'0')}`);
                response_in_minutes.push(0);
            }
            console.log(dates);
            axios.get("{{ route('statistics.reclamations') }}?month=" + month).then(response => {
                let data = response.data;
                console.log(data);
                // console.log(data);

                data.forEach(el => {
                    let _d = new Date(el.date);
                    el.date = (_d.getDate()).toString().padStart(2, '0') + '/' + (_d.getMonth() + 1)
                        .toString().padStart(2, '0');
                });
                console.log(data);
                // console.log(data);
                data.forEach(el => {
                    console.log(`Search for ${el.date}`)
                    let index = dates.findIndex((date) => date === el.date);
                    console.log(index);
                    response_in_minutes[index] = el.response_in_minutes;
                });
                reclamationsChart.data.labels = dates;
                reclamationsChart.data.datasets[0].data = response_in_minutes;
                reclamationsChart.update();
            })
        }

        getReclamationsByMonth(new Date().getMonth() + 1);

        reclamations_select_month.addEventListener('change', function() {
            getReclamationsByMonth(this.value);
        });
    </script>
@endpush


@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $orders_count }}</h3>
                                <p>Commandes</p>
                            </div>
                            <div class="icon">
                                <i class="icon fa-solid fa-cart-shopping"></i>
                            </div>
                            <a href="{{ route('orders.index') }}" class="small-box-footer">
                                Liste des commandes <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $users_count }}</h3>
                                <p>Utilisateurs Débridé</p>
                            </div>
                            <div class="icon">
                                <i class="icon fa-solid fa-users"></i>
                            </div>
                            <a href="{{ route('installations.index') }}" class="small-box-footer">Lite des
                                Utilisateurs Débridé <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $demo_count }}</h3>
                                <p>Utilisateurs Demo</p>
                            </div>
                            <div class="icon">
                                <i class="icon fa-solid fa-user-ninja"></i>
                            </div>
                            <a href="{{ route('installations.index') }}?type=demo" class="small-box-footer">
                                Liste des utilisateurs DEMO<i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $resolved_tickets }}</h3>
                                <p>Tickets résolus</p>
                            </div>
                            <div class="icon">
                                <i class="icon fa-solid fa-circle-check"></i>
                            </div>
                            <a href="{{ route('reclamations.index') }}" class="small-box-footer">Afficher <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <i class="fa-regular fa-handshake"></i> Les rendezvous de cette semaines
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Produit</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Adresse</th>
                                            <th scope="col">Téléphone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders_this_week as $order)
                                            <tr>
                                                <th scope="row">{{ $order->id }}</th>
                                                <td>{{ $order->date }}</td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        {{ $order->product->name }}
                                                    </span>
                                                </td>
                                                <td>{{ $order->doctor->FAMNAME }} {{ $order->doctor->SHORTNAME }}</td>
                                                <td>{{ $order->doctor->ADRESSE }},{{ $order->doctor->LOCALITE }},{{ $order->doctor->GOUVNAME }}
                                                </td>
                                                <td>{{ $order->doctor->TELEPHONE }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <i class="fa-regular fa-handshake"></i> Les produits les plus vendus
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nom Produit</th>
                                            <th scope="col">Nombre Commandes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products_order_counts as $product)
                                            <tr>
                                                <th scope="row">{{ $product->name }}</th>
                                                <td>{{ $product->order_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-primary">
                                <i class="fa-regular fa-handshake"></i> Avis des clients
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($qualites as $qualite)
                                        <div class="col-md-3 text-center">
                                            <h2> {{ $qualite['count'] }} <sup>
                                                    <small style="color:gray;font-size:13px">

                                                        {{ number_format(((float) $qualite['count'] * 100) / collect($qualites)->sum('count'), 2, '.', '') }}
                                                        %
                                                    </small>
                                                </sup>
                                            </h2>
                                            {!! $qualite['icon'] !!}
                                            <h5 class="mt-2">{{ $qualite['name'] }}</h5>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-primary">
                                <i class="fa-regular fa-handshake"></i> Temps moyen pour répondre aux réclamations
                            </div>
                            <div class="card-body">
                                <div class=" text-center">
                                    <h3>
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $reclamation_response_average_time }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary">
                        <i class="fa-solid fa-chart-area"></i> Nombre des commandes
                    </div>
                    <div class="card-body">
                        <select class="form-control" name="month" id="orders_select_month" style="max-width:200px">
                            <option value="1">Janvier</option>
                            <option value="2">Février</option>
                            <option value="3">Mars</option>
                            <option value="4">Avril</option>
                            <option value="5">Mai</option>
                            <option value="6">Juin</option>
                            <option value="7">Juillet</option>
                            <option value="8">Août</option>
                            <option value="9">Septembre</option>
                            <option value="10">Octobre</option>
                            <option value="11">Novembre</option>
                            <option value="12">Décembre</option>
                        </select>

                        <canvas id="orders-chart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                        </canvas>


                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary">
                        <i class="fa-solid fa-chart-area"></i> Temps moyen pour répondre aux réclamations
                    </div>
                    <div class="card-body">
                        <select class="form-control" name="month" id="reclamations_select_month"
                            style="max-width:200px">
                            <option value="1">Janvier</option>
                            <option value="2">Février</option>
                            <option value="3">Mars</option>
                            <option value="4">Avril</option>
                            <option value="5">Mai</option>
                            <option value="6">Juin</option>
                            <option value="7">Juillet</option>
                            <option value="8">Août</option>
                            <option value="9">Septembre</option>
                            <option value="10">Octobre</option>
                            <option value="11">Novembre</option>
                            <option value="12">Décembre</option>
                        </select>

                        <canvas id="reclamations-chart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
                        </canvas>


                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="col-sm-6">
                        <h1 class="s-1">Dashboard</h1>
                      </div>
                      <hr>
                      <div class="row">
                        <!-- commandes-->
                        <div class="col-lg-3 col-6">
                          <div class="small-box bg-primary">
                            <div class="inner">
                              <h3>{{ $orders }}</h3>
                              <p>Commandes en attente</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">Plus d'informations <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- reclamations -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                              <div class="inner">
                                <h3>{{ $reclamations }}</h3>
                                <p>Réclamations en attente</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                              </div>
                              <a href="#" class="small-box-footer">Plus d'informations <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                       <!--users-->
                       <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $medUsers }}</h3>
                                <p>Utilisateurs de Medwin</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">Plus d'informations <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                </div>
             </div>
        </div>

    </section>
</div>

@endsection

@extends('layouts.app')

@section('title', 'Liste des Installations')

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
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                @if (!request()->type == 'demo')
                                    <th>ID Commande</th>
                                @endif
                                <th>Medecin</th>
                                @if (!request()->type == 'demo')
                                    <th>Nombre des licences utilisées</th>
                                    <th>Etat</th>
                                    <th>?</th>
                                @else
                                    <th>Etat</th>
                                    <th>Date Installtion</th>
                                    <th>Date Expiration</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($installations as $installation)
                                <tr>
                                    @if (!request()->type == 'demo')
                                        <td>
                                            {{ $installation['order_id'] }}
                                        </td>
                                    @endif
                                    <td>
                                        {{ $installation['doctor']['FAMNAME'] ?? '' }}
                                        {{ $installation['doctor']['SHORTNAME'] ?? '' }}
                                    </td>
                                    @if (!request()->type == 'demo')
                                        <td>
                                            {{ $installation['installation_count'] }}/{{ $installation['order']['licenses'] }}
                                        </td>
                                        <td>
                                            @if ($installation['order']['status'] == 'in_progress')
                                                <span class="badge badge-danger"><i class="fas fa-circle-notch fa-spin"></i>
                                                    En Attend</span>
                                            @elseif($installation['order']['status'] == 'installed')
                                                <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i>
                                                    Installé</span>
                                            @else
                                                <span class="badge badge-warning">Annulé</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#installation-details-{{ $installation['order_id'] }}">
                                                <i class="fa-solid fa-list"></i> Afficher les détails
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#order-edit-{{ $installation['order_id'] }}">
                                                <i class="fa-solid fa-pen"></i> Modifier
                                            </button>

                                            {{-- edit modal --}}

                                            <div class="modal fade" id="order-edit-{{ $installation['order_id'] }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <form method="post"
                                                    onsubmit=SendRequest(event,"{{ route('installations.update-order-status', $installation['order_id']) }}","{{ route('installations.index') }}");>
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header main-bg">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    <i class="fa-solid fa-pen"></i> Modifier la commande
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @csrf
                                                                <div class="errors"></div>

                                                                <input type="hidden"
                                                                    value="{{ $installation['order_id'] }}"
                                                                    name="order_id">
                                                                <div class="form-group">
                                                                    <label>Etat :</label>
                                                                    <select name="status" class="form-control">
                                                                        <option @selected($installation['order']['status'] == 'installed')
                                                                            value="installed">
                                                                            Installé</option>
                                                                        <option @selected($installation['order']['status'] == 'in_progress')
                                                                            value="in_progress">En
                                                                            attend</option>
                                                                        <option @selected($installation['order']['status'] == 'canceled')
                                                                            value="canceled">
                                                                            Anulée
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    Modifier
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- details modal --}}

                                            <div class="modal fade"
                                                id="installation-details-{{ $installation['order_id'] }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header main-bg">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                <i class="fa-solid fa-list"></i> Afficher les
                                                                détails
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            .@foreach ($installation['installation'] as $data)
                                                                <h3>Licence #{{ $loop->index + 1 }}</h3>
                                                                <div class="form-group">
                                                                    <label>Date :</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $data['created_at'] }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>HDID :</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $data['hdid'] }}" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>CPUI :</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $data['cpui'] }}" disabled>
                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            @if ($installation->created_at->addDays(30) < now())
                                                <span class="badge badge-danger">Expiré</span>
                                            @else
                                                <span class="badge badge-success">Valide</span>
                                            @endif
                                        </td>
                                        <td>{{ $installation->created_at }}</td>

                                        <td>{{ $installation->created_at->addDays(30) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

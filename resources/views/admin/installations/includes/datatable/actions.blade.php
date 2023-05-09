<button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
    data-target="#installation-details-{{ $row['order_id'] }}">
    <i class="fa-solid fa-list"></i> Afficher les détails
</button>
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#order-edit-{{ $row['order_id'] }}">
    <i class="fa-solid fa-pen"></i> Modifier
</button>

{{-- edit modal --}}

<div class="modal fade" id="order-edit-{{ $row['order_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <form method="post"
        onsubmit=SendRequest(event,"{{ route('installations.update-order-status', $row['order_id']) }}","{{ route('installations.index') }}");>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fa-solid fa-pen"></i> Modifier la commande
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="errors"></div>

                    <input type="hidden" value="{{ $row['order_id'] }}" name="order_id">
                    <div class="form-group">
                        <label>Etat :</label>
                        <select name="status" class="form-control">
                            <option @selected($row['order']['status'] == 'installed') value="installed">
                                Installé</option>
                            <option @selected($row['order']['status'] == 'in_progress') value="in_progress">En
                                attend</option>
                            <option @selected($row['order']['status'] == 'canceled') value="canceled">
                                Anulée
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Modifier
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- details modal --}}

<div class="modal fade" id="installation-details-{{ $row['order_id'] }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header main-bg">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa-solid fa-list"></i> Afficher les
                    détails
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($row['installation'] as $data)
                    <h3>Licence #{{ $loop->index + 1 }}</h3>
                    <div class="form-group">
                        <label>Date :</label>
                        <input type="text" class="form-control" value="{{ $data['created_at'] }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>HDID :</label>
                        <input type="text" class="form-control" value="{{ $data['hdid'] }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>CPUI :</label>
                        <input type="text" class="form-control" value="{{ $data['cpui'] }}" disabled>
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

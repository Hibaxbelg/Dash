<div class="modal fade" id="order-edit-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('orders.update', $row->id) }}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier Commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @csrf
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label>Date</label>
                        <input type="datetime-local" class="form-control" name="date" value="{{ $row->date }}">
                    </div>
                    <div class="form-group">
                        <label>Nombre des postes :</label>
                        <input type="number" min="1" class="form-control" name="posts" required
                            value="{{ $row->posts }}">
                    </div>
                    <div class="form-group">
                        <label>Note </label>
                        <textarea class="form-control" name="textarea">{{ $row->note }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Etat</label>
                        <select class="form-control" name="status">
                            <option @selected($row->status == 'installed') value="installed">Installé</otpion>
                            <option @selected($row->status == 'in_progress') value="in_progress">En attend
                                </otpion>
                            <option @selected($row->status == 'canceled') value="canceled">Anulée</otpion>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
        </form>
    </div>
</div>

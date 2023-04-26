<div class="modal fade" id="show-reclamation-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header main-bg">
                <h5 class="modal-title" id="exampleModalLongTitle">Reclamation #{{ $row->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="errors"></div>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Objet</label>
                            <input type="text" class="form-control" name="objet" value="{{ $row->objet }}"
                                disabled required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>solution</label>
                            <input type="text" min="1" class="form-control" name="solution"
                                value="{{ $row->solution }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Intervenant :</label>
                        <select name="user_id" class="form-control" disabled>
                            @foreach ($users as $user)
                                <option @selected($user->id == $row->user_id) value="{{ $user->id }}">
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label>description</label>
                        <div class="input-group">
                            <input disabled type="text" step="0.1" min="1" class="form-control"
                                name="description<" value="{{ $row->description }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Etat :</label>
                        <select disabled name="status" class="form-control">
                            <option @selected($row->status == 'resolved') value="resolved">Résolue</option>
                            <option @selected($row->status == 'in_progress') value="in_progress">En attente</option>
                            <option @selected($row->status == 'closed') value="closed">Fermée</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Confirmer</button>
            </div>
        </div>
    </div>
</div>

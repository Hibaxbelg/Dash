<div class="modal fade" id="users-edit-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post"
                onsubmit=SendRequest(event,"{{ route('users.update', $row->id) }}","{{ route('users.index') }}");>
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <i class="fa-solid fa-pen"></i> Modifier l'utilisateur {{ $row->name }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors"></div>
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" value="{{ $row->name }}" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="email" value="{{ $row->email }}" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Role :</label>
                        <select name="role" class="form-control">
                            <option @selected($row->role == 'admin') value="admin">admin</option>
                            <option @selected($row->role == 'super-admin') value="super-admin">Super Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Etat :</label>
                        <select name="is_active" class="form-control">
                            <option @selected($row->is_active) value="1">Compte Activé</option>
                            <option @selected(!$row->is_active) value="0">Compte Desactivé</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

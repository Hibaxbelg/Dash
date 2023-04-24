<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-user">
    <i class="fa-solid fa-circle-plus"></i> Ajouter un utilisateur
</button>

<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" onsubmit=SendRequest(event,"{{ route('users.store') }}","{{ route('users.index') }}");>
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors"></div>
                    @csrf
                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Mot de passe :</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirmation Mot de passe :</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label>Role :</label>
                        <select name="role" class="form-control">
                            <option value="admin">admin</option>
                            <option value="super-admin">Super Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </div>
        </form>

    </div>
</div>

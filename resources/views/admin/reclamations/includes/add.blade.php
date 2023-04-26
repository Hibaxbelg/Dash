@pushIf(count($errors) > 0, 'scripts')
<script>
    $("#add-reclamation").modal()
</script>
@endPushIf

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-reclamation">
    <i class="fa-solid fa-square-plus"></i> Ajouter réclamation
</button>

<div class="modal fade" id="add-reclamation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('reclamations.store') }}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter reclamation</h5>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Objet :</label>
                                <input type="text" class="form-control" name="objet" value="{{ old('objet') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Solution :</label>
                                <input type="text" class="form-control" name="solution"
                                    value="{{ old('solution') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label>description :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="description"
                                    value="{{ old('description') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Intervenant :</label>
                            <select name="user_id" class="form-control">
                                @foreach (App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </div>
        </form>

    </div>
</div>

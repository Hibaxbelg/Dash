<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouter-client">
    <i class="fa-solid fa-square-plus"></i> Ajouter client
</button>

<div class="modal fade" id="ajouter-client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('clients.store') }}">

            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-xmark"></i> {{ $error }}
                    </div>
                    @endforeach
                    @endif
                    @csrf
                    <div class="form-group">
                        <label>CNAMID</label>
                        <input type="text" class="form-control" name="CNAMID" value="{{ old('CNAMID') }}">
                    </div>
                    <div class="form-group">
                        <label>FAMNAME</label>
                        <input type="text" class="form-control" name="FAMNAME" value="{{ old('FAMNAME') }}">
                    </div>
                    <div class="form-group">
                        <label>SHORTNAME</label>
                        <input type="text" class="form-control" name="SHORTNAME" value="{{ old('SHORTNAME') }}">
                    </div>
                    <div class="form-group">
                        <label>SPECIALITE</label>
                        <input type="text" class="form-control" name="SPECIALITE" value="{{ old('SPECIALITE') }}">
                    </div>
                    <div class="form-group">
                        <label>GSM</label>
                        <input type="text" class="form-control" name="GSM" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
        </form>

    </div>
</div>

<div class="modal fade" id="sotware-version-edit-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('softwareVersions.update', $row->id) }}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier la version</h5>
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
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Nom Version</label>
                                <input type="text" required class="form-control" name="name"
                                    value="{{ $row->name }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Min Posts</label>
                                <input type="number" min="1" required class="form-control" name="min_pc_number"
                                    value="{{ $row->min_pc_number }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Prix</label>
                            <div class="input-group">
                                <input type="number" step="0.1" min="1" class="form-control" name="price"
                                    value="{{ $row->price }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Prix PC supplémentaire</label>
                            <div class="input-group">
                                <input type="number" step="0.1" class="form-control" name="price_per_additional_pc"
                                    value="{{ $row->price_per_additional_pc }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label>TVA</label>
                            <div class="input-group">
                                <input type="number" min="0" max="100" class="form-control" name="tva"
                                    value="{{ $row->tva }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit-product-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('products.update', $row->id) }}">
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
                                <input type="text" class="form-control" name="name" value="{{ $row->name }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Min Posts</label>
                                <input type="number" min="1" class="form-control" name="min_pc_number"
                                    value="{{ $row->min_pc_number }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Prix</label>
                            <div class="input-group">
                                <input type="number" step="0.1" min="1" class="form-control" name="price"
                                    value="{{ $row->price }}" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Prix hors promotion</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="price_without_promo"
                                    value="{{ $row->price_without_promo }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
                            <small>Laissez vide s'il n'y a pas de promotion</small>
                        </div>
                        <div class="col-6">
                            <label>Prix PC supplémentaire</label>
                            <div class="input-group">
                                <input type="number" step="0.1" class="form-control" name="price_per_additional_pc"
                                    value="{{ $row->price_per_additional_pc }}" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
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

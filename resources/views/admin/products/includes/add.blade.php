@pushIf(count($errors) > 0 && !Session::has('modal'), 'scripts')
<script>
    $("#add-product").modal()
</script>
@endPushIf

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-product">
    <i class="fa-solid fa-circle-plus"></i> Ajouter Produit
</button>

<div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('products.store') }}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter produit</h5>
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
                                <label>Nom Version</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Min Posts</label>
                                <input type="text" class="form-control" name="min_pc_number"
                                    value="{{ old('min_pc_number') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Prix</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Prix hors promotion</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="price_without_promo"
                                    value="{{ old('price_without_promo') }}">
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
                                    value="{{ old('price_per_additional_pc') }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">DT</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
        </form>

    </div>
</div>

@if ($row->previous_data)
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
        data-target="#show-details-{{ $row->id }}">
        <i class="fa-solid fa-list"></i> Afficher les détails
    </button>

    <div class="modal fade" id="show-details-{{ $row->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('products.store') }}">
                <div class="modal-content">
                    <div class="modal-header main-bg">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            <i class="fa-solid fa-list"></i> Les détails
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($row->previous_data as $key => $value)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ $key }} :</label>
                                        <input type="text" value="{{ $value }}" class="form-control" disabled>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
            </form>

        </div>
    </div>
@endif

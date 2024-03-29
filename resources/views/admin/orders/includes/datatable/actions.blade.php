<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#order-show-{{ $row->id }}-modal">
            <i class="fa-solid fa-eye"></i> Afficher
        </a>
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#order-edit-{{ $row->id }}-modal">
            <i class="fa-solid fa-pen"></i> Modifier
        </a>

            <div class="dropdown-divider"></div>
            <a style="cursor: pointer;" class="dropdown-item"
                onClick="document.getElementById('order-delete-{{ $row->id }}-form').submit();">
                <i class="fa-solid fa-trash"></i> Supprimer
                <form method="post" action="{{ route('orders.destroy', $row->id) }}"
                    id="order-delete-{{ $row->id }}-form" action="" style="display:none">
                    @csrf
                    @method('delete')
                </form>
            </a>

    </div>
</div>

@include('admin.orders.includes.datatable.modals.show')
@include('admin.orders.includes.datatable.modals.edit')

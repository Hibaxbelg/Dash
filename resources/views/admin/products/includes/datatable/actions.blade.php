<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#edit-product-{{ $row->id }}-modal">
            <i class="fa-solid fa-pen"></i> Modifier
        </a>
        @can('delete-order')
            <div class="dropdown-divider"></div>
            <a style="cursor: pointer;" class="dropdown-item"
                onClick="document.getElementById('delete-product-{{ $row->id }}-form').submit();">
                <i class="fa-solid fa-trash"></i> Supprimer
                <form method="post" action="{{ route('products.destroy', $row->id) }}"
                    id="delete-product-{{ $row->id }}-form" action="" style="display:none">
                    @csrf
                    @method('delete')
                </form>
            </a>
        @endcan
    </div>
</div>

@include('admin.products.includes.datatable.modals.edit')

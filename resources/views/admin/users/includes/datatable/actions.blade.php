<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#users-edit-{{ $row->id }}-modal">
            <i class="fa-solid fa-pen"></i> Modifier
        </a>
        {{-- <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item"
            onClick="document.getElementById('users-delete-{{ $row->id }}-form').submit();">
            <i class="fa-solid fa-trash"></i> Supprimer
            <form method="post" action="{{ route('users.index', $row->id) }}"
                id="users-delete-{{ $row->id }}-form" action="" style="display:none">
                @csrf
                @method('delete')
            </form>
        </a> --}}
    </div>
</div>

@include('admin.users.includes.datatable.modals.edit')
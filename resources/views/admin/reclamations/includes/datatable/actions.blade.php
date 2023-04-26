<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#show-reclamation-{{ $row->id }}-modal">
            <i class="fa-solid fa-eye"></i> Afficher
        </a>
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#edit-reclamation-{{ $row->id }}-modal">
            <i class="fa-solid fa-pen"></i> Modifier
        </a>
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item"
            onClick="confirm_delete(function(){
                    document.getElementById('delete-reclamation-{{ $row->id }}-form').submit();
                })">
            <i class="fa-solid fa-trash"></i> Supprimer
            <form method="post" action="{{ route('reclamations.destroy', $row->id) }}"
                id="delete-reclamation-{{ $row->id }}-form" action="" style="display:none">
                @csrf
                @method('delete')
            </form>
        </a>
    </div>
</div>

@include('admin.reclamations.includes.datatable.modals.show')
@include('admin.reclamations.includes.datatable.modals.edit')

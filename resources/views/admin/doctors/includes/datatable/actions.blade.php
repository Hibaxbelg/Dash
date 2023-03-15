<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#edit-doctor-{{ $row->RECORD_ID }}">
            <i class="fa-solid fa-user-pen"></i> Modifier
        </a>

        @can('delete-doctor')
            <div class="dropdown-divider"></div>
            <a style="cursor: pointer;" class="dropdown-item"
                onClick="document.getElementById('doctor-delete-form-{{ $row->RECORD_ID }}').submit();">
                <i class="fa-solid fa-trash"></i> Supprimer
                <form method="post" id="doctor-delete-form-{{ $row->RECORD_ID }}"
                    action="{{ route('doctors.destroy', $row->RECORD_ID) }}" style="display:none">
                    @csrf
                    @method('delete')
                    <button></button>
                </form>
            </a>
        @endcan
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#create-order-{{ $row->RECORD_ID }}">
            <i class="fa-solid fa-circle-plus"></i> Creer une commande
        </a>
    </div>
</div>


@include('admin.doctors.includes.datatable.modals.create-order')
@include('admin.doctors.includes.datatable.modals.edit')

@if ($row->action == 'delete')
    <span class="badge badge-danger"><i class="fa-solid fa-trash"></i> Suppression</span>
@elseif($row->action == 'update')
    <span class="badge badge-warning text-white"><i class="fa-solid fa-pen"></i> Modification</span>
@else
    <span class="badge badge-primary"><i class="fa-solid fa-plus"></i> Ajout</span>
@endif

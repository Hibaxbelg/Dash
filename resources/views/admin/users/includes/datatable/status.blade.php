@if ($row->is_active)
    <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Compte Activé</span>
@else
    <span class="badge badge-danger"><i class="fa-solid fa-circle-xmark"></i> Compte Desactivé</span>
@endif

@if ($row->status == 'in_progress')
    <span class="badge badge-danger"><i class="fas fa-circle-notch fa-spin"></i> En Attente</span>
@elseif($row->status == 'installed')
    <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Installé</span>
@else
    <span class="badge badge-warning">Annulé</span>
@endif

@if ($row->status == 'in_progress')
    <span class="badge badge-danger"><i class="fas fa-circle-notch fa-spin"></i> En attente</span>
@elseif($row->status == 'resolved')
    <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Résolue</span>
@else
    <span class="badge badge-warning">Fermée</span>
@endif

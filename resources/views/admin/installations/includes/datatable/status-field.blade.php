@if (!request()->type == 'demo')
    @if ($row['order']['status'] == 'in_progress')
        <span class="badge badge-danger"><i class="fas fa-circle-notch fa-spin"></i>
            En Attend</span>
    @elseif($row['order']['status'] == 'installed')
        <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i>
            Installé</span>
    @else
        <span class="badge badge-warning">Annulé</span>
    @endif
@else
    @if ($row->created_at->addDays(30) < now())
        <span class="badge badge-danger">Expiré</span>
    @else
        <span class="badge badge-success">Valide</span>
    @endif
@endif

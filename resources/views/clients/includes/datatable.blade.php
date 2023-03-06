@push('scripts')
<script>
  var table;
  $(function () {

     table = $("#example1").DataTable({
      dom: 'lBrtip',
      language : {
          url : 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/fr-FR.json'
      },
      ajax: "{{ route('clients.index') }}",
      processing: true,
      serverSide: true,
      pageLength : 50,
      columns: [
      @foreach ($datatable->getColumns() as $column )
      {data: "{{ $column['data' ]}}",name: "{{ $column['data' ]}}"},
      @endforeach
      {
                data : null,
                render : function(data,type,row,meta){
                  var update_url = "{{ route('clients.update', ':id') }}".replace(':id', data.RECORD_ID);
                  var delete_url = "{{ route('clients.destroy', ':id') }}".replace(':id', data.RECORD_ID);
                  return `


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#modifier-client-${data.RECORD_ID}">
            <i class="fa-solid fa-user-pen"></i> Modifier
        </a>

        @can('delete-client')
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item"
            onClick="document.getElementById('client-delete-form-${data.RECORD_ID}').submit();">
            <i class="fa-solid fa-trash"></i> Supprimer
            <form method="post" id="client-delete-form-${data.RECORD_ID}" action="${delete_url}" style="display:none">
                @csrf
                @method('delete')
                <button></button>
            </form>
        </a>
        @endcan
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#create-commande-${data.RECORD_ID}">
            <i class="fa-solid fa-circle-plus"></i> Creer une commande
        </a>
    </div>
</div>



<div class="modal fade" id="create-commande-${data.RECORD_ID}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action='http://localhost:8000/clients/${data.RECORD_ID}/commandes'>
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf

                    <input type="hidden" class="form-control" name="id" value="${data.RECORD_ID}">

                    <div class="form-group">
                        <label>Date</label>
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Note :</label>
                        <textarea type="date" class="form-control" name="note"
                            placeholder="ajouter une note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

</div>



<div class="modal fade" id="modifier-client-${data.RECORD_ID}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="${update_url}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-xmark"></i> {{ $error }}
                    </div>
                    @endforeach
                    @endif
                    @csrf
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label>CNAMID</label>
                        <input type="text" class="form-control" name="CNAMID" value="${data.CNAMID}">
                    </div>
                    <div class="form-group">
                        <label>FAMNAME</label>
                        <input type="text" class="form-control" name="FAMNAME" value="${data.FAMNAME}">
                    </div>
                    <div class="form-group">
                        <label>SHORTNAME</label>
                        <input type="text" class="form-control" name="SHORTNAME" value="${data.SHORTNAME}">
                    </div>
                    <div class="form-group">
                        <label>SPECIALITE</label>
                        <input type="text" class="form-control" name="SPECIALITE" value="${data.SPECIALITE}">
                    </div>
                    <div class="form-group">
                        <label>GSM</label>
                        <input type="text" class="form-control" name="GSM" value="${data.GSM}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
        </form>
    </div>
</div>
                    `;
                }
    }
  ],
      "responsive": false, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy","csv", "excel", "pdf"]

    });
    // .buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    table.on( 'preDraw', function () {
        // alert( 'processing' );
        $("#example1_wrapper").css({opacity : 0.75});
    } );

    table.on( 'draw', function () {
      $("#example1_wrapper").css({opacity : 1});

    } );

    $('.datatable-filter').on('keyup change', function(e) {
      let column_id = $(this).attr("data-column-id");
      // if(this.type != "select" || e.keyCode == 13){
        console.log(`Searching for ${this.value} in column ${column_id}`);
        table.column(column_id).search(this.value).draw();

      // }
    });

  });
</script>
@endpush
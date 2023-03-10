@push('scripts')
<script>
    var table;
  $(function () {

     table = $("#example1").DataTable({
      dom: 'lBrtip',
      language : {
          url : 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/fr-FR.json'
      },
      ajax: "{{ route('doctors.index') }}",
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
                  var update_url = "{{ route('doctors.update', ':id') }}".replace(':id', data.RECORD_ID);
                  var delete_url = "{{ route('doctors.destroy', ':id') }}".replace(':id', data.RECORD_ID);
                  var create_order_url = "{{ route('orders.store') }}";
                  return `


<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#edit-doctor-${data.RECORD_ID}">
            <i class="fa-solid fa-user-pen"></i> Modifier
        </a>

        @can('delete-doctor')
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item"
            onClick="document.getElementById('doctor-delete-form-${data.RECORD_ID}').submit();">
            <i class="fa-solid fa-trash"></i> Supprimer
            <form method="post" id="doctor-delete-form-${data.RECORD_ID}" action="${delete_url}" style="display:none">
                @csrf
                @method('delete')
                <button></button>
            </form>
        </a>
        @endcan
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#create-order-${data.RECORD_ID}">
            <i class="fa-solid fa-circle-plus"></i> Creer une commande
        </a>
    </div>
</div>



<div class="modal fade" id="create-order-${data.RECORD_ID}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action='${create_order_url}'>
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
                        <label>Nombre des postes :</label>
                        <input type="number" min="1" class="form-control" name="posts" required>
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


{{-- ====  EDIT CLIENT MODEL ==== --}}

<div class="modal fade edit-client-modal" id="edit-doctor-${data.RECORD_ID}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" action="${update_url}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier M??decin</h5>
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

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>CNAMID</label>
                                <input type="text" class="form-control" name="CNAMID" value="${data.CNAMID}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>SPECIALITE</label>
                                <select name="SPECIALITE" class="form-control select2bs4 select2bs4-modal">
                                    @foreach ($specialites as $specialite)
                                    <option value="{{ $specialite }}" ${data.SPECIALITE == '{{  $specialite }}' ? 'selected' : ''}>{{ $specialite }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>SHORTNAME</label>
                                <input type="text" class="form-control" name="SHORTNAME" value="${data.SHORTNAME}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>FAMNAME</label>
                                <input type="text" class="form-control" name="FAMNAME" value="${data.FAMNAME}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>GOUVNAME</label>
                                    <select name="GOUVNAME" class="form-control select2bs4 select2bs4-modal">
                                    @foreach ($gouvnames as $gouvname)
                                    <option value="{{ $gouvname }}" ${data.GOUVNAME == '{{  $gouvname }}' ? 'selected' : ''}>{{ $gouvname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>LOCALITE</label>
                                <select name="LOCALITE" class="form-control select2bs4 select2bs4-modal">
                                    @foreach ($localites as $localite)
                                    <option value="{{ $localite }}" ${data.LOCALITE == '{{  $localite }}' ? 'selected' : ''}>{{ $localite }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>ADRESSE</label>
                                <input type="text" class="form-control" name="ADRESSE" value="${data.ADRESSE}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>GSM</label>
                                <input type="text" class="form-control" name="GSM" value="${data.GSM}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>TELEPHONE</label>
                                <input type="text" class="form-control" name="TELEPHONE"
                                    value="${data.TELEPHONE}">
                            </div>
                        </div>
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

    // $('.datatable-filter').on('keyup change', function(e) {
    //   let column_id = $(this).attr("data-column-id");
    //   // if(this.type != "select" || e.keyCode == 13){
    //     console.log(`Searching for ${this.value} in column ${column_id}`);
    //     table.column(column_id).search(this.value).draw();

    //   // }
    // });

  });
</script>
@endpush
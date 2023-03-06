@push('scripts')
<script>
  var table;
  $(function () {

     table = $("#example1").DataTable({
      dom: 'lBrtip',
      language : {
          url : 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/fr-FR.json'
      },
      ajax: "{{ route('orders.index') }}",
      processing: true,
      serverSide: true,
      pageLength : 50,
      columns: [
      @foreach ($datatable->getColumns() as $column )
      {data: "{{ $column['data']}}",name: "{{ $column['data']}}"},
      @endforeach
      {
        data: 'status',
         render : function(data,type,row,meta){
          console.log(data);
          if(data == 'in_progress'){
            return '<span class="badge badge-danger"><i class="fas fa-circle-notch fa-spin"></i> En Attend</span>';
          }else if(data == 'installed'){
            return '<span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Installé</span>';
          }else{
            return '<span class="badge badge-warning">Annulé</span>';
          }
         }
    },
    {
      data : null,
      render : function(data,type,row,meta){
        var update_url = "{{ route('orders.update', ':id') }}".replace(':id', data.id);
        var delete_url = "{{ route('orders.destroy', ':id') }}".replace(':id', data.id);
        var error_modal = null;
        @if(Session::has('modal'))
         error_modal =  "{{ Session::get('modal') }}";
        @endif
        return `

<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#order-edit-${data.id}-modal">
            <i class="fa-solid fa-pen"></i> Modifier
        </a>
        @can('delete-client')
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item"
            onClick="document.getElementById('order-delete-${data.id}-form').submit();">
            <i class="fa-solid fa-trash"></i> Supprimer
            <form method="post" action="${delete_url}" id="order-delete-${data.id}-form" action="" style="display:none">
                @csrf
                @method('delete')
            </form>
        </a>
        @endcan
    </div>
</div>


{{-- ==== ORDER EDIT MODEL ==== --}}

<div class="modal fade" id="order-edit-${data.id}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="${update_url}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier Commande</h5>
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
                        <label>Date</label>
                        <input type="datetime-local" class="form-control" name="date" value="${data.date}">
                    </div>
                    <div class="form-group">
                        <label>Note </label>
                        <textarea class="form-control" name="textarea">${data.note ?? ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Etat</label>
                        <select class="form-control" name="status">
                          <option value="installed" ${data.status == 'installed' ?  'selected' : ''}>Installé</otpion>
                          <option value="in_progress" ${data.status == 'in_progress' ?  'selected' : ''}>En attend</otpion>
                          <option value="canceled" ${data.status == 'canceled' ?  'selected' : ''}>Anulée</otpion>
                        </select>
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
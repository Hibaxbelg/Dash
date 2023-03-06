@push('scripts')
<script>
  var table;
  $(function () {

     table = $("#example1").DataTable({
      dom: 'lBrtip',
      language : {
          url : 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/fr-FR.json'
      },
      ajax: "{{ route('clients.commandes.index') }}",
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
                  // var update_url = "{{ route('clients.update', ':id') }}".replace(':id', data.RECORD_ID);
                  // var delete_url = "{{ route('clients.destroy', ':id') }}".replace(':id', data.RECORD_ID);
                  // return `
                  // ${data.status == 'in_progress' ? '<span class="badge badge-danger">   <i class="fas fa-circle-notch fa-spin"></i> En Attend</span>' : ''}
                  // ${data.status == 'installed	' ? '<span class="badge badge-success">Installé</span>' : ''}
                  //   `;
         }
    },
    {
      data : null,
      render : function(data,type,row,meta){
        return `
        
        <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
    </button>

    <div class="dropdown-menu">
        <a style="cursor: pointer;" class="dropdown-item" data-toggle="modal"
            data-target="#modifier-client-${data.id}">
            <i class="fa-solid fa-user-pen"></i> Modifier
        </a>

        @can('delete-client')
        <div class="dropdown-divider"></div>
        <a style="cursor: pointer;" class="dropdown-item"
            onClick="document.getElementById('client-delete-form-${data.id}').submit();">
            <i class="fa-solid fa-trash"></i> Supprimer
            <form method="post" id="client-delete-form-${data.id}" action="" style="display:none">
                @csrf
                @method('delete')
                <button></button>
            </form>
        </a>
        @endcan
 
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
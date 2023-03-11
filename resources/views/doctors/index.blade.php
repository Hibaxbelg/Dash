@extends('layouts.app')


@section('title')
Medecins
@endsection

{{-- datatable --}}
@include('doctors.includes.datatable')

{{-- Alert --}}
@include('doctors.includes.alert')

{{-- validation ajouter client --}}

@push('scripts')
@if(count($errors) > 0)
<script>
  $("#add-doctor").modal()
</script>
@endif
@endpush

@push('scripts')
<script>
  $(function(){
    $('#example1').on( 'draw.dt', function () {
      $('.edit-client-modal').on('show.bs.modal', function (event) {
        $('.select2bs4-modal').select2({
          theme: 'bootstrap4'
        })
      })
    });
});
</script>
@endpush
@section('content')
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des médecins :</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @include('doctors.includes.add')
            </div>

            {{ $datatable->getSearchFields() }}

            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    @foreach ($datatable->getColumns() as $column)
                    <th>{{ $column['name'] }}</th>
                    @endforeach
                  </tr>
                </thead>
              </table>
            </div>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@endsection
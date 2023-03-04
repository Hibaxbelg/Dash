@extends('layouts.app')


@section('title')
    Clients
@endsection

{{-- datatable --}}
@include('clients.includes.datatable')

{{-- Alert --}}
@include('clients.includes.alert')

{{-- validation ajouter client --}}

@push('scripts')
@if(count($errors) > 0)
<script>
  $("#ajouter-client").modal()
</script>
@endif
@endpush

@section('content')
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des clients :</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @include('clients.includes.add-client')
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

{{ $datatable->buildSearchInputs() }}

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

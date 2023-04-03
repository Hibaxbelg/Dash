@push('scripts')
    <script>
        $('.select2').select2()

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        function reset() {
            let inputs = document.getElementsByClassName('datatable-filter');

            $(".select2bs4").trigger("change");

            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
                table.column(inputs[i].getAttribute("data-column-id")).search('');
            }

            table.draw();

        }

        function search() {

            let inputs = document.getElementsByClassName('datatable-filter');

            for (var i = 0; i < inputs.length; i++) {
                let column_id = inputs[i].getAttribute('data-column-id');
                let value = inputs[i].value;
                // table.column(column_id).search(this.value).draw();
                // table.column(inputs[i].getAttribute("data-column-id")).search(inputs[i].value);
                table.column(column_id).search(value);
            }

            table.draw();
        }
    </script>
@endpush
<div class="row my-2">
    @foreach (array_filter($datatable->columns, fn($column) => $column['searchable']) as $input)
        <div class="col-md-2 mb-2">
            <label class="d-block">{{ $input['name'] }} : </label>
            @if (array_key_exists('type', $input) == false || $input['type'] == 'text')
                <input type="text" data-column-id="{{ $input['id'] }}" class="form-control datatable-filter"
                    placeholder="{{ $input['name'] }}">
            @else
                <select class="datatable-filter form-control select2bs4" data-column-id="{{ $input['id'] }}"">
                    <option value="">Choisir</option>
                    @foreach ($input['values'] as $key => $value)
                        @php
                            $input_value = is_array($input['values']) ? $key : $value;
                        @endphp
                        <option value="{{ $input_value }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
    @endforeach

    <button type="button" class="btn btn-primary m-2 align-self-end" onclick="search()"><i
            class="fa-solid fa-magnifying-glass"></i>
        Rechercher</button>

    <button type="button" class="btn btn-primary m-2 align-self-end" onclick="reset()"><i
            class="fa-solid fa-rotate-left"></i>
        Réinitialiser</button>
</div>

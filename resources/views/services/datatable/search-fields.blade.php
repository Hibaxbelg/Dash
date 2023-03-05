@push('css')
<link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@push('scripts')
<script src="../../plugins/select2/js/select2.full.min.js"></script>

<script>
    $('.select2').select2()

$('.select2bs4').select2({
  theme: 'bootstrap4'
})

function reset(){
    let inputs = document.getElementsByClassName('datatable-filter');

    $(".select2bs4").trigger("change");

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
        table.column(inputs[i].getAttribute("data-column-id")).search('');
    }

    table.draw();

}
</script>
@endpush
<div class="row mt-2">
    @foreach ($datatable->getSearcheableColumns() as $input)
    <div class="col-md-2 mb-2">
        <label class="d-block">{{ $input['name'] }} : </label>
        @if(array_key_exists('type',$input) == false || $input['type'] == 'text')
        <input type="text" data-column-id="{{ $input['id'] }}" class="form-control datatable-filter"
            placeholder="{{ $input['name'] }}">
        @else
        <select class="datatable-filter form-control select2bs4" data-column-id="{{ $input['id'] }}"">
            <option value="">Choisir</option>
            @foreach ($input['values'] as $value)
            <option value=" {{ $value }}">{{$value}}</option>
            @endforeach
        </select>
        @endif
    </div>
    @endforeach
    <button class="btn btn-primary" style="align-self:end;margin-bottom:8px" onclick="reset()"><i
            class="fa-solid fa-rotate-left"></i>
        Réinitialiser</button>
</div>
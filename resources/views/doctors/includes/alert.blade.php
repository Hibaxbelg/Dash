@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
</script>

@if(Session::has('message') && Session::has('type'))
<script>
    swal({
  text: "{{ Session::get('message') }}",
  icon: "{{ Session::get('type') }}",
});
</script>
@endif
@endpush
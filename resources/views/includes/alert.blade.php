@push('scripts')
    @if (Session::has('message') && Session::has('type'))
        <script>
            swal({
                text: "{{ Session::pull('message') }}",
                icon: "{{ Session::pull('type') }}",
            });
        </script>
    @endif

    @if (Session::has('modal'))
        <script>
            $(document).ready(function() {
                setTimeout(() => {
                    $("#{{ Session::get('modal') }}").modal();
                }, 1000);
            });
        </script>
    @endif
@endpush

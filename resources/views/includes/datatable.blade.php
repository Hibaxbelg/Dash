@push('scripts')
    <script>
        let table;
        $(function() {
            table = $("#example1").DataTable({
                dom: 'lBrtip',
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/fr-FR.json'
                },
                ajax: "{{ $AJAX_URL }}",
                processing: true,
                serverSide: true,
                pageLength: {{ $pageLength ?? 25 }},
                columns: @json($datatable->getColumns(true)),
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf"]

            });
            table.on('preDraw', function() {
                $("#example1_wrapper").css({
                    opacity: 0.75
                });
            });

            table.on('draw', function() {
                $("#example1_wrapper").css({
                    opacity: 1
                });

            });
        });
    </script>
@endpush

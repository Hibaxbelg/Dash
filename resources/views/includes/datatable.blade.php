@push('scripts')
    <script>
        let table;
        $(function() {
            let columns = @json($datatable->getColumns(true));
            let export_columns = [];
            for (let i = 0; i < columns.length - 1; i++) {
                export_columns.push(i);
            }
            table = $("#example1").DataTable({
                dom: 'lBrtip',
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/fr-FR.json'
                },
                ajax: "{{ $AJAX_URL }}",
                processing: true,
                serverSide: true,
                pageLength: {{ $pageLength ?? 25 }},
                columns: columns,
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf"]
                "buttons": [{
                    "extend": "copy",
                    "exportOptions": {
                        columns: export_columns
                    },
                }, {
                    "extend": "excel",
                    "exportOptions": {
                        columns: export_columns
                    },
                }, {
                    "extend": "pdf",
                    "exportOptions": {
                        columns: export_columns
                    }
                }]
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

$(document).ready(function() {
    $('#customerList').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('sale_manager.customerList') }}",
        "columns":[
            // {"data": 'DT_RowIndex'},
            // {"data":"date"},
            { "data": "name" },
            {"data":"email"},
            {"data":"phoneno"},
            {"data":"location"},
            // {"data":"property_description"},
            // {"data":"report_name"},
            // {"data":"price"}
        ],
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf',
        ],
    });
});
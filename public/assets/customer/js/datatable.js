$('.display').DataTable({
    responsive: true,
    dom: 'lBfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
    lengthMenu: [
            [20, 40, 60, 80, 100],
            [20, 40, 60, 80, 100]
        ],
});
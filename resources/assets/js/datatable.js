$(document).ready(function() {
    alert("sadsad");
    oTable = $('#delecdistboards').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('delecdistboardsdatatable.delecdistboardsgetposts') }}",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'zone_name', name: 'zone_name'},
            {data: 'item_name', name: 'item_name'},
            {data: 'item_type', name: 'item_type'},
            {data: 'status_boards', name: 'status_boards'}
        ]
    });
});

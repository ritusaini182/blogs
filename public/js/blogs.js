$(document).ready(function () {
    //remove flashmessage
    setTimeout(function () {
        $("div.flashmessage").remove();
    }, 5000);
    // datatable initialization

    fill_datatable();

    function fill_datatable() {
        var dataTable = $('#blogs-list-datatable').DataTable({
            responsive: true,
            order: [],
            ajax: {
                url: getBlogsList,
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },

            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'title',
                name: 'title',
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'tags',
                name: 'tags'
            },
            {
                data: 'action',
                name: 'action'
            }
            ]
        });
    }

    /** Delete blog */
    $(document).on('click', '.DeleteBtn', function () {
        var id = $(this).attr("data-href");
        $('.yeDelete').attr("data-href", id);
        $('#deleteModal').modal('show');
    });

    $(document).on('click', '.yeDelete', function () {
        // ajax call for delete
        var bid = $(this).attr("data-href");
        $.ajax({
            url: deleteBlog,
            data: { 'bid': bid, },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (result) {
                $('#deleteModal').modal('hide');
                $('#blogs-list-datatable').dataTable().api().ajax.reload();
            }
        });
    });

});

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        load_data();
    });

    $('.category1').on('change', function() {
        var data = $(".select2 option:selected").text();
        // console.log(data);
        $("#categoryid").val(data);
    })

    $(".category1").select2({
        placeholder: "Select a Category",
        // allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ url('admin/getdropdowndata') }}",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    tableName: 'category',
                    category: $('select[name="categoryid"]').val(),
                };
            },
            processResults: function(response) {
                // console.log(response);
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('.category2').on('change', function() {
        var data = $(".category2 option:selected").text();
        // console.log(data);
        $("#category").val(data);
    })

    $(".category2").select2({
        placeholder: "Select a Category",
        // allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ url('admin/getdropdowndata') }}",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    tableName: 'category',
                    category: $('select[name="categoryid"]').val(),
                };
            },
            processResults: function(response) {
                // console.log(response);
                return {
                    results: response
                };
            },
            cache: true
        }
    })

    $('.person2').on('change', function() {
        var data = $(".person2 option:selected").text();
        // console.log(data);
        $("#person").val(data);
    })

    $(".person2").select2({
        placeholder: "Select a Person",
        // allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ url('admin/getdropdowndata') }}",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    tableName: 'person',
                    category: $('select[name="personid"]').val(),
                };
            },
            processResults: function(response) {
                // console.log(response);
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('#statusApply').click(function() {
        var category_id = $('#category_id').val();
        var person_id = $('#person_id').val();
        if (category_id != '' || person_id != '') {
            $('#table_list_data').DataTable().destroy();
            load_data(category_id, person_id);
        }
    });

    function editable_remove(data_edit) {
        var type = 'Remove';
        var sliderImgId = $(data_edit).data('val');
        var tableName = $(data_edit).data('table');
        var ot_title = $(data_edit).attr('title');
        Swal.fire({
            title: 'Are you sure want to delete model : ' + ot_title + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('/admin/deleteData') }}",
                    type: 'post',
                    data: {
                        sliderImgId: sliderImgId,
                        tableName: tableName
                    },
                    success: function(response) {
                        if (response.success == 1) {
                            Swal.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            )
                            $('.data-table').DataTable().ajax.reload();
                        } else {
                            alert("Failed");
                        }
                    }
                });
            } else {
                swal.fire("Cancelled", "Your data is safe", "error");

            }
        })
    }
</script>
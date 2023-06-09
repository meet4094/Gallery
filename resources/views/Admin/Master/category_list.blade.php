@extends('Admin.template')
@section('main-section')
<style>
    .modal-dialog {
        max-width: 900px !important;
    }
</style>
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Category</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active" aria-current="page">Category List</li>
        </ol>
    </div>
    <div class="btn btn-list">
        <button type="button" class="btn btn-outline-primary rounded" id="toggler" data-toggle="modal" data-target="#add_edit_category">
            Add Category
        </button>
        <div id="add_edit_category" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/admin/add_edit_category') }}" class="ajax-form-submit" id="cform" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="categoryId" id="categoryId" value="">
                        <div class="modal-body">
                            <div class="row" style="display: flex;justify-content: center;">
                                <div class="col-12">
                                    <div class="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="float-left" for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                                        <span class="float-left tx-danger error_text name_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error-msg tx-danger"></div>
                                    <div class="form_proccessing tx-success float-left"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="save_data" type="submit" value="Submit">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header-divider">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table data-table table-striped table-hover table-fw-widget" id="table_list_data" width="100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#toggler').on('click', function() {
        $('#categoryId').val('');
        document.getElementById("cform").reset();
        $('.modal-title').html('Add Category');
    });

    $(document).ready(function() {
        load_data();
    });

    function load_data(filter_data = '') {
        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                data: {
                    data: filter_data,
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

    $('.ajax-form-submit').on('submit', function(e) {
        $('#save_data').prop('disabled', true);
        $('.error-msg').html('');
        $('.form_proccessing').html('Please wait...');
        e.preventDefault();
        var aurl = $(this).attr('action');
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            type: "POST",
            url: aurl,
            cache: false,
            contentType: false,
            processData: false,
            data: formdata ? formdata : form.serialize(),
            success: function(response) {
                if (response.st == 'success') {
                    $('#add_edit_category').modal('toggle');
                    $('.form_proccessing').html('');
                    $('#save_data').prop('disabled', false);
                    Swal.fire("Success!", response.msg, "success");
                    $('.data-table').DataTable().ajax.reload();
                } else {
                    $('.form_proccessing').html('');
                    $('#save_data').prop('disabled', false);
                    $.each(response.error, function(prefix, val) {
                        $('span.' + prefix + '_error').text(val).show().delay(5000)
                            .fadeOut();
                    });
                }
            },
            error: function() {
                $('#save_data').prop('disabled', false);
                alert('Error');
            }
        });
        return false;
    });

    function edit_Category(edit_employee) {
        var categoryId = $(edit_employee).data('val');
        $.ajax({
            type: 'POST',
            url: "{{ url('/admin/GetCategoryData') }}",
            data: {
                categoryId: categoryId
            },
            success: function(response) {
                // console.log(response);
                if (response.st == 'success') {
                    $('#iamges').html('');
                    $('#add_edit_category').modal('show');
                    $('.modal-title').html('Edit Category');
                    $('#categoryId').val(response.msg.id);
                    $('#name').val(response.msg.name);
                } else {
                    alert('failed');
                }
            },
            error: function(error) {
                $('#save_data').prop('disabled', false);
                alert('Error');
            }
        });
    }

    function editable_remove(data_edit) {
        var type = 'Remove';
        var categoryId = $(data_edit).data('val');
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
                    url: "{{ url('/admin/deleteCategory') }}",
                    type: 'post',
                    data: {
                        categoryId: categoryId
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
@endsection
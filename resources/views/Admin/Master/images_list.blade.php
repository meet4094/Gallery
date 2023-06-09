@extends('Admin.template')
@section('main-section')
<style>
    .modal-dialog {
        max-width: 900px !important;
    }
</style>
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Images & Videos</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active" aria-current="page">Images & Videos List</li>
        </ol>
    </div>
    <div>
        <button type="button" class="btn btn-outline-primary rounded" id="toggler" data-toggle="modal" data-target="#add_edit_images">
            Add Images & Videos
        </button>
        <a href="#" class="btn ripple btn-primary navresponsive-toggler mb-0" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
        </a>
    </div>
</div>
<div class="responsive-background">
    <div id="add_edit_images" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Images & Videos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/admin/add_edit_images') }}" class="ajax-form-submit" id="cform" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="imagesId" id="imagesId" value="">
                    <div class="modal-body">
                        <div class="row" style="display: flex;justify-content: center;">
                            <div class="col-12">
                                <div class="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="d-flex" for="personID">Person</label>
                                                    <select class="form-control person2" name="person" id="model">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" name="personname" id="person" value="">
                                                    <span class="float-left tx-danger error_text person_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="images">Images</label>
                                                    <input type="file" class="form-control" id="images" name="images[]" accept="image/png, image/gif, image/jpeg" multiple>
                                                    <span class="float-left tx-danger error_text images_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="d-flex" for="">Image</label>
                                                    <div id="image"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="videos">Videos</label>
                                                    <input type="file" class="form-control" id="videos" name="videos[]" accept="video/mp4,video/x-m4v,video/*" multiple>
                                                    <span class="float-left tx-danger error_text videos_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="d-flex" for="">Videos</label>
                                                    <div id="video"></div>
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
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="advanced-search">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Category</span></label>
                        <select class="form-control select2-flag-search select2" id="category_id">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Person</span></label>
                        <select class="form-control select2-flag-search person2" id="person_id">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a href="#" id="statusApply" class="btn btn-primary">Apply</a>
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
                                        <th>Category Name</th>
                                        <th>Model Name</th>
                                        <th>Image & Video</th>
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
        $('#imagesId').val('');
        $("#model").val('').trigger('change');
        $('#image').html('');
        $('#video').html('');
        $('#images').attr('disabled', false);
        $('#videos').attr('disabled', false);
        document.getElementById("cform").reset();
        $('.modal-title').html('Add Images & Videos');
    });

    $('.select2').on('change', function() {
        var data = $(".select2 option:selected").text();
        console.log(data);
        $("#categoryid").val(data);
    })

    $(".select2").select2({
        placeholder: "Select a Category",
        // allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ url('admin/get_category') }}",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    category: $('select[name="categoryid"]').val(),
                };
            },
            processResults: function(response) {
                console.log(response);
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $('.person2').on('change', function() {
        var data = $(".person2 option:selected").text();
        console.log(data);
        $("#person").val(data);
    })

    $(".person2").select2({
        placeholder: "Select a Person",
        // allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ url('admin/get_person') }}",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    category: $('select[name="personid"]').val(),
                };
            },
            processResults: function(response) {
                console.log(response);
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    $(document).ready(function() {
        load_datatable();
    });

    function load_datatable(category_id = '', person_id = '') {
        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('images_list') }}",
                data: {
                    'category_id': category_id,
                    'person_id': person_id,
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'categoryname',
                    name: 'categoryname'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'imageurl',
                    name: 'imageurl',
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
                    $('#add_edit_images').modal('toggle');
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

    var images = document.getElementById("images");
    images.addEventListener("input", function() {
        document.getElementById("videos").disabled = this.value != "";
    });

    var videos = document.getElementById("videos");
    videos.addEventListener("input", function() {
        document.getElementById("images").disabled = this.value != "";
    });

    function edit_modelCategory(edit_employee) {
        var imagesId = $(edit_employee).data('val');
        $.ajax({
            type: 'POST',
            url: "{{ url('/admin/GetImagesData') }}",
            data: {
                imagesId: imagesId
            },
            success: function(response) {
                // console.log(response);
                if (response.st == 'success') {
                    $('#model').html('');
                    $('#image').html('');
                    $('#video').html('');
                    $('#images').attr('disabled', false);
                    $('#videos').attr('disabled', false);
                    $('#add_edit_images').modal('show');
                    $('.modal-title').html('Edit Image & Videos');
                    $('#imagesId').val(response.msg.id);
                    $('#model').append(
                        `<option class="" value="${response.msg.modelID}" selected>${response.msg.modelname}</option>`
                    );
                    if (response.msg.image == '') {
                        $('#images').attr('disabled', true);
                        $('#video').append(
                            `<a target="_blank" href="${response.msg.video}" class="btn btn-link"><video controls src = "${response.msg.video}"width=150px height=100px></a>`
                        );
                    } else {
                        $('#videos').attr('disabled', true);
                        $('#image').append(
                            `<a target="_blank" href="${response.msg.image}" class="btn btn-link"><img src = "${response.msg.image}"width=100px height=100px></a>`
                        );
                    }
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
        var imagesId = $(data_edit).data('val');
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
                    url: "{{ url('/admin/deleteImages') }}",
                    type: 'post',
                    data: {
                        imagesId: imagesId
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

    $('#statusApply').click(function() {
        var category_id = $('#category_id').val();
        var person_id = $('#person_id').val();
        if (category_id != '' || person_id != '') {
            $('#table_list_data').DataTable().destroy();
            load_datatable(category_id, person_id);
        }
    });
</script>
@endsection
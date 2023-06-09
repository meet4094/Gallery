@extends('Admin.template')
@section('main-section')
<style>
    .modal-dialog {
        max-width: 900px !important;
    }
</style>
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Person</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active" aria-current="page">Person List</li>
        </ol>
    </div>
    <div>
        <button type="button" class="btn btn-outline-primary rounded" id="toggler" data-toggle="modal" data-target="#add_edit_person">
            Add Person
        </button>
        <a href="#" class="btn ripple btn-primary navresponsive-toggler mb-0" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
        </a>
    </div>
</div>
<div class="responsive-background">
    <div id="add_edit_person" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/admin/add_edit_person') }}" class="ajax-form-submit" id="cform" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="personId" id="personId" value="">
                    <div class="modal-body">
                        <div class="row" style="display: flex;justify-content: center;">
                            <div class="col-12">
                                <div class="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="d-flex" for="categoryID">Category<span class="tx-danger">*</span></label>
                                                    <select class="form-control category2" name="category" id="model">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" name="categoryname" id="category" value="">
                                                    <span class="float-left tx-danger error_text category_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="name">Name<span class="tx-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                                    <span class="float-left tx-danger error_text name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="birthdate">BirthDate<span class="tx-danger">*</span></label>
                                                    <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Enter Birthdate">
                                                    <span class="float-left tx-danger error_text birthdate_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="image">Image<span class="tx-danger">*</span></label>
                                                    <input type="file" class="form-control" id="image" name="image">
                                                    <span class="float-left tx-danger error_text image_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="d-flex" for="">Image</label>
                                                    <div id="images"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 text-left">
                                                <label class="" for="cname">Gender</label>
                                                <div class="form-control form-group">
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="gender" id="visible1" value="0" checked />
                                                        <label class="form-check-label" for="visible1">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="gender" id="visible2" value="1" />
                                                        <label class="form-check-label" for="visible2">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 text-left">
                                                <label class="" for="cname">Married Status</label>
                                                <div class="form-control form-group">
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="married_status" id="visible3" value="0" checked />
                                                        <label class="form-check-label" for="visible3">Unmarried</label>
                                                    </div>
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="married_status" id="visible4" value="1" />
                                                        <label class="form-check-label" for="visible4">Married</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="city">City</label>
                                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                                                    <span class="float-left tx-danger error_text city_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="float-left" for="annual_income">Annual Income</label>
                                                    <input type="text" class="form-control" id="annual_income" name="annual_income" placeholder="Enter Annual income">
                                                    <span class="float-left tx-danger error_text annual_income_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="float-left" for="description">Description<span class="tx-danger">*</span></label>
                                                    <textarea class="form-control" id="description" name="description"></textarea>
                                                    <span class="float-left tx-danger error_text description_error"></span>
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
                                        <th>Name</th>
                                        <th>Image</th>
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
        $('#personId').val('');
        $('#images').html('');
        $("#model").val('').trigger('change');
        document.getElementById("cform").reset();
        $('.modal-title').html('Add Person');
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

    $('.category2').on('change', function() {
        var data = $(".category2 option:selected").text();
        console.log(data);
        $("#category").val(data);
    })

    $(".category2").select2({
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

    $(document).ready(function() {
        load_datatable();
    });

    function load_datatable(category_id = '') {
        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('person_list') }}",
                data: {
                    'category_id': category_id,
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
        $('#statusApply').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
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
                    $('#add_edit_person').modal('toggle');
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

    function edit_modelCategory(edit_employee) {
        var personId = $(edit_employee).data('val');
        $.ajax({
            type: 'POST',
            url: "{{ url('/admin/GetPersonData') }}",
            data: {
                personId: personId
            },
            success: function(response) {
                // console.log(response);
                if (response.st == 'success') {
                    $('#images').html('');
                    $('#add_edit_person').modal('show');
                    $('.modal-title').html('Edit Person');
                    $('#personId').val(response.msg.id);
                    $('#name').val(response.msg.name);
                    $('#age').val(response.msg.age);
                    $('#birthdate').val(response.msg.birthdate);
                    $('#married_status').val(response.msg.married_status);
                    $('#city').val(response.msg.city);
                    $('#annual_income').val(response.msg.annual_income);
                    $('#description').val(response.msg.description);
                    var gender = response.msg.gender;
                    if (gender == '0') {
                        $('#visible1').prop("checked", true);
                    } else {
                        $('#visible2').prop("checked", true);
                    }
                    var married_status = response.msg.married_status;
                    if (married_status == '0') {
                        $('#visible3').prop("checked", true);
                    } else {
                        $('#visible4').prop("checked", true);
                    }
                    $('#model').append(
                        `<option class="" value="${response.msg.category_id}" selected>${response.msg.categoryname}</option>`
                    );
                    $('#images').append(
                        `<a target="_blank" href="${response.msg.image}" class="btn btn-link"><img src = "${response.msg.image}"width=100px height=100px></a>`
                    );
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
        var personId = $(data_edit).data('val');
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
                    url: "{{ url('/admin/deletePerson') }}",
                    type: 'post',
                    data: {
                        personId: personId
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
        if (category_id != '') {
            $('#table_list_data').DataTable().destroy();
            load_datatable(category_id);
        }
    });
</script>
@endsection
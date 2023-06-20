@extends('Web.template')
@section('main-section')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('web/assets/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Contacts</h2>
                    <p>Welcome to the official Contacts.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="login spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login__register">
                    <img src="{{asset('web/assets/img/contact.png')}}" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login__form">
                    <form action="mailto:" class="ajax-form-submit" id="cform" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input__item">
                            <input type="text" placeholder="Name" name="name" required>
                            <!-- <span class="icon_mail"></span> -->
                            <!-- <span class="float-left tx-danger error_text name_error pb-1" style="color: red;"></span> -->
                        </div>
                        <div class="input__item">
                            <input type="text" placeholder="Title" name="title" required>
                            <!-- <span class="icon_lock"></span> -->
                            <!-- <span class="float-left tx-danger error_text title_error pb-1" style="color: red;"></span> -->
                        </div>
                        <div class="input__item">
                            <input type="text" placeholder="Message" name="message" required>
                            <!-- <span class="icon_lock"></span> -->
                            <!-- <span class="float-left tx-danger error_text login_error pb-1" style="color: red;"></span> -->
                        </div>
                        <button type="submit" class="site-btn">Send</button>
                    </form>
                    <!-- <span class="float-left tx-danger error_text login_error pt-2" style="color: red;"></span> -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">

    // Send Message
    // $('.ajax-form-submit').on('submit', function(e) {
    //     e.preventDefault();
    //     var aurl = $(this).attr('action');
    //     var form = $(this);
    //     var formdata = false;
    //     if (window.FormData) {
    //         formdata = new FormData(form[0]);
    //     }
    //     $.ajax({
    //         type: "POST",
    //         url: aurl,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         data: formdata ? formdata : form.serialize(),
    //         success: function(response) {
    //             console.log(response.msg);
    //             if (response.st == 'success') {
    //                 $('.comment_error').html(''),
    //                     $('span.' + 'login_error').text(response.msg).show().delay(50000)
    //                     .fadeOut();
    //                 $("#cform").trigger('reset');
    //             } else {
    //                 $.each(response.error, function(prefix, val) {
    //                     $('span.' + prefix + '_error').text(val).show().delay(5000)
    //                         .fadeOut();
    //                 });
    //             }
    //         },
    //         error: function() {
    //             $('.save_data').prop('disabled', false);
    //             alert('Error');
    //         }
    //     });
    //     return false;
    // });
</script>
@endsection
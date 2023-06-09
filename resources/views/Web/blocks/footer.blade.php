<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="./index.html"><img src="{{asset('web/assets/img/logo.png')}}" alt="" /></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="{{ @$title == 'home' ? 'active' : '' }}"><a href="{{ url('/') }}">Homepage</a></li>
                        <li class="{{ @$title == 'categories' ? 'active' : '' }}"><a href="{{ url('categories') }}">Categories</a></li>
                        <li class="{{ @$title == 'contacts' ? 'active' : '' }}"><a href="{{ url('/contacts') }}">Contacts</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    All rights reserved | This template is made with
                    <i class="fa fa-heart" aria-hidden="true"></i> by
                    <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Search model Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form action="{{url ('/getAllPersondata')}}" id="cform" method="post" enctype="multipart/form-data" class="search-model-form">
            @csrf
            <input type="text" name="search" id="search-input" placeholder="Search here....." />
            <!-- <button hidden type="submit" class="search-switch"><span class="icon_search"></span></button> -->
        </form>
    </div>
</div>
<!-- Search model end -->
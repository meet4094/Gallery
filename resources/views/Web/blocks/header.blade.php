<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ url('/') }}">
                        <!-- <img src="{{asset('web/assets/img/logo.png')}}" alt=""> -->
                        <h3 style="color: white; font-weight: 800; font-size: 25px;">Model<span style="color: #e63334;">wio</span></h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="header__nav">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="{{ @$title == 'home' ? 'active' : '' }}"><a href="{{ url('/') }}">Homepage</a></li>
                            <li class="{{ @$title == 'categories' ? 'active' : '' }}"><a href="{{ url('categories') }}">Categories <span class="arrow_carrot-down"></span></a>
                                <ul class="dropdown" id="category_data">
                                </ul>
                            </li>
                            <!-- <li class="{{ @$title == 'blog' ? 'active' : '' }}"><a href="{{ url('/blog') }}">Our Blog</a></li> -->
                            <li class="{{ @$title == 'contacts' ? 'active' : '' }}"><a href="{{ url('/contacts') }}">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="header__right">
                    <a href="#" class="search-switch"><span class="icon_search"></span></a>
                    <a href="{{url('/login')}}"><span class="icon_profile"></span></a>
                </div>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
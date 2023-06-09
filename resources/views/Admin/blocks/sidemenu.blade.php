<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class=" sidemenu-logo">
        <a class="main-logo" href="{{ url('/admin/dashboard') }}">
            <img src="{{asset('admin/assets/images/logo.png')}}" class="header-brand-img desktop-logo">
            <img src="{{asset('admin/assets/images/mini-logo.png')}}" class="header-brand-img icon-logo">
            <img src="{{asset('admin/assets/images/logo.png')}}" class="header-brand-img desktop-logo theme-logo">
            <img src="{{asset('admin/assets/images/logo.png')}}" class="header-brand-img icon-logo theme-logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-label">Dashboard</li>
            <li class="nav-item {{ @$title == 'dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i><span class="sidemenu-label">Home</span></a>
            </li>
            <li class="nav-label">Master</li>
            <li class="nav-item {{ @$title == 'category_list' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/category_list') }}"><i class="fa-brands fa-docker"></i><span class="sidemenu-label">Add Category</span></a>
            </li>
            <li class="nav-item {{ @$title == 'person_list' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/person_list') }}"><i class="fa fa-user"></i><span class="sidemenu-label">Add Person</span></a>
            </li>
            <li class="nav-item {{ @$title == 'images_list' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/images_list') }}"><i class="fa fa-image"></i><span class="sidemenu-label">Add Images</span></a>
            </li>
        </ul>
    </div>
</div>
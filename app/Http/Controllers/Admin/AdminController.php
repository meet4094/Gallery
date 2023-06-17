<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    protected $admin;
    public function __construct()
    {
        $this->admin = new Admin();
    }

    public function dashboard(Request $req)
    {
        $data = $this->admin->dashboard();
        $data['title'] = 'dashboard';
        return view('Admin.dashboard', $data);
    }

    public function slider_list(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->admin->slider_list();
            return $data;
        }
        $data['title'] = 'slider_list';
        return view('Admin.Master.slider_list', $data);
    }

    public function add_edit_slider(Request $req)
    {
        if (!empty($req)) {
            $data = $this->admin->add_edit_slider($req);
            return $data;
        }
    }

    public function category_list(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->admin->category_list();
            return $data;
        }
        $data['title'] = 'category_list';
        return view('Admin.Master.category_list', $data);
    }

    public function add_edit_category(Request $req)
    {
        if (!empty($req)) {
            $data = $this->admin->add_edit_category($req);
            return $data;
        }
    }

    public function person_list(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->admin->person_list($req);
            return $data;
        }
        $data['title'] = 'person_list';
        return view('Admin.Master.person_list', $data);
    }

    public function add_edit_person(Request $req)
    {
        if (!empty($req)) {
            $data = $this->admin->add_edit_person($req);
            return $data;
        }
    }

    public function person_profile_view($req)
    {
        if (!empty($req)) {
            $iData = $this->admin->person_profile_view($req);
            $data['data'] = $iData;
            $data['title'] = 'person_list';
            return view('Admin.Master.person_profile_view', $data);
        }
    }

    public function images_list(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->admin->images_list($req);
            return $data;
        }
        $data['title'] = 'images_list';
        return view('Admin.Master.images_list', $data);
    }

    public function add_edit_images(Request $req)
    {
        if (!empty($req)) {
            $data = $this->admin->add_edit_images($req);
            return $data;
        }
    }

    public function deleteData(Request $req)
    {
        if (!empty($req)) {
            $msg = $this->admin->deleteData($req);
            return response()->json($msg);
        }
    }

    public function GetData(Request $req)
    {
        if (!empty($req)) {
            $data = $this->admin->GetData($req);
            return $data;
        }
    }

    public function getdropdowndata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->admin->getdropdowndata($req);
            return $data;
        }
    }
}

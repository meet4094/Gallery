<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use Laravel\Socialite\Facades\Socialite;

class WebController extends Controller
{
    protected $web;
    public function __construct()
    {
        $this->web = new Web();
    }

    // View Page
    public function home(Request $req)
    {
        $data['slider'] = $this->web->getSliderdata();
        $data['title'] = 'home';
        return view('Web.Master.home', $data);
    }

    public function categories(Request $req)
    {
        $data['title'] = 'categories';
        return view('Web.Master.categories', $data);
    }

    public function category($req)
    {
        $data['title'] = 'categories';
        $data['cid'] = $req;
        return view('Web.Master.category', $data);
    }

    public function person_details($req)
    {
        $data['persondetails'] = $this->web->person_details($req);
        $data['title'] = 'categories';
        return view('Web.Master.person_details', $data);
    }

    public function contacts()
    {
        $data['title'] = 'contacts';
        return view('Web.Master.contacts', $data);
    }

    public function login()
    {
        return view('Web.Master.login');
    }

    // Get Data Function
    public function getCategorydata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getCategorydata();
            return $data;
        }
    }

    public function getAllPersondata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getAllPersondata($req);
            return $data;
        }
    }

    public function getTopViewPersondata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getTopViewPersondata($req);
            return $data;
        }
    }

    // Login Function
    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $data = $this->web->callback();
        return $data;
    }

    // Comment Function
    public function sendcomment(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->sendcomment($req);
            return $data;
        }
    }

    public function getComment(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getComment($req);
            return $data;
        }
    }
}

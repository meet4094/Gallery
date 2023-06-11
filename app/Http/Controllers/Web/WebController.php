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

    public function home(Request $req)
    {
        $data['title'] = 'home';
        return view('Web.Master.home', $data);
    }

    public function categories(Request $req)
    {
        $data['title'] = 'categories';
        return view('Web.Master.categories', $data);
    }

    public function getAllPersondata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getAllPersondata($req);
            return $data;
        }
    }

    public function getCategorydata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getCategorydata();
            return $data;
        }
    }

    public function getRecentlyAddPersondata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getRecentlyAddPersondata($req);
            return $data;
        }
    }

    public function getTrendingPersondata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getTrendingPersondata($req);
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

    public function CategoryByPersonData($req)
    {
        $data = $this->web->CategoryByPersonData($req);
        $data['title'] = 'categories';
        return view('Web.Master.category', $data);
    }

    public function person_details($req)
    {
        $data['persondetails'] = $this->web->person_details($req);
        $data['title'] = 'categories';
        return view('Web.Master.person_details', $data);
    }

    public function getCategoryByAnyPersondata(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->getCategoryByAnyPersondata($req);
            return $data;
        }
    }

    public function blog()
    {
        $data['title'] = 'blog';
        return view('Web.Master.blog', $data);
    }

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

    public function searchPerson(Request $req)
    {
        if ($req->ajax()) {
            $data = $this->web->searchPerson($req);
            return $data;
        }
    }

    public function login()
    {
        return view('Web.Master.login');
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $data = $this->web->callback();
        return $data;
    }
}

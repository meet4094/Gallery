<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class Web extends Model
{
    // Category
    public function getCategorydata()
    {
        $data = DB::table('category')->where(array('is_del' => 0))->get();
        return response()->json(['st' => 'success', 'category' => $data]);
    }

    //All Person Data
    public function getAllPersondata($req)
    {
        $builder = DB::table('person');
        if (isset($req->cid)) {
            $builder->where(array('category_id' => $req->cid));
        }
        $PData = $builder->count('id');
        $pageId = $req->pageId ? $req->pageId : 0;
        $limit = 1;
        $PData = $PData / $limit;

        $lastpage = '';
        if ($PData < $req->pageId) {
            $start = $pageId * 1 - 2;
            if ($PData < $req->pageId) {
                $lastpage = '';
            } else {
                $lastpage = $req->pageId - 1;
            }
        } else {
            $start = $pageId * 1 - 1;
        }

        if ($PData > 1) {
            if ($PData <= 5) {
                $PdataCount = $PData;
            } else {
                $PdataCount = 5;
            }
        } else {
            $PdataCount = 1;
        }

        $builder = DB::table('person as p');
        $builder->where(array('p.is_del' => 0));
        if (isset($req->cid)) {
            $builder->where(array('p.category_id' => $req->cid));
        }
        $builder->join('category as c', 'c.id', 'p.category_id');
        $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
        if (isset($req->pageId)) {
            $builder->skip($start);
            $builder->limit($limit);
        } else {
            $builder->skip(0);
            $builder->limit($limit);
        }

        if ($req->filterId == 1) {
            $builder->orderBy('p.name');
            $builder->skip($start);
            $builder->limit($limit);
        } else if ($req->filterId == 2) {
            $builder->limit($limit);
            $PdataCount = $PData / 10;
        } else if ($req->filterId == 3) {
            $builder->skip(10);
            $builder->limit(50);
            $PdataCount = $PData / 40;
        }
        $data = $builder->get();

        $recentlyperson = array();
        foreach ($data as $persondata) {
            $imagefileName = asset('images/' . $persondata->image);
            $recentlyperson[] = array(
                'id' => $persondata->id,
                'name' => $persondata->name,
                'image' => $imagefileName,
                'trending' => $persondata->trending,
                'categoryname' => $persondata->categoryname
            );
        }

        return response()->json(['st' => 'success', 'PdataCount' => $PdataCount, 'lastpage' => $lastpage, 'recentlyperson' => $recentlyperson]);
    }

    //Recently Add Person Data
    public function getRecentlyAddPersondata($req)
    {
        $builder = DB::table('person as p');
        $builder->where(array('p.is_del' => 0));
        $builder->orderBy('p.id', 'desc');
        $builder->join('category as c', 'c.id', 'p.category_id');
        $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
        $data = $builder->get();
        $recentlyperson = array();
        foreach ($data as $persondata) {
            $imagefileName = asset('images/' . $persondata->image);
            $recentlyperson[] = array(
                'id' => $persondata->id,
                'name' => $persondata->name,
                'image' => $imagefileName,
                'trending' => $persondata->trending,
                'categoryname' => $persondata->categoryname,
            );
        }

        return response()->json(['st' => 'success', 'recentlyperson' => $recentlyperson]);
    }

    // Trending Person Data
    public function getTrendingPersondata($req)
    {
        $builder = DB::table('person as p');
        $builder->where(array('p.is_del' => 0));
        $builder->orderBy('p.trending', 'desc');
        $builder->join('category as c', 'c.id', 'p.category_id');
        $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
        $data = $builder->get();
        $trendingperson = array();
        foreach ($data as $persondata) {
            $imagefileName = asset('images/' . $persondata->image);
            $trendingperson[] = array(
                'id' => $persondata->id,
                'name' => $persondata->name,
                'image' => $imagefileName,
                'trending' => $persondata->trending,
                'categoryname' => $persondata->categoryname,
            );
        }
        return response()->json(['st' => 'success', 'trendingperson' => $trendingperson]);
    }

    // Top View Person Data
    public function getTopViewPersondata($req)
    {
        $builder = DB::table('top_view');
        $builder->select('person_id', DB::raw('COUNT(id) as viewcount'));
        $builder->groupBy('person_id');
        $builder->orderBy(DB::raw('COUNT(id)'), 'DESC');
        $builder->take(5);
        if ($req->filerId == 1) {
            $builder->whereDate('created_at', date('Y-m-d'));
        } else if ($req->filerId == 2) {
            $builder->whereBetween(
                'created_at',
                [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
            );
        } else if ($req->filerId == 3) {
            $builder->whereBetween(
                'created_at',
                [Carbon::now()->subMonth(1), Carbon::now()]
            );
        } else if ($req->filerId == 4) {
            $builder->whereBetween(
                'created_at',
                [Carbon::now()->subYear(1), Carbon::now()]
            );
        }
        $data = $builder->get();

        $topviewperson = array();
        foreach ($data as $persondata) {
            $builder = DB::table('person');
            $builder->where(array('id' => $persondata->person_id));
            $data = $builder->first();
            $imagefileName = asset('images/' . $data->image);
            $topviewperson[] = array(
                'id' => $data->id,
                'name' => $data->name,
                'image' => $imagefileName,
                'trending' => $data->trending,
                'viewcount' => $persondata->viewcount,
            );
        }

        return response()->json(['st' => 'success', 'topviewperson' => $topviewperson]);
    }

    public function CategoryByPersonData($req)
    {
        $builder = DB::table('person as p');
        $builder->where(array('p.is_del' => 0));
        $builder->where('p.category_id', '=', $req);
        $builder->join('category as c', 'c.id', '=', 'p.category_id');
        $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.id as cid', 'c.name as categoryname');
        $builder->orderBy('p.id', 'desc');
        $data = $builder->get();
        $PData = array();
        $person['categoryname'] = $data[0]->categoryname;
        $person['cid'] = $data[0]->cid;

        foreach ($data as $persondata) {
            $imagefileName = asset('images/' . $persondata->image);
            $PData[] = array(
                'id' => $persondata->id,
                'name' => $persondata->name,
                'image' => $imagefileName,
                'trending' => $persondata->trending,
                'categoryname' => $persondata->categoryname,
            );
        }

        $person['persondata'] = $PData;
        return $person;
    }

    public function person_details($req)
    {
        $builder = DB::table('person as p');
        $builder->where(array('p.is_del' => 0));
        $builder->where('p.id', '=', $req);
        $builder->join('category as c', 'c.id', '=', 'p.category_id');
        $builder->select('p.id', 'p.name', 'p.image', 'p.category_id', 'c.name as categoryname', 'c.id as categoryId', 'p.age', 'p.birthdate', 'p.gender', 'p.city', 'p.married_status', 'p.annual_income', 'p.description', 'p.trending');
        $builder->orderBy('p.id', 'desc');
        $data = $builder->first();

        // // Trending Now Count Add
        $trending['trending'] = $data->trending + 1;
        DB::table('person')->where('id', '=', $req)->update($trending);

        // Top View Count Add
        $top_view = array(
            'person_id' => $req,
            'category_id' => $data->category_id,
            'created_at' => date('Y-m-d'),
        );
        DB::table('top_view')->insert($top_view);

        // Person Data 
        $PimagefileName = asset('images/' . $data->image);
        if ($data->gender == 0) {
            $gender = 'Male';
        } else {
            $gender = 'Female';
        }
        if ($data->married_status == 0) {
            $married_status = 'Unmarried';
        } else {
            $married_status = 'Married';
        }
        $PData = array(
            'id' => $data->id,
            'name' => $data->name,
            'age' => $data->age,
            'birthdate' => $data->birthdate,
            'gender' => $gender,
            'city' => $data->city,
            'married_status' => $married_status,
            'annual_income' => $data->annual_income,
            'image' => $PimagefileName,
            'description' => $data->description,
        );
        $imagesData = DB::table('images')
            ->where(array('is_del' => 0))
            ->where('person_id', '=', $req)
            ->get();

        $PimagesData = array();
        foreach ($imagesData as $personIdata) {
            $imagefileName = '';
            $videofileName = '';
            if ($personIdata->images) {
                $image = $personIdata->images;
                $imagefileName = asset('images/' . $image);
            } else {
                $video = $personIdata->video;
                $videofileName = asset('images/' . $video);
            }
            $PimagesData[] = array(
                'id' => $personIdata->id,
                'image' => $imagefileName,
                'video' => $videofileName,
            );
        }
        $person['categoryname'] = $data->categoryname;
        $person['categoryId'] = $data->categoryId;
        $person['pId'] = $req;
        $person['persondata'] = $PData;
        $person['personimage'] = $PimagesData;
        return $person;
    }

    // Category By Any More Person Data
    public function getCategoryByAnyPersondata($req)
    {
        $builder = DB::table('person as p');
        $builder->where(array('p.is_del' => 0));
        $builder->where('p.category_id', '=', $req->categoryId);
        $builder->join('category as c', 'c.id', '=', 'p.category_id');
        $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
        $builder->inRandomOrder();
        $builder->limit(5);
        $data = $builder->get();
        $PData = array();
        foreach ($data as $persondata) {
            $imagefileName = asset('images/' . $persondata->image);
            $PData[] = array(
                'id' => $persondata->id,
                'name' => $persondata->name,
                'image' => $imagefileName,
                'trending' => $persondata->trending,
                'categoryname' => $persondata->categoryname,
            );
        }
        return response()->json(['st' => 'success', 'CategoryByAnyPersondata' => $PData]);
    }

    // Add Comment
    function sendcomment($req)
    {
        $rules = array(
            'comment' => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            $login = Auth::User();
            print_r($login);
            die;
            if (empty($login)) {
                return response()->json(['st' => 'success', 'msg' => 'Please Login']);
            } else {
                $data = $this->web->sendcomment($req);
                return $data;
            }
            $data = array(
                'person_id' => $req->pid,
                'comment' => $req->comment,
            );
            $data['created_at'] = date('Y-m-d H:i');
            DB::table('comment')->insert($data);
            return response()->json(['st' => 'success', 'msg' => 'Comment has been added',]);
        }
    }

    public function callback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = DB::table('users')->where('google_id', $user->id)->first();
            if ($finduser) {

                $ffd = Auth::user();
                print_r($ffd);
                die;

                return redirect()->intended('/');
            } else {
                $newUser = array(
                    'google_id' => $user->id,
                    'email' => $user->email,
                    'user_name' => $user->name,
                    'password' => Hash::make($user->name . '@' . $user->id),
                    'request_token' => Str::random(15),
                    'type' => '2'
                );

                DB::table('users')->insert($newUser);

                Auth::loginUsingId($newUser['google_id'], true);

                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

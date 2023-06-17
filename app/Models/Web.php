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
    // Category Data
    public function getCategorydata()
    {
        $data = DB::table('category')->where(array('is_del' => 0))->get();
        return response()->json(['st' => 'success', 'category' => $data]);
    }

    // Slider Img Data
    public function getSliderdata()
    {
        $data = DB::table('slider_img')->where(array('is_del' => 0))->get();
        $slider = array();
        foreach ($data as $sliderimg) {
            $imagefileName = asset('images/' . $sliderimg->image);
            $slider[] = array(
                'id' => $sliderimg->id,
                'title' => $sliderimg->title,
                'image' => $imagefileName,
            );
        }
        return $slider;
    }

    // Person Data
    public function getAllPersondata($req)
    {
        $limit = 1;
        // Recently Person Data ------ Home Page
        {
            $builder = DB::table('person as p');
            $builder->where(array('p.is_del' => 0));
            if (isset($req->name)) {
                $builder->where('p.name', 'LIKE', "%{$req->name}%");
            }
            $builder->join('category as c', 'c.id', 'p.category_id');
            $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
            $builder->limit($limit);
            $builder->orderBy('p.id', 'desc');
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
        }

        // Trending Person Data ------ Home Page
        {
            $builder = DB::table('person as p');
            $builder->where(array('p.is_del' => 0));
            if (isset($req->name)) {
                $builder->where('p.name', 'LIKE', "%{$req->name}%");
            }
            $builder->join('category as c', 'c.id', 'p.category_id');
            $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
            $builder->orderBy('p.trending', 'desc');
            $builder->limit($limit);
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
        }

        // All Person Data ----  Categories Page
        {
            $builder = DB::table('person');
            if (isset($req->cid)) {
                $builder->where(array('category_id' => $req->cid));
            }
            $PCount = $builder->count('id');
            $pageId = $req->pageId ? $req->pageId : 0;
            $PDataCount = $PCount / $limit;

            $lastpage = '';
            if ($PDataCount < $req->pageId) {
                $start = $pageId * 1 - 2;
                if ($PDataCount < $req->pageId) {
                    $lastpage = '';
                } else {
                    $lastpage = $req->pageId - 1;
                }
            } else {
                $start = $pageId * 1 - 1;
            }

            if ($PDataCount > 1) {
                if ($PDataCount <= 5) {
                    $PDataCount = $PDataCount;
                } else {
                    $PDataCount = 5;
                }
            } else {
                $PDataCount = 1;
            }

            $builder = DB::table('person as p');
            $builder->where(array('p.is_del' => 0));
            if (isset($req->cid)) {
                $builder->where(array('p.category_id' => $req->cid));
            }
            $builder->join('category as c', 'c.id', 'p.category_id');
            $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
            $builder->orderBy('p.name');
            if (isset($req->pageId)) {
                $builder->orderBy('p.name');
                $builder->skip($start);
            } else {
                $builder->skip(0);
            }

            if ($req->filterId == 1) {
                $builder->orderBy('p.name');
                $builder->skip($start);
            } else if ($req->filterId == 2) {
                $PDataCount = $PDataCount / 10;
            } else if ($req->filterId == 3) {
                $builder->skip(10);
                $PDataCount = $PDataCount / 40;
                $limit = 50;
            }
            $builder->limit($limit);
            $data = $builder->get();

            $allperson = array();
            foreach ($data as $persondata) {
                $imagefileName = asset('images/' . $persondata->image);
                $allperson[] = array(
                    'id' => $persondata->id,
                    'name' => $persondata->name,
                    'image' => $imagefileName,
                    'trending' => $persondata->trending,
                    'categoryname' => $persondata->categoryname
                );
            }
        }

        return response()->json(['st' => 'success', 'recentlyperson' => $recentlyperson, 'trendingperson' => $trendingperson, 'allperson' => $allperson, 'PdataCount' => $PDataCount, 'lastpage' => $lastpage,]);
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

    // // Search Person Data
    // public function searchPerson($req)
    // {
    //     // allperson
    //     $builder = DB::table('person');
    //     if (isset($req->search)) {
    //         $builder->where(array('name' => $req->search));
    //     }
    //     if (isset($req->cid)) {
    //         $builder->where(array('category_id' => $req->cid));
    //     }
    //     $PData = $builder->count('id');
    //     $pageId = $req->pageId ? $req->pageId : 0;
    //     $limit = 10;
    //     $PData = $PData / $limit;

    //     $lastpage = '';
    //     if ($PData < $req->pageId) {
    //         $start = $pageId * 1 - 2;
    //         if ($PData < $req->pageId) {
    //             $lastpage = '';
    //         } else {
    //             $lastpage = $req->pageId - 1;
    //         }
    //     } else {
    //         $start = $pageId * 1 - 1;
    //     }

    //     if ($PData > 1) {
    //         if ($PData <= 5) {
    //             $PdataCount = $PData;
    //         } else {
    //             $PdataCount = 5;
    //         }
    //     } else {
    //         $PdataCount = 1;
    //     }

    //     $builder = DB::table('person as p');
    //     $builder->where(array('p.is_del' => 0));
    //     if (isset($req->cid)) {
    //         $builder->where(array('p.category_id' => $req->cid));
    //     }
    //     if (isset($req->search)) {
    //         $builder->where(array('p.name' => $req->search));
    //     }
    //     $builder->join('category as c', 'c.id', 'p.category_id');
    //     $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
    //     if (isset($req->pageId)) {
    //         $builder->skip($start);
    //         $builder->limit($limit);
    //     } else {
    //         $builder->skip(0);
    //         $builder->limit($limit);
    //     }

    //     if ($req->filterId == 1) {
    //         $builder->orderBy('p.name');
    //         $builder->skip($start);
    //         $builder->limit($limit);
    //     } else if ($req->filterId == 2) {
    //         $builder->limit($limit);
    //         $PdataCount = $PData / 10;
    //     } else if ($req->filterId == 3) {
    //         $builder->skip(10);
    //         $builder->limit(50);
    //         $PdataCount = $PData / 40;
    //     }
    //     $data = $builder->get();

    //     $allperson = array();
    //     foreach ($data as $persondata) {
    //         $imagefileName = asset('images/' . $persondata->image);
    //         $allperson[] = array(
    //             'id' => $persondata->id,
    //             'name' => $persondata->name,
    //             'image' => $imagefileName,
    //             'trending' => $persondata->trending,
    //             'categoryname' => $persondata->categoryname
    //         );
    //     }

    //     // trendingperson
    //     $builder = DB::table('person as p');
    //     $builder->where(array('p.is_del' => 0));
    //     $builder->where('p.name', 'LIKE', "%{$req->search}%");
    //     $builder->orderBy('p.trending', 'desc');
    //     $builder->join('category as c', 'c.id', 'p.category_id');
    //     $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
    //     $data = $builder->get();
    //     $trendingperson = array();
    //     foreach ($data as $persondata) {
    //         $imagefileName = asset('images/' . $persondata->image);
    //         $trendingperson[] = array(
    //             'id' => $persondata->id,
    //             'name' => $persondata->name,
    //             'image' => $imagefileName,
    //             'trending' => $persondata->trending,
    //             'categoryname' => $persondata->categoryname,
    //         );
    //     }

    //     // recentlyperson
    //     $builder = DB::table('person as p');
    //     $builder->where(array('p.is_del' => 0));
    //     $builder->where('p.name', 'LIKE', "%{$req->search}%");
    //     $builder->orderBy('p.id', 'desc');
    //     $builder->join('category as c', 'c.id', 'p.category_id');
    //     $builder->select('p.id', 'p.name', 'p.image', 'p.trending', 'c.name as categoryname');
    //     $data = $builder->get();
    //     $recentlyperson = array();
    //     foreach ($data as $persondata) {
    //         $imagefileName = asset('images/' . $persondata->image);
    //         $recentlyperson[] = array(
    //             'id' => $persondata->id,
    //             'name' => $persondata->name,
    //             'image' => $imagefileName,
    //             'trending' => $persondata->trending,
    //             'categoryname' => $persondata->categoryname,
    //         );
    //     }

    //     return response()->json(['st' => 'success', 'trendingperson' => $trendingperson, 'recentlyperson' => $recentlyperson, 'PdataCount' => $PdataCount, 'lastpage' => $lastpage, 'allperson' => $allperson]);
    // }

    public function CategoryByPersonData($req)
    {
        // $builder = DB::table('person');
        // $builder->where(array('category_id' => $req));
        // $PData = $builder->count('id');
        // $limit = 1;
        // $PData = $PData / $limit;
        // print_r($PData);
        // die;

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
            if (empty($login)) {
                return response()->json(['st' => 'success', 'msg' => 'Please Login']);
            } else {
                $data = $this->web->sendcomment($req);
                return $data;
            }
            $data = array(
                'user_id' => '',
                'person_id' => $req->pid,
                'comment' => $req->comment,
            );
            $data['created_at'] = date('Y-m-d H:i');
            DB::table('comment')->insert($data);
            return response()->json(['st' => 'success', 'msg' => 'Comment has been added',]);
        }
    }

    // Get Comment
    function getComment($req)
    {
        $builder = DB::table('comment as c');
        $builder->where(array('c.is_del' => 0));
        $builder->join('users as u', 'u.id', '=', 'c.user_id');
        $builder->where('c.person_id', '=', $req->personId);
        $builder->select('c.id', 'c.comment', 'c.created_at', 'c.user_id', 'u.user_name as username', 'u.image');
        $builder->orderBy('id', 'desc');
        $builder->limit(5);
        $data = $builder->get();

        $commentData = array();
        foreach ($data as $key => $value) {

            $livedate = date('Y-m-d H:i:s');
            $date = $value->created_at;

            $toDate = Carbon::parse($livedate);
            $fromDate = Carbon::parse($date);

            $minutes = $toDate->diffInMinutes($fromDate);
            $hours = $toDate->diffInHours($fromDate);
            $days = $toDate->diffInDays($fromDate);
            $months = $toDate->diffInMonths($fromDate);
            $years = $toDate->diffInYears($fromDate);

            if ($minutes <= '60' && $hours == 0) {
                $created_at = $minutes . ' ' . 'Minutes Ago';
            } else if ($hours <= '24' && $days == 0) {
                $created_at = $hours . ' ' . 'Hours Ago';
            } else if ($days <= '31' && $months == 0) {
                $created_at = $days . ' ' .  'Days Ago';
            } else if ($months <= '12' && $years == 0) {
                $created_at = $months . ' ' .  'Months Ago';
            } else {
                $created_at = $years . ' ' .  'Years Ago';
            }
            $commentData[] = array(
                'id' => $value->id,
                'comment' => $value->comment,
                'username' => $value->username,
                'image' => $value->image,
                'commenttime' => $created_at,
            );
        }
        return response()->json(['st' => 'success', 'comment' => $commentData]);
    }

    public function callback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = DB::table('users')->where('google_id', $user->id)->first();
            // echo '<pre>';
            // print_r($finduser);
            // die;
            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('/');
            } else {
                $newUser = array(
                    'google_id' => $user->id,
                    'email' => $user->email,
                    'user_name' => $user->name,
                    'password' => Hash::make($user->name . '@' . $user->id),
                    'image' => $user->picture,
                    'request_token' => Str::random(15),
                    'type' => '2'
                );

                DB::table('users')->insert($newUser);

                Auth::login($newUser);

                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

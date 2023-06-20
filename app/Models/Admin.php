<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class Admin extends Model
{
    public function dashboard()
    {
        $data['slider'] = DB::table('slider_img')->where(array('is_del' => 0))->count('id');
        $data['category'] = DB::table('category')->where(array('is_del' => 0))->count('id');
        $data['person'] = DB::table('person')->where(array('is_del' => 0))->count('id');
        $data['personimage'] = DB::table('images')->where(array('is_del' => 0))->where(array('video' => ''))->count('id');
        $data['personvideo'] = DB::table('images')->where(array('is_del' => 0))->where(array('images' => ''))->count('id');
        return $data;
    }

    // Slider Image
    public function slider_list()
    {
        $data = DB::table('slider_img')->where(array('is_del' => 0))
            ->select('*')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('imageurl', function ($row) {
                $url = asset('images');
                $images = '<a target="_blank" href="' . $url . '/' . $row->image . '" class="btn btn-link"><img src = "' . $url . '/' . $row->image . '"width=200px height=100px></a>';
                return $images;
            })
            ->addColumn('action', function ($row) {
                $update_btn = '<button title="' . $row->title . '" class="btn btn-link" onclick="edit_SliderImg(this)" data-table="slider_img" data-val="' . $row->id . '"><i class="fas fa-edit"></i></button>';
                $delete_btn = '<button data-toggle="modal" target="_blank"  title="' . $row->title . '" class="btn btn-link" onclick="editable_remove(this)" data-table="slider_img" data-val="' . $row->id . '"><i class="fa fa-trash-alt tx-danger"></i></button>';
                return $update_btn . $delete_btn;
            })
            ->rawColumns(['imageurl', 'action'])
            ->make(true);
    }

    public function add_edit_slider($req)
    {
        if (empty($req->sliderImgId)) {
            $rules = array(
                'title' => 'required',
                'image' => 'required',
            );
        } else {
            $rules = array(
                'title' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            $iOriginal = DB::table('slider_img')->Where('id', $req->sliderImgId)->first();
            if (isset($req->image) && $req->image->getError() == 0) {
                if (isset($iOriginal->image) && !empty($iOriginal->image)) {

                    $iSelfpicture = public_path('images') . '/' . $iOriginal->image;

                    if (file_exists($iSelfpicture))

                        @unlink($iSelfpicture);
                }
                $file = $req->image;
                $extension = $file->extension();
                $imagefileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('images/'), $imagefileName);
            } else {
                $imagefileName = $iOriginal->image;
            }
            $data = array(
                'title' => $req->title,
                'image' => $imagefileName,
            );
            if (empty($req->sliderImgId)) {
                $data['created_at'] = date('Y-m-d H:i');
                DB::table('slider_img')->insert($data);
                return response()->json(['st' => 'success', 'msg' => 'Slider Image has been added',]);
            } else {
                $data['updated_at'] = date('Y-m-d H:i');
                DB::table('slider_img')->where('id', $req->sliderImgId)->update($data);
                return response()->json(['st' => 'success', 'msg' => 'Slider Image update successfully']);
            }
        }
    }

    // Person Category
    public function category_list()
    {
        $data = DB::table('category')->where(array('is_del' => 0))
            ->select('*')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $update_btn = '<button title="' . $row->name . '" class="btn btn-link" onclick="edit_Category(this)" data-table="category" data-val="' . $row->id . '"><i class="fas fa-edit"></i></button>';
                $delete_btn = '<button data-toggle="modal" target="_blank"  title="' . $row->name . '" class="btn btn-link" onclick="editable_remove(this)" data-table="category" data-val="' . $row->id . '"><i class="fa fa-trash-alt tx-danger"></i></button>';
                return $update_btn . $delete_btn;
            })
            ->rawColumns(['imageurl', 'action'])
            ->make(true);
    }

    public function add_edit_category($req)
    {
        $rules = array(
            'name' => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            $data = array(
                'name' => $req->name,
            );
            if (empty($req->categoryId)) {
                $data['created_at'] = date('Y-m-d H:i');
                DB::table('category')->insert($data);
                return response()->json(['st' => 'success', 'msg' => 'Category has been added',]);
            } else {
                $data['updated_at'] = date('Y-m-d H:i');
                DB::table('category')->where('id', $req->categoryId)->update($data);
                return response()->json(['st' => 'success', 'msg' => 'Category update successfully']);
            }
        }
    }

    // Person
    public function person_list($req)
    {
        $builder = DB::table('person as p');
        $builder->join('category as c', 'c.id', '=', 'p.category_id');
        $builder->where(array('p.is_del' => 0));
        if ($req->category_id != '') {
            $builder->where('p.category_id', $req->category_id);
        }
        $builder->select('p.*', 'c.name as categoryname');
        $data = $builder->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('imageurl', function ($row) {
                $url = asset('images');
                $images = '<a target="_blank" href="' . $url . '/' . $row->image . '" class="btn btn-link"><img src = "' . $url . '/' . $row->image . '"width=100px height=100px></a>';
                return $images;
            })
            ->addColumn('action', function ($row) {
                $view_btn = '<a href="/admin/person_profile_view/' . $row->id . '" title="' . $row->name . '" class="btn btn-link"><i class="fas fa-eye "></i></a>';
                $update_btn = '<button title="' . $row->name . '" class="btn btn-link" onclick="edit_modelCategory(this)" data-table="person" data-val="' . $row->id . '"><i class="fas fa-edit"></i></button>';
                $delete_btn = '<button data-toggle="modal" target="_blank"  title="' . $row->name . '" class="btn btn-link" onclick="editable_remove(this)" data-table="person" data-val="' . $row->id . '"><i class="fa fa-trash-alt tx-danger"></i></button>';
                return $view_btn . $update_btn . $delete_btn;
            })
            ->rawColumns(['imageurl', 'action'])
            ->make(true);
    }

    public function add_edit_person($req)
    {
        if (empty($req->personId)) {
            $rules = array(
                'category' => 'required',
                'name' => 'required',
                'image' => 'required',
                'birthdate' => 'required',
                'description' => 'required',
            );
        } else {
            $rules = array(
                'category' => 'required',
                'name' => 'required',
                'birthdate' => 'required',
                'description' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            $dateOfBirth = $req->birthdate;
            $age = Carbon::parse($dateOfBirth)->age;
            $iOriginal = DB::table('person')->Where('id', $req->personId)->first();
            if (isset($req->image) && $req->image->getError() == 0) {
                if (isset($iOriginal->image) && !empty($iOriginal->image)) {

                    $iSelfpicture = public_path('images') . '/' . $iOriginal->image;

                    if (file_exists($iSelfpicture))

                        @unlink($iSelfpicture);
                }
                $file = $req->image;
                $extension = $file->extension();
                $imagefileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('images/'), $imagefileName);
            } else {
                $imagefileName = $iOriginal->image;
            }
            $data = array(
                'category_id' => $req->category,
                'name' => $req->name,
                'image' => $imagefileName,
                'age' => $age,
                'birthdate' => $req->birthdate,
                'gender' => $req->gender,
                'married_status' => $req->married_status,
                'city' => $req->city ? $req->city : '',
                'annual_income' => $req->annual_income ? $req->annual_income : '',
                'description' => $req->description,
            );
            if (empty($req->personId)) {
                $data['created_at'] = date('Y-m-d H:i');
                DB::table('person')->insert($data);
                return response()->json(['st' => 'success', 'msg' => 'Person has been added',]);
            } else {
                $data['updated_at'] = date('Y-m-d H:i');
                DB::table('person')->where('id', $req->personId)->update($data);
                return response()->json(['st' => 'success', 'msg' => 'Person update successfully']);
            }
        }
    }

    public function person_profile_view($req)
    {
        $data = DB::table('person as p')->where(array('p.id' => $req))->join('category as c', 'c.id', '=', 'p.category_id')->select('p.*', 'c.name as categoryname')->first();
        $images = DB::table('images')->select('images', 'video')->where(array('person_id' => $req))->get();
        $personimage = array();
        foreach ($images as $image) {
            $imagefileName = '';
            $videofileName = '';
            if ($image->images) {
                $image = $image->images;
                $imagefileName = asset('images/' . $image);
            } else {
                $video = $image->video;
                $videofileName = asset('images/' . $video);
            }
            $personimage[] = array(
                'image' => $imagefileName,
                'video' => $videofileName,
            );
        }
        $imagefileName = asset('images/' . $data->image);
        if ($data->gender == '0') {
            $gender = 'Male';
        } else {
            $gender = 'Female';
        }
        if ($data->married_status == '0') {
            $married_status = 'Unmarried';
        } else {
            $married_status = 'Married';
        }
        $data = array(
            'id' => $data->id,
            'categoryname' => $data->categoryname,
            'name' => $data->name,
            'image' => $imagefileName,
            'age' => $data->age,
            'birthdate' => $data->birthdate,
            'gender' => $gender,
            'married_status' => $married_status,
            'city' => $data->city,
            'annual_income' => $data->annual_income,
            'description' => $data->description,
            'personimages' => $personimage,
        );
        // echo '<pre>';
        // print_r($data['personimages']);
        // die;
        return $data;
    }

    // Person Image
    public function images_list($req)
    {
        $builder = DB::table('images as i');
        $builder->join('person as p', 'p.id', '=', 'i.person_id');
        $builder->join('category as c', 'c.id', '=', 'p.category_id');
        $builder->where(array('i.is_del' => 0));
        if ($req->category_id != '' && $req->person_id != '') {
            $builder->where('i.person_id', $req->person_id);
            $builder->where('p.category_id', $req->category_id);
        } else if ($req->category_id != '' || $req->person_id != '') {
            $builder->where('i.person_id', $req->person_id);
            $builder->orWhere('p.category_id', $req->category_id);
        }
        $builder->select('i.id', 'p.name', 'i.images', 'i.video', 'c.name as categoryname');
        $data = $builder->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('imageurl', function ($row) {
                $url = asset('images');
                if ($row->images) {
                    $images = '<a target="_blank" href="' . $url . '/' . $row->images . '" class="btn btn-link"><img src = "' . $url . '/' . $row->images . '"width=100px height=100px></a>';
                } else {
                    $images = '<a target="_blank" href="' . $url . '/' . $row->video . '" class="btn btn-link"><video controls src = "' . $url . '/' . $row->video . '"width=150px height=100px></a>';
                }
                return $images;
            })
            ->addColumn('action', function ($row) {
                $update_btn = '<button title="' . $row->name . '" class="btn btn-link" onclick="edit_modelCategory(this)" data-table="images" data-val="' . $row->id . '"><i class="fas fa-edit"></i></button>';
                $delete_btn = '<button data-toggle="modal" target="_blank"  title="' . $row->name . '" class="btn btn-link" onclick="editable_remove(this)" data-table="images" data-val="' . $row->id . '"><i class="fa fa-trash-alt tx-danger"></i></button>';
                return $update_btn . $delete_btn;
            })
            ->rawColumns(['imageurl', 'action'])
            ->make(true);
    }

    public function add_edit_images($req)
    {
        if (empty($req->imagesId)) {
            if (empty($req->images) && empty($req->videos)) {
                $rules = array(
                    'person' => 'required',
                    'images' => 'required',
                    'videos' => 'required',
                );
            } else {
                $rules = array(
                    'person' => 'required',
                );
            }
        } else {
            $rules = array(
                'person' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            if (isset($req->images)) {
                $images_videos = $req->images;
            } else {
                $images_videos = $req->videos;
            }
            if (empty($req->imagesId)) {
                foreach ($images_videos as $image_video) {
                    $file = $image_video;
                    $extension = $file->extension();
                    $fileName = md5(uniqid() . time()) . '.' . $extension;
                    $file->move(public_path('images/'), $fileName);

                    if (isset($req->images)) {
                        $data = array(
                            'person_id' => $req->person,
                            'images' => $fileName,
                            'video' => '',
                        );
                    } else {
                        $data = array(
                            'person_id' => $req->person,
                            'images' => '',
                            'video' => $fileName,
                        );
                    }
                    $data['created_at'] = date('Y-m-d H:i');
                    DB::table('images')->insert($data);
                }
                return response()->json(['st' => 'success', 'msg' => 'Image & Video has been added',]);
            } else {
                $iOriginal = DB::table('images')->Where('id', $req->imagesId)->first();
                if (isset($images_videos[0]) && $images_videos[0]->getError() == 0) {
                    if (isset($req->images)) {
                        if (isset($iOriginal->images) && !empty($iOriginal->images)) {

                            $iSelfpicture = public_path('images') . '/' . $iOriginal->images;

                            if (file_exists($iSelfpicture))

                                @unlink($iSelfpicture);
                        }
                    } else {
                        if (isset($iOriginal->video) && !empty($iOriginal->video)) {

                            $iSelfpicture = public_path('images') . '/' . $iOriginal->video;

                            if (file_exists($iSelfpicture))

                                @unlink($iSelfpicture);
                        }
                    }
                    $file = $images_videos[0];
                    $extension = $file->extension();
                    $fileName = md5(uniqid() . time()) . '.' . $extension;
                    $file->move(public_path('images/'), $fileName);
                } else {
                    if (isset($req->images)) {
                        $fileName = $iOriginal->images;
                    } else {
                        $fileName = $iOriginal->video;
                    }
                }
                if (isset($req->images)) {
                    $data = array(
                        'person_id' => $req->person,
                        'images' => $fileName,
                        'video' => '',
                    );
                } else {
                    $data = array(
                        'person_id' => $req->person,
                        'images' => '',
                        'video' => $fileName,
                    );
                }
                $data['updated_at'] = date('Y-m-d H:i');
                DB::table('images')->where('id', $req->imagesId)->update($data);
                return response()->json(['st' => 'success', 'msg' => 'Image & Video update successfully']);
            }
        }
    }

    // Any table Get Data Sem function
    public function GetData($req)
    {
        $table = $req->tableName;
        $Id = $req->sliderImgId;

        if (!empty($req)) {
            if ($table == 'slider_img') {
                $data = DB::table($table)
                    ->where(array('id' => $Id))
                    ->select('*')
                    ->first();
                $imagefileName = asset('images/' . $data->image);
                $data = array(
                    'id' => $data->id,
                    'title' => $data->title,
                    'image' => $imagefileName,
                );
            } else if ($table == 'person') {
                $data = DB::table('person as p')
                    ->where(array('p.id' => $req->personId))
                    ->join('category as c', 'c.id', '=', 'p.category_id')
                    ->select('p.*', 'c.name as categoryname')
                    ->first();
                $imagefileName = asset('images/' . $data->image);
                $data = array(
                    'id' => $data->id,
                    'category_id' => $data->category_id,
                    'categoryname' => $data->categoryname,
                    'name' => $data->name,
                    'image' => $imagefileName,
                    'age' => $data->age,
                    'birthdate' => $data->birthdate,
                    'gender' => $data->gender,
                    'married_status' => $data->married_status,
                    'city' => $data->city,
                    'annual_income' => $data->annual_income,
                    'description' => $data->description,
                );
            } else if ($table == 'images') {
                $data = DB::table('images as i')
                    ->where(array('i.id' => $req->imagesId))
                    ->join('person as p', 'p.id', '=', 'i.person_id')
                    ->select('i.id', 'i.person_id', 'p.name', 'i.images', 'i.video')
                    ->first();
                if ($data->images == '') {
                    $imagefileName = '';
                } else {
                    $imagefileName = asset('images/' . $data->images);
                }
                if ($data->video == '') {
                    $videofileName = '';
                } else {
                    $videofileName = asset('images/' . $data->video);
                }
                $data = array(
                    'id' => $data->id,
                    'modelID' => $data->person_id,
                    'modelname' => $data->name,
                    'image' => $imagefileName,
                    'video' => $videofileName,
                );
            } else {
                $data = DB::table('category')
                    ->where(array('id' => $req->categoryId))
                    ->first();
            }
            $response = array('st' => "success", "msg" => $data);
            return response()->json($response);
        }
    }

    // Any table Delete Data Sem function
    public function deleteData($req)
    {
        $table = $req->tableName;
        $sliderImgId = $req->sliderImgId;

        $job_data = DB::table($table)->where('id', $sliderImgId)->update(array('is_del' => '1'));
        if ($job_data) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Failed to delete';
        }
        return $response;
    }

    // Any table Drop Down Data Sem function
    public function getdropdowndata($req)
    {
        $search = $req->searchTerm;
        $tableName = $req->tableName;
        if ($search == '') {
            $Data = DB::table($tableName)->where(array('is_del' => 0))->select('id', 'name')->get();
        } else {
            $Data = DB::table($tableName)->select('id', 'name')->where('name', 'like', '%' . $search . '%')->where('is_del', 0)->limit(10)->get();
        }

        $response = array();
        foreach ($Data as $data) {
            $response[] = array(
                "id" => $data->id,
                "text" => $data->name
            );
        }
        return response()->json($response);
    }
}

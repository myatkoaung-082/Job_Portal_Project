<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    // direct to blog management
    public function listPage(){
        $data = blog::when(request('key1'),function($query){
            $key1 = request('key1');
            $query->orWhere('title','like','%'.$key1.'%')
                  ->orWhere('description','like','%'.$key1.'%');
        })->orderBy('created_at','desc')->paginate(2);
        return view('admin.blog.list',compact('data'));
    }

    // create blog post
    public function createPost(Request $req){
        $this->validationCheck($req);
        $data = $this->getData($req);
        //for image
        if($req->hasFile('image')){
            $fileName = uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public/blogImage',$fileName);
            $data['image'] = $fileName;
        }
        $data['created_at'] = Carbon::now();
        blog::create($data);
        return redirect()->route('blog#list')->with(['createSuccess'=>'Post Created Successfully']);
    }

    // delete post
    public function deletePost($id){
        blog::where('id',$id)->delete();
        return redirect()->route('blog#list')->with(['deleteSuccess'=>'Post Deleted Successfully']);
    }

    // direct to details page
    public function details($id){
        $data = blog::where('id',$id)->first();
        return view('admin.blog.details',compact('data'));
    }

    // update blog post
    public function update(Request $req,$id){
        
        $this->validationCheck($req);
        $data = $this->getData($req);

        if($req->hasFile('image')){
            $oldimg = blog::where('id',$id)->first();
            $oldimg = $oldimg->image;

            if($oldimg != null){
                Storage::delete('public/'.$oldimg);
            }

            $newimg = uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public',$newimg);
            $data['image'] = $newimg;

        }
        $data['updated_at'] = Carbon::now();
        blog::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Updated Post Successfully']);
    }

    // accepts user input
    private function getData($req){
        return [
            'title'=>$req->title,
            'description'=>$req->description
        ];
    }

    // validation check
    private function validationCheck($req){
        Validator::make($req->all(),[
            'title' => 'required|min:10|unique:blogs,title,'.$req->id,
            'description' => 'required|min:20',
            'image' => 'mimes:jpg,jpeg,png,webp,jfif'
        ])->validate();
    }
}

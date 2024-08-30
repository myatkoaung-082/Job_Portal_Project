<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    // direct to category list page
    public function listpage(){
        $data = Category::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%');
        })
            ->orderBy('created_at','desc')
            ->paginate(5);
        return view('admin.category.list',compact('data'));
    }

    // direct to category page
    public function createPage(){
        return view('admin.category.create');
    }

    // category create 
    public function create(Request $req){
        //check validation
        $this->categoryValidationCheck($req);
        //accept input
        $data = $this->requestCategoryData($req);
        //create category
        Category::create($data);
        //return list page
        return redirect()->route('admin#categorylist')->with(['createSuccess'=> 'Category Created Successfully']);
    }

    //delete category
    public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Category Deleted Successfully']);
    }

    //edit page
    public function editPage($id){
        $data = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('data'));
    }

    //update category
    public function update(Request $req){
        //check validation
        $this->categoryValidationCheck($req);
        //accept input
        $data = $this->requestCategoryData1($req);
        Category::where('id',$req->id)->update($data);
        return redirect()->route('admin#categorylist')->with(['updateSuccess'=>'Data Updated Successfully']);
    }

    //category validation
    private function categoryValidationCheck($req){
        Validator::make($req->all(),[
            'categoryName' => 'required|min:4|unique:categories,name,'.$req->id
        ],[
            'categoryName.required' => 'please fill the data',
            'categoryName.unique' => 'Category already exist!'
        ])->validate();
    }

    //accept category input
    private function requestCategoryData($req){
        return [
            'name' => $req->categoryName,
            'created_at' => Carbon::now()
        ];
    }

    private function requestCategoryData1($req){
        return [
            'name' => $req->categoryName,
            'updated_at' => Carbon::now()
        ];
    }
}

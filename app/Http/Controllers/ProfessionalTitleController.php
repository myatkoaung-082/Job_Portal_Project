<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\professional_title;
use Illuminate\Support\Facades\Validator;

class ProfessionalTitleController extends Controller
{
    // direct to professional list
    public function list(){
        $data = professional_title::select('professional_titles.*','categories.name as name')
        ->when(request('searchKey'),function($query){
            $query->where('professional_title_name','like','%'.request('searchKey').'%');
        })
            ->leftJoin('categories','professional_titles.category_id','categories.id')
            ->orderBy('created_at','desc')
            ->paginate(5);
        return view('admin.professional_title.list',compact('data'));
    }

    // direct to create page
    public function create(){
        $data = Category::get();
        return view('admin.professional_title.create',compact('data'));
    }

    // direct to create func
    public function createfunc(Request $req){
        $this->checkValidation($req);
        $data = $this->requestprofessionData($req);
        professional_title::create($data);
        return redirect()->route('admin#professionlist')->with(['createSuccess'=> 'Category Created Successfully']);
    }

    //delete professional title
    public function delete($id){
        professional_title::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Category Deleted Successfully']);
    }

    //edit page
    public function editpage($id){
        $data = professional_title::where('id',$id)->first();
        $data1 = Category::get();
        return view('admin.professional_title.edit',compact('data','data1'));
    }

    //update category
    public function edit(Request $req){
        //check validation
        $this->checkValidation($req);
        //accept input
        $data = $this->requestprofessionData1($req);
        professional_title::where('id',$req->id)->update($data);
        return redirect()->route('admin#professionlist')->with(['updateSuccess'=>'Data Updated Successfully']);
    }

    // validation for professional title
    private function checkValidation($req){
        Validator::make($req->all(),[
            'professionName' => 'required|min:4|unique:professional_titles,professional_title_name,'.$req->id,
            'category_name' => 'required'
        ],[
            'professionName.required' => 'please fill the data',
            'professionName.unique' => 'Professional Title already exist!'
        ])->validate();
    }

    //accept professional title input
    private function requestprofessionData($req){
        return [
            'professional_title_name' => $req->professionName,
            'category_id' => $req->category_name,
            'created_at'=>Carbon::now()     
        ];
    }

    private function requestprofessionData1($req){
        return [
            'professional_title_name' => $req->professionName,
            'category_id' => $req->category_name,
            'updated_at'=>Carbon::now()     
        ];
    }
}

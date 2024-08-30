<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    // direct to industry list page
    public function list(){
        $data = industry::when(request('searchKey'),function($query){
            $query->where('industry_name','like','%'.request('searchKey').'%');
        })
            ->orderBy('created_at','desc')
            ->paginate(5);
        return view('admin.industry.list',compact('data'));
    }

    // direct to create page
    public function create(){
        return view('admin.industry.create');
    }

    // create function
    public function createfunc(Request $req){
        //check validation
        $this->industryValidation($req);
        //accept input
        $data = $this->requestIndustryData($req);
        //create industry
        industry::create($data);
        //return list page
        return redirect()->route('admin#industrylist')->with(['createSuccess'=> 'Industry Created Successfully']);
    }

    // direct to edit page
    public function editPage($id){
        $data = industry::where('id',$id)->first();
        return view('admin.industry.edit',compact('data'));
    }

    //update industry
    public function update(Request $req){
        //check validation
        $this->industryValidation($req);
        //accept input
        $data = $this->requestIndustryData1($req);
        industry::where('id',$req->id)->update($data);
        return redirect()->route('admin#industrylist')->with(['updateSuccess'=>'Data Updated Successfully']);
    }

    // industry validation
    private function industryValidation($req){
        Validator::make($req->all(),[
            'industryName' => 'required|min:4|unique:industries,industry_name,'.$req->id
        ],[
            'industryName.required' => 'please fill the data',
            'industryName.unique' => 'Industry Name already exist!'
        ])->validate();
    }

    //accept industry input
    private function requestIndustryData($req){
        return [
            'industry_name' => $req->industryName,
            'created_at' => Carbon::now()
        ];
    }

    //accept industry input
    private function requestIndustryData1($req){
        return [
            'industry_name' => $req->industryName,
            'updated_at' => Carbon::now()
        ];
    }
}

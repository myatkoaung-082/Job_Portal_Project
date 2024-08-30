<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Contact;
use App\Models\employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // direct to about page
    public function contactPage(){
       
        return view('employer.main.contact');
    }

    public function contactPage1(){
        
        return view('seeker.main.contact');
    }

    // contact
    public function contact(Request $request){
        $this->validateTest($request);
        $cdata = $this->getData($request);
        $cdata['created_at'] = Carbon::now();
        Contact::create($cdata);
        return back()->with(['sendSuccess'=>'Message Sent Successfully']);
    }

    // contact 1
    public function contact1(Request $request){
        $this->validateTest($request);
        $data = $this->getDataSeeker($request);
        Contact::create($data);
        return back()->with(['sendSuccess'=>'Message Sent Successfully']);
    }

    // direct to admin contact page
    public function inbox(){
        $cdata = Contact::select('contacts.*','users.*','contacts.id as cid')
            ->where('seeker_id')
            ->leftJoin('users','users.id','contacts.company_id')
            ->get();
        

        $sdata = Contact::select('contacts.*','users.*','contacts.id as sid')
            ->where('company_id')
            ->leftJoin('users','users.id','contacts.seeker_id')
            ->get();
        
        return view('admin.main.inbox',compact('sdata','cdata'));
    }

    // delete contact
    public function inboxDelete($id){
        Contact::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Message deleted successfully']);
    }

    // edit contact
    public function inboxView($id){
        $data = Contact::select('contacts.*','users.*','contacts.id as cid')
        ->leftJoin('users','users.id','contacts.company_id')
        ->where('contacts.id',$id)
        ->get();

        // dd($data);
        return view('admin.main.inboxDetail',compact('data'));
    }

    public function inboxView1($id){
        $data = Contact::select('contacts.*','users.*','contacts.id as sid')
        ->leftJoin('users','users.id','contacts.seeker_id')
        ->where('contacts.id',$id)
        ->get();

        // dd($data);
        return view('admin.main.inboxDetail',compact('data'));
    }

    // direct to about page
    public function about(){
        return view('employer.main.about');
    }

    // direct to seeker about page
    public function aboutseeker(){
        return view('seeker.main.about');
    }

    // validation data
    private function validateTest($request){
        Validator::make($request->all(), [
            'description' => 'required | min:10'
        ])->validate();
    }

    // get data
    private function getData($request){
        return [
            'message'=>$request->description,
            'company_id'=>$request->id
        ];
    }

    // get data for seeker
    private function getDataSeeker($request){
        return [
            'message' => $request->description,
            'seeker_id' => $request->id
        ];
    }
}

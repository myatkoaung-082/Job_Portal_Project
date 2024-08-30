<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Interview;
use App\Mail\InterviewMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InterviewController extends Controller
{
    // interview list
    public function interviewList(){
        $data = Interview::select('interviews.*', 'professional_titles.professional_title_name','industries.industry_name','users.name as seekerName' )
                            ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->leftJoin('industries','industries.id','company_industries.industry_id')
                            ->where('company_industries.company_id',Auth::user()->id)
                            ->orderBy('job_applies.created_at', 'desc')
                            ->paginate(5);

        // user interface
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.job.interview_list_update', compact('image', 'data'));
    }

    // interview update
    public function interviewUpdate(Request $request, $id){
        // interview update
        $this->checkValidationInterview($request);
        $interviewData = $this->getInterviewData($request);
        // dd($interviewData);
        $now = Carbon::now();
        $interviewDate = Carbon::parse($interviewData['interview_date']);
        $interviewDate = $interviewDate->format('Y-m-d');
        if($interviewDate < $now){
            return back()->with(['dateError'=>'Interview Date Must be earlier than current date']);
        }
        Interview::where('id', $id)->update($interviewData);

        // interview mail
        $seekerData = Interview::select('users.email', 'users.name as seekerName')
                                ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                                ->leftJoin('users', 'users.id', 'job_applies.seeker_id')
                                ->where('interviews.id', $id)
                                ->get();
        $companyData = Interview::select('professional_titles.professional_title_name', 'industries.industry_name', 'users.name as companyName')
                                    ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                                    ->leftJoin('jobs', 'jobs.id', 'job_applies.job_id')
                                    ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
                                    ->leftJoin('company_industries', 'company_industries.id', 'jobs.company_industry_id')
                                    ->leftJoin('industries', 'industries.id', 'company_industries.industry_id')
                                    ->leftJoin('users', 'users.id', 'company_industries.company_id')
                                    ->where('users.id', Auth::user()->id)
                                    ->get();
                                    
        // dd($companyData->toArray());
        $seekerEmail = $seekerData[0]->email;
        $seekerName = $seekerData[0]->seekerName;
        $jobPosition = $companyData[0]->professional_title_name;
        $industryName = $companyData[0]->industry_name;
        $companyName = $companyData[0]->companyName;
        $time = $request->time;
        $date = $request->date;
        $location = $request->location;
        Mail::to($seekerEmail)->send(new InterviewMail($seekerEmail, $seekerName, $time, $date, $location, $jobPosition, $industryName, $companyName));
        
        

        // interview list
        $data = Interview::select('interviews.*', 'professional_titles.professional_title_name','industries.industry_name','users.name as seekerName' )
                            ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->leftJoin('industries','industries.id','company_industries.industry_id')
                            ->where('company_industries.company_id',Auth::user()->id)
                            ->orderBy('job_applies.created_at', 'desc')
                            ->paginate(5);

        $image = User::where('id',Auth::user()->id)->first();
        return redirect()->route('employer#interviewList',compact('data', 'image'))->with(['updateSuccess' => 'Message have been sent successfully']);
    }

    // interview list for each job
    public function eachInterviewList($jobId){
        $data = Interview::select('interviews.*', 'job_applies.apply_date', 'users.name as seekerName', 'townships.township_name', 'states.state_name' )
                            ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('seekers', 'seekers.email', 'users.email')
                            ->leftJoin('townships', 'townships.id', 'seekers.city_id')
                            ->leftJoin('states', 'states.id', 'townships.state_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->where('company_industries.company_id',Auth::user()->id)
                            ->where('jobs.id', $jobId)
                            ->orderBy('job_applies.created_at', 'desc')
                            ->paginate(5);

        // user interface

        // retrieve industry & position
        $jobNature = Job::select('professional_titles.professional_title_name','industries.industry_name')
                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                    ->where('jobs.id', $jobId)
                    ->get();
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.job.each_interview_list', compact('data', 'image', 'jobNature'));
    }

    // interview update for each job
    public function eachInterviewUpdate(Request $request, $id){
       // interview update
       $this->checkValidationInterview($request);
       $interviewData = $this->getInterviewData($request);
       Interview::where('id', $id)->update($interviewData);

       // interview mail
       $seekerData = Interview::select('users.email', 'users.name as seekerName')
                               ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                               ->leftJoin('users', 'users.id', 'job_applies.seeker_id')
                               ->where('interviews.id', $id)
                               ->get();
       $companyData = Interview::select('professional_titles.professional_title_name', 'industries.industry_name', 'users.name as companyName')
                                   ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                                   ->leftJoin('jobs', 'jobs.id', 'job_applies.job_id')
                                   ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
                                   ->leftJoin('company_industries', 'company_industries.id', 'jobs.company_industry_id')
                                   ->leftJoin('industries', 'industries.id', 'company_industries.industry_id')
                                   ->leftJoin('users', 'users.id', 'company_industries.company_id')
                                   ->where('users.id', Auth::user()->id)
                                   ->get();

       // dd($companyData->toArray());
       $seekerEmail = $seekerData[0]->email;
       $seekerName = $seekerData[0]->seekerName;
       $jobPosition = $companyData[0]->professional_title_name;
       $industryName = $companyData[0]->industry_name;
       $companyName = $companyData[0]->companyName;
       $time = $request->time;
       $date = $request->date;
       $location = $request->location;
       Mail::to($seekerEmail)->send(new InterviewMail($seekerEmail, $seekerName, $time, $date, $location, $jobPosition, $industryName, $companyName));

       return back()->with(['updateSuccess' => 'Message have been sent successfully']);
    }

    // interview validation check
    private function checkValidationInterview($request){
        Validator::make($request->all(),[
            'time' => 'required',
            'date' => 'required',
            'location' => 'required|string'
        ])->validate();
    }

    // interview
    private function getInterviewData($request){
        return [
            'interview_date' => $request->date,
            'interview_time' => $request->time,
            'interview_location' => $request->location,
        ];
    }
}

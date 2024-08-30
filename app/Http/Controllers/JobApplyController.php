<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\seeker;
use App\Models\employer;
use App\Models\JobApply;
use Illuminate\Http\Request;
use App\Models\SkillandLanguage;
use App\Models\EmploymentHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\EducationalQualification;

class JobApplyController extends Controller
{
    //job apply
    public function applyJob($jobId,$companyId){
        // dd($jobId);
        $jobApplyCount = JobApply::where('seeker_id', Auth::user()->id)
                                    ->where('job_id',$jobId)
                                    ->get();
        if(count($jobApplyCount) != null){
            return redirect()->route('seeker#detailJob',[$jobId,$companyId])->with(['applyFail'=>'You have already applied on this job']);
        }
        else{
            $data = $this->getApplyJob($jobId);
            JobApply::create($data);
            seeker::where('email', Auth::user()->email)->update([
                'available_status' => '1'
            ]);
            return redirect()->route('seeker#detailJob',[$jobId,$companyId])->with(['applySuccess'=>'You have successfully applied']);
        }
    }

    //job apply page
    public function applyJobPage(){
        
        $data = JobApply::select('job_applies.*','professional_titles.professional_title_name as proName','users.id as companyId','users.name as employerName','townships.township_name as townshipName')
                        ->leftJoin('jobs','jobs.id','job_applies.job_id')
                        ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                        ->leftJoin('users','users.id','company_industries.company_id')
                        ->leftJoin('employers','employers.email','users.email')
                        ->leftJoin('townships','townships.id','employers.city_id')
                        ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                        ->where('job_applies.seeker_id',Auth::user()->id)
                        ->get();
                        // dd($data);
        // dd($data->toArray());

        
        return view('seeker.job.job_apply',compact('data'));
    }


    //job apply delete
    public function applyJobDelete($jobApplyId)
    {
        
        $jastl =  JobApply::where('id', $jobApplyId)
            ->get();
       $jastl =  $jastl['0']->status;

       if($jastl == "1"){
        return redirect()->route('seeker#applyJobPage')->with(['canNotDelete'=>'Your job application has been accepted. It cannot be removed.']);
       }else{
        JobApply::where('id', $jobApplyId)->delete();
        return redirect()->route('seeker#applyJobPage')->with(['deleteSuccess' => 'The applied job is cancelled successfully.']);
       }
    }


    //company
    // job apply page
    public function jobApply(){
        $image = User::where('id',Auth::user()->id)->first();
        // retrieve job apply list
        $data = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName', 'townships.township_name', 'states.state_name')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('seekers', 'seekers.email', 'users.email')
                            ->leftJoin('townships','townships.id','seekers.city_id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->leftJoin('industries','industries.id','company_industries.industry_id')
                            ->where('company_industries.company_id',Auth::user()->id)
                            ->orderBy('job_applies.created_at', 'desc')
                            ->paginate(5);

        // retrieve duplicate rows
        $highlight = [];
        foreach ($data as $d) {
            $duplicate = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName')
                                    ->leftJoin('users','users.id','job_applies.seeker_id')
                                    ->leftJoin('jobs','jobs.id','job_applies.job_id')
                                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                                    ->where('company_industries.company_id',Auth::user()->id)
                                    ->where('job_applies.seeker_id', $d->seeker_id)
                                    ->where('job_applies.status', 0)
                                    ->get();
            if(count($duplicate)>1){
                foreach ($duplicate as $du) {
                    $highlight[] = $du->id;
                }
            }
        }
        return view('employer.job.job_apply_list',compact('image','data','highlight'));
    }

    // search apply list
    public function searchApplyList(Request $request){
        // dd($request->toArray());
        $image = User::where('id',Auth::user()->id)->first();
        // retrieve job apply list
        $data = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName', 'townships.township_name', 'states.state_name')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('seekers', 'seekers.email', 'users.email')
                            ->leftJoin('townships','townships.id','seekers.city_id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->leftJoin('industries','industries.id','company_industries.industry_id')
                            ->where('company_industries.company_id',Auth::user()->id)
                            ->orderBy('job_applies.created_at', 'desc');

        if ($request->searchKey != null) {
            $data->when(request('searchKey'),function($query){
                $searchKey = request('searchKey');
                $query->where('users.name','like','%'.$searchKey.'%');
            });
        }
        $data = $data->paginate(5);
        // retrieve duplicate rows
        $highlight = [];
        foreach ($data as $d) {
            $duplicate = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName')
                                    ->leftJoin('users','users.id','job_applies.seeker_id')
                                    ->leftJoin('jobs','jobs.id','job_applies.job_id')
                                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                                    ->where('company_industries.company_id',Auth::user()->id)
                                    ->where('job_applies.seeker_id', $d->seeker_id)
                                    ->where('job_applies.status', 0)
                                    ->get();

            if(count($duplicate)>1){
                foreach ($duplicate as $du) {
                    $highlight[] = $du->id;
                }
            }
        }


        return view('employer.job.job_apply_list',compact('image','data','highlight'));
    }

    // job apply details
    public function applyDetails($seekerId){
        $data = User::select('users.name as seekerName','users.id as seekerId','seekers.*','professional_titles.professional_title_name as proTitleName','townships.township_name','states.state_name')
                        ->leftJoin('seekers','seekers.email','users.email')
                        ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
                        ->leftJoin('townships','townships.id','seekers.city_id')
                        ->leftJoin('states','states.id','townships.state_id')
                        ->where('users.id', $seekerId)
                        ->get();

        $empHistory = EmploymentHistory::where('seeker_id', $seekerId)->get();
        $education = EducationalQualification::where('seeker_id', $seekerId)->get();
        $skill = SkillandLanguage::where('seeker_id', $seekerId)->get();

                        // dd($data->toArray());
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.job.job_apply_details', compact('image','data','empHistory','education','skill'));
    }

    //view resume
    public function viewResume($seekerId){
        $data = Seeker::select('seekers.resume')
                ->leftJoin('users','users.email','seekers.email')
                ->where('users.id', $seekerId)
                ->get();
        // dd($data->toArray());
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.job.view_resume', compact('data', 'image'));
    }

    //single job
    //apply list
    public function jobApplySg($jobId){
        // dd($jobId);

        // retrieve job apply list
        $data = JobApply::select('job_applies.*', 'users.name as seekerName', 'professional_titles.professional_title_name', 'townships.township_name', 'states.state_name')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('seekers','seekers.email','users.email')
                            ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
                            ->leftJoin('townships','townships.id','seekers.city_id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->where('jobs.id', $jobId)
                            ->paginate(5);

        // retrieve duplicate rows
        $highlight = [];
        foreach ($data as $d) {
            $duplicate = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName')
                                    ->leftJoin('users','users.id','job_applies.seeker_id')
                                    ->leftJoin('jobs','jobs.id','job_applies.job_id')
                                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                                    ->where('company_industries.company_id',Auth::user()->id)
                                    ->where('job_applies.seeker_id', $d->seeker_id)
                                    ->where('job_applies.status', 0)
                                    ->get();

                                    // dd($duplicate->toArray());
            if(count($duplicate)>1){
                    $highlight[] = $d->id;
            }
        }

        // retrieve industry & position
        $jobNature = Job::select('professional_titles.professional_title_name','industries.industry_name')
                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                    ->where('jobs.id', $jobId)
                    ->get();
        $image = User::where('id',Auth::user()->id)->first();
        // dd($data->toArray());
        return view('employer.job.job_apply_list_sg', compact('image', 'data', 'highlight', 'jobNature', 'jobId'));
    }

    //search apply list
    public function searchApplyListSg(Request $request){
        // dd($request->toArray());

        // retrieve job apply list
        $data = JobApply::select('job_applies.*', 'users.name as seekerName', 'professional_titles.professional_title_name', 'townships.township_name', 'states.state_name')
                            ->leftJoin('users','users.id','job_applies.seeker_id')
                            ->leftJoin('seekers','seekers.email','users.email')
                            ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
                            ->leftJoin('townships','townships.id','seekers.city_id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->leftJoin('jobs','jobs.id','job_applies.job_id')
                            ->where('jobs.id', $request->jobId);

                            // if ($request->searchKey != null) {
                            //     $data->when(request('searchKey'),function($query){
                            //         $searchKey = request('searchKey');
                            //         $query->where('users.name','like','%'.$searchKey.'%');
                            //     });
                            // }
        if($request->status != null){
            $data = $data->where('job_applies.status', $request->status);
        }

        $data= $data->paginate(5);
        // retrieve duplicate rows
        $highlight = [];
        foreach ($data as $d) {
            $duplicate = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName')
                                    ->leftJoin('users','users.id','job_applies.seeker_id')
                                    ->leftJoin('jobs','jobs.id','job_applies.job_id')
                                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                                    ->where('company_industries.company_id',Auth::user()->id)
                                    ->where('job_applies.seeker_id', $d->seeker_id)
                                    ->where('job_applies.status', 0)
                                    ->get();

                                    // dd($duplicate->toArray());
            if(count($duplicate)>1){
                    $highlight[] = $d->id;
            }
        }
        $image = User::where('id',Auth::user()->id)->first();
        $jobNature = Job::select('professional_titles.professional_title_name','industries.industry_name')
                    ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                    ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                    ->where('jobs.id', $request->jobId)
                    ->get();
        $jobId = $request->jobId;
        return view('employer.job.job_apply_list_sg', compact('data', 'image', 'jobNature', 'jobId', 'highlight'));
    }

    // insert apply job
    private function getApplyJob($jobId){
        return [
            'seeker_id' => Auth::user()->id,
            'job_id' => $jobId,
            'apply_date' => Carbon::now()->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

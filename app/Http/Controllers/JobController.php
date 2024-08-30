<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\employer;
use App\Models\JobApply;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    // create function
    public function create(Request $request){
        $this->validationCheck($request);
        $data = $this->getCreateData($request);
        $data['created_at'] = Carbon::now();
        Job::create($data);
        return redirect()->route('employer#home')->with(['createSuccess'=>'job created successfully']);
    }

    // //update Job
    // public function update(Request $request){
    //     // dd($request->all());
    //     $this->validationCheck($request);
    //     $data = $this->getupdateData($request);
    //     $data['updated_at'] = Carbon::now();
    //     // dd($data);
    //     Job::where('id', $request->JobID)->update($data);
    //     return redirect()->route('employer#alljob')->with(['updateSuccess' => 'Job Updated Successfully']);

    // }

    //update Job
    public function update(Request $request)
    {
        $now = Carbon::now();
        // dd($now);
        $planExpire = Purchase::where('company_id', Auth::user()->id)
            ->where('expire_date', '>', $now)
            ->first();

            if($planExpire != null){
                $this->validationCheck($request);
                $data = $this->getupdateData($request);
                $data['updated_at'] = Carbon::now();
                // dd($data);
                Job::where('id', $request->JobID)->update($data);
                return redirect()->route('employer#alljob')->with(['updateSuccess' => 'Job Updated Successfully']);
            }else{
                return back()->with(['updatefail' => 'The plan has expired. Purchase again!']);
            }



    }

    //direct to job detail
    public function detail($jobId,$companyId){
        $Job =
            Job::select('jobs.*','users.name','work_types.work_type_name','salary_ranges.salary_range_name','experience_levels.experience_level_name','company_industries.company_id', 'company_industries.industry_id', 'professional_titles.professional_title_name', 'professional_titles.category_id','categories.name as category_name','industries.industry_name','users.name as company_name','employers.address','townships.township_name','states.state_name')
            ->leftJoin('company_industries', 'jobs.company_industry_id', 'company_industries.id')
            ->leftJoin('users', 'users.id', 'company_industries.company_id')
            ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
            ->leftJoin('work_types','work_types.id','jobs.work_type_id')
            ->leftJoin('salary_ranges','salary_ranges.id','jobs.salary_range_id')
            ->leftJoin('experience_levels','experience_levels.id','jobs.experience_level_id')
            ->leftJoin('categories','categories.id','professional_titles.category_id')
            ->leftJoin('industries','industries.id','company_industries.industry_id')
            ->leftJoin('employers','employers.email','users.email')
            ->leftJoin('townships','townships.id','employers.city_id')
            ->leftJoin('states','states.id','townships.state_id')
            ->where('jobs.id', $jobId)
            ->first();

            $now = Carbon::today()->format('Y-m-d');

        $moreJobs =
            Job::select('jobs.*','employers.logo','professional_titles.professional_title_name','users.name as company_name','company_industries.company_id')
            
            ->leftJoin('company_industries', 'jobs.company_industry_id', 'company_industries.id')
            ->leftJoin('users', 'users.id', 'company_industries.company_id')
            ->leftJoin('employers','employers.email','users.email')
            ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
            ->where('jobs.id','!=', $jobId)
            ->where('users.id',$companyId)
            ->where('jobs.apply_expire_date','>',$now)
            ->latest()
            ->paginate(4);

        return view('seeker.job.job_detail',compact('Job','moreJobs'));
    }

    //seeker recommend Jobs section
    public function recommendJobs()
    {
        $now = Carbon::now();
        $data = Job::select('jobs.*','company_industries.company_id','company_industries.industry_id','users.name','employers.logo','employers.address','professional_titles.professional_title_name','jobs.created_at as fixtime','townships.township_name','states.state_name')
        ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
        ->leftJoin('seekers','seekers.professional_title_id','professional_titles.id')
        // ->leftJoin('users','users.email','seekers.email')
        ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
        ->leftJoin('users','users.id','company_industries.company_id')
        ->leftJoin('employers','users.email','employers.email')
        ->leftJoin('townships','townships.id','employers.city_id')
        ->leftJoin('states','states.id','townships.state_id')

        ->where('jobs.apply_expire_date','>',$now)
        ->where('seekers.email',Auth::user()->email)
        ->orderBy('created_at','desc')
        ->paginate(5);

        return view('seeker.job.recommendJobs',compact('data'));
    }

    //delete Job Function
    public function delete($id)
    {
        try {
            JobApply::where('job_id', $id)->delete();
            Job::where('id', $id)->delete();

            return redirect()->route('employer#alljob')->with('success', 'Item deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('employer#alljob')->with('error', 'Failed to delete item.');
        }
    }

    // validation check for job create
    private function validationCheck($request){
        Validator::make($request->all(),[
            'category' => 'required',
            'profession' => 'required',
            'industry' => 'required',
            'worktype' => 'required',
            'salarytype' => 'required',
            'salaryrange' => 'required',
            'gender'=>'required',
            'experience' => 'required',
            'expdate' => 'required',
            'vacancy' => 'required|max:3',
            'jobDescription' => 'required|min:20',
            'jobRequirement' => 'required|min:20',
            'jobBenefit' => 'required|min:20',
            'age' => 'required'
        ],
        [
            'profession.required' => 'This Field is required',
            'worktype.required' => 'This Field is required',
            'salaryrange.required' => 'This Field is required'
        ])->validate();
    }

    // get data from input form
    private function getCreateData($request){
        return [
            'professional_title_id'=>$request->profession,
            'company_industry_id'=>$request->industry,
            'work_type_id'=>$request->worktype,
            'salary_type'=>$request->salarytype,
            'salary_range_id'=>$request->salaryrange,
            'gender'=>$request->gender,
            'experience_level_id'=>$request->experience,
            'job_description'=>$request->jobDescription,
            'job_requirement'=>$request->jobRequirement,
            'benefit'=>$request->jobBenefit,
            'vacancy'=>$request->vacancy,
            'age' => $request->age,
            'apply_expire_date'=>$request->expdate
        ];
    }

    private function getupdateData($request){
        return [
            'professional_title_id'=>$request->profession,
            'company_industry_id'=>$request->industry,
            'work_type_id'=>$request->worktype,
            'salary_type'=>$request->salarytype,
            'salary_range_id'=>$request->salaryrange,
            'gender'=>$request->gender,
            'experience_level_id'=>$request->experience,
            'job_description'=>$request->jobDescription,
            'job_requirement'=>$request->jobRequirement,
            'benefit'=>$request->jobBenefit,
            'vacancy'=>$request->vacancy,
            'age' => $request->age,
            'apply_expire_date'=>$request->expdate
        ];
    }
}

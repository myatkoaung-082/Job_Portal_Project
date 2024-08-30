<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\blog;
use App\Models\Plan;
use App\Models\User;
use App\Models\state;
use App\Models\seeker;
use App\Models\Contact;
use App\Models\Category;
use App\Models\employer;
use App\Models\industry;
use App\Models\JobApply;
use App\Models\Purchase;
use App\Models\township;
use App\Models\WorkType;
use App\Models\Interview;
use App\Models\SalaryRange;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use App\Models\ExperienceLevel;
use App\Models\companyIndustries;
use App\Models\professional_title;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{
    // direct to home page
    public function home(){
        $data = Plan::get();
        $image = User::where('id',Auth::user()->id)->first();
        $now = Carbon::today()->format('Y-m-d');
        $activeJob = 
             Job::select('jobs.*', 'company_industries.company_id','company_industries.industry_id','professional_titles.professional_title_name','professional_titles.category_id')
             ->leftJoin('company_industries', 'jobs.company_industry_id', 'company_industries.id')
             ->leftJoin('users', 'users.id', 'company_industries.company_id')
             ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
             ->where('company_industries.company_id',Auth::user()->id)
             ->where('jobs.apply_expire_date','>',$now)
             ->get();
        $applyTotal = JobApply::select('job_applies.*','professional_titles.professional_title_name','industries.industry_name','users.name as seekerName', 'townships.township_name', 'states.state_name')
             ->leftJoin('users','users.id','job_applies.seeker_id')
             ->leftJoin('seekers', 'seekers.email', 'users.email')
             ->leftJoin('townships','townships.id','seekers.city_id')
             ->leftJoin('states','states.id','townships.state_id')
             ->leftJoin('jobs','jobs.id','job_applies.job_id')
             ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
             ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
             ->leftJoin('industries','industries.id','company_industries.industry_id')
             ->where('company_industries.company_id',Auth::user()->id)
             ->get();
        $interviewTotal = Interview::select('interviews.*', 'professional_titles.professional_title_name','industries.industry_name','users.name as seekerName' )
             ->leftJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
             ->leftJoin('users','users.id','job_applies.seeker_id')
             ->leftJoin('jobs','jobs.id','job_applies.job_id')
             ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
             ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
             ->leftJoin('industries','industries.id','company_industries.industry_id')
             ->where('company_industries.company_id',Auth::user()->id)
             ->get();
        return view('employer.home',compact('data','image','activeJob', 'applyTotal', 'interviewTotal'));
    }

    // direct to employer verify page
    public function verifyPage(){
        return view('employer.account.verifypage');
    }

    // verify Otp
    public function verifyOtp(Request $req){
        $email = $req->email;
        $data = VerifyToken::where('token',$req->number)->first();
        if($data){
            $data->is_activated = 1;
            $data->save();
            $user = User::where('email',$data->email)->first();
            $user->is_activated = 1;
            $user->save();
            $getting_token = VerifyToken::where('token',$data->token)->first();
            $getting_token->delete();

            $data = Plan::get();
            return view('employer.home',compact('data'));
        }else{
            return redirect()->route('employer#verify')->with(['incorrect'=>'invalid code']);
        }
    }

    // direct to news page
    public function newsPage(){
        $data = blog::when(request('key1'),function($query){
            $key1 = request('key1');
            $query->orWhere('title','like','%'.$key1.'%')
                  ->orWhere('description','like','%'.$key1.'%');
        })->orderBy('created_at','desc')->paginate(4);

       
        return view('employer.main.news',compact('data'));
    }

    // direct to news details page
    public function newsDetail($id){
        $data = blog::where('id',$id)
        ->first();
        $count = [
            'view_count' => $data->view_count + 1
        ];
        $data = blog::where('id',$id)->update($count);
        $data= blog::where('id',$id)->first();
        return view('employer.main.newsdetail',compact('data'));
    }

    // direct to change password page
    public function changepasspage(){
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.account.changePassPage',compact('image'));
    }

    // change password
    public function changepass(Request $req){
        // validation check
        $this->validationCheckPass($req);
        $currentPassword = User::select('password')->where('id',Auth::user()->id)->first();
        $dbpass = $currentPassword->password; // db hash value

        // update password
        if(Hash::check($req->oldPassword,$dbpass)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($req->newPassword)
            ]);
            Auth::logout();
            return redirect()->route('auth#loginPage')->with(['updatePassword'=>'Password Changed Successfully']);
        }else{
            return back()->with(['passError'=>' Old and New Passwords must be same ']);
        }
    }

    //deactivateAcc
    public function deactivateAcc(Request $req)
    {
        // dd("hello");
        $this->deactivateAccValidationCheck($req);

        if (!Hash::check($req->password, Auth::user()->password)) {
            return back()->with(['password' => 'The password is incorrect.']);
        }

        JobApply::select('job_applies.*')
            ->leftJoin('jobs', 'jobs.id', 'job_applies.job_id')
            ->leftJoin('company_industries', 'company_industries.id', 'jobs.company_industry_id')
            ->where('company_industries.company_id', Auth::user()->id)
            ->delete();

        Job::select('jobs.*')
            ->leftJoin('company_industries', 'company_industries.id', 'jobs.company_industry_id')
            ->where('company_industries.company_id', Auth::user()->id)
            ->delete();

        companyIndustries::where('company_id', Auth::user()->id)->delete();
        TransactionHistory::where('company_id', Auth::user()->id)->delete();
        Purchase::where('company_id', Auth::user()->id)->delete();
        Contact::where('company_id', Auth::user()->id)->delete();
        employer::where('email', Auth::user()->email)->delete();
        

        User::where('id', Auth::user()->id)->delete();

        Auth::logout();


        return redirect()->route('auth#loginPage')->with(['deactivateSuccess' => 'Your account has been deleted successfully.']);
    }


    public function checkUserStatus(){
        // check status level
        $today = Carbon::today()->format('Y-m-d');
        $statusLevel = Purchase::select('purchases.*')
                                ->where('company_id',Auth::user()->id)
                                ->where('expire_date','>',$today)
                                ->where('status_level',1)
                                ->first();
        if($statusLevel != null){
            $statusLevel = 1;
        } else{
            $statusLevel = 0;
        }
        return response()->json(['status' => $statusLevel]);
        
    }
   

    // direct to employer job create page
    public function createPage(){
        $data = Category::get();
       
        $industry = companyIndustries::select('company_industries.*','industries.industry_name')
                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                    ->where('company_industries.company_id',Auth::user()->id)
                    ->get();

        $workType = WorkType::get();
        $salaryRange = SalaryRange::get();
        $experienceLevel = ExperienceLevel::get();

        $image = User::where('id',Auth::user()->id)->first();
        
        return view('employer.job.create',compact('data','industry','workType','salaryRange','experienceLevel','image'));
    }

    // direct to view company
    public function viewCompany(){
        $data = User::select('users.name','users.id as user_id','townships.township_name','employers.logo','employers.address','states.state_name')
                    ->leftJoin('employers','employers.email','users.email')
                    ->leftJoin('townships','townships.id','employers.city_id')
                    ->leftJoin('states','states.id','townships.state_id')
                    ->where('users.role','employer')
                    ->get();
        
        return view('employer.account.viewcompany',compact('data'));
    }

    // direct to profile update Page
    public function profileupdate(){
        $data = employer::select('townships.id as townshipId','townships.township_name','townships.state_id','employers.*')
        ->where('email', Auth::user()->email)
        ->leftJoin('townships','townships.id','employers.city_id')
        ->first();
        $state = state::get();
        $image = User::where('id',Auth::user()->id)->first();
        
        return view('employer.account.profileupdate',compact('data','state','image'));
    }

    // direct to update profile
    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $this->profileDataValidationCheck($request);
        $data = $this->requestProfileData($request);
        $now = Carbon::now();
        $foundedDate = Carbon::parse($data['founded_date']);
        $foundedDate = $foundedDate->format('Y-m-d');
        if($foundedDate > $now){
            return back()->with(['dateError'=>'Founded Date Must lower than current date']);
        }
        if ($request->hasFile('companyLogo')) {
            $oldLogo = employer::select('logo')->where('email', Auth::user()->email)->first()->toArray();
            $oldLogo = $oldLogo['logo'];

            if ($oldLogo != null) {
                Storage::delete('public/company/'.$oldLogo);
            }

            $fileName = uniqid() . $request->file('companyLogo')->getClientOriginalName();
            $request->file('companyLogo')->storeAs('public/company', $fileName);
            $data['logo'] = $fileName;

        }
        $data['updated_at'] = Carbon::now();
        employer::where('email', $request->oldEmail)->update($data);
        return redirect()->route('employer#profileupdate')->with(['updateSuccess' => 'Data Updated Successfully']);
    }

    // update image
    public function updateImage(Request $req){
        // dd($req->all());
        $this->imagevalidation($req);
        $data = [];
        if ($req->hasFile('image')) {
            $oldLogo = user::select('image')->where('id', Auth::user()->id)->first()->toArray();
            $oldLogo = $oldLogo['image'];

            if ($oldLogo != null) {
                Storage::delete('public/company/'.$oldLogo);
            }

            $fileName = uniqid() . $req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public/company', $fileName);
            $data['image'] = $fileName;

        }
        User::where('id',Auth::user()->id)->update($data);
        return back()->with(['updateSuccess'=> 'Image Updated Successfully']);
    }

    //direct to delete industry
    public function deleteIndustry($id){
        companyIndustries::where('id',$id)->delete();
        Job::where('company_industry_id',$id)->delete();
        return back()->with(['deleteIndustry' => 'Industry Deleted....']);
    }

    //direct to edit industry
    public function editIndustry($id){

        $industries = industry::get();

        $industry = industry::select('industries.industry_name','company_industries.industry_id as company_industry_id','company_industries.id as companyIndustryId')
                        ->leftJoin('company_industries','company_industries.industry_id','industries.id')
                        ->where('company_industries.id',$id)
                        ->first();

                        // dd($industryName);

        return view('employer.account.editIndustry',compact('industries','industry'));
    }

    //direct to update industry
    public function updateIndustry(Request $req){
        // dd($req->all());
        $this->industryValidationCheck($req);
        $data = $this->requestIndustrytData($req);

        companyIndustries::where('id', $req->companyIndustryId)->update($data);
        return redirect()->route('employer#IndustryPage')->with(['updateSuccess' => 'Industry Updated Successfully']);
    }

    // direct to all job 
    public function alljob(){
        $now = Carbon::today()->format('Y-m-d');
        $activeJob =
        Interview::select(DB::raw('COUNT(job_applies.id) as total_job'), DB::raw('COUNT(interviews.id) as total_interview'), 'jobs.*' , 'industries.industry_name', 'professional_titles.professional_title_name')
                    ->rightJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                    ->rightJoin('jobs','jobs.id','job_applies.job_id')
                    ->leftJoin('company_industries', 'jobs.company_industry_id', 'company_industries.id')
                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                    ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
                    ->where('company_industries.company_id',Auth::user()->id)
                    ->where('jobs.apply_expire_date','>',$now)
                    ->groupBy('jobs.id')
                    ->get();
        $expireJob =
        Interview::select(DB::raw('COUNT(job_applies.id) as total_job'), DB::raw('COUNT(interviews.id) as total_interview'), 'jobs.*' , 'industries.industry_name', 'professional_titles.professional_title_name')
                    ->rightJoin('job_applies', 'job_applies.id', 'interviews.job_apply_id')
                    ->rightJoin('jobs','jobs.id','job_applies.job_id')
                    ->leftJoin('company_industries', 'jobs.company_industry_id', 'company_industries.id')
                    ->leftJoin('industries','industries.id','company_industries.industry_id')
                    ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
                    ->where('company_industries.company_id',Auth::user()->id)
                    ->where('jobs.apply_expire_date','<',$now)
                    ->groupBy('jobs.id')
                    ->get();
       
        $image = User::where('id',Auth::user()->id)->first();    
               
        return view('employer.job.all',compact('activeJob','expireJob','image'));
    }

    // direct to company detail view
    // public function companydetail($id){
    //     $companyData = User::select('users.name','users.created_at as userCreateAt','employers.*','townships.township_name','states.state_name')
    //                         ->leftJoin('employers','employers.email','users.email')
    //                         ->leftJoin('townships','townships.id','employers.city_id')
    //                         ->leftJoin('states','states.id','townships.state_id')
    //                         ->where('users.id',$id)
    //                         ->get();
        
    //     $companyIndustry = companyIndustries::select('industries.industry_name')
    //                                         ->leftJoin('industries','industries.id','company_industries.industry_id')
    //                                         ->where('company_industries.company_id',$id)
    //                                         ->get();
        
    //     $companyJob = Job::select('jobs.*','professional_titles.professional_title_name as proTitle','salary_ranges.salary_range_name as salary','categories.name')
    //                                     ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
    //                                     ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
    //                                     ->leftJoin('salary_ranges','salary_ranges.id','jobs.salary_range_id')
    //                                     ->leftJoin('categories','categories.id','professional_titles.category_id')
    //                                     ->where('company_industries.company_id',$id)
    //                                     ->get();
     
    //     return view('employer.account.companydetail',compact('companyData','companyIndustry','companyJob'));
    // }

    // direct to jobs view
    // public function jobs(){
    //     // dd("hello");
    //     $now = Carbon::today()->format('Y-m-d');
    //     $data = 
    //         Job::select('jobs.*','company_industries.company_id','company_industries.industry_id','users.name','employers.logo','employers.address','professional_titles.professional_title_name','jobs.created_at as fixtime','townships.township_name','states.state_name')
    //             ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
    //             ->leftJoin('users','users.id','company_industries.company_id')
    //             ->leftJoin('employers','users.email','employers.email')
    //             ->leftJoin('townships','townships.id','employers.city_id')
    //             ->leftJoin('states','states.id','townships.state_id')
    //             ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
    //             ->where('jobs.apply_expire_date','>',$now)
    //             ->latest()
    //             ->get();;
               
    //     return view('employer.job.job',compact('data'));
    // }

    // direct to edit Job view
    public function editJob($id){

        $categories = Category::get();
        $pfdata = [];
        $industry = industry::get();
        $workType = WorkType::get();
        $salaryRange = SalaryRange::get();
        $experienceLevel = ExperienceLevel::get();

        $Job = 
            Job::select('jobs.*','work_types.work_type_name','salary_ranges.salary_range_name','experience_levels.experience_level_name','company_industries.company_id', 'company_industries.industry_id', 'professional_titles.professional_title_name', 'professional_titles.category_id')
            ->leftJoin('company_industries', 'jobs.company_industry_id', 'company_industries.id')
            ->leftJoin('users', 'users.id', 'company_industries.company_id')
            ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
            ->leftJoin('work_types','work_types.id','jobs.work_type_id')
            ->leftJoin('salary_ranges','salary_ranges.id','jobs.salary_range_id')
            ->leftJoin('experience_levels','experience_levels.id','jobs.experience_level_id')
            ->where('jobs.id', $id)
            ->first();

        $industry = companyIndustries::select('company_industries.*','industries.industry_name')
        ->leftJoin('industries','industries.id','company_industries.industry_id')
        ->where('company_industries.company_id',Auth::user()->id)
        ->get();

        $image = User::where('id',Auth::user()->id)->first();
            
        return view('employer.job.edit',compact('categories', 'pfdata', 'industry','Job','workType','salaryRange','experienceLevel','image'));
    }

    //Plan
    //Plan subscribe
    public function  subscribePlan($id){
        $plan = Plan::select('id','plan_price')
                    ->where('id',$id)
                    ->first();
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.plan.payment_method', compact('plan','image'));
    }

    //payment method
    public function paymentMethod(Request $request){
        $data = $request->payment;
        $planId = $request->planId;
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.plan.deposit_confirm', compact('planId','data','image'));
    }

    // direct to deposit page
    public function depositPage(){
        return view('employer.plan.deposit_confirm');
    }

    //deposit confirm
    public function depositConfirm(Request $request){
        $subscription = Purchase::where('company_id',Auth::user()->id)
                                ->latest()
                                ->first();
        

        // if comapany has active plan
        if($subscription){
            $data = $request->all();
            $subscription->extendSubscription($data);
        }

        // if company does not have active plan
        else{
            $this->validationDepositConfirm($request);

            $orderCode = mt_rand(0,99999);
            $orderCode = 'NEXT'.$orderCode;
            $data = $this->getDepositConfirm($request, $orderCode);

            $fileName =uniqid().$request->file('transactionSlip')
                        ->getClientOriginalName();
            $request->file('transactionSlip')->storeAs('public/transactionSlip/',$fileName);
            $data['transaction_slip'] = $fileName;

            Purchase::create($data);
            TransactionHistory::create($data);
        }
        return redirect()->route('employer#home')->with(['createSuccess' => 'Plan subscribed successfully']);
    }


    // direct to transaction page

    public function transactionPage(){
        $data = TransactionHistory::select('transaction_histories.*','plans.plan_name')
                                    ->leftJoin('plans','plans.id','transaction_histories.plan_id')
                                    ->where('transaction_histories.company_id',Auth::user()->id)
                                    ->orderBy('purchase_date','desc')
                                    ->paginate(5);
        
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.plan.transaction_history',compact('data','image'));
    }

    //header menu list
    // home page
    public function headerHome(){
        $now = Carbon::today()->format('Y-m-d');
        $activeJobs =
            Job::select('jobs.*')
            ->where('jobs.apply_expire_date', '>', $now)
            ->get();

        $companies = employer::select('employers.*')
                    ->get();

        $seekers = seeker::select('seekers.*')
                ->get();

                $companyLogos = User::select('users.id as user_id','employers.logo')
                    ->leftJoin('employers','employers.email','users.email')
                    ->where('users.role','employer')
                    ->get();

                    $latestJobs =
                    Job::select('jobs.*','employers.logo','professional_titles.professional_title_name','users.name as company_name','company_industries.company_id')
                    ->leftJoin('company_industries', 'company_industries.id','jobs.company_industry_id')
                    ->leftJoin('users', 'users.id', 'company_industries.company_id')
                    ->leftJoin('employers','employers.email','users.email')
                    ->leftJoin('professional_titles', 'professional_titles.id', 'jobs.professional_title_id')
                    ->where('jobs.apply_expire_date','>',$now)
                    ->latest()
                    // ->get();
                    ->paginate(8);
                    // ->paginate();

                    // dd($latestJobs->toArray());

        // dd($companies->toArray());

       
        return view('employer.main.header_home',compact('activeJobs','companies','seekers','companyLogos','latestJobs'));
    }

    //all job
    public function headerAllJob(){
        
        $now = Carbon::today()->format('Y-m-d');
        $data =
            Job::select('jobs.*','company_industries.company_id','company_industries.industry_id','users.name','employers.logo','employers.address','professional_titles.professional_title_name','jobs.created_at as fixtime','townships.township_name','states.state_name')
                ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
                ->leftJoin('users','users.id','company_industries.company_id')
                ->leftJoin('employers','users.email','employers.email')
                ->leftJoin('townships','townships.id','employers.city_id')
                ->leftJoin('states','states.id','townships.state_id')
                ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                ->where('jobs.apply_expire_date','>',$now)
                ->orderBy('created_at','desc')
                ->paginate(5);

        // need for user interface
        $state = state::get();
        $townshipData = [];
        $proTitle = professional_title::get();
        $salaryRange = SalaryRange::get();
        $workType = WorkType::get();
        $expLevel =ExperienceLevel::get();
        $category = Category::select('categories.*',
        DB::raw('COUNT(jobs.id) as total_job'))
        ->leftJoin('professional_titles','professional_titles.category_id','categories.id')
        ->leftJoin('jobs',
                    function($join){
                        $now = Carbon::today()->format('Y-m-d');
                        $join->on('jobs.professional_title_id','=','professional_titles.id')
                                ->where('jobs.apply_expire_date','>',$now);
                    })
        ->groupBy('categories.id','categories.name')
        ->get();        
        // dd($category->toArray());
        return view('employer.main.all_job',compact('data','state','category','townshipData','proTitle','salaryRange','category','workType','expLevel'));
    }

    //search job
    public function headerSearchJob(Request $request){
        // dd("hello");
        $now = Carbon::today()->format('Y-m-d');
        $data =
            Job::select('jobs.*','company_industries.company_id','company_industries.industry_id','users.name','employers.logo','employers.address','professional_titles.professional_title_name','jobs.created_at as fixtime','townships.township_name','states.state_name')
                ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
                ->leftJoin('users','users.id','company_industries.company_id')
                ->leftJoin('employers','users.email','employers.email')
                ->leftJoin('townships','townships.id','employers.city_id')
                ->leftJoin('states','states.id','townships.state_id')
                ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                ->where('jobs.apply_expire_date','>',$now);

            // query
            if($request->searchKey != null){
                if($request->state != null){
                    $data->when(request('state'),function($query){
                        $state = request('state');
                        $query->where('states.id',$state);
                    });
                    if($request->township != null){
                        $data->when(request('township'),function($query){
                            $township = request('township');
                            $query->where('townships.id',$township);
                        });
                    }
                }
                $data->when(request('searchKey'),function($query){
                    $searchKey = request('searchKey');
                    $query->where('professional_titles.professional_title_name','like','%'.$searchKey.'%');
                });
            }
            elseif ($request->state != null) {
                $data->when(request('state'),function($query){
                    $state = request('state');
                    $query->where('states.id',$state);
                });
                if ($request->township != null) {
                    $data->when(request('township'),function($query){
                        $township = request('township');
                        $query->where('townships.id',$township);
                    });
                }
            }

            $data = $data->orderBy('created_at','desc')->paginate(5);

        //need for user interface
        $state = state::get();
        $salaryRange = SalaryRange::get();
        $workType = WorkType::get();
        $expLevel = ExperienceLevel::get();
        $proTitle = professional_title::get();
        $category = Category::select('categories.*',
        DB::raw('COUNT(jobs.id) as total_job'))
        ->leftJoin('professional_titles','professional_titles.category_id','categories.id')
        ->leftJoin('jobs',
                    function($join){
                        $now = Carbon::today()->format('Y-m-d');
                        $join->on('jobs.professional_title_id','=','professional_titles.id')
                                ->where('jobs.apply_expire_date','>',$now);
                    })
        ->groupBy('categories.id','categories.name')
        ->get();
        //fetch township if seeker serach by state
        $townshipData = township::select('townships.township_name','townships.id as township_id')
                        ->leftJoin('states','states.id','townships.state_id')
                        ->where('townships.state_id',$request->state)
                        ->get();

        return view('employer.main.all_job',compact('state','townshipData','salaryRange','workType','expLevel','data','proTitle','category'));
    }

    // filter job
    public function headerFilterJob(Request $request){
        // dd("hello");
        $now = Carbon::today()->format('Y-m-d');
        $data =
            Job::select('jobs.*','company_industries.company_id','company_industries.industry_id','users.name','employers.logo','employers.address','professional_titles.professional_title_name','jobs.created_at as fixtime','townships.township_name','states.state_name')
                ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
                ->leftJoin('users','users.id','company_industries.company_id')
                ->leftJoin('employers','users.email','employers.email')
                ->leftJoin('townships','townships.id','employers.city_id')
                ->leftJoin('states','states.id','townships.state_id')
                ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                ->leftJoin('salary_ranges','salary_ranges.id','jobs.salary_range_id')
                ->leftJoin('categories','categories.id','professional_titles.category_id')
                ->leftJoin('work_types','work_types.id','jobs.work_type_id')
                ->leftJoin('experience_levels','experience_levels.id','jobs.experience_level_id')
                ->where('jobs.apply_expire_date','>',$now);
        // dd($data->get()->toArray());

        //query
        if ($request->salaryRange != null) {
            $data->when(request('salaryRange'),function($query){
                $salaryRange = request('salaryRange');
                $query->where('salary_ranges.id',$salaryRange);
            });
        }
        if ($request->category != null) {
            $data->when(request('category'),function($query){
                $category = request('category');
                $query->where('categories.id',$category);
            });
        }
        if ($request->workType != null) {
            $data->when(request('workType'),function($query){
                $workType = request('workType');
                $query->where('work_types.id',$workType);
            });
        }if ($request->expLevel != null) {
            $data->when(request('expLevel'),function($query){
                $expLevel = request('expLevel');
                $query->where('experience_levels.id',$expLevel);
            });
        }

        //need for user interface
        // fetch state
        $state = state::get();
        $proTitle = professional_title::get();
        $salaryRange = SalaryRange::get();
        $workType = WorkType::get();
        $expLevel = ExperienceLevel::get();
        $category = Category::select('categories.*',
        DB::raw('COUNT(jobs.id) as total_job'))
        ->leftJoin('professional_titles','professional_titles.category_id','categories.id')
        ->leftJoin('jobs',
                    function($join){
                        $now = Carbon::today()->format('Y-m-d');
                        $join->on('jobs.professional_title_id','=','professional_titles.id')
                                ->where('jobs.apply_expire_date','>',$now);
                    })
        ->groupBy('categories.id','categories.name')
        ->get();

        // dd($category->toArray());
        //fetch township if seeker serach by state
        $townshipData = township::select('townships.township_name','townships.id as township_id')
                        ->leftJoin('states','states.id','townships.state_id')
                        ->where('townships.state_id',$request->state)
                        ->get();
        $data = $data->orderBy('created_at','desc')->paginate(5);
        
        return view('employer.main.all_job' ,compact('data','state','townshipData','proTitle','salaryRange','category','workType','expLevel'));
    }

    // detail job
    public function headerDetail($jobId,$companyId){
        // dd("hello");
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

        return view('employer.main.job_detail',compact('Job','moreJobs'));
    }

    // company
    // all company
    public function headerViewCompany(){
        // dd("hello");
        $now = Carbon::today()->format('Y-m-d');
       
        $data = User::select('users.name','users.id as user_id','townships.township_name','employers.logo','employers.address','states.state_name',DB::raw('COUNT(jobs.id) as total_job'))
        ->leftJoin('employers','employers.email','users.email')
        ->leftJoin('townships','townships.id','employers.city_id')
        ->leftJoin('states','states.id','townships.state_id')
        ->leftJoin('company_industries','company_industries.company_id','users.id')
        ->leftJoin('jobs', function($join){
            $now = Carbon::today()->format('Y-m-d');
            $join->on('jobs.company_industry_id','company_industries.id')
            ->where('jobs.apply_expire_date','>',$now);
        })
        ->groupBy('company_industries.company_id')
        ->where('users.role','employer')
        ->paginate(6);

        $industry = industry::get();
        $userIndustry = "";
       
        // dd($data->toArray());
        return view('employer.main.all_company',compact('data','industry','userIndustry'));
    }

    // search company
    public function headerSearchCompany(Request $request){
        // dd("hello");
        // need for UI
        $industry = industry::get();

        // query
        $now = Carbon::today()->format('Y-m-d');
        $data = User::select('users.name','users.id as user_id','townships.township_name','employers.logo','employers.address','states.state_name',DB::raw('COUNT(jobs.id) as total_job'))
        ->leftJoin('employers','employers.email','users.email')
        ->leftJoin('townships','townships.id','employers.city_id')
        ->leftJoin('states','states.id','townships.state_id')
        ->leftJoin('company_industries','company_industries.company_id','users.id')
        ->leftJoin('jobs', function($join){
            $now = Carbon::today()->format('Y-m-d');
            $join->on('jobs.company_industry_id','company_industries.id')
            ->where('jobs.apply_expire_date','>',$now);
        })
        ->groupBy('company_industries.company_id')
        ->where('users.role','employer');

                    if($request->searchKey != null){
                        if ($request->industry != null) {
                            $data->when(request('industry'),function($query){
                                $industry = request('industry');
                                $query->where('company_industries.industry_id',$industry);
                            });
                        }
                        $data->when(request('searchKey'),function($query){
                            $searchKey = request('searchKey');
                            $query->where('users.name','like','%'.$searchKey.'%');
                        });
                    }
                    elseif ($request->industry != null) {
                        $data->when(request('industry'),function($query){
                            $industry = request('industry');
                            $query->where('company_industries.industry_id',$industry);
                        });

                    }
        // dd($data->get()->toArray());
        $data = $data->paginate(6);

        if($request->industry){
            $userIndustry = $request->industry;
        }else{
            $userIndustry = "";
        }

        return view('employer.main.all_company',compact('data','industry','userIndustry'));

    }

    // direct to company detail view with industry
    public function headerCompanyDetail($companyId, $userIndustry){
        // dd("hello");
        $now = Carbon::today()->format('Y-m-d');
        $companyData = User::select('users.name', 'users.id as companyId', 'users.created_at as userCreateAt','employers.*','townships.township_name','states.state_name')
                            ->leftJoin('employers','employers.email','users.email')
                            ->leftJoin('townships','townships.id','employers.city_id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->where('users.id',$companyId)
                            ->get();
                        

        $userCreateAt = Carbon::parse($companyData[0]->userCreateAt);
        
        $companyIndustry = companyIndustries::select('industries.industry_name')
                                            ->leftJoin('industries','industries.id','company_industries.industry_id')
                                            ->where('company_industries.company_id',$companyId)
                                            ->get();
        
        $companyJob = Job::select('jobs.*','company_industries.company_id','professional_titles.professional_title_name as proTitle','salary_ranges.salary_range_name as salary','categories.name')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                            ->leftJoin('salary_ranges','salary_ranges.id','jobs.salary_range_id')
                            ->leftJoin('categories','categories.id','professional_titles.category_id')
                            ->where('company_industries.company_id',$companyId)
                            ->where('company_industries.industry_id',$userIndustry)
                            ->where('jobs.apply_expire_date','>',$now)
                            ->paginate(3);   
        return view('employer.main.company_detail',compact('companyData','companyIndustry','companyJob','userCreateAt'));
    }

    // direct to company detail view without industry
    public function headerCompanyDetailWithout($companyId){
        $now = Carbon::today()->format('Y-m-d');
        $companyData = User::select('users.name','users.id as companyId', 'users.created_at as userCreateAt','employers.*','townships.township_name','states.state_name')
                            ->leftJoin('employers','employers.email','users.email')
                            ->leftJoin('townships','townships.id','employers.city_id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->where('users.id',$companyId)
                            ->get();

        $userCreateAt = Carbon::parse($companyData[0]->userCreateAt);
        
        $companyIndustry = companyIndustries::select('industries.industry_name')
                                            ->leftJoin('industries','industries.id','company_industries.industry_id')
                                            ->where('company_industries.company_id',$companyId)
                                            ->get();
        
        $companyJob = Job::select('jobs.*','company_industries.company_id','professional_titles.professional_title_name as proTitle','salary_ranges.salary_range_name as salary','categories.name')
                            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
                            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                            ->leftJoin('salary_ranges','salary_ranges.id','jobs.salary_range_id')
                            ->leftJoin('categories','categories.id','professional_titles.category_id')
                            ->where('company_industries.company_id',$companyId)
                            ->where('jobs.apply_expire_date','>',$now)
                            ->paginate(3);
        return view('employer.main.company_detail',compact('companyData','companyIndustry','companyJob','userCreateAt'));
    }

    // password validation check
    private function validationCheckPass($req){
        Validator::make($req->all(),[
            'oldPassword' => 'required|min:8|max:10',
            'newPassword' => 'required|min:8|max:10',
            'confirmPassword' => 'required|min:8|same:newPassword|max:10'
        ],[

        ])->validate();
    }

    //deposit confirm validation check
    private function validationDepositConfirm($request){
        Validator::make($request->all(),[
            'accountName' => 'required',
            'accountPhone' => 'required',
            'transactionSlip' => 'required|image|mimes:jpeg,png,jpg',
            
        ])->validate();
    }

    private function getDepositConfirm($request, $orderCode){
       return [
        'company_id' => $request->companyId,
        'plan_id' => $request->planId,
        'order_code' => $orderCode,
        'account_name' => $request->accountName,
        'account_phone' => $request->accountPhone,
        'purchase_date' => Carbon::now()->format('Y-m-d'),
        'expire_date' => Carbon::now()->addMonth()->format('Y-m-d'),
       ];
    }

    //PorfileData validation check
    private function profileDataValidationCheck($req)
    {
        Validator::make($req->all(), [
            'companyOwner' => 'required',
            'companyPhone' => 'required|max:11|min:9',
            'companyLogo' => 'required|mimes:jpg,jpeg,png,webp,jfif,tiff',
            'address' => 'required',
            // 'foundedDate' => 'required',
            'state' => 'required',
            'city' => 'required',
            // 'website' => 'required',
            // 'noEmployee' => 'required',
            'companyDescription' => 'required|min:20',
        ])->validate();
    }

    //accept Profile input
    private function requestProfileData($req)
    {
        return [
            'founder_name' => $req->companyOwner,
            'company_phone' => $req->companyPhone,
            'address' => $req->address,
            'founded_date' => $req->foundedDate,
            'city_id' => $req->city,
            'website' => $req->website,
            'number_of_employees' => $req->noEmployee,
            'company_description' => $req->companyDescription
        ];
    }

    //industry validation
    private function industryValidationCheck($req)
    {
        Validator::make($req->all(), [
            'companyId' => 'required',
            'industryId' => 'required',
        ],[
            'industryId.unique' => 'duplicate error'
        ])->validate();
    }

    //accept industry input
    private function requestIndustrytData($req)
    {
        return [
            'company_id' => $req->companyId,
            'industry_id' => $req->industryId
        ];
    }

    private function imagevalidation($req){
        Validator::make($req->all(),[
            'image' => 'required| mimes:jpg,jpeg,png,webp,jfif,tiff'
        ])->validate();
    }

    private function imagearray($req){
        return [
            'image' => $req->image
        ];
    }

    private function deactivateAccValidationCheck($req)
    {

        Validator::make($req->all(), [
            'password' => 'required',
        ])->validate();
    }
}

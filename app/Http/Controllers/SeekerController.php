<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\blog;
use App\Models\User;
use App\Models\state;
use App\Models\seeker;
use App\Models\Contact;
use App\Models\Category;
use App\Models\employer;
use App\Models\industry;
use App\Models\JobApply;
use App\Models\township;
use App\Models\WorkType;
use App\Models\Interview;
use App\Models\SalaryRange;
use App\Models\SaveCompany;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use App\Models\ExperienceLevel;
use App\Models\SkillandLanguage;
use App\Models\companyIndustries;
use App\Models\EmploymentHistory;
use App\Models\professional_title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\EducationalQualification;
use Illuminate\Support\Facades\Validator;

class SeekerController extends Controller
{
    // direct to seeker home
    public function home(){
        $data = JobApply::where('seeker_id',Auth::user()->id)->get();
        if($data == null){
            $data = [];
        }


        $availableStatus = seeker::select('available_status')
            ->where('email', Auth::user()->email)
            ->first();

        $exists = JobApply::where('seeker_id', Auth::user()->id)->exists();
        return view('seeker.home',compact('data','availableStatus','exists'));
    }

    // direct to seeker home page
    public function homepage(){
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

       
        return view('seeker.main.homePage',compact('activeJobs','companies','seekers','companyLogos','latestJobs'));
    }

    public function available()
    {

        seeker::where('email', Auth::user()->email)->update([
            'available_status' => '1'
        ]);

        return back();


        // dd('available');
    }

    public function unavailable()
    {

        seeker::where('email', Auth::user()->email)->update([
            'available_status' => '0'
        ]);


        JobApply::where('seeker_id', Auth::user()->id)
        ->where('status', '!=', '1')
        ->delete();

        // $JAhas = JobApply::where('seeker_id',Auth::user()->id)
        //         ->where('status','1')
        //         ->get();

        // dd( $jaIsSet->toArray());

        // if(isset($JAhas)){
        //     dd('it is has');
        // }else{

        // }


        return back();
    }

   

    // seeker deactivate Acc
    public function deactivateAcc(Request $req)
    {
        // dd('hello');
        $this->deactivateAccValidationCheck($req);

        if (!Hash::check($req->password, Auth::user()->password)) {
            return back()->with(['password' => 'The password is incorrect.']);
        }
        Interview::leftJoin('job_applies','job_applies.id','interviews.job_apply_id')
                    ->where('job_applies.seeker_id',Auth::user()->id)
                    ->delete();
        JobApply::where('seeker_id', Auth::user()->id)->delete();
        EducationalQualification::where('seeker_id', Auth::user()->id)->delete();
        EmploymentHistory::where('seeker_id', Auth::user()->id)->delete();
        SkillandLanguage::where('seeker_id', Auth::user()->id)->delete();
        SaveCompany::where('seeker_id',Auth::user()->id)->delete();
        Contact::where('seeker_id', Auth::user()->id)->delete();
        seeker::where('email', Auth::user()->email)->delete();
        User::where('id', Auth::user()->id)->delete();
        Auth::logout();
        return redirect()->route('auth#loginPage')->with(['deactivateSuccess' => 'Your account has been deleted successfully.']);
    }

   
    // direct to seeker verify page
    public function verifyPage(){
        return view('seeker.account.verifypage');
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

            $availableStatus = seeker::select('available_status')
                ->where('email', Auth::user()->email)
                ->first();

            $exists = JobApply::where('seeker_id', Auth::user()->id)->exists();

            return view('seeker.home',compact('availableStatus','exists'))->with(['success'=>'Your Account is Ready to Use']);
        }else{
            return redirect()->route('seeker#verify')->with(['incorrect'=>'invalid code']);
        }
    }

    // direct to news page
    public function newsPage(){
        $data = blog::when(request('key1'),function($query){
            $key1 = request('key1');
            $query->orWhere('title','like','%'.$key1.'%')
                  ->orWhere('description','like','%'.$key1.'%');
        })->orderBy('created_at','desc')->paginate(4);

       
        return view('seeker.main.news',compact('data'));
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

       
        return view('seeker.main.newsdetail',compact('data'));
    }

    // direct to view company
    public function viewCompany(){

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
        return view('seeker.account.viewcompany',compact('data','industry','userIndustry'));
    }


    // search company
    public function searchCompany(Request $request){
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

        return view('seeker.account.viewcompany',compact('data','industry','userIndustry'));

    }
    

    // direct to company detail view with industry
    public function companydetail($companyId, $userIndustry){
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
                            ->get();   
        return view('seeker.account.companydetail',compact('companyData','companyIndustry','companyJob','userCreateAt'));
    }

    // direct to company detail view without industry
    public function companydetailWithout($companyId){
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
                            ->get();
        return view('seeker.account.companydetail',compact('companyData','companyIndustry','companyJob','userCreateAt'));
    }
    
    //direct to seeker profileupdate page
    public function profileupdate(){
        $proTitles = professional_title::get();
        $townships = township::get();
        $states = state::get();
        $data = seeker::select('seekers.*','professional_titles.*','townships.township_name','townships.state_id','townships.id as township_id')
                ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
                ->leftJoin('townships','townships.id','seekers.city_id')
                ->where('email',Auth::user()->email)
                ->first();

                // dd($data);

        $educations = EducationalQualification::select('educational_qualifications.*')
        ->leftJoin('users','users.id','educational_qualifications.seeker_id')
        ->where('users.id',Auth::user()->id)
        ->get();

        $employments = EmploymentHistory::select('employment_histories.*')
        ->leftJoin('users','users.id','employment_histories.seeker_id')
        ->where('users.id',Auth::user()->id)
        ->get();

        $skills = SkillandLanguage::select('skilland_languages.*')
        ->leftJoin('users','users.id','skilland_languages.seeker_id')
        ->where('users.id',Auth::user()->id)
        ->get();

        
                
        return view('seeker.account.profileupdate',compact('proTitles','states','townships','data','educations','employments','skills'));
    }

    public function updateProfile(Request $request){
        // dd($request->all());
        $this->profileDataValidationCheck($request);
        $data = $this->requestProfileData($request);
        $today = Carbon::parse($request->dob);
        // $dt = $today->toDateTimeString();
        $dt = $today->subYears(18);
        $dt = $dt->format('Y-m-d');
        // dd($dt,$data['dob']);
        if($data['dob'] > $dt){
            return back()->with(['ageError'=>'Age number must greater than 18']);
        }

        if ($request->hasFile('resume')) {
            $oldLogo = seeker::select('resume')->where('email', Auth::user()->email)->first()->toArray();
            $oldLogo = $oldLogo['resume'];

            if ($oldLogo != null) {
                Storage::delete('public/seeker/'.$oldLogo);
            }

            $fileName = uniqid() . $request->file('resume')->getClientOriginalName();
            $request->file('resume')->storeAs('public/seeker', $fileName);
            $data['resume'] = $fileName;
        }

        if ($request->hasFile('profileImage')) {
            $oldLogo = seeker::select('profile_image')->where('email', Auth::user()->email)->first()->toArray();
            $oldLogo = $oldLogo['profile_image'];

            if ($oldLogo != null) {
                Storage::delete('public/seeker/'.$oldLogo);
            }

            $fileName = uniqid() . $request->file('profileImage')->getClientOriginalName();
            $request->file('profileImage')->storeAs('public/seeker', $fileName);
            $data['profile_image'] = $fileName;
        }
        $data['updated_at'] = Carbon::now();
        // dd($data);
        seeker::where('email', $request->oldEmail)->update($data);
        // return redirect()->route('seeker#profileupdate')->with(['updateSuccess' => 'Data Updated Successfully']);
        return back()->with(['updateSuccess' => 'Your data is successfully updated.']);
    }

    //direct to EducationalQulification

    public function addNewEducation(){
       
        return view('seeker.account.addneweducation');
    }

    public function addNewEQ(Request $req){
        // dd($req->all());
        //check validation
        $this->EQValidationCheck($req);
        //accept input
        $data = $this->requestEQData($req);
        //create EducationalQualification
        $data['created_at'] = Carbon::now();
        EducationalQualification::create($data);
        //return EQlist page
        
        return redirect()->route('seeker#profileupdate')->with(['EQAddedSuccess' => 'Educational qualification is successfully added.']);
    }

    public function deleteEQ($id){
        EducationalQualification::where('id',$id)->delete();
        return redirect()->route('seeker#profileupdate')->with(['deleteSuccess' => 'Educational qualification is successfully deleted.']);
    }

    public function editEQ($id){
        $educations = EducationalQualification::where('id',$id)->first();
       
        return view('seeker.account.editEducation',compact('educations'));

    }

    public function updateEQ(Request $request){
        // dd($request->all());
        $this->EQvalidationCheck($request);
        $data = $this->requestEQData($request);
        $data['updated_at'] = Carbon::now();
        EducationalQualification::where('id', $request->EQId)->update($data);
        return redirect()->route('seeker#profileupdate')->with(['updateSuccess' => 'Educational qualification is successfully updated.']);
    }


    //direct to EmploymentHistory Page

    public function addNewEmploymentHistory(){
        
        return view('seeker.account.addNewEmploymentHistory');
    }

    public function addNewEmployment(Request $req){
        //  dd($req->all());
        //check validation
        $this->EmploymentValidationCheck($req);
        //accept input
        $data = $this->requestEmploymentData($req);
        //create EmploymentHistory
        $data['created_at'] = Carbon::now();
        EmploymentHistory::create($data);
        //return Employmentlist page
        return redirect()->route('seeker#profileupdate')->with(['EmploymentAddedSuccess' => 'Employment history is successfully added.']);
    }

    public function deleteEmployment($id){
        EmploymentHistory::where('id',$id)->delete();
        return redirect()->route('seeker#profileupdate')->with(['deleteSuccess' => 'Employment history is successfully deleted.']);
    }

    public function editEmployment($id){
        $employments = EmploymentHistory::where('id',$id)->first();
        $now = Carbon::today()->format('Y-m-d');
        
        return view('seeker.account.editEmployment',compact('employments'));
    }

    public function updateEmployment(Request $request){
        // dd($request->all());
        $this->EmploymentValidationCheck($request);
        $data = $this->requestEmploymentData($request);
        $data['updated_at'] = Carbon::now();
        EmploymentHistory::where('id', $request->EmploymentId)->update($data);
        return redirect()->route('seeker#profileupdate')->with(['updateSuccess' => 'Employment history is successfully updated.']);
    }

    //direct to addNewSkillPage
    public function addNewSkillPage(){
       
        return view('seeker.account.addNewSkill');
    }

    public function addNewSkill(Request $req){
        // dd($req->all());
        //check validation
        $this->SkillValidationCheck($req);
        //accept input
        $data = $this->requestSkillData($req);
        //create SkillandLanguage
        $data['created_at'] = Carbon::now();
        SkillandLanguage::create($data);
        //return EQlist page
        return redirect()->route('seeker#profileupdate')->with(['SkillAddedSuccess' => 'Skill is successfully added.']);
    }

    public function deleteSkill($id){
        SkillandLanguage::where('id',$id)->delete();
        return redirect()->route('seeker#profileupdate')->with(['deleteSuccess' => 'Skill is successfully deleted.']);
    }

    public function editSkill($id){
        $skills = SkillandLanguage::where('id',$id)->first();
       
        return view('seeker.account.editSkill',compact('skills'));
    }

    public function updateSkill(Request $request){
        //  dd($request->all());
        $this->SkillValidationCheck($request);
        $data = $this->requestSkillData($request);
        $data['updated_at'] = Carbon::now();
        SkillandLanguage::where('id', $request->SkillId)->update($data);
        return redirect()->route('seeker#profileupdate')->with(['updateSuccess' => 'Skill is successfully updated.']);
    }

    // all job section
    // all job section
    public function allJob(){
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
        return view('seeker.job.all_job',compact('data','state','category','townshipData','proTitle','salaryRange','category','workType','expLevel'));
    }

    //job by searching
    public function searchJob(Request $request){

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

        return view('seeker.job.all_job',compact('state','townshipData','salaryRange','workType','expLevel','data','proTitle','category'));
    }

    // job by filtering
    public function filterJob(Request $request){
        // dd($request->toArray());
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
        
        return view('seeker.job.all_job',compact('data','state','townshipData','proTitle','salaryRange','category','workType','expLevel'));
    }

    // direct to change pass page
    public function changepasspage(){
       
        return view('seeker.account.changePass');
    }

    // change password
    public function change(Request $request){
        // validation check
        $this->validationCheckPass($request);
        $currentPassword = User::select('password')->where('id',Auth::user()->id)->first();
        $dbpass = $currentPassword->password; // db hash value

        // update password
        if(Hash::check($request->oldPassword,$dbpass)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Auth::logout();
            return redirect()->route('auth#loginPage')->with(['updatePassword'=>'Password Changed Successfully']);
        }else{
            return back()->with(['passError'=>' Old and New Passwords must be same ']);
        }
    }

    // direct to resume page
    public function resume(){
        $data = Seeker::select('seekers.*')
        ->leftJoin('users','users.email','seekers.email')
        ->where('users.id',Auth::user()->id)
        ->get();
        // dd($data->toArray());

       
        return view('seeker.main.resume',compact('data'));
    }

     //PorfileData validation check
     private function profileDataValidationCheck($req)
     {
         Validator::make($req->all(), [
            'proTitle' => 'required',
            'phone' => 'required',
            'DOB' => 'required',
            'address' => 'required',
            // 'martialStatus' => 'required',
            'gender' => 'required',
            // 'nrc' => 'required',
            'state' => 'required',
            'city' => 'required',
            'resume' => 'mimes:pdf',
            'profileImage' => 'mimes:jpg,jpeg,png,webp,jfif,tiff',
         ])->validate();
     }

     //accept Profile input
     private function requestProfileData($req)
     {
         return [
            'professional_title_id' => $req->proTitle,
            'phone' => $req->phone,
            'dob' => $req->DOB,
            'address' => $req->address,
            'martial_status' => $req->martialStatus,
            'gender' => $req->gender,
            'city_id' => $req->city
         ];
     }


     //Educational_Qualification Validation
     private function EQValidationCheck($req){
        Validator::make($req->all(),[
            'degreeLevel' => 'required',
            'areaOfStudies' => 'required',
            'institute' => 'required',
            'passingYear' => 'required|min:4|max:4',
            'seekerId' => 'required'
        ])->validate();
    }

    //accept EQ input
    private function requestEQData($req){
        return [
            'degree_level' => $req->degreeLevel,
            'area_of_studies' => $req->areaOfStudies,
            'institute_name' => $req->institute,
            'passing_year' => $req->passingYear,
            'seeker_id' => $req->seekerId
        ];
    }

    private function EmploymentValidationCheck($req){
        Validator::make($req->all(),[
            'companyName' => 'required',
            'departmentName' => 'required',
            'position' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'seekerId' => 'required'
        ])->validate();
    }

    private function requestEmploymentData($req){
        return [
            'company_name' => $req->companyName,
            'Department' => $req->departmentName,
            'Position' => $req->position,
            'Start_Date' => $req->startDate,
            'End_Date' => $req->endDate,
            'seeker_id' => $req->seekerId
        ];
    }
    private function SkillValidationCheck($req){
        Validator::make($req->all(),[
            'skillName' => 'required',
            'skillLevel' => 'required',
            'seekerId' => 'required'
        ])->validate();
    }

    private function requestSkillData($req){
        return [
            'skill_name' => $req->skillName,
            'skill_level' => $req->skillLevel,
            'seeker_id' => $req->seekerId,
            
        ];
    }

    // validation for password change page
    private function validationCheckPass($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:8|max:10',
            'newPassword' => 'required|min:8|max:10',
            'confirmPassword' => 'required|min:8|same:newPassword|max:10'
        ],[

        ])->validate();
    }

    private function deactivateAccValidationCheck($req)
    {

        Validator::make($req->all(), [
            'password' => 'required',
        ])->validate();
    }
}

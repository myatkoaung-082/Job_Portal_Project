<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\blog;
use App\Models\User;
use App\Models\state;
use App\Models\seeker;
use App\Models\Category;
use App\Models\employer;
use App\Models\industry;
use App\Models\township;
use App\Models\WorkType;
use App\Models\SalaryRange;
use Illuminate\Http\Request;
use App\Models\ExperienceLevel;
use App\Models\companyIndustries;
use App\Models\professional_title;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    // direct to guest page
    public function guestHome(){
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
                ->paginate(8);

        return view('guest.home',compact('activeJobs','companies','seekers','companyLogos','latestJobs'));
    }

    // direct to company detail view without industry
    public function companydetailWithout($companyId){
        $now = Carbon::today()->format('Y-m-d');
        $companyData = User::select('users.name','users.created_at as userCreateAt','employers.*','townships.township_name','states.state_name')
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

       
     
        return view('guest.companydetail',compact('companyData','companyIndustry','companyJob','userCreateAt'));
    }

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
        return view('guest.all_job',compact('data','state','category','townshipData','proTitle','salaryRange','category','workType','expLevel'));
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
        return view('guest.viewcompany',compact('data','industry','userIndustry'));
    }

    // direct to news page
    public function newsPage(){
        $data = blog::when(request('key1'),function($query){
            $key1 = request('key1');
            $query->orWhere('title','like','%'.$key1.'%')
                  ->orWhere('description','like','%'.$key1.'%');
        })->orderBy('created_at','desc')->paginate(4);

       
        return view('guest.news',compact('data'));
    }

    // direct to seeker about page
    public function aboutseeker(){
        return view('guest.about');
    }

    //direct to job detail
    public function detail($jobId,$companyId){
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

        return view('guest.job_detail',compact('Job','moreJobs'));
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

        return view('guest.all_job',compact('state','townshipData','salaryRange','workType','expLevel','data','proTitle','category'));
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
        
        return view('guest.all_job',compact('data','state','townshipData','proTitle','salaryRange','category','workType','expLevel'));
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

        return view('guest.viewcompany',compact('data','industry','userIndustry'));

    }

    // direct to company detail view with industry
    public function companydetail($companyId, $userIndustry){
        $now = Carbon::today()->format('Y-m-d');
        $companyData = User::select('users.name','users.created_at as userCreateAt','employers.*','townships.township_name','states.state_name')
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

       
     
        return view('guest.companydetail',compact('companyData','companyIndustry','companyJob','userCreateAt'));
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

       
        return view('guest.newsdetail',compact('data'));
    }
    
    // direct to guide page
    public function guide(){
        return view('guest.guide');
    }
}

<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Job;
use App\Models\User;
use App\Mail\OtpMail;
use App\Models\industry;
use App\Models\JobApply;
use App\Models\Interview;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    // direct to dashboard page
    public function dashboard(){
        $employer = User::where('role','employer')->get();
        $seeker = User::where('role','seeker')->get();
        $applyList = JobApply::get();
        $transaction = TransactionHistory::get();
        return view('admin.main.dashboard',compact('employer','seeker','applyList','transaction'));
    }

    // direct to admin page
    public function info(){
        return view('admin.account.info');
    }

    // direct to update page
    public function updatePage($id){
        $data = User::where('id',$id)->first();
        return view('admin.account.editpage',compact('data'));
    }

    // update admin data
    public function update($id,Request $req){
        $this->validationCheck($req);
        $data = $this->getData($req);
        
        
        if($req->hasFile('image')){
            $oldimg = User::where('id',$id)->first();
            $oldimg = $oldimg->image;

            if($oldimg != null){
                Storage::delete('public/'.$oldimg);
            }

            $newimg = uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public',$newimg);
            $data['image'] = $newimg;

        }
        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'update successfully']);
    }

    // change password page
    public function changePassword(){
        return view('admin.account.changePass');
    }

    // change password
    public function change(Request $req){
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

    // change password with Otp
    public function changeOtp(Request $req){
        // validation check
        $this->validationOptPass($req);

        // update password
        User::where('email',$req->email)->update([
            'password' => Hash::make($req->newPassword)
        ]);
        Auth::logout();
        return redirect()->route('auth#loginPage')->with(['updatePassword'=>'Password Changed Successfully']);
    }

    // direct to forgot Password Page
    public function forgot(){
        return view('admin.account.forgotPass');
    }

    // send otp function
    public function sendOtp(Request $req){
        $otp_token = rand(10,100..'2024');
        $get_otp = new VerifyToken();
        $get_otp->token = $otp_token;
        $get_otp->email = $req->email;
        $get_otp->save();

        $get_user_email = $req->email;
        Mail::to($req->email)->send(new OtpMail($get_user_email,$otp_token));

        return view('admin.account.verifyotp',['email'=>$get_user_email]);
    }

    // otp page
    public function OtpPage(){
        return view('admin.account.verifyotp');
    }

    // check otp 
    public function verify(Request $req){
        $email = $req->email;
        $data = VerifyToken::where('token',$req->number)->first();
        if($data){
            $data->is_activated = 1;
            $data->save();
            $user = User::where('email',$data->email)->first();
            $getting_token = Verifytoken::where('token',$data->token)->first();
            $getting_token->delete();
            return view('admin.account.changePassOtp',['data'=>$req->email]);
        }else{
            return redirect()->route('admin#otppage')->with(['incorrect'=>'invalid code']);
        }
    }

    // change password with Otp
    public function changePassOtp(){
        return view('admin.account.changePassOtp',['email'=>$email]);
    }

    // direct to employer data list
    public function emplist(){
        $data = User::select('users.*','employers.logo','employers.website','employers.company_phone','employers.number_of_employees','employers.address','employers.company_description','employers.founder_name','employers.founded_date','employers.city_id','company_industries.company_id','company_industries.industry_id','industries.industry_name')
        ->when(request('industry'),function($query){
            $query->where('industries.id',request('industry'));
        })
            ->where('users.role','employer')
            ->leftJoin('employers','employers.email','users.email')
            ->leftJoin('company_industries','company_industries.company_id','users.id')
            ->leftJoin('industries','industries.id','company_industries.industry_id')
            ->orderBy('users.created_at','desc')
            ->paginate(5);
            // dd($data);

        $industry = industry::get();
        $industryData = industry::where('id',request('industry'))->first();
        $emptotal = User::where('role','employer')->get();
        return view('admin.employerData.list',compact('data','industry','industryData','emptotal'));
    }

    // direct to employer view page
    public function viewemp($id){
        $data = User::select('users.*','employers.logo','employers.website','employers.company_phone','employers.number_of_employees','employers.address','employers.company_description','employers.founder_name','employers.founded_date','employers.city_id','townships.township_name','states.state_name')
        ->leftJoin('employers','employers.email','users.email')
        ->leftJoin('townships','townships.id','employers.city_id')
        ->leftJoin('states','states.id','townships.state_id')
        ->where('users.id',$id)
        ->get();
        // dd($data);
        return view('admin.employerData.view',compact('data'));
    }

    // direct to employee page
    public function employeelist(){
        $data = User::select('users.*','seekers.phone')
        ->when(request('searchKey'),function($query){
            $query->where('users.name','like','%'.request('searchKey').'%');
        })
            ->where('users.role','seeker')
            ->leftJoin('seekers','seekers.email','users.email')
            ->orderBy('users.created_at','desc')
            ->paginate(5);
            // dd($data->toArray());
        return view('admin.employeeData.list',compact('data'));
    }

    // direct to employee view page
    public function viewemployee($id){
        $data = User::select(
            'users.*',
            'seekers.phone',
            'seekers.profile_image',
            'seekers.gender','seekers.address',
            'seekers.martial_status',
            'seekers.professional_title_id',
            'seekers.dob','seekers.nrc',
            'seekers.resume',
            'seekers.city_id',
            'professional_titles.professional_title_name',
            'townships.township_name',
            'states.state_name'
            )
        ->leftJoin('seekers','seekers.email','users.email')
        ->leftJoin('townships','townships.id','seekers.city_id')
        ->leftJoin('states','states.id','townships.state_id')
        ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
        ->where('users.id',$id)
        ->get();
        // dd($data);
        return view('admin.employeeData.view',compact('data'));
    }

    // direct to applylist
    public function applyList(){
        $data = JobApply::get();

        $data = JobApply::select('users.name','professional_titles.professional_title_name','company_industries.company_id','job_applies.status','job_applies.apply_date')
        ->when(request('searchKey'),function($query){
            $query->where('users.name','like','%'.request('searchKey').'%');
        })
            ->leftJoin('users','users.id','job_applies.seeker_id')
            ->leftJoin('jobs','jobs.id','job_applies.job_id')
            ->leftJoin('company_industries','company_industries.id','jobs.company_industry_id')
            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
            ->orderBy('users.created_at','desc')
            ->paginate(7);
            // dd($data);

        $data1 = User::where('role','employer')->get();
        return view('admin.main.applylist',compact('data','data1'));
    }

    // job
    // all job
    public function allJob(){
        $data =
            JobApply::select(DB::raw('COUNT(job_applies.id) as total_job'),'users.name as companyName','jobs.id as jobId','jobs.apply_expire_date','jobs.created_at','industries.industry_name','professional_titles.professional_title_name')
                ->rightJoin('jobs','jobs.id','job_applies.job_id')
                ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
                ->leftJoin('users','users.id','company_industries.company_id')
                ->leftJoin('industries','industries.id','company_industries.industry_id')
                ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                ->groupBy('jobs.id')
                ->orderBy('jobs.created_at','desc')
                ->paginate(5);
            // dd($data->toArray());
        return view('admin.job_list.job', compact('data'));
    }

    //detail job
    public function detailsJob($jobId){
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

        return view('admin.job_list.jod_details', compact('Job'));
    }

    //job delete
    public function jobDelete($jobId){
        try {
            Interview::leftJoin('job_applies','job_applies.id','interviews.job_apply_id')
                    ->where('job_applies.job_id',$jobId)->delete();
            JobApply::where('job_id', $jobId)->delete();
            Job::where('id', $jobId)->delete();
            return back()->with('success', 'Job deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete Job.');
        }
    }

    // job searching
    public function searchJob(Request $request){
        $data =
            JobApply::select(DB::raw('COUNT(job_applies.id) as total_job'),'users.name as companyName','jobs.id as jobId','jobs.apply_expire_date','jobs.created_at','industries.industry_name','professional_titles.professional_title_name')
                ->rightJoin('jobs','jobs.id','job_applies.job_id')
                ->leftJoin('company_industries','jobs.company_industry_id','company_industries.id')
                ->leftJoin('users','users.id','company_industries.company_id')
                ->leftJoin('industries','industries.id','company_industries.industry_id')
                ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
                ->groupBy('jobs.id');


        if($request->orderBy != null){
            if($request->searchKey != null){
                $data->when(request('searchKey'),function($query){
                    $searchKey = request('searchKey');
                    $query->where('users.name','like','%'.$searchKey.'%');
                });
            }
            if($request->orderBy == 'asc'){
                $data->when(request('orderBy'),function($query){
                    $orderBy = request('orderBy');
                    $query->orderBy('created_at','asc');
                });
            }
            else {
                $data->when(request('orderBy'),function($query){
                    $orderBy = request('orderBy');
                    $query->orderBy('created_at','desc');
                });
            }
        }
        elseif ($request->searchKey != null) {
            $data->when(request('searchKey'),function($query){
                $searchKey = request('searchKey');
                $query->where('users.name','like','%'.$searchKey.'%');
            });
        }

        $data = $data->paginate(5);
        return view('admin.job_list.job', compact('data'));
    }
    
    // accepts user input
    private function getData($req){
        return [
            'name'=>$req->name,
            'email'=>$req->email,
            'phone'=>$req->phone
        ];
    }

    // validation check
    private function validationCheck($req){
        Validator::make($req->all(),[
            'name' => 'required|min:5',
            'email' => 'required|min:10',
            'phone' => 'required|max:12',
            'image' => 'mimes:jpg,jpeg,png,webp,jfif'
        ])->validate();
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

    // password otp validation check
    private function validationOptPass($req){
        Validator::make($req->all(),[
            'newPassword' => 'required|min:8|max:10',
            'confirmPassword' => 'required|min:8|same:newPassword|max:10'
        ])->validate();
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    
    //direct to chart data
    public function chartData(){
        return view('admin.main.chart');
    }

    //direct to age pie
    public function ageDataPie(){
        $data1 = DB::table('users')
        ->where('role','seeker')
        ->select('seekers.gender',DB::raw('count(users.id) as total'))
        ->leftJoin('seekers','seekers.email','users.email')
        ->groupBy('seekers.gender')
        ->get();

        // dd($data->toArray());
        $data = [];
        foreach ($data1 as $d) {
            $data[] = [$d->gender, (int)$d->total];
        }
        return response()->json($data);
    }

    public function seekersData(){
        $data1 = DB::table('users')
        ->where('role','seeker')
        ->select('professional_titles.professional_title_name',DB::raw('count(users.id) as total'))
        ->leftJoin('seekers','seekers.email','users.email')
        ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
        ->groupBy('professional_titles.professional_title_name')
        ->get();

        // $data = [];
        // foreach ($data1 as $d) {
        //     $data[] = [$d->professional_title_name, (int)$d->total];
        // }
        return response()->json($data1);
    }

    public function seekerSearch(Request $req){
        // dd($req->all());
        $start_date = $req->startdate;
        $end_date = $req->enddate;
        $sd = Carbon::parse($req->startdate)->format('Y-m-d');
        $ed = Carbon::parse($req->enddate)->format('Y-m-d');
        if($ed<$sd){
            return back()->with(['dateError'=>'End date must be greater than Start date']);
        }
        $category = $req->category;
        $data1 = DB::table('users')
            ->where('role','seeker')
            ->select('professional_titles.professional_title_name',DB::raw('count(users.id) as total'))
            ->leftJoin('seekers','seekers.email','users.email')
            ->leftJoin('professional_titles','professional_titles.id','seekers.professional_title_id')
            ->whereBetween('seekers.created_at', [$start_date,$end_date])
            ->groupBy('professional_titles.professional_title_name');
            if(isset($category)){
                $data1 = $data1->leftJoin('categories','categories.id','professional_titles.category_id')
                               ->where('categories.id',$category)->get();
            }else{
                $data1 = $data1->get();
            }
        // dd($data1);
        $data = [];
        foreach ($data1 as $d) {
            $data[] = [$d->professional_title_name, (int)$d->total];
        }
        $categoryData = Category::get();
        $category_name = Category::select('categories.name')->where('id',$category)->first();
        // dd($category_name);
        return view('admin.chart.protitle',compact('data','start_date','end_date','categoryData','category_name'));
        // return redirect()->route('admin#prochart',compact('data','start_date','end_date','categoryData','category_name'));
    }

    public function industrySearch(Request $req){
        // dd($req->all());
        $start_date = $req->startdate;
        $end_date = $req->enddate;
        $sd = Carbon::parse($req->startdate)->format('Y-m-d');
        $ed = Carbon::parse($req->enddate)->format('Y-m-d');
        if($ed<$sd){
            return back()->with(['dateError'=>'End date must be greater than Start date']);
        }
        $data1 = DB::table('users')
            ->where('role','employer')
            ->select('industries.industry_name',DB::raw('count(users.id) as total'))
            ->leftJoin('employers','employers.email','users.email')
            ->leftJoin('company_industries','company_industries.company_id','users.id')
            ->leftJoin('industries','industries.id','company_industries.industry_id')
            ->whereBetween('company_industries.created_at', [$start_date,$end_date])
            ->groupBy('industries.industry_name')
            ->get();
        // dd($data1); 
        $data = [];
        foreach ($data1 as $d) {
            $data[] = [$d->industry_name, (int)$d->total];
        }
        return view('admin.chart.industry',compact('data','start_date','end_date'));
    }

    public function jobpostSearch(Request $req){
        // dd($req->all());
        $start_date = $req->startdate;
        $end_date = $req->enddate;
        $sd = Carbon::parse($req->startdate)->format('Y-m-d');
        $ed = Carbon::parse($req->enddate)->format('Y-m-d');
        if($ed<$sd){
            return back()->with(['dateError'=>'End date must be greater than Start date']);
        }
        $data1 = DB::table('users')
            ->where('role','employer')
            ->select('users.name',DB::raw('count(jobs.id) as total'))
            ->leftJoin('company_industries','company_industries.company_id','users.id')
            ->leftJoin('jobs','jobs.company_industry_id','company_industries.id')
            ->whereBetween('jobs.created_at', [$start_date,$end_date])
            ->groupBy('users.name')
            ->get();
        // dd($data1); 
        $data = [];
        foreach ($data1 as $d) {
            $data[] = [$d->name, (int)$d->total];
        }
        return view('admin.chart.jobpost',compact('data','start_date','end_date'));
    }

    public function purchaseSearch(Request $request){
        $users = User::select(
            DB::raw('MONTH(transaction_histories.purchase_date) as month'),
            DB::raw('COUNT(users.id) as count')
        )
        ->leftJoin('transaction_histories','transaction_histories.company_id','users.id')
        ->where('users.role','employer')
        ->whereYear('transaction_histories.purchase_date', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $months = [];
        $counts = [];

        foreach ($users as $user) {
            $months[] = Carbon::createFromDate(null, $user->month)->format('F');
            $counts[] = $user->count * 500000;
        }

        $data = [
            'months' => $months,
            'counts' => $counts,
        ];

        return response()->json($data);
    }

    public function popularSearch(Request $req){
        $start_date = $req->startdate;
        $end_date = $req->enddate;
        $category = $req->category;
        $sd = Carbon::parse($req->startdate)->format('Y-m-d');
        $ed = Carbon::parse($req->enddate)->format('Y-m-d');
        if($ed<$sd){
            return back()->with(['dateError'=>'End date must be greater than Start date']);
        }
        $data1 = Job::select('professional_titles.professional_title_name',DB::raw('COUNT(jobs.id) as job_total'))
            ->leftJoin('professional_titles','professional_titles.id','jobs.professional_title_id')
            ->whereBetween('jobs.created_at', [$start_date,$end_date])
            ->groupBy('jobs.professional_title_id');

            if(isset($category)){
                $data1 = $data1->leftJoin('categories','categories.id','professional_titles.category_id')
                               ->where('categories.id',$category)->get(); 
            }else{
                $data1 = $data1->get();
            }
        // dd($data1->toArray()); 
        $data = [];
        foreach ($data1 as $d) {
            $data[] = [$d->professional_title_name, (int)$d->job_total];
        }
        $categoryData = Category::get();
        $category_name = Category::select('categories.name')->where('id',$category)->first();
        return view('admin.chart.popularjob',compact('data','start_date','end_date','categoryData','category_name'));
    }

    public function employers(){
        $users = User::select(
            DB::raw('MONTH(employers.created_at) as month'),
            DB::raw('COUNT(users.id) as count')
        )
        ->leftJoin('employers','employers.email','users.email')
        ->where('users.role','employer')
        ->whereYear('employers.created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $months = [];
        $counts = [];

        foreach ($users as $user) {
            $months[] = Carbon::createFromDate(null, $user->month)->format('F');
            $counts[] = $user->count;
        }

        $data = [
            'months' => $months,
            'counts' => $counts,
        ];

        return response()->json($data);
    }

    public function seekers(){
        $users = User::select(
            DB::raw('MONTH(seekers.created_at) as month'),
            DB::raw('COUNT(users.id) as count')
        )
        ->leftJoin('seekers','seekers.email','users.email')
        ->where('users.role','seeker')
        ->whereYear('seekers.created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $months = [];
        $counts = [];

        foreach ($users as $user) {
            $months[] = Carbon::createFromDate(null, $user->month)->format('F');
            $counts[] = $user->count;
        }

        $data = [
            'months' => $months,
            'counts' => $counts,
        ];

        return response()->json($data);
    }

    // start charts
    public function prochart(){
        $data = [];
        $start_date = '';
        $end_date = '';
        $categoryData = Category::get();
        $category_name = '';
        return view('admin.chart.protitle',compact('data','start_date','end_date','categoryData','category_name'));
    }

    public function industrychart(){
        $data = [];
        $start_date = '';
        $end_date = '';
        return view('admin.chart.industry',compact('data','start_date','end_date'));
    }

    public function jobpostchart(){
        $data = [];
        $start_date = '';
        $end_date = '';
        return view('admin.chart.jobpost',compact('data','start_date','end_date'));
    }

    public function gender(){
        return view('admin.chart.gender');
    }

    public function purchase(){
        return view('admin.chart.purchase');
    }

    public function popularjob(){
        $data = [];
        $start_date = '';
        $end_date = '';
        $categoryData = Category::get();
        $category_name = '';
        return view('admin.chart.popularjob',compact('data','start_date','end_date','categoryData','category_name'));
    }
    // end charts
}

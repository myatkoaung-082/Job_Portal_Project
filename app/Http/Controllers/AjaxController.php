<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Mail\payslip;
use App\Models\Category;
use App\Models\JobApply;
use App\Models\Purchase;
use App\Models\township;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\professional_title;
use Illuminate\Support\Facades\Mail;


class AjaxController extends Controller
{
    // status data
    public function statusdata(Request $request){
        // logger($request->all());
        Purchase::where('id',$request->purchase_id)->update([
            'status_level'=>$request->status
        ]);

        $currentDate = Carbon::now();
        Purchase::where('id', $request->purchase_id)->update([
            'purchase_date' => Carbon::now(),
            'expire_date' => $currentDate->addDay(30)
        ]);

        // $email = User::select('users.email')
        // ->where('purchases.company_id',$request->company_id)
        // ->leftjoin('purchases','users.id','purchases.company_id')->first();
        // logger($email);

        $companyPurchase = Purchase::select('purchases.expire_date', 'users.name as companyName', 'users.email')
            ->leftJoin('users','users.id','purchases.company_id')
            ->where('purchases.company_id', $request->company_id)
            ->first();
        if($companyPurchase){
            $companyEmail = $companyPurchase->email;
            $companyName = $companyPurchase->companyName;
            $expireDate = $companyPurchase->expire_date;
            logger($companyPurchase);
        }else{
            logger('error');
        }

        if($request->status == 1){
            // $get_user_email = $email->email;
            Mail::to($companyEmail)->send(new payslip($companyEmail,$companyName,$expireDate));
        }

    }
    

    // selected pay
    public function selectedPay(Request $request){
        // logger($request->all());
    }

    // fetch category data to create page
    public function categorydata(Request $request){
        
        $pfdata = professional_title::select('professional_titles.professional_title_name as profession_name','professional_titles.id as profession')
        ->where('professional_titles.category_id',$request->status)
        ->leftJoin('categories','professional_titles.category_id','categories.id')
        ->get();
       
        // logger($pfdata);
        return response()->json($pfdata, 200);
        
    }

    // fetch state data to update company profile
    public function stateData(Request $request){
        
        // logger($request->all());
        $stateData = township::select('townships.township_name','townships.id as townshipId')
            ->leftJoin('states','states.id','townships.state_id')
            ->where('townships.state_id',$request->status)
            ->get();
        
        return response()->json($stateData, 200);          
    }

    //fetch township data
    public function townshipData(Request $request){
        $townshipData = township::select('townships.township_name','townships.id as township_id')
            ->leftJoin('states','states.id','townships.state_id')
            ->where('townships.state_id',$request->status)
            ->get();
        // logger($townshipData);
        return response()->json($townshipData, 200);
    }

    //view count for jobs
    public function viewCount(Request $request){
        // logger($request);
        $data = Job::where('id',$request->jobId)->first();
        // logger($data);
        $count = [
            'view_count' => $data->view_count + 1
        ];
        // logger($count);
        Job::where('id',$request->jobId)->update($count);

    }

    // company
    // job apply status change
    public function statusChange(Request $request){
        JobApply::where('id', $request->jobApplyId)->update([
            'status' => $request->status
        ]);

        $interview = Interview::where('job_apply_id', $request->jobApplyId)->get();

        // if job apply id does not exist
        if(count($interview) == null){
            if($request->status == 1){
                Interview::create([
                    'job_apply_id' => $request->jobApplyId
                ]);
                return response()->json([
                    'message' => 'Successfully added to interview list'
                ]);
            }
            else{
                return response()->json([
                    'message' => 'Job application status updated successfully'
                ]);
            }
        }
        elseif ($request->status == 0 | $request->status == 2) {
            Interview::where('job_apply_id',  $request->jobApplyId)->delete();
            return response()->json([
                'message' => 'Successfully removed from interview list'
            ]);
        }
    }
}

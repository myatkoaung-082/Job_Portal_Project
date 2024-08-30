<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\payslip;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{
    //
    public function list(){
        $data = Purchase::when(request('searchKey'),function($query){
            $query->where('order_code','like','%'.request('searchKey').'%');
        })
        ->select('purchases.*','plans.plan_name','purchases.status_level','users.name')
        ->leftJoin('plans','purchases.plan_id','plans.id')
        ->leftJOin('users','users.id','purchases.company_id')
        ->orderBy('purchases.created_at','desc')
        ->paginate(7);

        // dd($data->toArray());

        return view('admin.plan.transaction_list',compact('data'));
    }
}

<?php

namespace App\Models;

use Storage;
use Carbon\Carbon;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['company_id','plan_id','order_code','account_name','account_phone','purchase_date','expire_date','transaction_slip'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }

    public function extendSubscription($data){
        //insert old record to transaction history
        // dd($data);
        // $this->saveToHistory();
        

        //insert new record
        $now = Carbon::now();
        $endDate = Carbon::parse($this->expire_date);

        if ($endDate->greaterThan($now)) {
            $this->expire_date = $endDate->addMonth()->format('Y-m-d');
        } else {
            $this->purchase_date = $now->format('Y-m-d');
            $this->expire_date = $now->copy()->addMonth()->format('Y-m-d');
        }

        $this->account_name = $data['accountName'];
        $this->account_phone = $data['accountPhone'];
        $orderCode = mt_rand(0,99999);
        $orderCode = 'NEXT'.$orderCode;
        $this->order_code = $orderCode;

        //for image
        if($data['transactionSlip']){
            $dbImage = Purchase::where('company_id',$data['companyId'])->first();
            $dbImage = $dbImage->transaction_slip;
            if($dbImage != null){
                Storage::delete('public/storage/transactionSlip'.$dbImage);
            }
            $fileName = uniqid().$data['transactionSlip']->getClientOriginalName();
            $data['transactionSlip']->storeAs('public/transactionSlip',$fileName);
            $this->transaction_slip = $fileName;
        }

        $this->save();

        DB::table('transaction_histories')->insert([
            'company_id' => $this->company_id,
            'plan_id' => $this->plan_id,
            'order_code' => $this->order_code,
            'account_name' => $this->account_name,
            'account_phone' => $this->account_phone,
            'purchase_date' => $this->purchase_date,
            'expire_date' => $this->expire_date,
            'transaction_slip' => $this->transaction_slip,
        ]);

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = ['company_id','plan_id','order_code','account_name','account_phone','purchase_date','expire_date','transaction_slip'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    //
    public function transactionDelete($id){

        try {
            TransactionHistory::where('id',$id)->delete();
            return redirect()->route('employer#transactionPage')->with(['deleteSuccess' => 'Transaction history deleted successfully']);
        } catch (\Exception $e) {
            return redirect()->route('employer#transactionPage')->with(['error' => 'Failed to delete transaction history.']);
        }
    }

    public function transactionDetails($id){
        $data = TransactionHistory::where('id',$id)->first();
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.plan.transaction_history_details',compact('data','image'));
    }

    public function adminTransactionDetails($id){
        $data = Purchase::where('id',$id)->first();
        $image = User::where('id',Auth::user()->id)->first();
        return view('admin.plan.transaction_history_details',compact('data','image'));
    }
}

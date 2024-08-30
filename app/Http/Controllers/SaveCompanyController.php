<?php

namespace App\Http\Controllers;

use App\Models\SaveCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaveCompanyController extends Controller
{
    // save company
    public function saveCompany($companyId){
        $saveCompanyCount = SaveCompany::where('seeker_id',Auth::user()->id)
                                        ->where('company_id',$companyId)
                                        ->get();
        if(count($saveCompanyCount) == null){
            $data = $this->getSaveCompany($companyId);
            SaveCompany::create($data);
            return back()->with(['saveSuccess'=>'You have successfully saved this company']);
        } else {
            return back()->with(['saveFail'=>'You have already saved this company']);
        }

    }

    // saved company list
    public function saveCompanyPage(){
        $data = SaveCompany::select('save_companies.*','users.name as companyName','employers.founder_name','employers.logo','townships.township_name','states.state_name')
                            ->leftJoin('users','users.id','save_companies.company_id')
                            ->leftJoin('employers','employers.email','users.email')
                            ->leftJoin('townships','employers.city_id','townships.id')
                            ->leftJoin('states','states.id','townships.state_id')
                            ->where('save_companies.seeker_id', Auth::user()->id)
                            ->get();
        // dd($data->toArray());
        // dd($data->toArray());
        return view('seeker.account.saveCompany',compact('data'));
    }

    // saved company delete
    public function saveCompanyDelete($saveCompanyId){
        SaveCompany::where('id',$saveCompanyId)->delete();
        return back()->with(['deleteSuccess' => 'You have successfully removed this company']);
    }

private function getSaveCompany($companyId){
        return [
            'seeker_id' => Auth::user()->id,
            'company_id' => $companyId,
        ];
    }
}

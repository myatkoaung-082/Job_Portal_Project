<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\employer;
use App\Models\industry;
use Illuminate\Http\Request;
use App\Models\companyIndustries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyIndustriesController extends Controller
{
    public function IndustryPage()
    {
        $industries = industry::select('industries.industry_name','company_industries.id','company_industries.created_at')
                        ->leftJoin('company_industries','company_industries.industry_id','industries.id')
                        ->where('company_industries.company_id',Auth::user()->id)
                        ->get();

                        // dd($industries->all());
        $image = User::where('id',Auth::user()->id)->first();
        return view('employer.account.IndustryPage',compact('industries','image'));
    }

    public function addIndustryPage()
    {
        $industries = industry::get();
        $image = User::where('id',Auth::user()->id)->first();
        
        return view('employer.account.addIndustryPage', compact('industries','image'));
    }

    public function addnewIndustry(Request $req)
    {

        // dd($req->all());
        //check validation
        $this->industryValidationCheck($req);
        //accept input
        $data = $this->requestIndustryData($req);
        //add new industry
        $industry = companyIndustries::where('company_id', Auth::user()->id)
            ->get();

        // dd($industry);

        if ($industry) {

            // dd($industry);
            foreach ($industry as $item) {
                if ($item->company_id == Auth::user()->id && $item->industry_id == $req->industryId) {
                    return redirect()->route('add#newIndustryPage')->with(['duplicateError' => 'The industry you added already exists.']);
                } else {

                }
            }
            $data['created_at'] = Carbon::now();
            companyIndustries::create($data);
                    // return list page
            return redirect()->route('employer#IndustryPage')->with(['addIndustrySuccess' => 'Industry Created Successfully']);
        } else {
           
        }
        
    }

    //industry validation
    private function industryValidationCheck($req)
    {
        Validator::make($req->all(), [
            'companyId' => 'required',
            'industryId' => 'required',
        ])->validate();
    }

    //accept industry input
    private function requestIndustryData($req)
    {
        return [
            'company_id' => $req->companyId,
            'industry_id' => $req->industryId
        ];
    }
}

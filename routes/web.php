<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\JobApplyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\SaveCompanyController;
use App\Http\Controllers\CompanyIndustriesController;
use App\Http\Controllers\ProfessionalTitleController;
use App\Http\Controllers\TransactionHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['admin_auth'])->group(function(){
    Route::redirect('/', 'loginPage');
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
    Route::get('forgortPasswordPage',[AdminController::class,'forgot'])->name('admin#forgortPasswordPage');
    Route::post('sendOtp',[AdminController::class,'sendOtp'])->name('admin#sendOtp');
    Route::get('verifyOtp',[AdminController::class,'OtpPage'])->name('admin#otppage');
    Route::post('verifyOtp',[AdminController::class,'verify'])->name('admin#verifyOtp');
    Route::get('changePassOtp',[AdminController::class,'changePassOtp'])->name('admin#changePassOtpPage');
    Route::post('changePassOtp',[AdminController::class,'changeOtp'])->name('admin#changePassOtp');
});

Route::get('terms',function(){
    return view('user.terms');
})->name('terms&conds');


Route::prefix('guest')->group(function(){
    Route::get('home',[GuestController::class,'guestHome'])->name('guest#home');
    Route::get('companydetail/{companyId}/{userIndustry}',[GuestController::class,'companydetail'])->name('guest#companydetail');
    Route::get('companydetail/{companyId}',[GuestController::class,'companydetailWithout'])->name('guest#companydetail1');
    Route::get('allJob',[GuestController::class,'allJob'])->name('guest#allJob');
    Route::get('viewcompany',[GuestController::class,'viewCompany'])->name('guest#viewcompany');
    Route::get('news',[GuestController::class,'newsPage'])->name('guest#news');
    Route::get('about',[GuestController::class,'aboutseeker'])->name('guest#about');
    Route::get('detail/{jobId}/{companyId}',[GuestController::class,'detail'])->name('guest#detailJob');
    Route::get('searchJob',[GuestController::class,'searchJob'])->name('guest#serachJob');
    Route::get('filterJob',[GuestController::class,'filterJob'])->name('guest#filterJob');
    Route::get('searchCompany',[GuestController::class,'searchCompany'])->name('guest#searchCompany');
    Route::get('news/{id}',[GuestController::class,'newsDetail'])->name('guest#details');
    Route::get('townshipData',[AjaxController::class,'townshipData'])->name('guest#townshipData');
    Route::get('guide',[GuestController::class,'guide'])->name('guest#guide');
});

Route::middleware(['auth'])->group(function(){

    //Dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function(){

        // start admin account section
        Route::prefix('account')->group(function(){
            Route::get('info',[AdminController::class,'info'])->name('admin#info');
            Route::get('updatePage/{id}',[AdminController::class,'updatePage'])->name('admin#updatePage');
            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');
            Route::get('changePassPage',[AdminController::class,'changePassword'])->name('admin#changePasswordPage');
            Route::post('changePass',[AdminController::class,'change'])->name('admin#changePassword');
        });
        // end admin account section

        // start admin blog section
        Route::prefix('blog')->group(function(){
            Route::get('list',[BlogController::class,'listPage'])->name('blog#list');
            Route::post('create',[BlogController::class,'createPost'])->name('blog#create');
            Route::get('delete/{id}',[BlogController::class,'deletePost'])->name('blog#delete');
            Route::get('details/{id}',[BlogController::class,'details'])->name('blog#details');
            Route::post('update/{id}',[BlogController::class,'update'])->name('blog#update');
        });
        // end admin blog section

        // start admin function
        Route::prefix('admin')->group(function(){
            Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin#dashboard');
        });

        // start category section
        Route::prefix('category')->group(function(){
            Route::get('list',[CategoryController::class,'listpage'])->name('admin#categorylist');
            Route::get('createPage',[CategoryController::class,'createPage'])->name('admin#categorycreatepage');
            Route::post('create',[CategoryController::class,'create'])->name('admin#categorycreate');
            Route::get('delete/{id}',[CategoryController::class,'delete'])->name('admin#categorydelete');
            Route::get('editpage/{id}',[CategoryController::class,'editPage'])->name('admin#categoryeditpage');
            Route::post('update',[CategoryController::class,'update'])->name('admin#categoryupdate');
        });
        // end category section

        // start professional section
        Route::prefix('professional')->group(function(){
            Route::get('list',[ProfessionalTitleController::class,'list'])->name('admin#professionlist');
            Route::get('createPage',[ProfessionalTitleController::class,'create'])->name('admin#professioncreate');
            Route::post('create',[ProfessionalTitleController::class,'createfunc'])->name('admin#professioncreatefunc');
            Route::get('delete/{id}',[ProfessionalTitleController::class,'delete'])->name('admin#professiondelete');
            Route::get('editpage/{id}',[ProfessionalTitleController::class,'editpage'])->name('admin#professioneditpage');
            Route::post('edit',[ProfessionalTitleController::class,'edit'])->name('admin#professionedit');
        });
        // end professional section

        // start industry section
        Route::prefix('industry')->group(function(){
            Route::get('list',[IndustryController::class,'list'])->name('admin#industrylist');
            Route::get('createPage',[IndustryController::class,'create'])->name('admin#industrycreatepage');
            Route::post('create',[IndustryController::class,'createfunc'])->name('admin#industrycreate');
            Route::get('editpage/{id}',[IndustryController::class,'editPage'])->name('admin#industryeditpage');
            Route::post('update',[IndustryController::class,'update'])->name('admin#industryupdate');
        });
        // end industry section

        // start employers data section
        Route::prefix('empdata')->group(function(){
            Route::get('list',[AdminController::class,'emplist'])->name('admin#empdatalist');
            Route::get('viewpage/{id}',[AdminController::class,'viewemp'])->name('admin#viewemp');
        });
        // end employers data section

        // start employees data section
        Route::prefix('empsdata')->group(function(){
            Route::get('employeelist',[AdminController::class,'employeelist'])->name('admin#employeelist');
            Route::get('viewpageemployee/{id}',[AdminController::class,'viewemployee'])->name('admin#viewemployee');
        });
        // end employees data section

        //start apply list data section
        Route::prefix('admin')->group(function(){
            Route::get('applylist',[AdminController::class,'applyList'])->name('admin#applyList');
        });
        //end apply list data section

        // transaction list
        Route::prefix('transaction')->group(function(){
            Route::get('list',[PurchaseController::class,'list'])->name('admin#transactionList');
            Route::get('adminTransactionDetails/{id}',[TransactionHistoryController::class,'adminTransactionDetails'])->name('admin#adminTransactionDetails');
        });

        // inbox
        Route::prefix('admin')->group(function(){
            Route::get('inbox',[ContactController::class,'inbox'])->name('admin#inbox');
            Route::get('inbox/delete/{id}',[ContactController::class,'inboxDelete'])->name('admin#inboxDelete');
            Route::get('inbox/view/{id}',[ContactController::class,'inboxView'])->name('admin#inboxView');
            Route::get('inbox1/view1/{id}',[ContactController::class,'inboxView1'])->name('admin#inboxView1');
        });

        // job
        Route::prefix('job')->group(function(){
            Route::get('allJob',[AdminController::class,'allJob'])->name('admin#allJob');
            Route::get('detailsJob/{jobId}',[AdminController::class,'detailsJob'])->name('admin#detailsJob');
            Route::delete('/jobDelete/{jobId}',[AdminController::class,'jobDelete'])->name('admin#jobDelete');
            Route::get('searchJob',[AdminController::class,'searchJob'])->name('admin#searchJob');
        });
        // ajax
        Route::prefix('ajax')->group(function(){
            Route::get('statusdata',[AjaxController::class,'statusdata'])->name('ajax#statusdata');
        });
        // user-data
        Route::prefix('analysis')->group(function(){
            Route::get('chartData',[AnalysisController::class,'chartData'])->name('admin#chartData');
            Route::get('protitleChart',[AnalysisController::class,'prochart'])->name('admin#prochart');
            Route::get('industrydata',[AnalysisController::class,'industrychart'])->name('admin#industrychart');
            Route::get('genderdata',[AnalysisController::class,'gender'])->name('admin#gender');
            Route::get('purchasedata',[AnalysisController::class,'purchase'])->name('admin#purchase');
            Route::get('popularjob',[AnalysisController::class,'popularjob'])->name('admin#popularjob');
            Route::get('jobPost',[AnalysisController::class,'jobpostchart'])->name('admin#jobpostchart');
            Route::get('ageData',[AnalysisController::class,'ageDataPie'])->name('admin#agepie');
            Route::get('seekerdata',[AnalysisController::class,'seekersData'])->name('admin#seekerdata');
            Route::get('empdata',[AnalysisController::class,'employers'])->name('admin#employers');
            Route::get('seeker',[AnalysisController::class,'seekers'])->name('admin#seekers');
            // search seeker
            Route::post('seekerSearch',[AnalysisController::class,'seekerSearch'])->name('admin#seekerSearch');
            // search industry
            Route::post('industrySearch',[AnalysisController::class,'industrySearch'])->name('admin#industrySearch');
            // search job post
            Route::post('jobpostSearch',[AnalysisController::class,'jobpostSearch'])->name('admin#jobpostSearch');
            // purchase search
            Route::get('getData',[AnalysisController::class,'purchaseSearch'])->name('admin#purchaseSearch');
            // popular search
            Route::post('popularJob',[AnalysisController::class,'popularSearch'])->name('admin#popularSearch');
        });

        // chart
        // Route:prefix('charts')->group(function(){
            
        // });
    });

    // seeker
    Route::middleware(['user_auth'])->group(function(){

        // seeker
        Route::prefix('seeker')->group(function(){
            Route::get('home',[SeekerController::class,'home'])->name('seeker#home');
            Route::get('changePassPage',[SeekerController::class,'changepasspage'])->name('seeker#changepasspage');
            Route::post('changePass',[SeekerController::class,'change'])->name('seeker#changePassword');
            Route::get('homesection',[SeekerController::class,'homepage'])->name('seeker#homepage');

            //deactivate account
            Route::delete('/seeker/delete', [SeekerController::class, 'deactivateAcc'])->name('seeker.delete');

            // account verification
            Route::get('verifyAccount',[SeekerController::class,'verifyPage'])->name('seeker#verify');
            Route::post('verityOtp',[SeekerController::class,'verifyOtp'])->name('seeker#verifyOtp');

            // job section
            Route::prefix('job')->group(function(){
                Route::get('allJob',[SeekerController::class,'allJob'])->name('seeker#allJob');
                Route::get('searchJob',[SeekerController::class,'searchJob'])->name('seeker#serachJob');
                Route::get('filterJob',[SeekerController::class,'filterJob'])->name('seeker#filterJob');
                Route::get('detail/{jobId}/{companyId}',[JobController::class,'detail'])->name('seeker#detailJob');
                Route::get('applyJob/{jobId}/{companyId}',[JobApplyController::class,'applyJob'])->name('seeker#applyJob');
                Route::get('applyJobPage',[JobApplyController::class,'applyJobPage'])->name('seeker#applyJobPage');
                Route::delete('applyJobDelete/{jobApplyId}',[JobApplyController::class,'applyJobDelete'])->name('seeker#applyJobDelete');
                Route::get('recommendJobsPage',[JobController::class,'recommendJobs'])->name('seeker#recommendJobsPage');
            });

            // news section
            Route::get('news',[SeekerController::class,'newsPage'])->name('seeker#news');
            Route::get('news/{id}',[SeekerController::class,'newsDetail'])->name('seeker#details');

            //seeker profile
            Route::get('profileupdate',[SeekerController::class,'profileupdate'])->name('seeker#profileupdate');
            Route::post('updateProfile',[SeekerController::class,'updateProfile'])->name('seeker#updateProfile');
            Route::get('viewcompany',[SeekerController::class,'viewCompany'])->name('seeker#viewcompany');
            Route::get('searchCompany',[SeekerController::class,'searchCompany'])->name('seeker#searchCompany');
            Route::get('companydetail/{companyId}/{userIndustry}',[SeekerController::class,'companydetail'])->name('seeker#companydetail');
            Route::get('companydetail/{companyId}',[SeekerController::class,'companydetailWithout'])->name('seeker#companydetail1');

            // favourite company
            Route::get('saveCompany/{companyId}',[SaveCompanyController::class,'saveCompany'])->name('seeker#saveCompany');
            Route::get('saveCompanyPage',[SaveCompanyController::class,'saveCompanyPage'])->name('seeker#saveCompanyPage');
            Route::get('saveCompanyDelete/{saveCompanyId}',[SaveCompanyController::class,'saveCompanyDelete'])->name('seeker#saveCompanyDelete');

            //seeker educationalQulification
            Route::get('addNewEducation',[SeekerController::class,'addNewEducation'])->name('add#newEducation');
            Route::post('addNewEQ',[SeekerController::class,'addNewEQ'])->name('seeker#addNewEducationalQualification');
            Route::get('deleteEducation/{id}',[SeekerController::class,'deleteEQ'])->name('seeker#deleteEducation');
            Route::get('editEducation/{id}',[SeekerController::class,'editEQ'])->name('seeker#editEducation');
            Route::post('updateEducation',[SeekerController::class,'updateEQ'])->name('seeker#updateEducation');

            //seeker employmentHistory
            Route::get('addNewEmploymentHistory',[SeekerController::class,'addNewEmploymentHistory'])->name('add#newEmploymentHistory');
            Route::post('addNewEmployment',[SeekerController::class,'addNewEmployment'])->name('seeker#addNewEmploymentHistory');
            Route::get('deleteEmployment/{id}',[SeekerController::class,'deleteEmployment'])->name('seeker#deleteEmployment');
            Route::get('editEmployment/{id}',[SeekerController::class,'editEmployment'])->name('seeker#editEmployment');
            Route::post('updateEmployment',[SeekerController::class,'updateEmployment'])->name('seeker#updateEmployment');
            
            //seeker skill
            Route::get('addNewSkill',[SeekerController::class,'addNewSkillPage'])->name('add#newSkillPage');
            Route::post('addNewSkill',[SeekerController::class,'addNewSkill'])->name('seeker#addNewSkill');
            Route::get('deleteSkill/{id}',[SeekerController::class,'deleteSkill'])->name('seeker#deleteSkill');
            Route::get('editSkill/{id}',[SeekerController::class,'editSkill'])->name('seeker#editSkill');
            Route::post('updateSkill',[SeekerController::class,'updateSkill'])->name('seeker#updateSkill');


            
            // contact section
            Route::get('contact',[ContactController::class,'contactPage1'])->name('seeker#contact');
            Route::post('contact1',[ContactController::class,'contact1'])->name('seeker#contactfunc');

            // about section
            Route::get('about',[ContactController::class,'aboutseeker'])->name('seeker#about');

            // resume section
            Route::get('resume',[SeekerController::class,'resume'])->name('seeker#resume');
            
            //ajax
            Route::prefix('ajax')->group(function(){
                Route::get('stateData',[AjaxController::class,'stateData'])->name('ajax#stateData');
                Route::get('townshipData',[AjaxController::class,'townshipData'])->name('ajax#townshipData');
                Route::get('viewCount',[AjaxController::class,'viewCount'])->name('ajax#viewCount');
            });

            //available test
            Route::post('available',[SeekerController::class,'available'])->name('seeker#available');
            Route::post('unavailable',[SeekerController::class,'unavailable'])->name('seeker#unavailable');
        });

    });

    // employer
    Route::middleware(['employer_auth'])->group(function(){

        // employer
        Route::prefix('employer')->group(function(){
            Route::get('home',[EmployerController::class,'home'])->name('employer#home');
            
            // account verification
            Route::get('verifyAccount',[EmployerController::class,'verifyPage'])->name('employer#verify');
            Route::post('verityOtp',[EmployerController::class,'verifyOtp'])->name('employer#verifyOtp');

            // account change password page
            Route::get('changepasspage',[EmployerController::class,'changepasspage'])->name('employer#changepasspage');
            Route::post('chagepass',[EmployerController::class,'changepass'])->name('employer#changePassword');

            //deactivate account
            Route::delete('/company/delete', [EmployerController::class, 'deactivateAcc'])->name('companys.delete');

            // news section
            Route::get('news',[EmployerController::class,'newsPage'])->name('employer#news');
            Route::get('news/{id}',[EmployerController::class,'newsDetail'])->name('employer#details');

            // job section
            Route::get('checkUserStatus',[EmployerController::class,'checkUserStatus'])->name('employer#checkUserStatus');
            Route::get('createPage',[EmployerController::class,'createPage'])->name('employer#createPage');
            Route::get('all',[EmployerController::class,'alljob'])->name('employer#alljob');
            // Route::get('jobs',[EmployerController::class,'jobs'])->name('employer#jobs');
            Route::get('editJob/{id}',[EmployerController::class,'editJob'])->name('employer#editJob');
            
            Route::prefix('job')->group(function(){
                Route::post('create',[JobController::class,'create'])->name('employer#createJob');
                Route::post('update',[JobController::class,'update'])->name('employer#updateJob');
                // Route::get('detail/{jobId}/{companyId}',[JobController::class,'detail'])->name('employer#detailJob');
                Route::delete('/delete/{id}', [JobController::class, 'delete'])->name('employer#deleteJob');
                Route::get('jobApply',[JobApplyController::class,'jobApply'])->name('employer#jobApply');
                Route::get('apply/details/{seekerId}',[JobApplyController::class,'applyDetails'])->name('employer#applyDetials');
                Route::get('apply/viewResume/{seekerId}',[JobApplyController::class,'viewResume'])->name('employer#viewResume');
                Route::get('search/applyList',[JobApplyController::class,'searchApplyList'])->name('employer#searchApplyList');

                // single job
                Route::get('jobApplySg/{jobId}',[JobApplyController::class,'jobApplySg'])->name('employer#jobApplySg');
                Route::get('search/applyList/single',[JobApplyController::class,'searchApplyListSg'])->name('employer#searchApplyListSg');

                //interview
                Route::get('interviewList',[InterviewController::class, 'interviewList'])->name('employer#interviewList');
                Route::put('interview/update/{id}',[InterviewController::class,'interviewUpdate'])->name('employer#interviewUpdate');

                // Interview for each job
                Route::get('interview/list/each/{jobId}',[InterviewController::class,'eachInterviewList'])->name('employer#eachInterviewList');
                Route::post('/eachInterviewUpdate/{id}',[InterviewController::class,'eachInterviewUpdate'])->name('employer#eachInterviewUpdate');
            });

            Route::prefix('menu')->group(function(){
                // home
                Route::get('header/home',[EmployerController::class,'headerHome'])->name('employer#headerHome');

                // job
                Route::get('header/allJob',[EmployerController::class,'headerAllJob'])->name('employer#headerAllJob');
                Route::get('header/searchJob',[EmployerController::class,'headerSearchJob'])->name('employer#headerSearchJob');
                Route::get('header/filterJob',[EmployerController::class,'headerFilterJob'])->name('employer#headerFilterJob');
                Route::get('header/detail/{jobId}/{companyId}',[EmployerController::class,'headerDetail'])->name('employer#headerDetail');

                // company
                Route::get('header/view/company',[EmployerController::class,'headerViewCompany'])->name('employer#headerViewCompany');
                Route::get('header/search/company',[EmployerController::class,'headerSearchCompany'])->name('employer#headerSearchCompany');
                Route::get('header/company/detail/{companyId}/{userIndustry}',[EmployerController::class,'headerCompanyDetail'])->name('employer#headerCompanyDetail');
                Route::get('header/company/detail/{companyId}',[EmployerController::class,'headerCompanyDetailWithout'])->name('employer#headerCompanyDetail1');
            });
            

            // company profile
            // Route::get('viewcompany',[EmployerController::class,'viewCompany'])->name('employer#viewcompany');
            Route::get('profileupdate',[EmployerController::class,'profileupdate'])->name('employer#profileupdate');
            // Route::get('companydetail/{id}',[EmployerController::class,'companydetail'])->name('employer#companydetail');
            Route::post('updateProfile',[EmployerController::class,'updateProfile'])->name('employer#updateProfile');
            Route::post('updateImage',[EmployerController::class,'updateImage'])->name('employer#updateImage');

            //Industry
            Route::get('IndustryPage',[CompanyIndustriesController::class,'IndustryPage'])->name('employer#IndustryPage');
            Route::get('addIndustryPage',[CompanyIndustriesController::class,'addIndustryPage'])->name('add#newIndustryPage');
            Route::post('addnewIndustry',[CompanyIndustriesController::class,'addnewIndustry'])->name('add#newIndustry');
            Route::get('deleteIndustry/{id}',[EmployerController::class,'deleteIndustry'])->name('employer#deleteIndustry');
            Route::get('editIndustry/{id}',[EmployerController::class,'editIndustry'])->name('employer#editIndustry');
            Route::post('updateIndustry/',[EmployerController::class,'updateIndustry'])->name('employer#updateIndustry');


            //plan 
            Route::get('subscribePlan/{id}', [EmployerController::class,'subscribePlan'])->name('employer#subscribePlan');
            Route::post('paymentMethod',[EmployerController::class,'paymentMethod'])->name('employer#paymentMethod');
            Route::get('depositConfirm',[EmployerController::class,'depositPage'])->name('employer#depositPage');
            Route::post('depositConfirm',[EmployerController::class,'depositConfirm'])->name('employer#depositConfirm');
            Route::get('transactionHistory',[EmployerController::class,'transactionPage'])->name('employer#transactionPage');

            // transaction history
            Route::delete('transactionDelete/{id}',[TransactionHistoryController::class,'transactionDelete'])->name('employer#transactionDelete');
            Route::get('transactionDetails/{id}',[TransactionHistoryController::class,'transactionDetails'])->name('employer#transactionDetails');
            
            // contact page
            Route::prefix('employer')->group(function(){
                Route::get('contact',[ContactController::class,'contactPage'])->name('employer#contact');
                Route::post('contact1',[ContactController::class,'contact'])->name('employer#contactfunc');

                // about page
                Route::get('about',[ContactController::class,'about'])->name('employer#about');
            });

            //ajax
            Route::prefix('ajax')->group(function(){
                Route::get('selectedPay',[AjaxController::class,'selectedPay'])->name('ajax#selectedPay');
                Route::get('categorydata',[AjaxController::class,'categorydata'])->name('ajax#categoryData');
                Route::get('stateData',[AjaxController::class,'stateData'])->name('ajax#stateData');
                Route::get('statusChange',[AjaxController::class,'statusChange'])->name('ajax#statusChange');
                Route::get('townshipData',[AjaxController::class,'townshipData'])->name('ajax#townshipData');
                Route::get('viewCount',[AjaxController::class,'viewCount'])->name('ajax#viewCount');
            });

            
        });

    });
});

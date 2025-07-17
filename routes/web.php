<?php

use App\Models\SubCraft;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RolesController;

use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\AboutusController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DemandsController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\NominateController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\SubCraftController;
use App\Http\Controllers\Admin\MainCraftController;
use App\Http\Controllers\Admin\MianCraftController;
use App\Http\Controllers\Admin\NominationsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\HumanResourceController;
use App\Http\Controllers\Admin\BulkFeatureController;
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\HumanResouce\HRProfileController;
use App\Http\Controllers\Admin\ApprovedApplicantsController;
use App\Http\Controllers\Admin\HrStepController;
use App\Http\Controllers\Admin\ProjectReportController as AdminProjectReportController;
use App\Http\Controllers\HumanResouce\HumanResouceController;
use App\Http\Controllers\HumanResouce\HRNotificationController;
use App\Http\Controllers\HumanResouce\HumanResouceAuthController;

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
/*
Admin routes
 * */

Route::get('/', function () {
    return redirect('/admin-login');
});
Route::get('/admin-login', [AuthController::class, 'getLoginPage'])->name('login');
Route::post('admin/login', [AuthController::class, 'Login']);
Route::get('/admin-forgot-password', [AdminController::class, 'forgetPassword']);
Route::post('/admin-reset-password-link', [AdminController::class, 'adminResetPasswordLink']);
Route::get('/change_password/{id}', [AdminController::class, 'change_password']);
Route::post('/admin-reset-password', [AdminController::class, 'ResetPassword']);

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'getdashboard']);
    Route::get('profile', [AdminController::class, 'getProfile']);
    Route::post('update-profile', [AdminController::class, 'update_profile']);
    Route::get('logout', [AdminController::class, 'logout']);
    /**officer */
    Route::get('officer/status/{id}', [OfficerController::class, 'status'])->name('officer.status');
    /**company */
    Route::get('company/status/{id}', [CompanyController::class, 'status'])->name('company.status');

    /** resource controller */
    Route::resource('officer', OfficerController::class);
    Route::resource('about', AboutusController::class);
    Route::resource('policy', PolicyController::class);
    Route::resource('terms', TermConditionController::class);
    Route::resource('faq', FaqController::class);
    // ############ Roles #################
    Route::controller(RolesController::class)->group(function () {
        Route::get('/roles',  'index')->name('roles.index')->middleware(['check.permission:Roles,view']);
        Route::get('/roles-create',  'create')->name('roles.create')->middleware(['check.permission:Roles,create']);
        Route::post('/roles-store',  'store')->name('roles.store')->middleware(['check.permission:Roles,create']);
        Route::get('/roles-edit/{id}',  'edit')->name('roles.edit')->middleware(['check.permission:Roles,edit']);
        Route::post('/roles-update/{id}',  'update')->name('roles.update')->middleware(['check.permission:Roles,edit']);
        Route::delete('/roles-destroy/{id}',  'destroy')->name('roles.destroy')->middleware(['check.permission:Roles,delete']);
    });
    // ############ Mian Craft #################
    Route::controller(MainCraftController::class)->group(function () {
        Route::get('/mainCraft',  'index')->name('maincraft.index')->middleware(['check.permission:Main Crafts,view']);
        Route::get('/mainCraft-create',  'create')->name('maincraft.create')->middleware(['check.permission:Main Crafts,create']);
        Route::post('/mainCraft-store',  'store')->name('maincraft.store')->middleware(['check.permission:Main Crafts,create']);
        Route::get('/mainCraft-edit/{id}',  'edit')->name('maincraft.edit')->middleware(['check.permission:Main Crafts,edit']);
        Route::post('/mainCraft-update/{id}',  'update')->name('maincraft.update')->middleware(['check.permission:Main Crafts,edit']);
        Route::delete('/mainCraft-destroy/{id}',  'destroy')->name('maincraft.destroy')->middleware(['check.permission:Main Crafts,delete']);
        Route::get('/get-sub-crafts', 'getSubCrafts')->name('get-sub-crafts')->middleware(['check.permission:Sub Crafts,view']);
        Route::get('/get-all-crafts', 'getAllCrafts')->name('get-all-crafts')->middleware(['check.permission:Sub Crafts,view']);
    });


    Route::controller(SubCraftController::class)->group(function () {
        Route::get('/Craftsub/{id}',  'index')->name('subcraft.index')->middleware(['check.permission:Sub Crafts,view']);
        Route::post('/Craftsub-store',  'store')->name('subcraft.store')->middleware(['check.permission:Sub Crafts,create']);
        Route::post('/Craftsub-update/{id}',  'update')->name('subcraft.update')->middleware(['check.permission:Sub Crafts,edit']);
        Route::delete('/Craftsub-destroy/{id}',  'destroy')->name('subcraft.destroy')->middleware(['check.permission:Sub Crafts,delete']);
    });

    // ############ Sub Admin #################
    Route::controller(SubAdminController::class)->group(function () {
        Route::get('/subadmin',  'index')->name('subadmin.index')->middleware(['check.permission:Sub Admins,view']);
        Route::get('/subadmin-create',  'create')->name('subadmin.create')->middleware(['check.permission:Sub Admins,create']);
        Route::post('/subadmin-store',  'store')->name('subadmin.store')->middleware(['check.permission:Sub Admins,create']);
        Route::get('/subadmin-edit/{id}',  'edit')->name('subadmin.edit')->middleware(['check.permission:Sub Admins,edit']);
        Route::post('/subadmin-update/{id}',  'update')->name('subadmin.update')->middleware(['check.permission:Sub Admins,edit']);
        Route::delete('/subadmin-destroy/{id}',  'destroy')->name('subadmin.destroy')->middleware(['check.permission:Sub Admins,delete']);
    });

    // ############ Companies #################
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/companies',  'index')->name('companies.index')->middleware(['check.permission:Companies,view']);
        Route::post('/company-store',  'store')->name('companies.store')->middleware(['check.permission:Companies,create']);
        Route::post('/company-update/{id}',  'update')->name('company.update')->middleware(['check.permission:Companies,edit']);
        Route::delete('/company-destroy/{id}',  'destroy')->name('company.destroy')->middleware(['check.permission:Companies,delete']);
    });
    // ############ Projects #################
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/companies-projects/{id}',  'index')->name('project.index')->middleware(['check.permission:Projects,view']);
        Route::post('/project-store',  'store')->name('project.store')->middleware(['check.permission:Projects,create']);
        Route::post('/project-update/{id}',  'update')->name('project.update')->middleware(['check.permission:Projects,edit']);
        Route::delete('/project-destroy/{id}',  'destroy')->name('project.destroy')->middleware(['check.permission:Projects,delete']);

        Route::get('/get-projects',  'getProjects')->name('get-projects')->middleware(['check.permission:Projects,view']);
    });
    // ############ Demands #################
    Route::controller(DemandsController::class)->group(function () {
        Route::get('/demands/{id}',  'index')->name('demands.index')->middleware(['check.permission:Demands,view']);
        Route::post('/demand',  'store')->name('demand.store')->middleware(['check.permission:Demands,create']);
        Route::post('/demand-update/{id}',  'update')->name('demand.update')->middleware(['check.permission:Demands,edit']);
        Route::delete('/demand-destroy/{id}',  'destroy')->name('demand.destroy')->middleware(['check.permission:Demands,delete']);
        Route::get('/get-demand', 'getDemand')->name('get-demand')->middleware(['check.permission:Demands,view']);
        Route::get('/get-crafts-by-demand', 'getCrafts')->name('get-crafts-by-demand')->middleware(['check.permission:Demands,view']);
    });
    // ############ Human Resource ################# 
    Route::controller(HumanResourceController::class)->group(function () {
        Route::get('/human-resource',  'index')->name('humanresource.index')->middleware(['check.permission:Human Resources,view']);
        Route::get('/human-resource/create',  'create')->name('humanresource.create')->middleware(['check.permission:Human Resources,create']);
        Route::post('/human-resource/store',  'store')->name('humanresource.store')->middleware(['check.permission:Human Resources,create']);
        Route::get('/human-resource-edit/{id}',  'edit')->name('humanresource.edit')->middleware(['check.permission:Human Resources,edit']);
        Route::post('/human-resource-update/{id}',  'update')->name('humanresource.update')->middleware(['check.permission:Human Resources,update']);
        Route::delete('/human-resource-destroy/{id}',  'destroy')->name('humanresource.destroy')->middleware(['check.permission:Human Resources,delete']);
        Route::post('/update-history',  'mobDemob')->name('jobHistory.update');
        Route::post('/jobHistory-update',  'updateHistory')->name('history.update');
        Route::get('/get-demob-data',  'getMobData')->name('get-demob-data');
        Route::post('admin/human-resource/ajax','ajax')->name('humanresource.ajax');
    });
    

      // ############ Human Resource ################# 
    Route::controller(BulkFeatureController::class)->group(function () {
        Route::post('/human-resource/import',  'import')->name('humanresource.import.data');
        // Route::get('/human-resource/create',  'create')->name('humanresource.create');
        // Route::post('/human-resource/store',  'store')->name('humanresource.store');
        // Route::get('/human-resource-edit/{id}',  'edit')->name('humanresource.edit');
        // Route::post('/human-resource-update/{id}',  'update')->name('humanresource.update');
        // Route::delete('/human-resource-destroy/{id}',  'destroy')->name('humanresource.destroy');
        // Route::post('/update-history',  'mobDemob')->name('jobHistory.update');
        // Route::post('/jobHistory-update',  'updateHistory')->name('history.update');
        // Route::get('/get-demob-data',  'getMobData')->name('get-demob-data');
    });


    // ############ Human Resource Steps #################
    Route::controller(HrStepController::class)->group(function () {
        Route::post('/submit-step/{step}',  'submitStep')->name('submit.step');
    });
    // ############ Nomination #################
    Route::controller(NominationsController::class)->group(function () {
        Route::get('/nominations',  'index')->name('nominations.index');
        Route::delete('/nomination/{id}',  'destroy')->name('nominations.destroy');
    });

    // ############ Nominate from Demands #################
    Route::controller(NominateController::class)->group(function () {
        Route::get('/nominate/{craft_id}/{demand_id}/{project_id}',  'index')->name('nominate.index');
        Route::post('/nominate-store',  'store')->name('nominate.store');
        Route::delete('/nominate/{id}',  'destroy')->name('nominate.destroy');
    });
   // ############ Approved Applicant ################# 
    Route::controller(ApprovedApplicantsController::class)->group(function () {
        Route::get('/approved-applicants',  'index')->name('approved.applicants.index');
        Route::delete('/approved-applicant/{id}',  'destroy')->name('approved.applicant.destroy');
    });
    // ############ Reports #################
    Route::controller(ReportsController::class)->group(function () {
        Route::get('/reports',  'index')->name('reports.index');
    });

    Route::controller(AdminProjectReportController::class)->group(function () {
        Route::get('/project-reports',  'index')->name('project-reports.index');
        Route::get('/projects-get', 'getProjects')->name('projects-get');
        Route::get('/project-reports/ajax', 'ajaxData')->name('project-reports.ajax');
        Route::get('/flight-reports',  'flightReportIndex')->name('flight-reports.index');
        Route::get('flight-reports/data', 'getFlights')->name('flight-reports.ajax');
    });

    // ############ Notifications #################
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index')->middleware(['check.permission:Notifications,view']);
    Route::get('/fetch-recipients', [NotificationController::class, 'fetchRecipients']);
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store')->middleware(['check.permission:Notifications,create']);
    Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware(['check.permission:Notifications,delete']);

    Route::get('/notification/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::get('/notification/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/notification/read-all/', [NotificationController::class, 'readAll'])->name('notifications.read.all');
});

// HR and company notification 
Route::view('/user-notification', 'notification.show');


// ######################### Human Rescourse ############################
Route::get('/human-resource', [HumanResouceAuthController::class, 'getHrLoginPage']);
Route::post('human-resource/login', [HumanResouceAuthController::class, 'loginHR']);
Route::get('/human-resource-forgot-password', [HumanResouceController::class, 'forgetPassword']);
Route::post('/human-resource-reset-password-link', [HumanResouceController::class, 'adminResetPasswordLink']);
Route::get('/human-resource-change_password/{id}', [HumanResouceController::class, 'change_password']);
Route::post('/human-resource-reset-password', [HumanResouceController::class, 'ResetPassword']);
Route::post('/generate-form-7', [HumanResouceController::class, 'generateForm7'])->name('generate.filled.pdf7');
Route::post('/generate-nbp-form', [HumanResouceController::class, 'generateForm8'])->name('generate.filled.pdf');
Route::post('/generate-challan-92', [HumanResouceController::class, 'generateForm9'])->name('generate.filled.pdf');
Route::post('/generate-life-insurance', [HumanResouceController::class, 'generateForm10'])->name('generate.filled.pdf');
Route::post('/generate-fsa-form', [HumanResouceController::class, 'generateForm11'])->name('generate.filled.pdf');

Route::prefix('human-resource')->middleware('humanresource')->group(function () {
    Route::get('dashboard', [HumanResouceController::class, 'getdashboard'])->name('human-resouce.dashboard');
    Route::get('profile', [HumanResouceController::class, 'getProfile']);
    Route::post('update-profile', [HumanResouceController::class, 'update_profile']);
    Route::get('logout', [HumanResouceController::class, 'logout']);
    Route::get('steps-data', [HumanResouceController::class, 'hrStepsData']);
    
    /**officer */
    Route::get('officer/status/{id}', [OfficerController::class, 'status'])->name('officer.status');
    /**human-resource */
    Route::get('human-resource/status/{id}', [HumanResouceController::class, 'status'])->name('human-resouce.status');

    // ############ HR profile #################
    Route::controller(HRProfileController::class)->group(function () {
        Route::get('/my-profile',  'index')->name('myprofile.index');
    });
    // ############ NOtifcation #################
    Route::controller(HRNotificationController::class)->group(function () {
        Route::get('/notification',  'index')->name('notificationHumanResouce.index');
    });
});

Route::get('/hr/modal-content', [HumanResourceController::class, 'getModalContent'])->name('hr.modal.content');

require __DIR__ . '/company.php';

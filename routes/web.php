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
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\HumanResouce\HRProfileController;
use App\Http\Controllers\Admin\ApprovedApplicantsController;
use App\Http\Controllers\Admin\HrStepController;
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
Route::get('/admin-login', [AuthController::class, 'getLoginPage']);
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
        Route::get('/roles',  'index')->name('roles.index');
        Route::get('/roles-create',  'create')->name('roles.create');
        Route::post('/roles-store',  'store')->name('roles.store');
        Route::get('/roles-edit/{id}',  'edit')->name('roles.edit');
        Route::post('/roles-update/{id}',  'update')->name('roles.update');
        Route::delete('/roles-destroy/{id}',  'destroy')->name('roles.destroy');
    });
    // ############ Mian Craft #################
    Route::controller(MainCraftController::class)->group(function () {
        Route::get('/mainCraft',  'index')->name('maincraft.index');
        Route::get('/mainCraft-create',  'create')->name('maincraft.create');
        Route::post('/mainCraft-store',  'store')->name('maincraft.store');
        Route::get('/mainCraft-edit/{id}',  'edit')->name('maincraft.edit');
        Route::post('/mainCraft-update/{id}',  'update')->name('maincraft.update');
        Route::delete('/mainCraft-destroy/{id}',  'destroy')->name('maincraft.destroy');
        
        Route::get('/get-sub-crafts', 'getSubCrafts')->name('get-sub-crafts');
    });


    Route::controller(SubCraftController::class)->group(function () {
        Route::get('/Craftsub/{id}',  'index')->name('subcraft.index');
        Route::post('/Craftsub-store',  'store')->name('subcraft.store');
        Route::post('/Craftsub-update/{id}',  'update')->name('subcraft.update');
        Route::delete('/Craftsub-destroy/{id}',  'destroy')->name('subcraft.destroy');
    });

    // ############ Sub Admin #################
    Route::controller(SubAdminController::class)->group(function () {
        Route::get('/subadmin',  'index')->name('subadmin.index');
        Route::get('/subadmin-create',  'create')->name('subadmin.create');
        Route::post('/subadmin-store',  'store')->name('subadmin.store');
        Route::get('/subadmin-edit/{id}',  'edit')->name('subadmin.edit');
        Route::post('/subadmin-update/{id}',  'update')->name('subadmin.update');
        Route::delete('/subadmin-destroy/{id}',  'destroy')->name('subadmin.destroy');
    });

    // ############ Companies #################
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/companies',  'index')->name('companies.index');
        Route::post('/company-store',  'store')->name('companies.store');
        Route::post('/company-update/{id}',  'update')->name('company.update');
        Route::delete('/company-destroy/{id}',  'destroy')->name('company.destroy');
    });
    // ############ Projects #################
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/companies-projects/{id}',  'index')->name('project.index');
        Route::post('/project-store',  'store')->name('project.store');
        Route::post('/project-update/{id}',  'update')->name('project.update');
        Route::delete('/project-destroy/{id}',  'destroy')->name('project.destroy');

        Route::get('/get-projects',  'getProjects')->name('get-projects');
    });
    // ############ Demands #################
    Route::controller(DemandsController::class)->group(function () {
        Route::get('/demands/{id}',  'index')->name('demands.index');
        Route::post('/demand',  'store')->name('demand.store');
        Route::post('/demand-update/{id}',  'update')->name('demand.update');
        Route::delete('/demand-destroy/{id}',  'destroy')->name('demand.destroy');

        Route::get('/get-demand', 'getDemand')->name('get-demand');
    });
    // ############ Human Resource #################
    Route::controller(HumanResourceController::class)->group(function () {
        Route::get('/human-resource',  'index')->name('humanresource.index');
        Route::get('/human-resource/create',  'create')->name('humanresource.create');
        Route::post('/human-resource/store',  'store')->name('humanresource.store');
        Route::get('/human-resource-edit/{id}',  'edit')->name('humanresource.edit');
        Route::post('/human-resource-update/{id}',  'update')->name('humanresource.update');
        Route::delete('/human-resource-destroy/{id}',  'destroy')->name('humanresource.destroy');
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
    // ############ Notifications #################
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notification',  'index')->name('notification.index');
    });
});

// ######################### Human Rescourse ############################
Route::get('/human-resource', [HumanResouceAuthController::class, 'getHrLoginPage']);
Route::post('human-resource/login', [HumanResouceAuthController::class, 'loginHR']);
Route::get('/human-resource-forgot-password', [HumanResouceController::class, 'forgetPassword']);
Route::post('/human-resource-reset-password-link', [HumanResouceController::class, 'adminResetPasswordLink']);
Route::get('/human-resource-change_password/{id}', [HumanResouceController::class, 'change_password']);
Route::post('/human-resource-reset-password', [HumanResouceController::class, 'ResetPassword']);
Route::get('/generate-form-7', [HumanResouceController::class, 'generateForm7'])->name('generate.filled.pdf');
Route::prefix('human-resource')->middleware('humanresource')->group(function () {
    Route::get('dashboard', [HumanResouceController::class, 'getdashboard'])->name('human-resouce.dashboard');
    Route::get('profile', [HumanResouceController::class, 'getProfile']);
    Route::post('update-profile', [HumanResouceController::class, 'update_profile']);
    Route::get('logout', [HumanResouceController::class, 'logout']);
    
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
require __DIR__ . '/company.php';

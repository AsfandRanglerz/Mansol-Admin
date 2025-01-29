<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\AboutusController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Admin\TermConditionController;
use App\Http\Controllers\Company\CompanyAuthController;
use App\Http\Controllers\Company\CompanyNotificationController;
use App\Http\Controllers\Company\CompanyProjectController;

Route::get('/company', [CompanyAuthController::class, 'getCompanyLoginPage']);
Route::post('company/login', [CompanyAuthController::class, 'companyLogin']);
Route::get('/company-forgot-password', [CompanyController::class, 'forgetPassword']);
Route::post('/company-reset-password-link', [CompanyController::class, 'adminResetPasswordLink']);
Route::get('/company-change_password/{id}', [CompanyController::class, 'change_password']);
Route::post('/company-reset-password', [CompanyController::class, 'ResetPassword']);
Route::prefix('company')->middleware('company')->group(function () {
    Route::get('dashboard', [CompanyController::class, 'getdashboard'])->name('company.dashboard');
    Route::get('profile', [CompanyController::class, 'getProfile']);
    Route::post('update-profile', [CompanyController::class, 'update_profile']);
    Route::get('logout', [CompanyController::class, 'logout']);
    /**officer */
    Route::get('officer/status/{id}', [OfficerController::class, 'status'])->name('officer.status');
    /**company */
    Route::get('company/status/{id}', [CompanyController::class, 'status'])->name('company.status');
    // ############ Projects #################
    Route::controller(CompanyProjectController::class)->group(function () {
        Route::get('/company-projects',  'index')->name('companyProject.index');
    });
    // ############ Notification #################
    Route::controller(CompanyNotificationController::class)->group(function () {
        Route::get('/notification',  'index')->name('notificationCompany.index');
    });
});

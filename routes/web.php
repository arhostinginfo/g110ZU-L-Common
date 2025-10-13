<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GPAdmin\LoginController;
use App\Http\Controllers\GPAdmin\DashboardController;
use App\Http\Controllers\GPAdmin\ChangePasswordController;

use App\Http\Controllers\GPAdmin\OfficerController;
use App\Http\Controllers\GPAdmin\NavbarController; 
use App\Http\Controllers\GPAdmin\FamousLocationController; 
use App\Http\Controllers\GPAdmin\YojnaController; 
use App\Http\Controllers\GPAdmin\AbhiyansController; 
use App\Http\Controllers\GPAdmin\SliderController;  
use App\Http\Controllers\GPAdmin\GallaryController;  
use App\Http\Controllers\GPAdmin\MarqueeController;  
use App\Http\Controllers\GPAdmin\WelcomeNoteController;  


use App\Http\Controllers\WebSiteController;
use App\Http\Controllers\FrontwebsitecontactController;

use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SuperAdminChangePasswordController;
use App\Http\Controllers\SuperAdmin\AdminLoginController;
use App\Http\Controllers\SuperAdmin\AdminGPController;

use Illuminate\Support\Facades\Artisan;

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});


Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    // Artisan::call('route:cache');
    Artisan::call('view:cache');
    Artisan::call('event:cache');

    return "All optimized and cleared!";
});


Route::post('/frontwebsitecontact', [FrontwebsitecontactController::class, 'store'])->name('frontwebsitecontact.store');



// Route::resource('talukas', [TalukaController::class, 'loginsuper'])->name('adminlogin');


Route::get('adminlogin', [AdminLoginController::class, 'loginsuper'])->name('adminlogin');
Route::post('adminlogin', [AdminLoginController::class, 'validateSuperLogin'])->name('adminlogin');


Route::get('login', [LoginController::class, 'loginsuper'])->name('login');
Route::post('gplogin', [LoginController::class, 'validateSuperLogin'])->name('gplogin');

Route::get('/{gpname}', [WebSiteController::class, 'index'])->name('/');

// Route::group(['prefix' => 'gpadmin','middleware' => ['GPAdmin']], function () {   
Route::group([
    'prefix' => 'gpadmin',
    'as' => 'gpadmin.',
    'middleware' => ['GPAdmin']
], function () {
    
    
   
    Route::get('dashboard-gp', [DashboardController::class, 'gplogin'])->name('dashboard-gp');

    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');
    Route::post('/update-password', [ChangePasswordController::class, 'updatePassword'])->name('update-password');

        
    Route::get('/yojna/list', [YojnaController::class, 'list'])->name('yojna.list');
    Route::get('/yojna/add', [YojnaController::class, 'add'])->name('yojna.add');
    Route::post('/yojna/add', [YojnaController::class, 'save'])->name('yojna.save');
    Route::get('/yojna/edit/{encodedId}', [YojnaController::class, 'edit'])->name('yojna.edit');
    Route::post('/yojna/update/', [YojnaController::class, 'update'])->name('yojna.update');
    Route::post('/yojna/delete', [YojnaController::class, 'delete'])->name('yojna.delete');
    Route::post('/yojna/update-status', [YojnaController::class, 'updateStatus'])->name('yojna.updatestatus');

    Route::get('/abhiyan/list', [AbhiyansController::class, 'index'])->name('abhiyan.list');
    Route::get('/abhiyan/add', [AbhiyansController::class, 'create'])->name('abhiyan.create');
    Route::post('/abhiyan/add', [AbhiyansController::class, 'save'])->name('abhiyan.save');
    Route::get('/abhiyan/edit/{encodedId}', [AbhiyansController::class, 'edit'])->name('abhiyan.edit');
    Route::post('/abhiyan/update/{encodedId}', [AbhiyansController::class, 'update'])->name('abhiyan.update');
    Route::post('/abhiyan/delete', [AbhiyansController::class, 'delete'])->name('abhiyan.delete');
    Route::post('/abhiyan/update-status', [AbhiyansController::class, 'updateStatus'])->name('abhiyan.updatestatus');

    Route::get('/officers/list', [OfficerController::class, 'list'])->name('officers.list');
    Route::get('/officers/add', [OfficerController::class, 'add'])->name('officers.add');
    Route::post('/officers/add', [OfficerController::class, 'save'])->name('officers.save');
    Route::get('/officers/edit/{encodedId}', [OfficerController::class, 'edit'])->name('officers.edit');
    Route::post('/officers/update/', [OfficerController::class, 'update'])->name('officers.update');
    Route::post('/officers/delete', [OfficerController::class, 'delete'])->name('officers.delete');
    Route::post('/officers/update-status', [OfficerController::class, 'updateStatus'])->name('officers.updatestatus');

    Route::get('/navbar/list', [NavbarController::class, 'list'])->name('navbar.list');
    Route::get('/navbar/add', [NavbarController::class, 'add'])->name('navbar.add');
    Route::post('/navbar/add', [NavbarController::class, 'save'])->name('navbar.save');
    Route::get('/navbar/edit/{encodedId}', [NavbarController::class, 'edit'])->name('navbar.edit');
    Route::post('/navbar/update/', [NavbarController::class, 'update'])->name('navbar.update');
    Route::post('/navbar/delete', [NavbarController::class, 'delete'])->name('navbar.delete');
    Route::post('/navbar/update-status', [NavbarController::class, 'updateStatus'])->name('navbar.updatestatus');


    Route::get('/famous-locations/list', [FamousLocationController::class, 'list'])->name('famous-locations.list');
    Route::get('/famous-locations/add', [FamousLocationController::class, 'add'])->name('famous-locations.add');
    Route::post('/famous-locations/add', [FamousLocationController::class, 'save'])->name('famous-locations.save');
    Route::get('/famous-locations/edit/{encodedId}', [FamousLocationController::class, 'edit'])->name('famous-locations.edit');
    Route::post('/famous-locations/update/', [FamousLocationController::class, 'update'])->name('famous-locations.update');
    Route::post('/famous-locations/delete', [FamousLocationController::class, 'delete'])->name('famous-locations.delete');
    Route::post('/famous-locations/update-status', [FamousLocationController::class, 'updateStatus'])->name('famous-locations.updatestatus');

    Route::get('/slider/list', [SliderController::class, 'list'])->name('slider.list');
    Route::get('/slider/add', [SliderController::class, 'add'])->name('slider.add');
    Route::post('/slider/add', [SliderController::class, 'save'])->name('slider.save');
    Route::get('/slider/edit/{encodedId}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('/slider/update/', [SliderController::class, 'update'])->name('slider.update');
    Route::post('/slider/delete', [SliderController::class, 'delete'])->name('slider.delete');
    Route::post('/slider/update-status', [SliderController::class, 'updateStatus'])->name('slider.updatestatus');

    Route::get('/gallary/list', [GallaryController::class, 'list'])->name('gallary.list');
    Route::get('/gallary/add', [GallaryController::class, 'add'])->name('gallary.add');
    Route::post('/gallary/add', [GallaryController::class, 'save'])->name('gallary.save');
    Route::get('/gallary/edit/{encodedId}', [GallaryController::class, 'edit'])->name('gallary.edit');
    Route::post('/gallary/update/', [GallaryController::class, 'update'])->name('gallary.update');
    Route::post('/gallary/delete', [GallaryController::class, 'delete'])->name('gallary.delete');
    Route::post('/gallary/update-status', [GallaryController::class, 'updateStatus'])->name('gallary.updatestatus');

    Route::get('/marquee/list', [MarqueeController::class, 'index'])->name('marquee.list');
    Route::get('/marquee/add', [MarqueeController::class, 'create'])->name('marquee.create');
    Route::post('/marquee/add', [MarqueeController::class, 'save'])->name('marquee.save');
    Route::get('/marquee/edit/{encodedId}', [MarqueeController::class, 'edit'])->name('marquee.edit');
    Route::post('/marquee/update/{encodedId}', [MarqueeController::class, 'update'])->name('marquee.update');
    Route::post('/marquee/delete', [MarqueeController::class, 'delete'])->name('marquee.delete');
    Route::post('/marquee/update-status', [MarqueeController::class, 'updateStatus'])->name('marquee.updatestatus');

    

    Route::get('/welcome-note/list', [WelcomeNoteController::class, 'index'])->name('welcome-note.list');
    Route::get('/welcome-note/add', [WelcomeNoteController::class, 'create'])->name('welcome-note.create');
    Route::post('/welcome-note/add', [WelcomeNoteController::class, 'save'])->name('welcome-note.save');
    Route::get('/welcome-note/edit/{encodedId}', [WelcomeNoteController::class, 'edit'])->name('welcome-note.edit');
    Route::post('/welcome-note/update/{encodedId}', [WelcomeNoteController::class, 'update'])->name('welcome-note.update');
    Route::post('/welcome-note/delete', [WelcomeNoteController::class, 'delete'])->name('welcome-note.delete');
    Route::post('/welcome-note/update-status', [WelcomeNoteController::class, 'updateStatus'])->name('welcome-note.updatestatus');



    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

});

Route::group([
    'prefix' => 'superadmin',
    'as' => 'superadmin.',
    'middleware' => ['SuperAdmin']
], function () {
    
    
    Route::get('/admin-gp/list', [AdminGPController::class, 'list'])->name('admin-gp.list');
    Route::get('/admin-gp/add', [AdminGPController::class, 'add'])->name('admin-gp.add');
    Route::post('/admin-gp/add', [AdminGPController::class, 'save'])->name('admin-gp.save');
    Route::get('/admin-gp/edit/{encodedId}', [AdminGPController::class, 'edit'])->name('admin-gp.edit');
    Route::post('/admin-gp/update/', [AdminGPController::class, 'update'])->name('admin-gp.update');
    Route::post('/admin-gp/delete', [AdminGPController::class, 'delete'])->name('admin-gp.delete');
    Route::post('/admin-gp/update-status', [AdminGPController::class, 'updateStatus'])->name('admin-gp.updatestatus');

    Route::get('dashboard-admin', [SuperAdminDashboardController::class, 'admin'])->name('dashboard-admin');

    Route::get('/change-password', [SuperAdminChangePasswordController::class, 'index'])->name('change-password');
    Route::post('/update-password', [SuperAdminChangePasswordController::class, 'updatePassword'])->name('update-password');

    Route::get('logout', [AdminLoginController::class, 'logout'])->name('logout');

});

<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin'], function () {

    /*==================== Auth System ==================*/
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')
        ->name('login');//view login

    Route::post('login', 'Auth\AdminLoginController@login')
        ->name('admin.login.submit');//action login


    //==================================================
    /*====================Admin Panel==================*/
    Route::group(['middleware' => 'auth'], function ()
    {
        //Log Out
        Route::get('logout',
            'Auth\AdminLoginController@logout')->name('admin.logout');

        //user layout settings
        Route::get('data-theme',
            'AppSettings\AdminAppSettingController@handel_data_theme_bg')
            ->name('data-theme');

        //dashboard
        Route::get('/home',
            'Home\AdminController@index')->name('admin.dashboard');

        //Profile
        Route::resource('profileControl',
            'Profile\AdminProfileController');

        /**====================================================**/
        /**====================================================**/
        /**===================    Modules   ===================**/
        /**====================================================**/
        /**====================================================**/

        Route::resource('routingBasics','Modules\AdminRoutingController');

        require __DIR__.'/modulesRoutes/SystemRouter.php';
        require __DIR__.'/modulesRoutes/ManagmentRouter.php';



    });//end auth part

});//end prefix part

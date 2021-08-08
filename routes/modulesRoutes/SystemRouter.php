<?php

    //setting index
    Route::resource('settingIndex',
        'Modules\SystemSetting\AdminSettingIndexController');

//general company settings
    Route::resource('generalSettings',
        'Modules\SystemSetting\AdminGeneralSettingController');


//users settings
    Route::resource('users',
        'Modules\SystemSetting\AdminUserController');
    Route::delete('users/delete/bulk',
        'Modules\SystemSetting\AdminUserController@delete_all')
        ->name('users.delete.bulk');

    Route::get('users/changeBlock/{id}',
        'Modules\SystemSetting\AdminUserController@changeBlock')
        ->name('users.changeBlock');


   //log activities settings
    Route::resource('logActivities',
        'Modules\SystemSetting\AdminLogActivityController');

    Route::post('logActivities/filter',
        'Modules\SystemSetting\AdminLogActivityController@filter')
        ->name('logActivities.filter');

    Route::delete('logActivities/delete/bulk',
        'Modules\SystemSetting\AdminLogActivityController@delete_all')
        ->name('logActivities.delete.bulk');

    //Dynamic Sliders settings
    Route::resource('dynamicSliders',
        'Modules\SystemSetting\AdminDynamicSliderController');

    Route::get('reOrderAllDynamicSliders',
        'Modules\SystemSetting\AdminDynamicSliderController@reOrderAllDynamicSliders')
        ->name('dynamicSliders.reOrderAllDynamicSliders');

    Route::post('reOrderAllDynamicSlidersAction',
        'Modules\SystemSetting\AdminDynamicSliderController@reOrderAllDynamicSlidersAction')
        ->name('dynamicSliders.reOrderAllDynamicSlidersAction');


    Route::get('dynamicSliders/changeStatus/{id}',
        'Modules\SystemSetting\AdminDynamicSliderController@changeStatus')
        ->name('dynamicSliders.changeStatus');

    Route::post('dynamicSliders/changeOrder',
        'Modules\SystemSetting\AdminDynamicSliderController@re_order_dynamic_sliders')
        ->name('dynamicSliders.changeOrder');



    //adding permissions  settings
    Route::resource('userPermissions',
        'Modules\SystemSetting\AdminUserPermissionController');

    Route::delete('userPermissions/delete/bulk',
        'Modules\SystemSetting\AdminUserPermissionController@delete_all')
        ->name('userPermissions.delete.bulk');




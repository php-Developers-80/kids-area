<?php


Route::resource('cashier', 'Modules\Cashier\AdminCashierController');




Route::get('selectExistClient','Modules\Cashier\AdminCashierController@selectExistClient')
    ->name('selectExistClient');

Route::get('selectNewClient','Modules\Cashier\AdminCashierController@selectNewClient')
    ->name('selectNewClient');

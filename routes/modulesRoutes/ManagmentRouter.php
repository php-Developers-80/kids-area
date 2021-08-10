<?php


//tickets

Route::resource('tickets',
    'Modules\Managment\AdminTicketController');

Route::delete('tickets/delete/bulk',
    'Modules\Managment\AdminTicketController@delete_all')
    ->name('tickets.delete.bulk');


Route::get('tickets/changeStatus/{id}',
    'Modules\Managment\AdminTicketController@changeStatus')
    ->name('tickets.changeStatus');



//add-ons

Route::resource('add-ons',
    'Modules\Managment\AdminAddOnsController');

Route::delete('add-ons/delete/bulk',
    'Modules\Managment\AdminAddOnsController@delete_all')
    ->name('add-ons.delete.bulk');


Route::get('add-ons/changeStatus/{id}',
    'Modules\Managment\AdminAddOnsController@changeStatus')
    ->name('add-ons.changeStatus');



//customers

Route::resource('customers',
    'Modules\Managment\AdminCustomerController');

Route::delete('customers/delete/bulk',
    'Modules\Managment\AdminCustomerController@delete_all')
    ->name('customers.delete.bulk');




Route::resource('orders',
    'Modules\Managment\AdminOrderController');

Route::delete('orders/delete/bulk',
    'Modules\Managment\AdminOrderController@delete_all')
    ->name('orders.delete.bulk');
Route::post('ordersFilter','Modules\Managment\AdminOrderController@filter')
    ->name('orders.filter');

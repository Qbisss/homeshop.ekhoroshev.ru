<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Admin\AuthController::class, 'check'])->name('check');
Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'index'])->name('login');
Route::get('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
Route::post('login_process', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login_process');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('panel', [App\Http\Controllers\Admin\PanelController::class, 'index'])->name('panel.index');

    Route::get('panel/catalog/category', [App\Http\Controllers\Admin\PanelCategoryController::class, 'show_category'])->name('show_category');
    Route::post('panel/catalog/addcategory', [App\Http\Controllers\Admin\PanelCategoryController::class, 'addcategory'])->name('add_category');
    Route::post('panel/catalog/editcategory', [App\Http\Controllers\Admin\PanelCategoryController::class, 'editcategory'])->name('edit_category');
    Route::post('panel/catalog/editcategory_process', [App\Http\Controllers\Admin\PanelCategoryController::class, 'editcategory_process'])->name('editcategory_process');
    Route::post('panel/catalog/deletecategory', [App\Http\Controllers\Admin\PanelCategoryController::class, 'deletecategory'])->name('deletecategory');

    Route::get('panel/catalog/product', [App\Http\Controllers\Admin\PanelProductController::class, 'show_product'])->name('show_product');
    Route::post('panel/catalog/editproduct', [App\Http\Controllers\Admin\PanelProductController::class, 'editproduct'])->name('editproduct');
    Route::post('panel/catalog/modaladdproduct', [App\Http\Controllers\Admin\PanelProductController::class, 'modaladdproduct'])->name('modaladdproduct');
    Route::post('panel/catalog/modaladdproperties', [App\Http\Controllers\Admin\PanelProductController::class, 'modaladdproperties'])->name('modaladdproperties');
    Route::post('panel/catalog/addproduct_process', [App\Http\Controllers\Admin\PanelProductController::class, 'addproduct'])->name('add_productprocess');
    Route::post('panel/catalog/deleteproduct', [App\Http\Controllers\Admin\PanelProductController::class, 'deleteproduct'])->name('deleteproduct');
    Route::post('panel/catalog/saveproduct', [App\Http\Controllers\Admin\PanelProductController::class, 'saveproduct'])->name('saveproduct');
    Route::get('panel/catalog/searchproduct/{param}', [App\Http\Controllers\Admin\PanelProductController::class, 'searchproduct'])->name('searchproduct');

    Route::get('panel/catalog/property', [App\Http\Controllers\Admin\PanelPropertyController::class, 'show_property'])->name('show_property');
    Route::post('panel/catalog/modaladdproperty', [App\Http\Controllers\Admin\PanelPropertyController::class, 'modaladdproperty'])->name('modaladdproperty');
    Route::post('panel/catalog/addproperty_process', [App\Http\Controllers\Admin\PanelPropertyController::class, 'addproperty_process'])->name('addproperty_process');
    Route::post('panel/catalog/editproperty', [App\Http\Controllers\Admin\PanelPropertyController::class, 'editproperty'])->name('editproperty');
    Route::post('panel/catalog/saveproperty', [App\Http\Controllers\Admin\PanelPropertyController::class, 'saveproperty'])->name('saveproperty');
    Route::post('panel/catalog/deleteproperty', [App\Http\Controllers\Admin\PanelPropertyController::class, 'deleteproperty'])->name('deleteproperty');
    Route::get('panel/catalog/searchproperty/{param}', [App\Http\Controllers\Admin\PanelPropertyController::class, 'searchproperty'])->name('searchproperty');

    Route::get('panel/catalog/badge', [App\Http\Controllers\Admin\PanelBadgeController::class, 'show_badge'])->name('show_badge');
    Route::post('panel/catalog/addbadge', [App\Http\Controllers\Admin\PanelBadgeController::class, 'addbadge'])->name('addbadge');
    Route::get('panel/catalog/editbadge/{id}', [App\Http\Controllers\Admin\PanelBadgeController::class, 'editbadge'])->name('editbadge');
    Route::post('panel/catalog/deletebadge', [App\Http\Controllers\Admin\PanelBadgeController::class, 'deletebadge'])->name('deletebadge');
    Route::post('panel/catalog/savebadge', [App\Http\Controllers\Admin\PanelBadgeController::class, 'savebadge'])->name('savebadge');

    Route::get('panel/order/editorder/{id}', [App\Http\Controllers\Admin\PanelOrderController::class, 'editorder'])->name('editorder');
    Route::get('panel/order/search/{search}', [App\Http\Controllers\Admin\PanelOrderController::class, 'searchorder'])->name('searchorder');
    Route::post('panel/order/deletefromorder', [App\Http\Controllers\Admin\PanelOrderController::class, 'deletefromorder'])->name('deletefromorder');
    Route::post('panel/order/deleteorder', [App\Http\Controllers\Admin\PanelOrderController::class, 'deleteorder'])->name('deleteorder');
    Route::post('panel/order/saveorder', [App\Http\Controllers\Admin\PanelOrderController::class, 'saveorder'])->name('saveorder');


    Route::get('panel/user/search/{search}', [App\Http\Controllers\Admin\PanelUserController::class, 'searchuser'])->name('searchuser');


    Route::get('panel/{page}', [App\Http\Controllers\Admin\PanelController::class, 'change_page'])->name('change_page');
});

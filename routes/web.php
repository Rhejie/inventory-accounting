<?php

use App\Http\Controllers\Accounting\ProposalsController;
use App\Http\Controllers\HomeController;
use App\Mail\InvoiceMail;
use App\Mail\ProposalMail;
use App\Models\Accounting\Invoice;
use App\Models\Inventory\FixedAsset;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
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

Route::get('/', 'HomeController@index');

Route::group(['namespace'=>'Dashboard'],function(){
    Route::get('/inventory/dashboard','DashboardController@index')->name('dashboard.index');
});
//PROJECTS





Route::group(['namespace'=>'PointOfSale'],function(){
    Route::get('/point-of-sale/cashier','CashierController@index')->name('cashier.index');
    Route::get('/point-of-sale/kitchen','KitchenController@index')->name('kitchen.index');
    Route::get('/point-of-sale/waiter','WaiterController@index')->name('kitchen.index');
});

Route::group(['namespace'=>'Sale'],function(){

    Route::get('/sale/invoice','InvoiceController@index')->name('invoice.index');

    Route::get('/sale/invoice/details','InvoiceController@invoiceDetails')->name('invoice.details');
    Route::get('/sale/quotation','QuotationController@index')->name('quotation.index');
    Route::get('/sale/void','VoidController@index')->name('void.index');

    Route::get('/sale/daily-sales','SaleController@index')->name('daily-sales.index');
    Route::post('/sale/_load_sales','SaleController@_load_sales')->name('sales.load');
    Route::post('/sale/store','SaleController@store')->name('sales.store');
});

Route::group(['namespace'=>'Product'],function(){
    Route::get('/product/product-category','ProductCategoryController@index')->name('product-category.index');
    Route::get('/product/stock-management','StockManagementController@index')->name('stock-management.index');
    Route::get('/product/stock-adjustment','StockAdjustmentController@index')->name('stock-adjustment.index');
    Route::get('/product/defect-item','DefectItemController@index')->name('defect-item.index');
});

Route::group(['namespace'=>'Customer'],function(){
    Route::get('/customer-list','CustomerController@index')->name('customer.index');
});

Route::group(['namespace'=>'Purchase'],function(){
    Route::get('/purchase/supplier-management','SupplierManagementController@index')->name('supplier-management.index');
    Route::get('/purchase/purchase-order','PurchaseOrderController@index')->name('purchase-order.index');
    Route::get('/purchase/purchase-order/details','PurchaseOrderController@purchaseOrderDetails')->name('purchase-order.details');
    Route::get('/purchase/purchase-received','PurchaseReceivedController@index')->name('purchase-received.index');
    Route::get('/purchase/return-item-to-supplier','ReturnItemToSupplierController@index')->name('return-item-to-supplier.index');
});



Route::group(['namespace'=>'Finance'],function(){
    Route::get('/finance','FinanceController@index')->name('finance.index');
});


Route::group(['namespace'=>'Inventory'],function(){
    Route::get('/inventory/assets/heavy/equipment','HeavyEquipmentController@index')->name('equipment.index');
    Route::get('/inventory/categories/types','TypesController@index')->name('type.index');
    Route::get('/inventory/types/list','TypesController@showList')->name('type.list');
    Route::post('/inventory/add/type','TypesController@addTypes')->name('types.store');
    //category
    Route::get('/inventory/categories','CategoryController@index')->name('category.index');
    Route::post('/inventory/add/category','CategoryController@addCategory')->name('category.store');
    Route::get('/inventory/category/list','CategoryController@showList')->name('category.list');

    //heavy equipment
    Route::get('/inventory/equipment/list','HeavyEquipmentController@showList')->name('equipment.list');
    Route::post('/inventory/add/equipment','HeavyEquipmentController@addEquipment')->name('equipment.store');
    Route::get('/inventory/heavy/equipment/{id}','HeavyEquipmentController@displayEquipment')->name('equipment.display');
    Route::get('/inventory/equipment/documents/{id}','EquipmentDocumentController@displayDocuments');
     Route::post('/inventory/add/documents','EquipmentDocumentController@addDocument')->name('document.store');

    //  FIXED ASSETS
     Route::get('inventory/assets/fixed/assets','FixedAssetController@index')->name('fixed.index');
     Route::get('inventory/assets/fixed/assets/list','FixedAssetController@showList')->name('fixed.showList');

    //  VEHICLE
     Route::get('inventory/assets/vehicles','VehicleController@index')->name('vehicle.index');
     Route::get('inventory/assets/vehicles/list','VehicleController@showList')->name('vehicle.list');
     Route::post('inventory/assets/add/vehicle','VehicleController@addVehicle')->name('vehicle.store');
     Route::get('inventory/assets/vehicles/{id}','VehicleController@displayVehicle')->name('vehicle.display');

    //  OTHERS
    Route::get('inventory/assets/others','OtherAssetsController@index')->name('others.index');
    Route::get('inventory/assets/others/list','OtherAssetsController@showList')->name('others.list');
    Route::post('inventory/assets/others','OtherAssetsController@addOthers')->name('others.store');
    Route::get('inventory/assets/others/{id}','OtherAssetsController@displayOthers')->name('others.display');

});



//pages converted from interns
 Route::get('/pages/budget/vs/actual','HomeController@budgetVsActual');
  Route::get('/pages/income/vs/expense','HomeController@incomeVsExpense');
   Route::get('/pages/tools','HomeController@tools');
   Route::get('/pages/budget/variance','HomeController@budgetVariance');
   Route::get('/pages/bills/materials','HomeController@billsOfMaterials');
   Route::get('/pages/canvass','HomeController@canvass');




// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Project Routes
    require_once base_path('routes/ModuleRoutes/project.php');
    // End Project Routes

    // Fixed Assets Inventory Routes
    require_once base_path('routes/ModuleRoutes/heavy-equipment.php');
    require_once base_path('routes/ModuleRoutes/truck-vehicle.php');
    require_once base_path('routes/ModuleRoutes/other-inventory.php');
    require_once base_path('routes/ModuleRoutes/fixed-assets.php');
    require_once base_path('routes/ModuleRoutes/type-inventory.php');
    require_once base_path('routes/ModuleRoutes/category-inventory.php');
    require_once base_path('routes/ModuleRoutes/consumable-supply.php');
    // End Fixed Assets Inventory Routes

    // purchase
    require_once base_path('routes/ModuleRoutes/supplier-management.php');
    require_once base_path('routes/ModuleRoutes/consumable-item.php');
    require_once base_path('routes/ModuleRoutes/purchase-order.php');
    require_once base_path('routes/ModuleRoutes/purchase-recieved.php');

    // stock out
    require_once base_path('routes/ModuleRoutes/asset-stock-out.php');
    require_once base_path('routes/ModuleRoutes/supply-stock-out.php');

    // Request Material
    require_once base_path('routes/ModuleRoutes/request-material.php');

    // General Setting
    require_once base_path('routes/ModuleRoutes/setting.php');

    require_once base_path('routes/AccountingRoutes/home.php');

    require_once base_path('routes/ModuleRoutes/bill-of-material.php');

    require_once base_path('routes/AccountingRoutes/services.php');
    require_once base_path('routes/AccountingRoutes/customer.php');
    require_once base_path('routes/AccountingRoutes/proposal.php');
    require_once base_path('routes/AccountingRoutes/invoice.php');
    require_once base_path('routes/AccountingRoutes/constant.php');
    require_once base_path('routes/AccountingRoutes/credit-note.php');
    require_once base_path('routes/AccountingRoutes/bank-account.php');
    require_once base_path('routes/AccountingRoutes/invoice-payment.php');
    require_once base_path('routes/AccountingRoutes/revenue.php');
    require_once base_path('routes/AccountingRoutes/bill.php');
    require_once base_path('routes/AccountingRoutes/bill-payment.php');
    require_once base_path('routes/AccountingRoutes/debit-note.php');
    require_once base_path('routes/AccountingRoutes/payment.php');
    require_once base_path('routes/AccountingRoutes/attachment.php');


});


Route::get('/generate-pdf', [ProposalsController::class, 'generatePdf']);

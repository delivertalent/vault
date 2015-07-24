<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::filter('designerFilter', function()
{
    if (Session::get('sessionRoleid')== 1)
    {
        return Redirect::to('/admin/dashboard');
    }

    if (Session::get('sessionRoleid')== 3)
    {
        return Redirect::to('/manager/manager-dashboard');
    }    
});

Route::get('/email-alerts', array('as' => 'email-alerts', 'uses' => 'EmailAlertsController@emailAlarts'));
//============================== AUTH =================================//
Route::get('/login', array('as' => 'login', 'uses' => 'AuthController@loginview'));
Route::post('auth/login', array('uses' => 'AuthController@loginuser'));
Route::post('auth/forget', array('uses' => 'AuthController@forgetPass'));
Route::get('/logout', array('uses'=> 'AuthController@logoutuser'));
Route::post('reset-pass', array('uses'=> 'AuthController@forgetPass'));
Route::post('setPassword', array('as' => 'setPassword', 'uses'=> 'AuthController@setPassword'));
Route::get('update-password/{id}', array('as' =>'update-password' , 'uses' => 'AuthController@updatePassword' ));
//=========================== End of AUTH =============================//

//============================== Designer =============================//
Route::get('/', array('as' => 'auth', 'before' => 'auth|designerFilter', 'uses' => 'HomeController@showWelcome'));
Route::post('/update-status', array('as' => 'update-status', 'before' => 'auth', 'uses' => 'HomeController@updateStatus'));
Route::post('/update-profile', array('as' => 'update-profile', 'before' => 'auth', 'uses' => 'HomeController@updateProfile'));
Route::get('/profile', array('as' => 'profile', 'before' => 'auth', 'uses' => 'HomeController@userProfile'));
Route::get('/additional-designer', array('as' => 'additional-designer', 'before' => 'auth', 'uses' => 'HomeController@additionalDesigner'));
Route::post('/save-additional-designer', array('as' => 'save-additional-designer', 'before' => 'auth', 'uses' => 'HomeController@saveAdditionalDesigner'));
Route::get('get-additional-designer', array('as' =>'get-additional-designer' , 'before' => 'auth', 'uses' => 'HomeController@getAdditionalDesigner' ));	
Route::delete('delete-additional-designer', array('as' =>'delete-additional-designer' , 'before' => 'auth', 'uses' => 'HomeController@deleteAdditionalDesigner' ));	
//=========================== End of Designer =========================//


//=============================== Customer ==================================//
Route::get('/customers', array('as' => 'customers', 'before' => 'auth', 'uses' => 'CustomerController@customerList'));
Route::post('/save-customers', array('as' => 'save-customers', 'before' => 'auth', 'uses' => 'CustomerController@saveCustomer'));
Route::get('/get-customers', array('as' => 'get-customers', 'before' => 'auth', 'uses' => 'CustomerController@getCustomer'));
Route::delete('delete-customers', array('as' =>'delete-customers' , 'before' => 'auth', 'uses' => 'CustomerController@deleteCustomer' ));	
Route::get('/customer-details/{id}', array('as' => 'customer-details', 'before' => 'auth', 'uses' => 'CustomerController@detailCustomer'));
Route::get('get_customerList', array('as' =>'get_customerList' , 'before' => 'auth', 'uses' => 'JobController@get_customer' ))->before('auth');
Route::get('get-lastname-email', array('as' =>'get-lastname-email' , 'before' => 'auth', 'uses' => 'JobController@get_namePhone' ))->before('auth');
//============================== End of Clients =============================//

//================================= Jobs =================================//
Route::get('/jobs', array('as' => 'jobs', 'before' => 'auth', 'uses' => 'JobController@jobList'));
Route::post('/save-job', array('as' => 'save-job', 'before' => 'auth', 'uses' => 'JobController@saveJob'));
Route::get('/get-job', array('as' => 'get-job', 'before' => 'auth', 'uses' => 'JobController@getJob'));
Route::delete('delete-job', array('as' =>'delete-job' , 'before' => 'auth', 'uses' => 'JobController@deleteJob' ));	
Route::get('job-details/{id}/{designerID}', array('as' =>'job-details' , 'before' => 'auth', 'uses' => 'JobController@jobDetails' ));
Route::get('details-inventory/{id}', array('as' =>'details-inventory' , 'before' => 'auth', 'uses' => 'InventoriesController@inventoryDetails' ));
Route::get('designer-inventories', array('as' =>'designer-inventories' , 'before' => 'auth', 'uses' => 'InventoriesController@designerInventory' ));
Route::get('search-inventory', array('as' =>'search-inventory' , 'before' => 'auth', 'uses' => 'InventoriesController@searchInventory' ));

Route::post('/send-inventory-email', array('as' => 'send-inventory-email', 'before' => 'auth', 'uses' => 'InventoriesController@sendInventoryEmail'));
Route::get('designer-damage-inventories', array('as' =>'designer-damage-inventories' , 'before' => 'auth', 'uses' => 'InventoriesController@designerDamageInventory' ));
//============================== End of Jobs =============================//

//================================= Workorder =================================//
Route::get('/workorders', array('as' => 'workorders', 'before' => 'auth', 'uses' => 'WorkordersController@workorders'));
Route::get('/workorders-form', array('as' => 'workorders-form', 'before' => 'auth', 'uses' => 'WorkordersController@workordersForm'));


Route::get('/inventory-list', array('as' => 'inventory-list', 'before' => 'auth', 'uses' => 'WorkordersController@inventorylist'));
Route::post('/create-workorder', array('as' => 'create-workorder', 'before' => 'auth', 'uses' => 'WorkordersController@saveWorkorder'));
Route::get('/workorder-details/{id}', array('as' => 'workorder-details', 'before' => 'auth', 'uses' => 'WorkordersController@workorderDetails'));
Route::post('/update-workorder', array('as' => 'update-workorder', 'before' => 'auth', 'uses' => 'WorkordersController@updateWorkorder'));
//============================== End of Workorder =============================//
//============================== Prefix Manager composer dump-autoload =============================//
Route::filter('managerFilter', function()
{
    if (Session::get('sessionRoleid')== 1)
    {
        return Redirect::to('/admin/dashboard');
    }

    if (Session::get('sessionRoleid')== 2)
    {
        return Redirect::to('/');
    }    
});

Route::group(array('prefix' => 'manager'), function()
{
	Route::get('manager-dashboard', array('as' =>'manager-dashboard' , 'before' => 'auth|managerFilter', 'uses' => 'ManagersController@dashboard' ));
	Route::get('/manager-inventories', array('as' => 'manager-inventories', 'before' => 'auth|managerFilter', 'uses' => 'ManagersController@inventories'));
	Route::get('/search-inventory-manager', array('as' => 'search-inventory-manager', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@searchInventoryManager'));	
	Route::get('/manager-inventory-details/{id}', array('as' => 'manager-inventory-details', 'before' => 'auth|managerFilter', 'uses' => 'ManagersController@getInventory'));
	Route::post('/manager-add-inventory', array('as' => 'manager-add-inventory', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@saveInventory'));
	Route::get('/manager-damaged-inventories', array('as' => 'manager-damaged-inventories', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@damagedInventories'));
	Route::delete('/manager-delete-images', array('as' => 'manager-delete-images', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@deleteImages'));
	Route::delete('/manager-delete-inventories', array('as' => 'manager-delete-inventories', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@deleteInventory'));
	Route::post('/manager-inventory-jobid-update', array('as' => 'manager-inventory-jobid-update', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@inventoryJobidUpdate'));


	Route::get('manager-get-warehousebin', array('as' =>'manager-get-warehousebin', 'before' => 'auth|managerFilter', 'uses' => 'BinsController@warehousebinList' ));
	Route::get('manager-get-binlrtlist', array('as' =>'manager-get-binlrtlist', 'before' => 'auth|managerFilter', 'uses' => 'BinlrtsController@binBinLrt' ));
	Route::post('/manager-create-qr', array('as' => 'manager-create-qr', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@createQr'));

	Route::get('/manager-get-joblist', array('as' => 'manager-get-joblist', 'before' => 'auth|managerFilter', 'uses' => 'JobController@getJobList'));

	Route::get('/manager-workorders', array('as' => 'manager-workorders', 'before' => 'auth|managerFilter', 'uses' => 'WorkordersController@managerWorkorders'));
	Route::get('/manager-workorder-details/{id}', array('as' => 'manager-workorder-details', 'before' => 'auth|managerFilter', 'uses' => 'WorkordersController@managerWorkorderDetails'));
	
	Route::post('manager-update-workorder', array('as' => 'manager-update-workorder', 'before' => 'auth|managerFilter', 'uses' => 'WorkordersController@updateWorkorder'));
	
	Route::post('update-delivery-status', array('as' => 'update-delivery-status', 'before' => 'auth|managerFilter', 'uses' => 'InventoriesController@updateDeliveryStatus'));

});
//============================== End of Prefix Manager =============================//

//============================== Prefix Admin composer dump-autoload =============================//
Route::filter('adminFilter', function()
{
    if (Session::get('sessionRoleid')== 2)
    {
        return Redirect::to('/');
    }
    if (Session::get('sessionRoleid')== 3)
    {
        return Redirect::to('/manager/manager-dashboard');
    }    

});


Route::group(array('prefix' => 'admin'), function()
{
	Route::get('dashboard', array('as' =>'dashboard' , 'before' => 'auth|adminFilter', 'uses' => 'DashboardsController@indexview' ));	
	Route::get('designer', array('as' =>'designer' , 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@index' ));	
	Route::post('save-designer', array('as' =>'save-designer' , 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@addDesigner' ));	
	Route::get('/get-designer', array('as' => 'get-designer', 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@getDesigner'));
	Route::delete('delete-designer', array('as' =>'delete-designer' , 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@deleteDesigner' ));	
	Route::get('client-details/{id}', array('as' =>'client-details' , 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@detailDesigner' ));	
	Route::get('/get-lead-designer', array('as' => 'get-lead-designer', 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@leadDesignerList'));
	Route::get('/admin-additional-designer/{id}', array('as' => 'admin-additional-designer', 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@adminAdditionalDesigner'));
	Route::post('/resent-activation-email', array('as' => 'resent-activation-email', 'before' => 'auth|adminFilter', 'uses' => 'DesignersController@resentActivationEmail'));

	

	Route::post('/admin-save-job', array('as' => 'admin-save-job', 'before' => 'auth|adminFilter', 'uses' => 'JobController@saveJob'));
	Route::get('/admin-get-job', array('as' => 'admin-get-job', 'before' => 'auth|adminFilter', 'uses' => 'JobController@getJob'));
	Route::get('/get-joblist', array('as' => 'get-joblist', 'before' => 'auth|adminFilter', 'uses' => 'JobController@getJobList'));
	Route::get('/admin-get-customerList', array('as' => 'admin-get-customerList', 'before' => 'auth|adminFilter', 'uses' => 'JobController@admin_get_customer'));
	Route::delete('admin-delete-job', array('as' =>'admin-delete-job' , 'before' => 'auth|adminFilter', 'uses' => 'JobController@deleteJob' ));	
//================================= Job Inventory =================================//
	Route::get('job-inventory/{id}/{designerID}', array('as' =>'job-inventory' , 'before' => 'auth|adminFilter', 'uses' => 'JobinventoryController@jobDetails' ));
	Route::get('/admin-jobs', array('as' => 'admin-jobs', 'before' => 'auth', 'uses' => 'AdminjobController@adminjobList'));
	Route::get('/get-jobList', array('as' => 'get-jobList', 'before' => 'auth|adminFilter', 'uses' => 'AdminjobController@clientJobList'));

//================================= End of Job Inventory ==========================//	
	Route::get('warehouse-manager', array('as' =>'warehouse-manager' , 'before' => 'auth|adminFilter', 'uses' => 'ManagersController@managerList' ));
	Route::post('save-manager', array('as' =>'save-manager' , 'before' => 'auth|adminFilter', 'uses' => 'ManagersController@savemanager' ));
//================================= Warehouse Manager ==========================//	


//============================End of Warehouse Manager =========================//

//================================= Inventory =================================//
	Route::get('/inventories', array('as' => 'inventories', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@inventories'));	
	Route::get('/search-inventory-admin', array('as' => 'search-inventory-admin', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@searchInventoryAdmin'));	
	Route::get('/damaged-inventories', array('as' => 'damaged-inventories', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@damagedInventories'));	
	Route::post('/add-inventory', array('as' => 'add-inventory', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@saveInventory'));	
	Route::get('/inventory-details/{id}', array('as' => 'inventory-details', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@getInventory'));
	Route::post('/create-qr', array('as' => 'create-qr', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@createQr'));	
	Route::delete('/admin-delete-images', array('as' => 'admin-delete-images', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@deleteImages'));	
	Route::delete('/admin-delete-inventories', array('as' => 'admin-delete-inventories', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@deleteInventory'));	
	Route::post('/inventory-jobid-update', array('as' => 'inventory-jobid-update', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@inventoryJobidUpdate'));	
	Route::get('/print-inventory-details/{id}', array('as' => 'print-inventory-details', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@printInventory'));
	Route::post('/inventory-inline-update', array('as' => 'inventory-inline-update', 'before' => 'auth|adminFilter', 'uses' => 'InventoriesController@inventoryInlineUpdate'));

//================================= End of Inventory ==========================//

//================================= Admin Work Order =================================//
Route::get('/admin-workorders', array('as' => 'admin-workorders', 'before' => 'auth|adminFilter', 'uses' => 'WorkordersController@adminWorkorders'));
Route::get('/admin-closed-workorders', array('as' => 'admin-closed-workorders', 'before' => 'auth|adminFilter', 'uses' => 'WorkordersController@adminClosedWorkorders'));
Route::get('/inventory-list', array('as' => 'inventory-list', 'before' => 'auth|adminFilter', 'uses' => 'WorkordersController@inventorylist'));
Route::post('/admin-create-workorder', array('as' => 'admin-create-workorder', 'before' => 'auth|adminFilter', 'uses' => 'WorkordersController@saveWorkorder'));
Route::get('/admin-workorder-details/{id}', array('as' => 'admin-workorder-details', 'before' => 'auth|adminFilter', 'uses' => 'WorkordersController@adminWorkorderDetails'));
Route::post('admin-update-workorder', array('as' => 'admin-update-workorder', 'before' => 'auth|adminFilter', 'uses' => 'WorkordersController@updateWorkorder'));	
//============================== End of Admin Work Order =============================//	
	
//================================= Manufacturers =================================//
	Route::get('manufacturers', array('as' =>'manufacturers' , 'before' => 'auth|adminFilter', 'uses' => 'ManufacturerController@manufacturerList' ));
	Route::post('save-manufacturer', array('as' =>'save-manufacturer' , 'before' => 'auth|adminFilter', 'uses' => 'ManufacturerController@saveManufacturer' ));	
	Route::get('/get-manufacturer', array('as' => 'get-manufacturer', 'before' => 'auth|adminFilter', 'uses' => 'ManufacturerController@getManufacturer'));
	Route::delete('delete-manufacturer', array('as' =>'delete-manufacturer' , 'before' => 'auth|adminFilter', 'uses' => 'ManufacturerController@deleteManufacturer' ));	
	Route::get('manufacturers-inline', array('as' =>'manufacturers-inline' , 'before' => 'auth|adminFilter', 'uses' => 'ManufacturerController@manufacturerInline' ));		
//================================= End of Manufacturers =================================//

//================================= Carrier =================================//
	Route::get('carriers', array('as' =>'carriers' , 'before' => 'auth|adminFilter', 'uses' => 'CarriersController@carrierList' ));
	Route::post('save-carrier', array('as' =>'save-carrier' , 'before' => 'auth|adminFilter', 'uses' => 'CarriersController@saveCarrier' ));	
	Route::get('/get-carrier', array('as' => 'get-carrier', 'before' => 'auth|adminFilter', 'uses' => 'CarriersController@getCarrier'));
	Route::delete('delete-carrier', array('as' =>'delete-carrier' , 'before' => 'auth|adminFilter', 'uses' => 'CarriersController@deleteCarrier' ));			
//================================= End of Carrier =================================//

//================================= Storage =================================//
	Route::get('storage', array('as' =>'storage' , 'before' => 'auth|adminFilter', 'uses' => 'StoragepriceController@storageIndex' ));
	Route::get('storage-price', array('as' =>'storage-price' , 'before' => 'auth|adminFilter', 'uses' => 'StoragepriceController@storagePriceList' ));
	Route::post('save-storage-price', array('as' =>'save-storage-price' , 'before' => 'auth|adminFilter', 'uses' => 'StoragepriceController@saveStoragePrice' ));	
	Route::get('/get-storage-price', array('as' => 'get-storage-price', 'before' => 'auth|adminFilter', 'uses' => 'StoragepriceController@getStoragePrice'));
	Route::delete('delete-storage-price', array('as' =>'delete-storage-price' , 'before' => 'auth|adminFilter', 'uses' => 'StoragepriceController@deleteStoragePrice' ));	
	Route::get('export-report', array('as' =>'export-report' , 'before' => 'auth|adminFilter', 'uses' => 'StoragepriceController@exportReport' ));		
//================================= End of Carrier =================================//

//================================= advertise =================================//
	Route::get('advertise', array('as' =>'advertise' , 'before' => 'auth|adminFilter', 'uses' => 'AdvertiseController@advertiseList' ));
	Route::post('save-advertise', array('as' =>'save-advertise' , 'before' => 'auth|adminFilter', 'uses' => 'AdvertiseController@saveAdvertise' ));	
	Route::get('/get-advertise', array('as' => 'get-advertise', 'before' => 'auth|adminFilter', 'uses' => 'AdvertiseController@advertiseList'));
	Route::delete('delete-advertise', array('as' =>'delete-advertise' , 'before' => 'auth|adminFilter', 'uses' => 'AdvertiseController@deleteAdvertise' ));			
//================================= End of Carrier =================================//


//================================= InventoryCategory =================================//
	Route::get('inventorycategory', array('as' =>'inventorycategory' , 'before' => 'auth|adminFilter', 'uses' => 'InventorycategoryController@inventorycategoryList' ));
	Route::post('save-inventorycategory', array('as' =>'save-inventorycategory' , 'before' => 'auth|adminFilter', 'uses' => 'InventorycategoryController@saveInventorycategory' ));	
	Route::get('/get-inventorycategory', array('as' => 'get-inventorycategory', 'before' => 'auth|adminFilter', 'uses' => 'InventorycategoryController@getInventorycategory'));
	Route::delete('delete-inventorycategory', array('as' =>'delete-inventorycategory' , 'before' => 'auth|adminFilter', 'uses' => 'InventorycategoryController@deleteInventorycategory' ));	
	Route::get('inventorycategory-inline', array('as' =>'inventorycategory-inline' , 'before' => 'auth|adminFilter', 'uses' => 'InventorycategoryController@inventorycategoryInline' ));		
//========================== End of InventoryCategory =================================//

//================================= ItemdescriptionsCategory =================================//
	Route::get('itemdescription', array('as' =>'itemdescription' , 'before' => 'auth|adminFilter', 'uses' => 'ItemdescriptionsController@itemdescriptionList' ));
	Route::post('save-itemdescription', array('as' =>'save-itemdescription' , 'before' => 'auth|adminFilter', 'uses' => 'ItemdescriptionsController@saveItemdescription' ));	
	Route::get('/get-itemdescription', array('as' => 'get-itemdescription', 'before' => 'auth|adminFilter', 'uses' => 'ItemdescriptionsController@getItemdescription'));
	Route::delete('delete-itemdescription', array('as' =>'delete-itemdescription' , 'before' => 'auth|adminFilter', 'uses' => 'ItemdescriptionsController@deleteItemdescription' ));
	Route::get('itemdescription-inline', array('as' =>'itemdescription-inline' , 'before' => 'auth|adminFilte', 'uses' => 'ItemdescriptionsController@itemdescriptionInline' ));			
//========================== End of ItemdescriptionsCategory =================================//

//================================= RoomsController =================================//
	Route::get('room', array('as' =>'room' , 'before' => 'auth|adminFilter', 'uses' => 'RoomsController@roomList' ));
	Route::post('save-room', array('as' =>'save-room' , 'before' => 'auth|adminFilter', 'uses' => 'RoomsController@saveRoom' ));	
	Route::get('/get-room', array('as' => 'get-room', 'before' => 'auth|adminFilter', 'uses' => 'RoomsController@getRoom'));
	Route::delete('delete-room', array('as' =>'delete-room' , 'before' => 'auth|adminFilter', 'uses' => 'RoomsController@deleteRoom' ));
	Route::get('room-inline', array('as' =>'room-inline' , 'before' => 'auth|adminFilter', 'uses' => 'RoomsController@roomInline' ));			
//========================== End of RoomsController =================================//

//================================= WarehouseLocation =================================//
	Route::get('warehouselocations', array('as' =>'warehouselocations' , 'before' => 'auth|adminFilter', 'uses' => 'WarehouseLocationController@warehouselocationList' ));
	Route::post('save-warehouselocation', array('as' =>'save-warehouselocation' , 'before' => 'auth|adminFilter', 'uses' => 'WarehouseLocationController@saveWarehouseLocation' ));	
	Route::get('/get-warehouselocation', array('as' => 'get-warehouselocation', 'before' => 'auth|adminFilter', 'uses' => 'WarehouseLocationController@getWarehouseLocation'));
	Route::delete('delete-warehouselocation', array('as' =>'delete-warehouselocation' , 'before' => 'auth|adminFilter', 'uses' => 'WarehouseLocationController@deleteWarehouseLocation' ));			
//========================== End of WarehouseLocation =================================//

//================================= Warehouse =================================//
	Route::get('warehouses', array('as' =>'warehouses' , 'before' => 'auth|adminFilter', 'uses' => 'WarehousesController@warehoueList' ));
	Route::post('save-warehouse', array('as' =>'save-warehouse' , 'before' => 'auth|adminFilter', 'uses' => 'WarehousesController@saveWarehoue' ));	
	Route::get('/get-warehouse', array('as' => 'get-warehouse', 'before' => 'auth|adminFilter', 'uses' => 'WarehousesController@getWarehoue'));
	Route::delete('delete-warehouse', array('as' =>'delete-warehouse' , 'before' => 'auth|adminFilter', 'uses' => 'WarehousesController@deleteWarehoue' ));			
//============================== End of Warehouse ============================//


//================================= Bin =================================//
	Route::get('bins', array('as' =>'bins' , 'before' => 'auth|adminFilter', 'uses' => 'BinsController@binList' ));
	Route::post('save-bin', array('as' =>'save-bin' , 'before' => 'auth|adminFilter', 'uses' => 'BinsController@saveBin' ));	
	Route::get('/get-bin', array('as' => 'get-bin', 'before' => 'auth|adminFilter', 'uses' => 'BinsController@getBin'));
	Route::delete('delete-bin', array('as' =>'delete-bin' , 'before' => 'auth|adminFilter', 'uses' => 'BinsController@deleteBin' ));
	Route::get('get-warehousebin', array('as' =>'get-warehousebin', 'before' => 'auth|adminFilter', 'uses' => 'BinsController@warehousebinList' ));			
//============================== End of Bin ============================//

//================================= Binlrts =================================//
	Route::get('binlrts', array('as' =>'binlrts' , 'before' => 'auth|adminFilter', 'uses' => 'BinlrtsController@binlrtList' ));
	Route::post('save-binlrt', array('as' =>'save-binlrt' , 'before' => 'auth|adminFilter', 'uses' => 'BinlrtsController@saveBinlrt' ));	
	Route::get('/get-binlrt', array('as' => 'get-binlrt', 'before' => 'auth|adminFilter', 'uses' => 'BinlrtsController@getBinlrt'));
	Route::delete('delete-binlrt', array('as' =>'delete-binlrt' , 'before' => 'auth|adminFilter', 'uses' => 'BinlrtsController@deleteBinlrt' ));		
	Route::get('get-binlrtlist', array('as' =>'get-binlrtlist', 'before' => 'auth|adminFilter', 'uses' => 'BinlrtsController@binBinLrt' ));
//============================== End of Binlrts ============================//

	
});
//=========================== End of Prefix Admin =========================//
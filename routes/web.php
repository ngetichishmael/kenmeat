<?php

use App\Http\Controllers\Api\TestingController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\SocketsController;
use App\Http\Controllers\SupportTicketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin.php';
require __DIR__ . '/others.php';

Route::get('/', 'Auth\LoginController@showLoginForm')->name('home.page');
Route::get('/privacy-policy', 'PrivacyController@index');
Route::get('sokoflowadmin', 'Auth\LoginController@showLoginForm');
Route::get('signup', 'Auth\RegisterController@signup_form')->name('signup.page');
Route::post('signup/account', 'Auth\RegisterController@signup')->name('signup');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('api/tests', [TestingController::class, 'test']);
Route::get('getMarkers/${userCode}', [CurrentDeviceInformationController::class, "getUserCoordinates"])->name('getUserCoordinates');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['verified']], function () {
    Route::get('dashboard', 'app\sokoflowController@dashboard')->name('app.dashboard');
    Route::get('dashboard/users-summary', 'app\sokoflowController@user_summary')->name('app.dashboard.user.summary');

    Route::resource('regions', Territory\RegionController::class)->names([
        'index' => 'regions',
        'show' => 'regions.show',
        'edit' => 'regions.edit',
        'update' => 'regions.update',
        'destroy' => 'regions.destroy',
        'create' => 'regions.create',
        'store' => 'regions.store',
    ]);
    Route::resource('subregions', Territory\SubRegionController::class)->names([
        'index' => 'subregions',
        'show' => 'subregions.show',
        'edit' => 'subregions.edit',
        'update' => 'subregions.update',
        'destroy' => 'subregions.destroy',
        'create' => 'subregions.create',
        'store' => 'subregions.store',
    ]);
    Route::resource('areas', AreaController::class)->names([
        'index' => 'areas',
        'show' => 'areas.show',
        'edit' => 'areas.edit',
        'update' => 'areas.update',
        'destroy' => 'areas.destroy',
        'create' => 'areas.create',
        'store' => 'areas.store',
    ]);
    Route::resource('subareas', SubareaController::class)->names([
        'index' => 'subareas',
        'show' => 'subareas.show',
        'edit' => 'subareas.edit',
        'update' => 'subareas.update',
        'destroy' => 'subareas.destroy',
        'create' => 'subareas.create',
        'store' => 'subareas.store',
    ]);
    Route::resource('zones', Territory\ZoneController::class)->names([
        'index' => 'zones',
        'show' => 'zones.show',
        'edit' => 'zones.edit',
        'update' => 'zones.update',
        'destroy' => 'zones.destroy',
        'create' => 'zones.create',
        'store' => 'zones.store',
    ]);
    Route::resource('units', UnitController::class)->names([
        'index' => 'units',
        'show' => 'units.show',
        'edit' => 'units.edit',
        'update' => 'units.update',
        'destroy' => 'units.destroy',
        'create' => 'units.create',
        'store' => 'units.store',
    ]);
    Route::resource('customer', app\customer\customerController::class)->names([
        'index' => 'customer',
        'show' => 'customer.show',
        'edit' => 'customer.edit',
        'update' => 'customer.update',
        'destroy' => 'customer.destroy',
        'store' => 'customer.store',
    ]);
    Route::get('creditors', ['uses' => 'app\customer\customerController@creditor', 'as' => 'creditors']);
    Route::get('customer/allocations/{customerid}', ['uses' => 'app\customer\customerController@allocations', 'as' => 'customer.allocations']);
    Route::get('approveCreditors', ['uses' => 'app\customer\customerController@approveCreditors', 'as' => 'approveCreditors']);
    Route::get('creditors/pending', ['uses' => 'app\customer\customerController@pendingcreditor', 'as' => 'pending.creditors']);
    Route::get('creditor/create', ['uses' => 'app\customer\customerController@createcreditor', 'as' => 'creditor.create']);
    Route::get('creditor/{id}/edit', ['uses' => 'app\customer\customerController@editcreditor', 'as' => 'creditor.edit']);
    Route::get('customer/{id}/details', ['uses' => 'app\customer\customerController@details', 'as' => 'creditor.details']);
    Route::get('creditor/{id}/details', ['uses' => 'app\customer\customerController@creditordetails', 'as' => 'creditors.details']);
    Route::post('creditor/{id}/update', ['uses' => 'app\customer\customerController@updatecreditor', 'as' => 'creditor.update']);
    Route::post('creditor/store', ['uses' => 'app\customer\customerController@storecreditor', 'as' => 'creditor.store']);
    Route::get('creditor/{id}/approve', ['uses' => 'app\customer\customerController@approvecreditor', 'as' => 'creditor.approve']);
    /* === customer checkin === */
    Route::get('customer/checkins', ['uses' => 'app\customer\checkinController@index', 'as' => 'customer.checkin.index']);

    //import customer

    // Route::get('user-import', ['uses' => 'app\customer\importController@index', 'as' => 'user-import.index']);
    // Route::post('user-import/store', ['uses' => 'app\customer\importController@store', 'as' => 'user-import.store']);
    // Route::get('user-import/{id}/edit', ['uses' => 'app\customer\importController@edit', 'as' => 'user-import.edit']);
    // Route::post('user-import/{id}/update', ['uses' => 'app\customer\importController@update', 'as' => 'user-import.update']);
    // Route::get('user-import/{id}/delete', ['uses' => 'app\customer\importController@delete', 'as' => 'user-import.delete']);
    Route::resource('user-import', importController::class)->names([
        'index' => 'user-import',
        'show' => 'user-import.show',
        'edit' => 'user-import.edit',
        'update' => 'user-import.update',
        'destroy' => 'user-import.destroy',
        'create' => 'user-import.create',
        'store' => 'user-import.store',
    ]);
    Route::resource('customer-import', importController::class)->names([
        'index' => 'user-import',
        'show' => 'user-import.show',
        'edit' => 'user-import.edit',
        'update' => 'user-import.update',
        'destroy' => 'user-import.destroy',
        'create' => 'user-import.create',
        'store' => 'user-import.store',
    ]);
    Route::get('supplier/import', ['uses' => 'app\supplier\ImportController@index', 'as' => 'supplier.import.index']);
    Route::post('supplier/post/import', ['uses' => 'app\supplier\ImportController@import', 'as' => 'supplier.import']);
    //customer category
    Route::resource('customer/catergory', app\customer\groupsController::class)->names([
        'index' => 'CustomerCategory',
        'show' => 'CustomerCategory.show',
        'edit' => 'CustomerCategory.edit',
        'update' => 'CustomerCategory.update',
        'destroy' => 'CustomerCategory.destroy',
        'create' => 'CustomerCategory.create',
        'store' => 'CustomerCategory.store',
    ]);

    /* === supplier === */
    Route::resource('warehousing/supplier', app\supplier\supplierController::class)->names([
        'index' => 'supplier',
        'show' => 'supplier.show',
        'edit' => 'supplier.edit',
        'destroy' => 'supplier.delete',
        'create' => 'supplier.create',
        'store' => 'supplier.store',
    ]);

    Route::get('supplier/{id}/delete', ['uses' => 'app\supplier\supplierController@delete', 'as' => 'supplier.destroy']);
    // Route::get('supplier/create', ['uses' => 'app\supplier\supplierController@create', 'as' => 'supplier.create']);
    Route::post('warehousing/update/{id}', ['uses' => 'app\supplier\supplierController@update', 'as' => 'supplier.update']);
    // Route::get('supplier/{id}/edit', ['uses' => 'app\supplier\supplierController@edit', 'as' => 'supplier.edit']);
    // Route::post('supplier/{id}/update', ['uses' => 'app\supplier\supplierController@update', 'as' => 'supplier.update']);
    // Route::get('supplier/{id}/show', ['uses' => 'app\supplier\supplierController@show', 'as' => 'supplier.show']);
    Route::get('supplier/{id}/archive', ['uses' => 'app\supplier\supplierController@archive', 'as' => 'supplier.archive']);
    Route::get('supplier/{id}/activate', ['uses' => 'app\supplier\supplierController@activate', 'as' => 'supplier.activate']);
    Route::get('supplier/archive/view', ['uses' => 'app\supplier\supplierController@archiveView', 'as' => 'supplier.archive.view']);

    // Route::get('delete-supplier-person/{id}', ['uses' => 'app\supplier\supplierController@delete_contact_person', 'as' => 'supplier.vendor.person']);
    // Route::get('supplier/{id}/trash', ['uses' => 'app\supplier\supplierController@trash', 'as' => 'vendor.trash.update']);
    // Route::get('supplier/download/import/sample/', ['uses' => 'app\supplier\ImportController@download_import_sample', 'as' => 'supplier.download.sample.import']);

    //supplier category
    Route::get('supplier/category', ['uses' => 'app\supplier\groupsController@index', 'as' => 'supplier.category.index']);
    Route::post('supplier/category/store', ['uses' => 'app\supplier\groupsController@store', 'as' => 'supplier.category.store']);
    Route::get('supplier/category/{id}/edit', ['uses' => 'app\supplier\groupsController@edit', 'as' => 'supplier.category.edit']);
    Route::post('supplier/category/{id}/update', ['uses' => 'app\supplier\groupsController@update', 'as' => 'supplier.category.update']);
    Route::get('supplier/category/{id}/delete', ['uses' => 'app\supplier\groupsController@delete', 'as' => 'supplier.category.delete']);

    //import
    Route::get('supplier/import', ['uses' => 'app\supplier\importController@index', 'as' => 'supplier.import.index']);
    // Route::get('supplier/import', [app\supplier\importController::class, 'index'])->name('supplier.import.index');
    Route::post('supplier/post/import', ['uses' => 'app\supplier\importController@import', 'as' => 'supplier.import']);

    //export
    Route::get('supplier/export/{type}', ['uses' => 'app\supplier\importController@export', 'as' => 'supplier.export']);

    /* === product === */
    Route::get('warehousing/products', ['uses' => 'app\products\productController@index', 'as' => 'product.index']);
    Route::get('warehousing/products/create', ['uses' => 'app\products\productController@create', 'as' => 'products.create']);
    Route::post('warehousing/products/store', ['uses' => 'app\products\productController@store', 'as' => 'products.store']);
    Route::post('warehousing/products/upload', ['uses' => 'app\products\productController@upload', 'as' => 'products.upload']);
    Route::get('warehousing/products/{id}/edit', ['uses' => 'app\products\productController@edit', 'as' => 'products.edit']);
    Route::get('warehousing/products/{id}/restock', ['uses' => 'app\products\productController@restock', 'as' => 'products.restock']);
    Route::get('warehousing/products/{id}/view', ['uses' => 'app\products\productController@singleview', 'as' => 'products.view']);
    Route::post('warehousing/products/{id}/update', ['uses' => 'app\products\productController@update', 'as' => 'products.update']);
    Route::post('warehousing/products/{id}/updatestock', ['uses' => 'app\products\productController@updatestock', 'as' => 'products.updatestock']);
    Route::get('warehousing/products/{id}/details', ['uses' => 'app\products\productController@details', 'as' => 'products.details']);
    Route::get('warehousing/products/{id}/destroy', ['middleware' => ['permission:delete-products'], 'uses' => 'app\products\productController@destroy', 'as' => 'products.destroy']);

    //express products
    Route::get('/express/items', ['uses' => 'app\products\productController@express_list', 'as' => 'product.express.list']);
    Route::post('/express/items/create', ['uses' => 'app\products\productController@express_store', 'as' => 'products.express.create']);

    //import product
    Route::get('products/import', ['uses' => 'app\products\ImportController@index', 'as' => 'products.import']);
    Route::post('products/post/import', ['uses' => 'app\products\ImportController@import', 'as' => 'products.post.import']);
    Route::post('products/post/imports', ['uses' => 'app\products\productController@importProducts', 'as' => 'products.post.imports']);

    //import users
    Route::get('users/all/import', ['uses' => 'app\usersController@indexUser', 'as' => 'users.all.import']);
    Route::post('users/post/import', ['uses' => 'app\usersController@import', 'as' => 'users.post.import']);

    Route::get('/get-users', 'app\usersController@getUsers')->name('get.users');
    Route::get('/get-distributors', 'app\usersController@getDistributors')->name('get.distributors');

    //export products
    Route::get('products/export/{type}', ['uses' => 'app\products\ImportController@export', 'as' => 'products.export']);

    //download csv sample for products
    Route::get('products/download/import/sample', ['uses' => 'app\products\ImportController@download_import_sample', 'as' => 'products.sample.download']);

    /* === product description === */
    Route::get('products/{id}/description', ['uses' => 'app\products\productController@description', 'as' => 'description']);
    Route::post('products/{id}/description/update', ['uses' => 'app\products\productController@description_update', 'as' => 'description.update']);

    /* === product price === */
    Route::get('product/price/{id}/edit', ['uses' => 'app\products\productController@price', 'as' => 'product.price']);
    Route::post('price/{id}/update', ['uses' => 'app\products\productController@price_update', 'as' => 'product.price.update']);
    //customer groups
    Route::get('customers/groups', ['uses' => 'app\customer\customerController@customergroups', 'as' => 'groupings']);
    Route::post('customers/groups/store', ['uses' => 'app\customer\customerController@groupstore', 'as' => 'groupstore']);

    /* === product inventory === */
    Route::get('products/inventory/{id}/edit', ['uses' => 'app\products\inventoryController@inventory', 'as' => 'products.inventory']);
    Route::post('products/inventory/{productID}/update', ['uses' => 'app\products\inventoryController@inventroy_update', 'as' => 'products.inventory.update']);
    Route::post('products/inventory/settings/{productID}/update', ['uses' => 'app\products\inventoryController@inventory_settings', 'as' => 'products.inventory.settings.update']);
    Route::post('products/inventory/outlet/link', ['uses' => 'app\products\inventoryController@inventory_outlet_link', 'as' => 'products.inventory.outlet.link']);
    Route::get('products/{productID}/inventory/outle/{id}/link/delete', ['uses' => 'app\products\inventoryController@delete_inventroy', 'as' => 'products.inventory.outlet.link.delete']);

    /* === product images === */
    Route::get('products/images/{id}/edit', ['uses' => 'app\products\imagesController@edit', 'as' => 'product.images']);
    Route::post('products/images/{id}/update', ['uses' => 'app\products\imagesController@update', 'as' => 'product.images.update']);
    Route::post('products/images/store', ['uses' => 'app\products\imagesController@store', 'as' => 'product.images.store']);
    Route::post('products/images/{id}/destroy', ['uses' => 'app\products\imagesController@destroy', 'as' => 'product.images.destroy']);

    /* === stock control === */
    Route::get('stock/control/', ['uses' => 'app\products\stockcontrolController@index', 'as' => 'product.stock.control']);
    Route::get('order/stock', ['uses' => 'app\products\stockcontrolController@order', 'as' => 'product.stock.order']);
    Route::get('order/stock/{id}/show', ['uses' => 'app\products\stockcontrolController@show', 'as' => 'product.stock.order.show']);
    Route::post('post/order/stock', ['middleware' => ['permission:create-stockcontrol'], 'uses' => 'app\products\stockcontrolController@store', 'as' => 'product.stock.order.post']);
    Route::post('lpo/ajax/price', 'app\products\stockcontrolController@productPrice')->name('ajax.product.stock.price');
    Route::get('order/stock/{id}/edit', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@edit', 'as' => 'product.stock.order.edit']);
    Route::post('order/stock/{id}/update', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@update', 'as' => 'product.stock.order.update']);
    Route::get('order/stock/{id}/pdf', ['uses' => 'app\products\stockcontrolController@pdf', 'as' => 'product.stock.order.pdf']);
    Route::get('order/stock/{id}/print', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@print', 'as' => 'product.stock.order.print']);
    Route::get('order/stock/{id}/delivered', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@delivered', 'as' => 'stock.delivered']);

    //send order
    Route::get('stock/{id}/mail', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@mail', 'as' => 'stock.mail']);
    Route::post('stock/mail/send', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@send', 'as' => 'stock.mail.send']);
    Route::post('stock/attach/files', ['middleware' => ['permission:update-stockcontrol'], 'uses' => 'app\products\stockcontrolController@attachment_files', 'as' => 'stock.attach']);
//stock lifts
    Route::get('stock-lifts', ['uses' => 'app\products\StockLiftController@lifted', 'as' => 'stock.lifts']);
    Route::get('lifted/items/{allocation_code}', ['uses' => 'app\products\StockLiftController@items', 'as' => 'lifted.items']);
    //stock Reconciliations
    Route::get('stock-Reconciliations', ['uses' => 'app\products\inventoryController@stockrecon', 'as' => 'stock.recon']);
    Route::get('salesperson/reconciled/{warehouse_code}', ['uses' => 'app\products\inventoryController@salesperson', 'as' => 'stock.salesperson']);
    Route::get('products/reconciled/{warehouse_code}', ['uses' => 'app\products\inventoryController@reconciled', 'as' => 'stock.reconciled']);

   /* === product category === */
    Route::get('warehousing/products/category', ['uses' => 'app\products\categoryController@index', 'as' => 'product.category']);
    Route::post('warehousing/products/category/store', ['uses' => 'app\products\categoryController@store', 'as' => 'product.category.store']);
    Route::get('warehousing/products/category/{id}/edit', ['uses' => 'app\products\categoryController@edit', 'as' => 'product.category.edit']);
    Route::post('warehousing/product.category/{id}/update', ['uses' => 'app\products\categoryController@update', 'as' => 'product.category.update']);
    Route::get('warehousing/products/category/{id}/destroy', ['uses' => 'app\products\categoryController@destroy', 'as' => 'product.category.destroy']);

    /* === product brands === */
    Route::get('warehousing/products/brand', ['uses' => 'app\products\brandController@index', 'as' => 'product.brand']);
    Route::post('warehousing/products/brand/store', ['uses' => 'app\products\brandController@store', 'as' => 'product.brand.store']);
    Route::get('warehousing/products/brand/{id}/edit', ['uses' => 'app\products\brandController@edit', 'as' => 'product.brand.edit']);
    Route::post('warehousing/product/brand/{id}/update', ['uses' => 'app\products\brandController@update', 'as' => 'product.brand.update']);
    Route::get('warehousing/products/brand/{id}/destroy', ['uses' => 'app\products\brandController@destroy', 'as' => 'product.brand.destroy']);
    Route::get('warehousing/products/restock_history/{id}/{warehousecode}', ['uses' => 'app\products\stockcontrolController@restockHistory', 'as' => 'product.restock.history']);

    /* === users === */
    Route::get('user', ['uses' => 'app\usersController@index', 'as' => 'users.index']);
    Route::get('user/create', ['uses' => 'app\usersController@create', 'as' => 'user.create']);
    Route::get('user/creatensm', ['uses' => 'app\usersController@creatensm', 'as' => 'user.creatensm']);
    Route::post('user/store', ['uses' => 'app\usersController@store', 'as' => 'user.store']);
    Route::get('user/{id}/edit', ['uses' => 'app\usersController@edit', 'as' => 'user.edit']);
    Route::get('user/{id}/view', ['uses' => 'app\usersController@view', 'as' => 'user.view']);
    Route::put('user/{id}/update', ['uses' => 'app\usersController@update', 'as' => 'user.update']);
    //   Route::get('user{id}/destroy', ['uses' => 'app\usersController@destroy', 'as' => 'user.destroy']);
    Route::get('user{id}/suspend', ['uses' => 'app\usersController@suspend', 'as' => 'user.suspend']);

    Route::get('users', ['uses' => 'app\usersController@index', 'as' => 'users.list']);
    Route::get('users-Admins', ['uses' => 'app\usersController@admins', 'as' => 'users.admins']);
    Route::get('users/admins', ['uses' => 'app\usersController@admin', 'as' => 'users.admin']);

    Route::get('users/merchandizer', ['uses' => 'app\usersController@Merchandizer', 'as' => 'Merchandizer']);
    Route::get('users/sales', ['uses' => 'app\usersController@tsr', 'as' => 'tsr']);
    Route::get('users/managers', ['uses' => 'app\usersController@rsm', 'as' => 'rsm']);
    Route::get('users/hr', ['uses' => 'app\usersController@hr', 'as' => 'hr']);
    Route::get('users/account-managers', ['uses' => 'app\usersController@ac', 'as' => 'users.ac']);
    Route::get('users/GT-Sales', ['uses' => 'app\usersController@GTSales', 'as' => 'GTSales']);
    Route::get('users/Horeca-Sales', ['uses' => 'app\usersController@HorecaSales', 'as' => 'HorecaSales']);
    //   Route::get('rider', ['uses' => 'app\usersController@technical', 'as' => 'rider']);
    // Routes for reports
    Route::middleware('web')->group(function () {
        Route::get('reports', 'app\ReportsController@reports')->name('users.reports');
        Route::get('reports/pre-oders', 'app\ReportsController@reports')->name('preorders.reports');
        Route::get('reports/Van-sales', 'app\ReportsController@reports')->name('vansales.reports');
        Route::get('reports/delivery', 'app\ReportsController@reports')->name('delivery.reports');
        Route::get('reports/kenbeauty-users', 'app\ReportsController@reports')->name('sidai.reports');
        Route::get('reports/warehouse-Report', 'app\ReportsController@reports')->name('warehouse.reports');
        Route::get('reports/supplier-report', 'app\ReportsController@reports')->name('supplier.reports');
        Route::get('reports/visitation-report', 'app\ReportsController@reports')->name('visitation.reports');
        Route::get('reports/targets-report', 'app\ReportsController@reports')->name('target.reports');
        Route::get('reports/payments-report', 'app\ReportsController@reports')->name('payments.reports');
        Route::get('reports/distributors', 'app\ReportsController@reports')->name('distributor.reports');
        Route::get('reports/region-report', 'app\ReportsController@reports')->name('regional.reports');
        Route::get('reports/customers-report', 'app\ReportsController@reports')->name('clients.reports');
        Route::get('reports/inventory-report', 'app\ReportsController@reports')->name('inventory.reports');
    });

    //Routes for reports
    Route::get('reports/supplier-report/{id}', ['uses' => 'app\ReportsController@supplierDetails', 'as' => 'supplierDetailed.reports']);
    Route::get('reports/payments-report/{id}', ['uses' => 'app\ReportsController@paymentsDetails', 'as' => 'paymentsdetails.reports']);
    Route::get('reports/subregion-report/{id}', ['uses' => 'app\ReportsController@subregions', 'as' => 'subregion.reports']);
    Route::get('reports/{id}/routes-report', ['uses' => 'app\ReportsController@routes', 'as' => 'routes.reports']);
    Route::get('reports/customers/{id}', ['uses' => 'app\ReportsController@customers', 'as' => 'customers.reports']);
    Route::get('reports/products/{code}', ['uses' => 'app\ReportsController@productreport', 'as' => 'allproducts.reports']);
    Route::get('reports/{code}/products', ['uses' => 'app\ReportsController@products', 'as' => 'report.products']);
    Route::get('orders/items/{order_code}', ['uses' => 'app\ReportsController@preorderitems', 'as' => 'product.items']);
    Route::get('orders/vansaleitems/{order_code}', ['uses' => 'app\ReportsController@vansaleitems', 'as' => 'vansale.items']);
    Route::get('orders/deliveryitems/{order_code}', ['uses' => 'app\ReportsController@deliveryitems', 'as' => 'delivery.items']);
    Route::get('reports/admins/details', ['uses' => 'app\ReportsController@admins', 'as' => 'admins.details']);
    Route::get('reports/GT-Sales/details', ['uses' => 'app\ReportsController@gtsales', 'as' => 'gtsales.details']);
    Route::get('reports/HumanResource-Manager/details', ['uses' => 'app\ReportsController@hr', 'as' => 'hr.details']);
    Route::get('reports/Sales/details', ['uses' => 'app\ReportsController@sales', 'as' => 'sales.details']);
    Route::get('reports/Merchandiser/details', ['uses' => 'app\ReportsController@merchandiser', 'as' => 'merchandiser.details']);
    Route::get('reports/Dat-Entry/details', ['uses' => 'app\ReportsController@dataentry', 'as' => 'dataentry.details']);
    Route::get('reports/Managers/details', ['uses' => 'app\ReportsController@manager', 'as' => 'manager.details']);
    Route::get('reports/Team-Leader/details', ['uses' => 'app\ReportsController@teamleader', 'as' => 'teamleader.details']);
    Route::get('reports/	Account-Sales-Manager/details', ['uses' => 'app\ReportsController@asm', 'as' => 'asm.details']);
    Route::get('reports/customer/details', ['uses' => 'app\ReportsController@customer', 'as' => 'customer.details']);
    Route::get('reports/admin/details', ['uses' => 'app\ReportsController@admin', 'as' => 'admin.details']);

    //getting subregions
    Route::get('/get-subregions/{regionId}', 'app\warehousingController@getByRegion')->name('get-subregions');;
    /* === Route Scheduling === */
    Route::get('routes', ['uses' => 'app\routesController@index', 'as' => 'routes.index']);
    Route::get('routes/individual', ['uses' => 'app\routesController@individual', 'as' => 'routes.individual']);
    Route::get('routes/create', ['uses' => 'app\routesController@create', 'as' => 'routes.create']);
    Route::post('routes/store', ['uses' => 'app\routesController@store', 'as' => 'routes.store']);
    Route::get('routes/{code}/update', ['uses' => 'app\routesController@update', 'as' => 'routes.update']);
    Route::get('routes/{code}/view', ['uses' => 'app\routesController@view', 'as' => 'routes.view']);

    /* === delivery === */
    Route::get('delivery', ['uses' => 'app\deliveryController@index', 'as' => 'delivery.index']);
    Route::get('delivery/{code}/details', ['uses' => 'app\deliveryController@details', 'as' => 'delivery.details']);

    /* === Warehousing === */
    Route::get('warehousing', ['uses' => 'app\warehousingController@index', 'as' => 'warehousing.index']);
    Route::get('warehousing/create', ['uses' => 'app\warehousingController@create', 'as' => 'warehousing.create']);
    Route::get('warehousing/show', ['uses' => 'app\warehousingController@show', 'as' => 'warehousing.show']);
    Route::get('warehousing/import', ['uses' => 'app\warehousingController@import', 'as' => 'warehousing.import']);
    Route::post('warehousing/import/store', ['uses' => 'app\warehousingController@storeWarehouse', 'as' => 'warehousing.import.store']);
    Route::post('warehousing/store', ['uses' => 'app\warehousingController@store', 'as' => 'warehousing.store']);
    Route::get('warehousing/{code}/edit', ['uses' => 'app\warehousingController@edit', 'as' => 'warehousing.edit']);
    Route::post('warehousing/{code}/update', ['uses' => 'app\warehousingController@update', 'as' => 'warehousing.update']);

    //editing sales targets
    Route::get('target/sales/edit/{code}', ['uses' => 'app\Target\SalesController@edit', 'as' => 'salestarget.edit']);
    Route::post('target/sales/update/{code}', ['uses' => 'app\Target\SalesController@update', 'as' => 'salestarget.update']);
    //edits for visits targets
    Route::get('target/visits/edit/{code}', ['uses' => 'app\Target\VisitsController@edit', 'as' => 'visitstarget.edit']);
    Route::post('target/visits/update/{code}', ['uses' => 'app\Target\VisitsController@update', 'as' => 'visitstarget.update']);
    //edits for leads targets
    Route::get('target/leads/edit/{code}', ['uses' => 'app\Target\LeadsController@edit', 'as' => 'leadstarget.edit']);
    Route::post('target/leads/update/{code}', ['uses' => 'app\Target\LeadsController@update', 'as' => 'leadstarget.update']);
    //edits for orders targets
    Route::get('target/orders/edit/{code}', ['uses' => 'app\Target\OrdersController@edit', 'as' => 'orderstarget.edit']);
    Route::post('target/orders/update/{code}', ['uses' => 'app\Target\OrdersController@update', 'as' => 'orderstarget.update']);

    /* ===  inventory === */

    //stock allocation
    Route::post('warehousing/approve', ['uses' => 'app\inventoryController@handleApproval', 'as' => 'inventory.handleApproval']);
    Route::get('warehousing/approve/{id}', ['uses' => 'app\inventoryController@approve', 'as' => 'inventory.approve']);
    Route::get('warehousing/inventory/allocated', ['uses' => 'app\inventoryController@allocated', 'as' => 'inventory.allocated']);
    Route::post('inventory/allocate/user', ['uses' => 'app\inventoryController@allocate_user', 'as' => 'inventory.allocate.user']);
    Route::get('inventory/allocate/{code}/items', ['uses' => 'app\inventoryController@allocate_items', 'as' => 'inventory.allocate.items']);
    //stock approval
    Route::get('warehousing/all/stock-requisition', ['uses' => 'app\inventoryController@approval', 'as' => 'inventory.approval']);
    Route::get('warehousing/approved/{requisition_id}', ['uses' => 'app\products\productController@approvestock', 'as' => 'product.approvestock']);
    //products
    Route::get('warehousing/{code}/products', ['uses' => 'app\warehousingController@products', 'as' => 'warehousing.products']);
    Route::get('warehousing/assign', ['uses' => 'app\warehousingController@assign', 'as' => 'warehousing.assign']);
    Route::post('warehousing/assignwarehouse', ['uses' => 'app\warehousingController@assignwarehouse', 'as' => 'warehousing.assignwarehouse']);

    /* === settings === */
    //account
    Route::get('settings/account', ['uses' => 'app\settingsController@account', 'as' => 'settings.account']);
    Route::post('settings/account/{id}/update', ['uses' => 'app\settingsController@update_account', 'as' => 'settings.account.update']);

    //activity lo
    Route::get('settings/activity-log', ['uses' => 'app\settingsController@activity_log', 'as' => 'settings.activity_log']);

    //Territories
    Route::get('territories', ['uses' => 'app\territoriesController@index', 'as' => 'territories.index']);

    /* === Orders === */
    Route::get('orders', ['uses' => 'app\ordersController@index', 'as' => 'orders.index']);
    Route::get('pendingorders', ['uses' => 'app\ordersController@pendingorders', 'as' => 'orders.pendingorders']);
    //   Route::get('distributororders', ['uses' => 'app\ordersController@distributororders', 'as' => 'orders.distributororders']);
    Route::get('pendingdeliveries', ['uses' => 'app\ordersController@pendingdeliveries', 'as' => 'orders.pendingdeliveries']);
    Route::get('orders/{code}/details', ['uses' => 'app\ordersController@details', 'as' => 'orders.details']);
    Route::get('orders/{code}/pendingdetails', ['uses' => 'app\ordersController@pendingdetails', 'as' => 'orders.pendingdetails']);
    Route::get('orders/{code}/distributorsdetails', ['uses' => 'app\ordersController@distributordetails', 'as' => 'orders.distributorsdetails']);
    Route::post('orders/{code}/distributorschangeStatus', ['uses' => 'app\ordersController@distributorschangeStatus', 'as' => 'orders.distributorschangeStatus']);
    Route::get('orders/customer/{id}', ['uses' => 'app\ordersController@makeOrder', 'as' => 'make.orders']);
    Route::get('orders/{code}/delivery/allocation', ['uses' => 'app\ordersController@allocation', 'as' => 'orders.delivery.allocation']);
    Route::post('orders/allocate', ['uses' => 'app\ordersController@delivery', 'as' => 'order.create.delivery']);
    Route::post('orders/allocate', ['uses' => 'app\ordersController@allocateOrders', 'as' => 'order.create.allocateorders']);
    Route::post('orders/reallocate', ['uses' => 'app\ordersController@reAllocateOrders', 'as' => 'order.create.reallocateorders']);
    //distributor orders
    Route::get('vansalesorders', ['uses' => 'app\ordersController@vansalesorders', 'as' => 'orders.vansalesorders']);

    /* ===  survey === */
    /* === category === */
    Route::get('category/list', 'app\survey\categoryController@index')->name('survey.category.index');
    Route::get('category/create', 'app\survey\categoryController@create')->name('survey.category.create');
    Route::post('category/store', 'app\survey\categoryController@store')->name('survey.category.store');
    Route::get('category/{code}/edit', 'app\survey\categoryController@edit')->name('survey.category.edit');
    Route::post('category/{code}/update', 'app\survey\categoryController@update')->name('survey.category.update');
    Route::get('category/{code}/delete', 'app\survey\categoryController@delete')->name('survey.category.delete');

    /* === survey === */
    Route::get('survey/list', 'app\survey\surveyController@index')->name('survey.index');
    Route::get('survey/active', 'app\survey\surveyController@active')->name('survey.active');
    Route::get('survey/responses', 'app\survey\surveyController@responses')->name('survey.responses');
    Route::get('survey/create', 'app\survey\surveyController@create')->name('survey.create');
    Route::post('survey/store', 'app\survey\surveyController@store')->name('survey.store');
    Route::get('survey/{code}/show', 'app\survey\surveyController@show')->name('survey.show');
    Route::get('survey/{code}/edit', 'app\survey\surveyController@edit')->name('survey.edit');
    Route::post('survey/{code}/update', 'app\survey\surveyController@update')->name('survey.update');
    Route::get('survey/{code}/delete', 'app\survey\surveyController@delete')->name('survey.delete');

    /* === questions === */
    Route::get('survey/{code}/questions', 'app\survey\questionsController@index')->name('survey.questions.index');
    Route::get('survey/{code}/questions/create', 'app\survey\questionsController@create')->name('survey.questions.create');
    Route::post('survey/{code}/questions/store', 'app\survey\questionsController@store')->name('survey.questions.store');
    Route::get('survey/{code}/questions/{questionID}/edit', 'app\survey\questionsController@edit')->name('survey.questions.edit');
    Route::post('survey/{code}/questions/{questionID}/update', 'app\survey\questionsController@update')->name('survey.questions.update');
    Route::get('survey/{code}/questions/{id}/delete', 'app\survey\questionsController@delete')->name('survey.questions.delete');

    //activity logs
    Route::get('activity', ['uses' => 'ActivityController@index', 'as' => 'activity.index']);
    Route::get('activity/show/{id}', ['uses' => 'ActivityController@show', 'as' => 'activity.show']);
    Route::get('sales/activity', ['uses' => 'ActivityController@sales', 'as' => 'activity.sales']);

    //chats endpoints
    Route::get('socket/index', [SocketsController::class, 'index'])->name('socket.index');
    Route::get('chats/{chat}', 'ChatController@show');
    Route::get('/chats/index', [ChatController::class, 'index'])->name('chats.index');
    Route::post('chats/{chat}/messages', 'MessageController@store');
    Route::get('/messages/{receiverId}', [ChatController::class, 'messagesIndex'])->name('messages.index');

    //support
    Route::get('support', ['uses' => 'SupportTicketController@index', 'as' => 'support.index'])->middleware('auth:sanctum');
    Route::get('support/{id}', ['uses' => 'SupportTicketController@show', 'as' => 'support.show'])->middleware('auth:sanctum');
    Route::get('support/update/{id}', ['uses' => 'SupportTicketController@update', 'as' => 'support.update'])->middleware('auth:sanctum');
    Route::post('/support/{ticketId}/messages/{messageId}/reply', [SupportTicketController::class, 'replyToMessage'])->name('support.reply');
    Route::get('support/{ticket_id}/messages', ['uses' => 'SupportTicketController@getMessages', 'as' => 'support.getMessages'])->middleware('auth:sanctum');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
});

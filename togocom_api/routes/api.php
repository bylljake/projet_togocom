<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\company\CompanyController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Shopping\ShoppingController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Role_list\Role_listContoller;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Sale_line\Sale_lineController;
use App\Http\Controllers\Statistic\StatisticController;
use App\Http\Controllers\Image_slider\Image_sliderController;
use App\Http\Controllers\Sale_history\Sale_historyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Routes publiques accessibles sans authentification
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/image_sliders', [Image_sliderController::class, 'index'])->name('image_sliders_index');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');
    Route::get('/email/resendverification/{id}', [VerificationController::class, 'sendVerificationEmail'])->name('verificationemail.resend');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('/password/reset', [ResetPasswordController::class, 'verifiedLink'])->name('password.verifiedLink');
    Route::post('/password/newpassword', [ResetPasswordController::class, 'reset'])->name('password.reset');
});
Route::group(['middleware' => ['api', 'auth'], 'prefix' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/edit-profile', [AuthController::class, 'editUserProfile']);
    //Category
    Route::get('/categories', [CategoryController::class, 'index']);
    //Customer
    Route::post('/customers/register', [CustomerController::class, 'register']);
    //Produit
    Route::get('/products', [ProductController::class, 'listProduit'])->name('products');
    Route::get('/products/list', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'getProductByID']);
    //Email verification
    Route::put('/users/password/{id}', [UserController::class, 'editPassword']);
    //Image slider
    Route::get('/image_sliders/activatedimageslist', [Image_sliderController::class, 'activatedImage'])->name('image_sliders_activatedimageslist');
    Route::get('/image_sliders/{id}', [Image_sliderController::class, 'show'])->name('image_sliders_show');
});


Route::group(['middleware' => ['auth', 'role_or_permission:admin,sale,cashier,user,Sale_Or_Validate'], 'prefix' => 'auth'], function () {
    // Ces routes sont accessibles par les utilisateurs ayant l'un des rôles : "admin", "sale", "cashier"
    Route::get('/unpaidorderslist', [SaleController::class, 'unpaidOrdersList']);
    Route::get('/unpaidorders/{sale_id}', [SaleController::class, 'unpaidOrderById']);
    Route::get('/getOrdersById/{sale_id}', [SaleController::class, 'getOrderById']);

    // Sale
    Route::get('/sales/list', [SaleController::class, 'saleListByUser']);
    Route::post('/sales', [SaleController::class, 'store'])->name('store.sales');
    Route::get('/sales/{id}', [SaleController::class, 'show']);
    Route::put('/unpaidOrder/{sale_id}', [SaleController::class, 'updateUnpaidOrder'])->name('update_unpaid_order');
    Route::delete('/sales/cancelunpaidorder/{sale_d}', [SaleController::class, 'cancelUnpaidSale']);

    Route::get('/customers', [CustomerController::class, 'index']); // list
    Route::get('/customers/{id}', [CustomerController::class, 'show']); //view
    Route::put('/customers/{id}', [CustomerController::class, 'update']); // update
    Route::post('/customers', [CustomerController::class, 'register']); // create
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']); //delete

    //Exired product
    Route::get('/products/expired/list', [StatisticController::class, 'expiredProductList'])->name('expires.products');
});


Route::group(['middleware' => ['api', 'auth', 'permission:validate_sale,Sale_Or_Validate'], 'prefix' => 'auth'], function () {
    Route::post('/sales/confirmpurchase/{sale_id}', [SaleController::class, 'confirmPurchase']);
    //Invoice
    Route::get('/invoices/{sale_id}', [InvoiceController::class, 'invoice'])->name('invoices');
});

Route::group(['middleware' => ['api', 'auth', 'role:admin,cashier'], 'prefix' => 'admin'], function () {
    Route::get('/sales/cashiersales/{cashier_id}', [SaleController::class, 'unconfirmCashierSaleBySaleId'])->name('sales.ashiersales');
    Route::get('/sales/unconfirmcashiersales/{cashier_id}', [SaleController::class, 'cashierSale'])->name('sales.unconfirmcashiersales');
    Route::put('/sales/confirmcashierreceipts/{cashier_id}', [SaleController::class, 'confirmCashierReceipts'])->name('confirmcashierreceipts');
    Route::get('/sales/total_amount_shortfall/{cashier_id}', [SaleController::class, 'totalCashierAmountShortfall'])->name('totalCashierAmountShortfall');
    Route::get('/sales/mount_shortfall_list/{cashier_id}', [SaleController::class, 'listCashierAmountShortfall'])->name('listCashierAmountShortfall');
    Route::get('/sales/amount_shortfall/{cashier_id}', [SaleController::class, 'cashierAmountShortfall'])->name('cashierAmountShortfall');
    Route::get('/sales/listaccounts', [SaleController::class, 'AccountList'])->name('AccountList');
    Route::get('/sales/accounts/{id}', [SaleController::class, 'AccountById'])->name('AccountById');
    Route::get('/sales/listreimbursements/{closure_id}', [SaleController::class, 'reimbursementListByCashier'])->name('reimbursementList');
    Route::put('/sales/{id}', [SaleController::class, 'update']);
});

Route::group(['middleware' =>  ['api', 'auth', 'permission:ResetCashRegister'], 'prefix' => 'admin'], function () {
    Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('show.suppliers');
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('index');
    //Shopping
    Route::get('/shoppings', [ShoppingController::class, 'listShopping'])->name('listShopping');
    Route::get('/shoppings/{id}', [ShoppingController::class, 'getShoppingByID']);
    Route::post('/shoppings', [ShoppingController::class, 'store'])->name('store.shoppings');
    Route::put('/shoppings/existingproduct/{product_id}', [ShoppingController::class, 'storeShoppingExistingProduct'])->name('store_existingproduct');
    Route::put('/shoppings/{id}', [ShoppingController::class, 'update']);
    Route::post('/shoppings/list', [ShoppingController::class, 'test']);
    Route::delete('/shoppings/{id}', [ShoppingController::class, 'destroy']);

    //Inventory
    Route::post('/inventories', [InventoryController::class, 'store'])->name('store_inventory');
    Route::put('/inventories/{id}', [InventoryController::class, 'update'])->name('update_inventory');
    Route::get('/inventories', [InventoryController::class, 'index'])->name('index_inventory');
    Route::post('/inventories/info', [InventoryController::class, 'getInventoryInfo'])->name('info_inventory');
    Route::get('/salebydaterange/{product_id}/{start_date}/{end_date}', [InventoryController::class, 'getSalesByDateRange'])->name('get_sales_by_dateRange');
    Route::get('/inventories/{id}', [InventoryController::class, 'show']);
    Route::delete('/inventories/{id}', [InventoryController::class, 'destroy'])->name('destroy.inventories');

    // Vraque de produit
    Route::post('/vraques', [StockController::class, 'vraque'])->name('vraquierProduit');


    //Make account
    Route::put('/sales/makeaccounts/{closure_id}', [SaleController::class, 'makeAccount'])->name('makeAccount');

    //Make reimbursement
    Route::put('/sales/cashierreimbursements/{closure_id}', [SaleController::class, 'cashierReimbursements'])->name('cashierReimbursements');

    //All reimbursement list
    Route::get('/sales/allreimbursementlist', [SaleController::class, 'allReimbursementList'])->name('allReimbursementList');
});

Route::group(['middleware' =>  ['api', 'auth', 'role:admin'], 'prefix' => 'admin'], function () {
    //Admin
    Route::get('/', [AdminController::class, 'index'])->name('index.admin');
    //Roles and Permissions
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
    Route::post('/roles/users', [RoleController::class, 'assignRole'])->name('roles.user');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissionsToRole'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'editRolePermissions'])->name('editRoles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.revokePermission');
    Route::resource('/roleslist', Role_listContoller::class);

    //User
    Route::apiResource('/users', UserController::class);

    //Category
    Route::post('/categories', [CategoryController::class, 'store'])->name('store.categories');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('update.categories');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('destroy.categories');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('show.categories');

    //Supplier
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('store.suppliers');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'show'])->name('show.supplier');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('update.suppliers');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('destroy.suppliers');


    //Sale
    Route::get('/sales', [SaleController::class, 'index']);
    Route::get('/sales/{id}', [SaleController::class, 'show']);
    Route::delete('/sales/{id}', [SaleController::class, 'cancelSale']);
    Route::delete('/deletesales/{id}', [SaleController::class, 'deleteSale']);

    //sale_line
    Route::get('/sale_lines', [Sale_lineController::class, 'index'])->name('index.sale_lines');
    Route::delete('/sale_lines/{id}', [Sale_lineController::class, 'destroy']);
    Route::put('/sale_lines/{id}', [Sale_lineController::class, 'update']);

    //sale_history
    Route::get('/sale_histories', [Sale_historyController::class, 'index'])->name('sale_histories_index');
    Route::get('/sale_histories/{id}', [Sale_historyController::class, 'find_by_sale_id'])->name('sale_histories_find_by_sale_id');

    //stock
    Route::get('/stocks', [StockController::class, 'index'])->name('index_stocks');
    Route::get('/stocks/{product_id}', [StockController::class, 'show'])->name('show_stocks');
    //Vraquer
    Route::post('/stocks', [StockController::class, 'magasin'])->name('stocks.magasin');

    //Chart
    Route::get('/salebymonth', [StatisticController::class, 'getTotalSaleByMMonth'])->name('salebymonth');
    Route::get('/topsellingproducts', [StatisticController::class, 'getTopSellingProducts'])->name('topsellingproducts');

    //Statistic
    Route::get('/statistics/stockoutbydaterange/{start_date}/{end_date}', [StatisticController::class, 'stockOutByDateRange'])->name('stockoutbydaterange');
    Route::get('/statistics/sellingproductsbydaterange/{start_date}/{end_date}', [StatisticController::class, 'sellingProductDateRange'])->name('sellingproductdaterange');
    Route::get('/statistics/saleslistbydaterange/{start_date}/{end_date}', [StatisticController::class, 'salesList'])->name('sales_list');
    Route::get('/statistics/topsellingproductsbydaterange/{start_date}/{end_date}', [StatisticController::class, 'topSellingProduct'])->name('top_selling_products');
    Route::get('/statistics/shoppinglistbydaterange/{start_date}/{end_date}', [StatisticController::class, 'shoppingListByDateRange'])->name('shoppinglistbydaterange');
    Route::get('/statistics/totalsalesamountbydaterange/{start_date}/{end_date}', [StatisticController::class, 'totalSalesAmount'])->name('totalsalesamountbydaterange');
    Route::get('/statistics/saleslistbydaterange/{start_date}/{end_date}', [StatisticController::class, 'salesListByDateRange'])->name('Saleslistbydaterange');
    Route::get('/statistics/expiringproductsbeforedate/{date}', [StatisticController::class, 'expiringProductsBeforeDate'])->name('expiringproductsbeforedate');
    Route::get('/statistics/salesdata', [StatisticController::class, 'getSalesData'])->name('saledata');
    //Low Quantity Products
    Route::get('/statistics/lowquantityproducts', [StatisticController::class, 'getLowQuantityProducts'])->name('lowquantityproducts');

    //Image_slider
    Route::post('/image_sliders', [Image_sliderController::class, 'store'])->name('image_sliders_store');
    Route::delete('/image_sliders/{id}', [Image_sliderController::class, 'destroy'])->name('image_sliders_destroy');
    Route::put('/image_sliders/{id}', [Image_sliderController::class, 'update'])->name('update_sliders_destroy');

    //Save product and category data by excel file
    Route::post('/shoppings/excel', [ShoppingController::class, 'storeExcelFile'])->name('save_by_excel_file');

    //Confirm cashier sale's account
    Route::get('/salerList', [UserController::class, 'saleList'])->name('users.sales');

    //Cahiers list
    Route::get('/cashiers', [UserController::class, 'cashierList'])->name('cashiers_list');

    // Company
    Route::apiResource('/companies', CompanyController::class);

    //Slider
    Route::apiResource('/sliders', SliderController::class);
});

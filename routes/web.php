<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\IndexComponent;
use App\Http\Livewire\ProductDetailComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\AdminPostComponent;
use App\Http\Livewire\AdminProductComponent;
use App\Http\Livewire\AdminProductCategoryComponent;
use App\Http\Livewire\AdminSupplierComponent;
use App\Http\Livewire\AdminProductImportComponent;
use App\Http\Livewire\AdminProductCategoryLv2Component;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\OrderCompleteComponent;
use App\Http\Livewire\AdminOrderComponent;
use App\Http\Livewire\UserInfoComponent;
use App\Http\Livewire\AdminAcceptedOderComponent;
use App\Http\Livewire\AdminNewOrderComponent;
use App\Http\Livewire\AdminShippingUnitComponent;
use App\Http\Livewire\AdminShippingOrderComponent;
use App\Http\Livewire\AdminCompletedOrderComponent;
use App\Http\Livewire\AdminDeclinedOrderComponent;
use App\Http\Livewire\DemoShipComponent;
use App\Http\Livewire\CheckOrderComponent;
use App\Http\Livewire\AdminDashboardComponent;
use App\Http\Livewire\AdminStaffComponent;
use App\Http\Livewire\AdminProductImportManagerComponent;
use App\Http\Livewire\AdminProductImportBillListComponent;
use App\Http\Livewire\AdminImportRequestComponent;
use App\Http\Livewire\AdminAccountantComponent;



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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Frontend
Route::get('index', App\Http\Livewire\Frontend\Index::class);

Route::get('slider', App\Http\Livewire\Pages\Slider::class);


// end Frontend


Route::get('trang-chu',IndexComponent::class);
Route::get('san-pham/{id}',ProductDetailComponent::class);
Route::get('gio-hang',CartComponent::class);

Route::get('/admin/dashboard', AdminDashboardComponent::class);
Route::get('/admin-post', AdminPostComponent::class);
Route::get('/admin/products', AdminProductComponent::class);
Route::get('/admin/product-category/lv1', AdminProductCategoryComponent::class);
Route::get('admin/suppliers', AdminSupplierComponent::class);

Route::get('admin/product-category/lv2',AdminProductCategoryLv2Component::class);
Route::get('thanh-toan',CheckoutComponent::class);
Route::get('hoan-tat',OrderCompleteComponent::class)->middleware('checkOrderCode');


Route::get('admin/orders',AdminOrderComponent::class);
Route::get('admin/orders/accepted',AdminAcceptedOderComponent::class);
Route::get('admin/orders/new',AdminNewOrderComponent::class);
Route::get('admin/orders/completed',AdminCompletedOrderComponent::class);
Route::get('admin/orders/declined',AdminDeclinedOrderComponent::class);


Route::get('admin/demo/ship',DemoShipComponent::class);
Route::get('tra-cuu-don-hang',CheckOrderComponent::class);

Route::get('admin/shippers',AdminShippingUnitComponent::class);
Route::get('admin/shippers/create-bill',AdminShippingOrderComponent::class);

Route::get('thong-tin-nguoi-dung',UserInfoComponent::class)->middleware('checkType_User');

Route::get('admin/users/staff',AdminStaffComponent::class);

Route::get('admin/product-import/list', AdminProductImportBillListComponent::class);
Route::get('admin/product-import/new', AdminProductImportComponent::class);
Route::get('admin/product-import/manager',AdminProductImportManagerComponent::class);

Route::get('admin/import/request', AdminImportRequestComponent::class);

Route::get('admin/accountant/list',AdminAccountantComponent::class);

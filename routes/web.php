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
use App\Http\Livewire\AdminShipperBillListComponent;
use App\Http\Livewire\AdminProductLogo;
use App\Http\Livewire\AdminStorageComponent;
use App\Http\Livewire\AdminSettingComponent;
use App\Http\Livewire\UserMaintenanceComponent;
use App\Http\Livewire\AdminInfoComponent;
use App\Http\Livewire\AdminUserComponent;
use App\Http\Livewire\ReportComponent;
use App\Http\Livewire\AdminFlashSaleComponent;
use App\Http\Livewire\FlashSaleComponent;
use App\Http\Livewire\AdminCreditInfoComponent;
use App\Http\Livewire\AdminPaymentMethodComponent;

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

/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/


Route::middleware(['VisitCounter','checkMaintenance'])->group(function(){
	// Frontend
	Route::get('/', App\Http\Livewire\Frontend\Index::class);
	Route::get('index', App\Http\Livewire\Frontend\Index::class)->name('index');
	Route::get('shop', App\Http\Livewire\Frontend\Shop::class);
	Route::get('shop-detail/{slug}', App\Http\Livewire\Frontend\ShopDetail::class);
	Route::get('product/category/{slug}',App\Http\Livewire\Frontend\CategoryComponent::class);
	Route::get('blog',App\Http\Livewire\Frontend\Blog::class);
	Route::get('blog/caregory/{id}',App\Http\Livewire\Frontend\BlogCategory::class);
	Route::get('cart', App\Http\Livewire\Frontend\carts::class);
	Route::get('blog-detail/{id}',App\Http\Livewire\Frontend\BlogDetail::class);
	Route::get('checkout',App\Http\Livewire\Frontend\Checkout::class);
	Route::get('contact',App\Http\Livewire\Frontend\Contact::class);
	Route::get('about',App\Http\Livewire\Frontend\About::class);
	Route::get('wishlist',App\Http\Livewire\Frontend\WhislistComponent::class);
	Route::get('tim-kiem',App\Http\Livewire\Frontend\SearchComponent::class);
	Route::get('users',App\Http\Livewire\Frontend\Users::class)->middleware('auth');
	Route::get('don-hang',App\Http\Livewire\Frontend\Purchase::class)->middleware('auth');
	Route::get('slider', App\Http\Livewire\Pages\Slider::class);
	Route::get('sale', App\Http\Livewire\Pages\Sale::class);
	Route::get('instagram', App\Http\Livewire\Pages\Instagrams::class);
	Route::get('coupon', App\Http\Livewire\Pages\AdminCoupon::class);
	Route::get('/admin-contact', App\Http\Livewire\Pages\Admincontact::class);
	Route::get('/tin-nhan', App\Http\Livewire\Pages\AdminMessage::class);
	Route::get('flash-sale/{id}',App\Http\Livewire\FlashSaleComponent::class);
	// Blog
	Route::get('post',[App\Http\Controllers\Controller::class, 'index']);
	Route::post('addpost',[App\Http\Controllers\Controller::class, 'addpost']);
	Route::get('edit-blog/{id}',[App\Http\Controllers\Controller::class, 'show_edit_blog']);
	Route::post('update-blog/{id}',[App\Http\Controllers\Controller::class, 'update_post']);
	// end Frontend
	Route::get('trang-chu',IndexComponent::class);
	Route::get('san-pham/{id}',ProductDetailComponent::class);
	Route::get('gio-hang',CartComponent::class);
	Route::get('thanh-toan',CheckoutComponent::class);
	Route::get('hoan-tat',OrderCompleteComponent::class)->middleware('checkOrderCode');	
	Route::get('tra-cuu-don-hang',CheckOrderComponent::class);
	Route::get('thong-tin-nguoi-dung',UserInfoComponent::class)->middleware('auth');
	Route::get('bao-cao/{type}/{id}',ReportComponent::class);
});
	Route::middleware(['auth','CheckType_Admin'])->group(function(){
		Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
		Route::get('/admin-post', AdminPostComponent::class);
		Route::get('/admin/products', AdminProductComponent::class);
		Route::get('/admin/product-category/lv1', AdminProductCategoryComponent::class);
		Route::get('admin/suppliers', AdminSupplierComponent::class);
		Route::get('admin/product-category/lv2',AdminProductCategoryLv2Component::class);
		Route::get('admin/orders',AdminOrderComponent::class);
		Route::get('admin/orders/accepted',AdminAcceptedOderComponent::class);
		Route::get('admin/orders/new',AdminNewOrderComponent::class);
		Route::get('admin/orders/completed',AdminCompletedOrderComponent::class);
		Route::get('admin/orders/declined',AdminDeclinedOrderComponent::class);
		Route::get('admin/demo/ship',DemoShipComponent::class);
		Route::get('admin/shippers',AdminShippingUnitComponent::class);
		Route::get('admin/shippers/create-bill',AdminShippingOrderComponent::class);
		Route::get('admin/users/staff',AdminStaffComponent::class);
		Route::get('admin/product-import/list', AdminProductImportBillListComponent::class);
		Route::get('admin/product-import/new', AdminProductImportComponent::class);
		Route::get('admin/product-import/manager',AdminProductImportManagerComponent::class);
		Route::get('admin/import/request', AdminImportRequestComponent::class);
		Route::get('admin/accountant/list',AdminAccountantComponent::class);
		Route::get('admin/shippers/bill-list',AdminShipperBillListComponent::class);
		Route::get('admin/image/product-logo',AdminProductLogo::class);
		Route::get('admin/storage',AdminStorageComponent::class);
		Route::get('admin/setting',AdminSettingComponent::class);
		Route::get('admin/info',AdminInfoComponent::class)->name('admin.info');
		Route::get('admin/users/user',AdminUserComponent::class);
		Route::get('admin/flash-sale',AdminFlashSaleComponent::class);
		Route::get('admin/payment/methods',AdminPaymentMethodComponent::class);
		Route::get('admin/payment/credit-info',AdminCreditInfoComponent::class);
	});

Route::get('bao-tri',UserMaintenanceComponent::class);


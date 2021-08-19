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

Route::get('trang-chu',IndexComponent::class);
Route::get('san-pham/{id}',ProductDetailComponent::class);
Route::get('gio-hang',CartComponent::class);

Route::get('/admin-post', AdminPostComponent::class);
Route::get('/admin-product', AdminProductComponent::class);
Route::get('/admin-product-category', AdminProductCategoryComponent::class);
Route::get('admin/suppliers', AdminSupplierComponent::class);
Route::get('admin/product-import', AdminProductImportComponent::class);
Route::get('admin/product-category/lv2',AdminProductCategoryLv2Component::class);
Route::get('thanh-toan',CheckoutComponent::class);
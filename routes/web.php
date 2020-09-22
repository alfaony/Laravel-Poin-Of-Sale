<?php

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
// Route::prefix('admin')->group(function () {
//     Route::get('users', function () {
//         // Matches The "/admin/users" URL
//     });
// });
// ROLE
Route::get('/kerja','ApiController@kerja');
Route::get('/', function() {
    return redirect(route('login'));
});
// Route::group(['middleware' => ['role:admin']], function () 
// {
    Route::resource('/role', 'RoleController')->except([
        'create', 'show', 'edit', 'update'
    ]);
    Route::resource('/users', 'UserController')->except([
        'show'
    ]);
    Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
    // ROLE
    
    Auth::routes();
    
    Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
    Route::put('/users/roles/{id}', 'UserController@setRole')->name('users.set_role');
    Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
    Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.roles_permission');
    Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');
        
        
    
    // ENDROLE
    
    Route::get('/','dashboardController@index');
    Route::prefix('transaksi')->group(function (){
        Route::get('/buat',function(){
            return view('transaksi.create');
            // dd("oke");
        })->name('transaksi.create');
    
        Route::get('/menambahkan',function()
        {
            return view('transaksi.store');
        })->name('transaksi.store');
    
        Route::get('{id}','TransaksiController@edit')->name('transaksi.edit');
        Route::post('/create','TransaksiController@store')->name('transaksi.store');
        Route::post('/buat','TransaksiController@index')->name('transaksi.create');
        Route::delete('{id}','TransaksiController@destroy')->name('transaksi.destroy');
        Route::put('{id}','TransaksiController@update')->name('transaksi.update');
        Route::post('/','TransaksiController@forceDelete')->name('transaksi.forceDelete');
    });
    Route::get('/home','DashboardController@index');
    Route::prefix('option')->group(function()
    {
        Route::get('/','OptionController@optionIndex')->name('option.index');
        Route::post('/','OptionController@optionStore')->name('option.store');
    });
    Route::prefix('karyawan')->group(function()
    {
        Route::get('/','BaristaController@index')->name('barista.index');
        Route::post('/','BaristaController@store')->name('barista.store');
        Route::put('{id}','BaristaController@edit')->name('barista.edit');
        Route::delete('{id}','BaristaController@destroy')->name('barista.destroy'); 
    });
    Route::prefix('produk')->group(function(){
        // Import
        Route::post('/import','ProdukController@import')->name('produk.import');
        // EXPORT
        Route::get('/export','ProdukController@export')->name('produk.export');
        Route::get('/','ProdukController@index')->name('produk.index');
        Route::get('/create','ProdukController@create')->name('produk.create');
        Route::post('/','ProdukController@store')->name('produk.store');
        // update
        Route::post('/item/{id}','ProdukController@update')->name('produk.update');
        Route::put('{id}','ProdukController@item')->name('produk.item');
        Route::get('/memperbarui/item/{id}','ProdukController@edit')->name('produk.edit');
        Route::delete('{id}','ProdukController@destroy')->name('produk.destroy');
        // Produk_material
        Route::delete('/material/delete/{id}','ProdukController@destroyMaterial')->name('produk_material.delete');
        Route::delete('/subcategori/delete/{id}','ProdukController@destroySubcategori')->name('produk_subcategori.delete');
        Route::put('/subcategori/edit/{id}','ProdukController@editSubcategori')->name('produk_subcategori.edit');
        Route::get('/material/{id}','ProdukController@showMaterial')->name('produk_material.edit');
        Route::put('/material/{id}','ProdukController@updateMaterial')->name('produk_material.update');
        Route::post('/material/{id}','ProdukController@storeProduk')->name('storeProduk');
        //---> Kategori----<
        Route::get('/Kategori','CategoriController@index')->name('categori.index');
        // Store
        Route::post('/Kategori','CategoriController@store')->name('categori.store');
        Route::post('/Kategori/subcategori/{id}','CategoriController@update')->name('categori.update');
        // PUT
        Route::get('/Kategori/subcategori/{id}','CategoriController@edit')->name('categori.edit');
        // Destroy
        Route::delete('/Kategori/{id}','CategoriController@destroy')->name('categori.destroy');
        Route::delete('/Kategori/subcategori/{id}','CategoriController@subdestroy')->name('subcategori.destroy');
        Route::get('/clearCookie','ProdukController@clearCookie')->name('clearcookie');
        
    });
    Route::prefix('stok')->group(function()
    {
        Route::post('/import','StokController@import')->name('stok.import');
        Route::post('/menambahkan','StokController@store')->name('stok.store');
        Route::post('/{id}','StokController@update')->name('stok.update');
        Route::get('/','StokController@index')->name('stok.index');
        Route::get('/menambahkan','StokController@create')->name('stok.create');
        Route::get('/memperbarui/{id}','StokController@edit')->name('stok.edit');
        Route::delete('{id}','StokController@destroy')->name('stok.destroy');  
    });
    Route::get('/home', 'dashboardController@index')->name('home');
// });
// END


Auth::routes();

// BARISTA
Route::group(['middleware' => ['role:barista']], function () 
{
    Route::prefix('barista')->group(function()
    {
        Route::get('/','BaristaController@layout')->name('barista.layout');
        Route::get('/produk','BaristaController@produk')->name('barista.produk');
    });
});
Route::get('transaksis','TransaksiController@transaksiFront');
Route::get('transaksis/vue',function()
{
    return view('transaksi.vue');
});
Route::get('coba1','ApiController@cookie');
Route::get('/real',function(){
    return view('welcomereal');
});





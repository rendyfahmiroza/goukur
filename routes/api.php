<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});

// Dashboard
Route::get('dashboard','DashboardController@index')->name('dashboard');
Route::get('dashboard-petugas','DashboardPetugasController@index')->name('dashboard.petugas');
Route::get('dashboard-operator','DashboardOperatorController@index')->name('dashboard.operator');

// Manajemen
Route::resource('kegiatan','KegiatanController',['except' => ['create','edit']]);
Route::resource('pembatalan','PembatalanController',['except' => ['create','edit']]);
Route::resource('pengguna','PenggunaController',['except' => ['create','edit']]);
Route::resource('ppat','PpatController',['except' => ['create','edit']]);
Route::get('ppat_kab/{id}','PpatController@show_kab')->name('ppat.show_kab');
Route::resource('petugas','PetugasController',['except' => ['create','edit']]);
Route::get('petugas_kab/{id}','PetugasController@show_kab')->name('petugas.show_kab');
Route::get('petugas_kab_penugasan/{id}','PetugasController@penugasan')->name('petugas.penugasan');

// Berkas
Route::resource('berkas','BerkasController',['except' => ['create','edit']]);
Route::get('berkas_kab/{id}','BerkasController@show_kab')->name('berkas.show_kab');
Route::get('berkas-surat-tugas/{id}','BerkasController@berkas_surat_tugas')->name('berkas.surat_tugas');
Route::get('berkas-mandiri','BerkasController@berkas_mandiri')->name('berkas.berkas_mandiri');
Route::get('berkas-tertunda','BerkasController@berkas_tertunda')->name('berkas.berkas_tertunda');
Route::get('berkas-verifikasi','BerkasController@berkas_verifikasi')->name('berkas.berkas_verifikasi');
Route::put('verifikasi/{id}','BerkasController@verifikasi')->name('berkas.verifikasi');
Route::post('berkas-mandiri','BerkasController@store_mandiri')->name('berkas.store_mandiri');
Route::get('berkas-mandiri-print/{id}','BerkasController@berkas_mandiri_print')->name('berkas.berkas_mandiri_print');
Route::put('konfirmasi-berkas/{id}','BerkasController@konfirmasi_berkas')->name('berkas.konfirmasi_berkas');
Route::put('pembatalan-berkas/{id}','BerkasController@pembatalan_berkas')->name('berkas.pembatalan_berkas');
Route::put('penugasan/{id}','BerkasController@penugasan')->name('berkas.penugasan');
Route::post('selesai-berkas/{id}','BerkasController@selesai_berkas')->name('berkas.selesai_berkas');

// Download FILE
Route::get('download/{file}', 'FileController@downloadFile')->name('file.downloadFile');

// Berkas Petugas
Route::get('berkas-petugas','PetugasController@show_berkas')->name('petugas.show_berkas');

// Berkas PPAT
Route::get('berkas-ppat','PpatController@show_berkas')->name('ppat.show_berkas');

// Berkas Operator
Route::get('berkas-operator','OperatorController@show_berkas')->name('operator.show_berkas');
Route::get('berkas-operator-filter','OperatorController@show_berkas_filter')->name('operator.show_berkas_filter');

// Kantor
Route::resource('kantor','KantorController',['except' => ['create','edit']]);

// Setting
Route::put('change-pass','UserController@change_pass')->name('user.change_pass');
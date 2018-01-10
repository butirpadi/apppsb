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

Route::get('/', 'App\Controllers\LoginController@index');
Route::post('login/auth','App\Controllers\LoginController@auth');
Route::get('login/logout','App\Controllers\LoginController@logout');
Route::resource('login','App\Controllers\LoginController');

Route::get('home/index','App\Controllers\HomeController@index');
Route::resource('home','App\Controllers\HomeController');

Route::group(array('before'=>'auth','prefix' => 'master'), function() {

    Route::get('akun/histori/{id}', 'App\Controllers\Master\AkunController@histori');
    Route::get('akun/listakun/{id}', 'App\Controllers\Master\AkunController@listakun');
    Route::get('akun/getsaldo/{id}', 'App\Controllers\Master\AkunController@getsaldo');
    Route::post('akun/delete', 'App\Controllers\Master\AkunController@delete');
    Route::resource('akun', 'App\Controllers\Master\AkunController');
      
    
});

Route::group(array('before'=>'auth','prefix' => 'transaksi'), function() {
    
    Route::post('debet/kredit', 'App\Controllers\Transaksi\DebetController@kredit');
    Route::post('debet/debet', 'App\Controllers\Transaksi\DebetController@debet');
    Route::get('debet/siswabynis/{id}', 'App\Controllers\Transaksi\DebetController@siswabynis');
    Route::get('debet/datasiswa', 'App\Controllers\Transaksi\DebetController@datasiswa');
    Route::get('debet/saldo/{id}', 'App\Controllers\Transaksi\DebetController@saldo');
    Route::get('debet/lasttrans/{id}', 'App\Controllers\Transaksi\DebetController@lasttrans');
    Route::resource('debet', 'App\Controllers\Transaksi\DebetController');
    
    Route::get('tutup/detilsiswa/{id}', 'App\Controllers\Transaksi\TutupController@detilsiswa');
    Route::post('tutup/tutup', 'App\Controllers\Transaksi\TutupController@tutup');
    Route::get('tutup/siswabynis/{id}', 'App\Controllers\Transaksi\TutupController@siswabynis');
    Route::get('tutup/datasiswa', 'App\Controllers\Transaksi\TutupController@datasiswa');
    Route::get('tutup/saldo/{id}', 'App\Controllers\Transaksi\TutupController@saldo');
    Route::get('tutup/lasttrans/{id}', 'App\Controllers\Transaksi\TutupController@lasttrans');
    Route::resource('tutup', 'App\Controllers\Transaksi\TutupController');

});

Route::group(array('before'=>'auth','prefix' => 'rekap'), function() {
    
    Route::get('rekap/topdf/{awal}/{akhir}', 'App\Controllers\Rekap\RekapController@topdf');
    Route::get('rekap/gettransaksi/{awal}/{akhir}', 'App\Controllers\Rekap\RekapController@gettransaksi');
    Route::resource('rekap', 'App\Controllers\Rekap\RekapController');

});


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

//route root sementara
Route::get('/', 'App\Controllers\LoginController@index');
Route::post('login/auth','App\Controllers\LoginController@auth');
Route::get('login/logout','App\Controllers\LoginController@logout');
Route::resource('login','App\Controllers\LoginController');

//Route::get('/', 'App\Controllers\LoginController@index');

//Route::get('home/index',array('before'=>'auth','App\Controllers\HomeController@index') );


Route::group(array('before'=>'auth'), function() {   
    Route::get('home/index','App\Controllers\HomeController@index');
    Route::resource('home','App\Controllers\HomeController');
    
    Route::post('pengeluaran/addnew','App\Controllers\PengeluaranController@addnew');
    Route::get('pengeluaran/edit/{id}','App\Controllers\PengeluaranController@edit');
    Route::get('pengeluaran/delete/{id}','App\Controllers\PengeluaranController@delete');
    Route::post('pengeluaran/postedit','App\Controllers\PengeluaranController@postedit');
    Route::resource('pengeluaran','App\Controllers\PengeluaranController');
    
//    Route::get('report', 'App\Controllers\ReportController@index');
//    Route::resource('report', 'App\Controllers\ReportController');
    Route::controller('rpt', 'App\Controllers\ReportController');
});

Route::group(array('before'=>'auth','prefix' => 'master'), function() {
//Route::group(array('prefix' => 'master'), function() {

    Route::resource('gelombang', 'App\Controllers\Master\GelombangController');
    
    Route::resource('tapel', 'App\Controllers\Master\TapelController');
    
    Route::resource('kriteria', 'App\Controllers\Master\KriteriaController');
    
    Route::resource('setkriteria', 'App\Controllers\Master\SetkriteriaController');

    Route::get('biaya/pengaturan', 'App\Controllers\Master\BiayaController@pengaturan');
    Route::resource('biaya', 'App\Controllers\Master\BiayaController');
    
    Route::get('setbiaya/getbiaya/{id}', 'App\Controllers\Master\SetbiayaController@getbiaya');
    Route::post('setbiaya/simpan', 'App\Controllers\Master\SetbiayaController@simpan');
    Route::resource('setbiaya', 'App\Controllers\Master\SetbiayaController');
    
    Route::get('calonsiswa/getdeletepembayaran/{pembayaranid}', 'App\Controllers\Master\CalonsiswaController@getdeletepembayaran');
    Route::get('calonsiswa/gethistoripembayaran/{regnum}', 'App\Controllers\Master\CalonsiswaController@gethistoripembayaran');
    Route::get('calonsiswa/getcalonsiswa/{id}', 'App\Controllers\Master\CalonsiswaController@getcalonsiswa');
    Route::resource('calonsiswa', 'App\Controllers\Master\CalonsiswaController');
       
    
});

Route::group(array('before'=>'auth','prefix' => 'transaksi'), function() {
//Route::group(array('prefix' => 'transaksi'), function() {
    
    Route::get('seleksi/hasil','App\Controllers\Transaksi\SeleksiController@hasil');
    Route::get('seleksi/lulus','App\Controllers\Transaksi\SeleksiController@lulus');
    Route::resource('seleksi', 'App\Controllers\Transaksi\SeleksiController');
       
    Route::post('registrasi/getnota', 'App\Controllers\Transaksi\RegistrasiController@getnota');
    Route::get('registrasi/cetak', 'App\Controllers\Transaksi\RegistrasiController@cetak');
    Route::get('registrasi/test', 'App\Controllers\Transaksi\RegistrasiController@getTest');
    Route::get('registrasi/getgelombang/{id}', 'App\Controllers\Transaksi\RegistrasiController@getgelombang');
    Route::get('registrasi/getbiaya/{id}/{gel}/{jk}', 'App\Controllers\Transaksi\RegistrasiController@getbiaya');
    Route::get('registrasi/getregid/{id}', 'App\Controllers\Transaksi\RegistrasiController@getregid');
    Route::post('registrasi/simpan', 'App\Controllers\Transaksi\RegistrasiController@simpan');
    Route::resource('registrasi', 'App\Controllers\Transaksi\RegistrasiController');
    Route::post('registrasi/cetak-nota-registrasi', 'App\Controllers\Transaksi\RegistrasiController@postCetakNotaRegistrasi');
    
    Route::resource('pembayaran', 'App\Controllers\Transaksi\PembayaranController');
    
    Route::get('pelunasan/getnotapilihan/{regnum}/{tgl}', 'App\Controllers\Transaksi\PelunasanController@getnotapilihan');
    Route::get('pelunasan/getnotapilihan/{regnum}/{tgl}/{counter}', 'App\Controllers\Transaksi\PelunasanController@getnotapilihan');
    Route::get('pelunasan/recalculate-counter', 'App\Controllers\Transaksi\PelunasanController@getRecalculateCounter');
    Route::post('pelunasan/getnota', 'App\Controllers\Transaksi\PelunasanController@getnota');
    Route::post('pelunasan/simpan', 'App\Controllers\Transaksi\PelunasanController@simpan');
    Route::get('pelunasan/lunasi/{regid}', 'App\Controllers\Transaksi\PelunasanController@getlunasi');
    Route::get('pelunasan/getcalons', 'App\Controllers\Transaksi\PelunasanController@getcalons');
    Route::get('pelunasan/getstatusbayar/{regid}', 'App\Controllers\Transaksi\PelunasanController@getstatusbayar');
    Route::get('pelunasan/getdatapembayaran/{regid}', 'App\Controllers\Transaksi\PelunasanController@getdatapembayaran');
    Route::get('pelunasan/getcalonbyregid/{regid}', 'App\Controllers\Transaksi\PelunasanController@getcalonbyregid');
    Route::get('pelunasan/editbayar/{id}', 'App\Controllers\Transaksi\PelunasanController@editbayar');
    Route::get('pelunasan/editbayar/{id}/{regid}/{tgl}', 'App\Controllers\Transaksi\PelunasanController@editbayar');
    Route::post('pelunasan/batalkantransaksi', 'App\Controllers\Transaksi\PelunasanController@batalkantransaksi');
    Route::post('pelunasan/showpembayaran', 'App\Controllers\Transaksi\PelunasanController@showpembayaran');
    Route::post('pelunasan/deleteitembayar', 'App\Controllers\Transaksi\PelunasanController@deleteitembayar');
    Route::get('pelunasan/testprint', 'App\Controllers\Transaksi\PelunasanController@testprint');
    Route::resource('pelunasan', 'App\Controllers\Transaksi\PelunasanController');
    
    
    Route::post('distribusi/canceldistribute', 'App\Controllers\Transaksi\DistribusiController@canceldistribute');
    Route::post('distribusi/distribute', 'App\Controllers\Transaksi\DistribusiController@distribute');
    Route::get('distribusi/getcalonbytapel/{tapelid}', 'App\Controllers\Transaksi\DistribusiController@getcalonbytapel');
    Route::resource('distribusi', 'App\Controllers\Transaksi\DistribusiController');
});

Route::group(array('before'=>'auth','prefix' => 'rekap'), function() {
//Route::group(array('prefix' => 'rekap'), function() {    
    Route::get('rekap/topdf/{tapelid}/{awal}/{akhir}', 'App\Controllers\Rekap\RekapController@topdf');
    Route::get('rekap/getpembayaran/{awal}/{akhir}', 'App\Controllers\Rekap\RekapController@getpembayaran');
    Route::get('rekap/getregistrasi/{id}/{awal}/{akhir}', 'App\Controllers\Rekap\RekapController@getregistrasi');
    Route::resource('rekap', 'App\Controllers\Rekap\RekapController');
});


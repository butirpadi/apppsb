<?php

namespace App\Controllers\Transaksi;

class SeleksiController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach($tapels as $dt){
            $selectTapel[$dt->id] = $dt->nama;
        }
        
        return \View::make('transaksi.seleksi.index')->with('selectTapel',  $selectTapel);
    }
    
    public function hasil(){
        return \View::make('transaksi.seleksi.hasil');
    }
    
    public function lulus(){
        return \View::make('transaksi.seleksi.lulus');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return \View::make('transaksi.seleksi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        return \View::make('transaksi.seleksi.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}

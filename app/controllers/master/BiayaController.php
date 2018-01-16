<?php

namespace App\Controllers\Master;

use App\Models\Biaya;

class BiayaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return \View::make('master.biaya.index')->with('biaya', Biaya::all());
    }
    
    public function pengaturan(){
        return \View::make('master.biaya.pengaturan')->with('tapel', \App\Models\Tapel::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return \View::make('master.biaya.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $biaya = new Biaya();
        $biaya->nama = \Input::get('nama');
        $biaya->save();
        
        return \Redirect::route('master.biaya.index');
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
        return \View::make('master.biaya.edit')->with('biaya', biaya::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $biaya = Biaya::find($id);
        $biaya->nama = \Input::get('nama');
        $biaya->save();
        
        return \Redirect::route('master.biaya.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        \App::error(function(\Illuminate\Database\QueryException $ex){ 
            return \Redirect::route('master.biaya.index')->withErrors('Data tidak dapat dihapus, karena data telah digunakan pada transaksi sebelumnya.');
        });
        
        Biaya::whereId($id)->delete();
                
        return \Redirect::route('master.biaya.index');
    }

}

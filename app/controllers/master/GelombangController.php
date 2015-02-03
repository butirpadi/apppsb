<?php

namespace App\Controllers\Master;

use App\Models\Gelombang;

class GelombangController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return \View::make('master.gelombang.index')->with('tapel', \App\Models\Tapel::all());
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        
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
        return \View::make('master.gelombang.edit')->with('tapel', \App\Models\Tapel::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $tapel = \App\Models\Tapel::find($id);
        if($tapel->gelombang){
            $tapel->gelombang->jumlah = \Input::get('jumlah');
            $tapel->gelombang->save();
        }else{
            $gelombang = new Gelombang();
            $gelombang->jumlah = \Input::get('jumlah');
            $tapel->gelombang()->save($gelombang);
        }
        
        return \Redirect::route('master.gelombang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Gelombang::whereId($id)->delete();
        return \Redirect::route('master.gelombang.index');
    }

}

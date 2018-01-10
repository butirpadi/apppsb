<?php

namespace App\Controllers\Master;

use App\Models\Biaya;

class SetkriteriaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return \View::make('master.setkriteria.index')->with('tapel', \App\Models\Tapel::all());
    }  
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //return \View::make('master.setkriteria.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
//        $setkriteria = new Setkriteria();
//        $setkriteria->nama = \Input::get('nama');
//        $setkriteria->save();
//        
//        return \Redirect::route('master.setkriteria.index');
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
        return \View::make('master.setkriteria.edit')->with('tapel', \App\Models\Tapel::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $setkriteria = Setkriteria::find($id);
        $setkriteria->nama = \Input::get('nama');
        $setkriteria->save();
        
        return \Redirect::route('master.setkriteria.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Setkriteria::whereId($id)->delete();
        return \Redirect::route('master.setkriteria.index');
    }

}

<?php

namespace App\Controllers\Master;


class SetbiayaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $tapel = \App\Models\Tapel::all();

        return \View::make('master.setbiaya.index')
                ->with('tapel', $tapel);
    }  
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //return \View::make('master.setbiaya.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
//        $setbiaya = new Setbiaya();
//        $setbiaya->nama = \Input::get('nama');
//        $setbiaya->save();
//        
//        return \Redirect::route('master.setbiaya.index');
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
        return \View::make('master.setbiaya.edit')
                ->with('tapel', \App\Models\Tapel::find($id))
                ->with('biaya', \App\Models\Biaya::all());
    }
    
    /**
     * 
     * @param int $id tapelId
     * @return  JSON Mengembalikan data pengaturan biaya pada tahunpelajaran tertentu yang diinputkan
     */
    public function getbiaya($id){
        $tapel = \App\Models\Tapel::find($id);
        $biayas = $tapel->biayas;
        return $biayas->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
        
        //return \Redirect::route('master.setbiaya.index');
    }
    
    public function simpan(){
        //echo var_dump( json_decode(\Input::get('biayas')) );
        $biayasObj = json_decode(\Input::get('biayas'));
        $tapel = \App\Models\Tapel::find(\Input::get('tahunajaran_id'));
        $databiaya;
        //hapus yang pernah diisi
        $tapel->biayas()->detach();
        //attach satu-satu lagi
        foreach($biayasObj as $dt){
            //$databiaya[$dt->psbbiaya_id] = array('gelombang'=>$dt->gelombang,'nilai'=>$dt->nilai);
            $tapel->biayas()->attach($dt->psbbiaya_id,array('gelombang'=>$dt->gelombang,'p_nilai'=>$dt->p_nilai,'w_nilai'=>$dt->w_nilai));
        }
        
        echo var_dump($biayasObj);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Setbiaya::whereId($id)->delete();
        return \Redirect::route('master.setbiaya.index');
    }

}

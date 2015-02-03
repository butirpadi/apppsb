<?php

namespace App\Controllers\Master;

class CalonsiswaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach ($tapels as $dt) {
            $selectTapel[$dt->id] = $dt->nama;
        }

        return \View::make('master.calonsiswa.index')->with('selectTapel', $selectTapel);
    }
    
    /**
     * Hapus data transaksi pembayaran
     */
    public function getdeletepembayaran($pembayaranid){
        $pembayaran = \App\Models\Pembayaran::find($pembayaranid);
        $reg = $pembayaran->registrasi;
        $calon = $reg->calonsiswa;
        //delete pembayaran
        $pembayaran->delete();
        //return
        return \Redirect::route('master.calonsiswa.edit', $calon->id);
        
    }

    /**
     * 
     * @param type $id tapelid
     */
    public function getcalonsiswa($id) {
        $tapel = \App\Models\Tapel::find($id);
        $calon = $tapel->calonsiswas;

        return \View::make('master.calonsiswa.calonsiswa', array('calon' => $calon));
    }
    
    public function gethistoripembayaran($regid) {
        $calon = \App\Models\Calonsiswa::where('regnum', $regid)->first();
        $appset = \App\Models\Appsetting::first();
        
        return \View::make('master.calonsiswa.histori', array('calon' => $calon,'appset'=>$appset));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return \View::make('master.calonsiswa.create');
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
     * @param  int  $id calonsiswa_id
     * @return Response
     */
    public function edit($id) {
        $calon = \App\Models\Calonsiswa::with('tapelmasuk')->find($id);
        $tapelmasuk = \App\Models\Tapel::find($calon->tapelmasuk_id);
        $biayas = $tapelmasuk->biayas()->where('gelombang',$calon->gelombang)->get();
        $pembayaran = $calon->registrasi->pembayarans;
        
        $gelombang = $tapelmasuk->gelombang;
        $selGel;
        for ($i = 0; $i < $gelombang->jumlah; $i++) {
            $selGel[$i + 1] = 'Gelombang ' . ($i + 1);
        }
        
        return \View::make('master.calonsiswa.edit', array('calon' => $calon,'biayas'=>$biayas,'pembayaran'=>$pembayaran,'selGelombang'=>$selGel));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $calon = \App\Models\Calonsiswa::find($id);
        $calon->nama = \Input::get('nama');
        $calon->diterima = \Input::get('status');
        $calon->gelombang = \Input::get('gelombang');
        $calon->save();

        return \Redirect::route('master.calonsiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id calonsiswaId
     * @return Response
     */
    public function destroy($id) {
        //delete calon siswa dari beberapa table yang ber-relasi
         \DB::transaction(function() use($id) {
             $calon = \App\Models\Calonsiswa::find($id);
             
             //jika sudah di distribusikan hapus data distribusi
             if($calon->siswa_id != null || $calon->siswa_id != ''){
                 //hapus rombelsiswa
                \DB::table('rombelsiswa')->where('siswa_id',$calon->siswa_id)->delete();
                //hapus siswanya
                \DB::table('siswa')->where('id',$calon->siswa_id)->delete();
                //hapus siswa id dan rombel id di calon
                \DB::table('psb_calon_siswa')->where('id',$calon->id)->update(array(
                    'siswa_id'=>null,
                    'rombel_id'=>null
                ));
             }
             
            //delete dari table pembayaran
            $calon->registrasi->pembayarans()->delete();
            //delete dari table registrasi
            $calon->registrasi->delete();
            //delete dari table calon
            $calon->delete();           
            
         });
         
         return \Redirect::route('master.calonsiswa.index');
    }

}

<?php

namespace App\Controllers\Transaksi;

class DistribusiController extends \BaseController {

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
        $appset = \App\Models\Appsetting::first();
        return \View::make('transaksi.distribusi.index', array('selectTapel' => $selectTapel,'appset'=>$appset));
    }
    
    /**
     * mengembalikan data calon siswa yang telah diterima
     * @param type $tapelid tapel id
     */
    public function getcalonbytapel($tapelid){
        $tapel = \App\Models\Tapel::find($tapelid);
        $calon = \App\Models\Calonsiswa::where('tapelmasuk_id',$tapel->id)->where('diterima','Y')->get();
        $rombels = \App\Models\Rombel::where('jenjang',1)->get();
        $selectRombel = [];
        foreach($rombels as $dt){
            $selectRombel[$dt->id] = $dt->nama;
        }
        
        return \View::make('transaksi.distribusi.calonsiswa',array('calon'=>$calon,'rombels'=>$rombels,'selectRombel'=>$selectRombel));
    }
    
    /**
     * Distribusi siswa ke rombel
     * @param type $tapelid
     * @param type $regid
     * @param type $rombelid
     */
    public function distribute(){
        $tapel = \App\Models\Tapel::find(\Input::get('tapelid'));
        $rombel = \App\Models\Rombel::find(\Input::get('rombelid'));
        $calon = \App\Models\Calonsiswa::find(\Input::get('calonid'));
        
        $idsiswa = \DB::transaction(function()use($tapel,$rombel,$calon) {
            //input ke data siswa
            $siswaId = \DB::table('siswa')->insertGetId(array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'nisn'=>$calon->nisn,
                'nama'=>$calon->nama,
                'jenjang_spp'=>'1',
                'psbcalonsiswa_id'=>$calon->id
            ));            
            
            \DB::table('rombelsiswa')->insert(array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'tahunajaran_id'=>$tapel->id,
                'rombel_id'=>$rombel->id,
                'siswa_id'=>$siswaId
            ));
            
            //update calon siswa set diterima di rombel id berapa
            $calon->rombel_id = $rombel->id;
            $calon->siswa_id = $siswaId;
            $calon->save();            
            
            return $siswaId;
        });
        
        
        return $idsiswa;
        //return \Redirect::to('transaksi.distribusi.index');
    }
    
    public function canceldistribute(){
        $siswa = \App\Models\Siswa::find(\Input::get('siswaid'));
        $calon = $siswa->calonsiswa;        
        
        \DB::transaction(function()use($siswa,$calon) {
            //hapus rombelsiswa
            \DB::table('rombelsiswa')->where('siswa_id',$siswa->id)->delete();
            //hapus siswanya
            \DB::table('siswa')->where('id',$siswa->id)->delete();
            //hapus siswa id dan rombel id di calon
            \DB::table('psb_calon_siswa')->where('id',$calon->id)->update(array(
                'siswa_id'=>null,
                'rombel_id'=>null
            ));
            
        });
        
    }

}

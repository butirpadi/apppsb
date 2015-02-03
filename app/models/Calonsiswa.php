<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Counter
 *
 * @author eries
 */
class Calonsiswa extends \Eloquent {

    protected $table = 'psb_calon_siswa';

    public function tapelmasuk(){
        return $this->belongsTo('App\Models\Tapel','tapelmasuk_id');
    }
    
    public function tapeldaftar(){
        return $this->belongsTo('App\Models\Tapel','tapeldaftar_id');
    }
    
    public function registrasi(){
        return $this->hasOne('App\Models\Registrasi','psbcalonsiswa_id');
    }
    
    public function rombel(){
        return $this->belongsTo('\App\Models\Rombel');
    }
    
    public function siswa(){
        return $this->belongsTo('\App\Models\Siswa');
    }
}

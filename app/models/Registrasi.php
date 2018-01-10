<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registrasi
 *
 * @author eries
 */
class Registrasi extends \Eloquent{
    
    protected $table = 'psb_registrasi';
    
    public function calonsiswa(){
        return $this->belongsTo('App\Models\Calonsiswa','psbcalonsiswa_id');
    }
    
    public function pembayarans(){
        return $this->hasMany('App\Models\Pembayaran','psbregistrasi_id');
    }
    
    
}

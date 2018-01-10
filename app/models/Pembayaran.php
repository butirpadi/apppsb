<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pembayaran
 *
 * @author eries
 */
class Pembayaran extends \Eloquent{
    
    protected $table = 'psb_pembayaran';
    
    public function registrasi(){
        return $this->belongsTo('App\Models\Registrasi','psbregistrasi_id');
    }    
    
    public function biaya(){
        return $this->belongsTo('App\Models\Biaya','psbbiaya_id');
    }    
    
}

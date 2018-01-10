<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Biaya
 *
 * @author eries
 */
class Biaya extends \Eloquent{
    
    protected $table = 'psb_biaya';
    
    public function tapels(){
        return $this->belongsToMany('App\Models\Tapel','psb_biaya_per_tahunajaran','psbbiaya_id','tahunajaran_id')->withTimestamps()->withPivot(array('p_nilai','w_nilai','gelombang'));
    }
    
    public function pembayarans(){
        return $this->hasMany('App\Models\Pembayaran','psbbiaya_id');
    }
    
}

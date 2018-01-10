<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tapel
 *
 * @author eries
 */
class Tapel extends \Eloquent{
    
    protected $table = 'tahunajaran';
    
    public function biayas(){
        return $this->belongsToMany('App\Models\Biaya','psb_biaya_per_tahunajaran','tahunajaran_id','psbbiaya_id')->withTimestamps()->withPivot(array('p_nilai','w_nilai','gelombang'));
    }
    
    public function gelombang(){
        return $this->hasOne('App\Models\Gelombang', 'tahunajaran_id');
    }
    
    public function regcounter(){
        return $this->hasOne('App\Models\Regcounter', 'tahunajaran_id');
    }
    
    public function calonsiswas(){
        return $this->hasMany('App\Models\Calonsiswa','tapelmasuk_id');
    }
    
    public function pendaftarancalonsiswas(){
        return $this->hasMany('App\Models\Calonsiswa','tapeldaftar_id');
    }
    
    
    
    
    
}

<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rombel
 *
 * @author eries
 */
class Rombel extends \Eloquent{
    
    protected $table = 'rombel';
    
    public function siswas(){
        return $this->belongsToMany('\App\Models\Siswa', 'rombelsiswa', 'rombel_id','siswa_id');
    }
    
    public function calonsiswas(){
        return $this->hasMany('\App\Models\Calonsiswa');
    }
    
}

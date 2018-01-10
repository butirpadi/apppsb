<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Siswa
 *
 * @author eries
 */
class Siswa extends \Eloquent{
    
    protected $table = 'siswa';
    
    public function rombels(){
        return $this->belongsToMany('\App\Models\Rombel', 'rombelsiswa', 'siswa_id','rombel_id');
    }
    
    public function calonsiswa(){
        return $this->hasOne('\App\Models\Calonsiswa', 'siswa_id');
    }
    
}

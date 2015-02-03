<?php

namespace App\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gelombang
 *
 * @author eries
 */
class Gelombang extends \Eloquent{
    
    protected $table = 'psb_gelombang';
    
    public function tapel(){
        return $this->belongsTo('App\Models\Tapel');
    }
    
}

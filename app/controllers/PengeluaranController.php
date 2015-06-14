<?php

namespace App\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author eries
 */
class PengeluaranController extends \BaseController {

    public function index() {
        return \View::make('pengeluaran.index');
//        return \View::make('pengeluaran.index');
    }
    
    public function addnew(){
        echo 'simpan pengeluaran baru';
    }

}

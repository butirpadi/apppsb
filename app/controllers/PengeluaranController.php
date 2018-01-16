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
        $data = \DB::table('psb_pengeluaran')->orderBy('created_at', 'desc')->get();
        return \View::make('pengeluaran.index', array(
                    'data' => $data
        ));
//        return \View::make('pengeluaran.index');
    }

    public function addnew() {
        \DB::table('psb_pengeluaran')->insert(array(
            'tgl' => date('Y-m-d', strtotime(\Input::get('tgl'))),
            'keterangan' => \Input::get('keterangan'),
            'jumlah' => str_replace(' ','',str_replace('.', '', str_replace(',', '', str_replace('Rp.', '', \Input::get('jumlah'))))) ,
        ));

        return \Redirect::back();
    }

    public function edit($id) {
        $data = \DB::table('psb_pengeluaran')->find($id);
        return \View::make('pengeluaran.edit', array(
                    'data' => $data
        ));
    }

    public function postedit() {
        \DB::table('psb_pengeluaran')->where('id', \Input::get('dataid'))->update(array(
            'keterangan' => \Input::get('keterangan'),
            'jumlah' => str_replace(' ','',str_replace('.', '', str_replace(',', '', str_replace('Rp.', '', \Input::get('jumlah'))))) ,
            'tgl' => \Input::get('tgl'),
        ));

        return \Redirect::back();
    }
    
    public function delete($id){
        \DB::table('psb_pengeluaran')->where('id',$id)->delete();
        return \Redirect::back();
    }

}

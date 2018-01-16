<?php

namespace App\Controllers\Transaksi;

class RegistrasiController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach ($tapels as $dt) {
            $selectTapel[$dt->id] = $dt->nama;
        }

        $tapelAktif = \App\Models\Tapel::where('aktif', 'Y')->first();
        $appset = \App\Models\Appsetting::first();

        //return \View::make('transaksi.registrasi.index')->with('selectTapel',  $selectTapel);
        return \View::make('transaksi.registrasi.index', array('selectTapel' => $selectTapel, 'tapelAktif' => $tapelAktif, 'tapels' => $tapels,'appset'=>$appset));
    }

    /**
     * 
     * @param int $id tapel_id
     */
    public function getgelombang($id) {
        $tapel = \App\Models\Tapel::find($id);
        $gelombang = $tapel->gelombang;
        $selGel;
        for ($i = 0; $i < $gelombang->jumlah; $i++) {
            $selGel[$i + 1] = 'Gelombang ' . ($i + 1);
        }
        return \Form::select('gelombang', $selGel, null, array('class' => 'input-medium'));
    }

    /**
     * Get biaya registrasi
     * @param int $id tapel_id
     * @param int $gel gelombang
     */
    public function getbiaya($id, $gel, $jk) {
        $tapel = \App\Models\Tapel::find($id);
        $biayas = $tapel->biayas()->where('gelombang', $gel)->get();
        return \View::make('transaksi.registrasi.biayareg', array('biayas' => $biayas, 'jk' => $jk));
    }

    /**
     * 
     * @param type $id tapelId
     */
    public function getregid($id) {
        $tapel = \App\Models\Tapel::find($id);
        $regcounter = \App\Models\Regcounter::where('tahunajaran_id', $id)->first();
        if (!$regcounter) {
            //bikin baru
            $regcounter = new \App\Models\Regcounter();
            $regcounter->tahunajaran_id = $id;
            $regcounter->save();
        }
        //generate regid
        $regid = 'PSB' . $tapel->id . ($regcounter->counter + 1);

        return $regid;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return \View::make('transaksi.registrasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $calon = new \App\Models\Calonsiswa();
        $calon->tapeldaftar_id = \Input::get('tapelaktif');
        $calon->tapelmasuk_id = \Input::get('tapel');
        $calon->regnum = \Input::get('regid');
        $calon->nama = \Input::get('nama');
        $calon->save();

        //update reg_counter
        $regcounter = \App\Models\Regcounter::where('tahunajaran_id', \Input::get('tapel'))->first();
        $regcounter->counter +=1;
        $regcounter->save();

        return \Redirect::route('transaksi.registrasi.index');
    }

    /**
     * Simpan Transaksi dengan POST METHOD
     */
    public function simpan() {
        \DB::transaction(function() {
            $dataReg = json_decode(\Input::get('datareg'));
            $dataBayar = json_decode(\Input::get('databayar'));

            echo 'begin transaction.....<br/>';
            //insert to calon siswa
            $calonId = \DB::table('psb_calon_siswa')->insertGetId(array(
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'tapeldaftar_id' => $dataReg->tapeldaftar_id,
                'tapelmasuk_id' => $dataReg->tapelmasuk_id,
                'gelombang' => $dataReg->gelombang,
                'regnum' => $dataReg->regnum,
                'nama' => strtoupper($dataReg->nama),
                'jenis_kelamin' => $dataReg->jk,
                'diterima' => $dataReg->status
            ));
            echo 'Calon siswa id : ' . $calonId . '<br/>';
            //insert to psb_registrasi
            $regId = \DB::table('psb_registrasi')->insertGetId(array(
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'tgl' => date('Y-m-d',  strtotime($dataReg->tgl)),
                'psbcalonsiswa_id' => $calonId
            ));
            echo 'Registrasi ID : ' . $regId . '<br/>';
            //insert ke psb_pembayaran
            //
            // revisi 16012018
            $appset = \App\Models\Appsetting::first();
            $reg_counter = $appset->psb_reg_payment_counter;
            echo 'psb_reg_payment_counter : ' . $reg_counter . '<br/>';
            // update reg counter
            \DB::table('appsetting')->update([
                'psb_reg_payment_counter' => $reg_counter+1
            ]);
            // --------------------------------------

            for ($i = 0; $i < count($dataBayar); $i++) {
                echo 'Begin insert pembayaran ... <br/>';
                \DB::table('psb_pembayaran')->insert(array(
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'psbregistrasi_id' => $regId,
                    'psbbiaya_id' => $dataBayar[$i]->psbbiaya_id,
                    'harusbayar' => $dataBayar[$i]->harusbayar,
                    'dibayar' => $dataBayar[$i]->dibayar,
                    'potongan' => $dataBayar[$i]->potongan,
                    'reg_counter' => $reg_counter,
                    'tgl' => date('Y-m-d',strtotime($dataReg->tgl))
                ));
                echo 'insert data ke ' . ($i + 1) . '<br/>';
                echo '........<br/>';
            }
            //update reg_counter
            $regounter = \DB::table('psb_reg_counter')->where('tahunajaran_id', $dataReg->tapelmasuk_id)->first();
            \DB::table('psb_reg_counter')->where('tahunajaran_id', $dataReg->tapelmasuk_id)->update(array('counter' => ($regounter->counter + 1)));
        });

        return 'Selamat anda berhasil';
    }

    /**
     * Cetak nota dengan POST METHOD
     */
    public function cetak() {
//        $dataReg = json_decode(\Input::get('datareg'));
//        $dataBayar = json_decode(\Input::get('databayar'));

        return 'ok';
    }

    public function getnota() {
        $datareg = json_decode(\Input::get('datareg'));
        $databayar = json_decode(\Input::get('databayar'));
        
        $Data = "";
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $initialized = chr(27) . chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);
        $tanggaltrans = date('Y-m-d');
        $appset = \App\Models\Appsetting::first();
        $tahunajaran = \App\Models\Tapel::find($datareg->tapelmasuk_id);
        $datacetakbaru = "";
        $l_no = 3;
        $l_biaya = 11;
        $l_pot = 12;
        $l_tarif = 13;
        $l_jumlah = 13;
        $rowkertas = $appset->linekertas;
        $rowsisa = $rowkertas - 17;
        $spaceprinter = $appset->spaceprinter;
        $jumlahitem = 0;
        //$user = Auth::retrieve(Session::get('onuser_id'));
        $total = 0;
        $Data = $initialized;
        $Data .= $condensed1;
        $Data .= $this->generate_space(($appset->charcount - strlen('TANDA BUKTI PEMBAYARAN PSB ' . $tahunajaran->nama)) / 2, "") . "TANDA BUKTI PEMBAYARAN PSB " . $tahunajaran->nama . "\n";
        //$Data .= $this->generate_space(($appset->charcount - strlen($tahunajaran->nama)) / 2, "") . $tahunajaran->nama . "\n";
        $Data .= $this->generate_space(($appset->charcount - strlen('SDI SABILIL HUDA')) / 2, "") . "SDI SABILIL HUDA\n";
        $Data .= $this->generate_space(($appset->charcount - strlen('Jl. Singokarso 54 Sumorame, Candi, Sidoarjo')) / 2, "") . "Jl. Singokarso 54 Sumorame, Candi, Sidoarjo\n\n";
        $Data .= "Nama : " . ucwords($datareg->nama) . "\n";
        $Data .= "No. Registrasi   : " . $datareg->regnum . $this->generate_space($appset->charcount - strlen("No. Registrasi   : " . $datareg->regnum), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
        $Data .= "---+-----------+-------------+------------+-------------\n";
        $Data .= " NO    BIAYA       TARIF          POT          BAYAR    \n";
        $Data .= "---+-----------+-------------+------------+-------------\n";
        //$Data .= $datacetakbaru;
        $rownum = 1;
        for ($i = 0; $i < count($databayar); $i++) {
            $isi_num = $this->generate_space($l_no, $rownum) . $rownum++;
            $biaya = \App\Models\Biaya::find($databayar[$i]->psbbiaya_id);
            $isi_biaya = $biaya->nama . $this->generate_space($l_biaya, $biaya->nama);
            $isi_pot = $this->generate_space($l_pot, number_format($databayar[$i]->potongan, 0, ',', '.')) . number_format($databayar[$i]->potongan, 0, ',', '.');
            $tarif = $this->generate_space($l_tarif, number_format($databayar[$i]->harusbayar, 0, ',', '.')) . number_format($databayar[$i]->harusbayar, 0, ',', '.');
            $dibayar = $this->generate_space($l_jumlah, number_format($databayar[$i]->dibayar, 0, ',', '.')) . number_format($databayar[$i]->dibayar, 0, ',', '.');
            $Data .= $isi_num . ' ' . $isi_biaya . ' ' . $tarif . ' ' . $isi_pot . ' ' . $dibayar . "\n";
            $jumlahitem++;
            $total += $databayar[$i]->dibayar;
        }
        $Data .= "--------------------------------------------------------\n";
        $Data .= "TOTAL BAYAR" . $this->generate_space($appset->charcount - strlen("TOTAL BAYAR"), "Rp. " . number_format($total, 0, ',', '.')) . "Rp. " . number_format($total, 0, ',', '.') . "\n";
        $Data .= "--------------------------------------------------------\n";
        $Data .= $this->generate_space($appset->charcount - strlen('TTD'), "") . "TTD\n";
        $Data .= "\n";
        $Data .= $this->generate_space($appset->charcount - strlen('Bagian TU'), "") . 'Bagian TU' . "\n";
        $Data .= "\n";
        $Data .= $this->generate_space(($appset->charcount - strlen('Nota dianggap sah jika sudah dibubuhi stempel')) / 2, "") . "Nota dianggap sah jika sudah dibubuhi stempel\n";
        $Data .= $this->generate_space(($appset->charcount - strlen('dan tanda tangan dari Bagian TU')) / 2, "") . "dan tanda tangan dari Bagian TU\n";
        //sisa kertas
        $entercount = $rowsisa - $jumlahitem + $spaceprinter;
        for ($i = 0; $i < $entercount; $i++) {
            $Data.="\n ";
        }
        return $Data;
    }

    public function generate_space($space, $kata) {
        $res = "";
        for ($i = 0; $i < ($space - strlen($kata)); $i++) {
            $res .= " ";
        }

        return $res;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        return \View::make('transaksi.registrasi.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function postCetakNotaRegistrasi(){
        echo \Input::get('nota_text');
        $appset = \App\Models\Appsetting::first();
        $Data = "";
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $initialized = chr(27) . chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);
        
        $Data = $initialized;
        $Data .= $condensed1;
        $Data .= \Input::get('nota_text');

        // Printing Using PHP Copy
        // REVISI TGL : 18/05/2017      
        $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
        $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
        $handle = fopen($file, 'w');
        // echo $Data;
        fwrite($handle, $Data);
        fclose($handle);
        //copy($file, "//localhost/LX-300");  # Lakukan cetak
        // copy($file, $appset->printeraddr);  # Lakukan cetak
        // unlink($file);
        
        // Revisi 16-01-2018
        if($appset->using_winrawprint == 'Y'){
                // using raw printer app
            exec($appset->winrawprint_loc . ' -p "' . $appset->printeraddr . '" '. $file);
        }else{
            // using copy
            copy($file, $appset->printeraddr);  # Lakukan cetak                                    
        }
        unlink($file);
    }

    public function getTest(){
        $appset = \App\Models\Appsetting::first();
        $reg_counter = $appset->psb_reg_payment_counter;
            echo 'psb_reg_payment_counter : ' . $reg_counter . '<br/>';
        \DB::table('appsetting')->update([
                'psb_reg_payment_counter' => $reg_counter+1
            ]);
    }

}

<?php

namespace App\Controllers\Transaksi;

class PelunasanController extends \BaseController {

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
        $appset = \App\Models\Appsetting::first();
        return \View::make('transaksi.pelunasan.index', array('selectTapel' => $selectTapel, 'appset' => $appset));
    }

    /**
     * 
     * @param char $regid registrasi ID
     */
    public function getcalonbyregid($regid) {
        $calon = \App\Models\Calonsiswa::where('regnum', $regid)->first();
        return ($calon ? $calon->toJSON() : NULL);
    }

    /**
     * get data pembayaran
     * @param type $regid
     */
    public function getdatapembayaran($regid) {
        $calon = \App\Models\Calonsiswa::where('regnum', $regid)->first();
        $appset = \App\Models\Appsetting::first();

        return \View::make('transaksi.pelunasan.databayar', array('calon' => $calon, 'appset' => $appset));
    }

//    public function getstatusbayar($tapelid,$regid){
//        $calon = \App\Models\Calonsiswa::where('regnum',$regid)->first();
//        $tapel = \App\Models\Tapel::find($tapelid);
//        return \View::make('transaksi.pelunasan.statusbayar',array('calon'=>$calon,'tapel'=>$tapel));
//    }
    public function getstatusbayar($regid) {
        $calon = \App\Models\Calonsiswa::where('regnum', $regid)->first();
        $tapel = \App\Models\Tapel::find($calon->tapelmasuk_id);
        return \View::make('transaksi.pelunasan.statusbayar', array('calon' => $calon, 'tapel' => $tapel));
    }

    public function getcalons() {
        $latestTapel = \App\Models\Tapel::wherePosisi(\App\Models\Tapel::max('posisi'))->first();

        $calon = \App\Models\Calonsiswa::orderBy('created_at', 'desc')->get();

        return \View::make('transaksi.pelunasan.calons', array('calons' => $calon));
    }

    /**
     * mengembalikan view proses pelunasan biaya yg belum lunas
     * @param type $regid
     * @return type
     */
    public function getlunasi($regid) {
        $calon = \App\Models\Calonsiswa::where('regnum', $regid)->first();
        $tapel = \App\Models\Tapel::find($calon->tapelmasuk_id);
        return \View::make('transaksi.pelunasan.lunasi', array('calon' => $calon, 'tapel' => $tapel));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        
    }

    /**
     * Simpan Transaksi dengan POST METHOD
     */
    public function simpan() {
        $res = '';
        \DB::transaction(function() {

            $datareg = json_decode(\Input::get('datareg'));
            $databayar = json_decode(\Input::get('databayar'));

            $calon = \App\Models\Calonsiswa::where('regnum', $datareg->regnum)->first();
            $registrasi = $calon->registrasi;

            echo 'begin transaction.....<br/>';
            //insert ke psb_pembayaran
            for ($i = 0; $i < count($databayar); $i++) {
                echo 'Begin insert pembayaran ... <br/>';
                \DB::table('psb_pembayaran')->insert(array(
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'psbregistrasi_id' => $registrasi->id,
                    'psbbiaya_id' => $databayar[$i]->psbbiaya_id,
                    'harusbayar' => $databayar[$i]->harusbayar,
                    'dibayar' => $databayar[$i]->dibayar,
                    'potongan' => $databayar[$i]->potongan,
                    'tgl' => date('Y-m-d', strtotime($datareg->tgl))
                ));
                echo 'insert data ke ' . ($i + 1) . '<br/>';
                echo '........<br/>';
            }
        });

        return $res;
    }

    /**
     * get nota pembayaran
     * @return string
     */
    public function getnota() {
        $datareg = json_decode(\Input::get('datareg'));
        $databayar = json_decode(\Input::get('databayar'));
        $calon = \App\Models\Calonsiswa::where('regnum', $datareg->regnum)->first();
        $registrasi = $calon->registrasi;

        $Data = "";
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $initialized = chr(27) . chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);
        $tanggaltrans = date('Y-m-d');
        $appset = \App\Models\Appsetting::first();
        $tahunajaran = \App\Models\Tapel::find($calon->tapelmasuk_id);
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
        $Data .= "Nama : " . ucwords($calon->nama) . "\n";
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
        // return $Data;

        // Printing Using PHP Copy
        // REVISI TGL : 18/05/2017      
        $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
        $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
        $handle = fopen($file, 'w');
        // echo $Data;
        fwrite($handle, $Data);
        fclose($handle);
        //copy($file, "//localhost/LX-300");  # Lakukan cetak
        copy($file, $appset->printeraddr);  # Lakukan cetak
        unlink($file);
    }

    public function getnotapilihan($regnum, $tgl) {
        $tglPembayaran = date('Y-m-d', strtotime($tgl));
        $calon = \App\Models\Calonsiswa::where('regnum', $regnum)->first();
        $reg = $calon->registrasi;
        $pembayaran = $reg->pembayarans()->where('tgl', $tglPembayaran)->get();

        $Data = "";
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $initialized = chr(27) . chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);
        $tanggaltrans = $tglPembayaran;
        $appset = \App\Models\Appsetting::first();
        $tahunajaran = \App\Models\Tapel::find($calon->tapelmasuk_id);
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
        $Data .= "Nama : " . ucwords($calon->nama) . "\n";
        $Data .= "No. Registrasi   : " . $regnum . $this->generate_space($appset->charcount - strlen("No. Registrasi   : " . $regnum), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
        $Data .= "---+-----------+-------------+------------+-------------\n";
        $Data .= " NO    BIAYA       TARIF          POT          BAYAR    \n";
        $Data .= "---+-----------+-------------+------------+-------------\n";
        //$Data .= $datacetakbaru;
        $rownum = 1;
        foreach ($pembayaran as $dt) {
            $isi_num = $this->generate_space($l_no, $rownum) . $rownum++;
            $biaya = \App\Models\Biaya::find($dt->psbbiaya_id);
            $isi_biaya = $biaya->nama . $this->generate_space($l_biaya, $biaya->nama);
            $isi_pot = $this->generate_space($l_pot, number_format($dt->potongan, 0, ',', '.')) . number_format($dt->potongan, 0, ',', '.');
            $tarif = $this->generate_space($l_tarif, number_format($dt->harusbayar, 0, ',', '.')) . number_format($dt->harusbayar, 0, ',', '.');
            $dibayar = $this->generate_space($l_jumlah, number_format($dt->dibayar, 0, ',', '.')) . number_format($dt->dibayar, 0, ',', '.');
            $Data .= $isi_num . ' ' . $isi_biaya . ' ' . $tarif . ' ' . $isi_pot . ' ' . $dibayar . "\n";
            $jumlahitem++;
            $total += $dt->dibayar;
        }

//        for ($i = 0; $i < count($databayar); $i++) {
//            $isi_num = $this->generate_space($l_no, $rownum) . $rownum++;
//            $biaya = \App\Models\Biaya::find($databayar[$i]->psbbiaya_id);
//            $isi_biaya = $biaya->nama . $this->generate_space($l_biaya, $biaya->nama);
//            $isi_pot = $this->generate_space($l_pot, number_format($databayar[$i]->potongan, 0, ',', '.')) . number_format($databayar[$i]->potongan, 0, ',', '.');
//            $tarif = $this->generate_space($l_tarif, number_format($databayar[$i]->harusbayar, 0, ',', '.')) . number_format($databayar[$i]->harusbayar, 0, ',', '.');
//            $dibayar = $this->generate_space($l_jumlah, number_format($databayar[$i]->dibayar, 0, ',', '.')) . number_format($databayar[$i]->dibayar, 0, ',', '.');
//            $Data .= $isi_num . ' ' . $isi_biaya . ' ' . $tarif . ' ' . $isi_pot . ' ' . $dibayar . "\n";
//            $jumlahitem++;
//            $total += $databayar[$i]->dibayar;
//        }
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
        // return $Data;

        // Printing Using PHP Copy
        // REVISI TGL : 18/05/2017      
        $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
        $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
        $handle = fopen($file, 'w');
        // echo $Data;
        fwrite($handle, $Data);
        fclose($handle);
        //copy($file, "//localhost/LX-300");  # Lakukan cetak
        copy($file, $appset->printeraddr);  # Lakukan cetak
        unlink($file);
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

    /**
     * Edit transaksi pembayaran
     * @param type $id
     * @return type
     */
    function editbayar($id, $regid = null, $tgl = null) {


        if ($regid != null) {
            $bayar = \DB::table('psb_pembayaran')->where('psbregistrasi_id', $regid)->where('tgl', $tgl)->first();
//            $bayar = \DB::table('psb_pembayaran')->find($id);
            $calon = \DB::table('psb_calon_siswa')->where('id', \DB::table('psb_registrasi')->where('id', $bayar->psbregistrasi_id)->first()->psbcalonsiswa_id)->first();
            $databayar = \DB::table('view_psb_pembayaran')->where('psbregistrasi_id', $bayar->psbregistrasi_id)->where('tgl', $bayar->tgl)->get();
            $total = \DB::table('psb_pembayaran')->where('psbregistrasi_id', $bayar->psbregistrasi_id)->where('tgl', $bayar->tgl)->sum('dibayar');
        } else {
            $bayar = \DB::table('psb_pembayaran')->find($id);
            $calon = \DB::table('psb_calon_siswa')->where('id', \DB::table('psb_registrasi')->where('id', $bayar->psbregistrasi_id)->first()->psbcalonsiswa_id)->first();
            $databayar = \DB::table('view_psb_pembayaran')->where('psbregistrasi_id', $bayar->psbregistrasi_id)->where('tgl', $bayar->tgl)->get();
            $total = \DB::table('psb_pembayaran')->where('psbregistrasi_id', $bayar->psbregistrasi_id)->where('tgl', $bayar->tgl)->sum('dibayar');
        }

        return \View::make('transaksi.pelunasan.editbayar', array(
                    'databayar' => $databayar,
                    'calon' => $calon,
                    'bayar' => $bayar,
                    'total' => $total
        ));
    }

    /**
     * Delete salah satu item pembayaran
     */
    function deleteitembayar() {
        $data = \DB::table('psb_pembayaran')->find(\Input::get('psb_pembayaran_id'));
        \DB::select("CALL SP_DELETE_PSB_PEMBAYARAN('" . \Input::get('psb_pembayaran_id') . "')");

        return \Redirect::to('transaksi/pelunasan/editbayar/null/' . $data->psbregistrasi_id . '/' . $data->tgl);
    }

    function batalkantransaksi() {
        $data = \DB::table('psb_pembayaran')->find(\Input::get('psb_pembayaran_id'));

        $databayar = \DB::table('psb_pembayaran')->where('psbregistrasi_id', $data->psbregistrasi_id)->where('tgl', $data->tgl)->get();

        //delete item pembayaran
        foreach ($databayar as $db) {
            \DB::select("CALL SP_DELETE_PSB_PEMBAYARAN('" . $db->id . "')");
        }

        return \Redirect::to('transaksi/pelunasan');
    }

    function showpembayaran() {
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach ($tapels as $dt) {
            $selectTapel[$dt->id] = $dt->nama;
        }
        $appset = \App\Models\Appsetting::first();


        $calon = \App\Models\Calonsiswa::where('regnum', \Input::get('regid'))->first();
        $tapel = \App\Models\Tapel::find($calon->tapelmasuk_id);

        return \View::make('transaksi.pelunasan.show', array(
                    'regid' => \Input::get('regid'),
                    'nama' => \Input::get('nama'),
                    'tgl' => \Input::get('tgl'),
                    'selectTapel' => $selectTapel,
                    'appset' => $appset,
                    'tapel' => $tapel,
                    'calon' => $calon
        ));
    }
    
    function testprint(){
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach ($tapels as $dt) {
            $selectTapel[$dt->id] = $dt->nama;
        }
        $appset = \App\Models\Appsetting::first();
        return \View::make('transaksi.pelunasan.testprint', array('selectTapel' => $selectTapel, 'appset' => $appset));
    }

}

<?php

namespace App\Controllers\Rekap;

use App\Models\Rekap;

class RekapController extends \BaseController {

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
        return \View::make('rekap.rekap.index',array('selectTapel'=>$selectTapel));
    }

    /**
     * 
     * @param type $id tapelid
     */
    public function getregistrasi($id, $awal, $akhir) {
        $tapel = \App\Models\Tapel::find($id);

        $registrasi = \App\Models\Registrasi::where('tgl', '>=', date('Y-m-d', strtotime($awal)))
                ->where('tgl', '<=', date('Y-m-d', strtotime($akhir)))
                ->get();
        
        $biayas = $tapel->biayas();

        return \View::make('rekap.rekap.calonsiswa',array('registrasi'=>$registrasi,'biayas'=>$biayas));
    }
    
    public function getpembayaran($awal,$akhir){
        $pembayaran = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->select('psbregistrasi_id','tgl')->distinct()->get();
        $pembayarans = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->get();
        
        return \View::make('rekap.rekap.pembayaran',array('pembayaran'=>$pembayaran,'pembayarans'=>$pembayarans));
        
    }
    
    public function topdf($tapelid,$awal,$akhir){
        $tapel = \App\Models\Tapel::find($tapelid);
        $pembayaran = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->select('psbregistrasi_id','tgl')->distinct()->get();
        $pembayarans = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->get();
        
        $pdf = new \fpdf\Pdfepsb();
        //set periode
        $pdf->setAwal($awal);
        $pdf->setAkhir($akhir);
        $pdf->setTapel($tapel->nama);

        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        //get data transaksi
        //$transaksi = \App\Models\Transaksi::with('siswa')->where('tgl', '>=', date('Y-m-d', strtotime($awal)))->where('tgl', '<=', date('Y-m-d', strtotime($akhir)))->get();
        

        //generate table 
        //table header
        $colNo = 10;
        $colTgl = 25;
        $colNama = 50;
        $colBayar = 70;
        $colTotal = 35;
        
        $stdFontSize = 10;
        
        ///generate data transaksi
        $rownum = 1;
        $pdf->SetFont('Courier', null, 10);
        $grandTot=0;

        foreach($pembayaran as $dt){
            //initial
            $stdFontSize = 10;
            $pdf->SetFont('Courier', null, $stdFontSize);
            
            //generate row content
            $pdf->Cell($colNo, 5, $rownum++, 'LR', 0, 'R');
            $pdf->Cell($colTgl, 5, date('d-m-Y',strtotime($dt->tgl)), 'LR', 0, 'L');
            //looping nama untuk menentukan size font untuk menyesuaikan dengan lebar kolom
            $nama = $dt->registrasi->calonsiswa->nama;
            while ($pdf->GetStringWidth($nama) >= ($colNama - 1)) {
                $pdf->SetFont('Courier', null, $stdFontSize--);
            }
            $pdf->SetFont('Courier', null, $stdFontSize);
            //lanjut generate row content
            $pdf->Cell($colNama, 5, $nama, 'LR', 0, 'L');
            
            $rowStep=0;
            $heigtOfLastColumn = 0;
            $totalBayar=0;
            //reinitial
            $stdFontSize = 10;
            $pdf->SetFont('Courier', null, $stdFontSize);
            //$jumlahBiayaYgDBayar = $pembayarans()->where('tgl',$dt->tgl)->where('psbregistrasi_id',$dt->psbregistrasi_id)->count();
            $jumlahBiayaYgDBayar = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->where('tgl',$dt->tgl)->where('psbregistrasi_id',$dt->psbregistrasi_id)->count();
            foreach($pembayarans as $dt2){
                if($dt2->tgl == $dt->tgl && $dt2->psbregistrasi_id == $dt->psbregistrasi_id){
                    if($rowStep == 0){
                        $pdf->Cell($colBayar/2, 5, $dt2->biaya->nama, 'TLR', 0, 'L');
                        $pdf->Cell($colBayar/2, 5, number_format($dt2->dibayar,0,',','.'), 'TLR', 0, 'R');
                        $pdf->Cell($colTotal, 5, '', 'R', 1, 'R');
                    }else{
                        //generate row kosong
                        $pdf->Cell($colNo, 5, '', 'LR', 0, 'L');
                        $pdf->Cell($colTgl, 5, '', 'LR', 0, 'L');
                        $pdf->Cell($colNama, 5, '', 'LR', 0, 'L');
                        //
                        $pdf->Cell($colBayar/2, 5, $dt2->biaya->nama, 'LR', 0, 'L');
                        $pdf->Cell($colBayar/2, 5, number_format($dt2->dibayar,0,',','.'), 'LR', 0, 'R');
                        $pdf->Cell($colTotal, 5, '', 'R', 1, 'R');
                    }
                    $totalBayar+=$dt2->dibayar;
                    $rowStep++;
                    $heigtOfLastColumn+=5;
                    $grandTot+=$dt2->dibayar;
                }
            }
            //generate row kosong untuk row Total Bayar per Tanggal
            $pdf->Cell($colNo, 5,'' , 'BLR', 0, 'L');
            $pdf->Cell($colTgl, 5,'' , 'BLR', 0, 'L');
            $pdf->Cell($colNama, 5,'' , 'BLR', 0, 'L');
            $pdf->Cell($colBayar/2, 5,'' , 'BLR', 0, 'L');
            $pdf->Cell($colBayar/2, 5,'' , 'BLR', 0, 'L');
            $pdf->Cell($colTotal, 5, number_format($totalBayar,0,',','.'), 'BR', 1, 'R');
            
        }
        
        //generate TOTAL
        //show grand total
        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Cell(0, 0.2, '', 1, 1);
        $pdf->Cell($colNo+$colTgl+$colNama+$colBayar, 5, 'TOTAL', 1, 0, 'R');
        $pdf->Cell($colTotal, 5, number_format($grandTot, 0, ',', '.') , 1, 1, 'R');
        
        
//        foreach ($transaksi as $dt) {
//            //initial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//
//            $pdf->Cell($colNo, 5, $rownum++, 1, 0, 'R');
//            $pdf->Cell($colNis, 5, $dt->siswa->nisn, 1, 0, 'L');
//
//            //looping nama untuk menentukan size font untuk menyesuaikan dengan lebar kolom
//            $nama = $dt->siswa->nama;
//            while ($pdf->GetStringWidth($nama) >= ($colNama - 1)) {
//                $pdf->SetFont('Courier', null, $stdFontSize--);
//            }
//            $pdf->Cell($colNama, 5, $nama, 1, 0, 'L');
//
//            //reinitial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            $rombel = $dt->siswa->rombels()->orderBy('created_at', 'desc')->first()->nama;
//            while ($pdf->GetStringWidth($rombel) >= ($colRombel - 1)) {
//                $pdf->SetFont('Courier', null, $stdFontSize--);
//            }
//            $pdf->Cell($colRombel, 5, $rombel, 1, 0, 'L');
//
//            //reinitial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            $tgl = date('d-m-Y', strtotime($dt->tgl));
//            while ($pdf->GetStringWidth($tgl) >= ($colTgl - 1)) {
//                $pdf->SetFont('Courier', null, $stdFontSize--);
//            }
//            $pdf->Cell($colTgl, 5, $tgl, 1, 0, 'L');
//
//            //reinitial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            $pdf->Cell($colDebet, 5, ($dt->jenis == 'D' ? number_format($dt->jumlah, 0, ',', '.') : '-'), 1, 0, 'R');
//            $pdf->Cell($colKredit, 5, ($dt->jenis == 'K' ? number_format($dt->jumlah, 0, ',', '.') : '-'), 1, 1, 'R');
//            
//            //kalkulasi total debet kredit
//            if($dt->jenis == 'D'){
//                $totDebet += $dt->jumlah;
//            }else{
//                $totKredit += $dt->jumlah;
//            }
//        }
//
//        //show total
//        $pdf->SetFont('Courier', 'B', 10);
//        $pdf->Cell(0, 0.2, '', 1, 1);
//        $pdf->Cell($colNo+$colNis+$colNama+$colRombel+$colTgl, 5, 'SUB TOTAL', 1, 0, 'R');
//        $pdf->Cell($colDebet, 5, number_format($totDebet, 0, ',', '.') , 1, 0, 'R');
//        $pdf->Cell($colKredit, 5, number_format($totKredit, 0, ',', '.'), 1, 1, 'R');
//        
//        //show grand total
//        $pdf->Cell(0, 0.2, '', 1, 1);
//        $pdf->Cell($colNo+$colNis+$colNama+$colRombel+$colTgl, 5, 'TOTAL', 1, 0, 'R');
//        $pdf->Cell($colDebet+$colKredit, 5, number_format($totDebet-$totKredit, 0, ',', '.') , 1, 1, 'R');
//        
//        //show total saldo
//        $saldo = \App\Models\Saldo::sum('saldo');
//        $pdf->ln(5);
//        $pdf->Cell($colNo+$colNis+$colNama, 5, 'TOTAL SALDO KEUANGAN TABUNGAN', 1, 1, 'L');
//        $pdf->Cell($colNo+$colNis+$colNama, 5, 'Rp. ' . number_format($saldo, 0, ',', '.') , 1, 0, 'R');

        $pdf->Output('RekapPSB' .  date('dmY_His') .'.pdf', 'D');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return \View::make('master.rekap.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $rekap = new Rekap();
        $rekap->nama = \Input::get('nama');
        $rekap->save();

        return \Redirect::route('master.rekap.index');
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
        return \View::make('master.rekap.edit')->with('rekap', rekap::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $rekap = Rekap::find($id);
        $rekap->nama = \Input::get('nama');
        $rekap->save();

        return \Redirect::route('master.rekap.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Rekap::whereId($id)->delete();
        return \Redirect::route('master.rekap.index');
    }

}

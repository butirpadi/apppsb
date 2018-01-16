<?php

namespace App\Controllers;

class ReportController extends \BaseController {

    public function getIndex() {
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach ($tapels as $dt) {
            $selectTapel[$dt->id] = $dt->nama;
        }
        return \View::make('rpt.index', array('selectTapel' => $selectTapel));
    }

    public function postShow() {
        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
        foreach ($tapels as $dt) {
            $selectTapel[$dt->id] = $dt->nama;
        }



//        $data = \DB::select("CALL `SP_REKAP`('" . date('Y-m-d', strtotime(\Input::get('awal'))) . "', '" . date('Y-m-d', strtotime(\Input::get('akhir'))) . "')");
//
////        print_r($data);
//        return \View::make('rpt.show', array(
//                    'selectTapel' => $selectTapel,
//                    'data' => $data,
//                    'tapel' => \Input::get('tapel'),
//                    'jenis' => \Input::get('jenis'),
//                    'awal' => \Input::get('awal'),
//                    'akhir' => \Input::get('akhir'),
//        ));
//        $this->showAll(
//                \Input::get('awal'), \Input::get('akhir'), \Input::get('tapel'), \Input::get('jenis'), $selectTapel
//        );

        $awal = date('Y-m-d', strtotime(\Input::get('awal')));
        $akhir = date('Y-m-d', strtotime(\Input::get('akhir')));
        $jenis = \Input::get('jenis');
        $tapel = \Input::get('tapel');

        if ($jenis == 'A') {
            $data = \DB::table("view_rekap")->whereBetween('tgl', array($awal, $akhir))->get();
        } else {
            $data = \DB::table("view_rekap")->whereBetween('tgl', array($awal, $akhir))->whereTipe($jenis)->get();
        }

//        print_r($data);
        return \View::make('rpt.show', array(
                    'selectTapel' => $selectTapel,
                    'data' => $data,
                    'tapel' => $tapel,
                    'jenis' => $jenis,
                    'awal' => $awal,
                    'akhir' => $akhir,
        ));
    }

    public function showAll($awal, $akhir, $tapel, $jenis, $selectTapel) {

        $data = \DB::select("CALL `SP_REKAP`('" . date('Y-m-d', strtotime($awal)) . "', '" . date('Y-m-d', strtotime($akhir)) . "')");

//        print_r($data);
        return \View::make('rpt.show', array(
                    'selectTapel' => $selectTapel,
                    'data' => $data,
                    'tapel' => $tapel,
                    'jenis' => $jenis,
                    'awal' => $awal,
                    'akhir' => $akhir,
        ));
    }

    private function showPengeluaran() {
        
    }

    private function showPembayaran() {
        $pembayaran = \App\Models\Pembayaran::whereBetween('tgl', array(date('Y-m-d', strtotime($awal)), date('Y-m-d', strtotime($akhir))))->select('psbregistrasi_id', 'tgl')->distinct()->get();
        $pembayarans = \App\Models\Pembayaran::whereBetween('tgl', array(date('Y-m-d', strtotime($awal)), date('Y-m-d', strtotime($akhir))))->get();
    }

//    public function postToPdf() {
//        $tapel = \Input::get('tapel');
//        $tapel = \App\Models\Tapel::find($tapel);
//        $jenis = \Input::get('jenis');
//        $awal = date('Y-m-d',strtotime(\Input::get('awal')));
//        $akhir = date('Y-m-d',strtotime(\Input::get('akhir')));
//
////        $data = \DB::select("CALL `SP_REKAP`('" . date('Y-m-d', strtotime($awal)) . "', '" . date('Y-m-d', strtotime($akhir)) . "')");
//        $masterData = \DB::select("select tp.tgl,tp.regnum, tp.created_at,tp.psbregistrasi_id,tp.calon,tp.psbbiaya_id,tp.biaya,
//                        tp.harusbayar,tp.dibayar,tp.potongan,tp.tipe
//                        from VIEW_TRANSAKSI_PSB as tp
//                        where tgl between '" . $awal . "' and '" . $akhir . "'
//                        group by tp.tgl,tp.regnum");
//        $childs = \DB::select("select tp.tgl,tp.regnum, tp.created_at,tp.psbregistrasi_id,tp.calon,tp.psbbiaya_id,tp.biaya,
//                        tp.harusbayar,tp.dibayar,tp.potongan,tp.tipe
//                        from VIEW_TRANSAKSI_PSB as tp
//                        where tgl between '" . $awal . "' and '" . $akhir ."'");
//
////        $masterData = \DB::table('VIEW_TRANSAKSI_PSB')
////                ->whereBetween('tgl', array(date('Y-m-d', strtotime(\Input::get('awal'))),date('Y-m-d', strtotime(\Input::get('akhir')))));
//
//        
//
//
//        $pdf = new \Pdfepsb();
////        $pdf = new \fpdf\Pdfepsb();
//        //set periode
//        $pdf->setAwal($awal);
//        $pdf->setAkhir($akhir);
//        $pdf->setTapel($tapel->nama);
//
//        $pdf->SetAutoPageBreak(true, 10);
//        $pdf->AddPage();
//
//        //get data transaksi
//        //$transaksi = \App\Models\Transaksi::with('siswa')->where('tgl', '>=', date('Y-m-d', strtotime($awal)))->where('tgl', '<=', date('Y-m-d', strtotime($akhir)))->get();
//        //generate table 
//        //table header
//        $colNo = 10;
//        $colTgl = 25;
//        $colNama = 50;
//        $colBayar = 70;
//        $colTotal = 35;
//
//        $stdFontSize = 10;
//
//        ///generate data transaksi
//        $rownum = 1;
//        $pdf->SetFont('Courier', null, 10);
//        $grandTot = 0;
//
//        foreach ($masterData as $mdt) {
//            //initial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//
//            //generate row content
//            $pdf->Cell($colNo, 5, $rownum++, 'LR', 0, 'R');
//            $pdf->Cell($colTgl, 5, date('d/m/Y', strtotime($mdt->tgl)), 'LR', 0, 'L');
//            //looping nama untuk menentukan size font untuk menyesuaikan dengan lebar kolom
//            $nama = $mdt->calon;
//            while ($pdf->GetStringWidth($nama) >= ($colNama - 1)) {
//                $pdf->SetFont('Courier', null, $stdFontSize--);
//            }
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            //lanjut generate row content
//            $pdf->Cell($colNama, 5, $nama, 'LR', 0, 'L');
//
//            $rowStep = 0;
//            $heigtOfLastColumn = 0;
//            $totalBayar = 0;
//            //reinitial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            //$jumlahBiayaYgDBayar = $pembayarans()->where('tgl',$mdt->tgl)->where('psbregistrasi_id',$mdt->psbregistrasi_id)->count();
//            $jumlahBiayaYgDBayar = \App\Models\Pembayaran::whereBetween('tgl', array(date('Y-m-d', strtotime($awal)), date('Y-m-d', strtotime($akhir))))->where('tgl', $mdt->tgl)->where('psbregistrasi_id', $mdt->psbregistrasi_id)->count();
////            foreach ($childs as $mdt2) {
////                if ($mdt2->tgl == $mdt->tgl && $mdt2->psbregistrasi_id == $mdt->psbregistrasi_id) {
////                    if ($rowStep == 0) {
////                        $pdf->Cell($colBayar / 2, 5, $mdt2->biaya->nama, 'TLR', 0, 'L');
////                        $pdf->Cell($colBayar / 2, 5, number_format($mdt2->dibayar, 0, ',', '.'), 'TLR', 0, 'R');
////                        $pdf->Cell($colTotal, 5, '', 'R', 1, 'R');
////                    } else {
////                        //generate row kosong
////                        $pdf->Cell($colNo, 5, '', 'LR', 0, 'L');
////                        $pdf->Cell($colTgl, 5, '', 'LR', 0, 'L');
////                        $pdf->Cell($colNama, 5, '', 'LR', 0, 'L');
////                        //
////                        $pdf->Cell($colBayar / 2, 5, $mdt2->biaya->nama, 'LR', 0, 'L');
////                        $pdf->Cell($colBayar / 2, 5, number_format($mdt2->dibayar, 0, ',', '.'), 'LR', 0, 'R');
////                        $pdf->Cell($colTotal, 5, '', 'R', 1, 'R');
////                    }
////                    $totalBayar+=$mdt2->dibayar;
////                    $rowStep++;
////                    $heigtOfLastColumn+=5;
////                    $grandTot+=$mdt2->dibayar;
////                }
////            }
//            //generate row kosong untuk row Total Bayar per Tanggal
//            $pdf->Cell($colNo, 5, '', 'BLR', 0, 'L');
//            $pdf->Cell($colTgl, 5, '', 'BLR', 0, 'L');
//            $pdf->Cell($colNama, 5, '', 'BLR', 0, 'L');
//            $pdf->Cell($colBayar / 2, 5, '', 'BLR', 0, 'L');
//            $pdf->Cell($colBayar / 2, 5, '', 'BLR', 0, 'L');
//            $pdf->Cell($colTotal, 5, number_format($totalBayar, 0, ',', '.'), 'BR', 1, 'R');
//        }
//
//        //generate TOTAL
//        //show grand total
//        $pdf->SetFont('Courier', 'B', 10);
//        $pdf->Cell(0, 0.2, '', 1, 1);
//        $pdf->Cell($colNo + $colTgl + $colNama + $colBayar, 5, 'TOTAL', 1, 0, 'R');
//        $pdf->Cell($colTotal, 5, number_format($grandTot, 0, ',', '.'), 1, 1, 'R');
//
//        $pdf->Output('RekapPSB' . date('dmY_His') . '.pdf', 'D');
//    }
    public function postToPdf() {
        $tapel = \Input::get('tapel');
        $tapel = \App\Models\Tapel::find($tapel);
        $jenis = \Input::get('jenis');
        $awal = date('Y-m-d', strtotime(\Input::get('awal')));
        $akhir = date('Y-m-d', strtotime(\Input::get('akhir')));

//        $data = \DB::select("CALL `SP_REKAP`('" . date('Y-m-d', strtotime($awal)) . "', '" . date('Y-m-d', strtotime($akhir)) . "')");
//        $masterData = \DB::select("select tp.tgl,tp.regnum, tp.created_at,tp.psbregistrasi_id,tp.calon,tp.psbbiaya_id,tp.biaya,
//                        tp.harusbayar,tp.dibayar,tp.potongan,tp.tipe
//                        from VIEW_TRANSAKSI_PSB as tp
//                        where tgl between '" . $awal . "' and '" . $akhir . "'
//                        group by tp.tgl,tp.regnum");
//        $childs = \DB::select("select tp.tgl,tp.regnum, tp.created_at,tp.psbregistrasi_id,tp.calon,tp.psbbiaya_id,tp.biaya,
//                        tp.harusbayar,tp.dibayar,tp.potongan,tp.tipe
//                        from VIEW_TRANSAKSI_PSB as tp
//                        where tgl between '" . $awal . "' and '" . $akhir . "'");

        if ($jenis == 'A') {
            $masterData = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->get();
            $childs = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->get();
        } else {
            $masterData = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->whereTipe($jenis)->get();
            $childs = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->whereTipe($jenis)->get();
        }

        $totBayar = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->where('tipe', 'D')->sum('dibayar');
        $totKeluar = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->where('tipe', 'K')->sum('dibayar');


        $pdf = new \Fpdfrekap();
        $tableCol = array(
            0 => array(
                'width' => 10,
                'title' => 'NO',
                'border' => 1,
                'ln' => 0,
                'align' => 'C',
            ),
            1 => array(
                'width' => 15,
                'title' => 'TGL',
                'border' => 1,
                'ln' => 0,
                'align' => 'C',
            ),
            2 => array(
                'width' => 55,
                'title' => 'KETERANGAN',
                'border' => 1,
                'ln' => 0,
                'align' => 'C',
            ),
            3 => array(
                'width' => 50,
                'title' => 'BIAYA',
                'border' => 1,
                'ln' => 0,
                'align' => 'C',
            ),
            4 => array(
                'width' => 30,
                'title' => 'PEMBAYARAN',
                'border' => 1,
                'ln' => 0,
                'align' => 'C',
            ),
            5 => array(
                'width' => 30,
                'title' => 'PENGELUARAN',
                'border' => 1,
                'ln' => 1,
                'align' => 'C',
            ),
        );

        //HEADER SECTION
        if ($jenis == 'A') {
            $pdf->setPageTitle('REKAPITULASI PSB ' . $tapel->nama);
        } elseif ($jenis == 'D') {
            $pdf->setPageTitle('REKAPITULASI PENDAPATAN PEMBAYARAN PSB ' . $tapel->nama);
        } elseif ($jenis == 'K') {
            $pdf->setPageTitle('REKAPITULASI PENGELUARAN PSB ' . $tapel->nama);
        }

        $pdf->setSubtitle('PERIODE ' . date('d/m/Y', strtotime($awal)) . ' - ' . date('d/m/Y', strtotime($akhir)));
        $pdf->setTableHeader($tableCol);
        $pdf->setTableHeaderColumnHeight(8);
        $pdf->setTableHeaderFontSize(10);
        //END OF HEADER
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        // NEW CONTENT REVISI
        // END OF NEW CONTENT REVISI

        $master_row;
        // $chld=null;
        if ($jenis == 'A') {
            $master_row = \DB::select('select distinct(calon) from view_rekap where tgl between "' . $awal . '" and "' . $akhir . '"');
            // $mstr = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->get();
            $chld = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->get();
        } else {
            // $mstr = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->whereTipe($jenis)->get();
            $master_row = \DB::select('select distinct(calon) from view_rekap where tgl between "' . $awal . '" and "' . $akhir . '" and tipe="' . $jenis . '"');
            $chld = \DB::table('view_rekap')->whereBetween('tgl', array($awal, $akhir))->whereTipe($jenis)->get();
        }

        $rownum=1;
        $pdf->SetFontSize(9);
        foreach($master_row as $mr){
            $data_rekap = \DB::select('select * from view_rekap where tgl between "' . $awal . '" and "' . $akhir . '" and calon="'.$mr->calon.'"');
            $dr_rownum=0;
            $dr_lasrow = count($data_rekap)-1;
            $jumlah = 0
;            $jml = 0;
            foreach($data_rekap as $dr){
                if($dr_rownum == 0){
                    $pdf->Cell(10, 5, $rownum++, 'TLR', 0, 'R');
                    $pdf->Cell(15, 5, date('d/m', strtotime($dr->tgl)), 'TLR', 0, 'L');
                    $pdf->Cell(55, 5, $dr->calon, 'TLR', 0, 'L');
                    $pdf->Cell(25, 5, $dr->biaya, 'TLR', 0, 'R');
                    $pdf->Cell(25, 5, ($dr->psbregistrasi_id != null ? number_format($dr->dibayar, 0, '.', ','):'') , 'TLR', 0, 'R');
                    $jml += $dr->dibayar;
                    $jumlah = number_format($jml, 0, '.', ',');
                    $pdf->Cell(30, 5, ($dr->tipe == 'D' ? $jumlah : ''), 'TLR', 0, 'R');
                    $pdf->Cell(30, 5, ($dr->tipe == 'K' ? $jumlah : ''), 'TLR', 1, 'R');
                }elseif($dr_rownum == $dr_lasrow ){
                        $pdf->Cell(10, 5, '', 'L', 0, 'R');
                        $pdf->Cell(15, 5, '', 'L', 0, 'L');
                        $pdf->Cell(55, 5, '', 'L', 0, 'L');
                        $pdf->Cell(25, 5, $dr->biaya, 'L', 0, 'R');
                        $pdf->Cell(25, 5, number_format($dr->dibayar, 0, '.', ','), 'L', 0, 'R');
                        $jml += $dr->dibayar;
                        $jumlah = number_format($jml, 0, '.', ',');
                        $pdf->Cell(30, 5, ($dr->tipe == 'D' ? $jumlah : ''), 'L', 0, 'R');
                        $pdf->Cell(30, 5, ($dr->tipe == 'K' ? $jumlah : ''), 'LR', 1, 'R');

                    }else{
                        // if($dr_rownum > 0){
                            $pdf->Cell(10, 5, '', 'LR', 0, 'R');
                            $pdf->Cell(15, 5, '', 'LR', 0, 'L');
                            $pdf->Cell(55, 5, '', 'LR', 0, 'L');
                            $pdf->Cell(25, 5, $dr->biaya, 'LR', 0, 'R');
                            $pdf->Cell(25, 5, number_format($dr->dibayar, 0, '.', ','), 'LR', 0, 'R');
                            $jml += $dr->dibayar;
                            $jumlah = number_format($jml, 0, '.', ',');
                            $pdf->Cell(30, 5, '', 'LR', 0, 'R');
                            $pdf->Cell(30, 5, ($dr->tipe == 'K' ? $jumlah : ''), 'LR', 1, 'R');      
                        // }
                    }
                    
                // }


                $dr_rownum++;
            }

        }

        //CONTENT SECTION
        // $rownum = 1;
        // $totalPembayaran = 0;
        // $totalPengeluaran = 0;
        // foreach ($masterData as $md) {

        //     if ($md->tipe == 'D') {
        //         $pdf->Cell(10, 5, $rownum++, 'TLR', 0, 'R');
        //         $pdf->Cell(15, 5, date('d/m', strtotime($md->tgl)), 'TLR', 0, 'L');
        //         $pdf->Cell(55, 5, $md->calon, 'TLR', 0, 'L');
        //         $pdf->Cell(25, 5, '', 'TLR', 0, 'R');
        //         $pdf->Cell(25, 5, '', 'TLR', 0, 'R');
        //         $jumlah = number_format($md->dibayar, 0, '.', ',');
        //         $pdf->Cell(30, 5, '', 'TLR', 0, 'R');
        //         $pdf->Cell(30, 5, ($md->tipe == 'K' ? $jumlah : ''), 'TLR', 1, 'R');

        //         //loop childs
        //         $totalperrow = 0;
        //         $ketmu = false;
        //         foreach ($childs as $ch) {
        //             if ($ch->tipe == 'D' && $ch->regnum == $md->regnum && $ch->tgl == $md->tgl) {
        //                 $pdf->Cell(10, 5, '', 'LR', 0, 'R');
        //                 $pdf->Cell(15, 5, '', 'LR', 0, 'R');
        //                 $pdf->Cell(55, 5, '', 'LR', 0, 'R');
        //                 $pdf->Cell(25, 5, $ch->biaya . ' semangat', 'LR', 0, 'L');
        //                 $pdf->Cell(25, 5, number_format($ch->dibayar, 0, '.', ','), 'LR', 0, 'R');
        //                 $pdf->Cell(30, 5, '', 'LR', 0, 'R');
        //                 $pdf->Cell(30, 5, ($md->tipe == 'K' ? number_format($jumlah, 0, '.', ',') : ''), 'LR', 1, 'R');
        //                 $totalperrow+=$ch->dibayar;
        //                 $ketmu = true;
        //                 $totalPembayaran+=$ch->dibayar;
        //             }
        //         }
        //         if ($ketmu) {
        //             //cetak total per row
        //             $pdf->Cell(10, 5, '', 'LR', 0, 'R');
        //             $pdf->Cell(15, 5, '', 'LR', 0, 'R');
        //             $pdf->Cell(55, 5, '', 'LR', 0, 'R');
        //             $pdf->Cell(50, 5, 'JUMLAH', 'TLR', 0, 'R');
        //             $pdf->Cell(30, 5, number_format($totalperrow, 0, '.', ','), 'LR', 0, 'R');
        //             $pdf->Cell(30, 5, '', 'LR', 1, 'R');
        //         }
        //     } else {
        //         $pdf->Cell(10, 5, $rownum++, 1, 0, 'R');
        //         $pdf->Cell(15, 5, date('d/m', strtotime($md->tgl)), 1, 0, 'L');
        //         $pdf->Cell(105, 5, substr($md->calon, 0, 50), 1, 0, 'L');
        //         $pdf->Cell(30, 5, '', 1, 0, 'L');
        //         $jumlah = number_format($md->dibayar, 0, '.', ',');
        //         $pdf->Cell(30, 5, ($md->tipe == 'K' ? $jumlah : ''), 1, 1, 'R');
        //         $totalPengeluaran+=$md->dibayar;
        //     }
        // }

        //generate TOTAL ROW
        // $pdf->SetFontSize(14);
        if ($jenis == 'A') {
            $pdf->Cell(130, 5, 'SUB TOTAL', 1, 0, 'C');
            $pdf->Cell(30, 5, number_format($totBayar, 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(30, 5, number_format($totKeluar, 0, '.', ','), 1, 1, 'R');
            $pdf->Cell(130, 5, 'TOTAL', 1, 0, 'C');
            $pdf->Cell(60, 5, number_format($totBayar-$totKeluar, 0, '.', ','), 1, 0, 'R');
            // $pdf->Cell(30, 5, number_format($totKeluar, 0, '.', ','), 1, 1, 'R');
        } elseif ($jenis == 'D') {
            $pdf->Cell(130, 5, 'TOTAL PEMBAYARAN', 1, 0, 'L');
            $pdf->Cell(60, 5, number_format($totBayar, 0, '.', ','), 1, 1, 'R');
        } elseif ($jenis == 'K') {
            $pdf->Cell(130, 5, 'TOTAL PENGELUARAN', 1, 0, 'L');
            $pdf->Cell(60, 5, number_format($totKeluar, 0, '.', ','), 1, 1, 'R');
        }
        //END CONTENT SECTION

        $pdf->Output('RekapPSB' . date('dmY_His') . '.pdf', 'D');
    }

//    public function store(){
//        echo 'store';
//    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
//    public function index() {
//        $tapels = \App\Models\Tapel::orderBy('posisi')->get();
//        foreach ($tapels as $dt) {
//            $selectTapel[$dt->id] = $dt->nama;
//        }
//        return \View::make('rekap.rekap.index',array('selectTapel'=>$selectTapel));
//    }
//
//    /**
//     * 
//     * @param type $id tapelid
//     */
//    public function getregistrasi($id, $awal, $akhir) {
//        $tapel = \App\Models\Tapel::find($id);
//
//        $registrasi = \App\Models\Registrasi::where('tgl', '>=', date('Y-m-d', strtotime($awal)))
//                ->where('tgl', '<=', date('Y-m-d', strtotime($akhir)))
//                ->get();
//        
//        $biayas = $tapel->biayas();
//
//        return \View::make('rekap.rekap.calonsiswa',array('registrasi'=>$registrasi,'biayas'=>$biayas));
//    }
//    
//    public function getpembayaran($awal,$akhir){
//        $pembayaran = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->select('psbregistrasi_id','tgl')->distinct()->get();
//        $pembayarans = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->get();
//        
//        return \View::make('rekap.rekap.pembayaran',array('pembayaran'=>$pembayaran,'pembayarans'=>$pembayarans));
//        
//    }
//    
//    public function topdf($tapelid,$awal,$akhir){
//        $tapel = \App\Models\Tapel::find($tapelid);
//        $pembayaran = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->select('psbregistrasi_id','tgl')->distinct()->get();
//        $pembayarans = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->get();
//        
//        $pdf = new \Pdfepsb();
////        $pdf = new \fpdf\Pdfepsb();
//        //set periode
//        $pdf->setAwal($awal);
//        $pdf->setAkhir($akhir);
//        $pdf->setTapel($tapel->nama);
//
//        $pdf->SetAutoPageBreak(true, 10);
//        $pdf->AddPage();
//
//        //get data transaksi
//        //$transaksi = \App\Models\Transaksi::with('siswa')->where('tgl', '>=', date('Y-m-d', strtotime($awal)))->where('tgl', '<=', date('Y-m-d', strtotime($akhir)))->get();
//        
//
//        //generate table 
//        //table header
//        $colNo = 10;
//        $colTgl = 25;
//        $colNama = 50;
//        $colBayar = 70;
//        $colTotal = 35;
//        
//        $stdFontSize = 10;
//        
//        ///generate data transaksi
//        $rownum = 1;
//        $pdf->SetFont('Courier', null, 10);
//        $grandTot=0;
//
//        foreach($pembayaran as $dt){
//            //initial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            
//            //generate row content
//            $pdf->Cell($colNo, 5, $rownum++, 'LR', 0, 'R');
//            $pdf->Cell($colTgl, 5, date('d-m-Y',strtotime($dt->tgl)), 'LR', 0, 'L');
//            //looping nama untuk menentukan size font untuk menyesuaikan dengan lebar kolom
//            $nama = $dt->registrasi->calonsiswa->nama;
//            while ($pdf->GetStringWidth($nama) >= ($colNama - 1)) {
//                $pdf->SetFont('Courier', null, $stdFontSize--);
//            }
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            //lanjut generate row content
//            $pdf->Cell($colNama, 5, $nama, 'LR', 0, 'L');
//            
//            $rowStep=0;
//            $heigtOfLastColumn = 0;
//            $totalBayar=0;
//            //reinitial
//            $stdFontSize = 10;
//            $pdf->SetFont('Courier', null, $stdFontSize);
//            //$jumlahBiayaYgDBayar = $pembayarans()->where('tgl',$dt->tgl)->where('psbregistrasi_id',$dt->psbregistrasi_id)->count();
//            $jumlahBiayaYgDBayar = \App\Models\Pembayaran::whereBetween('tgl',array(date('Y-m-d',strtotime($awal)), date('Y-m-d',strtotime($akhir))))->where('tgl',$dt->tgl)->where('psbregistrasi_id',$dt->psbregistrasi_id)->count();
//            foreach($pembayarans as $dt2){
//                if($dt2->tgl == $dt->tgl && $dt2->psbregistrasi_id == $dt->psbregistrasi_id){
//                    if($rowStep == 0){
//                        $pdf->Cell($colBayar/2, 5, $dt2->biaya->nama, 'TLR', 0, 'L');
//                        $pdf->Cell($colBayar/2, 5, number_format($dt2->dibayar,0,',','.'), 'TLR', 0, 'R');
//                        $pdf->Cell($colTotal, 5, '', 'R', 1, 'R');
//                    }else{
//                        //generate row kosong
//                        $pdf->Cell($colNo, 5, '', 'LR', 0, 'L');
//                        $pdf->Cell($colTgl, 5, '', 'LR', 0, 'L');
//                        $pdf->Cell($colNama, 5, '', 'LR', 0, 'L');
//                        //
//                        $pdf->Cell($colBayar/2, 5, $dt2->biaya->nama, 'LR', 0, 'L');
//                        $pdf->Cell($colBayar/2, 5, number_format($dt2->dibayar,0,',','.'), 'LR', 0, 'R');
//                        $pdf->Cell($colTotal, 5, '', 'R', 1, 'R');
//                    }
//                    $totalBayar+=$dt2->dibayar;
//                    $rowStep++;
//                    $heigtOfLastColumn+=5;
//                    $grandTot+=$dt2->dibayar;
//                }
//            }
//            //generate row kosong untuk row Total Bayar per Tanggal
//            $pdf->Cell($colNo, 5,'' , 'BLR', 0, 'L');
//            $pdf->Cell($colTgl, 5,'' , 'BLR', 0, 'L');
//            $pdf->Cell($colNama, 5,'' , 'BLR', 0, 'L');
//            $pdf->Cell($colBayar/2, 5,'' , 'BLR', 0, 'L');
//            $pdf->Cell($colBayar/2, 5,'' , 'BLR', 0, 'L');
//            $pdf->Cell($colTotal, 5, number_format($totalBayar,0,',','.'), 'BR', 1, 'R');
//            
//        }
//        
//        //generate TOTAL
//        //show grand total
//        $pdf->SetFont('Courier', 'B', 10);
//        $pdf->Cell(0, 0.2, '', 1, 1);
//        $pdf->Cell($colNo+$colTgl+$colNama+$colBayar, 5, 'TOTAL', 1, 0, 'R');
//        $pdf->Cell($colTotal, 5, number_format($grandTot, 0, ',', '.') , 1, 1, 'R');
//        
//        
////        foreach ($transaksi as $dt) {
////            //initial
////            $stdFontSize = 10;
////            $pdf->SetFont('Courier', null, $stdFontSize);
////
////            $pdf->Cell($colNo, 5, $rownum++, 1, 0, 'R');
////            $pdf->Cell($colNis, 5, $dt->siswa->nisn, 1, 0, 'L');
////
////            //looping nama untuk menentukan size font untuk menyesuaikan dengan lebar kolom
////            $nama = $dt->siswa->nama;
////            while ($pdf->GetStringWidth($nama) >= ($colNama - 1)) {
////                $pdf->SetFont('Courier', null, $stdFontSize--);
////            }
////            $pdf->Cell($colNama, 5, $nama, 1, 0, 'L');
////
////            //reinitial
////            $stdFontSize = 10;
////            $pdf->SetFont('Courier', null, $stdFontSize);
////            $rombel = $dt->siswa->rombels()->orderBy('created_at', 'desc')->first()->nama;
////            while ($pdf->GetStringWidth($rombel) >= ($colRombel - 1)) {
////                $pdf->SetFont('Courier', null, $stdFontSize--);
////            }
////            $pdf->Cell($colRombel, 5, $rombel, 1, 0, 'L');
////
////            //reinitial
////            $stdFontSize = 10;
////            $pdf->SetFont('Courier', null, $stdFontSize);
////            $tgl = date('d-m-Y', strtotime($dt->tgl));
////            while ($pdf->GetStringWidth($tgl) >= ($colTgl - 1)) {
////                $pdf->SetFont('Courier', null, $stdFontSize--);
////            }
////            $pdf->Cell($colTgl, 5, $tgl, 1, 0, 'L');
////
////            //reinitial
////            $stdFontSize = 10;
////            $pdf->SetFont('Courier', null, $stdFontSize);
////            $pdf->Cell($colDebet, 5, ($dt->jenis == 'D' ? number_format($dt->jumlah, 0, ',', '.') : '-'), 1, 0, 'R');
////            $pdf->Cell($colKredit, 5, ($dt->jenis == 'K' ? number_format($dt->jumlah, 0, ',', '.') : '-'), 1, 1, 'R');
////            
////            //kalkulasi total debet kredit
////            if($dt->jenis == 'D'){
////                $totDebet += $dt->jumlah;
////            }else{
////                $totKredit += $dt->jumlah;
////            }
////        }
////
////        //show total
////        $pdf->SetFont('Courier', 'B', 10);
////        $pdf->Cell(0, 0.2, '', 1, 1);
////        $pdf->Cell($colNo+$colNis+$colNama+$colRombel+$colTgl, 5, 'SUB TOTAL', 1, 0, 'R');
////        $pdf->Cell($colDebet, 5, number_format($totDebet, 0, ',', '.') , 1, 0, 'R');
////        $pdf->Cell($colKredit, 5, number_format($totKredit, 0, ',', '.'), 1, 1, 'R');
////        
////        //show grand total
////        $pdf->Cell(0, 0.2, '', 1, 1);
////        $pdf->Cell($colNo+$colNis+$colNama+$colRombel+$colTgl, 5, 'TOTAL', 1, 0, 'R');
////        $pdf->Cell($colDebet+$colKredit, 5, number_format($totDebet-$totKredit, 0, ',', '.') , 1, 1, 'R');
////        
////        //show total saldo
////        $saldo = \App\Models\Saldo::sum('saldo');
////        $pdf->ln(5);
////        $pdf->Cell($colNo+$colNis+$colNama, 5, 'TOTAL SALDO KEUANGAN TABUNGAN', 1, 1, 'L');
////        $pdf->Cell($colNo+$colNis+$colNama, 5, 'Rp. ' . number_format($saldo, 0, ',', '.') , 1, 0, 'R');
//
//        $pdf->Output('RekapPSB' .  date('dmY_His') .'.pdf', 'D');
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return Response
//     */
//    public function create() {
//        return \View::make('master.rekap.create');
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @return Response
//     */
//    public function store() {
//        $rekap = new Rekap();
//        $rekap->nama = \Input::get('nama');
//        $rekap->save();
//
//        return \Redirect::route('master.rekap.index');
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function show($id) {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function edit($id) {
//        return \View::make('master.rekap.edit')->with('rekap', rekap::find($id));
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function update($id) {
//        $rekap = Rekap::find($id);
//        $rekap->nama = \Input::get('nama');
//        $rekap->save();
//
//        return \Redirect::route('master.rekap.index');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function destroy($id) {
//        Rekap::whereId($id)->delete();
//        return \Redirect::route('master.rekap.index');
//    }
}

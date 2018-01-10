<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//namespace fpdf;

/**
 * Description of Pdfku
 *
 * @author eries
 */
class Fpdfrekap extends \fpdf\FPDF {

    public $awal, $akhir, $tapel;
    public $pageTitle, $subtitle;
    public $tableHeader;
    public $tableHeaderFontSize;
    public $tableHeaderColumnHeight;

    public function setPageTitle($val) {
        $this->pageTitle = $val;
    }
    public function setSubtitle($val) {
        $this->subtitle = $val;
    }
    /**
     * array {width,height,title,border,ln,align}
     * @param type $val
     */
    public function setTableHeader($val) {
        $this->tableHeader = $val;
    }
    public function setTableHeaderFontSize($val) {
        $this->tableHeaderFontSize = $val;
    }
    public function setTableHeaderColumnHeight($val) {
        $this->tableHeaderColumnHeight = $val;
    }

    

    //put your code here
    function Header() {
        // Logo
        //$this->Image('logo.png', 10, 6, 30);
        // Courier bold 15
        // Move to the right
        // Title
        $this->SetFont('Courier', 'B', 12);
        $this->Cell($this->w - $this->rMargin - $this->lMargin, 5, $this->pageTitle , 0, 1, 'C');
        //show periode
        if ($this->subtitle !="") {
            $this->SetFont('Courier', 'B', 10);
            $this->Cell($this->w - $this->rMargin - $this->lMargin, 5, $this->subtitle, 0, 1, 'C');
        }

        $this->SetFont('Courier', 'B', 10);
        $this->Cell($this->w - $this->rMargin - $this->lMargin, 5, 'SDI SABILIL HUDA', 0, 1, 'C');
        $this->SetFont('Courier', 'B', 8);
        $this->Cell($this->w - $this->rMargin - $this->lMargin, 5, 'Jl. Singokarso 54 Sumorame Candi Sidoarjo', 0, 1, 'C');
        $this->Line(10, 30, $this->w - 10, 30);
        $this->Line(10, 30.1, $this->w - 10, 30.1);
        $this->Line(10, 30.2, $this->w - 10, 30.2);
        $this->Line(10, 30.3, $this->w - 10, 30.3);
        $this->Line(10, 30.7, $this->w - 10, 30.7);
        $this->ln();

        //show tanggal cetak
//        if ($this->PageNo() == 1) {
//            $this->SetFont('Courier', 'B', 8);
//            $this->Cell($this->w - $this->rMargin - $this->lMargin, 5, 'Dicetak pada : ' . date('d-m-Y [H:i:s]'), 0, 1, 'R');
//        }

        $this->SetFont('Courier', 'B',  $this->tableHeaderFontSize);        
        for($i=0;$i<count($this->tableHeader);$i++){
            $this->Cell(
                    $this->tableHeader[$i]['width'], 
                    $this->tableHeaderColumnHeight,
                    $this->tableHeader[$i]['title'], 
                    $this->tableHeader[$i]['border'], 
                    $this->tableHeader[$i]['ln'], 
                    $this->tableHeader[$i]['align']);
        }
    }

    // Page footer
    function Footer() {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Courier', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Page ' . $this->PageNo(), 1, 0, 'R');
        $this->Cell(($this->w - $this->rMargin - $this->lMargin) / 2, 10, 'Print at : ' . date('d-m-Y [H:i:s]'), 0, 0, 'L');
        $this->Cell(($this->w - $this->rMargin - $this->lMargin) / 2, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }

}

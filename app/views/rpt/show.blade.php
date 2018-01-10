@extends('_layouts.default')



@section('main')
<style>
    .th-attention{
        background: #D9EDF7;
    }
</style>

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>REPORT</h3>
            <div class="pull-right" style="padding-right: 10px;" id="pdf-convert-tag">
                <form  method="POST" action="rpt/to-pdf">
                    <input type="hidden" name="awal" value="{{$awal}}"/>
                    <input type="hidden" name="akhir" value="{{$akhir}}"/>
                    <input type="hidden" name="tapel" value="{{$tapel}}"/>
                    <input type="hidden" name="jenis" value="{{$jenis}}"/>
                    <button type="submit" class="btn btn-info btn-pdf" >PDF</button>    
                </form>                
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div class="alert alert-info">
                <form method="POST" action="rpt/show" >
                <table class="table table-form">
                    <tbody>
                        <tr>
                            <td>Tahun Pelajaran</td>
                            <td>
                                <?php echo Form::select('tapel', $selectTapel, $tapel, array('class' => 'span3','required')); ?>
                            </td>
                            <td>Jenis</td>
                            <td>
                                <?php $jenisarr=array('A'=>'TAMPILKAN SEMUA','D'=>'PEMBAYARAN','K'=>'PENGELUARAN'); ?>
                                <?php echo Form::select('jenis', $jenisarr, $jenis, array('class' => 'span3','required')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tentukan rentang waktu</td>
                            <td><?php echo Form::text('awal', $awal, array('class' => 'datepicker span2', 'placeholder' => 'Tanggal Awal','required')); ?></td>
                            <td></td>
                            <td><?php echo Form::text('akhir', $akhir, array('class' => 'datepicker span2', 'placeholder' => 'Tanggal Akhir','required')); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="5">
                                <!--<a class="btn btn-success" id="btn-tampil" >Tampilkan</a>-->
                                <button type="submit" class="btn btn-primary" >Tampilkan</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>

            <div id="table-data"></div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->
    
    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>DATA TABLE REPORT</h3>
            <div class="pull-right" style="padding-right: 10px;" id="pdf-convert-tag">
                
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th colspan="2">Biaya</th>
                        <th>Pembayaran</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rownum=1; ?>
                    <?php $pembayaran= 0; ?>
                    <?php $pengeluaran = 0; ?>
                    <?php $tgl=null; ?>
                    <?php $regnum=null; ?>
                    <?php $samerow=false; ?>
                    <?php $totalperrow=0; ?>
                    <?php $lasttipe=null;?>
                    
                    @foreach($data as $dt)    
                        @if($dt->tipe == 'D')
                            @if($tgl == $dt->tgl && $regnum == $dt->regnum)
                                <?php $samerow=true; ?>
                            @else
                                <?php $samerow=false; ?>
                                <?php $tgl=$dt->tgl; ?>
                                <?php $regnum=$dt->regnum; ?>
                            @endif
                        @else
                            <?php $samerow=false; ?>
                        @endif

                        <?php $border = (!$samerow?'style="border-top:1px solid darkgrey;"':'');?>
                        
                        <!--//tampilkan jumlah pembayaran di akhir yang samerow-->
                        @if((!$samerow && $totalperrow > 0 && $dt->tipe == 'D' && $lasttipe != 'K') || ($dt->tipe == 'K' && $lasttipe == 'D') )
                            <tr style="background: whitesmoke;" >
                                <td colspan="5" class="uang">JUMLAH</td>
                                <td class="uang th-attention" >{{number_format($totalperrow,0,'.',',')}}</td>
                                <td class="uang th-attention" ></td>
                            </tr>
                        
                        @endif

                        @if($jenis == $dt->tipe || $jenis == 'A')                   
                        <!--generate total row-->
                        <tr >
                            <td {{$border}} >
                                @if(!$samerow)
                                {{$rownum++}}
                                @endif
                            </td>
                            <td {{$border}} >
                                @if(!$samerow)
                                {{date('d-m-Y',strtotime($dt->tgl))}}
                                @endif
                            </td>
                            <td  {{$border}} >

                                @if($dt->tipe=='D')
                                @if(!$samerow)
                                {{$dt->calon . ' (' . $dt->regnum . ')'}}
                                @endif
                                @else
                                {{$dt->calon}}
                                @endif                            
                            </td>
                            <td  {{$border}} >
                                {{$dt->biaya}}
                            </td {{$border}} >
                            <td class="uang" {{$border}} >
                                <!--PEMBAYARAN-->
                                @if($dt->tipe=='D')
                                    {{number_format($dt->dibayar,0,'.',',')}}
                                    <?php $pembayaran+=$dt->dibayar; ?>
                                    @if($samerow)
                                    <?php $totalperrow+=$dt->dibayar; ?>
                                    @else
                                    <?php $totalperrow=$dt->dibayar; ?>
                                    @endif
                                @endif
                            </td>
                            <td class="uang th-attention" {{$border}} ></td>
                            <td class="uang th-attention" {{$border}} >
                                <!--PENGELUARAN-->
                                @if($dt->tipe=='K')
                                {{number_format($dt->dibayar,0,'.',',')}}
                                <?php $pengeluaran+=$dt->dibayar; ?>
                                @endif
                            </td>
                            
                        </tr>

                            @if($samerow)
                            @endif
                        @endif
                        <?php $lasttipe=$dt->tipe;?>
                    
                    @endforeach
                    
                    <!--jika data terakhir adalaha data pembayaran, maka tampilkan row jumlah pembayaran-->
                    @if($lasttipe == 'D')
                    <tr style="background: whitesmoke;" >
                        <td colspan="5" class="uang">JUMLAH</td>
                        <td class="uang th-attention" >{{number_format($totalperrow,0,'.',',')}}</td>
                        <td class="uang th-attention" ></td>
                    </tr>
                    @endif
                    
                    <tr>
                        <td colspan="8"></td>
                    </tr>
                    <tr style="background: whitesmoke;font-weight: bolder;font-size: normal;color: black;">
                        <td colspan="5" style="text-align: right;border-top: solid 2px darkgray;border-left: solid 2px darkgray;" >SUB TOTAL</td>
                        <td class="uang" style="border-top: solid 2px darkgray;">{{number_format($pembayaran,0,'.',',')}}</td>
                        <td class="uang" style="border-top: solid 2px darkgray;border-right: solid 2px darkgray;">{{number_format($pengeluaran,0,'.',',')}}</td>
                    </tr>
                    <tr style="background: whitesmoke;font-weight: bolder;font-size: large;color: black;">
                        <td colspan="5" style="text-align: right;border-bottom: solid 2px darkgray;border-left: solid 2px darkgray;"  >TOTAL</td>
                        @if($jenis=='K')
                        <td colspan="2" class="uang" style="border-bottom: solid 2px darkgray;border-right: solid 2px darkgray;">{{number_format($pengeluaran,0,'.',',')}}</td>
                        @else
                        <td colspan="2" class="uang" style="border-bottom: solid 2px darkgray;border-right: solid 2px darkgray;">{{number_format($pembayaran-$pengeluaran,0,'.',',')}}</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function() {
        //Format Data table
        $('.datatable').dataTable({
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                // Bold the grade for all 'A' grade browsers
                var index = iDisplayIndexFull + 1;
                $('td:eq(0)', nRow).html(index);
                return nRow;
            }
        });
    });
</script>
@stop
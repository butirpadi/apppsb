@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pembayaran PSB</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div class="alert alert-info" >
                Tahun Pelajaran &nbsp;<?php echo Form::select('tapel', $selectTapel, null, array('class' => 'input-medium')); ?>
                No Registrasi <?php echo Form::text('noreg', null, array('class'=>'input-medium'));?>
                Nama Calon Siswa <?php echo Form::text('nama', null, array('class'=>'input-xlarge'));?>
                <a class="btn btn-success">Tampilkan</a>
            </div>

            <div>
                
            </div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<div class="span4">      		

    <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> History Pembayaran PSB</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="news-items">
                <li>
                  
                  <div class="news-item-date"> <span class="news-item-day">10</span> <span class="news-item-month">Feb</span> </div>
                  <div class="news-item-detail"> <a href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title" target="_blank">Biaya Registrasi</a>
                    <p class="news-item-preview"> Rp. 100.000</p>
                  </div>
                  
                </li>
                <li>
                  
                  <div class="news-item-date"> <span class="news-item-day">10</span> <span class="news-item-month">Feb</span> </div>
                  <div class="news-item-detail"> <a href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title" target="_blank">Seragam Sekolah</a>
                    <p class="news-item-preview"> Rp. 115.000</p>
                  </div>
                  
                </li>
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>

</div> <!-- /span8 -->

<div class="span8">      		

    <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Biaya PSB belum dibayar</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th> Biaya</th>
                    <th> Jumlah</th>
                    <th> Potongan</th>
                    <th class="td-actions"> </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> Seragam Olah Raga</td>
                    <td> Rp. 75.000 </td>
                    <td> <?php echo Form::text('disc', null,array('class'=>'input-small uang','id'=>'potongan1'));?></td>
                    <td class="td-actions">
                        <?php echo Form::checkbox('bayar[]');?>                        
                    </td>
                  </tr>
                  <tr>
                    <td> Partisipasi</td>
                    <td> Rp. 3.500.000 </td>
                    <td> <?php echo Form::text('disc', null,array('class'=>'input-small uang','id'=>'potongan2'));?></td>
                    <td class="td-actions">
                        <?php echo Form::checkbox('bayar[]');?>                        
                    </td>
                  </tr>
                  <tr >
                      <td style="font-weight: bold;font-size: large;" colspan="2"> TOTAL BAYAR</td>
                      <td style="font-weight: bold;font-size: large;text-align: right;" colspan="2" class="td-actions">
                        Rp. 3.575.000
                    </td>
                  </tr>
                  <tr>
                      <td colspan="3"> </td>
                    <td class="td-actions">
                        <a class="btn btn-success">BAYAR</a>
                    </td>
                  </tr>
                
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>

</div> <!-- /span8 -->

@stop
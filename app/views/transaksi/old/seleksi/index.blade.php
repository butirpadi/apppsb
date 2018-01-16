@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Seleksi Calon Siswa</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div class="alert alert-info" >
                Tahun Pelajaran &nbsp;<?php echo Form::select('tapel', $selectTapel, null, array('class' => 'input-medium')); ?>
                <a class="btn btn-success">Tampilkan</a>
            </div>

            <div>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Reg</th>
                            <th>Nama</th>
                            <th>Komunikasi & Keterampilan</th>
                            <th>Kecerdasan Umum</th>
                            <th>Perkembangan <br/>Motorik Kasar</th>
                            <th>Perkembangan <br/>Motorik Halus</th>
                            <th>Kematangan Emosi</th>
                            <th>Kemandirian</th>
                            <th class="td-actions"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>012014</td>
                            <td>Afia Najah</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>012014</td>
                            <td>Syamsul Ma'arif</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>012014</td>
                            <td>Devina Pramawati</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>012014</td>
                            <td>Ali Nur Ramadhan</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>012014</td>
                            <td>Alifiah Annafisa</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>012014</td>
                            <td>Aulia Fitri Rachmania</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>012014</td>
                            <td>Dliyaul Haqqia</td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <?php echo Form::text('n1', null, array('class'=>'input-mini uang')); ?>
                            </td>                            
                            <td>
                                <a href="#" class="btn btn-mini btn-icon-only btn-info">Simpan</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="alert alert-info" style="text-align: center;">
                    <a href="{{ URL::to('transaksi/seleksi/hasil') }}" class="btn btn-success">PROSES SELEKSI <i class="icon-forward"></i></a>
                </div>
            </div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop
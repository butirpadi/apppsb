@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Hasil Seleksi Penerimaan Siswa</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div class="alert alert-info" >
                Tahun Pelajaran 2014 / 2015
            </div>

            <div>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Reg</th>
                            <th>Nama</th>
                            <th>Komunikasi & <br/> Keterampilan</th>
                            <th>Kecerdasan <br/> Umum</th>
                            <th>Perkembangan <br/>Motorik Kasar</th>
                            <th>Perkembangan <br/>Motorik Halus</th>
                            <th>Kematangan <br/>Emosi</th>
                            <th>Kemandirian</th>
                            <th style="background: yellow;">TOTAL</th>
                            <th class="td-actions">Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>012014</td>
                            <td>Afia Najah</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>012014</td>
                            <td>Syamsul Ma'arif</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>012014</td>
                            <td>Devina Pramawati</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>012014</td>
                            <td>Ali Nur Ramadhan</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>012014</td>
                            <td>Alifiah Annafisa</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>012014</td>
                            <td>Aulia Fitri Rachmania</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>012014</td>
                            <td>Dliyaul Haqqia</td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>
                            <td>
                                80
                            </td>                            
                            <td style="background: yellow;">
                                80
                            </td>                            
                            <td>
                                <?php echo Form::checkbox('lulus', null, false); ?>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="alert alert-info" style="text-align: center;">
                    <a class="btn btn-warning">EDIT NILAI <i class="icon-backward"></i></a>
                    <a href="{{ URL::to('transaksi/seleksi/lulus') }}" class="btn btn-success">PROSES SELEKSI <i class="icon-forward"></i></a>
                </div>
            </div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop
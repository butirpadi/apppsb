@extends('_layouts.default')

@section('main')

<div class="main-inner">
    <div class="container">
        <div class="row">
            <!-- /span6 -->
            <div class="span8">
                <div class="widget">
                    <div class="widget-header"> <i class="icon-bookmark"></i>
                        <h3>Shortcuts</h3>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="shortcuts"> 
                            <!--<a  href="#" class="shortcut pull-left" style="background-color: #639;width: 10%;"><i class="shortcut-icon icon-user" style="color: white;"></i><span class="shortcut-label" style="color: white;">Profil</span> </a>-->
                            <a href="{{ URL::route('master.gelombang.index') }}" class="shortcut pull-left" style="background-color: #329BC1;width: 20%;"><i class="shortcut-icon icon-list-ol" style="color: white;"></i><span class="shortcut-label" style="color: white;">Gelombang PSB</span> </a>
                            <a href="{{ URL::route('master.biaya.index') }}" class="shortcut pull-left" style="background-color: #7DB115;width: 20%;" ><i class="shortcut-icon icon-money" style="color: white;"></i><span class="shortcut-label" style="color: white;">Biaya</span> </a>
                            <a href="{{ URL::route('master.setbiaya.index') }}" class="shortcut pull-left" style="background-color: #D98200;width: 20%;"><i class="shortcut-icon icon-cog" style="color: white;"></i> <span class="shortcut-label" style="color: white;">Pengaturan Biaya</span> </a>
                            <a href="{{ URL::route('transaksi.registrasi.index') }}" class="shortcut pull-left" style="background-color: #953b39;width: 20%;"><i class="shortcut-icon icon-download" style="color: white;"></i> <span class="shortcut-label" style="color: white;">Registrasi</span> </a>
                            <a href="{{ URL::route('master.calonsiswa.index') }}" class="shortcut pull-left" style="background-color: #639;width: 20%;"><i class="shortcut-icon icon-user" style="color: white;"></i> <span class="shortcut-label" style="color: white;">Data Calon Siswa</span> </a>
                            <a href="{{ URL::route('rekap.rekap.index') }}" class="shortcut pull-left" style="background-color: #17CFB6;width: 20%;"><i class="shortcut-icon icon-list-alt" style="color: white;"></i> <span class="shortcut-label" style="color: white;">Rekap</span> </a>

                        </div>
                        <!-- /shortcuts --> 
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget -->
            </div>
            
            <div class="span4">
                <div class="widget">
                    <div class="widget-header"> <i class="icon-bookmark"></i>
                        <h3>JAM</h3>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="shortcuts"> 
                            <div class="pull-right" id="jam"></div>
                        </div>
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget -->
            </div>
            
            <div class="span8">
                <div class="widget">
                    <div class="widget-header"> <i class="icon-bookmark"></i>
                        <h3>Deskripsi</h3>
                    </div>
                    <!-- /widget-header -->
                    <div class="widget-content">
                        <div class="span">
                            <span style="font-size: 100px;"><i class="icon-briefcase"></i></span>
                        </div>
                        <div class="span5">
                            <table class="table table-form">
                                <tbody>
                                    <tr>
                                        <td colspan="3"><span class="label label-info">ePSB - SISTEM ADMINISTRASI PSB</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="label label-info">NAMA SEKOLAH</span></td>
                                        <td>:</td>
                                        <td>SDI SABILIL HUDA</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label label-info">ALAMAT</span></td>
                                        <td>:</td>
                                        <td>Jl. Singokarso 54 Sumorame Sidoarjo 61271</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /shortcuts --> 
                    </div>
                    <!-- /widget-content --> 
                </div>
                <!-- /widget -->
            </div>
            

            <!-- /span6 --> 
        </div>
        <!-- /row --> 
    </div>
    <!-- /container --> 
</div>

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function() {
        //setting jam
        var options2 = {format: '%A, %d %B %Y [%H:%M:%S]'};
        var jamLengkap = {format: '<div class="clock light"><p id="jamnya" data-date="%d %B %Y" data-ampm="{{ "TA : " }}" >%H:%M:%S</p></div>'};
        var jamTok = {format: '%H:%M:%S'};
        var tanggalTok = {format: '%A, %d %B %Y'};
        jQuery('#jam').jclock(jamLengkap);
    });
</script>
@stop
@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Rekap</h3>
            <div class="pull-right" style="padding-right: 10px;" id="pdf-convert-tag">
                <a class="btn btn-info btn-pdf">PDF</a>
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div class="alert alert-info">
                <form method="POST" action="rpt" >
                <table class="table table-form">
                    <tbody>
                        <tr>
                            <td>Tahun Pelajaran</td>
                            <td>:</td>
                            <td>
                                <?php echo Form::select('tapel', $selectTapel, null, array('class' => 'input-medium')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Tentukan rentang waktu</td>
                            <td>:</td>
                            <td><?php echo Form::text('awal', null, array('class' => 'input-medium datepicker', 'placeholder' => 'Tanggal Awal')); ?></td>
                            <td>-</td>
                            <td><?php echo Form::text('akhir', null, array('class' => 'input-medium datepicker', 'placeholder' => 'Tanggal Awal')); ?></td>
                            <td></td>
                            <td>
                                <a class="btn btn-success" id="btn-tampil" >Tampilkan</a>
                                <!--<button type="submit" class="btn btn-primary" >Tampil Komplit</button>-->
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>

            <div id="table-data"></div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function() {
        //drawDatatable();
        jQuery('select[name=tapel]').val([]);

        //hide tombol PDF
        jQuery('.btn-pdf').css('visibility', 'hidden');

        //tampilkan data transaksi
        jQuery('#btn-tampil').click(function() {
            var tglAwal = jQuery('input[name=awal]').val();
            var tglAkhir = jQuery('input[name=akhir]').val();
            var tapelid = jQuery('select[name=tapel]').val();
            //var getRekapUrl = "{{ URL::to('rekap/rekap/getregistrasi') }}" + "/" + tapelid + "/" + tglAwal + "/" + tglAkhir;
            var getBayarUrl = "{{ URL::to('rekap/rekap/getpembayaran') }}" + "/" + tglAwal + "/" + tglAkhir;
            jQuery('#table-data').html('<div class="loader"></div>').load(getBayarUrl);
            jQuery('.btn-pdf').css('visibility', 'visible');
        });

        /**
         * Conver ke pdf
         */
        jQuery('.btn-pdf').click(function() {
            var tglAwal = jQuery('input[name=awal]').val();
            var tglAkhir = jQuery('input[name=akhir]').val();
            var tapelid = jQuery('select[name=tapel]').val();
            var getConvertUrl = "{{ URL::to('rekap/rekap/topdf') }}" + "/" + tapelid + "/" + tglAwal + "/" + tglAkhir;
            window.location.href = getConvertUrl;
        });
    });
</script>
@stop
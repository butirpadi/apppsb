@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Calon Siswa</h3>
            <div class="pull-right" style="padding-right: 10px;">
                <a class="btn btn-primary" href="{{ URL::route('transaksi.registrasi.index') }}" >Registrasi</a>
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div class="alert alert-info" >
                <table class="table table-form">
                    <tbody>
                        <tr>
                            <td>Tahun Pelajaran</td>
                            <td>:</td>
                            <td>{{ Form::select('tapel', $selectTapel, null, array('class' => 'input-medium')) }}</td>
                            <td><a class="btn btn-success btn-tampil" >Tampilkan</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="table-calon-siswa">

            </div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->


@stop


@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function() {
        //set to non selected select tapel
        jQuery('select[name=tapel]').val([]);

        //tampilkan daftar calon siswa
        jQuery('.btn-tampil').click(function() {
            var tapelid = jQuery('select[name=tapel]').attr('value');
            if (tapelid == null || tapelid =='') {
                alert('Lengkapi data yang kosong.');
            } else {
                var getTableCalonUrl = "{{ URL::to('master/calonsiswa/getcalonsiswa') }}" + "/" + tapelid;
                jQuery('#table-calon-siswa').html('<div class="loader"></div>').load(getTableCalonUrl);
            }
        });
    });
</script>
@stop
@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Distribusi Calon Siswa</h3>
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
                var getTableCalonUrl = "{{ URL::to('transaksi/distribusi/getcalonbytapel') }}" + "/" + tapelid;
                jQuery('#table-calon-siswa').html('<div class="loader"></div>').load(getTableCalonUrl);
            }
        });
        
        /**
         * select change tapel
         * @param {type} data
         * @returns {undefined}
         */
        jQuery('select[name=tapel]').change(function(){
            jQuery('#table-calon-siswa').empty();
        });
        
        /**
         * Simpan distribusi
         */
        jQuery(document).on('click','.btn-simpan-distribusi',function() {
            var calonid = jQuery(this).attr('calonid');
            var regnum = jQuery(this).attr('regnum');
            var tapelid = jQuery('select[name=tapel]').val();
            var rombelid = jQuery('select[name=rombel_' + calonid + ']').val();
            
            if (rombelid == null || rombelid == '') {
                alert('Lengkapi data yang kosong.');
            } else {
                var simpanUrl = "{{ URL::to('transaksi/distribusi/distribute') }}";
                
                $.ajaxSetup({async: false});
                $.post(simpanUrl, {
                    'calonid': calonid,
                    'regnum': regnum,
                    'rombelid': rombelid,
                    'tapelid':tapelid
                }, function(data) {
                    jQuery('#post-rest').html(data);
                    alert('Distribusi siswa telah disimpan.');
                    //sembunyikan tombol simpan
                    jQuery('#btn-simpan-'+calonid).hide();
                    //tampilkan tombol batal
                    jQuery('#btn-batal-'+calonid).show();
                    //set siswaid untuk btn-batal
                    jQuery('#btn-batal-'+calonid).attr('siswaid',data);
                    //tampilkan informasi rombel
                    var namaRombel = jQuery('select[name=rombel_'+calonid+'] option:selected').text();
                    jQuery('select[name=rombel_'+calonid+']').before('<span class="label label-success" id="rombelcalon_' + calonid + '" >' + namaRombel + '</span>');
                    //sembunyikan select rombel
                    jQuery('select[name=rombel_'+calonid+']').hide();
                });
            }
        });
        
        /**
         * Bata;kan distribusi
         */
        jQuery(document).on('click','.btn-batal-distribusi',function() {
        
            var siswaid = jQuery(this).attr('siswaid');
            var calonid = jQuery(this).attr('calonid');
            var cancelUrl = "{{ URL::to('transaksi/distribusi/canceldistribute') }}";
        
            $.ajaxSetup({async: false});
            $.post(cancelUrl,{
                'siswaid':siswaid
            },function(data){
                jQuery('#post-rest').html(data);
                alert('Distribusi siswa telah dibatalkan');
                //sembunyikan tombol batal
                
                jQuery('#btn-batal-'+calonid).hide();
                //tampilkan tombol simpan
                
                jQuery('#btn-simpan-'+calonid).show();
                //hilangkan info rombel
                jQuery('#rombelcalon_'+calonid).remove();
                //tampilkan select rombel
                jQuery('select[name=rombel_' + calonid +  ']').show();
                
            });
            
            
        });
        
        
    });
</script>
@stop
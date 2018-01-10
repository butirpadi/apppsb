@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Edit Pengaturan Biaya</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <fieldset class="form-horizontal">
                {{ Form::hidden('tapelid',$tapel->id) }}
                <div class="control-group">											
                    <label class="control-label" >Tahun Pelajaran</label>
                    <div class="controls">
                        {{ Form::text('nama',$tapel->nama,array('class'=>'input-xlarge','autocomplete'=>'off','required','readonly')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
            </fieldset>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<style type="text/css">
    .table input{
        margin: 0;
    }
</style>

@for($i=0;$i<$tapel->gelombang->jumlah;$i++)
<div class="span6">
    <div class="widget">
        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Gelombang {{ $i+1 }}</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th></th>
                        <th>Biaya</th>
                        <th>Pria</th>
                        <th>Wanita</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($biaya as $dt)
                    <tr>
                        <td>{{ Form::checkbox('ckbiaya_gel_'. ($i+1) .'[]', null, false,array('class'=>'ckbiaya pull-right','id'=>$dt->id,'gel'=>($i+1))); }}</td>
                        <td>{{ $dt->nama }}</td>
                        <td>{{ Form::text('ptxbiaya_gel_' . ($i+1) .'_'. $dt->id,null,array('class'=>'input-small uang txnilai hidden','id'=>'ptxbiaya_gel_' .($i+1). '_' . $dt->id)) }}</td>
                        <td>{{ Form::text('wtxbiaya_gel_' . ($i+1) .'_'. $dt->id,null,array('class'=>'input-small uang txnilai hidden','id'=>'wtxbiaya_gel_' .($i+1). '_' . $dt->id)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endfor

<div class="span12">      		

    <div class="widget ">

        <div class="widget-content" style="text-align: center;">
            <a class="btn btn-success btn-simpan" >SIMPAN</a>
            <a class="btn btn-warning" href="{{ URL::route('master.setbiaya.index') }}" >KEMBALI</a>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<div id="try-rest"></div>

@stop

@section('custom-script')
<script type="text/javascript">

    jQuery(document).ready(function() {

        //cek data yang sudah tersimpan
        function loadDataOnEdit() {
            var isSet = "{{ count($tapel->biayas) }}";
            if (isSet > 0) {
                //tampilkan data yang telah disimpan sebelumnya
                //***
                //***
                //Ambil data yang tersimpan
                var getDataUrl = "{{ URL::to('master/setbiaya/getbiaya' . '/' . $tapel->id) }}";
                jQuery.ajaxSetup({cache: false});
                jQuery.ajax({url: getDataUrl, dataType: "json", async: false,
                    success: function(data) {
                        var dataBiaya = data;
                        for (i = 0; i < dataBiaya.length; i++) {
                            //check checkbox
                            jQuery('input[name=ckbiaya_gel_' + dataBiaya[i].pivot.gelombang + '[]][id=' + dataBiaya[i].id + ']').attr('checked', 'checked');
                            //set value textbox
                            jQuery('input[name=ptxbiaya_gel_' + dataBiaya[i].pivot.gelombang + '_' + dataBiaya[i].id + ']').removeClass('hidden');
                            jQuery('input[name=ptxbiaya_gel_' + dataBiaya[i].pivot.gelombang + '_' + dataBiaya[i].id + ']').attr('value', formatRupiahVal(dataBiaya[i].pivot.p_nilai));
                            jQuery('input[name=wtxbiaya_gel_' + dataBiaya[i].pivot.gelombang + '_' + dataBiaya[i].id + ']').removeClass('hidden');
                            jQuery('input[name=wtxbiaya_gel_' + dataBiaya[i].pivot.gelombang + '_' + dataBiaya[i].id + ']').attr('value', formatRupiahVal(dataBiaya[i].pivot.w_nilai));
                        }
                    }, error: function(data) {
                        alert('Request data gagal.');
                    }
                });

            }
        }
        loadDataOnEdit();


        jQuery('.ckbiaya').click(function() {
            var isCek = jQuery(this).attr('checked');
            var id = jQuery(this).attr('id');
            var gel = jQuery(this).attr('gel');
            if (isCek == 'checked') {
                //jika di centang maka tampilkan textbox nilainya
                jQuery('#ptxbiaya_gel_' + gel + '_' + id).removeClass('hidden');
                jQuery('#wtxbiaya_gel_' + gel + '_' + id).removeClass('hidden');
            } else {
                //jika tidak dicentang sembunyikan textbox nya
                jQuery('#ptxbiaya_gel_' + gel + '_' + id).addClass('hidden');
                jQuery('#wtxbiaya_gel_' + gel + '_' + id).addClass('hidden');
            }
        });


        jQuery('.btn-simpan').click(function() {
            var tapelid = jQuery('input[name=tapelid]').attr('value');
            var biayas = [];
            //kumpulkan data biayas
            jQuery('input[type=checkbox]').each(function() {
                if (jQuery(this).is(':checked')) {
                    var gel = jQuery(this).attr('gel');
                    var biayaid = jQuery(this).attr('id');
                    var p_nilai = unformatRupiahVal(jQuery('input[name=ptxbiaya_gel_' + gel + '_' + biayaid + ']').attr('value'));
                    var w_nilai = unformatRupiahVal(jQuery('input[name=wtxbiaya_gel_' + gel + '_' + biayaid + ']').attr('value'));
                    biayas[biayas.length] = {"tahunajaran_id": tapelid, 'gelombang': gel, 'psbbiaya_id': biayaid, 'p_nilai': p_nilai, 'w_nilai': w_nilai};
                }
            });
            //simpan ke database
            jQuery.post("{{ URL::to('master/setbiaya/simpan') }}", {
                biayas: JSON.stringify(biayas),
                tahunajaran_id: tapelid
            }).fail(function(data) {
                alert('Simpan data gagal, periksa kembali.');
                //jQuery('#post-rest').html(data);
            }).done(function(data) {
                alert('Data telah berhasil disimpan.');
                //jQuery('#post-rest').html(data);
                //location.reload();
            });

        });

    });


</script>
@stop

@extends('_layouts.default')

@section('main')
<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Registrasi Calon Siswa</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content" id="reg-content">            
            <?php //echo Form::open(array('route' => 'transaksi.registrasi.store', 'class' => 'form-horizontal')) ?>
            <fieldset class="form-horizontal">

                <?php echo Form::hidden('tapelaktif', $tapelAktif->id); ?>
                <div class="control-group">											
                    <label class="control-label" >Tahun Pelajaran</label>
                    <div class="controls">
                        {{ Form::select('tapel',$selectTapel,null,array('class'=>'input-medium')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" >Tanggal</label>
                    <div class="controls">
                        {{ Form::text('tgl',date('d-m-Y'),array('class'=>'input-small datepicker','required')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" >Gelombang</label>
                    <div class="controls select-gelombang">

                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" >Nomor Registrasi</label>
                    <div class="controls">
                        {{ Form::text('regid',null,array('class'=>'input-medium','required','readonly','autocomplete'=>'off','style'=>'font-size:2em;width:200px;height:50px;text-align:center;')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" >Nama</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','autofocus','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" >Jenis Kelamin</label>
                    <div class="controls">
                        {{ Form::select('jk',array('L'=>'Laki-laki','P'=>'Perempuan'),null,array('class'=>'input-medium','disabled'=>'disabled')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" >Pembayaran</label>
                    <div class="controls table-pembayaran">

                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" >Status Diterima</label>
                    <div class="controls">
                        {{ Form::select('status',array('P'=>'Pending','Y'=>'Diterima'),'P',array('class'=>'input-medium','required')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="form-actions">
                    <!--{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}-->
                    <a class="btn btn-primary" id="btn-simpan">Simpan</a>
                    <a class="btn btn-success" id="btn-simpan-cetak">Simpan & Cetak Nota</a>
                    <a class="btn" href="{{ URL::route('master.calonsiswa.index') }}" >Calon Siswa Terdaftar</a>
                </div> <!-- /form-actions -->
            </fieldset>
            <?php //echo Form::close(); ?>


        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<div id="post-rest"></div>
<div id="cetak"></div>

<!--<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }}" name="QZPrint" code="qz.PrintApplet.class" width="50" height="50"> 
    <param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}"> 
    <param name="cache_option" value="plugin"> 
    <param name="disable_logging" value="false"> 
    <param name="initial_focus" value="false"> 
</applet>-->
<br />

@stop

@section('custom-script')

<script type="text/javascript">
    jQuery(document).ready(function() {

        //reset ke posisi nol select tapel
        jQuery('select[name=tapel]').val([]);
        jQuery('select[name=jk]').val([]);
        jQuery('select[name=status]').val([]);
        //set to not active/readonly
        jQuery('input[name=nama]').attr('readonly', 'readonly');
        //focus ke select tapel
        jQuery('select[name=tapel]').focus();
        //simpan data registrasi
        jQuery('#btn-simpan').click(function() {
            if (bolehSimpan()) {
                if (simpanRegistrasi()) {
                    alert('Data telah disimpan.');
                    location.reload();
                } else {
                    alert('Data gagal disimpan, periksa kembali data inputan.');
                }
                ;
            } else {
                alert('Lengkapi data yang kosong.');
            }

        });
        jQuery('#btn-simpan-cetak').click(function() {
            //load aplet
            //simpan data
            if (bolehSimpan()) {
                //simpan data
                if (simpanRegistrasi()) {
                    //embed applet tag
                    //menggunakan qzprint
                    //var appletTag = '<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }} " name="QZPrint" code="qz.PrintApplet.class" width="50" height="50"><param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}"><param name="cache_option" value="plugin"><param name="disable_logging" value="false"><param name="initial_focus" value="false"></applet>';
                    //menggunakan jzebra
                    var appletTag = '<applet name="QZPrint" code="jzebra.PrintApplet.class" archive="{{ URL::to('jar/jzebra.jar') }}" width="1px" height="1px">'
                    jQuery('body').after(appletTag);
                    //--cetak nota---       
                    var getNotaUrl = "{{ URL::to('transaksi/registrasi/getnota') }}";
                    //alert(getNotaUrl);
                    var notaText;
                    $.ajax({
                        type: "POST",
                        url: getNotaUrl,
                        data: {
                            'datareg': JSON.stringify(dataReg),
                            'databayar': JSON.stringify(dataBayar)
                        },
                        success: function(data) {
                            notaText = data;
                            //alert(notaText);
                            QZPrint.findPrinter("{{ $appset->printeraddr }}");
                            QZPrint.append(notaText);
                            QZPrint.print();
                            alert('Data telah disimpan.\nCetak nota sedang diproses.');
                            location.reload();
                        },
                        dataType: 'text'
                    });
                } else {
                    alert('Data gagal disimpan, periksa kembali data inputan.');
                }
            } else {
                alert('Lengkapi data yang kosong.');
            }
        });
        //fungsi simpan
        var dataReg;
        var dataBayar = [];
        function simpanRegistrasi() {
            var simpanUrl = "{{ URL::to('transaksi/registrasi/simpan') }}";
            dataReg = {
                "tapeldaftar_id": jQuery('input[name=tapelaktif]').val(),
                "tapelmasuk_id": jQuery('select[name=tapel]').val(),
                "gelombang": jQuery('select[name=gelombang]').val(),
                "regnum": jQuery('input[name=regid]').val(),
                "nama": jQuery('input[name=nama]').val(),
                "jk": jQuery('select[name=jk]').val(),
                "tgl": jQuery('input[name=tgl]').val(),
                "status": jQuery('select[name=status]').val()
            };

            jQuery('input[type=checkbox][name=ckbiaya[]]').each(function() {
                if (jQuery(this).attr('checked') == 'checked') {
                    var biayaId = jQuery(this).attr('value');
                    var nilai = unformatRupiahVal(jQuery('input[name=dibayar_' + biayaId + ']').val());
                    var potongan = unformatRupiahVal(jQuery('input[name=potongan_' + biayaId + ']').val());
                    var harusbayar = unformatRupiahVal(jQuery('.harusbayar_' + biayaId).text());
                    //alert(harusbayar);
                    //totalBayar += parseInt(unformatRupiahVal(parseInt(nilai)));                   
                    dataBayar[dataBayar.length] = {
                        'psbbiaya_id': biayaId,
                        'harusbayar': harusbayar,
                        'dibayar': nilai,
                        'potongan': potongan
                    };
                }
            });

            //simpan data ke database
            var berhasil = false;
            $.ajaxSetup({async: false});
            $.post(simpanUrl, {
                'datareg': JSON.stringify(dataReg),
                'databayar': JSON.stringify(dataBayar)
            }, function(data) {
                berhasil = true;
            });
            
            return berhasil;
        };

        function bolehSimpan() {
            var tapel = jQuery('select[name=tapel]').val();
            var gelombang = jQuery('select[name=gelombang]').val();
            var regnum = jQuery('input[name=regid]').val();
            var nama = jQuery('input[name=nama]').val();
            var jk = jQuery('select[name=jk]').val();
            if (nama == null || nama == '' || tapel == null || tapel == '' || gelombang == null || gelombang == '' || regnum == '' || regnum == null || jk == '' || jk == null) {
                return false;
            } else {
                return true;
            }
        };

        //select gelombang selected
        jQuery(document).on('change', 'select[name=gelombang]', function() {
            //set input nama to editable
            jQuery('input[name=nama]').removeAttr('readonly');
            //set select jk to enable
            jQuery('select[name=jk]').removeAttr('disabled');
            //set focus input nama
            jQuery('input[name=nama]').focus();
        });
        //generate daftar pembayaran
        jQuery('select[name=jk]').change(function() {
            //generate daftar pembayaran
            var tapelid = jQuery('select[name=tapel]').attr('value');
            var gelombang = jQuery('select[name=gelombang]').val();
            var jk = jQuery('select[name=jk]').val();
            var getPembayaranUrl = "{{ URL::to('transaksi/registrasi/getbiaya') }}" + "/" + tapelid + "/" + gelombang + "/" + jk;
            jQuery('.table-pembayaran').load(getPembayaranUrl, null, function() {
                //sembunyikan input dibayar
                jQuery('.dibayar').attr('hidden', 'hidden');
            }).fail(function() {
                alert('Request data gagal.');
            });
        });
        //generate regid
        jQuery('select[name=tapel]').change(function() {
            var tapelid = jQuery(this).attr('value');
            //generate select gelombang
            var getSelectGelUrl = "{{ URL::to('transaksi/registrasi/getgelombang') }}" + "/" + tapelid;
            jQuery('.select-gelombang').load(getSelectGelUrl, null, function(data) {
                //set to not selected
                jQuery('select[name=gelombang]').val([]);
            });
            //generate regid            
            var getRegidUrl = "{{ URL::to('transaksi/registrasi/getregid') }}" + "/" + tapelid;
            var regid;
            jQuery.get(getRegidUrl, null, function(data) {
                regid = data;
                //set regid ke textbox
                jQuery('input[name=regid]').attr('value', regid);
            }).fail(function(data) {
                alert('Request Registration ID Gagal. Coba Lagi.');
                jQuery('input[name=regid]').attr('value', '');
            });
            //menampilkan input dibayar & potongan
            jQuery(document).on('click', 'input[name=ckbiaya[]]', function() {
                var biayaId = jQuery(this).attr('value');
                //show input
                if (jQuery(this).attr('checked') == 'checked') {
                    jQuery('.dibayar_' + biayaId).removeAttr('hidden');
                    jQuery('input[name=dibayar_' + biayaId + ']').focus();
                    jQuery('.potongan_' + biayaId).removeAttr('hidden');
                    jQuery('input[name=potongan_' + biayaId + ']').focus();
                    jQuery('input[name=dibayar_' + biayaId + ']').focus();
                } else {
                    jQuery('.dibayar_' + biayaId).attr('hidden', 'hidden');
                    jQuery('.potongan_' + biayaId).attr('hidden', 'hidden');
                }
                //calculate biaya harus dibayar
                calculateBayar();
            });
        });
        //calculate on change
        jQuery(document).on('change', '.text-dibayar', function() {
            //cek apakah dibayar lebih besar dari yang harus dibayarkan
            var biayaId = jQuery(this).attr('biayaid');
            var harusbayar = unformatRupiahVal(jQuery('.harusbayar_' + biayaId).text());
            var potongan = unformatRupiahVal(jQuery('#potongan_' + biayaId).attr('value'));
            var dibayar = unformatRupiahVal(jQuery('input[name=dibayar_' + biayaId + ']').attr('value'));
            if (parseInt(dibayar) > (parseInt(harusbayar) - parseInt(potongan))) {
                alert('Nilai yang anda inputkan melebihi ketentuan.');
                //set ke kosong
                jQuery('input[name=dibayar_' + biayaId + ']').removeAttr('value');
                //focuskan
                jQuery('input[name=dibayar_' + biayaId + ']').focus();
            } else {
                calculateBayar();
            }
        });
        jQuery(document).on('change', '.text-potongan', function() {
            //calculateBayar();
            //rubah dibayar ke maksimal bayar
            var biayaId = jQuery(this).attr('biayaid');
            var harusbayar = unformatRupiahVal(jQuery('.harusbayar_' + biayaId).text());
            var potongan = unformatRupiahVal(jQuery('#potongan_' + biayaId).attr('value'));
            var dibayar = unformatRupiahVal(jQuery('input[name=dibayar_' + biayaId + ']').attr('value'));
            //cek potongan lebih besar dari yang ditentukan atau tidak
            if (parseInt(potongan) > parseInt(harusbayar)) {
                alert('Nilai yang anda inputkan melebihi ketentuan.');
                //set ke kosong
                jQuery('#potongan_' + biayaId).removeAttr('value');
                //focuskan
                jQuery('#potongan_' + biayaId).focus();
            } else {
                //update dibayar ke maksimal pembayaran setelah di potong
                //jQuery('.harusbayar_'+biayaId).text(formatRupiahVal(parseInt(harusbayar)-parseInt(potongan)));
                jQuery('input[name=dibayar_' + biayaId + ']').attr('value', formatRupiahVal(parseInt(harusbayar) - parseInt(potongan)));
                //kalkulasi ulang pembayaran
                calculateBayar();
            }


        });
        //hitung total pembayaran
        function calculateBayar() {
            var totalBayar = 0;
            jQuery('input[type=checkbox][name=ckbiaya[]]').each(function() {

                if (jQuery(this).attr('checked') == 'checked') {
                    var biayaId = jQuery(this).attr('value');
                    var nilai = jQuery('input[name=dibayar_' + biayaId + ']').val();
                    var potongan = jQuery('input[name=potongan_' + biayaId + ']').val();
                    //totalBayar += parseInt(unformatRupiahVal(parseInt(nilai)));                   
                    //totalBayar = totalBayar + parseInt(unformatRupiahVal(nilai)) - parseInt(unformatRupiahVal(potongan));
                    totalBayar = totalBayar + parseInt(unformatRupiahVal(nilai));
                }
            });
            jQuery('.total-bayar').text(formatRupiahVal(totalBayar));
        }

    });
</script>
@stop

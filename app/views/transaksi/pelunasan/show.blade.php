@extends('_layouts.default')

@section('main')
<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pelunasan Pembayaran PSB</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->
        <div class="widget-content">    
            <div class="alert alert-success">
                <form action="transaksi/pelunasan/showpembayaran" method="POST">
                    <table class="table table-form">
                        <tbody>
                            <tr>
                                <td>No. Reg.</td>
                                <td>:</td>
                                <td>{{ Form::text('regid',$regid,array('required','class'=>'input-medium','placeholder'=>'Nomor Registrasi')) }}</td>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ Form::text('nama',$nama,array('required','class'=>'input-xlarge','placeholder'=>'Nama')) }}</td>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>{{ Form::text('tgl',$tgl,array('required','class'=>'input-small datepicker','placeholder'=>'Nama')) }}</td>
                                <td>&nbsp;</td>
                                <td><button type="submit" class="btn btn-success" >Tampilkan</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->


<div class="span7" id="widget-status">      		
    <div class="widget ">
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Status Pembayaran</h3>
        </div> <!-- /widget-header -->
        <div class="widget-content" >
            <?php $semualunas = true; ?>
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Biaya</th>
                        <th>Nilai</th>
                        <th>Pot</th>
                        <th>Dibayar</th>
                        <th>Sisa</th>
                        <th>Lunas</th>
                        <th class="td-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rownum = 1; ?>
                    @foreach($tapel->biayas()->where('gelombang',$calon->gelombang)->get() as $dt)
                    <tr>
                        <td>{{ $rownum++ }}</td>
                        <td>{{ $dt->nama }}</td>
                        <td style="text-align: right;">
                            <?php $harusbayar = 0; ?>
                            @if($calon->jenis_kelamin == 'L')
                            <?php $harusbayar = $dt->pivot->p_nilai; ?>
                            @else
                            <?php $harusbayar = $dt->pivot->w_nilai; ?>
                            @endif
                            {{ number_format($harusbayar,0,',','.') }}
                        </td>
                        <td style="text-align: right;">
                            <?php $pot = 0; ?>
                            @foreach($calon->registrasi->pembayarans as $dt1)
                            @if($dt1->psbbiaya_id == $dt->id)
                            <?php $pot = $dt1->potongan; ?>
                            @endif
                            @endforeach
                            {{ number_format($pot,0,',','.') }}
                        </td>
                        <td style="text-align: right;">
                            <?php $dibayar = 0; ?>
                            @foreach($calon->registrasi->pembayarans as $dt1)
                            @if($dt1->psbbiaya_id == $dt->id)
                            <?php $dibayar+=$dt1->dibayar; ?>
                            @endif
                            @endforeach
                            {{ number_format($dibayar,0,',','.') }}
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($harusbayar - $pot - $dibayar,0,',','.') }}
                        </td>
                        <td style="text-align: center;">
                            @if(($harusbayar-$pot) == $dibayar)
                            <i class="icon-ok" style="color: #5e8510;" ></i>
                            @else
                            <i class="icon-minus" style="color: red;"></i>
                            <?php $semualunas = false; ?>
                            @endif
                        </td>
                        <td></td>
                    </tr>                        
                    @endforeach
                </tbody>
            </table>

            @if(!$semualunas)
            <a class="btn btn-warning pull-right btn-lunasi">LUNASI SEKARANG</a>
            @endif
        </div>
    </div>
</div>

<div class="span5" id="widget-histori">      		
    <div class="widget ">
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Histori Pembayaran</h3>
        </div> <!-- /widget-header -->
        <div class="widget-content" >
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nota</th>
                        <th>Tanggal</th>
                        <th>Biaya</th>
                        <th>Dibayar</th>
                        <th class="td-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rownum = 1; ?>
                    <?php $tgl = null; ?>
                    @foreach($calon->registrasi->pembayarans as $dt)
                    <tr>
                        <td>{{ $rownum++ }}</td>
                        <td>
                            @if($dt->tgl == $tgl)
                            @else
                            <a class="btn btn-mini btn-cetak-nota" tgl="{{ date('d-m-Y',strtotime($dt->tgl)) }}" ><i class="icon-copy"></i></a>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($dt->tgl == $tgl)
                            -"-
                            @else
                            {{ date('d-m-Y',strtotime($dt->tgl)) }}
                            @endif
                        </td>
                        <td>{{ $dt->biaya->nama }}</td>
                        <td style="text-align: right;">{{ number_format($dt->dibayar,0,',','.') }}</td>
                        <td>
                            @if($dt->tgl == $tgl)
                            @else
                            <a class="btn btn-primary btn-mini" href="transaksi/pelunasan/editbayar/{{$dt->id}}" >Edit</a>
                            @endif

                        </td>
                    </tr>
                    <?php $tgl = $dt->tgl; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="span12" id="widget-pelunasan">      		
    <div class="widget ">
        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pembayaran/Pelunasan</h3>
        </div> <!-- /widget-header -->
        <div class="widget-content" >
            <?php $semualunas = true; ?>
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Biaya</th>
                        <th class="hidden">Nilai</th>
                        <th class="hidden">Pot</th>
                        <th class="hidden">Telah Dibayar</th>
                        <th>Belum Dibayar</th>
                        <th></th>
                        <th>Potongan</th>
                        <th>Bayar</th>
                        <th class="td-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rownum = 1; ?>
                    @foreach($tapel->biayas()->where('gelombang',$calon->gelombang)->get() as $dt)

                    <?php $harusbayar = 0; ?>
                    @if($calon->jenis_kelamin == 'L')
                    <?php $harusbayar = $dt->pivot->p_nilai; ?>
                    @else
                    <?php $harusbayar = $dt->pivot->w_nilai; ?>
                    @endif

                    <?php $pot = 0; ?>
                    <?php $dibayar = 0; ?>
                    @foreach($calon->registrasi->pembayarans as $dt1)
                    @if($dt1->psbbiaya_id == $dt->id)
                    <?php $pot = $dt1->potongan; ?>
                    @endif

                    @if($dt1->psbbiaya_id == $dt->id)
                    <?php $dibayar+=$dt1->dibayar; ?>
                    @endif
                    @endforeach

                    @if(($harusbayar-$pot) == $dibayar)
                    @else
                    <tr>
                        <td>{{ $rownum++ }}</td>
                        <td>{{ $dt->nama }}</td>
                        <td class="hidden" style="text-align: right;" id="harusbayar_{{$dt->id}}" >
                            <!--HARUS BAYAR-->
                            {{ number_format($harusbayar,0,',','.') }}
                        </td>
                        <td class="hidden" style="text-align: right;">
                            <!--POTONGAN-->
                            {{ number_format($pot,0,',','.') }}
                        </td>
                        <td class="hidden" style="text-align: right;">                
                            <!--TELAH DIBAYAR-->
                            {{ number_format($dibayar,0,',','.') }}
                        </td>
                        <td style="text-align: right;">
                            <!--BELUM DIBAYAR-->
                            {{ number_format($harusbayar - $pot - $dibayar,0,',','.') }}
                        </td>
                        <td>
                            @if(($harusbayar-$pot) == $dibayar)
                            @else
                            <?php echo Form::checkbox('ckbayar[]', $dt->id, false, array('class' => 'ckbayar')); ?>
                            <?php $semualunas = false; ?>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <?php echo Form::text('potongan', 0, array('class' => 'uang txpotongan', 'style' => 'width:95%;', 'id' => 'txpotongan_' . $dt->id, 'biayaid' => $dt->id)) ?>
                        </td>
                        <td style="text-align: right;">
                            <?php echo Form::text('bayar', number_format($harusbayar - $pot - $dibayar, 0, ',', '.'), array('class' => 'uang txbiaya', 'style' => 'width:95%;', 'id' => 'txbiaya_' . $dt->id, 'biayaid' => $dt->id)) ?>
                        </td>
                        <td></td>
                    </tr> 
                    @endif                       

                    @endforeach
                    <tr>
                        <td colspan="4">
                            TOTAL BAYAR
                        </td>
                        <td id="text-total-bayar" style="text-align: right;" colspan="2">

                        </td>
                        <td>

                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="span12" style="text-align: center;">
                <a class="btn btn-success btn-simpan-lunasi">Simpan</a>
                <a class="btn btn-info btn-simpan-cetak-lunasi">Simpan & Cetak Nota</a>
                <a class="btn btn-warning btn-batal-lunasi">Batal</a>
            </div>
        </div>
    </div>
</div>

<div id="applet-tag"></div>

<!-- Modal -->
<div id="modal-search-calon" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pencarian Data Calon Siswa</h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
    </div>
</div>

<!--modal-->
<div id="modal-lunasi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pelunasan Pembayaran PSB</h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
        <button class="btn btn-success">Simpan & Cetak Nota</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>

    </div>
</div>
<div id="post-rest"></div>

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function () {
//
//        //set focus on load
//        jQuery('input[name=regid]').focus();
//
//        //reset ke posisi nol select tapel
//        jQuery('select[name=tapel]').val([]);
//
//        //hide widget
//        jQuery('#widget-histori').hide();
//        jQuery('#widget-status').hide();
//        jQuery('#widget-pelunasan').hide();
//
//        /**
//         * Search data calon siswa dengan REGID
//         */
//        jQuery('input[name=regid]').change(function() {
//            setCalonToInput();
//        });
//
//        function setCalonToInput() {
//            var regid = jQuery('input[name=regid]').val();
//            var calon = searchByRegid(regid);
//
//            //clear input
//            jQuery('input[name=nama]').val('');
//
//            if (calon) {
//                //tampilkan ke form
//                jQuery('input[name=regid]').val(calon.regnum);
//                jQuery('input[name=nama]').val(calon.nama);
//                //hide tabel status dan histori
//                jQuery('#widget-histori').hide();
//                jQuery('#widget-status').hide();
//                jQuery('#widget-pelunasan').hide();
//            } else {
//                alert('Data Calon Siswa tidak ditemukan, periksa kembali nomor registrasi.');
//                //clear
//                jQuery('input[name=regid]').val('');
//                jQuery('input[name=nama]').val('');
//                //focus
//                jQuery('input[name=regid]').focus();
//            }
//        }
//
//        function searchByRegid(regid) {
//            var getCalonUrl = "{{ URL::to('transaksi/pelunasan/getcalonbyregid') }}" + "/" + regid;
//            var rData = null;
//            jQuery.ajax({
//                url: getCalonUrl,
//                dataType: "json",
//                async: false,
//                success: function(data) {
//                    rData = data;
//                }
//            });
//
//            return rData;
//        }
//        ;
//
//        /**
//         * cari data calon siswa dengan nama
//         */
//        jQuery('input[name=nama]').focus(function(data) {
//            //get data calon siswa
//            var getCalonUrl = "{{ URL::to('transaksi/pelunasan/getcalons') }}";
//            jQuery('#modal-search-calon .modal-body').html('<div class="loader" ></div>').load(getCalonUrl);
//            jQuery('#modal-search-calon').modal('show');
//        });
//
//        /**
//         * Tombol pilih siswa diclick
//         */
//        jQuery(document).on('click', '.btn-pilih', function(data) {
//            var regnum = jQuery(this).attr('regnum');
//            //set to input
//            jQuery('input[name=regid]').attr('value', regnum);
//            setCalonToInput();
//        })
//
//
//        /**
//         * tombol tampil di klik
//         **/
//        jQuery('#btn-tampil').click(function() {
//            //reset widget dulu
//            resetWidget();
//            //
//            var regid = jQuery('input[name=regid]').val();
//            var nama = jQuery('input[name=nama]').val();
//
//            if (regid == null || regid == '' || nama == null || nama == '') {
//                alert('Lengkapi data yang kosong.');
//            } else {
//                //tampilkan status bayar
//                //var getStatusUrl = "{{ URL::to('transaksi/pelunasan/getstatusbayar') }}" +"/"+tapelid+"/"+regid;
//                var getStatusUrl = "{{ URL::to('transaksi/pelunasan/getstatusbayar') }}" + "/" + regid;
//                jQuery('#widget-status .widget .widget-content').html('<div class="loader"></div>').load(getStatusUrl);
//                //tampilkan histori pembayaran
//                var getPembayaranUrl = "{{ URL::to('transaksi/pelunasan/getdatapembayaran') }}" + "/" + regid;
//                jQuery('#widget-histori .widget .widget-content').html('<div class="loader"></div>').load(getPembayaranUrl);
//
//                //tampilkan widget yang hidden
//
//                jQuery('#widget-histori').fadeIn();
//                jQuery('#widget-status').fadeIn();
//            }
//        });
//        /**
//         * Reset/sembunyikan semua widget
//         */
//        function resetWidget() {
//            jQuery('#widget-histori').hide();
//            jQuery('#widget-status').hide();
//            jQuery('#widget-pelunasan').hide();
//        }
//
//        /**
//         * Lunasi Sekarang
//         */
//        jQuery(document).on('click', '.btn-lunasi', function(data) {
//            var regnum = jQuery('input[name=regid]').val();
//            var getPelunasanUrl = "{{ URL::to('transaksi/pelunasan/lunasi') }}" + "/" + regnum;
////            jQuery('#modal-lunasi .modal-body').html('<div class="loader" ></div>').load(getPelunasanUrl);
////            jQuery('#modal-lunasi').modal('show');
//            jQuery('#widget-pelunasan .widget-content').load(getPelunasanUrl, null, function(data) {
//                //sembunyikan widget yan lain
//                jQuery('#widget-histori').hide();
//                jQuery('#widget-status').hide();
//                //tampilkan widget pelunasan
//                jQuery('#widget-pelunasan').fadeIn();
//                //$.scrollTo( '#widget-pelunasan');
//            });
//
//        });
//
//        /**
//         * Tutup widget lunasi click tombol batal lunas
//         */
//        jQuery(document).on('click', '.btn-batal-lunasi', function() {
//            jQuery('#widget-pelunasan').hide();
//            //open widget status dan histori
//            jQuery('#widget-histori').fadeIn();
//            jQuery('#widget-status').fadeIn();
//        });
//
//        /**
//         * cek apakah bisa disimpan atau tidak
//         * @returns {undefined}
//         */
//        function bolehsimpan() {
//            var ceked = 0;
//            jQuery('input[type=checkbox][name=ckbayar[]]').each(function() {
//                if (jQuery(this).attr('checked') == 'checked') {
//                    ceked += 1;
//                }
//            });
//
//            if (ceked > 0) {
//                return true;
//            } else {
//                return false;
//            }
//        }
//
//        /**
//         * Simpan data ke database
//         */
//        jQuery(document).on('click', '.btn-simpan-lunasi', function() {
////            simpan data ke database
//            if (bolehsimpan()) {
//                if (saveToDB()) {
//                    alert('Data telah disimpan');
//                    location.reload();
//                } else {
//                    alert('Simpan data gagal, periksa kembali.');
//                }
//                ;
//            } else {
//                alert('Tidak ada data yang disimpan');
//            }
//
//        });
//
//
//        /**
//         * Simpan & Cetak
//         */
//        jQuery(document).on('click', '.btn-simpan-cetak-lunasi', function() {
//            if (bolehsimpan()) {
//                //persiapkan applet
//                //menggunakan qzprint
//                //var appletTag = '<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }} " name="QZPrint" code="qz.PrintApplet.class" width="50" height="50"><param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}"><param name="cache_option" value="plugin"><param name="disable_logging" value="false"><param name="initial_focus" value="false"></applet>';
//                //menggunakan jzebra
//                var appletTag = '<applet name="QZPrint" code="jzebra.PrintApplet.class" archive="{{ URL::to('jar/jzebra.jar') }}" width="50px" height="50px">'
//                //jQuery('body').after(appletTag);
//                jQuery('#applet-tag').html(appletTag);
//                if (saveToDB()) {
//                    var cetakUrl = "{{ URL::to('transaksi/pelunasan/getnota') }}";
//                    var notaText;
//                    $.ajax({
//                        type: "POST",
//                        url: cetakUrl,
//                        data: {
//                            'datareg': JSON.stringify(dataReg),
//                            'databayar': JSON.stringify(dataBayar)
//                        },
//                        success: function(data) {
//                            notaText = data;
//                            //alert(notaText);
//                            QZPrint.findPrinter("{{ $appset->printeraddr }}");
//                            QZPrint.append(notaText);
//                            QZPrint.print();
//                            alert('Data telah disimpan.\nCetak nota sedang diproses.');
//                            location.reload();
//                        },
//                        dataType: 'text'
//                    });
//                } else {
//                    alert('Simpan data gagal, periksa kembali.');
//                }
//            } else {
//                alert('Tidak ada data yang disimpan');
//            }
//        });
//
//        /**
//         * Fungsi simpan ke database
//         */
//        var dataReg;
//        var dataBayar = [];
//        function saveToDB() {
//            dataReg;
//            dataBayar = [];
//            var simpanUrl = "{{ URL::to('transaksi/pelunasan/simpan') }}";
//
//            dataReg = {
//                "regnum": jQuery('input[name=regid]').val(),
//                "tgl": jQuery('input[name=tgl]').val()
//            };
//
//            jQuery('input[type=checkbox][name=ckbayar[]]').each(function() {
//
//                if (jQuery(this).attr('checked') == 'checked') {
//                    var biayaId = jQuery(this).attr('value');
//                    var nilai = unformatRupiahVal(jQuery('#txbiaya_' + biayaId).val());
//                    var potongan = unformatRupiahVal(jQuery('#txpotongan_' + biayaId).val());
//                    var harusbayar = unformatRupiahVal(jQuery('#harusbayar_' + biayaId).text());
//
//                    //totalBayar += parseInt(unformatRupiahVal(parseInt(nilai)));                   
//                    dataBayar[dataBayar.length] = {
//                        "psbbiaya_id": biayaId,
//                        "harusbayar": harusbayar,
//                        "dibayar": nilai,
//                        "potongan": potongan
//                    };
//                }
//            });
//
//            var berhasil = false;
//            $.ajaxSetup({async: false});
//            $.post(simpanUrl, {
//                'datareg': JSON.stringify(dataReg),
//                'databayar': JSON.stringify(dataBayar)
//            }, function(data) {
//                berhasil = true;
//                //alert(data);
//                //jQuery('#post-rest').html(data);
//            });
//
//            return berhasil;
//        }


    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        //hide text biaya
        jQuery('.txbiaya').hide();
        jQuery('.txpotongan').hide();

        /**
         * tampilkan input bayar saat checkbox di centang
         * 
         */
        jQuery(document).on('change', '.ckbayar', function(data) {
            var checked = jQuery(this).attr('checked');
            var biayaid = jQuery(this).val();

            if (checked == 'checked') {
                //tampilkan input bayar
                //jQuery('#txbiaya_' + biayaid).removeAttr('hidden');
                jQuery('#txbiaya_' + biayaid).show();
                jQuery('#txpotongan_' + biayaid).show();

            } else {
                //hide
                jQuery('#txbiaya_' + biayaid).hide();
                jQuery('#txpotongan_' + biayaid).hide();
            }

            //kalkulasi total pembayaran
            calculateBayar();
        });

        /**
         * Kalkulasi total pembayaran
         */
        function calculateBayar() {
            var total = 0;
            jQuery('.ckbayar').each(function(data) {

                if (jQuery(this).attr('checked') == 'checked') {
                    var biayaId = jQuery(this).val();
                    var bayarPerBiaya = unformatRupiahVal(jQuery('#txbiaya_' + biayaId).val());
                    total += parseInt(bayarPerBiaya);
                }
            });
            //show to tabel total
            jQuery('#text-total-bayar').text(formatRupiahVal(total));
        }

        jQuery('.txbiaya').change(function() {
            //cek apakah yg diinputkan lebih besar dari ketentuan yg harus dibayar
            var biayaId = jQuery(this).attr('biayaid');
            var harusBayar = unformatRupiahVal(jQuery('#harusbayar_' + biayaId).text());
            var dibayar = unformatRupiahVal(jQuery(this).val());
            var potongan = unformatRupiahVal(jQuery('#txpotongan_' + biayaId).val());

            if (parseInt(dibayar) > (parseInt(harusBayar) - parseInt(potongan))) {
                alert('Nilai yang diinputkan lebih besar dari ketentuan bayar.');
                jQuery(this).val(formatRupiahVal((parseInt(harusBayar) - parseInt(potongan))));
                jQuery(this).focus();
            } else {
                calculateBayar();
            }

        });

        /**
         * Jumlah potongan change
         */
        jQuery('.txpotongan').change(function() {
            var biayaId = jQuery(this).attr('biayaid');
            var harusBayar = unformatRupiahVal(jQuery('#harusbayar_' + biayaId).text());
            var potongan = unformatRupiahVal(jQuery(this).val());
            //cek apakah jumlah potongan lebih besar dari harusbayar
            if (parseInt(potongan) > parseInt(harusBayar)) {
                alert('Nilai yang diinputkan lebih besar dari ketentuan bayar.');
                jQuery(this).val('');
                jQuery(this).focus();
            } else {
                //calculateBayar();
                //rubah text input bayar
                jQuery('#txbiaya_' + biayaId).val(formatRupiahVal(parseInt(harusBayar) - parseInt(potongan)));
            }
        });

        /**
         * simpan pelunasan pembayaran
         */
        jQuery('.btn-simpan-lunasi').click(function(data) {
            var simpanUrl = "{{ URL::to('transaksi/pelunasan/simpan') }}";
            dataReg = {
                "regnum": jQuery('input[name=regid]').val()
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

        })

    })
</script>
@stop

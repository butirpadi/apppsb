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

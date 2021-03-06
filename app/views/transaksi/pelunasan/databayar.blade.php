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
        <?php //$tgl = null; ?>
        <?php $reg_counter = null; ?>
        @foreach($calon->registrasi->pembayarans as $dt)
        <tr>
            <td>{{ $rownum++ }}</td>
            <td>
                <!-- Revisi 16-01-2018 -->
                <!-- if($dt->tgl == $tgl) -->
                @if($dt->reg_counter == $reg_counter)
                @else
                <a data-counter="{{$dt->reg_counter}}" class="btn btn-mini btn-cetak-nota" tgl="{{ date('d-m-Y',strtotime($dt->tgl)) }}" ><i class="icon-copy"></i></a>
                @endif
            </td>
            <td style="text-align: center;">
                <!-- if($dt->tgl == $tgl) -->
                @if($dt->reg_counter == $reg_counter)
                -"-
                @else
                {{ date('d-m-Y',strtotime($dt->tgl)) }}
                @endif
            </td>
            <td>{{ $dt->biaya->nama }}</td>
            <td style="text-align: right;">{{ number_format($dt->dibayar,0,',','.') }}</td>
            <td>
                <!-- if($dt->tgl == $tgl) -->
                @if($dt->reg_counter == $reg_counter)
                @else
                    <a class="btn btn-primary btn-mini"  href="transaksi/pelunasan/editbayar/{{$dt->id}}" >Edit</a>
                @endif

            </td>
        </tr>
        <?php //$tgl = $dt->tgl; ?>
        <?php $reg_counter = $dt->reg_counter; ?>
        @endforeach
    </tbody>
</table>


<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.btn-cetak-nota').click(function () {
            if (confirm('Anda akan mencetak Nota untuk data pembayaran ini?')) {
                var tgl = jQuery('.btn-cetak-nota').attr('tgl');
                var regnum = jQuery('input[name=regid]').val();
                // revisi 16-01-2018
                var counter = $(this).data('counter');
                var getnotaUrl = "{{ URL::to('transaksi/pelunasan/getnotapilihan') }}" + "/" + regnum + "/" + tgl+"/"+counter;
                // alert(getnotaUrl);
                // ----------------------
                // var getnotaUrl = "{{ URL::to('transaksi/pelunasan/getnotapilihan') }}" + "/" + regnum + "/" + tgl;
                // alert(getnotaUrl);
                //set applet
//                var appletTag = '<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }} " name="QZPrint" code="qz.PrintApplet.class" width="50" height="50"><param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}"><param name="cache_option" value="plugin"><param name="disable_logging" value="false"><param name="initial_focus" value="false"></applet>';
//                jQuery('#applet-tag').html(appletTag);
                //print nota
//                 jQuery.get(getnotaUrl, null, function (data) {
// //                    QZPrint.findPrinter("{{ $appset->printeraddr }}");
// //                    QZPrint.append(data);
// //                    QZPrint.print();

//                     alert('Cetak nota sedang diproses.');
//                     var printer = "{{ $appset->printeraddr }}";
//                     //Printing
//                     qz.findPrinter(printer);
//                     // Automatically gets called when "qz.findPrinter()" is finished.
//                     window['qzDoneFinding'] = function () {
//                         var p = document.getElementById('printer');
//                         var printer = qz.getPrinter();

//                         // Alert the printer name to user
//                         alert(printer !== null ? 'Printer found: "' + printer +
//                                 '" after searching for "' + p.value + '"' : 'Printer "' +
//                                 p.value + '" not found.');

//                         // Remove reference to this function
//                         window['qzDoneFinding'] = null;
//                     };
//                     qz.append(data);
//                     qz.append('\n');
//                     qz.print();
//                     //DONe Printing
//                 });

                    // Printing Using PHP Copy
                    // REVISI TGL : 18/05/2017
                    jQuery.get(getnotaUrl,null,function(data){
                        alert('Cetak nota sedang diproses.');
                    });

                //location.reload();   
            }
        })
    });
</script>

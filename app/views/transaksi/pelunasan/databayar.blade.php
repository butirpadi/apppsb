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
            <td></td>
        </tr>
        <?php $tgl = $dt->tgl; ?>
        @endforeach
    </tbody>
</table>


<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.btn-cetak-nota').click(function() {
            if (confirm('Anda akan mencetak Nota untuk data pembayaran ini?')) {
                var tgl = jQuery('.btn-cetak-nota').attr('tgl');
                var regnum = jQuery('input[name=regid]').val();
                var getnotaUrl = "{{ URL::to('transaksi/pelunasan/getnotapilihan') }}" + "/" + regnum + "/" + tgl;
                //set applet
                var appletTag = '<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }} " name="QZPrint" code="qz.PrintApplet.class" width="50" height="50"><param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}"><param name="cache_option" value="plugin"><param name="disable_logging" value="false"><param name="initial_focus" value="false"></applet>';
                jQuery('#applet-tag').html(appletTag);
                //print nota
                jQuery.get(getnotaUrl, null, function(data) {
                    QZPrint.findPrinter("{{ $appset->printeraddr }}");
                    QZPrint.append(data);
                    QZPrint.print();
                    alert('Cetak nota sedang diproses.');
                });

                //location.reload();   
            }
        })
    });
</script>

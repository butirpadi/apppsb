<table class="table table-bordered datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Calon Siswa</th>
            <th>Pembayaran</th>
            <th>Total</th>     
        </tr>
    </thead>
    <tbody>
        <?php $rownum=1; ?>
        <?php $totPendapatan=0; ?>
        
        @foreach($registrasi as $dt)
        <tr>
            <td style="vertical-align: top;">{{ $rownum++ }}</td>
            <td style="vertical-align: top;">{{ date('d-m-Y',strtotime($dt->tgl)) }}</td>
            <td style="vertical-align: top;">{{ $dt->calonsiswa->nama }}</td>
            <td>
                <?php $totDibayar=0; ?>
                <table class="table table-bordered">
                    <tbody>
                        @foreach($dt->pembayarans as $dtby)
                        <tr>
                            <td>{{ $dtby->biaya->nama }}</td>
                            <td style="text-align: right;">{{ number_format($dtby->dibayar,0,',','.') }}</td>
                        </tr>
                        <?php $totDibayar+=$dtby->dibayar; ?>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="text-align: right;vertical-align: bottom;">{{ number_format($totDibayar,0,',','.') }}</td>
        </tr>
        <?php $totPendapatan+=$totDibayar; ?>
        @endforeach
        <tr style="background-color: #CCC;color: #000100;font-weight: bolder;font-size: 1.5em;">
            <td colspan="4">TOTAL PENDAPATAN</td>
            <td style="text-align: right;">{{ number_format($totPendapatan,0,',','.') }}</td>
        </tr>
    </tbody>
</table>
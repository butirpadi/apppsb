<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Calon</th>
            <th>Pembayaran</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum=1; ?>
        <?php $total=0; ?>
        @foreach($pembayaran as $dt)
        <tr >
            <td style="vertical-align: top;">{{ $rownum++ }}</td>
            <td style="vertical-align: top;">{{ date('d-m-Y',strtotime($dt->tgl)) }}</td>
            <td style="vertical-align: top;">{{ $dt->registrasi->calonsiswa->nama }}</td>
            <td>
                <table class="table" >
                    <tbody>
                        <?php $totalbayar=0; ?>
                        @foreach($pembayarans as $dt2)
                            @if($dt2->tgl == $dt->tgl && $dt2->psbregistrasi_id == $dt->psbregistrasi_id)
                            <tr>
                                <td style="border: none; border-bottom: thin solid #dddddd;">{{ $dt2->biaya->nama }}</td>
                                <td style="border: none; border-bottom: thin solid #dddddd;">:</td>
                                <td class="uang" style="border: none;border-bottom: thin solid #dddddd;">{{ number_format($dt2->dibayar,0,',','.') }}</td>
                            </tr>
                            <?php $totalbayar+=$dt2->dibayar; ?>
                            <?php $total += $dt2->dibayar  ?>
                            @else
                            @endif
                            
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="vertical-align: bottom;" class="uang">{{ number_format($totalbayar,0,',','.') }}</td>
        </tr>
        @endforeach
        
        <tr style="background-color: whitesmoke;color: #2c2c2c;font-size: 1.5em;">
            <td colspan="4">T O T A L</td>    
            <td style="text-align: right;">{{ number_format($total,0,',','.') }}</td>    
        </tr>
    </tbody>
</table>
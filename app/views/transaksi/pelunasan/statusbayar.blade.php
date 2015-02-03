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
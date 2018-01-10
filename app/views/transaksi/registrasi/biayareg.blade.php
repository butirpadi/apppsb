<table class="table table-form">
    <tbody>
        @foreach($biayas as $dt)
        <tr>
            <td>{{ Form::checkbox('ckbiaya[]',$dt->id,false) }}</td>
            <td>{{ $dt->nama }}</td>
            <td>: Rp.</td>            
            @if($jk == 'L')
            <td style="text-align: right;"><span class="label label-warning harusbayar_{{$dt->id}}"> {{ number_format($dt->pivot->p_nilai,0,',','.') }}</label></td>
            @else
            <td style="text-align: right;"><label class="label label-warning harusbayar_{{$dt->id}}"> {{ number_format($dt->pivot->w_nilai,0,',','.') }}</label></td>
            @endif            
            <td>&nbsp;</td>
            <td class="dibayar dibayar_{{$dt->id}}">Dibayar</td>
            <td class="dibayar dibayar_{{$dt->id}}">:</td>
            <td class="dibayar dibayar_{{$dt->id}}"><?php echo Form::text('dibayar_'.$dt->id, ($jk == 'L' ? 'Rp. ' .number_format($dt->pivot->p_nilai, 0, ',', '.') : 'Rp. ' . number_format($dt->pivot->w_nilai, 0, ',', '.')), array('class' => 'uang input-medium text-dibayar', 'id' => $dt->id,'biayaid'=>$dt->id)) ?></td>
            <td class="dibayar potongan_{{$dt->id}}">Potongan</td>
            <td class="dibayar potongan_{{$dt->id}}">:</td>
            <td class="dibayar potongan_{{$dt->id}}"><?php echo Form::text('potongan_'.$dt->id, 0, array('class' => 'uang input-medium text-potongan', 'id' => 'potongan_'.$dt->id,'biayaid'=>$dt->id)) ?></td>
        </tr>
        @endforeach
        <tr style="background-color: #ffef49;color: orangered;">
            <td>TOTAL HARUS DIBAYAR</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>:</td>
            <td class="total-bayar" style="text-align: right;font-weight: bolder;" ></td>
        </tr>
    </tbody>
</table>
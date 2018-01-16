<style type="text/css">
    table select{
        margin:0;
    }
</style>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>Registrasi ID</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Rombel</th>
            <th class="td-actions" ></th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum = 1; ?>
        @foreach($calon as $dt)
        <tr>
            <td>{{ $rownum++ }}</td>
            <td>{{ $dt->regnum }}</td>
            <td>{{ $dt->nama }}</td>
            <td style="text-align: center;">
                @if($dt->jenis_kelamin == 'L')
                <span class="label label-info">Laki-laki</span>
                @else
                <span class="label label-warning">Perempuan</span>
                @endif
            </td>
            <td>
                @if($dt->rombeli_id != null || $dt->rombel_id != '')                
                {{ Form::select('rombel_' . $dt->id,$selectRombel,null,array('class'=>'input-large select-rombel sembunyi')) }}
                <span class="label label-success" id="rombelcalon_{{ $dt->id }}" >{{ $dt->rombel->nama }}</span>
                @else
                {{ Form::select('rombel_' . $dt->id,$selectRombel,null,array('class'=>'input-large select-rombel')) }}
                @endif
            </td>
            <td style="text-align: center;">
                @if($dt->rombeli_id != null || $dt->rombel_id != '')
                <a class="btn btn-warning btn-batal-distribusi btn-mini " id="btn-batal-{{$dt->id}}" siswaid="{{ $dt->siswa_id }}" calonid="{{ $dt->id }}" regnum="{{ $dt->regnum }}" >&nbsp;&nbsp;Batal&nbsp;&nbsp;</a>
                <a class="btn btn-success btn-simpan-distribusi btn-mini sembunyi" id="btn-simpan-{{$dt->id}}" calonid="{{ $dt->id }}" regnum="{{ $dt->regnum }}" >Simpan</a>
                @else
                <a class="btn btn-warning btn-batal-distribusi btn-mini sembunyi" id="btn-batal-{{$dt->id}}" siswaid="{{ $dt->siswa_id }}" calonid="{{ $dt->id }}" regnum="{{ $dt->regnum }}" >&nbsp;&nbsp;Batal&nbsp;&nbsp;</a>
                <a class="btn btn-success btn-simpan-distribusi btn-mini " id="btn-simpan-{{$dt->id}}" calonid="{{ $dt->id }}" regnum="{{ $dt->regnum }}" >Simpan</a>
                @endif
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="post-rest"></div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        // drawDatatable();
        //set ke 0 untuk rombel
        jQuery('.select-rombel').val([]);
        jQuery('.sembunyi').hide();
        
    });
</script>
<table class="table table-bordered table-condensed datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>Registrasi ID</th>
            <th>nama</th>
            <th>Status Diterima</th>
            <th>Diterima di</th>
            <th class="td-actions"></th>
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
                @if($dt->diterima =='Y')
                <span class="label label-success">DITERIMA</span>
                @elseif($dt->diterima =='N')
                <span class="label label-danger">TIDAK DITERIMA</span>
                @elseif($dt->diterima =='P')
                <span class="label label-warning">PENDING</span>
                @endif
            </td>
            <td style="text-align: center;">
                @if($dt->rombel == null)
                -
                @else
                {{ $dt->rombel->nama }}
                @endif
            </td>
            <td>
                <a href="{{ URL::route('master.calonsiswa.edit',$dt->id) }}" class="btn btn-mini btn-icon-only btn-success">Edit</a>

                {{ Form::open(array('route' => array('master.calonsiswa.destroy', $dt->id), 'method' => 'delete', 'data-confirm' => 'Anda yakin?','class'=>'form-destroy')) }}
                <button type="submit" href="{{ URL::route('master.calonsiswa.destroy', $dt->id) }}" class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function() {
        drawDatatable();
    });
</script>
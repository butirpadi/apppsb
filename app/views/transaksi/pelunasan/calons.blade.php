<table class="table table-bordered table-condensed datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>No. Reg</th>
            <th>Nama</th>
            <th class="td-actions"></th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum=1; ?>
        @foreach($calons as $dt)
        <tr>
            <td>{{ $rownum++ }}</td>
            <td>{{ $dt->regnum }}</td>
            <td>{{ ucwords(strtolower($dt->nama)) }}</td>
            <td><a class="btn btn-success btn-pilih btn-mini" data-dismiss="modal" calonid="{{ $dt->id }}" regnum="{{ $dt->regnum }}" namacalon="{{ $dt->nama }}" >Pilih</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){
        drawDatatable();
    });
</script>
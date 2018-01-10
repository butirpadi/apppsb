@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Gelombang PSB</h3>
            <div class="pull-right" style="padding-right: 10px;">
                <!--<a class="btn btn-primary" href="{{ URL::route('master.gelombang.create') }}" >Tambah</a>-->
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <table class="table table-striped table-bordered table-condensed datatable"  >
                <thead>
                    <tr>
                        <th> No</th>
                        <th> Tahun Pelajaran</th>
                        <th> Jumlah Gelombang PSB</th>
                        <th class="td-actions"> </th>
                    </tr>
                </thead>
                <tbody>

                    <?php $rownum = 1; ?>
                    @foreach($tapel as $dt)
                    <tr id="{{ 'row_' . $dt->id }}" >
                        <td class="nomer"> {{ $rownum++ }}</td>
                        <td> {{ $dt->nama }}</td>
                        <td> {{ ($dt->gelombang ? $dt->gelombang->jumlah : '-') }}</td>
                        <td class="td-actions">
                            <a href="{{ URL::route('master.gelombang.edit',$dt->id) }}" class="btn btn-mini btn-success">Edit</a>

                            <!--{{ Form::open(array('route' => array('master.gelombang.destroy', $dt->id), 'method' => 'delete', 'data-confirm' => 'Anda yakin?','class'=>'form-destroy')) }}-->
                            <!--<button type="submit" href="{{ URL::route('master.gelombang.destroy', $dt->id) }}" class="btn btn-danger btn-mini btn-delete">Delete</butfon>-->
                            <!--{{ Form::close() }}-->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function(){
        drawDatatable();
    });
</script>
@stop
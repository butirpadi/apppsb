@extends('_layouts.default')

@section('main')
<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Biaya</h3>
            <div class="pull-right" style="padding-right: 10px;">
                <a class="btn btn-primary" href="{{ URL::route('master.biaya.create') }}" >Tambah</a>
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <table class="table table-striped table-bordered table-condensed datatable"  >
                <thead>
                    <tr>
                        <th> No</th>
                        <th> Nama</th>
                        <th class="td-actions"> </th>
                    </tr>
                </thead>
                <tbody>

                    <?php $rownum = 1; ?>
                    @foreach($biaya as $dt)
                    <tr id="{{ 'row_' . $dt->id }}" >
                        <td class="nomer"> {{ $rownum++ }}</td>
                        <td> {{ $dt->nama }}</td>
                        <td class="td-actions">
                            <a href="{{ URL::route('master.biaya.edit',$dt->id) }}" class="btn btn-mini btn-success">Edit</a>

                            {{ Form::open(array('route' => array('master.biaya.destroy', $dt->id), 'method' => 'delete', 'data-confirm' => 'Anda yakin?','class'=>'form-destroy')) }}
                            <button type="submit" href="{{ URL::route('master.biaya.destroy', $dt->id) }}" class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                                {{ Form::close() }}
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
    jQuery(document).ready(function() {
        drawDatatable();

        @if(isset($errors) && $errors->first() != '')
            //tampilkan alert error
                var errstring = "{{$errors->first()}}";
                alert(errstring);
        @endif

    });
</script>
@stop
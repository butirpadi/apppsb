@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Pengaturan Biaya per Tahun Pelajaran</h3>
            <div class="pull-right" style="padding-right: 10px;">
                
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <table class="table table-striped table-bordered table-condensed datatable"  >
                <thead>
                    <tr>
                        <th> No</th>
                        <th> Tahun Pelajaran</th>
                        <th> Biaya</th>
                        <th class="td-actions"> </th>
                    </tr>
                </thead>
                <tbody>

                    <?php $rownum = 1; ?>
                    @foreach($tapel as $dt)
                    <tr id="{{ 'row_' . $dt->id }}" >
                        <td class="nomer"> {{ $rownum++ }}</td>
                        <td> {{ $dt->nama }}</td>
                        <td> 
                            @foreach($dt->biayas as $dt1)
                            {{ $dt1->nama . ', ' }}
                            @endforeach
                        </td>
                        <td class="td-actions">
                            <a href="{{ URL::route('master.setbiaya.edit',$dt->id) }}" class="btn btn-mini btn-success">Edit</a>
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
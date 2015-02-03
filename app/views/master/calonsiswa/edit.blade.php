@extends('_layouts.default')

@section('main')

<div class="span6">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Edit Data Calon Siswa</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            {{ Form::model($calon, array('method' => 'put', 'route' => array('master.calonsiswa.update', $calon->id),'class'=>'form-horizontal')) }}
            <fieldset>
                <div class="control-group">											
                    <label class="control-label" >Tanggal Registrasi</label>
                    <div class="controls">
                        {{ Form::text('tapel',date('d-m-Y',strtotime($calon->registrasi->tgl)),array('class'=>'input-medium','readonly','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" >Tahun Pelajaran</label>
                    <div class="controls">
                        {{ Form::text('tapel',$calon->tapelmasuk->nama,array('class'=>'input-medium','readonly','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" >Gelombang</label>
                    <div class="controls">
                        {{ Form::select('gelombang',$selGelombang,$calon->gelombang,array('class'=>'input-medium')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" >Nomor Registrasi</label>
                    <div class="controls">
                        {{ Form::text('regnum',null,array('class'=>'input-medium','required','readonly','autocomplete'=>'off','style'=>'font-size:2em;width:200px;height:50px;text-align:center;')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" >Nama</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" >Jenis Kelamin</label>
                    <div class="controls">
                        {{ Form::text('jk',($calon->jk == 'L' ? 'Laki-laki' : 'Perempuan'),array('class'=>'input-small','readonly','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="control-group">											
                    <label class="control-label" >Status Diterima</label>
                    <div class="controls">
                        <table class="table table-form">
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo Form::radio('status', 'P', ($calon->diterima == 'P' ? true : false)); ?>
                                    </td>
                                    <td>Pending</td>

                                </tr>
                                <tr>
                                    <td>
                                        <?php echo Form::radio('status', 'Y', ($calon->diterima == 'Y' ? true : false)); ?>
                                    </td>
                                    <td>Diterima</td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo Form::radio('status', 'N', ($calon->diterima == 'N' ? true : false)); ?>
                                    </td>
                                    <td>Tidak Diterima</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="form-actions">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                    <a class="btn" href="{{ URL::route('master.calonsiswa.index') }}" >Cancel</a>
                </div> <!-- /form-actions -->
            </fieldset>
            {{ Form::close() }}
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<div class="span6">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Status Pembayaran</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
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
                    @foreach($biayas as $dt)
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
                            @foreach($pembayaran as $dt1)
                            @if($dt1->psbbiaya_id == $dt->id)
                            <?php $pot = $dt1->potongan; ?>
                            @endif
                            @endforeach
                            {{ number_format($pot,0,',','.') }}
                        </td>
                        <td style="text-align: right;">
                            <?php $dibayar = 0; ?>
                            @foreach($pembayaran as $dt1)
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
                            @endif
                        </td>
                        <td></td>
                    </tr>                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="span6">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Histori Pembayaran</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content" id="data-histori">
            
        </div>
    </div>
</div>

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function(){
        //tampilkan data histori pembaaran
        
        function showHistori(){
            var regnum = jQuery('input[name=regnum]').val();
            var historiUrl = "{{ URL::to('master/calonsiswa/gethistoripembayaran') }}" +"/"+ regnum;
            jQuery('#data-histori').html('<div id="loader"></div>').load(historiUrl);
        }
        showHistori();
    })
</script>
@stop
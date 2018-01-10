@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Edit Biaya</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            {{ Form::model($biaya, array('method' => 'put', 'route' => array('master.biaya.update', $biaya->id),'class'=>'form-horizontal')) }}
                <fieldset>

                    <div class="control-group">											
                        <label class="control-label" for="thn_awal">Nama</label>
                        <div class="controls">
                            <!--<input type="text" class="input-medium" name="thn_awal" autocomplete="off" autofocus required >-->
                            {{ Form::text('nama',null,array('class'=>'input-xlarge','autocomplete'=>'off','autofocus','required')) }}
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    
                    <div class="form-actions"> 
                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        <a class="btn" href="{{ URL::route('master.biaya.index') }}" >Cancel</a>
                    </div> <!-- /form-actions -->
                </fieldset>
            {{ Form::close() }}
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop
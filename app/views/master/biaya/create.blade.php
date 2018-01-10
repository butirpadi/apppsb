@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Tambah Biaya</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <?php echo Form::open(array('route' => 'master.biaya.store', 'class' => 'form-horizontal')) ?>
            <fieldset>

                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Nama</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xlarge','autofocus','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->

                <div class="form-actions">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary btn-save')) }}
                    <a class="btn" href="{{ URL::route('master.biaya.index') }}" >Cancel</a>
                </div> <!-- /form-actions -->
            </fieldset>
            <?php echo Form::close(); ?>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function(){
        //cek kosong
        jQuery('.btn-save').click(function(e){
            var nama = jQuery('input[name=nama]').val();
            if(nama == '' || nama == null){
                alert('Lengkapi data yang kosong.');
                e.preventDefault();
                //set focus
                jQuery('input[name=nama]').focus();
            }
        })
    });
</script>
@stop
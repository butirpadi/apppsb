@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Registrasi</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <?php echo Form::open(array('route' => 'master.biaya.store', 'class' => 'form-horizontal')) ?>
            <fieldset>
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal" style="text-decoration: underline!important;">DATA CALON SISWA</label>
                    <div class="controls"></div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">No Registrasi</label>
                    <div class="controls">
                        {{ Form::text('nama','0142014',array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Nama</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','autofocus','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Tempat, Tanggal Lahir</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-medium','autocomplete'=>'off')) }}
                        {{ Form::text('nama',null,array('class'=>'input-medium datepicker','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Jenis Kelamin</label>
                    <div class="controls">
                        <?php echo Form::select('jk', array('0'=>'Laki-laki','1'=>'Perempuan'),null,array('class'=>'input-medium')) ?>
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Asal Sekolah</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal" style="text-decoration: underline!important;">DATA ORANG TUA/WALI</label>
                    <div class="controls"></div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">AYAH</label>
                    <div class="controls"></div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Nama Ayah</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat Ayah</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Telpon Ayah</label>
                    <div class="controls">
                        1. {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal"></label>
                    <div class="controls">
                        2. {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Pekerjaan Ayah</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-large','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat Kerja Ayah</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Telpon Kerja Ayah</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">IBU</label>
                    <div class="controls"></div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Nama Ibu</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat Ibu</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Telpon Ibu</label>
                    <div class="controls">
                        1. {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal"></label>
                    <div class="controls">
                        2. {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Pekerjaan Ibu</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-large','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat Kerja Ibu</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Telpon Kerja Ibu</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">WALI</label>
                    <div class="controls"></div> <!-- /controls -->				
                </div> <!-- /control-group -->
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Nama Wali</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat Wali</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Telpon Wali</label>
                    <div class="controls">
                        1. {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal"></label>
                    <div class="controls">
                        2. {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Pekerjaan Wali</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-large','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Alamat Kerja Wali</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="control-group">											
                    <label class="control-label" for="thn_awal">Telpon Kerja Wali</label>
                    <div class="controls">
                        {{ Form::text('nama',null,array('class'=>'input-medium','required','autocomplete'=>'off')) }}
                    </div> <!-- /controls -->				
                </div> <!-- /control-group -->
                
                <div class="form-actions">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                    <a class="btn" href="{{ URL::route('master.biaya.index') }}" >Cancel</a>
                </div> <!-- /form-actions -->
            </fieldset>
            <?php echo Form::close(); ?>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop
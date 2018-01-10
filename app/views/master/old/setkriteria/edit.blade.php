@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-pencil"></i>
            <h3>Edit Pengaturan Biaya</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            {{ Form::model($tapel, array('method' => 'put', 'route' => array('master.tapel.update', $tapel->id),'class'=>'form-horizontal')) }}
                <fieldset>

                    <div class="control-group">											
                        <label class="control-label" >Tahun Pelajaran</label>
                        <div class="controls">
                            {{ Form::text('nama',null,array('class'=>'input-xlarge','autocomplete'=>'off','required','readonly')) }}
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    
                    <div class="control-group">											
                        <label class="control-label" >Biaya</label>
                        <div class="controls">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>{{ Form::checkbox('biaya[]', null, false); }} Biaya Pendaftaran</td>
                                        <td>{{ Form::text('pendaftaran',null,array('class'=>'input-small uang','id'=>'pendaftaran')) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Form::checkbox('biaya[]', null, false); }} Seragam Sekolah</td>
                                        <td>{{ Form::text('seragam',null,array('class'=>'input-small uang','id'=>'seragam')) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Form::checkbox('biaya[]', null, false); }} Seragam Olah Raga</td>
                                        <td>{{ Form::text('or',null,array('class'=>'input-small uang','id'=>'or')) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Form::checkbox('biaya[]', null, false); }} Atribut</td>
                                        <td>{{ Form::text('attribut',null,array('class'=>'input-small uang','id'=>'attribut')) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Form::checkbox('biaya[]', null, false); }} Partisipasi </td>
                                        <td>{{ Form::text('partisipasi',null,array('class'=>'input-small uang','id'=>'partisipasi')) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    
                    <div class="form-actions"> 
                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        <a class="btn" href="{{ URL::route('master.setbiaya.index') }}" >Cancel</a>
                    </div> <!-- /form-actions -->
                </fieldset>
            {{ Form::close() }}
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop
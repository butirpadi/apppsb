@extends('_layouts.default')

@section('main')
<div class="span12">      

    <!--widget form input-->
    <div class="widget " id="formInputPengeluaran">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Input Data Pengeluaran</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content" id="reg-content"> 
            <style>
                .table input{
                    margin: 0;
                }


            </style>
            <form action="pengeluaran/addnew" method="POST" >
                <table  class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td class="span2" >Tanggal</td>
                            <td>
                                <input type="text" value="{{date('d-m-Y')}}" name="tgl" class="input-small datepicker" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>
                                <input type="text" name="keterangan" class="input-block-level" maxlength="50" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>
                                <input type="text" name="jumlah" id="txJumlah" class="input-medium uang" required />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" id="btnReset" class="btn btn-warning">Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

    <!--widget data table-->
    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Data Pengeluaran</h3>
            <div class="pull-right" style="padding-right: 10px;">
                <a id="btnTambahPengeluaran" class="btn btn-primary">Input Data Pengeluaran</a>
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content" id="reg-content"> 
            <style>
                .table input{
                    margin: 0;
                }

                .datatable thead tr {
                    background: whitesmoke;
                }
            </style>
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $dt)
                    <tr>
                        <td></td>
                        <td>
                            {{date('d-m-Y',strtotime($dt->tgl))}}
                        </td>
                        <td>
                            {{$dt->keterangan}}
                        </td>
                        <td class="uang">
                            {{number_format($dt->jumlah,0,',','.')}}
                        </td>
                        <td>
                            <a class="btn btn-success btn-mini" href="pengeluaran/edit/{{$dt->id}}" > Edit</a>
                            <a class="btn btn-danger btn-mini btnDelete" href="pengeluaran/delete/{{$dt->id}}" > Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

<br />

@stop

@section('custom-script')

<script type="text/javascript">
    jQuery(document).ready(function () {
        //sembunyikan forminput saat pertama kali load
        $('#formInputPengeluaran').hide();
        //tampilkan form input
        $('#btnTambahPengeluaran').click(function () {
            $('#formInputPengeluaran').slideDown(250,function(){
                $('#btnTambahPengeluaran').hide();
            });
        });
        //sembunyikan form input
        $('#btnReset').click(function(){
             $('#formInputPengeluaran').slideUp(250,function(){
                $('#btnTambahPengeluaran').show();
            });
        });
        //
        //
        //format datatable
        $('.datatable').dataTable({
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                // Bold the grade for all 'A' grade browsers
                var index = iDisplayIndexFull + 1;
                $('td:eq(0)', nRow).html(index);
                return nRow;
            }
        });
        //Hapus data pengeluaran
        $('.btnDelete').click(function(e){
           if(confirm('Hapus data ini?')) {
               
           }else{
               return false;
           }
        });
    });
</script>
@stop

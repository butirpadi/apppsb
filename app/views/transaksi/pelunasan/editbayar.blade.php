@extends('_layouts.default')

@section('main')
<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Edit Data Pembayaran</h3>
            <div class="pull-right" style="padding-right: 10px;">

            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">  
            <div class="pull-right" >
                <form action="transaksi/pelunasan/batalkantransaksi" method="POST">
                    <input type="hidden" name="psb_pembayaran_id" value="{{$bayar->id}}"/>
                    <button type="submit" class="btn btn-danger" id="btnBatalPembayaran"><i class="icon icon-trash" ></i>  Batalkan Transaksi ini</button>
                </form>
                
            </div>
            <h4>Data Siswa</h4>
            <br/>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="span2">
                            Nama
                        </td>
                        <td>
                            <input readonly type="text" name="nama" value="{{$calon->nama}}" />
                        </td>
                        <td class="span2">
                            Tanggal
                        </td>
                        <td>
                            <input readonly type="text" name="nama" value="{{$bayar->tgl}}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="span2">
                            No. Reg
                        </td>
                        <td>
                            <input readonly type="text" name="nama" value="{{$calon->regnum}}" />
                        </td>
                        <td class="span2">
                            Total
                        </td>
                        <td>
                            <input readonly type="text" name="total" class="uang" value="{{number_format($total,0,',','.')}}" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="clearfix" ></div>
            <h4>Data Pembayaran</h4>
            <br/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Biaya</th>
                        <th>Jumlah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rownum = 1; ?>
                    @foreach($databayar as $db)
                    <tr>
                        <td class="span1">{{$rownum++}}</td>
                        <td>{{$db->biaya}}</td>
                        <td class="uang">
                            <input type="text" class="uang txjumlah" value="{{number_format($db->dibayar,0,',','.')}}" /> 
                        </td>
                        <td class="span1">
                            @if(count($databayar)>1)
                            <form name="formDelItem" id="{{$db->id}}" action="transaksi/pelunasan/deleteitembayar" method="POST" >
                                <input type="hidden" name="psb_pembayaran_id" value="{{$db->id}}" />
                                <button type="submit" class="btn btnDelItemPembayaran btn-mini btn-danger" >Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pull-right">
                <a class="btn btn-primary">Simpan</a>
                <a class="btn btn-warning" id="btnTutup" >Tutup Edit</a>
            </div>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->
<div id="post-rest"></div>

@stop

@section('custom-script')
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#btnTutup').click(function () {
            window.close();
        });

        //batalkan transaksi pembayaran
        $('#btnBatalPembayaran').click(function () {
            var form = $(this).parent('form');
            if (confirm('Batalkan transaksi pembayaran ini?')) {
                form.submit();
            } else {
                alert('Pembatalan transaksi ditolak.');
            }
        });
        
        $('.btnDelItemPembayaran').click(function(e){
            var form = $(this).parent('form');
            e.preventDefault();
            if(confirm('Hapus data ini?')){
                form.submit();
            }else{
                
            }
        });
    });
</script>
@stop

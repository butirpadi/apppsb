@extends('_layouts.default')

@section('main')

<div class="span12">      		

    <div class="widget ">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Kriteria Penilaian Tes PSB</h3>
            <div class="pull-right" style="padding-right: 10px;">
                <a class="btn btn-primary" href="{{ URL::route('master.biaya.create') }}" >Tambah</a>
            </div>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <table class="table table-striped table-bordered table-condensed"  >
                <thead>
                    <tr>
                        <th> No</th>
                        <th> Nama</th>
                        <th class="td-actions"> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr  >
                        <td class="nomer"> 1</td>
                        <td>Komunikasi & Keterampilan</td>
                        <td class="td-actions">
                            <a href="#" class="btn btn-mini btn-success">Edit</a>
                            <button type="submit"  class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                        </td>
                    </tr>
                    <tr  >
                        <td class="nomer"> 2</td>
                        <td>Kecerdasan Umum</td>
                        <td class="td-actions">
                            <a href="#" class="btn btn-mini btn-success">Edit</a>
                            <button type="submit"  class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                        </td>
                    </tr>
                    <tr  >
                        <td class="nomer"> 3</td>
                        <td>Perkembangan Motorik Kasar</td>
                        <td class="td-actions">
                            <a href="#" class="btn btn-mini btn-success">Edit</a>
                            <button type="submit"  class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                        </td>
                    </tr>
                    <tr  >
                        <td class="nomer"> 4</td>
                        <td>Perkembangan Motorik Halus</td>
                        <td class="td-actions">
                            <a href="#" class="btn btn-mini btn-success">Edit</a>
                            <button type="submit"  class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                        </td>
                    </tr>
                    <tr  >
                        <td class="nomer"> 5</td>
                        <td>Kematangan Emosi</td>
                        <td class="td-actions">
                            <a href="#" class="btn btn-mini btn-success">Edit</a>
                            <button type="submit"  class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                        </td>
                    </tr>
                    <tr  >
                        <td class="nomer"> 6</td>
                        <td>Kemandirian</td>
                        <td class="td-actions">
                            <a href="#" class="btn btn-mini btn-success">Edit</a>
                            <button type="submit"  class="btn btn-danger btn-mini btn-delete">Delete</butfon>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- /widget-content -->

    </div> <!-- /widget -->

</div> <!-- /span8 -->

@stop
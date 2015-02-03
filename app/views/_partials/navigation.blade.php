<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"> 
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
            </a>
            <a class="brand" href="index.html">.: ePSB - Sistem Administrasi Penerimaan Siswa Baru :. SDI Sabilil Huda </a>
            <div class="nav-collapse">

            </div>
            <!--/.nav-collapse --> 
        </div>
        <!-- /container --> 
    </div>
    <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="{{ Request::is('home*') ? 'active' : '' }}" ><a href="{{ URL::route('home.index') }}"><i class="icon-home"></i><span>HOME</span> </a> </li>
                <li class="{{ Request::is('master*') ? 'active dropdown' : 'dropdown' }}" ><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-folder-open"></i><span>MASTER</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::route('master.gelombang.index') }}">Gelombang PSB</a></li>
                        <li><a href="{{ URL::route('master.biaya.index') }}">Biaya</a></li>
                        <li><a href="{{ URL::route('master.setbiaya.index') }}">Pengaturan Biaya</a></li>
                        <li><a href="{{ URL::route('master.calonsiswa.index') }}">Calon Siswa</a></li>
                    </ul>
                </li>
                <li class="{{ Request::is('transaksi*') ? 'active dropdown' : 'dropdown' }}" ><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-download-alt"></i><span>REGISTRASI</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::route('transaksi.registrasi.index') }}">Registrasi</a></li>
                        <li><a href="{{ URL::route('transaksi.pelunasan.index') }}">Pelunasan</a></li>
                        <li><a href="{{ URL::route('transaksi.distribusi.index') }}">Distribusi Siswa</a></li>
                    </ul>
                </li>
                <li class="{{ Request::is('rekap*') ? 'active' : '' }}"><a href="{{ URL::route('rekap.rekap.index') }}"><i class="icon-list-alt"></i><span>REKAP</span> </a> </li>
                <li ><a class="btn-logout" href="{{ URL::to('login/logout') }}"><i class="icon-off" style="color: #DB613B;"></i><span style="color: #DB613B;">KELUAR</span> </a> </li>
                <li><a href="charts.html"><span></span> </a> </li>
            </ul>
        </div>
        <!-- /container --> 
    </div>
    <!-- /subnavbar-inner --> 
</div>
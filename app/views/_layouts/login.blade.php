<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo URL::to('/'); ?>/">
        <meta charset="utf-8">
        <title>ePSB - SDI Sabilil Huda</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        @include('_partials.assets')
        <style type="text/css">
            /*set vertical align to middle untuk header table data*/
            table.table thead tr th{
                vertical-align: middle !important;
            }
        </style>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">

            <div class="navbar-inner">

                <div class="container">

                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="index.html">
                        .: ePSB - Sistem Administrasi Penerimaan Siswa Baru :. SDI Sabilil Huda 				
                    </a>		

                    <div class="nav-collapse">
                        

                    </div><!--/.nav-collapse -->	

                </div> <!-- /container -->

            </div> <!-- /navbar-inner -->

        </div> <!-- /navbar -->

        @yield('main')  

        <!-- Le javascript
        ================================================== --> 
        @include('_partials.scripts')

        @yield('custom-script')
    </body>
</html>

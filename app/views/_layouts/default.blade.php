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
        @include('_partials.navigation')
        <!-- /subnavbar -->
        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        @yield('main')            
                    </div>
                    <!-- /row --> 
                </div>
                <!-- /container --> 
            </div>
            <!-- /main-inner --> 
        </div>
        <!-- /main -->
        
        <!-- Le javascript
        ================================================== --> 
        @include('_partials.scripts')
        
        @yield('custom-script')
    </body>
</html>

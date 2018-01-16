<!--APplet JZEBRA untuk direct printing-->
<applet id="qz" archive="{{ URL::to('jar/qz-print.jar') }}" name="QZPrint" code="qz.PrintApplet.class" width="50" height="50">
    <param name="jnlp_href" value="{{ URL::to('jar/qz-print_jnlp.jnlp') }}">
    <param name="cache_option" value="plugin">
    <param name="disable_logging" value="false">
    <param name="initial_focus" value="false">
</applet><br />
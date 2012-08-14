<?php
/*
Plugin Name: METAR plugin
Plugin URI: http://wordpress.org/extend/plugins/metar-widget/
Description: Plugin to include the latest METAR information from NOAA database for any Airport
Version: 0.1
Author: Luther Blissett
Author URI: http://lutherblissett.net
License: GPL3
*/

require_once "MetarWidget.php";

add_action("widgets_init",
    function () { register_widget("MetarWidget"); });

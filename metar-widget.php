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

class MetarWidget extends WP_Widget
{
    public function __construct() {
        parent::__construct("metar_widget", "METAR Widget",
            array("description" => "Plugin to inlclude the latest METAR information from NOAA database for any Airport"));
    }

    public function form($instance) {
        $icao = "";
        // if instance is defined, populate the fields
        if (!empty($instance)) {
            $icao = $instance["icao"];
        }

        $tableId = $this->get_field_id("icao");
        $tableName = $this->get_field_name("icao");
        echo '<label for="' . $tableId . '">ICAO</label><br/>';
        echo '<input id="' . $tableId . '" type="text" name="' .
            $tableName . '" value="' . $icao . '"/><br/>';
    }

    public function update($newInstance, $oldInstance) {
        $values = array();
        $values["icao"] = htmlentities($newInstance["icao"]);
        return $values;
    }

    public function widget($args, $instance) {
        $icao = $instance["icao"];

        $fileName = "http://weather.noaa.gov/pub/data/observations/metar/stations/$icao.TXT";
        $metar = '';
        $fileData = @file($fileName) or die('METAR not available');
        if ($fileData != false) {
        	list($i, $date) = each($fileData);
        	$utc = strtotime(trim($date));
        	$time = date("D, F jS Y g:i A",$utc);

        	while (list($i, $line) = each($fileData)) {
        		$metar .= ' ' . trim($line);
            	}
        	$metar = trim(str_replace('  ', ' ', $metar));
        }

	echo '<div class="widget widget-wrapper" id="' . $args['widget_id'] . '-container">';
	echo '<div class="widget-title"><b>Current METAR for ' . $icao . '</b></div>';
	echo $metar . '</div>';
    }
}

add_action("widgets_init", register_metarwidget);
function register_metarwidget() { register_widget("metarwidget"); }

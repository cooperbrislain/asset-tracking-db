<?php
function checkin($assets) {
    global $mqtt_client;
    log_event($assets, 'checked in');
    mqtt_notify( 'leds/test/checkin', $assets[0]->descriptor->spec_id);
    echo $assets[0]->get_json();
}

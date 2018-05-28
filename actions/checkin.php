<?php
function checkin($assets) {
    global $mqtt_client;
    log_event($assets, 'checked in');
    mqtt_notify( 'leds/test/checkin', $asset[0]->descriptor->spec_id);
    echo $asset->get_json();
}

<?php
function checkin($assets) {
    global $mqtt_client;
    log_event($assets, 'checked in');
    mqtt_notify($mqtt_client, 'leds/test/checkin', $asset[0]->descriptor->spec_id);
}

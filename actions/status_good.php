<?php
function status_good($assets) {
    foreach ($assets as $asset) {
        $asset->status = 1;
        $asset->save();
    }
    mqtt_notify('leds/asset/status', 1);
    log_event($assets, 'marked good');
}
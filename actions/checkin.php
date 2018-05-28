<?php
function checkin($db, $ids) {
    global $mqtt_client;
    $id = $ids[0];
    $asset = new Asset($id);
    log_event($db, $id, 'checked in');
    mqtt_notify($mqtt_client, $asset->get_json());
}

<?php
function checkin($db, $ids) {
    global $mqtt_client;
    $id = $ids[0];
    $asset = new Asset($db, $id);
    log_event($db, array($id), 'checked in');
    mqtt_notify($mqtt_client, $asset->get_json());
}

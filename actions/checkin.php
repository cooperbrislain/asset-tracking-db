<?php
function checkin($db, $ids) {
    global $mqtt_client;
    log_event($db, $ids, 'checked in');
    mqtt_notify($mqtt_client, $ids);
}

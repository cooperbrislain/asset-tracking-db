<?php
function checkin($db, $ids) {
    log_event($db, $ids, 'checked in');
    mqtt_notify($db, 4$ids);
}

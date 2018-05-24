<?php
function checkin($db, $ids) {
    log_event($db, $ids, 'checked in');
}

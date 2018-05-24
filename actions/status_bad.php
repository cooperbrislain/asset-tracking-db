<?php
function status_bad($db, $ids) {
    $query = "UPDATE asset SET status = -1 WHERE id = IN ( " . implode(',',$ids) . " )";
    log_event($db, $ids, 'marked bad');
}

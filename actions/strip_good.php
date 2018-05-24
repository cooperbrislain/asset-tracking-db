<?php
function strip_good($db, $ids) {
    log_event($db, $ids, 'LED strip passed');
    test_result($db, $ids, 'strip', 1);
}

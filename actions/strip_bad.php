<?php
function strip_bad($db, $ids) {
    log_event($db, $ids, 'LED strip failed');
    test_result($db, $ids, 'strip', -1);
}

<?php
function output_good($db, $ids) {
    log_event($db, $ids, 'Output passed');
    test_result($db, $ids, 'output', 1);
}

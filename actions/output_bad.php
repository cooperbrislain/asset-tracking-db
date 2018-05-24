<?php
function output_bad($db, $ids) {
    log_event($db, $ids, 'Output failed');
    test_result($db, $ids, 'output', -1);

}
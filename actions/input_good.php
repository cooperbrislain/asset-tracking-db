<?php
function input_good($db, $ids) {
    log_event($db, $ids, 'Input passed');
    test_result($db, $ids, 'input', 1);
}
<?php
function input_bad($db, $ids) {
    log_event($db, $ids, 'Input failed');
    test_result($db, $ids, 'input', -1);
}

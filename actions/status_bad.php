<?php
function status_bad($assets) {
    foreach ($assets as $asset) {
        $asset->status = -1;
    }
    log_event($assets, 'marked bad');
}

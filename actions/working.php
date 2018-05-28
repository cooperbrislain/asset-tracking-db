<?php
function working($assets) {
    foreach ($asset as $asset) {
        $asset->status = 1;
    }
    log_event($assets, 'marked working');
}
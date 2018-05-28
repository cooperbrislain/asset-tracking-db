<?php
function working($assets) {
    foreach ($asset as $asset) {
        $asset->status = 1;
        $asset->save();
    }
    log_event($assets, 'marked working');
}
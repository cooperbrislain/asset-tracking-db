<?php
function broken($assets) {
    foreach ($assets as $asset) {
        $asset->status = -1;
        $asset->save();
    }
    log_event($assets, 'marked broken');
}

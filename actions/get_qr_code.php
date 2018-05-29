<?php

    include('../lib/full/qrlib.php');

    function get_qr_code($assets) {
        foreach ($assets as $asset) {
            QRcode::png($asset->serial);
        }
    }
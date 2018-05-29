<?php

    include('../qrcode/qrlib.php');

    function get_qr_code($assets) {
        foreach ($assets as $asset) {
            QRcode::png($asset->serial);
        }
    }
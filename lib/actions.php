<?php
$dp = @opendir('actions');
while ($filename = @readdir($dp)) {
    if (preg_match('/^\./', $filename)) {
        continue;
    }
    if (preg_match('/\.php$/', $filename)) {
        include_once('actions/' . $filename);
    }
}
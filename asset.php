<?php
header('Content-Type: application/json');

require_once('mysqli.php');
require_once('class/class_asset.php');
require_once('lib/functions.php');
require_once('lib/actions.php');

$serial = $_REQUEST['serial'];
error_log($serial);
$id = find_or_create($mysqli, $serial);
error_log($id);
$asset = new Asset($mysqli, $id);

echo $asset->get_json();

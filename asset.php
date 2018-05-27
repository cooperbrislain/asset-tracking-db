<?php
header('Content-Type: application/json');

require_once('mysqli.php');
require_once('class/class_asset.php');
require_once('lib/functions.php');
require_once('lib/actions.php');

$serial = $_REQUEST['serial'];

$id = find_or_create($mysqli, $serial);

$asset = new Asset($mysqli, $id);

echo $asset->get_json();

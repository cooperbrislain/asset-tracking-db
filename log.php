<?php
header('Content-Type: application/json');

require_once('.secret/mysqli.php');
require_once('.secret/mqtt.php');
require_once('lib/mqtt.php');
require_once('class/class_asset.php');
require_once('lib/functions.php');
require_once('lib/actions.php');

$json_ob = json_decode($_REQUEST['json']);

$ids = array();

if(is_array($json_ob->ids)) {
    if(!$json_ob->action) {

    } else {
        foreach($json_ob->ids as $serial) {
            if($id = find_or_create($mysqli, $serial)) {
                $ids[] = $id;
            }
        }
        $action = strtolower(str_replace('.','_',$json_ob->action));
        if(preg_match('/^process_(\w+)$/', $action, $matches) ) {

        } else if (file_exists(__DIR__ . '/actions/' . strtolower($json_ob->action) . '.php')) {
           $action($mysqli, $ids);
        }
    }
} else {
}

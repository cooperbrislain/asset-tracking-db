<?php

    require_once('mysqli.php');
    require_once('actions.php');

    error_log($_REQUEST['json']);

 /*   $clientActions = array(
        "CheckIn",

        "Working",
        "Broken",

        "Status.Good",
        "Status.Bad",
        "Strip.Good",
        "Strip.Bad",
        "Input.Good",
        "Input.Bad",
        "Output.Good",
        "Output.Bad",
/*
        "Process.Begin",
        "Process.BeamAssembled",
        "Process.PowerWiresRun",
        "Process.ConnectionsSoldered",
        "Process.LEDs",
        "Process.EndCaps",
        "Process.PowerPlugs",
        "Process.Complete"
        */
    );*/

    $json_ob = json_decode($_REQUEST['json']);

    $ids = array();

    if(is_array($json_ob->ids)) {
        if(!$json_ob->action) {

        } else {
            foreach($json_ob->ids as $serial) {
                error_log('looking up ' . $serial);
                if($id = find_or_create($mysqli, $serial)) {
                    error_log('found ' . $id);
                    $ids[] = $id;
                }
            }
            $action = strtolower(str_replace('.','_',$json_ob->action));
            if(preg_match('/^process_(\w+)$/', $action, $matches) ) {

            } else if (file_exists(__DIR__ . '/actions/' . lower_case($json_ob->action) . '.php')) {
                $action($mysqli, $json_ob->ids);
            }
        }
    } else {
        error_log('not array');
    }

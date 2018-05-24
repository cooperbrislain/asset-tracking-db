<?php

    require_once('mysqli.php');
    require_once('actions.php');

    error_log($_REQUEST['json']);

    $clientActions = array(
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

        "Process.Begin",
        "Process.BeamAssembled",
        "Process.PowerWiresRun",
        "Process.ConnectionsSoldered",
        "Process.LEDs",
        "Process.EndCaps",
        "Process.PowerPlugs",
        "Process.Complete"
    );

    $json_ob = json_decode($_REQUEST['json']);

    $ids = array();

    if(is_array($json_ob->ids)) {
        if(!$json_ob->action) {

        } else {
            if(in_array($json_ob->action, $clientActions)) {
                $call = strtolower(str_replace('.','_',$json_ob->action));
                foreach($json_ob->ids as $serial) {
                    error_log('looking up ' . $serial);
                    if($id = find_or_create($mysqli, $serial)) {
                        error_log('found ' . $id);
                        $ids[] = $id;
                    }
                }
                error_log('calling [' . $call . '] with ids (' . implode(',', $ids) . ')');
                $call($mysqli,$ids);
            }
        }
    } else {
        error_log('not array');
    }

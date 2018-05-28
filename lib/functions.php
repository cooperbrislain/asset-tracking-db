<?php

function get_test_status($asset, $test_id) {
    global $mysqli;
    $query = "SELECT result FROM test_result_link " .
        "INNER JOIN test ON fk_test_id = test.id " .
        "WHERE fk_test_id = $test_id " .
        "AND fk_asset_id = $asset->id " .
        "ORDER BY timestamp DESC " .
        "LIMIT 1";
    if ($result = $mysqli->query($query)) {
        if ($row = $result->fetch_assoc()) {
            return $row['result'];
        }
    }
    return 0;
}

function find_or_create($serial) {
    global $mysqli;
    $query = "SELECT * FROM asset WHERE serial = '$serial'";
    if ($result = $mysqli->query($query)) {
        if($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $asset = new Asset($mysqli, $id);
            return $asset;
        } else {
            preg_match('/^([A-Za-z0-9]+)/', $serial, $matches);
            $model_string = $matches[1];
            $query = "SELECT * FROM asset_descriptor WHERE model = '$model_string'";
            $result = $mysqli->query($query);
            if($row = $result->fetch_assoc()) {
                $descriptor_id = $row['id'];
                $query = "INSERT INTO asset (serial, fk_descriptor) VALUES ('$serial', $descriptor_id)";
            } else {
                $query = "INSERT INTO asset (serial) VALUES ('$serial')";
            }
            $result = $mysqli->query($query);
            $id = $mysqli->insert_id;
            $asset = new Asset($mysqli, $id);
            return $asset;
        }
    }
    return 0;
}

function test_result($assets, $test_name, $test_result) {
    global $mysqli;
    $query = "SELECT * FROM test WHERE name = '$test_name'";
    if($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $test_id = $row['id'];
        foreach($assets as $asset) {
            $query = "INSERT INTO test_result_link (fk_asset_id, fk_test_id, timestamp, result) " .
                "VALUES ($asset->id, $test_id, NOW(), $test_result)";
            $$mysqli->query($query);
        }
    }
}


function mqtt_notify($topic, $message) {
    global $mqtt_client;
    $mqtt_client->publish($topic, $message);
}

function log_event($assets, $message) {
    global $mysqli;
    $query = "INSERT INTO event (timestamp, message) VALUES (NOW(), '$message')";
    $result = $mysqli->query($query);
    $event_id = $mysqli->insert_id;
    foreach($assets as $asset) {
        $query = "INSERT INTO event_asset_link (fk_event_id, fk_asset_id) VALUES ($event_id, $asset->id)";
        $mysqli->query($query);
    }
}

function complete_process($assets, $process_name) {
    global $mysqli;
    $query = "SELECT * FROM production WHERE name = '$process_name'";
    if ($result = $mysqli->query($query)) {
        if ($row = $result->fetch_assoc()) {
            $process_id = $row['id'];
            foreach($assets as $asset) {
                $query = "SELECT * FROM asset_production_link " .
                    "WHERE fk_process_id = $process_id " .
                    "AND fk_asset_id = $asset->id";
                if ($result = $mysqli->query($result)) {
                } else {
                }
            }
        }
    }
}


<?php

define('BROKER', 'localhost');
define('PORT', 1883);
define('CLIENT_ID', "pubclient_" + getmypid());

function mqtt_notify($db, $asset_ids) {
    $c = new Mosquitto\Client;
    $c->onConnect(function() use ($c) {
        $c->publish('assets/scanned', implode(',',asset_ids));
        $c->disconnect();
    });

    $c->connect('mqtt.spaceboycoop.com');
    $c->loopForever();
}

function get_test_status($db, $asset_id, $test_id) {
    $query = "SELECT result FROM test_result_link " .
        "INNER JOIN test ON fk_test_id = test.id " .
        "WHERE fk_test_id = $test_id " .
        "AND fk_asset_id = $asset_id " .
        "ORDER BY timestamp DESC " .
        "LIMIT 1";
    if ($result = $db->query($query)) {
        if ($row = $result->fetch_assoc()) {
            return $row['result'];
        }
    }
    return 0;
}

function find_or_create($db, $serial) {
    $query = "SELECT * FROM asset WHERE serial = '$serial'";
    $id = 0;
    if ($result = $db->query($query)) {
        if($row = $result->fetch_assoc()) {
            $id = $row['id'];
            return $id;
        } else {
            $query = "INSERT INTO asset (serial) VALUES ('$serial')";
            $result = $db->query($query);
            $id = $db->insert_id;
            return $id;
        }
    }
    return 0;
}

function test_result($db, $ids, $test_name, $test_result) {
    $query = "SELECT * FROM test WHERE name = '$test_name'";
    error_log($query);
    if($result = $db->query($query)) {
        $row = $result->fetch_assoc();
        $test_id = $row['id'];
        foreach($ids as $asset_id) {
            $query = "INSERT INTO test_result_link (fk_asset_id, fk_test_id, timestamp, result) " .
                "VALUES ($asset_id, $test_id, DATE(NOW()), $test_result)";
            error_log($query);
            $db->query($query);
        }
    }
}

function log_event($db, $ids, $message) {
    $query = "INSERT INTO event (timestamp, message) VALUES (DATE(NOW()), '$message')";
    $result = $db->query($query);
    $event_id = $db->insert_id;
    foreach($ids as $asset_id) {
        $query = "INSERT INTO event_asset_link (fk_event_id, fk_asset_id) VALUES ($event_id, $asset_id)";
        $db->query($query);
    }
}

function complete_process($db, $ids, $process_name) {
    $query = "SELECT * FROM production WHERE name = '$process_name'";
    if ($result = $db->query($query)) {
        if ($row = $result->fetch_assoc()) {
            $process_id = $row['id'];

            foreach($ids as $asset_id) {
                $query = "SELECT * FROM asset_production_link " .
                    "WHERE fk_process_id = $process_id " .
                    "AND fk_asset_id = $asset_id";
                if ($result = $db->query($result)) {
                    error_log('result');
                } else {
                    error_log('no result');
                }
            }
        }
    }
}


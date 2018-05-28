<?php

require_once('class/class_assetdescriptor.php');

class Asset {
    private $db;

    public $descriptor;

    public $id;
    public $serial;
    public $revision;
    public $model;
    public $status;

    function __construct($db, $id)
    {
        if ($db) {
            $this->db = $db;
            $this->id = $id;
            $this->load();
        }
    }

    function record_test() {

    }

    function save() {
        $query = "UPDATE asset SET " .
            "serial = '$this->serial', " .
            "revision = '$this->revision', " .
            "model = '$this->model', " .
            "status = '$this->status', " .
            "fk_descriptor = '$this->descriptor' " .
            "WHERE id = $this->id";
        $this->db->query($query);
    }

    function load() {
        $query = "SELECT * FROM asset WHERE id = $this->id";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $this->serial = $row['serial'];
        $this->revision = $row['revision'];
        $this->model = $row['model'];
        $this->status = $row['status'];
        $this->descriptor  = new AssetDescriptor($this->db, $row['fk_descriptor']);
    }

    function get_test_status() {
        $query = "SELECT DISTINCT id, name FROM test";
        if ($result = $this->db->query($query)) {
            $test_results = array();
            while ($row = $result->fetch_assoc()) {
                $test_status = get_test_status($this->db, $this->id, $row['id']);
                $test_results[$row['name']] = $test_status;
            }
            return $test_results;
        }
    }

    function get_event_history($length = 50) {

    }

    function get_production_checklist() {

    }

    function get_json() {
        $json = new stdClass;
        $json->id = $this->id;
        $json->serial = $this->serial;
        $json->model = $this->model;
        $json->status = $this->status;
        $json->revision = $this->revision;
        $json->descriptor = $this->descriptor->get_json();
        return json_encode($json);
    }
}

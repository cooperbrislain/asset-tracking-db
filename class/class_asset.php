<?php
class Asset {
    private $db;

    private $descriptor_id;

    public $id;
    public $serial;
    public $revision;
    public $model;
    public $status;

    function __construct($db, $id)
    {
        if ($db) {
            $this->db = $db;
            if ($id) {
                $query = "SELECT * FROM asset " .
                    "INNER JOIN  WHERE id = $id";
                if ($result = $db->query($query)) {
                    if ($row = $result->fetch_assoc()) {

                    }
                }

            }
        }
    }

    function record_test() {

    }

    function get_test_status() {
        $query = "SELECT DISTINCT id, name FROM test";
        if ($result = $this->db->query($query)) {
            $test_results = array();
            while ($row = $result->fetch_assoc($result)) {
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
        $json->test_results = $this->get_test_status();
        $json->production_checklist = $this->get_production_checklist();
        return json_encode($json);
    }
}

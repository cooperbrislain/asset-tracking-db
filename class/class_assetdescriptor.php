<?php
class AssetDescriptor {
    private $db;

    public $id;
    public $code;
    public $model;
    public $class;
    public $spec_id;

    function __construct($db, $id) {
        if ($db) {
            $this->db = $db;
            $this->id = $id;
            $this->load();
        }
    }

    function load() {
        $query = "SELECT * FROM asset_descriptor WHERE id = $this->id";
        if ($result = $this->db->query($query)) {
            if ($row = $result->fetch_assoc()) {
                $this->code = $row['code'];
                $this->model = $row['model'];
                $this->class = $row['class'];
                $this->spec_id = $row['fk_spec_id'];
            }
        }
    }

    function save() {
        $query = "UPDATE asset_descriptor SET " .
            "model = '$this->model', " .
            "class = '$this->class', " .
            "fk_spec_id = '$this->spec_id', " .
            "code = '$this->code' " .
            "WHERE id = $this->>id";
        $this->db->query($query);
    }

    function get_json() {
        $json = new stdClass;
        $json->id = $this->id;
        $json->code = $this->code;
        $json->model = $this->model;
        $json->class = $this->class;
        $json->spec_id = $this->spec_id;
        return json_encode($json);
    }
}
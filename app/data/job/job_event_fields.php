<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class job_event_fields extends job_rule {

    private $job_id;
    private $event;
    private $event_date;
    private $event_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "job_event";
        return true;
    }

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_parent_key($value, $key) {
        $this->parent_key = $value;
        data::add("parent_key", $this->parent_key !== "" ? $this->parent_key : null, $this->table_fields, $key);
    }

    public function set_job_id($value, $key) {
        $this->job_id = $value;
        data::add("job_id", $this->job_id !== "" ? $this->job_id : 0, $this->table_fields, $key);
    }

    public function set_event($value, $key) {
        $this->event = $value;
        data::add("event", $this->event !== "" ? $this->event : 0, $this->table_fields, $key);
    }

    public function set_event_date($value, $key) {
        $this->event_date = $value;
        data::add("event_date", $this->event_date !== "" ? $this->event_date : NOTIME, $this->table_fields, $key);
    }

    public function set_event_seccode($value, $key) {
        $this->event_seccode = $value;
        data::add("event_seccode", $this->event_seccode !== "" ? $this->event_seccode : NODATA, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id !== NODATA ? $this->users_id : 0, $this->table_fields, $key);
    }

}

<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class job_payment extends job_rule {

    private $job_id;
    private $event;
    private $event_date;
    private $event_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "job_payment";
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

    public function set_payment($value, $key) {
        $this->event = $value;
        data::add("event", $this->event !== "" ? $this->event : NOTIME, $this->table_fields, $key);
    }

    public function set_payment_unit($value, $key) {
        $this->payment_unit = $value;
        data::add("payment_unit", $this->payment_unit !== "" ? $this->payment_unit : default_currency(), $this->table_fields, $key);
    }

    public function set_payment_method($value, $key) {
        $this->payment_method = $value;
        data::add("payment_method", $this->payment_method !== "" ? $this->payment_method : NODATA, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date !== "" ? $this->date : NOTIME, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id !== NODATA ? $this->users_id : 0, $this->table_fields, $key);
    }

}

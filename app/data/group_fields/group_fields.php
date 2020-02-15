<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class group_fields extends group_fields_rule {

    private $fields_name;
    private $fields_name_sef;
    private $fields_type;
    private $date;
    private $group_fields_seccode;
    private $public;
    private $users_id;

    public function __construct() {
        $this->table_fields = "group_fields";
        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_fields_name($value) {
        $this->fields_name = $value;
        $this->fields_name_sef = sef_link($value);
        data::add("fields_name", $this->fields_name == "---" ? 0 : $this->fields_name, $this->table_fields);
        data::add("fields_name_sef", $this->fields_name_sef == "---" ? 0 : $this->fields_name_sef, $this->table_fields);
    }

    public function set_fields_type($value) {
        $this->fields_type = $value;
        data::add("fields_type", strtolower(input::santize($this->fields_type)), $this->table_fields);
    }

    public function set_date($value) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields);
    }

    public function set_group_fields_seccode($value) {
        $this->group_fields_seccode = seccode();
        data::add("group_fields_seccode", $this->group_fields_seccode, $this->table_fields);
    }

    public function set_public($value) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields);
    }

    public function set_users_id($value) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields);
    }

}

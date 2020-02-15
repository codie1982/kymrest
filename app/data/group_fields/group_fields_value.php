<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class group_fields_value extends category_rule {

    private $group_fields_id;
    private $category_id;
    private $date;
    private $public;
    private $category_group_field_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "group_fields_value";
        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_group_fields_value_name($value, $key) {
        $this->group_fields_value_name = $value;
        $this->group_fields_value_name_sef = sef_link($value);
        data::add("group_fields_value_name", $this->group_fields_value_name, $this->table_fields, $key);
        data::add("group_fields_value_name_sef", $this->group_fields_value_name_sef, $this->table_fields, $key);
    }

    public function set_line($value, $key) {
        $this->line = $value;
        data::add("line", $this->line == "" ? 0 : $this->line, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_group_fields_value_seccode($value, $key) {
        $this->group_fields_value_seccode = seccode();
        data::add("group_fields_value_seccode", $this->group_fields_value_seccode, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}

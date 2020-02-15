<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class category_group_fields extends category_rule {

    private $group_fields_id;
    private $category_id;
    private $date;
    private $public;
    private $category_group_field_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "category_group_fields";
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
        data::add($this->table_fields . "_id", $this->primary_key == "" ? 0 : $this->primary_key, $this->table_fields, $key);
    }

    public function set_group_fields_id($value, $key) {
        $this->group_fields_id = $value;
        data::add("group_fields_id", $this->group_fields_id == "" ? 0 : $this->group_fields_id, $this->table_fields, $key);
    }

    public function set_category_id($value, $key) {
        $this->category_id = $value;
        data::add("category_id", $this->category_id, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_category_group_field_seccode($value, $key) {
        $this->category_group_field_seccode = seccode();
        data::add("category_group_field_seccode", $this->category_group_field_seccode, $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields, $key);
    }

    public function set_sort_category($value, $key) {
        $this->sort_category = 0;
        data::add("sort_category", $this->sort_category, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}

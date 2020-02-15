<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class category_fields extends category_rule {

    private $category_name;
    private $category_sef_name;
    private $parent_category_id;
    private $category_description;
    private $category_keywords;
    private $date;
    private $category_seccode;
    private $public;
    private $sort_category;
    private $users_id;

    public function __construct() {
        $this->table_fields = "category";
        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_parent_category_id($value) {
        $this->parent_category_id = $value;
        data::add("parent_category_id", $this->parent_category_id == "" ? 0 : $this->parent_category_id, $this->table_fields);
    }

    public function set_category_name($value) {
        $this->category_name = $value;
        $this->category_sef_name = sef_link($this->category_name);
        data::add("category_name", strtolower(input::santize($this->category_name)), $this->table_fields);
        data::add("category_name_sef", $this->category_sef_name, $this->table_fields);
    }

    public function set_category_description($value) {
        $this->category_description = $value;
        data::add("category_description", base64_encode(strtolower(input::santize($this->category_description))), $this->table_fields);
    }

    public function set_category_keywords($value) {
        $this->category_keywords = $value;
        data::add("category_keywords", strtolower(input::santize($this->category_keywords)), $this->table_fields);
    }

    public function set_date($value) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields);
    }

    public function set_category_seccode($value) {
        $this->category_seccode = seccode();
        data::add("category_seccode", $this->category_seccode, $this->table_fields);
    }

    public function set_public($value) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields);
    }

    public function set_sort_category($value) {
        $this->sort_category = 0;
        data::add("sort_category", $this->sort_category, $this->table_fields);
    }

    public function set_users_id($value) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields);
    }

}

<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class category_gallery_fields extends category_rule {

    private $image_type;
    private $category_id;
    private $image_gallery_id;
    private $image_line;
    private $date;
    private $category_gallery_seccode;
    private $public;
    private $users_id;

    public function __construct() {
        $this->table_fields = "category_gallery";
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

    public function set_image_type($value, $key) {
        $this->image_type = $value;
        data::add("image_type", $this->image_type == "" ? "standart" : $this->image_type, $this->table_fields, $key);
    }

    public function set_image_gallery_id($value, $key) {
        $this->image_gallery_id = $value;
        data::add("image_gallery_id", $this->image_gallery_id == "" ? 0 : $this->image_gallery_id, $this->table_fields, $key);
    }

    public function set_image_line($value, $key) {
        $this->image_line = $value;
        data::add("image_line", $this->image_line == "" ? 0 : $this->image_line, $this->table_fields, $key);
    }

    public function set_category_id($value, $key) {
        $this->category_id = $value;
        data::add("category_id", $this->category_id == "---" ? 0 : $this->category_id, $this->table_fields, $key);
    }

    public function set_category_keywords($value, $key) {
        $this->category_keywords = $value;
        data::add("category_keywords", strtolower(input::santize($this->category_keywords)), $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_category_gallery_seccode($value, $key) {
        $this->category_gallery_seccode = seccode();
        data::add("category_gallery_seccode", $this->category_gallery_seccode, $this->table_fields, $key);
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

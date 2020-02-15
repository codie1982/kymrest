<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_gallery_fields extends product_rule {

    public $product_settings;
    public $product_title;
    public $fields = [];

    public function __construct() {
        $this->table_fields = "product_gallery";
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

    public function set_image_gallery_id($value, $key) {
        $this->image_gallery_id = $value;
        data::add("image_gallery_id", $this->image_gallery_id == "" ? 0 : $this->image_gallery_id, $this->table_fields, $key);
    }

    public function set_template($value, $key) {
        $this->template = $value;
        data::add("template", $this->template == "" ? 0 : $this->template, $this->table_fields, $key);
    }

    public function set_image_line($value, $key) {
        $this->image_line = $value;
        data::add("image_line", $this->image_line == "" ? 0 : $this->image_line, $this->table_fields, $key);
    }

    public function set_margin_left($value, $key) {
        $this->margin_left = $value;
        data::add("margin_left", $this->margin_left == "" ? 0 : $this->margin_left, $this->table_fields, $key);
    }

    public function set_margin_top($value, $key) {
        $this->margin_top = $value;
        data::add("margin_top", $this->margin_top == "" ? 0 : $this->margin_top, $this->table_fields, $key);
    }

    public function set_width($value, $key) {
        $this->width = $value;
        data::add("width", $this->width == "" ? 0 : $this->width, $this->table_fields, $key);
    }

    public function set_height($value, $key) {
        $this->height = $value;
        data::add("height", $this->height == "" ? 0 : $this->height, $this->table_fields, $key);
    }

    public function set_set_image($value, $key) {
        $this->set_image = $value;
        data::add("set_image", $this->set_image == "" ? 0 : $this->set_image, $this->table_fields, $key);
    }

    public function set_product_gallery_seccode($value, $key) {
        $this->product_gallery_seccode = seccode();
        data::add("product_gallery_seccode", $this->product_gallery_seccode, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}

<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_customer_application extends settings_customer_application_rule {

    private $title;
    private $protocol;
    private $ipnumber;
    private $portnumber;
    private $primary_color;
    private $text_color;
    private $main_slider;
    private $date;
    private $public;
    private $users_id;

    public function __construct() {
        $this->table_fields = "settings_customer_application";

        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_title($title) {
        $this->title = $title;
        data::add("title", $this->title == "" ? NODATA : $this->title, $this->table_fields);
    }

    public function set_protocol($title) {
        $this->protocol = $title;
        data::add("protocol", $this->protocol == "" ? "http" : $this->protocol, $this->table_fields);
    }

    public function set_ipnumber($title) {
        $this->ipnumber = $title;
        data::add("ipnumber", $this->ipnumber == "" ? NODATA : $this->ipnumber, $this->table_fields);
    }

    public function set_portnumber($title) {
        $this->portnumber = $title;
        data::add("portnumber", $this->portnumber == "" ? NODATA : $this->portnumber, $this->table_fields);
    }

    public function set_primary_color($primary_color) {
        $this->primary_color = $primary_color;
        data::add("primary_color", $this->primary_color == "" ? NODATA : $this->primary_color, $this->table_fields);
    }

    public function set_text_color($text_color) {
        $this->text_color = $text_color;
        data::add("text_color", $this->text_color == "" ? NODATA : $this->text_color, $this->table_fields);
    }

    public function set_main_slider($main_slider) {
        $this->main_slider = $main_slider;
        data::add("main_slider", $this->main_slider == "" ? NODATA : $this->main_slider, $this->table_fields);
    }

    public function set_date($date) {
        $this->date = $date;
        data::add("date", $this->date == "" ? getNow() : $this->date, $this->table_fields);
    }

    public function set_public($public) {
        $this->public = $public;
        data::add("public", $this->public == "" ? 1 : $this->public, $this->table_fields);
    }

    public function set_users_id($users_id) {
        $this->users_id = $users_id;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields);
    }

}

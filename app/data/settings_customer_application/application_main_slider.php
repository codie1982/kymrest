<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class application_main_slider extends settings_customer_application_rule {

    private $application_number;
    private $image_gallery_id;
    private $screen_type;
    private $screen;
    private $public;
    private $date;
    private $application_main_slider_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "application_main_slider";
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

    public function set_application_number($application_number, $key) {
        $this->application_number = $application_number;
        data::add("application_number", $this->application_number !== "" ? input::santize($this->application_number) : NODATA, $this->table_fields, $key);
    }

    public function set_image_gallery_id($image_gallery_id, $key) {
        $this->image_gallery_id = $image_gallery_id;
        data::add("image_gallery_id", $this->image_gallery_id !== "" ? input::santize($this->image_gallery_id) : NODATA, $this->table_fields, $key);
    }

    public function set_screen_type($screen_type, $key) {
        $this->screen_type = $screen_type;
        data::add("screen_type", $this->screen_type !== "" ? input::santize($this->screen_type) : NODATA, $this->table_fields, $key);
    }

    public function set_screen($screen, $key) {
        $this->screen = $screen;
        data::add("screen", $this->screen !== "" ? input::santize($this->screen) : NODATA, $this->table_fields, $key);
    }

    public function set_public($public, $key) {
        $this->public = $public;
        data::add("public", $this->public !== "" ? input::santize($this->public) : 1, $this->table_fields, $key);
    }

    public function set_date($date, $key) {
        $this->date = $date;
        data::add("date", $this->date !== "" ? input::santize($this->date) : getNow(), $this->table_fields, $key);
    }

    public function set_application_main_slider_seccode($application_main_slider_seccode, $key) {
        $this->application_main_slider_seccode = $application_main_slider_seccode;
        data::add("application_main_slider_seccode", $this->application_main_slider_seccode !== "" ? input::santize($this->application_main_slider_seccode) : seccode(), $this->table_fields, $key);
    }

    public function set_users_id($users_id, $key) {
        $this->users_id = $users_id;
        data::add("users_id", $this->users_id !== "" ? input::santize($this->users_id) : session::get(CURRENT_USER_SESSION_NAME), $this->table_fields, $key);
    }

}

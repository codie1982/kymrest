<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_general_fields extends settings_general_rule {

    public $site_title;
    public $site_description;
    public $image_gallery_id;
    public $site_url_protocol;
    public $site_url;
    public $site_keywords;
    public $mail_adres;
    public $company_name;
    public $tax_province;
    public $tax_office;
    public $tax_number;
    public $site_maintenance;
    public $block_user_listings;
    public $block_comments;
    public $allow_foreign_users;
    public $prepare;
    public $users_id;

    public function __construct() {
        $this->table_fields = "settings_general";

        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_mycompany_id($value) {
        $this->mycompany_id = $value;
        data::add("mycompany_id", $this->mycompany_id == "" ? 0 : $this->mycompany_id, $this->table_fields);
    }

    public function set_date($value) {
        $this->date = $value;
        data::add("date", $this->date == "" ? getNow() : $this->date, $this->table_fields);
    }

    public function set_settings_general_seccode($value) {
        $this->settings_general_seccode = $value;
        data::add("settings_general_seccode", $this->settings_general_seccode == "" ? seccode() : $this->settings_general_seccode, $this->table_fields);
    }

    public function set_users_id($value) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields);
    }

}

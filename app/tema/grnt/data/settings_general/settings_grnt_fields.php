<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_grnt_fields extends settings_general_rule {

    public $site_title;
    public $site_description;
    public $image_gallery_id;
    public $site_url_protocol;
    public $site_url;
    public $site_keywords;
    public $mail_adres;
    public $prepare;
    public $users_id;

    public function __construct() {
        $this->table_fields = "settings_grnt";

        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_site_title($value) {
        $this->site_title = $value;
        data::add("site_title", $this->site_title == "" ? NODATA : $this->site_title, $this->table_fields);
    }

    public function set_prepare($value) {
        $this->prepare = 1;
        data::add("prepare", $this->prepare, $this->table_fields);
    }

    public function set_site_description($value) {
        $this->site_description = $value;
        data::add("site_description", base64_encode($this->site_description), $this->table_fields);
    }

    public function set_image_gallery_id($value) {
        $this->image_gallery_id = $value;
        data::add("image_gallery_id", $this->image_gallery_id, $this->table_fields);
    }

    public function set_site_url_protocol($value) {
        $this->site_url_protocol = $value;
        data::add("site_url_protocol", $this->site_url_protocol, $this->table_fields);
    }

    public function set_site_url($value) {
        $this->site_url = $value;
        data::add("site_url", $this->site_url, $this->table_fields);
    }

    public function set_site_keywords($value) {
        $this->site_keywords = $value;
        data::add("site_keywords", $this->site_keywords, $this->table_fields);
    }

    public function set_site_mail($value) {
        $this->mail_adres = $value;
        data::add("site_mail", $this->mail_adres, $this->table_fields);
    }

    public function set_users_id($value) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields);
    }

}

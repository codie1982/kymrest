<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image_gallery_fields
 *
 * @author engin
 */
class image_gallery_fields {

    public function __construct() {
        $this->table_fields = "image_gallery";
        return true;
    }

    /*
      "form_type" => $image_info["form_type"],
      "image_name" => $image_info["image_name"],
      "file" => $file,
      "image_uniqid" => $image_info["uniqid"],
      "image_folder" => $image_info["image_folder"],
      "first_image_name" => $image_info["first_image_name"],
      "image_relative_path" => $image_info["image_relative_path"],
      "extention" => $image_info["extention"],
      "gallery_seccode" => $gallery_seccode,
      "date" => getNow(),
      "users_id" => $user_id, */

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_media_type($value, $key) {
        data::add("media_type", $value, $this->table_fields, $key);
    }

    public function set_form_type($value, $key) {
        data::add("form_type", $value, $this->table_fields, $key);
    }

    public function set_image_name($value, $key) {
        data::add("image_name", $value, $this->table_fields, $key);
    }

    public function set_file($value, $key) {
        data::add("file", $value, $this->table_fields, $key);
    }

    public function set_image_uniqid($value, $key) {
        data::add("image_uniqid", $value, $this->table_fields, $key);
    }

    public function set_image_folder($value, $key) {
        data::add("image_folder", $value, $this->table_fields, $key);
    }

    public function set_image_relative_path($value, $key) {
        data::add("image_relative_path", $value, $this->table_fields, $key);
    }

    public function set_first_image_name($value, $key) {
        data::add("first_image_name", $value, $this->table_fields, $key);
    }

    public function set_extention($value, $key) {
        data::add("extention", $value, $this->table_fields, $key);
    }

    public function set_gallery_seccode($value, $key) {
        data::add("gallery_seccode", seccode(), $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        data::add("date", getNow(), $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        data::add("users_id", session::get(CURRENT_USER_SESSION_NAME), $this->table_fields, $key);
    }

}

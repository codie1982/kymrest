<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class sidebar_menu_fields extends customer_rule {

    public function __construct() {
        $this->table_fields = "sidebar_menu";
        return true;
    }

    private $group_name;
    private $menu_title;
    private $menu_description;
    private $link;
    private $icon;
    private $row_number;
    private $menu_item_seccode;
    private $users_id;

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_group_name($group_name, $key) {
        $this->group_name = $group_name;
        data::add("group_name", $this->group_name != "" ? input::santize($this->group_name) : NODATA, $this->table_fields, $key);
    }

    public function set_menu_title($menu_title, $key) {
        $this->menu_title = $menu_title;
        data::add("menu_title", $this->menu_title != "" ? input::santize($this->menu_title) : NODATA, $this->table_fields, $key);
    }

    public function set_menu_description($menu_description, $key) {
        $this->menu_description = $menu_description;
        data::add("menu_description", $this->menu_description != "" ? input::santize($this->menu_description) : NODATA, $this->table_fields, $key);
    }

    public function set_link($link, $key) {
        $this->link = $link;
        data::add("link", $this->link != "" ? input::santize($this->link) : NODATA, $this->table_fields, $key);
    }

    public function set_icon($icon, $key) {
        $this->icon = $icon;
        data::add("icon", $this->icon != "" ? input::santize($this->icon) : NODATA, $this->table_fields, $key);
    }

    public function set_row_number($icon, $key) {
        $this->row_number = $icon;
        data::add("row_number", $this->row_number != "" ? input::santize($this->row_number) : NODATA, $this->table_fields, $key);
    }

    public function set_menu_item_seccode($menu_item_seccode, $key) {
        $this->menu_item_seccode = $menu_item_seccode;
        data::add("menu_item_seccode", $this->menu_item_seccode != "" ? input::santize($this->menu_item_seccode) : seccode(), $this->table_fields, $key);
    }

    public function set_users_id($users_id, $key) {
        $this->users_id = $users_id;
        data::add("users_id", $this->users_id != "" ? input::santize($this->users_id) : session::get(CURRENT_USER_SESSION_NAME), $this->table_fields, $key);
    }

}

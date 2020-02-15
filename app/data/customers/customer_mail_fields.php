<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_mail_fields extends customer_rule {

    private $customer_id;
    private $customer_mail;
    private $customer_mail_date;
    private $confirm;
    private $confirm_date;
    private $confirm_code;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_mail";
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

    public function set_customer_id($customer_id, $key) {
        $this->customer_id = $customer_id;
        data::add("customer_id", $this->customer_id !== 0 ? input::santize($this->customer_id) : 0, $this->table_fields, $key);
    }

    public function set_customer_mail($customer_mail, $key) {
        $this->customer_mail = $customer_mail;
        data::add("customer_mail", $this->customer_mail == "" ? NODATA : input::santize($this->customer_mail), $this->table_fields, $key);
    }

    public function set_customer_mail_date($customer_mail_date, $key) {
        $this->customer_mail_date = $customer_mail_date;
        data::add("customer_mail_date", $this->customer_mail_date == "" ? getNow() : input::santize($this->customer_mail_date), $this->table_fields, $key);
    }

    public function set_confirm($confirm, $key) {
        $this->confirm = $confirm;
        data::add("confirm", $this->confirm == "" ? 0 : input::santize($this->confirm), $this->table_fields, $key);
    }

    public function set_confirm_date($confirm_date, $key) {
        $this->confirm_date = $confirm_date;
        data::add("confirm_date", $this->confirm_date == "" ? data::get("confirm", $this->table_fields) == "1" ? getNow() : NOTIME : input::santize($this->confirm_date), $this->table_fields, $key);
    }

    public function set_confirm_code($confirm_date, $key) {
        $this->confirm_code = $confirm_date;
        data::add("confirm_code", $this->confirm_code == "" ? 0 : input::santize($this->confirm_code), $this->table_fields, $key);
    }

    public function set_users_id($users_id, $key) {
        $this->users_id = $users_id;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : input::santize($this->users_id), $this->table_fields, $key);
    }

}

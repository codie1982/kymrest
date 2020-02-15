<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_siteaccount_fields extends customer_rule {

    private $visitor_id;
    private $customer_id;
    private $customer_sef_link;
    private $customer_nickname;
    private $customer_email;
    private $password;
    private $re_password;
    private $re_password_code;
    private $customer_seccode;
    private $date;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_siteaccount";
        return true;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_customer_id($visitor_id) {
        $this->customer_id = $visitor_id;
        data::add("customer_id", $this->customer_id == "" ? 0 : input::santize($this->customer_id), $this->table_fields);
    }

    public function set_visitor_id($visitor_id) {
        $this->visitor_id = $visitor_id;
        data::add("visitor_id", $this->visitor_id == "" ? 0 : input::santize($this->visitor_id), $this->table_fields);
    }

    public function set_customer_sef_link($customer_sef_link) {
        $this->customer_sef_link = $customer_sef_link;
        data::add("customer_sef_link", $this->customer_sef_link == "" ? NODATA : input::santize($this->customer_sef_link), $this->table_fields);
    }

    public function set_customer_nickname($customer_nickname) {
        $this->customer_nickname = $customer_nickname;
        data::add("customer_nickname", $this->customer_nickname == "" ? NODATA : input::santize($this->customer_nickname), $this->table_fields);
        data::add("customer_sef_link", $this->customer_nickname == "" ? NODATA : sef_link($this->customer_nickname), $this->table_fields);
    }

    public function set_customer_email($customer_email) {
        $this->customer_email = $customer_email;
        data::add("customer_email", $this->customer_email == "" ? NODATA : input::santize($this->customer_email), $this->table_fields);
    }

    public function set_password($password) {
        $this->password = $password;
        data::add("password", $this->password == "" ? NODATA : password_hash(input::santize($this->password), PASSWORD_DEFAULT), $this->table_fields);
    }

    public function set_re_password($re_password) {
        $this->re_password = $re_password;
        data::add("re_password", $this->re_password == "" ? 0 : input::santize($this->re_password), $this->table_fields);
    }

    public function set_re_password_code($re_password_code) {
        $this->re_password_code = $re_password_code;
        data::add("re_password_code", $this->re_password_code == "" ? 0 : input::santize($this->re_password_code), $this->table_fields);
    }

    public function set_customer_seccode($customer_seccode) {
        $this->customer_seccode = $customer_seccode;
        data::add("customer_seccode", $this->customer_seccode == "" ? seccode() : input::santize($this->customer_seccode), $this->table_fields);
    }

    public function set_date($date) {
        $this->date = $date;
        data::add("date", $this->date == "" ? getNow() : input::santize($this->date), $this->table_fields);
    }

    public function set_users_id($users_id) {
        $this->users_id = $users_id;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : input::santize($this->users_id), $this->table_fields);
    }

}

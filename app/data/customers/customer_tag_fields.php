<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_tag_fields extends customer_rule {

    private $customer_id;
    private $tag;
    private $supermen_tag;
    private $public;
    private $customer_tag_seccode;
    private $date;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_tag";
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
        data::add("customer_id", $this->customer_id !== NODATA ? input::santize($this->customer_id) : 0, $this->table_fields, $key);
    }

    public function set_tag($iban, $key) {
        $this->tag = $iban;
        data::add("tag", $this->tag !== NODATA ? input::santize($this->tag) : NODATA, $this->table_fields, $key);
    }

    public function set_supermen_tag($iban, $key) {
        $this->supermen_tag = $iban;
        data::add("supermen_tag", $this->supermen_tag !== NODATA ? input::santize($this->supermen_tag) : NODATA, $this->table_fields, $key);
    }

    public function set_public($public, $key) {
        $this->public = $public;
        data::add("public", $this->public !== "" ? input::santize($this->public) : 1, $this->table_fields, $key);
    }

    public function set_customer_tag_seccode($customer_bank_seccode, $key) {
        $this->customer_tag_seccode = $customer_bank_seccode;
        data::add("customer_tag_seccode", $this->customer_tag_seccode !== "" ? input::santize($this->customer_tag_seccode) : seccode(), $this->table_fields, $key);
    }

    public function set_date($date, $key) {
        $this->date = $date;
        data::add("date", $this->date !== "" ? input::santize($this->date) : getNow(), $this->table_fields, $key);
    }

    /**
     * customer users_id - int(11)
     * default value use session id
     * table_columb_name ="users_id"
     * @param type $value
     * @param type $key
     */
    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}

<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_bank_fields extends customer_rule {

    private $bank_name;
    private $iban;
    private $public;
    private $customer_bank_seccode;
    private $date;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_bank";
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
        data::add("customer_id", $this->customer_id !== "" ? input::santize($this->customer_id) : 0, $this->table_fields, $key);
    }

    public function set_bank_name($bank_name, $key) {
        $this->bank_name = $bank_name;
        data::add("bank_name", $this->bank_name !== "" ? input::santize($this->bank_name) : NODATA, $this->table_fields, $key);
    }

    public function set_iban($iban, $key) {
        $this->iban = $iban;
        data::add("iban", $this->iban !== "" ? input::santize($this->iban) : 0, $this->table_fields, $key);
    }

    public function set_public($public, $key) {
        $this->public = $public;
        data::add("public", $this->public !== "" ? input::santize($this->public) : 1, $this->table_fields, $key);
    }

    public function set_customer_bank_seccode($customer_bank_seccode, $key) {
        $this->customer_bank_seccode = $customer_bank_seccode;
        data::add("customer_bank_seccode", $this->customer_bank_seccode !== "" ? input::santize($this->customer_bank_seccode) : seccode(), $this->table_fields, $key);
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

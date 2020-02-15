<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_phone_fields extends customer_rule {

    private $phone_type;
    private $area_code;
    private $phone_number;
    private $phone_seccode;
    private $public;
    private $confirm;
    private $date;
    private $users_id;
    private $secret_number;

    public function __construct() {
        $this->table_fields = "customer_phone";
        return true;
    }

    /*
      customer_id	int(11)
      phone_type	varchar(45)
      area_code         varchar(45)
      phone             varchar(7)
      date              timestamp
      phone_seccode	varchar(255)
      public            int(11)
      confirm           int(11)
      users_id          int(11)
     */

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

    /**
     * customer phone_type varchar(45) 
     * table_columb_name ="phone_type"
     * @param type $value
     * @param type $key
     */
    public function set_phone_type($value, $key) {
        $this->phone_type = $value;
        data::add("phone_type", $this->phone_type !== "" ? input::santize($this->phone_type) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer area_code varchar(3) 
     * table_columb_name ="area_code"
     * @param type $value
     * @param type $key
     */
    public function set_area_code($value, $key) {
        $this->area_code = $value;
        data::add("area_code", $this->area_code !== "" ? input::santize($this->area_code) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer phone_number varchar(7) 
     * table_columb_name ="phone_number"
     * @param type $value
     * @param type $key
     */
    public function set_phone_number($value, $key) {
        $this->phone_number = $value;
        data::add("phone_number", $this->phone_number !== "" ? input::santize($this->phone_number) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer phone security code - varchar(255)
     * table_columb_name ="phone_seccode"
     * @param type $value
     * @param type $key
     */
    public function set_phone_seccode($value, $key) {
        $this->phone_seccode = seccode();
        data::add("phone_seccode", $this->phone_seccode, $this->table_fields, $key);
    }

    /**
     * customer phone confirm state - boolean
     * default value 0
     * table_columb_name ="confirm"
     * @param type $value
     * @param type $key
     */
    public function set_confirm($value, $key) {
        $this->confirm = 1;
        data::add("confirm", $this->confirm, $this->table_fields, $key);
    }

    /**
     * customer phone public state - boolean
     * default value 1
     * table_columb_name ="public"
     * @param type $value
     * @param type $key
     */
    public function set_public($value, $key) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields, $key);
    }

    /**
     * customer phone reconize date - timestamp
     * only current time
     * table_columb_name ="date"
     * @param type $value
     * @param type $key
     */
    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    /**
     * customer session id - int(11)
     * table_columb_name ="users_id"
     * @param type $value
     * @param type $key
     */
    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id != "" ? $this->users_id : session::get(CURRENT_USER_SESSION_NAME), $this->table_fields, $key);
    }

}

<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_credicard_fields extends customer_rule {

    private $month;
    private $year;
    private $credi_card_number;
    private $card_security_number;
    private $credi_card_seccode;
    private $date;
    private $users_id;
    private $public;
    private $secret_number;

    public function __construct() {
        $this->table_fields = "customer_credi_card";
        return true;
    }

    /*
      credicard_title         varchar(455)
      customer_id             int(11)
      credi_card_number	varchar(45)
      month                   int(11)
      year                    int(11)
      card_security_number	int(11)
      date                    timestamp
      credi_card_seccode	varchar(255)
      public                  int(11)
      users_id                int(11)

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
        data::add("customer_id", $this->customer_id !== "" ? input::santize($this->customer_id) : 0, $this->table_fields, $key);
    }

    /**
     * customer credicard_title varchar(45) 
     * table_columb_name ="credicard_title"
     * @param type $value
     * @param type $key
     */
    public function set_credicard_title($value, $key) {
        $pattern = '/([A-Za-z])\w+/';
        preg_match_all($pattern, $value, $output);
        $this->credicard_title = implode(" ", $output[0]);
        data::add("credicard_title", $this->credicard_title !== "" ? input::santize($this->credicard_title) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer month date int(11)
     * table_columb_name ="month"
     * @param type $value
     * @param type $key
     */
    public function set_month($value, $key) {
        $pattern = '/([0-9])\w+/';
        preg_match_all($pattern, $value, $output);
        $this->month = trim(implode(" ", $output[0]));
        data::add("month", $this->month !== "" ? input::santize($this->month) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer year date int(11)
     * table_columb_name ="year"
     * @param type $value
     * @param type $key
     */
    public function set_year($value, $key) {
        $pattern = '/([0-9])\w+/';
        preg_match_all($pattern, $value, $output);
        $this->year = trim(implode(" ", $output[0]));
        data::add("year", $this->year !== "" ? input::santize($this->year) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer credi_card_number varchar(16)
     * table_columb_name ="credi_card_number"
     * @param type $value
     * @param type $key
     */
    public function set_number($value, $key) {
        $pattern = '/([0-9])\w+/';
        preg_match_all($pattern, $value, $output);
        $this->credi_card_number = trim(implode(" ", $output[0]));
        data::add("credi_card_number", $this->credi_card_number != "" ? $this->credi_card_number : NODATA, $this->table_fields, $key);
    }

    /**
     * customer card_security_number varchar(3)
     * table_columb_name ="card_security_number"
     * @param type $value
     * @param type $key
     */
    public function set_card_security_number($value, $key) {
        $pattern = '/([0-9])\w+/';
        preg_match_all($pattern, $value, $output);
        $this->card_security_number = trim(implode(" ", $output[0]));
        data::add("card_security_number", $this->card_security_number != "" ? $this->card_security_number : NODATA, $this->table_fields, $key);
    }

    /**
     * customer reconize date - timestamp
     * table_columb_name ="date"
     * @param type $value
     * @param type $key
     */
    public function set_date($value, $key) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields, $key);
    }

    /**
     * customer credicard security code - varchar(255)
     * table_columb_name ="credi_card_seccode"
     * @param type $value
     * @param type $key
     */
    public function set_credi_card_seccode($value, $key) {
        $this->credi_card_seccode = seccode();
        data::add("credi_card_seccode", $this->credi_card_seccode, $this->table_fields, $key);
    }

    /**
     * customer credicard public state - boolean
     * table_columb_name ="public"
     * @param type $value
     * @param type $key
     */
    public function set_public($value, $key) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields, $key);
    }

    /**
     * customer session id - int(11)
     * table_columb_name ="users_id"
     * @param type $value
     * @param type $key
     */
    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields, $key);
    }

}

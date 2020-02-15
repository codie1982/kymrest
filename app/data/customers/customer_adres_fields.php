<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_adres_fields extends customer_rule {

    private $adres_title;
    private $province;
    private $district;
    private $neighborhood;
    private $mail_code;
    private $directions;
    private $description;
    private $date;
    private $public;
    private $confirm;
    private $delivery_adres;
    private $shipping_adres;
    private $adres_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_adres";
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

    /**
     * customer adres title varchar(45) 
     * table_columb_name ="adres_title"
     * @param type $value
     * @param type $key
     */
    public function set_adres_title($value, $key) {
        $this->adres_title = $value;
        data::add("adres_title", $this->adres_title !== "" ? (trim(input::santize($this->adres_title))) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer province int(11)
     * table_columb_name ="province"
     * @param type $value
     * @param type $key
     */
    public function set_province($value, $key) {
        $this->province = $value;
        data::add("province", $this->province !== "" ? input::santize($this->province) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer district int(11)
     * table_columb_name ="district"
     * @param type $value
     * @param type $key
     */
    public function set_district($value, $key) {
        $this->district = $value;
        data::add("district", $this->district !== "" ? input::santize($this->district) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer neighborhood int(11)
     * table_columb_name ="neighborhood"
     * @param type $value
     * @param type $key
     */
    public function set_neighborhood($value, $key) {
        $this->neighborhood = $value;
        data::add("neighborhood", $this->neighborhood !== "" ? input::santize($this->neighborhood) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer mail_code int(11)
     * table_columb_name ="mail_code"
     * @param type $value
     * @param type $key
     */
    public function set_mail_code($value, $key) {
        $pattern = '/\d+/';
        preg_match_all($pattern, $value, $output);
        $this->mail_code = $output[0][0];
        data::add("mail_code", $this->mail_code !== "" ? input::santize($this->mail_code) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer description varchar(455)
     * table_columb_name ="description"
     * @param type $value
     * @param type $key
     */
    public function set_description($value, $key) {
        $this->description = $value;
        data::add("description", $this->description !== "" ? trim(input::santize($this->description)) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer street varchar(455)
     * table_columb_name ="street"
     * @param type $value
     * @param type $key
     */
    public function set_street($value, $key) {
        $this->street = $value;
        data::add("street", $this->street !== "" ? input::santize($this->street) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer reconize timespan
     * default only value current time
     * table_columb_name ="date"
     * @param type $value
     * @param type $key
     */
    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date == "" ? getNow() : $this->date, $this->table_fields, $key);
    }

    /**
     * customer adres_seccode security code - varchar(255)
     * default value use function seccode()
     * table_columb_name ="adres_seccode"
     * @param type $value
     * @param type $key
     */
    public function set_adres_seccode($value, $key) {
        $this->adres_seccode = seccode();
        data::add("adres_seccode", $this->adres_seccode == "" ? seccode() : $this->adres_seccode, $this->table_fields, $key);
    }

    /**
     * customer users_id - int(11)
     * default value use session id
     * table_columb_name ="users_id"
     * @param type $value
     * @param type $key
     */
    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields, $key);
    }

    /**
     * customer confirm - boolean
     * default value false
     * table_columb_name ="confirm"
     * @param type $value
     * @param type $key
     */
    public function set_confirm($value, $key) {
        $this->confirm = 1;
        data::add("confirm", $this->confirm, $this->table_fields, $key);
    }

    /**
     * customer public - boolean
     * default value true
     * table_columb_name ="public"
     * @param type $value
     * @param type $key
     */
    public function set_public($value, $key) {
        $this->public = 1;
        data::add("public", $this->public, $this->table_fields, $key);
    }

    public function set_delivery_adres($value, $key) {
        $this->delivery_adres = 1;
        data::add("delivery_adres", $this->delivery_adres, $this->table_fields, $key);
    }

    public function set_shipping_adres($value, $key) {
        $this->shipping_adres = 1;
        data::add("shipping_adres", $this->shipping_adres, $this->table_fields, $key);
    }

}

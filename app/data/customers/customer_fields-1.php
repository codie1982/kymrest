<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_fields extends customer_rule {

    private $name;
    private $lastname;
    private $email;
    private $email_cofirm;
    private $email_cofirm_date;
    private $password;
    private $repassword;
    private $repassword_code;
    private $gender;
    private $birthdate;
    private $type;
    private $description;
    private $customer_add_state;
    private $visitor_id;
    private $visitor_ip;
    private $visitor_referer;
    private $public;
    private $sales;
    private $customer_seccode;
    private $customer_code;
    private $contract;
    private $advertisement;
    private $advertisement_date;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer";
        return true;
    }

    /*
      customer_id
      name varchar(255)
      lastname varchar(255)
      name_sef varchar(255)
      email	varchar(255)
      email_cofirm	int(11)
      email_cofirm_date	timestazla
      password	varchar(455)
      repassword	int(11)
      repassword_code	varchar(455)
      gender	int(11)
      birthdate	timestamp
      type	varchar(45)
      description	text
      customer_add_state	varchar(45)
      visitor_id	int(11)
      visitor_ip	varchar(255)
      visitor_referer	varchar(255)
      date	timestamp
      public	int(11)
      sales	int(11)
      customer_seccode	varchar
      customer_code	varchar(45)
      contract	int(11)
      contract_date	timestamp
      advertisement	int(11)
      advertisement_date	timestazla
      users_id
     */

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    /**
     * customer name varchar(240) and customer_sef_name varchar(255)
     * table_columb_name ="name"
     * table_columb_name ="name_sef"
     * @param type $value
     */
    public function set_name($value) {
        $pattern = '/[a-zA-Z0-9\ş\ç\ö\ğ\ü\ı\Ş\Ç\Ö\Ğ\Ü\İ\s]+/';
        preg_match_all($pattern, $value, $output);
        $this->name = $output[0][0];
        data::add("name", $this->name !== "" ? $this->name : NODATA, $this->table_fields);
        data::add("name_sef", $this->name !== "" ? sef_link($this->name) : NODATA, $this->table_fields);
    }

    /**
     * customer sef name varchar(255) and customer_sef_name varchar(255)
     * table_columb_name ="name"
     * @param type $value
     */
    public function set_name_sef($value) {
        data::add("name_sef", $this->name !== "" ? sef_link($this->name) : NODATA, $this->table_fields);
    }

    /**
     * customer lastname varchar(240)
     * table_columb_name ="lastname"
     * @param type $value
     */
    public function set_lastname($value) {
        $pattern = '/[a-zA-Z0-9\ş\ç\ö\ğ\ü\ı\Ş\Ç\Ö\Ğ\Ü\İ\s]+/';
        preg_match_all($pattern, $value, $output);
        $this->lastname = $output[0][0];
        data::add("lastname", $this->lastname !== "" ? $this->lastname : NODATA, $this->table_fields);
    }

    /**
     * customer email adres varchar(255)
     *  table_columb_name ="email"
     * @param type $value
     */
    public function set_email($value) {
        $this->email = $value;
        data::add("email", $this->email !== "" ? $this->email : NODATA, $this->table_fields);
    }

    /**
     * customer email_confirm int(11)
     * table_columb_name ="email_cofirm"
     * @param type $value
     */
    public function set_email_cofirm($value) {
        $this->email_cofirm = $value;
        data::add("email_cofirm", $this->email_cofirm !== 0 ? $this->email_cofirm : 0, $this->table_fields);
    }

    /**
     *  customer email confirm date timespan
     * table_columb_name ="email_cofirm_date"
     * @param type $value
     */
    public function set_email_cofirm_date($value) {
        $this->email_cofirm_date = $value;
        data::add("email_cofirm_date", $this->email_cofirm_date !== "" ? $this->email_cofirm_date : NOTIME, $this->table_fields);
    }

    /**
     * customer password hash varchar(455)
     * table_columb_name ="password"
     *  password_hash(input::santize($value), PASSWORD_DEFAULT)
     * @param type $value
     */
    public function set_password($value) {
        $this->password = $value;
        data::add("password", $this->password !== "" ? $this->password : NODATA, $this->table_fields);
    }

    /**
     * customer password re generate boolean
     *  table_columb_name ="repassword"
     * @param type $value
     */
    public function set_repassword($value) {
        $this->repassword = $value;
        data::add("repassword", $this->repassword !== "" ? $this->repassword : 1, $this->table_fields);
    }

    /**
     *  customer re generate  password code  varchar(455)
     *  table_columb_name ="repassword_code"
     * @param type $value
     */
    public function set_repassword_code($value) {
        $this->repassword_code = $value;
        data::add("repassword_code", $this->repassword, $this->table_fields);
    }

    /**
     *  customer gender info man:1 - woman:0 varchar(455)
     *  table_columb_name ="repassword_code"
     * @param type $value
     */
    public function set_gender($value) {
        $this->gender = $value;
        data::add("gender", $this->gender !== "" ? $this->gender : NODATA, $this->table_fields);
    }

    /**
     *  customer birthdate info timestamp
     *  table_columb_name ="birthdate" 
     * @param type $value
     */
    public function set_birthdate($value) {
        $this->birthdate = $value;
        data::add("birthdate", $this->birthdate !== "" ? $this->birthdate : NODATA, $this->table_fields);
    }

    /**
     *  customer type "company" or "personel"
     *  table_columb_name ="type" 
     * @param type $value
     */
    public function set_type($value) {
        $this->type = $value;
        data::add("type", $this->type !== "" ? $this->type : NODATA, $this->table_fields);
    }

    /**
     *  customer descrtion 
     *  table_columb_name ="description" 
     * @param type $value
     */
    public function set_description($value) {
        $this->description = $value;
        data::add("description", base64_encode($this->description), $this->table_fields);
    }

    /**
     *  customer reconize state "manuel or "automatic"
     *  table_columb_name ="customer_add_state" 
     * @param type $value
     */
    public function set_customer_add_state($value) {
        $this->customer_add_state = $value;
        data::add("customer_add_state", $this->customer_add_state !== "" ? $this->customer_add_state : NODATA, $this->table_fields);
    }

    /**
     *  customer  random id code int(11)
     *  table_columb_name ="visitor_id" 
     * @param type $value
     */
    public function set_visitor_id($value) {
        $this->visitor_id = $value;
        data::add("visitor_id", $this->visitor_id !== "" ? $this->visitor_id : 0, $this->table_fields);
    }

    /**
     *  customer ip adres varchar(255)
     *  table_columb_name ="visitor_ip" 
     * @param type $value
     */
    public function set_visitor_ip($value) {
        $this->visitor_ip = $value;
        data::add("visitor_ip", $this->visitor_ip !== "" ? $this->visitor_ip : get_ipno(), $this->table_fields);
    }

    /**
     *  customer referer adres varchar(255)
     *  table_columb_name ="visitor_referer" 
     * @param type $value
     */
    public function set_visitor_referer($value) {
        $this->visitor_referer = $value;
        data::add("visitor_referer", $this->visitor_referer !== "" ? $this->visitor_referer : NODATA, $this->table_fields);
    }

    /**
     * customer reconize date timestamp
     * get automatic value
     * table_columb_name ="date" 
     * @param type $value
     */
    public function set_date($value) {
        data::add("date", $value != "" ? $value : getNow(), $this->table_fields);
    }

    /**
     * customer public state boolean
     * default value   false (0)
     * table_columb_name ="public" 
     * @param type $value
     */
    public function set_public($value) {
        $this->public = $value;
        data::add("public", $this->public !== "" ? $this->public : 0, $this->table_fields);
    }

    /**
     * customer sales state boolean
     * default value   true (1)
     * table_columb_name ="sales" 
     * @param type $value
     */
    public function set_sales($value) {
        $this->sales = $value;
        data::add("sales", $this->sales !== "" ? $this->sales : 1, $this->table_fields);
    }

    /**
     * customer securty code - varchar(255)
     * default value use function seccode()
     * table_columb_name ="customer_seccode" 
     * @param type $value
     */
    public function set_customer_seccode($value) {
        $this->customer_seccode = $value;
        data::add("customer_seccode", $this->customer_seccode !== "" ? $this->customer_seccode : seccode(), $this->table_fields);
    }

    /**
     * customer normal code - varchar(6)
     * default value ---
     * use 6 char
     * table_columb_name ="customer_seccode" 
     * @param type $value
     */
    public function set_customer_code($value) {
        $this->customer_code = $value;
        data::add("customer_code", $this->customer_code !== "" ? $this->customer_code : NODATA, $this->table_fields);
    }

    /**
     * customer accept contract - boolean
     * default value false(0)
     * table_columb_name ="contract" 
     * @param type $value
     */
    public function set_contract($value) {
        $this->contract = $value;
        data::add("contract", $this->contract !== "" ? $this->contract : 0, $this->table_fields);
    }

    /**
     * customer accept contract - timestamp
     * default value NOTIME
     * table_columb_name ="contract_date" 
     * @param type $value
     */
    public function set_contract_date($value) {
        $this->contract_date = $value;
        data::add("contract_date", $this->contract_date !== "" ? $this->contract_date : NOTIME, $this->table_fields);
    }

    /**
     * customer accept contract - boolean
     * default value false (0)
     * table_columb_name ="advertisement" 
     * @param type $value
     */
    public function set_advertisement($value) {
        $this->advertisement = $value;
        data::add("advertisement", $this->advertisement !== "" ? $this->advertisement : 0, $this->table_fields);
    }

    /**
     * customer accept advertisement - timestamp
     * default value NOTIME
     * table_columb_name ="advertisement_date" 
     * @param type $value
     */
    public function set_advertisement_date($value) {
        $this->advertisement_date = $value;
        data::add("advertisement_date", $this->advertisement_date !== "" ? $this->advertisement_date : NOTIME, $this->table_fields);
    }

    /**
     * open session id - int(11)
     * default value (0)
     * table_columb_name ="users_id" 
     * @param type $value
     */
    public function set_users_id($value) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id !== NODATA ? $this->users_id : 0, $this->table_fields);
    }

}

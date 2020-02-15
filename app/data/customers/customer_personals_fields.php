<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_personals_fields extends customer_rule {

    private $name;
    private $customer_id;
    private $lastname;
    private $gender;
    private $birth_day;
    private $birth_month;
    private $birth_year;
    private $profession;
    private $professional_duty;
    private $idnumber;
    private $description;
    private $public;
    private $date;
    private $customer_personel_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_personel";
        return true;
    }

    public function set_secret_number($value, $key) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields, $key);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_customer_id($customer_id, $key) {
        $this->customer_id = $customer_id;
        data::add("customer_id", $this->customer_id !== 0 ? input::santize($this->customer_id) : 0, $this->table_fields, $key);
    }

    public function set_name($name, $key) {
        $this->name = $name;
        data::add("name", $this->name !== "" ? input::santize($this->name) : NODATA, $this->table_fields, $key);
    }

    public function set_lastname($lastname, $key) {
        $this->lastname = $lastname;
        data::add("lastname", $this->lastname !== "" ? input::santize($this->lastname) : NODATA, $this->table_fields, $key);
    }

    public function set_gender($gender, $key) {
        $this->gender = $gender;
        data::add("gender", $this->gender == "" ? 0 : $this->gender, $this->table_fields, $key);
    }

    public function set_birth_day($birth_day, $key) {
        $this->birth_day = $birth_day;
        data::add("birth_day", $this->birth_day == "" ? 0 : $this->birth_day, $this->table_fields, $key);
    }

    public function set_birth_month($birth_month, $key) {
        $this->birth_month = $birth_month;
        data::add("birth_month", $this->birth_month == "" ? 0 : $this->birth_month, $this->table_fields, $key);
    }

    public function set_birth_year($birth_year, $key) {
        $this->birth_year = $birth_year;
        data::add("birth_year", $this->birth_year == "" ? 0 : $this->birth_year, $this->table_fields, $key);
    }

    public function set_profession($profession, $key) {
        $this->profession = $profession;
        data::add("profession", $this->profession !== "" ? input::santize($this->profession) : NODATA, $this->table_fields, $key);
    }

    public function set_professional_duty($professional_duty, $key) {
        $this->professional_duty = $professional_duty;
        data::add("professional_duty", $this->professional_duty !== "" ? input::santize($this->professional_duty) : NODATA, $this->table_fields, $key);
    }

    public function set_description($description, $key) {
        $this->description = $description;
        data::add("description", $this->description == "" ? NODATA : input::santize($this->description), $this->table_fields, $key);
    }

    public function set_date($date, $key) {
        $this->date = $date;
        data::add("date", $this->date == "" ? getNow() : $this->date, $this->table_fields, $key);
    }

    public function set_customer_personel_seccode($customer_personel_seccode, $key) {
        $this->customer_personel_seccode = $customer_personel_seccode;
        data::add("customer_personel_seccode", $this->customer_personel_seccode == "" ? seccode() : $this->customer_personel_seccode, $this->table_fields, $key);
    }

    /**
     * customer personel id number int(11)
     * table_columb_name ="idnumber"
     * @param type $value
     * @param type $key
     */
    public function set_idnumber($value, $key) {
        $this->idnumber = $value;
        data::add("idnumber", $this->idnumber !== "" ? input::santize($this->idnumber) : NODATA, $this->table_fields, $key);
    }

    /**
     * customer personel public state - boolean
     * table_columb_name ="public"
     * @param type $value
     * @param type $key
     */
    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public == "" ? 1 : $this->public, $this->table_fields, $key);
    }

    /**
     * customer session id - int(11)
     * table_columb_name ="users_id"
     * @param type $value
     * @param type $key
     */
    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields, $key);
    }

}

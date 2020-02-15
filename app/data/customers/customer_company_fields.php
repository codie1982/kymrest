<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class customer_company_fields extends customer_rule {

    private $customer_id;
    private $company_type;
    private $customer_company_title;
    private $tax_province;
    private $tax_office;
    private $tax_number;
    private $mersisno;
    private $start_day;
    private $start_month;
    private $start_year;
    private $workspace;
    private $description;
    private $date;
    private $public;
    private $customer_company_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "customer_company";
        return true;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_customer_id($customer_id) {
        $this->customer_id = $customer_id;
        data::add("customer_id", $this->customer_id !== "" ? input::santize($this->customer_id) : 0, $this->table_fields);
    }

    public function set_company_type($company_type) {
        $this->company_type = $company_type;
        data::add("company_type", $this->company_type == "" ? "" : input::santize($this->company_type), $this->table_fields);
    }

    public function set_customer_company_title($customer_company_title) {
        $this->customer_company_title = $customer_company_title;
        data::add("customer_company_title", $this->customer_company_title !== "" ? input::santize($this->customer_company_title) : NODATA, $this->table_fields);
    }

    public function set_tax_province($tax_province) {
        $this->tax_province = $tax_province;
        data::add("tax_province", $this->tax_province !== "" ? input::santize($this->tax_province) : 0, $this->table_fields);
    }

    public function set_tax_office($tax_office) {
        $this->tax_office = $tax_office;
        data::add("tax_office", $this->tax_office !== "" ? input::santize($this->tax_office) : 0, $this->table_fields);
    }

    public function set_tax_number($tax_number) {
        $this->tax_number = $tax_number;
        data::add("tax_number", $this->tax_number !== "" ? input::santize($this->tax_number) : 0, $this->table_fields);
    }

    public function set_mersisno($mersisno) {
        $this->mersisno = $mersisno;
        data::add("mersisno", $this->mersisno !== "" ? input::santize($this->mersisno) : NODATA, $this->table_fields);
    }

    public function set_start_day($start_day) {
        $this->start_day = $start_day;
        data::add("start_day", $this->start_day !== "" ? input::santize($this->start_day) : 0, $this->table_fields);
    }

    public function set_start_month($start_month) {
        $this->start_month = $start_month;
        data::add("start_month", $this->start_month !== "" ? input::santize($this->start_month) : 0, $this->table_fields);
    }

    public function set_start_year($start_year) {
        $this->start_year = $start_year;
        data::add("start_year", $this->start_year !== "" ? input::santize($this->start_year) : 0, $this->table_fields);
    }

    public function set_workspace($workspace) {
        $this->workspace = $workspace;
        data::add("workspace", $this->workspace !== "" ? input::santize($this->workspace) : NODATA, $this->table_fields);
    }

    public function set_description($description) {
        $this->description = $description;
        data::add("description", $this->description !== "" ? input::santize($this->description) : NODATA, $this->table_fields);
    }

    public function set_date($date) {
        $this->date = $date;
        data::add("date", $this->date !== "" ? input::santize($this->date) : getNow(), $this->table_fields);
    }

    public function set_public($public) {
        $this->public = $public;
        data::add("public", $this->public !== "" ? input::santize($this->public) : 1, $this->table_fields);
    }

    public function set_customer_company_seccode($customer_company_seccode) {
        $this->customer_company_seccode = $customer_company_seccode;
        data::add("customer_company_seccode", $this->customer_company_seccode !== "" ? $this->customer_company_seccode : seccode(), $this->table_fields);
    }

    public function set_users_id($users_id) {
        $this->users_id = $users_id;
        data::add("users_id", $this->users_id !== "" ? input::santize($this->users_id) : session::get(CURRENT_USER_SESSION_NAME), $this->table_fields);
    }

}

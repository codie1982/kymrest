<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class job_product_price_group_fields extends job_rule {

    private $job_id;
    private $job_products_id;
    private $product_group_title;
    private $date;
    private $job_products_price_group_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "job_product_price_group";
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

    public function set_parent_key($value, $key) {
        $this->parent_key = $value;
        data::add("parent_key", $this->parent_key !== "" ? $this->parent_key : null, $this->table_fields, $key);
    }

    public function set_job_id($value, $key) {
        $this->job_id = $value;
        data::add("job_id", $this->job_id !== "" ? $this->job_id : 0, $this->table_fields, $key);
    }

    public function set_job_products_id($value, $key) {
        $this->job_products_id = $value;
        data::add("job_products_id", $this->job_products_id !== "" ? $this->job_products_id : 0, $this->table_fields, $key);
    }

    public function set_product_group_title($value, $key) {
        $this->product_group_title = $value;
        data::add("product_group_title", $this->product_group_title !== "" ? $this->product_group_title : NODATA, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date !== "" ? $this->date : getNow(), $this->table_fields, $key);
    }

    public function set_job_products_price_group_seccode($value, $key) {
        $this->job_products_price_group_seccode = $value;
        data::add("job_products_price_group_seccode", $this->job_products_price_group_seccode !== "" ? $this->job_products_price_group_seccode : seccode(), $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id !== NODATA ? $this->users_id : 0, $this->table_fields, $key);
    }

}

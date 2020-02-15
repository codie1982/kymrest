<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class job_products_fields extends job_rule {

    private $job_id;
    private $product_id;
    private $product_type;
    private $customer_id;
    private $product_amount;
    private $product_price_type;
    private $product_price;
    private $product_price_unit;
    private $discount;
    private $discount_type;
    private $discount_rate;
    private $product_sales_price;
    private $payment_method_workable_type;
    private $payment_method;
    private $product_extra_price;
    private $product_extra_price_unit;
    private $product_delivery_workable_type;
    private $product_delivery_type;
    private $product_delivery_price;
    private $product_delivery_price_unit;
    private $product_delivery_price_in;
    private $product_tax_price;
    private $product_tax_price_unit;
    private $product_tax_rate;
    private $product_intax;
    private $public;
    private $admin_public;
    private $date;
    private $job_products_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "job_products";
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

    public function set_product_id($value, $key) {
        $this->product_id = $value;
        data::add("product_id", $this->product_id !== "" ? $this->product_id : 0, $this->table_fields, $key);
    }

    public function set_product_type($value, $key) {
        $this->product_type = $value;
        data::add("product_type", $this->product_type == "" ? "standart" : $this->product_type, $this->table_fields, $key);
    }

    public function set_customer_id($value, $key) {
        $this->customer_id = $value;
        data::add("customer_id", $this->customer_id !== "" ? $this->customer_id : 0, $this->table_fields, $key);
    }

    public function set_amount($value, $key) {
        $this->amount = $value;
        data::add("amount", $this->amount !== "" ? $this->amount : 0, $this->table_fields, $key);
    }

    public function set_product_amount($value, $key) {
        $this->product_amount = $value;
        data::add("product_amount", $this->product_amount !== "" ? $this->product_amount : 0, $this->table_fields, $key);
    }

    public function set_product_price_type($value, $key) {
        $this->product_price_type = $value;
        data::add("product_price_type", $this->product_price_type !== "" ? $this->product_price_type : "flat", $this->table_fields, $key);
    }

    public function set_product_price($value, $key) {
        $this->product_price = $value;
        data::add("product_price", $this->product_price !== "" ? $this->product_price : 0, $this->table_fields, $key);
    }

    public function set_product_price_unit($value, $key) {
        $this->product_price_unit = $value;
        data::add("product_price_unit", $this->product_price_unit !== "" ? $this->product_price_unit : default_currency(), $this->table_fields, $key);
    }

    public function set_discount($value, $key) {
        $this->discount = $value;
        data::add("discount", $this->discount !== "" ? $this->discount : 0, $this->table_fields, $key);
    }

    public function set_discount_type($value, $key) {
        $this->discount_type = $value;
        data::add("discount_type", $this->discount_type !== "" ? $this->discount_type : "rate", $this->table_fields, $key);
    }

    public function set_discount_rate($value, $key) {
        $this->discount_rate = $value;
        data::add("discount_rate", $this->discount_rate !== "" ? $this->discount_rate : 0, $this->table_fields, $key);
    }

    public function set_product_sales_price($value, $key) {
        $this->product_sales_price = $value;
        data::add("product_sales_price", $this->product_sales_price == "" ? 0 : $this->product_sales_price, $this->table_fields, $key);
    }

    public function set_product_delivery_workable_type($value, $key) {
        $this->product_delivery_workable_type = $value;
        data::add("product_delivery_workable_type", $this->product_delivery_workable_type !== "" ? $this->product_delivery_workable_type : "constant", $this->table_fields, $key);
    }

    public function set_product_delivery_type($value, $key) {
        $this->product_delivery_type = $value;
        data::add("product_delivery_type", $this->product_delivery_type !== "" ? $this->product_delivery_type : NODATA, $this->table_fields, $key);
    }

    public function set_product_delivery_price($value, $key) {
        $this->product_delivery_price = $value;
        data::add("product_delivery_price", $this->product_delivery_price !== "" ? $this->product_delivery_price : 0, $this->table_fields, $key);
    }

    public function set_product_delivery_price_unit($value, $key) {
        $this->product_delivery_price_unit = $value;
        data::add("product_delivery_price_unit", $this->product_delivery_price_unit !== "" ? $this->product_delivery_price_unit : default_currency(), $this->table_fields, $key);
    }

    public function set_product_delivery_price_in($value, $key) {
        $this->product_delivery_price_in = $value;
        data::add("product_delivery_price_in", $this->product_delivery_price_in !== "" ? $this->product_delivery_price_in : 0, $this->table_fields, $key);
    }

    public function set_product_tax_price($value, $key) {
        $this->product_tax_price = $value;
        data::add("product_tax_price", $this->product_tax_price !== "" ? $this->product_tax_price : 0, $this->table_fields, $key);
    }

    public function set_product_tax_price_unit($value, $key) {
        $this->product_tax_price_unit = $value;
        data::add("product_tax_price_unit", $this->product_tax_price_unit !== "" ? $this->product_tax_price_unit : default_currency(), $this->table_fields, $key);
    }

    public function set_product_tax_rate($value, $key) {
        $this->product_tax_rate = $value;
        data::add("product_tax_rate", $this->product_tax_rate !== "" ? $this->product_tax_rate : 0, $this->table_fields, $key);
    }

    public function set_product_intax($value, $key) {
        $this->product_intax = $value;
        data::add("product_intax", $this->product_intax !== "" ? $this->product_intax : 0, $this->table_fields, $key);
    }

    public function set_payment_method_workable_type($value, $key) {
        $this->payment_method_workable_type = $value;
        data::add("payment_method_workable_type", $this->payment_method_workable_type !== "" ? $this->payment_method_workable_type : "constant", $this->table_fields, $key);
    }

    public function set_payment_method($value, $key) {
        $this->payment_method = $value;
        data::add("payment_method", $this->payment_method !== "" ? $this->payment_method : NODATA, $this->table_fields, $key);
    }

    public function set_product_extra_price($value, $key) {
        $this->product_extra_price = $value;
        data::add("product_extra_price", $this->product_extra_price !== "" ? $this->product_extra_price : 0, $this->table_fields, $key);
    }

    public function set_product_extra_price_unit($value, $key) {
        $this->product_extra_price_unit = $value;
        data::add("product_extra_price_unit", $this->product_extra_price_unit !== "" ? $this->product_extra_price_unit : default_currency(), $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public !== "" ? $this->public : 1, $this->table_fields, $key);
    }

    public function set_admin_public($value, $key) {
        $this->admin_public = $value;
        data::add("admin_public", $this->admin_public !== "" ? $this->admin_public : 1, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        $this->date = $value;
        data::add("date", $this->date !== "" ? $this->date : getNow(), $this->table_fields, $key);
    }

    public function set_job_products_seccode($value, $key) {
        $this->job_products_seccode = $value;
        data::add("job_products_seccode", $this->job_products_seccode !== "" ? $this->job_products_seccode : seccode(), $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields, $key);
    }

}

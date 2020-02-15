<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_product_fields extends settings_product_rule {

    public $product_sub_title;
    public $product_code;
    public $product_flat_price;
    public $product_cost_price;
    public $product_options_price;
    public $product_default_currency;
    public $product_unit_list;
    public $product_sales_anchor;
    public $product_sales_threshold;
    public $product_sales_threshold_type;
    public $product_sales_threshold_amount;
    public $transport_fields_workable_type;
    public $extra_field_workable_type;
   
    public $product_extra_anchor;
    public $product_extra_threshold;
    public $product_extra_threshold_type;
    public $product_extra_threshold_amount;
    public $product_cargo_anchor;
    public $product_cargo_function;
    public $product_cargo_threshold;
    public $product_cargo_threshold_type;
    public $product_cargo_threshold_amount;

    public function __construct() {
        $this->table_fields = "settings_product";

        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_prepare($value) {
        $this->prepare = 1;
        data::add("prepare", $this->prepare, $this->table_fields);
    }

    public function set_product_sub_title($value) {
        $this->product_sub_title = $value;
        data::add("product_sub_title", $this->product_sub_title == "" ? 0 : $this->product_sub_title, $this->table_fields);
    }

    public function set_product_code($value) {
        $this->product_code = $value;
        data::add("product_code", $this->product_code == "" ? 0 : $this->product_code, $this->table_fields);
    }

    public function set_product_flat_price($value) {
        $this->product_flat_price = $value;
        data::add("product_flat_price", $this->product_flat_price, $this->table_fields);
    }

    public function set_product_cost_price($value) {
        $this->product_cost_price = $value;
        data::add("product_cost_price", $this->product_cost_price, $this->table_fields);
    }

    public function set_product_options_price($value) {
        $this->product_options_price = $value;
        data::add("product_options_price", $this->product_options_price, $this->table_fields);
    }

    public function set_product_default_currency($value) {
        $this->product_default_currency = $value;
        data::add("product_default_currency", $this->product_default_currency == "" ? "tl" : $this->product_default_currency, $this->table_fields);
    }

    public function set_product_unit_list($value) {
        $this->product_unit_list = $value;
        data::add("product_unit_list", $this->product_unit_list == "" ? NODATA : $this->product_unit_list, $this->table_fields);
    }

    public function set_product_sales_anchor($value) {
        $this->product_sales_anchor = $value;
        data::add("product_sales_anchor", $this->product_sales_anchor, $this->table_fields);
    }

    public function set_product_sales_threshold($value) {
        $this->product_sales_threshold = $value;
        data::add("product_sales_threshold", $this->product_sales_threshold, $this->table_fields);
    }

    public function set_product_sales_threshold_type($value) {
        $this->product_sales_threshold_type = $value;
        data::add("product_sales_threshold_type", $this->product_sales_threshold_type, $this->table_fields);
    }

    public function set_product_sales_threshold_amount($value) {
        $this->product_sales_threshold_amount = $value;
        data::add("product_sales_threshold_amount", $this->product_sales_threshold_amount == "" ? 0 : $this->product_sales_threshold_amount, $this->table_fields);
    }

  

    public function set_transport_fields_workable_type($value) {
        $this->transport_fields_workable_type = $value;
        data::add("transport_fields_workable_type", $this->transport_fields_workable_type, $this->table_fields);
    }

   
    public function set_product_extra_anchor($value) {
        $this->product_extra_anchor = $value;
        data::add("product_extra_anchor", $this->product_extra_anchor, $this->table_fields);
    }

    public function set_product_extra_threshold($value) {
        $this->product_extra_threshold = $value;
        data::add("product_extra_threshold", $this->product_extra_threshold, $this->table_fields);
    }

    public function set_product_extra_threshold_type($value) {
        $this->product_extra_threshold_type = $value;
        data::add("product_extra_threshold_type", $this->product_extra_threshold_type, $this->table_fields);
    }

    public function set_product_extra_threshold_amount($value) {
        $this->product_extra_threshold_amount = $value;
        data::add("product_extra_threshold_amount", $this->product_extra_threshold_amount, $this->table_fields);
    }

    public function set_product_cargo_anchor($value) {
        $this->product_cargo_anchor = $value;
        data::add("product_cargo_anchor", $this->product_cargo_anchor, $this->table_fields);
    }

    public function set_product_cargo_function($value) {
        $this->product_cargo_function = $value;
        data::add("product_cargo_function", $this->product_cargo_function, $this->table_fields);
    }

    public function set_product_cargo_threshold($value) {
        $this->product_cargo_threshold = $value;
        data::add("product_cargo_threshold", $this->product_cargo_threshold, $this->table_fields);
    }

    public function set_product_cargo_threshold_type($value) {
        $this->product_cargo_threshold_type = $value;
        data::add("product_cargo_threshold_type", $this->product_cargo_threshold_type, $this->table_fields);
    }

    public function set_product_cargo_threshold_amount($value) {
        $this->product_cargo_threshold_amount = $value;
        data::add("product_cargo_threshold_amount", $this->product_cargo_threshold_amount, $this->table_fields);
    }

}

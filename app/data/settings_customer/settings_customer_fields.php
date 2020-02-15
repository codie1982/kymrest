<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_customer_fields extends settings_customer_rule {

    private $customer_tag;
    private $supermen_tag;

    public function __construct() {
        $this->table_fields = "settings_customer";
        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_customer_tag($customer_tag) {
        $this->customer_tag = $customer_tag;
        data::add("customer_tag", $this->customer_tag == "" ? NODATA : $this->customer_tag, $this->table_fields);
    }

    public function set_supermen_tag($value) {
        $this->supermen_tag = $value;
        data::add("supermen_tag", $this->supermen_tag !== NODATA ? input::santize($this->supermen_tag) : NODATA, $this->table_fields);
    }

}

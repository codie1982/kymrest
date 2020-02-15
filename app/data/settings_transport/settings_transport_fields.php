<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_transport_fields extends settings_transport_rule {

    public $workable_type;
    public $transport_price;
    public $transport_price_unit;
    public $no_transport;
    public $cargo;
    public $cargo_price;
    public $cargo_price_unit;
    public $cargo_in;
    public $cargo_web;
    public $cargo_application;
    public $messenger;
    public $messenger_price;
    public $messenger_price_unit;
    public $messenger_in;
    public $messenger_web;
    public $messenger_application;
    public $transport_truck;
    public $transport_location_price;
    public $transport_truck_price;
    public $transport_truck_price_unit;
    public $transport_truck_in;
    public $transport_truck_web;
    public $transport_truck_application;
    public $transport_price_type;
    public $transport_anchor_threshold;
    public $transport_anchor_type;
    public $transport_anchor_value;

    public function __construct() {
        $this->table_fields = "settings_transport";

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

//    public function set_workable_type($value) {
//        $nproduct_constant = new product_constant();
//        if ($value == $nproduct_constant::constant || $value == $nproduct_constant::changeable) {
//            $this->workable_type = $value;
//            data::add("workable_type", $this->workable_type == "" ? $nproduct_constant::constant : $this->workable_type, $this->table_fields);
//        } else {
//            data::add("workable_type", $nproduct_constant::constant, $this->table_fields);
//        }
//    }

    public function set_transport_price($value) {
        $this->transport_price = $value;
        data::add("transport_price", $this->transport_price == "" ? 0 : $this->transport_price, $this->table_fields);
    }

    public function set_transport_price_unit($value) {
        $this->transport_price_unit = $value;
        data::add("transport_price_unit", $this->transport_price_unit == "" ? 0 : $this->transport_price_unit, $this->table_fields);
    }

    public function set_no_transport($value) {
        $this->no_transport = $value;
        data::add("no_transport", $this->no_transport == "" ? 0 : $this->transport_type, $this->table_fields);
    }

    public function set_cargo($value) {
        $this->cargo = $value;
        data::add("cargo", $this->cargo !== "" ? $this->cargo : 0, $this->table_fields);
    }

    public function set_cargo_price($value) {
        $this->cargo_price = $value;
        data::add("cargo_price", $this->cargo_price !== "" ? $this->cargo_price : 0, $this->table_fields);
    }

    public function set_cargo_price_unit($value) {
        $this->cargo_price_unit = $value;
        data::add("cargo_price_unit", $this->cargo_price_unit !== "" ? $this->cargo_price_unit : default_currency(), $this->table_fields);
    }

    public function set_cargo_in($value) {
        $this->cargo_in = $value;
        data::add("cargo_in", $this->cargo_in !== "" ? $this->cargo_in : 0, $this->table_fields);
    }

    public function set_cargo_web($value) {
        $this->cargo_web = $value;
        data::add("cargo_web", $this->cargo_web !== "" ? $this->cargo_web : 0, $this->table_fields);
    }

    public function set_cargo_application($value) {
        $this->cargo_application = $value;
        data::add("cargo_application", $this->cargo_application !== "" ? $this->cargo_application : 0, $this->table_fields);
    }

    public function set_messenger($value) {
        $this->messenger = $value;
        data::add("messenger", $this->messenger !== "" ? $this->messenger : 0, $this->table_fields);
    }

    public function set_messenger_price($value) {
        $this->messenger_price = $value;
        data::add("messenger_price", $this->messenger_price !== "" ? $this->messenger_price : 0, $this->table_fields);
    }

    public function set_messenger_price_unit($value) {
        $this->messenger_price_unit = $value;
        data::add("messenger_price_unit", $this->messenger_price_unit !== "" ? $this->messenger_price_unit : default_currency(), $this->table_fields);
    }

    public function set_messenger_in($value) {
        $this->messenger_in = $value;
        data::add("messenger_in", $this->messenger_in !== "" ? $this->messenger_in : 0, $this->table_fields);
    }

    public function set_messenger_web($value) {
        $this->messenger_web = $value;
        data::add("messenger_web", $this->messenger_web !== "" ? $this->messenger_web : 0, $this->table_fields);
    }

    public function set_messenger_application($value) {
        $this->messenger_application = $value;
        data::add("messenger_application", $this->messenger_application !== "" ? $this->messenger_application : 0, $this->table_fields);
    }

    public function set_transport_truck($value) {
        $this->transport_truck = $value;
        data::add("transport_truck", $this->transport_truck !== "" ? $this->transport_truck : 0, $this->table_fields);
    }

    public function set_transport_truck_price($value) {
        $this->transport_truck_price = $value;
        data::add("transport_truck_price", $this->transport_truck_price !== "" ? $this->transport_truck_price : 0, $this->table_fields);
    }

    public function set_transport_truck_price_unit($value) {
        $this->transport_truck_price_unit = $value;
        data::add("transport_truck_price_unit", $this->transport_truck_price_unit !== "" ? $this->transport_truck_price_unit : default_currency(), $this->table_fields);
    }

    public function set_transport_truck_in($value) {
        $this->transport_truck_in = $value;
        data::add("transport_truck_in", $this->transport_truck_in !== "" ? $this->transport_truck_in : 0, $this->table_fields);
    }

    public function set_transport_truck_web($value) {
        $this->transport_truck_web = $value;
        data::add("transport_truck_web", $this->transport_truck_web !== "" ? $this->transport_truck_web : 0, $this->table_fields);
    }

    public function set_transport_truck_application($value) {
        $this->transport_truck_application = $value;
        data::add("transport_truck_application", $this->transport_truck_application !== "" ? $this->transport_truck_application : 0, $this->table_fields);
    }

    public function set_transport_location_price($value) {
        $this->transport_location_price = $value;
        data::add("transport_location_price", $this->transport_location_price !== "" ? $this->transport_location_price : 0, $this->table_fields);
    }

    public function set_transport_price_type($value) {
        $this->transport_price_type = $value;
        data::add("transport_price_type", $this->transport_price_type == "" ? "product" : $this->transport_price_type, $this->table_fields);
    }

    public function set_transport_anchor_threshold($value) {
        $this->transport_anchor_threshold = $value;
        data::add("transport_anchor_threshold", $this->transport_anchor_threshold, $this->table_fields);
    }

    public function set_transport_anchor_type($value) {
        $nproduct_constant = new product_constant();
        $this->transport_anchor_type = $value;
        data::add("transport_anchor_type", $this->transport_anchor_type == "" ? $nproduct_constant::rate : $this->transport_anchor_type, $this->table_fields);
    }

    public function set_transport_anchor_value($value) {
        $this->transport_anchor_value = $value;
        data::add("transport_anchor_value", $this->transport_anchor_value == "" ? 0 : $this->transport_anchor_value, $this->table_fields);
    }

}

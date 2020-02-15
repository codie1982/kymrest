<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class job_fields extends job_rule {

    private $customer_id;
    private $start_date;
    private $end_date;
    private $job_seccode;
    private $date;
    private $customer_confirm_date;
    private $job_status;
    private $public;
    private $admin_public;
    private $confirm;
    private $confirm_date;
    private $prepare;
    private $prepare_date;
    private $job_delivery_time;
    private $complete;
    private $complete_date;
    private $job_price;
    private $job_price_unit;
    private $job_price_discount;
    private $job_payment_method;
    private $job_payment_method_options;
    private $job_extra_price;
    private $job_extra_price_discount;
    private $job_delivery_price;
    private $job_delivery_price_discount;
    private $job_tax_price;
    private $job_tax_price_discount;
    private $job_total_price;
    private $job_total_price_discount;
    private $product_settings;
    private $product_currency;
    private $return_request;
    private $return_request_date;
    private $return;
    private $return_date;
    private $customer_adres_id;
    private $customer_phone_id;
    private $delivery;
    private $delivery_date;
    private $delivery_complete;
    private $delivery_complete_date;
    private $job_number;
    private $users_id;
    private $job_note;
    private $view;
    private $admin_view;

    public function __construct() {
        $this->table_fields = "job";
        return true;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_customer_id($value) {
        $this->customer_id = $value;
        data::add("customer_id", $this->customer_id !== "" ? $this->customer_id : 0, $this->table_fields);
    }

    public function set_start_date($value) {
        $this->start_date = $value;
        data::add("start_date", $this->start_date !== "" ? $this->start_date : getNow(), $this->table_fields);
    }

    public function set_end_date($value) {
        $this->end_date = $value;
        data::add("end_date", $this->end_date !== "" ? $this->end_date : getNow(ONE_DAY * 20), $this->table_fields);
    }

    public function set_job_seccode($value) {
        $this->job_seccode = $value;
        data::add("job_seccode", $this->job_seccode !== "" ? $this->job_seccode : NODATA, $this->table_fields);
    }

    public function set_date($value) {
        $this->date = $value;
        data::add("date", $this->date !== "" ? $this->date : getNow(), $this->table_fields);
    }

    public function set_customer_confirm_date($value) {
        $this->customer_confirm_date = $value;
        data::add("customer_confirm_date", $this->customer_confirm_date !== "" ? $this->customer_confirm_date : getNow(), $this->table_fields);
    }

    public function set_job_status($value) {
        $this->job_status = $value;
        data::add("job_status", $this->job_status !== "" ? $this->job_status : 0, $this->table_fields);
    }

    public function set_public($value) {
        $this->public = $value;
        data::add("public", $this->public !== "" ? $this->public : 1, $this->table_fields);
    }

    public function set_admin_public($value) {
        $this->admin_public = $value;
        data::add("admin_public", $this->admin_public != "" ? $this->admin_public : 1, $this->table_fields);
    }

    public function set_confirm($value) {
        $this->confirm = $value;
        data::add("confirm", $this->confirm !== "" ? $this->confirm : 0, $this->table_fields);
    }

    public function set_confirm_date($value) {
        $this->confirm_date = $value;
        data::add("confirm_date", $this->confirm_date !== "" ? $this->confirm_date : NOTIME, $this->table_fields);
    }

    public function set_prepare($value) {
        $this->prepare = $value;
        data::add("prepare", $this->prepare !== "" ? $this->prepare : 0, $this->table_fields);
    }

    public function set_prepare_date($value) {
        $this->prepare_date = $value;
        data::add("prepare_date", $this->prepare_date !== "" ? $this->prepare_date : NOTIME, $this->table_fields);
    }

    public function set_job_delivery_time($value) {
        $this->job_delivery_time = $value;
        data::add("job_delivery_time", $this->job_delivery_time !== "" ? $this->job_delivery_time : getNow(86400), $this->table_fields);
    }

    public function set_complete($value) {
        $this->complete = $value;
        data::add("complete", $this->complete !== "" ? $this->complete : 0, $this->table_fields);
    }

    public function set_complete_date($value) {
        $this->complete_date = $value;
        data::add("complete_date", $this->complete_date !== "" ? $this->complete_date : NOTIME, $this->table_fields);
    }

    public function set_job_price($value) {
        $this->job_price = $value;
        data::add("job_price", $this->job_price !== "" ? $this->job_price : 0, $this->table_fields);
    }

    public function set_job_price_unit($value) {
        $this->job_price_unit = $value;
        data::add("job_price_unit", $this->job_price_unit !== "" ? $this->job_price_unit : default_currency(), $this->table_fields);
    }

    public function set_job_price_discount($value) {
        $this->job_price_discount = $value;
        data::add("job_price_discount", $this->job_price_discount !== "" ? $this->job_price_discount : 0, $this->table_fields);
    }

    public function set_job_payment_method($value) {
        $this->job_payment_method = $value;
        data::add("job_payment_method", $this->job_payment_method !== "" ? $this->job_payment_method : 0, $this->table_fields);
    }

    public function set_job_payment_method_options($value) {
        $this->job_payment_method_options = $value;
        data::add("job_payment_method_options", $this->job_payment_method_options !== "" ? $this->job_payment_method_options : NODATA, $this->table_fields);
    }

    public function set_job_extra_price($value) {
        $this->job_extra_price = $value;
        data::add("job_extra_price", $this->job_extra_price !== "" ? $this->job_extra_price : 0, $this->table_fields);
    }

    public function set_job_extra_price_discount($value) {
        $this->job_extra_price_discount = $value;
        data::add("job_extra_price_discount", $this->job_extra_price_discount !== "" ? $this->job_extra_price_discount : 0, $this->table_fields);
    }

    public function set_job_delivery_price($value) {
        $this->job_delivery_price = $value;
        data::add("job_delivery_price", $this->job_delivery_price !== "" ? $this->job_delivery_price : 0, $this->table_fields);
    }

    public function set_job_delivery_price_discount($value) {
        $this->job_delivery_price_discount = $value;
        data::add("job_delivery_price_discount", $this->job_delivery_price_discount !== "" ? $this->job_delivery_price_discount : 0, $this->table_fields);
    }

    public function set_job_tax_price($value) {
        $this->job_tax_price = $value;
        data::add("job_tax_price", $this->job_tax_price !== "" ? $this->job_tax_price : 0, $this->table_fields);
    }

    public function set_job_tax_price_discount($value) {
        $this->job_tax_price_discount = $value;
        data::add("job_tax_price_discount", $this->job_tax_price_discount !== "" ? $this->job_tax_price_discount : 0, $this->table_fields);
    }

    public function set_job_total_price($value) {
        $this->job_total_price = $value;
        data::add("job_total_price", $this->job_total_price !== "" ? $this->job_total_price : 0, $this->table_fields);
    }

    public function set_job_total_price_discount($value) {
        $this->job_total_price_discount = $value;
        data::add("job_total_price_discount", $this->job_total_price_discount !== "" ? $this->job_total_price_discount : 0, $this->table_fields);
    }

    public function set_product_settings($value) {
        $this->product_settings = $value;
        data::add("product_settings", $this->product_settings !== "" ? $this->product_settings : 0, $this->table_fields);
    }

    public function set_product_currency($value) {
        $this->product_currency = $value;
        data::add("product_currency", $this->product_currency !== "" ? $this->product_currency : default_currency(), $this->table_fields);
    }

    public function set_return_request($value) {
        $this->return_request = $value;
        data::add("return_request", $this->return_request !== "" ? $this->return_request : 0, $this->table_fields);
    }

    public function set_return_request_date($value) {
        $this->return_request_date = $value;
        data::add("return_request_date", $this->return_request_date !== "" ? $this->return_request_date : NOTIME, $this->table_fields);
    }

    public function set_return($value) {
        $this->return = $value;
        data::add("return", $this->return !== "" ? $this->return : 0, $this->table_fields);
    }

    public function set_return_date($value) {
        $this->return_date = $value;
        data::add("return_date", $this->return_date !== "" ? $this->return_date : NOTIME, $this->table_fields);
    }

    public function set_customer_adres_id($value) {
        $this->customer_adres_id = $value;
        data::add("customer_adres_id", $this->customer_adres_id !== "" ? $this->customer_adres_id : 0, $this->table_fields);
    }

    public function set_customer_phone_id($value) {
        $this->customer_phone_id = $value;
        data::add("customer_phone_id", $this->customer_phone_id !== "" ? $this->customer_phone_id : 0, $this->table_fields);
    }

    public function set_delivery($value) {
        $this->delivery = $value;
        data::add("delivery", $this->delivery !== "" ? $this->delivery : 0, $this->table_fields);
    }

    public function set_deliver_date($value) {
        $this->delivery_date = $value;
        data::add("delivery_date", $this->delivery_date !== "" ? $this->delivery_date : NOTIME, $this->table_fields);
    }

    public function set_deliver_complete($value) {
        $this->delivery_complete = $value;
        data::add("delivery_complete", $this->delivery_complete !== "" ? $this->delivery_complete : 0, $this->table_fields);
    }

    public function set_deliver_complete_date($value) {
        $this->delivery_complete_date = $value;
        data::add("delivery_complete_date", $this->delivery_complete_date !== "" ? $this->delivery_complete_date : NOTIME, $this->table_fields);
    }

    public function set_job_number($value) {
        $this->job_number = $value;
        data::add("job_number", $this->job_number !== "" ? $this->job_number : -1, $this->table_fields);
    }

    public function set_payment_rate($value) {
        $this->job_number = $value;
        data::add("job_number", $this->job_number !== "" ? $this->job_number : -1, $this->table_fields);
    }

    public function set_job_note($value) {
        $this->job_note = $value;
        data::add("job_note", $this->job_note == "" ? NODATA : sanitize($this->job_note), $this->table_fields);
    }

    public function set_view($value) {
        $this->view = $value;
        data::add("view", $this->view == "" ? 0 : sanitize($this->view), $this->table_fields);
    }

    public function set_admin_view($value) {
        $this->admin_view = $value;
        data::add("admin_view", $this->admin_view == "" ? 0 : sanitize($this->admin_view), $this->table_fields);
    }

    public function set_users_id($value) {
        $this->users_id = $value;
        data::add("users_id", $this->users_id == "" ? session::get(CURRENT_USER_SESSION_NAME) : $this->users_id, $this->table_fields);
    }

}

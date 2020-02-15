<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class settings_job_fields extends settings_job_rule {

    private $complete_time;
    private $card_time;
    private $time_threshold;
    private $time_threshold_hour;
    private $time_threshold_minute;
    private $user_job_limit;
    private $max_job_count;
    private $job_time_limit;
    private $user_last_job_hour;
    private $user_last_job_minute;
    private $user_first_job_hour;
    private $user_first_job_minute;
    private $job_prepare_workable;
    private $prepare_time;
    private $prepare_time_type;
    private $delivery_time_select_byuser;
    private $job_limit_delivery_location;
    private $date;
    public $extra_field_workable_type;
    public $credicart;
    public $credicart_extra_price;
    public $atthedoor_price;
    public $atthedoor_price_unit;
    public $credicart_price;
    public $credicart_price_unit;
    public $atthedoor;
    public $atthedoor_options;
    public $atthedoor_extra_price;
    public $bank;
    public $bank_extra_price;
    public $bank_price;
    public $bank_price_unit;
    public $inplace;
    public $inplace_extra_price;
    public $inplace_price;
    public $inplace_price_unit;
    public $product_extra_function;

    public function __construct() {
        $this->table_fields = "settings_jobs";
        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_complete_time($complete_time) {
        $this->complete_time = $complete_time;
        data::add("complete_time", $this->complete_time == "" ? 1 : $this->complete_time, $this->table_fields);
    }

    public function set_card_time($card_time) {
        $this->card_time = $card_time;
        data::add("card_time", $this->card_time == "" ? 0 : $this->card_time, $this->table_fields);
    }

    public function set_time_threshold($time_threshold) {
        $this->time_threshold = $time_threshold;
        data::add("time_threshold", $this->time_threshold == "" ? 0 : $this->time_threshold, $this->table_fields);
    }

    public function set_time_threshold_hour($time_threshold_hour) {
        $this->time_threshold_hour = $time_threshold_hour;
        data::add("time_threshold_hour", $this->time_threshold_hour == "" ? 0 : $this->time_threshold_hour, $this->table_fields);
    }

    public function set_time_threshold_minute($time_threshold_minute) {
        $this->time_threshold_minute = $time_threshold_minute;
        data::add("time_threshold_minute", $this->time_threshold_minute == "" ? 0 : $this->time_threshold_minute, $this->table_fields);
    }

    public function set_user_job_limit($user_job_limit) {
        $this->user_job_limit = $user_job_limit;
        data::add("user_job_limit", $this->user_job_limit == "" ? 0 : $this->user_job_limit, $this->table_fields);
    }

    public function set_max_job_count($max_job_count) {
        $this->max_job_count = $max_job_count;
        data::add("max_job_count", $this->max_job_count == "" ? 0 : $this->max_job_count, $this->table_fields);
    }

    public function set_job_time_limit($job_time_limit) {
        $this->job_time_limit = $job_time_limit;
        data::add("job_time_limit", $this->job_time_limit == "" ? 0 : $this->job_time_limit, $this->table_fields);
    }

    public function set_user_first_job_hour($user_last_job_hour) {
        $this->user_first_job_hour = $user_last_job_hour;
        data::add("user_first_job_hour", $this->user_first_job_hour == "" ? 0 : $this->user_first_job_hour, $this->table_fields);
    }

    public function set_user_first_job_minute($user_first_job_minute) {
        $this->user_first_job_minute = $user_first_job_minute;
        data::add("user_first_job_minute", $this->user_first_job_minute == "" ? 0 : $this->user_first_job_minute, $this->table_fields);
    }

    public function set_user_last_job_hour($user_last_job_hour) {
        $this->user_last_job_hour = $user_last_job_hour;
        data::add("user_last_job_hour", $this->user_last_job_hour == "" ? 0 : $this->user_last_job_hour, $this->table_fields);
    }

    public function set_user_last_job_minute($user_last_job_minute) {
        $this->user_last_job_minute = $user_last_job_minute;
        data::add("user_last_job_minute", $this->user_last_job_minute == "" ? 0 : $this->user_last_job_minute, $this->table_fields);
    }

    public function set_job_prepare_workable($job_prepare_workable) {
        $this->job_prepare_workable = $job_prepare_workable;
        data::add("job_prepare_workable", $this->job_prepare_workable == "" ? "constant" : $this->job_prepare_workable, $this->table_fields);
    }

    public function set_prepare_time($prepare_time) {
        $this->prepare_time = $prepare_time;
        data::add("prepare_time", $this->prepare_time == "" ? 0 : $this->prepare_time, $this->table_fields);
    }

    public function set_prepare_time_type($prepare_time_type) {
        $this->prepare_time_type = $prepare_time_type;
        data::add("prepare_time_type", $this->prepare_time_type == "" ? "minute" : $this->prepare_time_type, $this->table_fields);
    }

    public function set_delivery_time_select_byuser($delivery_time_select_byuser) {
        $this->delivery_time_select_byuser = $delivery_time_select_byuser;
        data::add("delivery_time_select_byuser", $this->delivery_time_select_byuser == "" ? 0 : $this->delivery_time_select_byuser, $this->table_fields);
    }

    public function set_job_limit_delivery_location($job_limit_delivery_location) {
        $this->job_limit_delivery_location = $job_limit_delivery_location;
        data::add("job_limit_delivery_location", $this->job_limit_delivery_location == "" ? 0 : $this->job_limit_delivery_location, $this->table_fields);
    }

    public function set_date($date) {
        $this->date = $date;
        data::add("date", $this->date == "" ? getNow() : $this->date, $this->table_fields);
    }

    public function set_credicart($value) {
        $this->credicart = $value;
        data::add("credicart", $this->credicart == "" ? 0 : $this->credicart, $this->table_fields);
    }

    public function set_credicart_price($value) {
        $this->credicart_price = $value;
        data::add("credicart_price", $this->credicart_price == "" ? 0 : $this->credicart_price, $this->table_fields);
    }

    public function set_credicart_price_unit($value) {
        $this->credicart_price_unit = $value;
        data::add("credicart_price_unit", $this->credicart_price_unit == "" ? 0 : $this->credicart_price_unit, $this->table_fields);
    }

    public function set_atthedoor_options($value) {
        $this->atthedoor_options = $value;
        data::add("atthedoor_options", $this->atthedoor_options == "" ? NODATA : $this->atthedoor_options, $this->table_fields);
    }

    public function set_atthedoor($value) {
        $this->atthedoor = $value;
        data::add("atthedoor", $this->atthedoor == "" ? 0 : $this->atthedoor, $this->table_fields);
    }

    public function set_atthedoor_price($value) {
        $this->atthedoor_price = $value;
        data::add("atthedoor_price", $this->atthedoor_price == "" ? 0 : $this->atthedoor_price, $this->table_fields);
    }

    public function set_atthedoor_price_unit($value) {
        $this->atthedoor_price_unit = $value;
        data::add("atthedoor_price_unit", $this->atthedoor_price_unit == "" ? "tl" : $this->atthedoor_price_unit, $this->table_fields);
    }

    public function set_bank($value) {
        $this->bank = $value;
        data::add("bank", $this->bank == "" ? 0 : $this->bank, $this->table_fields);
    }

    public function set_bank_price($value) {
        $this->bank_price = $value;
        data::add("bank_price", $this->bank == "" ? 0 : $this->bank, $this->table_fields);
    }

    public function set_bank_price_unit($value) {
        $this->bank_price_unit = $value;
        data::add("bank_price_unit", $this->bank == "" ? "tl" : $this->bank, $this->table_fields);
    }

    public function set_inplace($value) {
        $this->inplace = $value;
        data::add("inplace", $this->inplace == "" ? 0 : $this->inplace, $this->table_fields);
    }

    public function set_inplace_price($value) {
        $this->inplace_price = $value;
        data::add("inplace_price", $this->inplace_price == "" ? 0 : $this->inplace_price, $this->table_fields);
    }

    public function set_inplace_price_unit($value) {
        $this->inplace_price_unit = $value;
        data::add("inplace_price_unit", $this->inplace_price == "" ? "tl" : $this->inplace_price, $this->table_fields);
    }

    public function set_product_extra_function($value) {
        $this->product_extra_function = $value;
        data::add("product_extra_function", $this->product_extra_function == "" ? "product" : $this->product_extra_function, $this->table_fields);
    }

}

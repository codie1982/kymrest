<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class product_fields extends product_rule {

    public $product_settings;
    public $product_title;
    public $product_name_sef;
    public $product_sub_title;
    public $product_category;
    public $special_fields_value;
    public $product_code;
    public $product_cost;
    public $product_cost_unit;
    public $product_flat_price_productunit;
    public $product_price_type;
    public $product_price;
    public $product_flat_price;
    public $product_flat_price_unit;
    public $product_price_unit;
    public $product_discount_type;
    public $product_discount_price;
    public $product_tax_zone;
    public $product_intax;
    public $product_delivey_time;
    public $product_nostock;
    public $product_stock;
    public $payment_method = array();
    public $_payment_method = array();
    public $product_type;
    public $product_description;
    public $product_keywords;
    public $date;
    public $product_seccode;
    public $users_id;

    public function __construct() {
        $this->table_fields = "product";
        $nproduct_settings = new table_settings_product();
        $this->product_settings = $nproduct_settings->getProductSettings();
        return true;
    }

    public function get_table_fields() {
        return $this->table_fields;
    }

    public function set_primary_key($value) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields);
    }

    public function set_product_name($value) {

        $pattern = '/[a-zA-Z0-9\ş\ç\ö\ğ\ü\ı\Ş\Ç\Ö\Ğ\Ü\İ\s\-\.\,]+/';
        preg_match_all($pattern, $value, $output);
        $this->product_title = $output[0][0];

        data::add("product_name", $this->product_title == "" ? NODATA : strtolower(input::santize($this->product_title)), $this->table_fields);
        data::add("product_name_sef", sef_link($this->product_title), $this->table_fields);
    }

    public function set_product_name_sef($value) {
        return true;
    }

    public function set_product_sub_name($value) {
        $pattern = '/[a-zA-Z0-9\ş\ç\ö\ğ\ü\ı\Ş\Ç\Ö\Ğ\Ü\İ\s\.\-\,]+/';
        preg_match_all($pattern, $value, $output);
        $this->product_sub_title = $output[0][0];
        if ($this->product_settings->product_sub_title == 1) {
            data::add("product_sub_name", $this->product_sub_title == "" ? NODATA : strtolower(input::santize($this->product_sub_title)), $this->table_fields);
        } else {
            data::add("product_sub_name", NODATA);
        }
    }

//    public function set_product_category($value) {
//        $this->product_category = $value;
//        data::add("product_category", $this->product_category == "" ? 0 : $this->product_category, $this->table_fields);
//    }

    public function set_special_fields_value($value) {
        $this->special_fields_value = $value;
        data::add("special_fields_value", isset($value) ? implode(trim(DEFAULT_SEPERATOR), $this->special_fields_value) : 0, $this->table_fields);
    }

    public function set_favorite($value) {
        $this->favorite = $value;
        data::add("favorite", $this->favorite == "" ? 0 : $this->favorite, $this->table_fields);
    }

    public function set_product_code($value) {
        $this->product_code = $value;
        if ($this->product_settings->product_code == 1) {
            data::add("product_code", isset($value) && $this->product_code != "" ? $this->product_code : rand(9999, 99999), $this->table_fields);
        } else {
            data::add("product_code", 0);
        }
    }

    public function set_product_cost($value) {
        $this->product_cost = $value;
        if ($this->product_settings->product_cost_price == 1) {
            data::add("product_cost", isset($value) ? $this->product_cost : 0, $this->table_fields);
        } else {
            data::add("product_cost", 0, $this->table_fields);
        }
    }

    public function set_product_cost_unit($value) {
        $this->product_cost_unit = $value;
        if ($this->product_settings->product_cost_price == 1) {
            data::add("product_cost_unit", isset($value) && $value !== NODATA ? strtolower($this->product_cost_unit) : $this->product_settings->product_default_currency, $this->table_fields);
        } else {
            data::add("product_cost_unit", $this->product_settings->product_default_currency, $this->table_fields);
        }
    }

    public function set_product_price($value) {
        $this->product_price = $value;
        data::add("product_price", isset($value) ? $this->product_price : 0, $this->table_fields);
    }

    public function set_product_price_unit($value) {
        $this->product_cost_unit = $value;
        data::add("product_price_unit", isset($value) && $value !== NODATA ? strtolower($this->product_cost_unit) : $this->product_settings->product_default_currency, $this->table_fields);
    }

    public function set_product_price_type($value) {
        $this->product_price_type = $value;
        data::add("product_price_type", $value == "" ? "flat" : strtolower($this->product_price_type), $this->table_fields);
    }

    public function set_product_discount_type($value) {
        $this->product_discount_type = $value;
        data::add("product_discount_type", isset($value) && $this->product_discount_type !== NODATA && $this->product_discount_type !== "" ? strtolower(input::santize($this->product_discount_type)) : NODATA, $this->table_fields);
    }

    public function set_product_discount_price($value) {
        $this->product_discount_price = $value;
        data::add("product_discount_price", isset($value) ? $this->product_discount_price : 0, $this->table_fields);
    }

    public function set_product_tax_zone($value) {
        $this->product_tax_zone = $value;
        data::add("product_tax_zone", (isset($value) && $this->product_tax_zone != NODATA) ? $this->product_tax_zone : 0, $this->table_fields);
    }

    public function set_product_intax($value) {
        $this->product_intax = $value;
        data::add("product_intax", $value == "" ? 0 : $value, $this->table_fields);
    }

    public function set_product_delivey_time($value) {
        $this->product_delivey_time = $value;
        data::add("product_delivey_time", $this->product_delivey_time, $this->table_fields);
    }

    public function set_product_nostock($value) {
        $this->product_nostock = $value;
        data::add("product_nostock", $value == "" ? 0 : $value, $this->table_fields);
    }

    public function set_product_stock($value) {
        $this->product_stock = $value;
        data::add("product_stock", isset($value) && $this->product_stock != "" ? $this->product_stock : 0, $this->table_fields);
    }

    public function set_product_type($value) {
        $this->product_type = $value;
        data::add("product_type", $this->product_type == "" ? "standart" : $this->product_type, $this->table_fields);
    }

    public function set_product_description($value) {
        $this->product_description = $value;
        data::add("product_description", base64_encode($this->product_description), $this->table_fields);
    }

    public function set_product_keywords($value) {
        $this->product_keywords = $value;
        data::add("product_keywords", isset($value) && $this->product_keywords != "" ? input::santize($this->product_keywords) : NODATA, $this->table_fields);
    }

    public function set_date($value) {
        $this->date = getNow();
        data::add("date", $this->date, $this->table_fields);
    }

    public function set_public($value) {
        $this->public = $value;
        data::add("public", $this->public == "" ? 1 : $this->public, $this->table_fields);
    }

    public function set_product_seccode($value) {
        $this->product_seccode = seccode();
        data::add("product_seccode", $this->product_seccode, $this->table_fields);
    }

    public function set_users_id($value) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id, $this->table_fields);
    }

    /**
     * @return db Değişkenini geriye döndürür();
     */
//    public function getFields() {
//        return $this->fields;
//    }

    /**
     * @param $key
     * @param $value
     * @return db değişkenini hazırlar();
     */
//    public function add($key, $value = null) {
//        return $this->fields[$key] = $value;
//    }
}

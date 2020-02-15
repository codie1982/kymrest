<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category_module
 *
 * @author engin
 */
class prepare_product_data extends data {

    public function __construct() {
        $this->control_tag = "s_product";
        return true;
    }

    public function set_new_product_data($post) {

        data::set_control_module($this->get_control_tag());
        $product_data = $this->seperate_data($post);

//        if (!data::searchfunction("product_intax", $product_data))
//            $product_data[] = ["class" => "product_fields", "function" => "set_product_intax", "parameter" => 0];
//
//        if (!data::searchfunction("product_nostock", $product_data))
//            $product_data[] = ["class" => "product_fields", "function" => "set_product_nostock", "parameter" => 0];

//        $this->data_exec($product_data);
//        $product_settings_data = data::get_data($this->get_control_tag(), "settings_product");
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_product_sub_title", "parameter" => isset($product_settings_data["product_sub_title"]) ? $product_settings_data["product_sub_title"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_product_flat_price", "parameter" => isset($product_settings_data["product_flat_price"]) ? $product_settings_data["product_flat_price"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_product_code", "parameter" => isset($product_settings_data["product_code"]) ? $product_settings_data["product_code"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_product_cost_price", "parameter" => isset($product_settings_data["product_cost_price"]) ? $product_settings_data["product_cost_price"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_product_options_price", "parameter" => isset($product_settings_data["product_options_price"]) ? $product_settings_data["product_options_price"] : 0];
//
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_credicart", "parameter" => isset($product_settings_data["credicart"]) ? $product_settings_data["credicart"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_credicart_price", "parameter" => isset($product_settings_data["credicart_price"]) ? $product_settings_data["credicart_price"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_credicart_price_unit", "parameter" => isset($product_settings_data["credicart_price_unit"]) ? $product_settings_data["credicart_price_unit"] : NODATA];
//
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_atthedoor", "parameter" => isset($product_settings_data["atthedoor"]) ? $product_settings_data["atthedoor"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_atthedoor_price", "parameter" => isset($product_settings_data["atthedoor_price"]) ? $product_settings_data["atthedoor_price"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_atthedoor_price_unit", "parameter" => isset($product_settings_data["atthedoor_price_unit"]) ? $product_settings_data["atthedoor_price_unit"] : NODATA];
//
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_bank", "parameter" => isset($product_settings_data["bank"]) ? $product_settings_data["bank"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_bank_price", "parameter" => isset($product_settings_data["bank_price"]) ? $product_settings_data["bank_price"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_bank_price_unit", "parameter" => isset($product_settings_data["bank_price_unit"]) ? $product_settings_data["bank_price_unit"] : NODATA];
//
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_inplace", "parameter" => isset($product_settings_data["set_inplace"]) ? $product_settings_data["set_inplace"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_inplace_price", "parameter" => isset($product_settings_data["set_inplace_price"]) ? $product_settings_data["set_inplace_price"] : 0];
//        $product_data[] = ["class" => "settings_product_fields", "function" => "set_inplace_price_unit", "parameter" => isset($product_settings_data["set_inplace_price_unit"]) ? $product_settings_data["set_inplace_price_unit"] : NODATA];

        $product_data = data::integration($product_data);
        $this->data_exec($product_data);
        return $this->get_control_tag();
    }

}

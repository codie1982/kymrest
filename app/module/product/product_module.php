<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product_module
 *
 * @author engin
 */
class product_module {

//put your code here

    public function get_product_name($product_name) {
        return ucwords_tr(html_entity_decode($product_name));
    }

    public function get_product_subname($product_sub_name) {
        return ucwords_tr(html_entity_decode($product_sub_name));
    }

    public function get_product_description($product_description) {
        return strip_tags(html_entity_decode(base64_decode($product_description)));
    }

    public function get_product_keywords($product_keywords) {
        return html_entity_decode($product_keywords);
    }

    public function calculate_discount_rate($product_price, $discount, $discounting_type) {
        $nproduct_constant = new product_constant();
        switch ($discounting_type) {
            case $nproduct_constant::discounting_rate:
                return mtm::getPercent($product_price, $discount, true, 2);
                break;
            case $nproduct_constant::discounting_minus:
                $price = $product_price - $discount;
                return mtm::getPercent($product_price, $price, true, 2);
                break;
        }
    }

    public function get_product_discount($product_id) {

        $result = [];
        $nproduct = new table_product();
        $product_info = $nproduct->get_data($product_id);
        $product_active_price = $this->get_product_price($product_id);

//        dnd($product_info);
//        dnd($product_active_price);

        $product_price = $product_active_price["product_price"];
        $product_price_unit = $product_active_price["product_price_unit"];
        $result["product_price"] = $product_price;
        $result["product_price_unit"] = $product_price_unit;
        $discount_value = $product_info->product_discount_price;
        $result["discount_type"] = $product_info->product_discount_type; // Toplam İndirim Miktarı
        $nproduct_constant = new product_constant();
        switch ($product_info->product_discount_type) {
            case trim($nproduct_constant::discounting_rate):
                //$discount_value = mtm::getPercent($product_price, $discount_value, false);
                $result["discount_value"] = $product_price * $discount_value / 100;
                $result["total_product_discount"] = $product_price * $discount_value / 100; // Toplam İndirim Miktarı
                $result["product_discount_price"] = exchange_rate($product_price - $result["total_product_discount"], $product_price_unit); // Ürünün indirimli fiyatı
                $result["product_discount_price_unit"] = default_currency(); // Ürünün indirimli fiyatı
                $result["discount_rate"] = number_format($discount_value, 2); // İndirim Oranı
                break;
            case trim($nproduct_constant::discounting_minus):
                $price = $product_price - $discount_value;
                $result["discount_value"] = $discount_value; // Toplam İndirim Miktarı
                $result["total_product_discount"] = $price; // Toplam İndirim Miktarı
                $result["product_discount_price"] = exchange_rate($price, $product_price_unit); // Ürünün indirimli fiyatı
                $result["product_discount_price_unit"] = default_currency(); // Ürünün indirimli fiyatı
                $result["discount_rate"] = mtm::getPercent($price, $discount_value, false, 2); //İndirim Oranı
                return $result;
                break;
        }
        return $result;
    }

    public function get_product_tax_price($product_id) {
        $nproduct = new table_product();
        $product_info = $nproduct->get_data($product_id);
        // $product_sales_price_info = $this->get_product_sales_price($product_id);
        $product_price_info = $this->get_product_price($product_id);
        $product_discount_info = $this->get_product_discount($product_id);
        $prc = $product_price_info["product_price"] - $product_discount_info["total_product_discount"];
        $result["product_tax_price"] = (mtm::getTaxRate($prc, $product_info->product_tax_zone, $product_info->product_intax));
        //$result["product_tax_price"] = $product_price_info["product_price"] - (mtm::getTaxRate($product_price_info["product_price"], $product_info->product_tax_zone, $product_info->product_intax));
        $result["product_tax_price_unit"] = default_currency();
        $result["product_tax_rate"] = $product_info->product_tax_zone;
        $result["product_intax"] = $product_info->product_intax;
        return $result;
    }

    public function get_product_sales_price($product_id) {
        $nproduct = new table_product();
        $product_active_price = $this->get_product_price($product_id);
        $product_discount_info = $this->get_product_discount($product_id);
        $product_tax_price = $this->get_product_tax_price($product_id);
        if ($product_tax_price["product_intax"]) {
            $result["product_sales_price"] = ($product_active_price["product_price"] - $product_discount_info["discount_value"]);
        } else {
            $result["product_sales_price"] = ($product_active_price["product_price"] - $product_discount_info["discount_value"]) + $product_tax_price["product_tax_price"];
        }
        $result["product_sales_price_unit"] = $product_active_price["product_price_unit"];
        return $result;
    }

    public function get_product_transport($product_id) {
        $result = [];
        $nproduct_constant = new product_constant();
        $ntransport_settings = new table_settings_transport();
        $ntransport_settings->select();
        $transport_settings_info = $ntransport_settings->get_alldata(true);
        //   $result["type"] = $transport_settings_info->workable_type;
//        if ($transport_settings_info->workable_type == $nproduct_constant::changeable) {//Bu Kısım Ürün Gönderim Ayarlarına Göde Düzenlenecek
//            $nproduct_transport = new table_product_transport();
//            $nproduct_transport->select();
//            $nproduct_transport->add_condition("product_id", $product_id);
//            if ($product_transport_info = $nproduct_transport->get_alldata(true)) {
//                //dnd($product_transport_info);
//                if ($product_transport_info->product_intransport) {
//                    $result["transport_type"] = $product_transport_info->product_transport_type;
//                    $result["transport_price"] = 0;
//                    $result["transport_price_unit"] = NODATA;
//                    $result["intransportproduct"] = $product_transport_info->product_intransport;
//                } else {
//                    if ($product_transport_info->transport_type == $nproduct_constant::transport_no) {
//                        $result["transport_type"] = $product_transport_info->product_transport_type;
//                        $result["transport_price"] = 0;
//                        $result["transport_price_unit"] = NODATA;
//                        $result["intransportproduct"] = $product_transport_info->product_intransport;
//                    } else {
//                        $result["transport_type"] = $product_transport_info->product_transport_type;
//                        $result["transport_price"] = exchange_rate($product_transport_info->product_transport_price, $product_transport_info->product_transport_price_unit);
//                        $result["transport_price_unit"] = default_currency();
//                        $result["intransportproduct"] = $product_transport_info->product_intransport;
//                    }
//                }
//            } else {
//                $result["error"] = "Gönderim Ayarlarına Ekli Değil";
//            }
//        } else if ($transport_settings_info->workable_type == $nproduct_constant::constant) {//Bu Kısım Sabit Gönderim Ayarlarına Göre Düzenlenecek
//        } else {
//            $result["error"] = "Gönderim Çalışma Şekli Belirli Değil";
//        }

        if ($transport_settings_info->intransportproduct) {
            if ($transport_settings_info->transport_type == $nproduct_constant::transport_no) {
                $result["transport_type"] = $transport_settings_info->transport_type;
                $result["transport_price"] = 0;
                $result["transport_price_unit"] = NODATA;
                $result["intransportproduct"] = $transport_settings_info->intransportproduct;
            } else {
                $result["transport_type"] = $transport_settings_info->transport_type;
                $result["transport_price"] = 0;
                $result["transport_price_unit"] = NODATA;
                $result["intransportproduct"] = $transport_settings_info->intransportproduct;
            }
        } else {
            if ($transport_settings_info->transport_type == $nproduct_constant::transport_no) {
                $result["transport_type"] = $transport_settings_info->transport_type;
                $result["transport_price"] = 0;
                $result["transport_price_unit"] = NODATA;
                $result["intransportproduct"] = $transport_settings_info->intransportproduct;
            } else {
                $result["transport_type"] = $transport_settings_info->transport_type;
                $result["transport_price"] = exchange_rate($transport_settings_info->transport_price, $transport_settings_info->product_transport_price_unit);

                $result["transport_price_unit"] = default_currency();
                $result["intransportproduct"] = $transport_settings_info->intransportproduct;
            }
        }
        return $result;
    }

    public function get_product_price($product_id) {
        $result = [];
        $nproduct = new table_product();
        $nproduct->select("product_price,product_price_unit");
        $nproduct->add_condition("product_id", $product_id);
        $price_info = $nproduct->get_alldata(true);
        //Hataya Bak
        $result["product_price"] = exchange_rate($price_info->product_price, $price_info->product_price_unit);
        $result["product_price_unit"] = default_currency();
        return $result;
    }

    public function get_product_detail($product_id) {
        $nproduct = new table_product();
        $nproduct->select();
        $nproduct->add_condition("public", 1);
        $nproduct->add_condition("product_id", $product_id);
        if ($product_info = $nproduct->get_alldata(true)) {
            return $product_info;
        } else {
            throw new Exception("Ürün Bilgisine Ulaşılamıyor");
        }
    }

    public function get_product_price_group_detail($primary_id) {
        $table = new table_product_price_group();
        $table->select();
        $table->add_condition("public", 1);
        $table->add_condition("product_price_group_id", $primary_id);
        if ($data = $table->get_alldata(true)) {
            return $data;
        } else {
            false;
        }
    }

    public function get_product_price_option_detail($primary_id) {
        $table = new table_product_price_option();
        $table->select();
        $table->add_condition("public", 1);
        $table->add_condition("product_price_option_id", $primary_id);
        if ($data = $table->get_alldata(true)) {
            return $data;
        } else {
            false;
        }
    }

}

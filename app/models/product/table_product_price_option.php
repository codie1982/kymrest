<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adres
 *
 * @author engin
 */
class table_product_price_option extends general {

    private $product_settings = array();

    public function __construct($all = false) {
        $nproduct_settings = new table_settings_product();
        $this->product_settings = $nproduct_settings->getProductSettings();

        $this->selecttable = "product_price_option";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

//   public function get_data($primary_id = null) {
//        $prm = $this->selecttable . "_id";
//        if (is_null($primary_id)) {
//            $sql = "SELECT * FROM $this->selecttable ORDER BY $prm DESC LIMIT 1";
//            $arr = [];
//        } else {
//            $sql = "SELECT * FROM $this->selecttable WHERE $prm = ?";
//            $arr = [$primary_id];
//        }
//        if ($r = $this->query($sql, $arr)->one()) {
//            $r->primary_key = $prm;
//            return $r;
//        } else {
//            return false;
//        }
//    }
//
//
//    public function get_data_main_key($product_id) {
//        $prm = $this->selecttable . "_id";
//        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE product_id=?", [$product_id])->results()) {
//            foreach ($res as $r) {
//                $r->primary_key = $prm;
//            }
//            return $res;
//        } else {
//            return false;
//        }
//    }
//
//    public function insert_data($data) {
//        $primary_key = $this->selecttable . "_id";
//        if (isset($data[$primary_key])) {
//            $pr = $data[$primary_key];
//            if ($this->update($pr, $data)) {
//                return $data[$primary_key];
//            } else {
//                return false;
//            }
//        } else {
//            if ($this->insert($data)) {
//                return $this->_db->lastinsertID();
//            } else {
//                return false;
//            }
//        }
//    }
//
//    public function remove($key) {
//        if ($this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function get_product_active_price($product_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable  WHERE product_id = ? ORDER BY product_price_option_id DESC", [$product_id])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getProductOptionIDFromSeccode($product_price_option_seccode) {
        if ($r = $this->query("SELECT product_price_option_id FROM $this->selecttable  WHERE product_price_option_seccode = ?", [$product_price_option_seccode])->one()) {
            return $r->product_price_option_id;
        } else {
            return false;
        }
    }

    public function removeOption($product_price_option_id) {
        if ($this->delete($product_price_option_id)) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductPriceList($product_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable  WHERE product_id = ? ORDER BY product_price ASC", [$product_id])->results()) {
            $_r = [];
            foreach ($r as $rr) {
                $_r[] = get_object_vars($rr);
            }
            return $_r;
        } else {
            return false;
        }
    }

    public function getProductActivePriceInfo($product_id) {
        $r = $this->query("SELECT * FROM $this->selecttable WHERE product_id = ? ", [$product_id])->results();
        $zero = false;
        if (!empty($r)) {
            foreach ($r as $_r) {
                if ($_r->activePrice == 1) {
                    return $_r;
                    break;
                } else {
                    $zero = true;
                }
            }
            if ($zero) {
                return $r[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getProductOptionsPriceInfo($options_id) {
        $r = $this->query("SELECT * FROM $this->selecttable WHERE product_price_option_id = ? ", [$options_id])->one();
        if (!empty($r)) {
            return $r;
        } else {
            return false;
        }
    }

    public function addNewProductPriceOptions($source, $product_id) {
        $nproduct = new product;
        $randomlist = $source["price_type_random"];
        $options_type = $source["product_price_type"];

        if ($options_type == $nproduct::options) {

            if ($this->product_settings->product_options_price == 1) {
                $product_price = $source["product_price"];
                $product_price_unit = $source["product_price_unit"];
                $product_price_title = $source["product_price_title"];
                $activeCheckPrice = $source["activeCheckPrice"];
                if (isset($randomlist)) {
                    if (!empty($randomlist))
                        foreach ($randomlist as $rnd) {

                            $nproductpricetpefields = new productpricetpefields();
                            $nproductpricetpefields->set_product_id($product_id);
                            $nproductpricetpefields->set_product_price($product_price[$rnd]);

                            $nproductpricetpefields->set_product_price_unit($product_price_unit[$rnd]);
                            $nproductpricetpefields->set_product_price_title($product_price_title[$rnd]);
                            $nproductpricetpefields->set_activePrice($activeCheckPrice == $rnd ? 1 : 0);
                            $nproductpricetpefields->set_price_type_date();
                            $nproductpricetpefields->set_product_price_option_seccode();
                            $nproductpricetpefields->set_users_id();

                            $fields = $nproductpricetpefields->getFields();
                            $this->insert($fields);
                        }
                }
            } else {
                $nproductpricetpefields = new productpricetpefields();
                $nproductpricetpefields->set_product_id($product_id);
                $nproductpricetpefields->set_product_price(0);
                $nproductpricetpefields->set_product_price_unit(NODATA);
                $nproductpricetpefields->set_product_price_title(NODATA);
                $nproductpricetpefields->set_activePrice(0);
                $nproductpricetpefields->set_price_type_date();
                $nproductpricetpefields->set_product_price_option_seccode();
                $nproductpricetpefields->set_users_id();

                $fields = $nproductpricetpefields->getFields();
                $this->insert($fields);
            }
        } else if ($options_type == $nproduct::flat) {

            if ($this->product_settings->product_flat_price == 1) {
                $product_price = $source["product_flat_price"];
                $product_price_unit = $source["product_flat_price_unit"];
                $activePrice = 1;

                $nproductpricetpefields = new productpricetpefields();
                $nproductpricetpefields->set_product_id($product_id);
                $nproductpricetpefields->set_product_price($product_price);
                $nproductpricetpefields->set_product_price_unit($product_price_unit);
                $nproductpricetpefields->set_product_price_title(NODATA);
                $nproductpricetpefields->set_activePrice($activePrice);
                $nproductpricetpefields->set_price_type_date();
                $nproductpricetpefields->set_product_price_option_seccode();
                $nproductpricetpefields->set_users_id();

                $fields = $nproductpricetpefields->getFields();
                $this->insert($fields);
            } else {
                $nproductpricetpefields = new productpricetpefields();
                $nproductpricetpefields->set_product_id($product_id);
                $nproductpricetpefields->set_product_price(0);
                $nproductpricetpefields->set_product_price_unit(NODATA);
                $nproductpricetpefields->set_product_price_title(NODATA);
                $nproductpricetpefields->set_activePrice(0);
                $nproductpricetpefields->set_price_type_date();
                $nproductpricetpefields->set_product_price_option_seccode();
                $nproductpricetpefields->set_users_id();

                $fields = $nproductpricetpefields->getFields();
                $this->insert($fields);
            }
        }
    }

    public function updateProductPriceOptions($source, $product_id) {
        $nproduct = new product;
        $randomlist = $source["price_type_random"];
        $options_type = $source["product_price_type"];
        if ($options_type == $nproduct::options) {
            if ($this->product_settings->product_options_price == 1) {
                $product_price = $source["product_price"];
                $product_price_unit = $source["product_price_unit"];
                $product_price_title = $source["product_price_title"];
                $activeCheckPrice = $source["activeCheckPrice"];
                $product_price_option_seccode = $source["product_price_option_seccode"];
                if (isset($randomlist)) {
                    if (!empty($randomlist))
                        foreach ($randomlist as $rnd) {
                            if (isset($product_price_option_seccode[$rnd])) {
                                $product_price_option_id = $this->getProductOptionIDFromSeccode($product_price_option_seccode[$rnd]);
                                $nproductpricetpefields = new productpricetpefields();

                                $nproductpricetpefields->set_product_price($product_price[$rnd]);
                                $nproductpricetpefields->set_product_price_unit($product_price_unit[$rnd]);
                                $nproductpricetpefields->set_product_price_title($product_price_title[$rnd]);
                                $nproductpricetpefields->set_activePrice($activeCheckPrice == $rnd ? 1 : 0);
                                $fields = $nproductpricetpefields->getFields();
                                $this->update($product_price_option_id, $fields);
                            } else {
                                $nproductpricetpefields = new productpricetpefields();
                                $nproductpricetpefields->set_product_id($product_id);
                                $nproductpricetpefields->set_product_price($product_price[$rnd]);
                                $nproductpricetpefields->set_product_price_unit($product_price_unit[$rnd]);
                                $nproductpricetpefields->set_product_price_title($product_price_title[$rnd]);
                                $nproductpricetpefields->set_activePrice($activeCheckPrice == $rnd ? 1 : 0);
                                $nproductpricetpefields->set_price_type_date();
                                $nproductpricetpefields->set_product_price_option_seccode();
                                $nproductpricetpefields->set_users_id();
                                $fields = $nproductpricetpefields->getFields();
                                $this->insert($fields);
                            }
                        }
                }
            }
        } else if ($options_type == $nproduct::flat) {

            if ($this->product_settings->product_flat_price == 1) {
                $product_price_option_seccode = $source["product_price_option_seccode"];
                if (isset($product_price_option_seccode)) {
                    $product_price_option_id = $this->getProductOptionIDFromSeccode($product_price_option_seccode);

                    $product_price = $source["product_flat_price"];
                    $product_price_unit = $source["product_flat_price_unit"];
                    $activePrice = 1;

                    $nproductpricetpefields = new productpricetpefields();
                    $nproductpricetpefields->set_product_price($product_price);
                    $nproductpricetpefields->set_product_price_unit($product_price_unit);
                    $nproductpricetpefields->set_product_price_title(NODATA);
                    $nproductpricetpefields->set_activePrice($activePrice);
                    $fields = $nproductpricetpefields->getFields();

                    $this->update($product_price_option_id, $fields);
                } else {
                    $product_price = $source["product_flat_price"];
                    $product_price_unit = $source["product_flat_price_unit"];
                    $activePrice = 1;

                    $nproductpricetpefields = new productpricetpefields();
                    $nproductpricetpefields->set_product_id($product_id);
                    $nproductpricetpefields->set_product_price($product_price);
                    $nproductpricetpefields->set_product_price_unit($product_price_unit);
                    $nproductpricetpefields->set_product_price_title(NODATA);
                    $nproductpricetpefields->set_activePrice($activePrice);
                    $nproductpricetpefields->set_price_type_date();
                    $nproductpricetpefields->set_product_price_option_seccode();
                    $nproductpricetpefields->set_users_id();

                    $fields = $nproductpricetpefields->getFields();
                    $this->insert($fields);
                }
            }
        }
    }

}

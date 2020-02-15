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
class table_product_payment_method extends general {


    public function __construct($all = false) {
        $this->selecttable = "product_payment_method";
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

    public function get_payment_method_count($product_id) {
        $result;
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        if ($product_settings->extra_field_workable_type == $nproduct_settings::changeable) {
            $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE product_id=?";
            $r = $this->query($sql, [$product_id])->one();
            return $r->{"COUNT(*)"};
        } else {
            $result = NODATA;
        }
        return $result;
    }

    public function getProductPaymentMethodList($product_id) {
        // echo $product_id;
        if ($r = $this->query("SELECT * FROM $this->selecttable  WHERE product_id = ?", [$product_id])->results()) {
            $results = [];
            foreach ($r as $rr) {
                $results[] = get_object_vars($rr);
            }
            //dnd($results);
            $nproduct = new product();
            $nproduct_settings = new table_settings_product();
            $product_settings = $nproduct_settings->getProductSettings();
            $_results = [];
            if ($product_settings->extra_field_workable_type == $nproduct_settings::changeable) {
                foreach ($results as $result) {
                    switch ($result["payment_method"]) {
                        case $nproduct::credicart:
                            if (($product_settings->credicart == 1)) {
                                if (($product_settings->credicart_extra_price == 0)) {
                                    $result["payment_method_extra_price"] = 0;
                                    $result["extra_price_unit"] = NODATA;
                                }
                                $_results[] = $result;
                            }
                            break;
                        case $nproduct::atthedoor:
                            if (($product_settings->atthedoor == 1)) {
                                if (($product_settings->atthedoor_extra_price == 0)) {
                                    $result["payment_method_extra_price"] = 0;
                                    $result["extra_price_unit"] = NODATA;
                                }
                                $_results[] = $result;
                            }

                            break;
                        case $nproduct::bank:
                            if (($product_settings->bank == 1)) {
                                if (($product_settings->bank_extra_price == 0)) {
                                    $result["payment_method_extra_price"] = 0;
                                    $result["extra_price_unit"] = NODATA;
                                }
                                $_results[] = $result;
                            }

                            break;
                        case $nproduct::inplace:
                            if (($product_settings->inplace == 1)) {
                                if (($product_settings->inplace_extra_price == 0)) {
                                    $result["payment_method_extra_price"] = 0;
                                    $result["payment_method_extra_price"] = NODATA;
                                }
                                $_results[] = $result;
                            }
                            break;
                    }
                }
            } else {
                $result["payment_method_extra_price"] = NODATA;
            }

            return $_results;
        } else {
            return false;
        }
    }

    public function getProductPaymentMethod($jobID, $product_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable  WHERE product_id = ?", [$product_id])->results()) {
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
        foreach ($r as $_r) {
            if ($_r->activePrice == 1) {
                break;
                return $_r;
            } else {
                $zero = true;
            }
        }
        if ($zero) {
            return $r[0];
        } else {
            return false;
        }
    }

    public function getProductExtraPrice($product_id, $method_type) {
        //Genel Hesaplamada Kısa bir Değişiklik Yapacaz
        $nproduct = new product();
        $nproduct_settings = new table_settings_product();
        $productSettings = $nproduct_settings->getProductSettings();

        if ($productSettings->extra_field_workable_type == $nproduct_settings::constant) {
            switch ($method_type) {
                case $nproduct::credicart:
                    return $productSettings->credicart_price;
                    break;
                case $nproduct::atthedoor:
                    return $productSettings->atthedoor_price;
                    break;
                case $nproduct::bank:
                    return $productSettings->bank_price;
                    break;
                case $nproduct::inplace:
                    return $productSettings->inplace_price;
                    break;
            }
        } else if ($productSettings->extra_field_workable_type == $nproduct_settings::changeable) {
            $sql = "SELECT payment_method_extra_price FROM $this->selecttable WHERE product_id ='$product_id' AND payment_method = '$method_type'";
            if ($r = $this->query("SELECT payment_method_extra_price FROM $this->selecttable  WHERE product_id = ? AND payment_method = ?", [$product_id, $method_type])->one()) {
                return $r->payment_method_extra_price;
            } else {
                return false;
            }
        }
    }

    private function checkPaymentMethod($method) {
        $nproduct = new product();
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $results = [];
        switch ($method) {
            case $nproduct::credicart:
                if ($product_settings->credicart == 1) {
                    $results[] = $method;
                }
                break;
            case $nproduct::atthedoor:
                if ($product_settings->atthedoor == 1) {
                    $results[] = $method;
                }
                break;
            case $nproduct::bank:
                if ($product_settings->bank == 1) {
                    $results[] = $method;
                }
                break;
            case $nproduct::inplace:
                if ($product_settings->inplace == 1) {
                    $results[] = $method;
                }
                break;
        }

        return $results;
    }

    public function addNewPaymentMethod($source, $product_id) {
        $nproduct = new product();
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();

        $payment_methods = $source["payment_method"];
        $fix_payment_methods = [];
        if (!empty($payment_methods)) {
            foreach ($payment_methods as $method) {
                switch ($method) {
                    case $nproduct::credicart:
                        if ($product_settings->credicart == 1) {
                            $fix_payment_methods[] = $method;
                        }
                        break;
                    case $nproduct::atthedoor:
                        if ($product_settings->atthedoor == 1) {
                            $fix_payment_methods[] = $method;
                        }
                        break;
                    case $nproduct::bank:
                        if ($product_settings->bank == 1) {
                            $fix_payment_methods[] = $method;
                        }
                        break;
                    case $nproduct::inplace:
                        if ($product_settings->inplace == 1) {
                            $fix_payment_methods[] = $method;
                        }
                        break;
                }
            }

            if (!empty($fix_payment_methods)) {
                $nproductpaymentmethodfields = new productpaymentmethodfields();
                foreach ($fix_payment_methods as $method) {
                    //$method_fields = [];
                    //$method_fields["product_id"] = $product_id;
                    $nproductpaymentmethodfields->set_product_id($product_id);
                    //$method_fields["payment_method"] = $method;
                    $nproductpaymentmethodfields->set_payment_method($method);
                    $product_extra_price = $source["product_extra_price"][$method];
                    $product_extra_price_unit = $source["product_extra_price_unit"][$method];
                    switch ($method) {
                        case $nproduct::credicart:
                            if ($product_settings->credicart_extra_price == 1) {
                                $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                                $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                            } else {
                                $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                                $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                            }
                        case $nproduct::atthedoor:
                            if ($product_settings->atthedoor_extra_price == 1) {
                                $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                                $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                            } else {
                                $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                                $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                            }
                        case $nproduct::bank:
                            if ($product_settings->bank_extra_price == 1) {
                                $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                                $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                            } else {
                                $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                                $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                            }
                        case $nproduct::inplace:
                            if ($product_settings->inplace_extra_price == 1) {
                                $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                                $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                            } else {
                                $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                                $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                            }
                    }

                    $nproductpaymentmethodfields->set_payment_method_date();
                    $nproductpaymentmethodfields->set_product_payment_method_seccode();
                    $nproductpaymentmethodfields->set_users_id();
                    $fields = $nproductpaymentmethodfields->getFields();
                    if (!empty($fields)) {
                        $this->insert($fields);
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
//            $nproductpaymentmethodfields->set_product_id($product_id);
//            $nproductpaymentmethodfields->set_payment_method($nproduct::credicart);
//            $nproductpaymentmethodfields->set_payment_method_extra_price(0);
//            $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
//            $nproductpaymentmethodfields->set_payment_method_date();
//            $nproductpaymentmethodfields->set_product_payment_method_seccode();
//            $nproductpaymentmethodfields->set_users_id();
//            $fields = $nproductpaymentmethodfields->getFields();
//            if (!empty($fields)) {
//                $this->insert($fields);
//            }
            return false;
        }
    }

    public function updatePaymentMethod($source, $product_id) {
        $this->delete($product_id, "product_id");
        $nproduct = new product();
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();

        $payment_methods = $source["payment_method"];
        $fix_payment_methods = [];

        foreach ($payment_methods as $method) {
            switch ($method) {
                case $nproduct::credicart:
                    if ($product_settings->credicart == 1) {
                        $fix_payment_methods[] = $method;
                    }
                    break;
                case $nproduct::atthedoor:
                    if ($product_settings->atthedoor == 1) {
                        $fix_payment_methods[] = $method;
                    }
                    break;
                case $nproduct::bank:
                    if ($product_settings->bank == 1) {
                        $fix_payment_methods[] = $method;
                    }
                    break;
                case $nproduct::inplace:
                    if ($product_settings->inplace == 1) {
                        $fix_payment_methods[] = $method;
                    }
                    break;
            }
        }

        if (!empty($fix_payment_methods)) {
            foreach ($fix_payment_methods as $method) {
                $nproductpaymentmethodfields = new productpaymentmethodfields();


                $nproductpaymentmethodfields->set_product_id($product_id);
                $nproductpaymentmethodfields->set_payment_method($method);
                $product_extra_price = $source["product_extra_price"][$method];
                $product_extra_price_unit = $source["product_extra_price_unit"][$method];
                switch ($method) {
                    case $nproduct::credicart:
                        if ($product_settings->credicart_extra_price == 1) {
                            $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                            $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                        } else {

                            $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                            $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                        }
                        break;
                    case $nproduct::atthedoor:
                        if ($product_settings->atthedoor_extra_price == 1) {
                            $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                            $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                        } else {
                            $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                            $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                        }
                        break;
                    case $nproduct::bank:
                        if ($product_settings->bank_extra_price == 1) {
                            $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                            $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                        } else {
                            $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                            $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                        }
                        break;
                    case $nproduct::inplace:
                        if ($product_settings->inplace_extra_price == 1) {
                            $nproductpaymentmethodfields->set_payment_method_extra_price($product_extra_price);
                            $nproductpaymentmethodfields->set_extra_price_unit($product_extra_price_unit);
                        } else {
                            $nproductpaymentmethodfields->set_payment_method_extra_price(0);
                            $nproductpaymentmethodfields->set_extra_price_unit(NODATA);
                        }
                        break;
                }

                $nproductpaymentmethodfields->set_payment_method_date();
                $nproductpaymentmethodfields->set_product_payment_method_seccode();
                $nproductpaymentmethodfields->set_users_id();
                $fields = $nproductpaymentmethodfields->getFields();
                if (!empty($fields)) {
                    $this->insert($fields);
                }
            }
            return true;
        } else {
            return false;
        }
    }

}

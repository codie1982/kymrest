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
class table_job_products extends general {

    private $_jobid;
    private $_product_id;
    private $_job_product_id;
    private $_customer_id;
    private $_product_amount;
    private $_job_price;
    private $_job_price_unit;
    private $_discount = "---";
    private $_discount_amount;
    private $_job_product_price_type;
    private $_job_price_option_id;
    private $_total;
    private $_payment_method;
    private $_product_type = "standart";
    private $_poster_width;
    private $_poster_height;
    private $_poster_cropData;
    private $_job_product_seccode;

    public function __construct($all = true) {
        $this->selecttable = "job_products";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    public function set_payment_method($val) {
        return $this->_payment_method = $val;
    }

    public function set_poster_width($val) {
        return $this->_poster_width = $val;
    }

    public function set_poster_cropData($val) {
        return $this->_poster_cropData = $val;
    }

    public function set_poster_height($val) {
        return $this->_poster_height = $val;
    }

    public function set_product_type($val) {
        return $this->_product_type = $val;
    }

    public function set_jobid($val) {
        return $this->_jobid = $val;
    }

    public function set_product_id($val) {
        return $this->_product_id = $val;
    }

    public function set_job_product_id($val) {
        return $this->_job_product_id = $val;
    }

    public function set_customer_id($val) {
        return $this->_customer_id = $val == "" ? "0" : $val;
    }

    public function set_product_amount($val) {
        return $this->_product_amount = $val;
    }

    public function set_job_price($val) {
        return $this->_job_price = $val;
    }

    public function set_job_price_unit($val) {
        return $this->_job_price_unit = $val;
    }

    public function set_discount($val = "---") {
        return $this->_discount = $val;
    }

    public function set_discount_amount($val) {
        return $this->_discount_amount = $val;
    }

    public function set_job_product_price_type($val) {
        return $this->_job_product_price_type = $val;
    }

    public function set_job_price_option_id($val) {
        return $this->_job_price_option_id = $val;
    }

    public function getJobProductIDFromSeccode($jobProductSeccode) {
        if ($r = $this->query("SELECT job_products_id FROM $this->selecttable WHERE job_products_seccode=?", [$jobProductSeccode])->one()) {
            return $r->job_products_id;
        } else {
            return false;
        }
    }

    public function getJobProductInfo($job_product_id, $filter = " * ") {
        if ($r = $this->_db->query("SELECT $filter FROM $this->selecttable WHERE job_products_id=?", [$job_product_id])->one()) {
            if ($filter == " * ") {
                return $r;
            } else {
                return $r->$filter;
            }
        } else {
            return false;
        }
    }

    public function removeJobProduct($job_product_id, $checkJob = true) {
        $jobProductInfo = $this->getJobProductInfo($job_product_id);
        $jobID = $jobProductInfo->job_id;
        $job_products_seccode = $jobProductInfo->job_products_seccode;
        $product_id = $jobProductInfo->product_id;
        $nprodoct_gallery = new product_gallery();
        $productFirstImageID = $nprodoct_gallery->getProductFirstImageId($product_id);

        $nimage_gallery = new image_gallery();
        $product_crop_image_ORJ = $nimage_gallery->getCropImage($productFirstImageID->image_gallery_id, $jobProductInfo->job_products_seccode, "ORJ", true);
        $product_crop_image_100 = $nimage_gallery->getCropImage($productFirstImageID->image_gallery_id, $jobProductInfo->job_products_seccode, 100, true);

        if ($this->delete($job_product_id)) {
            @unlink($product_crop_image_ORJ);
            @unlink($product_crop_image_100);
            if ($checkJob) {
                $product_list = $this->getJobProductList($jobID);
                if (empty($product_list)) {
                    $this->_db->delete("job", $jobID);
                    cookie::delete(VISITORJOB);
                    $njob_event = new job_event();
                    $njob_event->addJobEvent($jobID, "JobDelete");
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function addNewJobProduct() {


        $nproduct_settings = new table_settings_product();
        $productSettings = $nproduct_settings->getProductSettings();


        //Burda da ürün bazında oluşan kampanya tülerini inceleyebiliriz.
        $this->_job_product_seccode = seccode();


        $fields = [
            "job_id" => $this->_jobid,
            "product_id" => $this->_product_id,
            "product_type" => $this->_product_type,
            "customer_id" => $this->_customer_id,
            "product_amount" => $this->_product_amount,
            "job_price_type" => $this->_job_product_price_type,
            "job_price_option_id" => $this->_job_price_option_id,
            "job_price" => $this->_job_price,
            "job_price_unit" => $this->_job_price_unit,
            "discount" => $this->_discount,
            "discount_amount" => $this->_discount_amount == "" ? 0 : $this->_discount_amount,
            "total" => $this->calculate_product_total_price($this->_job_price, $this->_product_amount, $this->_discount, $this->_discount_amount, 0, "", $this->_product_type, $this->_poster_width, $this->_poster_height),
            "job_payment_method" => $productSettings->extra_field_workable_type == $nproduct_settings::changeable ? $this->_payment_method : NODATA,
            "public" => 1,
            "admin_public" => 1,
            "date" => getNow(),
            "job_products_seccode" => $this->_job_product_seccode,
            "users_id" => session::exists(CURRENT_USER_SESSION_NAME) ? session::get(CURRENT_USER_SESSION_NAME) : -1,
        ];

        if ($this->_product_type == "poster") {
            $fields["poster_width"] = $this->_poster_width;
            $fields["poster_height"] = $this->_poster_height;
            $fields["poster_crop_data"] = $this->_poster_cropData;
        }

        // dnd($fields); 
        if ($this->insert($fields)) {
            return $this->_db->lastinsertID();
        } else {
            return false;
        }
    }

    public function upateJobProductAmount($job_products_id, $amount, $type = "plus") {
        switch ($type) {
            case"plus":
                $r = $this->query("SELECT job_price,discount,discount_amount,product_amount FROM $this->selecttable WHERE job_products_id= ? ", [$job_products_id])->one();
                $namount = $r->product_amount + $amount;
                $fields = [
                    "product_amount" => $namount,
                    "total" => $this->calculate_product_total_price($r->job_price, $namount, $r->discount, $r->discount_amount, $r->product_id, $r->payment_method),
                ];
                break;
            case"minus":
                $r = $this->query("SELECT job_price,discount,discount_amount,product_amount FROM $this->selecttable WHERE job_products_id= ? ", [$job_products_id])->one();
                $namount = $r->product_amount - $amount;
                $fields = [
                    "product_amount" => $namount,
                    "total" => $this->calculate_product_total_price($r->job_price, $namount, $r->discount, $r->discount_amount, $r->product_id, $r->payment_method),
                ];
                break;
            case"change":
                $namount = $amount;
                $fields = [
                    "product_amount" => $namount,
                ];
                break;
            default :
                $namount = $amount;
                $fields = [
                    "product_amount" => $namount,
                ];

                break;
        }
        if ($namount <= 0) {
            $namount = 0;
        }

        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function calculate_product_total_price($price, $amount, $discount, $discount_amount, $product_id = 0, $payment_method = "", $product_type = "standart", $poster_width = 0, $poster_height = 0) {

        if ($discount != "---") {
            $ttal = floatval($price) * floatval($amount);
            switch ($discount) {
                case"rate":
                    $disres = $ttal - (($ttal * floatval($discount_amount) ) / 100);
                    break;
                case"minus":
                    $disres = $ttal - floatval($discount_amount);
                    break;
            }
            $ttal = $ttal - $disres;
        } else {
            $ttal = $price * $amount;
        }

        if ($product_type != "standart") {
            $sqr = floatval($poster_width / 100) * floatval($poster_height / 100);
            $ttal = $ttal * $sqr;
        }
        if ($product_id != 0) {
            $nproduct_payment_method = new product_payment_method();
            $extra = $nproduct_payment_method->getProductExtraPrice($product_id, $payment_method);
            $ttal = $ttal + $extra->payment_method_extra_price;
        }

        return $ttal;
    }

    public function get_product_count($job_id) {
        if ($products = $this->query("SELECT product_amount FROM $this->selecttable WHERE job_id= ? ", [$job_id])->results()) {
            foreach ($products as $product) {
                $product_amount = $product->product_amount;
                $total_product = $total_product + $product_amount;
            }
            return $total_product;
        } else {
            return false;
        }
    }

    public function get_product_total_price($job_id) {
        if ($products = $this->query("SELECT * FROM $this->selecttable WHERE job_id= ? ", [$job_id])->results()) {
            $total["price"] = 0;
            $total["unit"] = $products[0]->job_price_unit;
            foreach ($products as $product) {
                $product_amount = $product->product_amount;
                $job_price = $product->product_amount;
                $total["price"] = $total["price"] + $this->calculate_product_total_price($product->job_price, $product->product_amount, $product->discount, $product->discount_amount, $product->product_id, $product->payment_method);
            }
            return $total;
        } else {
            return false;
        }
    }

    public function get_product_total_discount($job_id) {
        if ($products = $this->query("SELECT * FROM $this->selecttable WHERE job_id= ? ", [$job_id])->results()) {
            $total["discount_price"] = 0;
            $total["unit"] = $products[0]->job_price_unit;
            foreach ($products as $product) {
                if ($product->discount != "---") {
                    $total["discount_price"] = $total["discount_price"] + 0;
                } else {
                    if ($product->discount != "rate") {
                        $disres = $total["discount_price"] - (( $total["discount_price"] * floatval($discount_amount) ) / 100);
                    } else if ($product->discount != "minus") {
                        $disres = $total["discount_price"] - floatval($discount_amount);
                    }
                    $total["discount_price"] = $total["discount_price"] - $disres;
                }
            }
            return $total;
        } else {
            return false;
        }
    }

    public function get_product_total_profit($job_id) {
        if ($products = $this->query("SELECT * FROM $this->selecttable WHERE job_id= ? ", [$job_id])->results()) {

            $total["rate"] = "";
            $total["state"] = "";
            $total["unit"] = $products[0]->job_price_unit;

            $calculateProfit = true;
            foreach ($products as $product) {
                $product_id = $product->product_id;
                $nproduct = new product();
                $product_cost = $nproduct->getProductInfo($product_id, "product_cost");
                $product_amount = $product->product_amount;
                if ($product_cost == "---" || $product_cost == "") {
                    $calculateProfit = false;
                } else {
                    $product_price = $this->calculate_product_total_price($product->job_price, $product->product_amount, $product->discount, $product->discount_amount, $product->product_id, $product->payment_method);
                    $total_job_price = $total_job_price + $product_price;
                    $cost = floatval($product_cost) * $product_amount;
                    $total_cost = $total_cost + $cost;
                    $profit = $product_price - $cost;
                    $total_profit = $total_profit + $profit;
                }
            }


            $total["total_cost"] = $total_cost;
            $total["total_profit"] = $total_profit;
            $total["total_price"] = $total_job_price;
            if ($total_profit > 0) {
//kar
                $total["state"] = "up";
                $total["rate"] = number_format($total_cost * 100 / $total_job_price, 2);
            } else if ($total_profit < 0) {
//zarar
                $total["state"] = "down";
                $total["rate"] = number_format((-1 * $total_cost) * 100 / $total_job_price, 2);
            } else {
//eşit
                $total["state"] = "equal";
                $total["rate"] = 0;
            }



            if (!$calculateProfit) {
                return false;
            } else {
                return $total;
            }
        } else {
            return false;
        }
    }

    public function checkProductOnJob($jobID, $product_info, $options_id = 0, $payment_method = "credicart") {
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        if ($product_settings->extra_field_workable_type == $nproduct_settings::constant) {
            if ($product_info->product_price_type == "flat") {
                if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=? AND product_id = ? AND product_type=?", [$jobID, $product_info->product_id, $product_info->product_type])->one()) {
                    return $r;
                } else {
                    return false;
                }
            } elseif ($product_info->product_price_type == "options") {
                if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=? AND product_id = ? AND job_price_option_id = ?  AND product_type=?", [$jobID, $product_info->product_id, $options_id, $product_info->product_type])->one()) {
                    return $r;
                } else {
                    return false;
                }
            }
        } else if ($product_settings->extra_field_workable_type == $nproduct_settings::changeable) {
            if ($product_info->product_price_type == "flat") {
                if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=? AND product_id = ? AND job_payment_method=? AND product_type=?", [$jobID, $product_info->product_id, $payment_method, $product_info->product_type])->one()) {
                    return $r;
                } else {
                    return false;
                }
            } elseif ($product_info->product_price_type == "options") {
                if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=? AND product_id = ? AND job_price_option_id = ?  AND job_payment_method=? AND product_type=?", [$jobID, $product_info->product_id, $options_id, $payment_method, $product_info->product_type])->one()) {
                    return $r;
                } else {
                    return false;
                }
            }
        }
    }

    public function getJobProductList($jobID) {
        if ($r = $this->_db->query("SELECT * FROM $this->selecttable 
            INNER JOIN product ON $this->selecttable.product_id=product.product_id
            WHERE $this->selecttable.job_id=? AND product.public = '1' ORDER BY $this->selecttable.date DESC", [$jobID])->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getProductAmount($product_id) {
        $r = $this->_db->query("SELECT product_amount FROM $this->selecttable WHERE product_id= ?", [$product_id])->results();
        $totalAmount = 0;
        foreach ($r as $a) {
            $totalAmount = $totalAmount + $a->product_amount;
        }
        return $totalAmount;
    }

    public function getJobPrice($jobID) {
        // dnd("SELECT * FROM $this->selecttable WHERE job_id='$jobID'");
        if ($job_products = $this->query("SELECT * FROM $this->selecttable WHERE job_id=?", [$jobID])->results()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
            $nproduct = new product();
            $nproduct_settings = new table_settings_product();
            $product_settings = $nproduct_settings->getProductSettings();
            $product_default_currency = $product_settings->product_default_currency;
            $general_total = 0;
            $discount = 0;
            $isDiscount = false;
            foreach ($job_products as $job_product) {
                //dnd($job_product);

                $product_id = $job_product->product_id;
                if ($nproduct->isThereProduct($product_id)) {
                    $job_price = $this->getJobProductPrice($job_product);
                    if (array_key_exists("discount", $job_price)) {
                        $discount = $discount + $job_price["discount"];
                        $isDiscount = true;
                    }
                    $general_total = $general_total + $job_price["total"];
                }
                //dnd($job_price);
            }

            if ($isDiscount) {
                $result["discount"] = $discount;
            }

            $result["total"] = $general_total;
            $result["unit"] = $product_default_currency;
            return $result;
        } else {
            return false;
        }
    }

    public function getJobProductPriceNoAmount($job_product) {
        //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $product_default_currency = $product_settings->product_default_currency;
        if (session::get(CURRENT_USER_SESSION_NAME)) {
            // dnd($product_settings);
        }
        $general_total = 0;
        if ($job_product->product_type == "poster") {
            $sqr = floatval($job_product->poster_width / 100) * floatval($job_product->poster_height / 100);
            $general_total = ($job_product->job_price * $sqr);
        } else {
            $general_total = ($job_product->job_price );
        }

        $result["total"] = $general_total;
        $result["unit"] = $product_default_currency;
        //dnd($result);
        return $result;
    }

    public function getJobProductPrice($job_product) {
        //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $product_default_currency = $product_settings->product_default_currency;
        if (session::get(CURRENT_USER_SESSION_NAME)) {
            // dnd($product_settings);
        }
        $general_total = 0;
        if ($job_product->product_type == "poster") {
            $sqr = floatval($job_product->poster_width / 100) * floatval($job_product->poster_height / 100);
            $general_total = ($job_product->job_price * $job_product->product_amount * $sqr);
        } else {
            $general_total = ($job_product->job_price * $job_product->product_amount);
        }
        if ($product_settings->product_sales_threshold != 0) {
            if ($product_settings->product_sales_anchor == $nproduct_settings::sales_anchor_product) {
                if ($general_total >= $product_settings->product_sales_threshold) {
                    $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_sales_threshold_amount), $product_settings->product_sales_threshold_type);
                    $result["discount"] = $general_total - $discount;
                    $general_total = $discount;
                }
            }
        }
        $result["total"] = $general_total;
        $result["unit"] = $product_default_currency;
        //dnd($result);
        return $result;
    }

    public function getJobProductTotalPrice($job_product) {
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $product_default_currency = $product_settings->product_default_currency;
        $general_total = 0;
        $job_price = $this->getJobProductPrice($job_product);
    }

    public function _getJobProductTotalPrice($job_product) {
        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $product_default_currency = $product_settings->product_default_currency;
        $general_total = 0;
        $job_price = $this->getJobProductPrice($job_product);
        $extra_info = $this->_getJobProductExtraPrice($job_product);
        if ($extra_info["function"] == "basket") {
            $extra_info["extra"] = 0;
        }
        $cargo_info = $this->getjobProductCargoPrice($job_product);
        if ($cargo_info["function"] == "basket") {
            $cargo_info["cargo"] = 0;
        }
        $tax_info = $this->getjobProductTaxPrice($job_product);

        $general_total = $job_price["total"] + $extra_info["extra"] + $cargo_info["cargo"] + $tax_info["tax"];

        $result["total"] = $general_total;
        $result["unit"] = $product_default_currency;
        return $result;
    }

    public function getJobProductTotal($job_products_id) {
        if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_products_id=?  ", [$job_products_id])->one()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
            $result["total"] = $r->total;
            $result["unit"] = $r->job_price_unit;
            return $result;
        } else {
            return false;
        }
    }

    public function getJobProductTotalForCrediCart($jobID) {
        if ($jobProducts = $this->query("SELECT * FROM $this->selecttable WHERE job_id=?  ", [$jobID])->result()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA

            foreach ($jobProducts as $jobProduct) {
                
            }
            $ttl = $r->total;
            $rate = 100 - $r->payment_rate;
            if ($rate == 0) {
                $result["total"] = 0;
            } else {
                $result["total"] = ($ttl * $rate) / 100;
            }
            $result["unit"] = $r->job_price_unit;
            return $result;
        } else {
            return false;
        }
    }

    public function getJobProductExtraPrice($job_products_id) {
        if ($jobsInfo = $this->query("SELECT * FROM $this->selecttable WHERE job_products_id=?  ", [$job_products_id])->one()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
            //ürün Özelliklerine göre şekillendirelim bunu. 
            //1. Ürün özelliklerine göre bu bölüm ürün bazında - Sepet Bazında veya Adet Bazında hesaplanmaktadır.
            //burada ürün özelliklerini kontrol edip ürün veya adet bazında değilse ürün için extra ücreti 0 olarak işaretliyelim
            //kırılım değerinide hesaba katmamız gerekmektedir.

            $nproduct_settings = new table_settings_product();
            $product_settings = $nproduct_settings->getProductSettings();
            $nproduct = new product();
            $general_total = 0;
            $result["function"] = $product_settings->product_extra_function;
            switch ($product_settings->product_extra_function) {
                //Sepet Bazında Ürün Eklemelerde Ürün Bazında Hesaplama Yapmıyoruz. 
                case $nproduct_settings::basket:
                    //SEPET
                    //sepet Bazında kırılım değerlerini düzenlemiyoruz.
                    $general_total = 0;
                    $result["extra"] = 0;
                    $result["unit"] = $jobsInfo->job_price_unit;
                    break;
                //Adet Başına Olan Hesaplamalarda Olan Eklemeler Ürün Adeti ile Sayısını Çarpılması ile elde ediyoruz. 
                case $nproduct_settings::piece:
                    //PARÇA
                    $nproduct_payment_method = new product_payment_method();
                    $extra = $nproduct_payment_method->getProductExtraPrice($jobsInfo->product_id, $jobsInfo->job_payment_method);
                    $general_total = doubleval($extra) * $jobsInfo->product_amount;
                    if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
                        // dnd($jobsInfo);
                        // dnd($product_settings->product_extra_threshold_amount);
                    }
                    $job_price = doubleval($jobsInfo->job_price) * $jobsInfo->product_amount;

                    if ($product_settings->product_extra_threshold != 0) {
                        //Kırılım Değerlerini Hesaplayalım
                        if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_self) {
                            if ($general_total >= $product_settings->product_extra_threshold) {
                                $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                                $result["discount"] = $general_total - $discount;
                                $general_total = $discount;
                            }
                        } else if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_product) {
                            if ($job_price >= $product_settings->product_extra_threshold) {
                                $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                                $result["discount"] = $general_total - $discount;
                                $general_total = $discount;
                            }
                        }
                    }


                    $result["extra"] = $general_total;
                    $result["unit"] = $jobsInfo->job_price_unit;
                    break;
                //Ürün Bazında olan eklemelerde ürün sayısı önemsenmeden  ürünün extra bedelini alıp sonucu veriyoruz. 
                case $nproduct_settings::product:
                    //ÜRÜN
                    $nproduct_payment_method = new product_payment_method();

                    $extra = $nproduct_payment_method->getProductExtraPrice($jobsInfo->product_id, $jobsInfo->job_payment_method);
                    $general_total = doubleval($extra);
                    $job_price = $jobsInfo->job_price;

                    if ($product_settings->product_extra_threshold != 0) {
                        //Kırılım Değerlerini Hesaplayalım
                        if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
                            //dnd($extra);
                            // dnd($product_settings->product_extra_threshold);
                        }
                        if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_self) {
                            if ($general_total >= $product_settings->product_extra_threshold) {
                                $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                                $result["discount"] = $general_total - $discount;
                                $general_total = $discount;
                            }
                        } else if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_product) {
                            if ($job_price >= $product_settings->product_extra_threshold) {
                                $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                                $result["discount"] = $general_total - $discount;
                                $general_total = $discount;
                            }
                        }
                    }
                    $result["extra"] = $general_total;
                    $result["unit"] = $jobsInfo->job_price_unit;
                    break;
            }
            return $result;
        } else {
            return false;
        }
    }

    public function _getJobProductExtraPrice($job_product_info) {
        $product_id = $job_product_info->product_id;
        $job_payment_method = $job_product_info->job_payment_method;
        $job_price = $job_product_info->job_price;
        $job_price_unit = $job_product_info->job_price_unit;
        $product_amount = $job_product_info->product_amount;
        //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
        //ürün Özelliklerine göre şekillendirelim bunu. 
        //1. Ürün özelliklerine göre bu bölüm ürün bazında - Sepet Bazında veya Adet Bazında hesaplanmaktadır.
        //burada ürün özelliklerini kontrol edip ürün veya adet bazında değilse ürün için extra ücreti 0 olarak işaretliyelim
        //kırılım değerinide hesaba katmamız gerekmektedir.

        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $nproduct = new product();
        $general_total = 0;
        $result["function"] = $product_settings->product_extra_function;
        switch ($product_settings->product_extra_function) {
            //Sepet Bazında Ürün Eklemelerde Ürün Bazında Hesaplama Yapmıyoruz. 
            case $nproduct_settings::basket:
                //SEPET
                //sepet Bazında kırılım değerlerini düzenlemiyoruz.
                $general_total = 0;
                $result["extra"] = $general_total;
                $result["unit"] = $product_settings->product_default_currency;
                break;
            //Adet Başına Olan Hesaplamalarda Olan Eklemeler Ürün Adeti ile Sayısını Çarpılması ile elde ediyoruz. 
            case $nproduct_settings::piece:
                //PARÇA
                $nproduct_payment_method = new product_payment_method();
                $extra = $nproduct_payment_method->getProductExtraPrice($product_id, $job_payment_method);
                $general_total = doubleval($extra) * $product_amount;
                if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
                    // dnd($jobsInfo);
                    // dnd($product_settings->product_extra_threshold_amount);
                }
                $job_price = doubleval($job_price) * $product_amount;

                if ($product_settings->product_extra_threshold != 0) {
                    //Kırılım Değerlerini Hesaplayalım
                    if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_self) {
                        if ($general_total >= $product_settings->product_extra_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                            $result["discount"] = $general_total - $discount;
                            $general_total = $discount;
                        }
                    } else if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_product) {
                        if ($job_price >= $product_settings->product_extra_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                            $result["discount"] = $general_total - $discount;
                            $general_total = $discount;
                        }
                    }
                }


                $result["extra"] = $general_total;
                $result["unit"] = $product_settings->product_default_currency;
                break;
            //Ürün Bazında olan eklemelerde ürün sayısı önemsenmeden  ürünün extra bedelini alıp sonucu veriyoruz. 
            case $nproduct_settings::product:
                //ÜRÜN
                $nproduct_payment_method = new product_payment_method();
                $extra = $nproduct_payment_method->getProductExtraPrice($product_id, $job_payment_method);
                $general_total = doubleval($extra);
                $job_price = $job_price;

                if ($product_settings->product_extra_threshold != 0) {
                    //Kırılım Değerlerini Hesaplayalım
                    if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
                        //dnd($extra);
                        // dnd($product_settings->product_extra_threshold);
                    }
                    if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_self) {
                        if ($general_total >= $product_settings->product_extra_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                            $result["discount"] = $general_total - $discount;
                            $general_total = $discount;
                        }
                    } else if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_product) {
                        if ($job_price >= $product_settings->product_extra_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                            $result["discount"] = $general_total - $discount;
                            $general_total = $discount;
                        }
                    }
                }
                $result["extra"] = $general_total;
                $result["unit"] = $product_settings->product_default_currency;
                break;
        }
        return $result;
    }

    public function getTotalJobPrice($jobID) {
        if ($job_products = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id = ?  ", [$jobID])->results()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
            $nproduct_settings = new table_settings_product();
            $product_settings = $nproduct_settings->getProductSettings();
            $product_default_currency = $product_settings->product_default_currency;
            $basket_price = 0;

            $general_total = 0;
            $totalPrice = 0; //  $total değişkeni global olarak kullanılıyor
            foreach ($job_products as $job_product) {
                $total_price = $this->getJobProductPrice($job_product);
                $general_total = $general_total + $total_price["total"];
                $cargo = $this->getTotalCargoPrice($jobID);
                $tax = $this->getTotalTaxPrice($jobID);
                $extra = $this->getTotalExtraPrice($jobID);

                $basket_price = $general_total + $cargo["cargo"] + $tax["tax"] + $extra["extra"];
                if ($product_settings->product_sales_threshold != 0) {
                    if ($product_settings->product_sales_anchor == $nproduct_settings::sales_anchor_basket) {
                        if ($basket_price >= $product_settings->product_sales_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($basket_price), doubleval($product_settings->product_sales_threshold_amount), $product_settings->product_sales_threshold_type);
                            $result["discount"] = $basket_price - $discount;
                            $basket_price = $discount;
                        }
                    }
                }
            }

            $result[$nproduct_settings::sales_anchor_basket] = $basket_price;
            $result["total"] = $basket_price;
            $result["unit"] = $total_price["unit"];
            //dnd($result);
            return $result;
        } else {
            return false;
        }
    }

    public function getTotalDiscountPrice($jobID) {
        if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=?  ", [$jobID])->results()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
            $d = 0;
            $td = 0;
            foreach ($r as $t) {
                if ($t->discount != "---") {
                    $d = floatval($t->job_price) * floatval($t->product_amount);
                    switch ($t->discount) {
                        case"rate":
                            $d = $d - (($d * floatval($t->discount_amount) ) / 100);
                            break;
                        case"minus":
                            $d = $d - floatval($t->discount_amount);
                            break;
                    }
                    $td = $td + $d;
                }
            }
            $result["discount"] = $td;
            $result["unit"] = $r[0]->job_price_unit;
            return $result;
        } else {
            return false;
        }
    }

    public function getTotalExtraPrice($jobID) {
        if ($jobInfo = $this->query("SELECT * FROM $this->selecttable WHERE job_id=?  ", [$jobID])->results()) {

            $nproduct_settings = new table_settings_product();
            $product_settings = $nproduct_settings->getProductSettings();
            $nproduct = new product();
            $general_total = 0;
            $general_job_price = 0;
            if ($product_settings->product_extra_function == $nproduct_settings::basket) {
                //SEPET
                $extra_price_list = [];
                foreach ($jobInfo as $job_detail) {
                    $product_id = $job_detail->product_id;
                    $job_payment_method = $job_detail->job_payment_method;
                    $nproduct_payment_method = new product_payment_method();

                    $extra_price_list[] = $nproduct_payment_method->getProductExtraPrice($product_id, $job_payment_method);
                    $job_price = $job_detail->job_price * $job_detail->product_amount;
                    $general_job_price = $general_job_price + $job_price;
                }
                //Burada Faklı Şartlar Belirtebiliriz En Yüksek En Düşük veya Ortalaması gibi.
                // dnd($extra_price_list);
                $general_total = max($extra_price_list);

                if ($product_settings->product_extra_threshold != 0) {
                    //Kırılım Değerlerini Hesaplayalım

                    if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_product) {
                        if ($general_job_price >= $product_settings->product_extra_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                            $result["discount"] = $general_total - $discount;
                            $general_total = $discount;
                        }
                    } else if ($product_settings->product_extra_anchor == $nproduct_settings::extra_anchor_self) {
                        if ($general_total >= $product_settings->product_extra_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($general_total), doubleval($product_settings->product_extra_threshold_amount), $product_settings->product_extra_threshold_type);
                            $result["discount"] = $general_total - $discount;
                            $general_total = $discount;
                        }
                    }
                }

//                foreach ($jobInfo as $job_detail) {
//                    $job_payment_method = $job_detail->job_payment_method;
//                    $result[$job_payment_method] = $general_total;
//                } 

                $result[$nproduct_settings::basket] = $general_total;
                $result["extra"] = $general_total;
                //Genel Hesaplamada Tün Birimleri varsayılan birime dönüştürmemiz gerekmektedir.
                $result["unit"] = $product_settings->product_default_currency;
            } else if ($product_settings->product_extra_function == $nproduct_settings::product) {
                //ÜRÜN
                foreach ($jobInfo as $job_detail) {
                    $product_id = $job_detail->product_id;
                    $job_payment_method = $job_detail->job_payment_method;
                    $job_products_id = $job_detail->job_products_id;



                    $extra_info = $this->getJobProductExtraPrice($job_products_id);

                    $general_total = $general_total + $extra_info["extra"];
                    $result[$job_payment_method] = $general_total;
                }
                if (array_key_exists("discount", $extra_info)) {
                    $result["discount"] = $extra_info["discount"];
                }
                $result["extra"] = $general_total;
                $result["unit"] = $extra_info["unit"];
            } else if ($product_settings->product_extra_function == $nproduct_settings::piece) {
                //PARÇA
                foreach ($jobInfo as $job_detail) {
                    $product_id = $job_detail->product_id;
                    $job_payment_method = $job_detail->job_payment_method;
                    $job_products_id = $job_detail->job_products_id;

                    $extra_info = $this->getJobProductExtraPrice($job_products_id);

                    $general_total = ($general_total + $extra_info["extra"]);
                    $result[$job_payment_method] = $general_total;
                }
                if (array_key_exists("discount", $extra_info)) {
                    $result["discount"] = $extra_info["discount"];
                }
                $result["extra"] = $general_total;
                $result["unit"] = $extra_info["unit"];
            }

            return $result;
        } else {
            return false;
        }
    }

    public function getTotalCargoPrice($jobID) {
        if ($jobsInfo = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=? ", [$jobID])->results()) {
            $general_total = 0;
            $general_price = 0;
            $cargo_price = 0;
            //Kargo Kampanyası Kontrol Edilebilir.
            $nproduct_settings = new table_settings_product();
            $product_settings = $nproduct_settings->getProductSettings();
//            if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
//                dnd($jobsInfo);
//            }
            switch ($product_settings->product_cargo_function) {
                case $nproduct_settings::basket:
                    //SEPET
                    $cargo_price_list = [];

                    foreach ($jobsInfo as $jobInfo) {
                        $product_id = $jobInfo->product_id;
                        $product_price = $jobInfo->job_price * $jobInfo->product_amount;
                        $nproduct = new product();

                        $cargoInfo = $this->getjobProductCargoPrice($jobInfo);
                        $cargo_price_list[] = $cargoInfo["cargo"];
                        $general_price = intval($general_price) + intval($product_price);
                    }

                    $general_total = max($cargo_price_list);
                    if ($product_settings->product_cargo_threshold != 0) {
                        //Kırılım Değerlerini Hesaplayalım

                        if ($product_settings->product_cargo_anchor == $nproduct_settings::cargo_anchor_self) {
                            if ($general_total >= $product_settings->product_cargo_threshold) {
                                //Kargo Fiyatonba Göre İndirim Yapılıyor
                                $discount = $nproduct_settings->getProductThreshold(intval($general_total), intval($product_settings->product_cargo_threshold_amount), $product_settings->product_cargo_threshold_type);
                                $result["discount"] = $general_total - $discount;
                                $general_total = $discount;
                            }
                        } else if ($product_settings->product_cargo_anchor == $nproduct_settings::cargo_anchor_product) {
                            //Sepet Toplam Fiyatına Göre İndirim Yapılıyor
                            if ($general_price >= $product_settings->product_cargo_threshold) {
                                $discount = $nproduct_settings->getProductThreshold(intval($general_total), intval($product_settings->product_cargo_threshold_amount), $product_settings->product_cargo_threshold_type);
                                $result["discount"] = $general_total - $discount;
                                $general_total = $discount;
                            }
                        }
                    }

                    $result[$nproduct_settings::basket] = $general_total;
                    $result["cargo"] = $general_total;
                    $result["unit"] = $product_settings->product_default_currency;
                    //dnd($result);
                    break;
                case $nproduct_settings::product:
                    //ÜRÜN
                    $product_id = $jobInfo->product_id;
                    $nproduct = new product();
                    if ($nproduct->getCargoInclude($product_id)) {
                        $cargoPrice = 0;
                    } else {
                        $cargoInfo = $this->getjobProductCargoPrice($jobInfo);
                        $cargo_price = $cargoInfo["cargo"];
                        $cargo_price_unit = $cargoInfo["unit"];
                    }
                    $general_total = $general_total + $cargo_price;
                    if (is_array($cargoInfo)) {
                        if (array_key_exists("discount", $cargoInfo)) {
                            $result["discount"] = $cargoInfo["discount"];
                        }
                    }
                    $result["cargo"] = $general_total;
                    $result["unit"] = $product_settings->product_default_currency;
                    break;
                case $nproduct_settings::piece:
                    //PARÇA

                    $product_id = $jobInfo->product_id;
                    $nproduct = new product();
                    if ($nproduct->getCargoInclude($product_id)) {
                        $cargoPrice = 0;
                    } else {
                        //getjobProductCargoPrice

                        $cargoInfo = $this->getjobProductCargoPrice($jobInfo);
                        //$cargoInfo = $nproduct->getCargoPrice($product_id);
                        if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
                            //dnd($cargoInfo);
                        }
                        $cargo_price = $cargoInfo["cargo"];
                        $cargo_price_unit = $cargoInfo["unit"];
                    }
                    $general_total = $general_total + $cargo_price;

                    if (is_array($cargoInfo)) {
                        if (array_key_exists("discount", $cargoInfo)) {
                            $result["discount"] = $cargoInfo["discount"];
                        }
                    }


                    $result["cargo"] = $general_total;
                    $result["unit"] = $product_settings->product_default_currency;
                    break;
            }
            return $result;
        } else {
            return false;
        }
    }

    public function getjobProductCargoPrice($job_product_info) {
        $product_id = $job_product_info->product_id;
        $job_price = $job_product_info->job_price;
        $total_job_price = $job_product_info->total;
        $job_price_unit = $job_product_info->job_price_unit;
        $product_amount = $job_product_info->product_amount;

        $nproduct = new product();

        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->getProductSettings();
        $nproduct = new product();

        $cargo_price = 0;
        $cargo_price_unit = "";
        $result["function"] = $product_settings->product_cargo_function;
        if ($nproduct->getCargoInclude($product_id)) {
            $cargo_price = 0;
            $cargo_price_unit = $product_settings->product_default_currency;
        } else {

            switch ($product_settings->product_cargo_function) {
                case $nproduct_settings::basket:
                    $cargoInfo = $nproduct->getCargoPrice($product_id);
                    $result["cargo"] = $cargoInfo->product_transport_price;
                    $result["unit"] = $product_settings->product_default_currency;
                    break;
                case $nproduct_settings::product:
                    $cargoInfo = $nproduct->getCargoPrice($product_id);
                    $cargo_price = doubleval($cargoInfo->product_transport_price);
                    $cargo_price_unit = $cargoInfo->product_transport_price_unit;

                    if ($product_settings->product_cargo_anchor == $nproduct_settings::cargo_anchor_self) {
                        if ($cargo_price >= $product_settings->product_cargo_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($cargo_price), doubleval($product_settings->product_cargo_threshold_amount), $product_settings->product_cargo_threshold_type);
                            $result["discount"] = $cargo_price - $discount;
                            $cargo_price = $discount;
                        }
                    } else if ($product_settings->product_extra_anchor == $nproduct_settings::cargo_anchor_product) {
                        if ($total_job_price >= $product_settings->product_cargo_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($cargo_price), doubleval($product_settings->product_cargo_threshold_amount), $product_settings->product_cargo_threshold_type);
                            $result["discount"] = $cargo_price - $discount;
                            $cargo_price = $discount;
                        }
                    }

                    $result["cargo"] = $cargo_price;
                    $result["unit"] = $cargo_price_unit;
                    break;

                case $nproduct_settings::piece:
                    $cargoInfo = $nproduct->getCargoPrice($product_id);
                    $cargo_price = doubleval($cargoInfo->product_transport_price) * $product_amount;
                    $cargo_price_unit = $cargoInfo->product_transport_price_unit;
                    if (session::get(CURRENT_USER_SESSION_NAME) == 10306) {
                        // dnd($cargoInfo);
                    }
                    if ($product_settings->product_cargo_anchor == $nproduct_settings::cargo_anchor_self) {

                        if ($cargo_price >= $product_settings->product_cargo_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($cargo_price), doubleval($product_settings->product_cargo_threshold_amount), $product_settings->product_cargo_threshold_type);
                            $result["discount"] = $cargo_price - $discount;
                            $cargo_price = $discount;
                        }
                    } else if ($product_settings->product_extra_anchor == $nproduct_settings::cargo_anchor_product) {

                        $job_price_piece = $job_price * $product_amount;

                        if ($job_price_piece >= $product_settings->product_cargo_threshold) {
                            $discount = $nproduct_settings->getProductThreshold(doubleval($cargo_price), doubleval($product_settings->product_cargo_threshold_amount), $product_settings->product_cargo_threshold_type);
                            $result["discount"] = $cargo_price - $discount;
                            $cargo_price = $discount;
                        }
                    }


                    $result["cargo"] = $cargo_price;
                    $result["unit"] = $cargo_price_unit;


                    break;
            }
        }
        return $result;
    }

    public function getTotalTaxPrice($jobID) {
        if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=?  ", [$jobID])->results()) {
            $tt = 0;
            $taxPrice = 0;
            foreach ($r as $t) {
                $product_id = $t->product_id;
                $nproduct = new product();
                if ($nproduct->getTaxInclude($product_id)) {
                    $taxPrice = 0;
                } else {
                    $taxZone = $nproduct->getTaxZone($product_id);
                    $price = $this->getJobProductPrice($t);
                    $taxPrice = $price["total"] * $taxZone / 100;
                }
                $tt = $tt + $taxPrice;
            }
            $result["tax"] = $tt;
            $result["unit"] = "tl";
            return $result;
        } else {
            return false;
        }
    }

    public function getjobProductTaxPrice($job_product_info) {
        $tt = 0;
        $taxPrice = 0;

        $product_id = $job_product_info->product_id;
        $nproduct = new product();
        if ($nproduct->getTaxInclude($product_id)) {
            $taxPrice = 0;
        } else {
            $taxZone = $nproduct->getTaxZone($product_id);
            $price = $this->getJobProductPrice($job_product_info);
            $taxPrice = $price["total"] * $taxZone / 100;
        }
        $result["tax"] = $taxPrice;
        $result["unit"] = $price["unit"];
        return $result;
    }

    public function getjobProductDiscountPrice($job_product_info) {

        return true;
    }

    public function getJobPaymentClass($jobID) {
        if ($r = $this->_db->query("SELECT * FROM $this->selecttable WHERE job_id=?  ", [$jobID])->results()) {
            $tt = 0;
            $paymentClass = [];
            $_credicart = 0;
            $_atthedoor = 0;
            $_inplace = 0;
            $_bank = 0;
            $jobID;
            if ($extra["function"] == "basket") {
                $extra["extra"] = $this->getTotalExtraPrice($jobID);
            }
            foreach ($r as $t) {
                $nproduct = new product();
                $jobID = $t->job_id;
                switch ($t->job_payment_method) {
                    case $nproduct::credicart:
                        $totalJobPrice = $this->getJobProductPrice($t);
                        $cargo = $this->getjobProductCargoPrice($t);
                        if (isset($cargo["function"]) && $cargo["function"] == "basket") {
                            $cargo["cargo"] = 0;
                        }
                        $tax = $this->getjobProductTaxPrice($t);
                        $extra = $this->getJobProductExtraPrice($t->job_products_id);
                        if (isset($extra["function"]) && $extra["function"] == "basket") {
                            $extra["extra"] = 0;
                        }
                        $credicart = $totalJobPrice["total"] + $cargo["cargo"] + $tax["tax"] + $extra["extra"];
                        $_credicart = $_credicart + $credicart;
                        $paymentClass[$nproduct::credicart] = $_credicart;
                        break;
                    case $nproduct::atthedoor:
                        $totalJobPrice = $this->getJobProductPrice($t);
                        //dnd($totalJobPrice);
                        $cargo = $this->getjobProductCargoPrice($t);
                        if (isset($cargo["function"]) && $cargo["function"] == "basket") {
                            $cargo["cargo"] = 0;
                        }
                        //dnd($cargo);
                        $tax = $this->getjobProductTaxPrice($t);
                        //dnd($tax);
                        $extra = $this->getJobProductExtraPrice($t->job_products_id);
                        if (isset($extra["function"]) && $extra["function"] == "basket") {
                            $extra["extra"] = 0;
                        }
                        //dnd($extra);
                        $atthedoor = $totalJobPrice["total"] + $cargo["cargo"] + $tax["tax"] + $extra["extra"];
                        //dnd($atthedoor);
                        $_atthedoor = $_atthedoor + $atthedoor;
                        //dnd($_atthedoor);
                        $paymentClass[$nproduct::atthedoor] = $_atthedoor;
                        break;
                    case $nproduct::inplace:
                        $totalJobPrice = $this->getJobProductPrice($t);
                        $cargo = $this->getjobProductCargoPrice($t);
                        if (isset($cargo["function"]) && $cargo["function"] == "basket") {
                            $cargo["cargo"] = 0;
                        }
                        $tax = $this->getjobProductTaxPrice($t);
                        $extra = $this->getJobProductExtraPrice($t->job_products_id);
                        if (isset($extra["function"]) && $extra["function"] == "basket") {
                            $extra["extra"] = 0;
                        }
                        $inplace = $totalJobPrice["total"] + $cargo["cargo"] + $tax["tax"] + $extra["extra"];
                        $_inplace = $_inplace + $inplace;
                        $paymentClass[$nproduct::inplace] = $_inplace;
                        break;
                    case $nproduct::bank:
                        $totalJobPrice = $this->getJobProductPrice($t);
                        $cargo = $this->getjobProductCargoPrice($t);
                        if (isset($cargo["function"]) && $cargo["function"] == "basket") {
                            $cargo["cargo"] = 0;
                        }
                        $tax = $this->getjobProductTaxPrice($t);
                        $extra = $this->getJobProductExtraPrice($t->job_products_id);
                        if (isset($extra["function"]) && $extra["function"] == "basket") {
                            $extra["extra"] = 0;
                        }
                        $bank = $totalJobPrice["total"] + $cargo["cargo"] + $tax["tax"] + $extra["extra"];
                        $_bank = $_bank + $bank;
                        $paymentClass[$nproduct::bank] = $_bank;
                        break;
                    default :
                        break;
                }
            }




            $temp = [];
            if (isset($paymentClass[$nproduct::credicart])) {
                $temp[$nproduct::credicart] = $paymentClass[$nproduct::credicart];
            }
            if (isset($paymentClass[$nproduct::atthedoor])) {
                $temp[$nproduct::atthedoor] = $paymentClass[$nproduct::atthedoor];
            }
            if (isset($paymentClass[$nproduct::bank])) {
                $temp[$nproduct::bank] = $paymentClass[$nproduct::bank];
            }
            if (isset($paymentClass[$nproduct::inplace])) {
                $temp[$nproduct::inplace] = $paymentClass[$nproduct::inplace];
            }
            $temp["total"] = $paymentClass[$nproduct::credicart] + $paymentClass[$nproduct::atthedoor] + $paymentClass[$nproduct::bank] + $paymentClass[$nproduct::inplace];
            //dnd($paymentClass);

            $total_cargo_info = $this->getTotalCargoPrice($jobID);
            //dnd($total_cargo_info);
            if (isset($total_cargo_info["basket"])) {
                $temp["total"] = $temp["total"] + $total_cargo_info["basket"];
            }
            $total_extra_info = $this->getTotalExtraPrice($jobID);
            if (isset($total_extra_info["basket"])) {
                $temp["total"] = $temp["total"] + $total_extra_info["basket"];
            }
            //dnd($total_extra_info);
            return $temp;
        } else {
            return false;
        }
    }

    public function sendIyzico() {
        return true;
    }

    public function setJobProductPayment($job_product_id, $rate) {
        $fields = [
            "payment_rate" => $rate
        ];
        if ($this->update($job_product_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Ürünler için ödeme bilgisi eklenemedi&jobproductid=' . $job_product_id . '&model=job_productsModel&method=setJobProductPayment&post=' . json_encode($post));
            return false;
        }
    }

    public function checkJobProductPayment($jobProdID) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE job_products_id=? AND payment_rate <>?  ", [$jobProdID, 100])->one()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductAmountInfo($jobProdID) {
        if ($r = $this->query("SELECT product_amount FROM $this->selecttable WHERE job_products_id=?  ", [$jobProdID])->one()) {
            return $r->product_amount;
        } else {
            return false;
        }
    }

    public function getProductID($job_products_id) {
        if ($r = $this->query("SELECT product_id FROM $this->selecttable WHERE job_products_id=?  ", [$job_products_id])->one()) {
            return $r->product_id;
        } else {
            return false;
        }
    }

    public function makeCropImage($product_image_id, $imageX, $imageY, $imageWidth, $imageHeigth) {
        $nimage_gallery = new image_gallery();

        $image = $nimage_gallery->getImage($product_image_id, 1000, true);
        //dnd($image);
        $img_info = $nimage_gallery->getImageInfo($product_image_id);
        $subfolder = TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $this->_job_product_seccode;
        if (!is_dir($subfolder)) {
            mkdir($subfolder);
        }
        $filename = $subfolder . DS . $img_info->first_image_name . "_100." . $img_info->extention;
        // $save_folder = //
        $dst_x = 0;   // X-coordinate of destination point
        $dst_y = 0;   // Y-coordinate of destination point
        $src_x = $imageX; // Crop Start X position in original image
        $src_y = $imageY; // Crop Srart Y position in original image
        $dst_w = 100; // Yeni Resmin Genişliği
        $dst_h = 100 * ($imageHeigth / $imageWidth ); // Yeni Resmin Yüksekliği
        $src_w = $imageWidth; // Crop end X position in original image
        $src_h = $imageHeigth;
        // Crop end Y position in original image
        // Creating an image with true colors having thumb dimensions (to merge with the original image)
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        // Get original image
        $crop = true;
        if ($img_info->extention == "jpg" || $img_info->extention == "jpeg") {
            $src_image = imagecreatefromjpeg($image);
        } else if ($img_info->extention == "png") {
            $src_image = imagecreatefrompng($image);
        } else if ($img_info->extention == "gif") {
            $src_image = imagecreatefromgif($image);
        }
        // Cropping
        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        // Saving
        imagejpeg($dst_image, $filename);




        $filename = $subfolder . DS . $img_info->first_image_name . "_ORJ." . $img_info->extention;
        // $save_folder = //
        $dst_x = 0;   // X-coordinate of destination point
        $dst_y = 0;   // Y-coordinate of destination point
        $src_x = $imageX; // Crop Start X position in original image
        $src_y = $imageY; // Crop Srart Y position in original image
        $dst_w = $imageWidth; // Yeni Resmin Genişliği
        $dst_h = $imageHeigth; // Yeni Resmin Yüksekliği
        $src_w = $imageWidth; // Crop end X position in original image
        $src_h = $imageHeigth;
        // Crop end Y position in original image
        // Creating an image with true colors having thumb dimensions (to merge with the original image)
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        // Get original image
        $crop = true;
        if ($img_info->extention == "jpg" || $img_info->extention == "jpeg") {
            $src_image = imagecreatefromjpeg($image);
        } else if ($img_info->extention == "png") {
            $src_image = imagecreatefrompng($image);
        } else if ($img_info->extention == "gif") {
            $src_image = imagecreatefromgif($image);
        }
        // Cropping
        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        // Saving
        imagejpeg($dst_image, $filename);
    }

    public function getJobProductGeneralTotal($jobproduct_info) {
        $nproduct_settings = new table_settings_product();
        $totalJobPrice = $this->getJobProductPrice($jobproduct_info);
        $cargo = $this->getjobProductCargoPrice($jobproduct_info);
        if (array_key_exists("function", $cargo)) {
            if ($cargo["function"] == $nproduct_settings::basket) {
                $cargo["cargo"] = 0;
            }
        }
        $extra = $this->_getJobProductExtraPrice($jobproduct_info);
        if (array_key_exists("function", $extra)) {
            if ($extra["function"] == $nproduct_settings::basket) {
                $extra["extra"] = 0;
            }
        }
        $tax = $this->getjobProductTaxPrice($jobproduct_info);
        return $totalJobPrice["total"] + $cargo["cargo"] + $tax["tax"] + $extra["extra"];
    }

    public function setJobProductTable($job_product_info, $show = 10, $start = 0, $end = 10, $total = 30, $message = "") {
//  dnd($product_info);
        $job_product_table = new job_product_table($job_product_info);
        $job_product_table->set_error_message($message);
        $job_product_table_cloumb = [
            "cloumb" => [
                ["thead_title" => "#",
                    "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center"],
                    "tbody_varible" => "checkbox",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Ürün Kodu",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kodu"],
                    "tbody_varible" => "job_product_code",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Ürün Adı",
                    "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün adı"],
                    "tbody_varible" => "job_product_title",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "ürün tipi",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kategorisi"],
                    "tbody_varible" => "job_product_type",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "fiyatı",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün stok sayısı"],
                    "tbody_varible" => "job_product_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "adet",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün gönderim ücreti"],
                    "tbody_varible" => "job_product_amount",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Ödeme Tipi",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "payment_method",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Kargo",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "job_product_cargo_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Vergi",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "job_product_tax_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "İndirimler",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "job_product_discount_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Toplam Fiyat",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "job_product_total_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Ödeme",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün stok sayısı"],
                    "tbody_varible" => "job_product_payment_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Eylemler",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "eylemler"],
                    "tbody_varible" => "actions",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
            ]
        ];

        /*
          ["thead_title" => "Toplam Maliyet",
          "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün fiyatı"],
          "tbody_varible" => "total_cost",
          "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
          ], */

        $job_product_table->set_table_info($job_product_table_cloumb);
        $job_product_table->set_show_item($show);
        $job_product_table->set_start_item($start);
        $job_product_table->set_end_item($end);
        $job_product_table->set_total_item($total);
        $job_product_table->set_table_header(FALSE);
        $job_product_table->set_table_footer(false);

        return $job_product_table->add_table(false);
    }

    public function update_job_payment_method($job_product_id, $payment_method) {

        $job_product_info = $this->getJobProductInfo($job_product_id);
        $product_id = $job_product_info->product_id;
        $jobID = $job_product_info->job_id;
        $product_amount = $job_product_info->product_amount;

        $job_products = $this->getJobProductList($jobID);
        $add_job = false;
        foreach ($job_products as $njob_product) {
            if ($njob_product->job_products_id != $job_product_id) {
                if ($njob_product->product_id == $product_id) {
                    if ($njob_product->job_payment_method == $payment_method) {
                        $add_job = true;
                        $_job_product_id = $njob_product->job_products_id;
                        $_product_amount = $njob_product->product_amount;
                    }
                }
            }
        }

        if ($add_job) {
            $nproduct_amount = $product_amount + $_product_amount;
            $fields = [
                "product_amount" => $nproduct_amount
            ];
            if ($this->update($_job_product_id, $fields)) {
                $this->delete($job_product_id);
                return $_job_product_id;
            } else {
                return false;
            }
        } else {
            $fields = [
                "job_payment_method" => $payment_method
            ];

            if ($this->update($job_product_id, $fields)) {
                return $job_product_id;
            } else {
                return false;
            }
        }
    }

    public function addJobProductPrice($job_products_id, $job_product_price) {
        $fields = [];
        $fields["job_price"] = $job_product_price["total"];
        $fields["job_price_unit"] = $job_product_price["unit"];
        if (is_array($job_product_price))
            if (array_key_exists("discount", $job_product_price)) {
                $fields["discount"] = $job_product_price["discount"];
            }

        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş Kaleminin Fiyatı Eklenemiyor&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductExtraPrice($job_products_id, $extra_info) {
        $fields = [];
        $nproduct_settings = new table_settings_product();

        if (is_array($extra_info)) {
            if (array_key_exists("function", $extra_info)) {
                if ($extra_info["function"] == $nproduct_settings::basket) {
                    $fields["job_extra_price"] = 0;
                } else {
                    $fields["job_extra_price"] = $extra_info["extra"];
                }
                $fields["job_extra_price_discount"] = $extra_info["discount"];
            }
            if (array_key_exists("discount", $extra_info)) {
                $fields["job_extra_price_discount"] = $extra_info["discount"];
            }
        }


        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş Kaleminin Ekstra Fiyatları Eklenemiyor Fiyatı Eklenemiyor&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductCargoPrice($job_products_id, $cargo_info) {
        $fields = [];
        $nproduct_settings = new table_settings_product();
        if (is_array($cargo_info)) {
            if (array_key_exists("function", $cargo_info)) {
                if ($cargo_info["function"] == $nproduct_settings::basket) {
                    $fields["job_cargo_price"] = 0;
                } else {
                    $fields["job_cargo_price"] = $cargo_info["cargo"];
                }
            }
            if (array_key_exists("discount", $cargo_info)) {
                $fields["job_cargo_price_discount"] = $cargo_info["discount"];
            }
        }

        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş Kargo Ücreti Eklenemiyor Fiyatı Eklenemiyor&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductTaxPrice($job_products_id, $tax_info) {
        $fields = [];
        $fields["job_tax_price"] = $tax_info["tax"];
        if (is_array($tax_info))
            if (array_key_exists("discount", $tax_info)) {
                $fields["job_tax_price_discount"] = $tax_info["discount"];
            }
        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Vergi Ücreteleri Eklenemiyor.&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductTotalPrice($job_products_id, $job_product_total_price) {
        $fields = [];
        $fields["job_price_general_total"] = $job_product_total_price["total"];
        if (is_array($job_product_total_price))
            if (array_key_exists("discount", $job_product_total_price)) {
                $fields["job_price_general_total_discount"] = $job_product_total_price["discount"];
            }
        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Toplam İş Ücreti Eklenmiyor.&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductPS($job_products_id, $jsonProductSetting) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        $fields["product_settings"] = $jsonProductSetting;

        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Ürün Ayarları Eklenemedi&jobid=' . $job_products_id);
            return false;
        }
    }

    public function addJobProductPC($job_products_id, $jsonProductCurrency) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        $fields["product_currency"] = $jsonProductCurrency;

        if ($this->update($job_products_id, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Döviz Fiyatları Eklenemedi&jobid=' . $job_products_id);
            return false;
        }
    }

}

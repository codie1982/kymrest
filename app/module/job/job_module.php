<?php

/**
 * Description of job_module
 *
 * @author engin
 */
class job_module {

    public function __construct() {
        return true;
    }

    public function chekc_max_job_count($max_job_count) {
//Saat 00:00 dan itibaren olan iş sayısı karşılaştırması
//confirm_date kullanmamız gerekiyor.
        date_default_timezone_set('Europe/Istanbul');
        $start_time = mktime(0, 0, 0, date("m"), date("d"), date("y"));

        $njob = new table_job();
        $njob->set_count();
        $njob->select();
        $njob->add_condition("confirm_date", $start_time, ">");
        $job_count = $njob->get_alldata(true);
        if ($max_job_count >= $job_count) {
            return true;
        } else {
            return false;
        }
    }

    public function check_job_time_limit($first_hour, $first_minute, $last_hour, $last_minute) {
//girilen saatler arasında kalma kontrolü
//mktime(hour, minute, second, month, day, year, is_dst)
        date_default_timezone_set('Europe/Istanbul');
        $start_time = mktime($first_hour, $first_minute, 0, date("m"), date("d"), date("y"));
        $finish_time = mktime($last_hour, $last_minute, 0, date("m"), date("d"), date("y"));
        $now = time();
        if ($now > $start_time && $now < $finish_time) {
            return true;
        } else {
            return false;
        }
        return true;
    }

    public function get_payment_methods($selected_payment_method = "") {
        $result = [];
        $nproduct_constant = new product_constant();
        $nsettings_job = new table_settings_jobs();
        $job_settings = $nsettings_job->get_data();
        $result["methods"] = "";
        $payment_method = [];

        if ($job_settings->credicart == 1) {
            $payment_method["title"] = "Kredi Kartı";
            $payment_method["short_title"] = "KK";
            $payment_method["method"] = $nproduct_constant::credicart;
            $payment_method["price"] = $job_settings->credicart_price;
            $payment_method["unit"] = $job_settings->credicart_price_unit;
            $result["methods"][] = $payment_method;
            if ($selected_payment_method != "" && ($selected_payment_method == "KK" || $selected_payment_method == $nproduct_constant::credicart)) {
                return $result;
            }
        }
        if ($job_settings->atthedoor == 1) {
            $payment_method["title"] = "Kapıda Ödeme";
            $payment_method["short_title"] = "KO";
            $payment_method["method"] = $nproduct_constant::atthedoor;
            $payment_method["price"] = $job_settings->atthedoor_price;
            $payment_method["unit"] = $job_settings->atthedoor_price_unit;
            $payment_method["options"] = explode(",", $job_settings->atthedoor_options);
            $result["methods"][] = $payment_method;
            if ($selected_payment_method != "" && ($selected_payment_method == "KO" || $selected_payment_method == $nproduct_constant::atthedoor)) {
                return $result;
            }
        }
        if ($job_settings->bank == 1) {

            $payment_method["title"] = "Banka Havalesi";
            $payment_method["short_title"] = "BN";
            $payment_method["method"] = $nproduct_constant::bank;
            $payment_method["price"] = $job_settings->bank_price;
            $payment_method["unit"] = $job_settings->bank_price_unit;
            $result["methods"][] = $payment_method;
            if ($selected_payment_method != "" && ($selected_payment_method == "BN" || $selected_payment_method == $nproduct_constant::bank)) {
                return $result;
            }
        }
        if ($job_settings->inplace == 1) {
            $payment_method["title"] = "Yerinde Ödeme";
            $payment_method["short_title"] = "YO";
            $payment_method["method"] = $nproduct_constant::inplace;
            $payment_method["price"] = $job_settings->inplace_price;
            $payment_method["unit"] = $job_settings->inplace_price_unit;
            $result["methods"][] = $payment_method;
            if ($selected_payment_method != "" && ($selected_payment_method == "YO" || $selected_payment_method == $nproduct_constant::inplace)) {
                return $result;
            }
        }
        return $result;
    }

    public function calculate_payment_methods($job_id, $payment_method) {
        $result = [];
        if (is_array($payment_method["methods"])) {
            return $paymethod_extra_price = $payment_method["methods"][0]["price"];
        } else {
            return $paymethod_extra_price = $payment_method["price"];
        }
    }

    public function calculate_job_total_price($job_price, $job_payment_method_extra_price, $delivery_price) {
        return floatval($job_price) + floatval($job_payment_method_extra_price) + floatval($delivery_price);
    }

    public function calculate_delivery_price($job_delivery_method, $location_difrent_price) {
        if (is_array($job_delivery_method)) {
            $dlPrice = $job_delivery_method["delivery_price"];
        }
        if (is_array($location_difrent_price)) {
            $lcPrice = $location_difrent_price["price"];
        } else {
            $lcPrice = $location_difrent_price;
        }
        return doubleval($dlPrice) + doubleval($lcPrice);
    }

    public function calculate_delivery_location_price($job_price, $job_delivery_method, $founded_location, $justprice = false) {
        $result = [];
        if ($founded_location->value != 0) {
            if ($founded_location->direction == "increase") {
                if ($founded_location->addmethod == "rate") {

                    $result["price"] = doubleval($job_price) * (doubleval($founded_location->value) / 100);
                } else {
                    $result["price"] = doubleval($founded_location->value);
                }
            } else {
                if ($founded_location->addmethod == "rate") {
                    $result["price"] = -1 * (doubleval($job_price) * (doubleval($founded_location->value) / 100));
                } else {
                    $result["price"] = -1 * doubleval($founded_location->value);
                }
            }
        } else {
            $result["price"] = $job_delivery_method->delivery_price;
            $result["unit"] = $job_delivery_method->delivery_price_unit;
        }
        if ($justprice) {
            return $result["price"];
        } else {
            return $result;
        }
    }

    public function get_delivery_method($selected_delivery_method_type) {
        $result = [];
        $nproduct_constant = new product_constant();
//        $nsettings_job = new table_settings_jobs();
//
//        $nsettings_job->add_filter("job_limit_delivery_location");
//        $nsettings_job->select();
//        $job_settings = $nsettings_job->get_alldata();
//        $job_limit_delivery_location = $job_settings->job_limit_delivery_location;

        $nsettings_delivery = new table_settings_transport();
        $nsettings_delivery->select();
        $delivery_info = $nsettings_delivery->get_alldata(true);
        if ($delivery_info->no_transport == 0) {
            $transport_price = exchange_rate($delivery_info->transport_price, $delivery_info->transport_price_unit);
            $transport_price_unit = default_currency();
            $transport_extra_price_key = $selected_delivery_method_type . "_price";
            $transport_extra_price_unit_key = $selected_delivery_method_type . "_price_unit";
            $transport_extra_in_key = $selected_delivery_method_type . "_in";
            $transport_extra_web_key = $selected_delivery_method_type . "_web";
            $transport_extra_application_key = $selected_delivery_method_type . "_application";

            $transport_extra_price = exchange_rate($delivery_info->$transport_extra_price_key, $delivery_info->$transport_extra_price_unit_key);
            $result["methods"] = $selected_delivery_method_type;
            $result["delivery_price"] = $transport_price;
            $result["delivery_price_unit"] = $transport_price_unit;
            $result["extra_price"] = $transport_extra_price;
            $result["extra_price_unit"] = $transport_price_unit;

            if ($delivery_info->transport_location_price) {
                $ndelivery_location = new table_settings_transport_location();
                $ndelivery_location->select();
                $locations = $ndelivery_location->get_alldata();
                $result["locations"] = $locations;
            }


            return $result;
        } else {
            return 0;
        }
    }

    public function location_diffrent($delivery_locations, $customer_adres_id = 0) {
        $ncustomer_adres = new table_customer_adres();
        $ncustomer_adres->select();
        $ncustomer_adres->add_condition("customer_adres_id", $customer_adres_id);

        if ($customer_adres_data = $ncustomer_adres->get_alldata(true)) {
            $i = 0;
            $ifound = "yok";
            foreach ($delivery_locations as $delivery_location) {

                if ($delivery_location->province != 0) {
                    if ($delivery_location->province == $customer_adres_data->province) {
                        $ifound = "var";
                    } else {
                        $ifound = "yok";
                    }
                }
                if ($delivery_location->district != 0) {
                    if ($delivery_location->district == $customer_adres_data->district) {
                        $ifound = "var";
                    } else {
                        $ifound = "yok";
                    }
                }
                if ($delivery_location->neighborhood != 0) {
                    if ($delivery_location->neighborhood == $customer_adres_data->neighborhood) {
                        $ifound = "var";
                    } else {
                        $ifound = "yok";
                    }
                } else {
                    
                }
                if ($ifound == "var") {
                    $selected_adres = $delivery_location;
                    break;
                } else {
                    $selected_adres = [];
                }
                $i++;
            }
            return $selected_adres;
        } else {
            return false;
        }
    }

    public function get_job_price($jobid, $just_price = false) {
        $njob = new table_job();
        $njob->add_filter("job_number");
        $njob->select();
        $njob->add_condition("job_id", $jobid);
        $total_price = [];
        $job_price = 0;
        $job_price_unit = default_currency();
        if ($jobData = $njob->get_alldata(true)) {
            if ($jobData->job_number == "-1") {
//Sipariş Sepette Güncel Fiyatlara göre hesaplama yapmamız gerekli
                $njobProducts = new table_job_products();
                $njobProducts->add_filter("job_products_id");
                $njobProducts->select();
                $njobProducts->add_condition("job_id", $jobid);
                $jobroductsData = $njobProducts->get_alldata();
                $nproduct_module = new product_module();
                if (!empty($jobroductsData))
                    foreach ($jobroductsData as $data) {
                        $product_sales_price_options = $this->get_job_product_price($jobData, $data->job_products_id);
                        $job_price = $job_price + $product_sales_price_options;
                    }

                $result = $just_price ? $job_price : $total_price = ["price" => $job_price, "price_unit" => $job_price_unit];
                return $result;
            } else {
//Sipariş Onaylanmış Sabit Fiyatlara göre hesaplama yapmamız gerekli
            }
        } else {
            return false;
        }
    }

    public function get_job_total_price($jobid) {
        $njob = new table_job();
        $njob->add_filter("job_number");
        $njob->select();
        $njob->add_condition("job_id", $jobid);
        $total_price = [];
        $job_price = 0;
        $job_price_unit = default_currency();
        if ($jobData = $njob->get_alldata(true)) {
            if ($jobData->job_number == "-1") {
//Sipariş Sepette Güncel Fiyatlara göre hesaplama yapmamız gerekli
                $njobProducts = new table_job_products();
                $njobProducts->add_filter("job_products_id");
                $njobProducts->select();
                $njobProducts->add_condition("job_id", $jobid);
                $jobroductsData = $njobProducts->get_alldata();
                $nproduct_module = new product_module();
                if (!empty($jobroductsData))
                    foreach ($jobroductsData as $data) {
                        $product_sales_price_options = $this->get_job_product_price($jobData, $data->job_products_id);

                        $job_price = $job_price + $product_sales_price_options;
                    }
                $total_price = ["total_price" => $job_price, "total_price_unit" => $job_price_unit];
                return $total_price;
            } else {
//Sipariş Onaylanmış Sabit Fiyatlara göre hesaplama yapmamız gerekli
            }
        } else {
            return false;
        }
    }

    public function job_product_price($job_product_id, $job_number = "-1") {
        if ($job_number == "-1") {

            $njobProducts = new table_job_products();
            $njobProducts->add_filter("product_id");
            $njobProducts->add_filter("amount");
            $njobProducts->select();
            $njobProducts->add_condition("job_products_id", $job_product_id);
            $jobroductData = $njobProducts->get_alldata(true);


            $nproduct_module = new product_module();
            $product_sales_price = $nproduct_module->get_product_price($jobroductData->product_id);

            $product_sales_price_options = $this->calculate_product_options(
                    $product_sales_price["product_price"],
                    $this->get_job_product_options($job_product_id));

            return $product_sales_price_options * $jobroductData->amount;
        } else {
//Sipariş Onaylanmış Sabit Fiyatlara göre hesaplama yapmamız gerekli
        }
    }

    public function get_job_product_options($job_product_id) {
        $njobProductOptions = new table_job_products_price_options_value();
        $njobProductOptions->select();
        $njobProductOptions->add_condition("job_products_id", $job_product_id);
        if ($options = $njobProductOptions->get_alldata()) {
            return $options;
        } else {
            return false;
        }
    }

    private function calculate_product_options($product_sales_price, $options = []) {
        if (!empty($options)) {
            if ($options->value != 0) {
                if ($options->direction == "increase") { //Arttrımak
                    if ($options->type == "minus") { //sayısal
                        return floatval($product_sales_price) + floatval($options->value);
                    } else if ($options->type == "rate") {//Oransal
                        return floatval($product_sales_price) + mtm::rate($product_sales_price, $options->value);
                    }
                } else if ($options->direction == "decrease") {//Azaltmak
                    if ($options->type == "minus") {//Sayısal
                        return floatval($product_sales_price) - floatval($options->value);
                    } else if ($options->type == "rate") {//Oransal
                        return parseFloat($product_sales_price) - mtm::rate($product_sales_price, $options->value);
                    }
                }
            } else {
                return $product_sales_price;
            }
        } else {
            return $product_sales_price;
        }
    }

//by eki ile where koşulunu sağlayalım
    public function get_jobs_bycustomer($customer_id) {
        $ntable = new table_job();
        $ntable->select();
        $ntable->add_condition("customer_id", $customer_id);
        if ($data = $ntable->get_alldata()) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_job_products_items($jobID) {
        $ntable = new table_job_products();
        $ntable->select();
        $ntable->add_condition("job_id", $jobID);
        if ($data = $ntable->get_alldata()) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_job_product_items($job_product_id) {
        $ntable = new table_job_products();
        $ntable->select();
        $ntable->add_condition("job_products_id", $job_product_id);
        if ($data = $ntable->get_alldata(true)) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_job_products_options($job_product_id) {
        $ntable = new table_job_products_price_options_value();
        $ntable->select();
        $ntable->add_condition("job_products_id", $job_product_id);
        if ($data = $ntable->get_alldata()) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_job_products_option($option_id) {
        $ntable = new table_job_products_price_options_value();
        $ntable->select();
        $ntable->add_condition("job_product_price_options_value_id", $option_id);
        if ($data = $ntable->get_alldata()) {
            return $data;
        } else {
            return false;
        }
    }

    public function get_job_product_option_detail($jobData, $job_product) {
        $job_product_options = $this->get_job_products_options($job_product->job_products_id);
        if ($jobData->job_number == "-1") {
            $product_module = new product_module();
            $product_info = $product_module->get_product_detail($job_product->product_id);
            $value = [];
            $value_item = [];
            if (!empty($job_product_options)) {
                foreach ($job_product_options as $job_product_option) {
//dnd($job_product_option);
                    $group_name = $job_product_option->job_product_price_group_title;
                    $group_info = $product_module->get_product_price_group_detail($job_product_option->job_product_price_group_id);
                    $option_info = $product_module->get_product_price_option_detail($job_product_option->job_product_price_group_option_id);
                    $options[] = [
                        "job_product_price_options_value_id" => $job_product_option->job_product_price_options_value_id,
                        "group_name" => ucfirst(strtolower($group_info->group_title)),
                        "title" => ucfirst(strtolower($option_info->product_price_title)),
                        "value" => $option_info->value,
                        "value_fixed" => number_format($option_info->value, 2),
                        "direction" => $option_info->direction,
                        "type" => $option_info->type,
                    ];
                }
            }
        } else {

            $value = [];
            $value_item = [];
            if (!empty($job_product_options)) {
                foreach ($job_product_options as $job_product_option) {
//dnd($job_product_option);
                    $group_name = $job_product_option->job_product_price_group_title;
                    $options[] = [
                        "job_product_price_options_value_id" => $job_product_option->job_product_price_options_value_id,
                        "group_name" => $job_product_option->job_product_price_group_title,
                        "title" => $job_product_option->price_title,
                        "value" => $job_product_option->value,
                        "value_fixed" => number_format($job_product_option->value, 2),
                        "direction" => $job_product_option->direction,
                        "type" => $job_product_option->type,
                    ];
                }
            }
        }

        return $options;
    }

    public function get_job_product_price($jobData, $job_products_id) {
        if ($jobData->job_number == "-1") {

            $njobProducts = new table_job_products();
            $njobProducts->add_filter("product_id");
            $njobProducts->add_filter("amount");
            $njobProducts->select();
            $njobProducts->add_condition("job_products_id", $job_products_id);
            $jobproductData = $njobProducts->get_alldata(true);


            $nproduct_module = new product_module();
            $product_sales_price = $nproduct_module->get_product_sales_price($jobproductData->product_id);

            $product_sales_price_options = $this->calculate_product_options(
                    $product_sales_price["product_sales_price"],
                    $this->get_job_product_options($job_products_id));

            return $product_sales_price_options * $jobproductData->amount;
        } else {
            return null;
        }
    }

    public function get_job_product_detail($jobData) {
        $result = [];
        if ($jobData->job_number == "-1") {
            if ($job_products = $this->get_job_products_items($jobData->job_id)) {
                foreach ($job_products as $job_product) {
                    $product_module = new product_module();
                    $nproduct_constant = new product_constant();
//Ürün Özelllikleri
                    $product_info = $product_module->get_product_detail($job_product->product_id);
//Sipariş Kaleminin Fiyat Özellikleri
                    $job_product_price = $this->get_job_product_price($jobData, $job_product->job_products_id);
//Sipariş Kaleminin Detayları
                    if ($product_info->product_price_type == $nproduct_constant::options) {
                        $result[] = [
                            "job_product_id" => $job_product->job_products_id,
                            "product_id" => $job_product->product_id,
                            "product_title" => $product_module->get_product_name($product_info->product_name),
                            "product_sub_title" => $product_module->get_product_subname($product_info->product_sub_name),
                            "job_product_price" => $job_product_price,
                            "job_product_price_fixed" => number_format($job_product_price, 2),
                            "job_product_price_unit" => default_currency(),
                            "amount" => $job_product->amount,
                            "options" => $this->get_job_product_option_detail($jobData, $job_product),
                        ];
                    } else {
                        $result[] = [
                            "job_product_id" => $job_product->job_products_id,
                            "product_id" => $job_product->product_id,
                            "product_title" => $product_module->get_product_name($product_info->product_name),
                            "product_sub_title" => $product_module->get_product_subname($product_info->product_sub_name),
                            "job_product_price" => $job_product_price,
                            "job_product_price_fixed" => number_format($job_product_price, 2),
                            "job_product_price_unit" => default_currency(),
                            "amount" => $job_product->amount,
                        ];
                    }
                }
            }
        } else {
            $result = [];
        }


        return $result;
    }

    public function get_job_payment_method($jobData) {
        $result = [];
        if ($jobData->job_number == "-1") {
            $result = null;
        } else {
            $result = ["method" => "", "extra_price" => "", "extra_price_unit" => "", "payment_method_options" => ""];
        }

        return $result;
    }

    public function get_job_delivery_method($jobData) {
        $result = [];
        if ($jobData->job_number == "-1") {
            $result = null;
        } else {
            $result = [
                "delivery_type" => "",
                "delivery_price" => "",
                "delivery_price_unit" => "",
                "location" =>
                [
                    "customer_adres_id" => "",
                    "province" => "",
                    "district" => "",
                    "neighborhood" => "",
                    "description" => "",
                    "mail_code" => "",
                    "street" => "",
                    "location_extra_price" => "",
                    "location_extra_price_unit" => "",
                ]
            ];
        }
        return $result;
    }

    public function get_job_detail($jobID) {
        $njob = new table_job();
        $njob->select();
        $njob->add_condition("job_id", $jobID);
        if ($jobData = $njob->get_alldata(true)) {
            $jobPriceInfo = $this->get_job_total_price($jobID);
            if ($jobData->job_number == "-1") {
                return [
                    "job_id" => $jobID,
                    "customer_id" => $customer_id,
                    "total_price" => $jobPriceInfo["total_price"],
                    "total_price_fixed" => number_format($jobPriceInfo["total_price"], 2),
                    "total_price_unit" => $jobPriceInfo["total_price_unit"],
                    "discount" => null,
                    "tax_rate" => null,
                    "payment_method" => null,
                    "delivery_method" => null,
                    "job_products" => $this->get_job_product_detail($jobData)
                ];
            } else {
                return [
                    "job_id" => $jobID,
                    "customer_id" => $customer_id,
                    "total_price" => $jobData->job_price,
                    "total_price_fixed" => number_format($jobData->job_price, 2),
                    "total_price_unit" => $jobData->job_price_unit,
                    "discount" => "",
                    "tax_rate" => "",
                    "payment_method" => $this->get_job_payment_method($jobData),
                    "delivery_method" => $this->get_job_delivery_method($jobData),
                    "job_products" => $this->get_job_product_detail($jobData)
                ];
            }
        } else {
            throw new Exception("NO_JOB");
        }
    }

    public function set_job_product_format($data) {

        $product_module = new product_module();

        $job_products[] = [
            "job_product_id" => $data->job_products_id,
            "product_id" => $data->product_id,
            "product_title" => $nproduct_module->get_product_name($product_info->product_name),
            "product_sub_title" => $nproduct_module->get_product_subname($product_info->product_sub_name),
            "job_product_price" => $job_products_price,
            "job_product_price_fixed" => number_format($job_products_price, 2),
            "job_product_price_unit" => default_currency(),
            "amount" => $jpdata->amount,
            "options" => $options
        ];
    }

    public function get_job_products_count($jobID) {
        $table = new table_job_products();
        $table->set_count();
        $table->select();
        $table->add_condition("job_id", $jobID);
        if ($data = $table->get_alldata(true)) {
            return $data;
        } else {
            return false;
        }
    }

    public function set_job_number() {
        return rand(999, 9999) . "-" . rand(999, 9999) . "-" . rand(999, 9999) . "-" . rand(999, 9999);
    }

}

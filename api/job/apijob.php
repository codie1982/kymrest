<?php

header('Content-Type: application/json');

/**
 * Description of apijob
 *
 * @author engin
 */
class apijob {

    public function addtocardAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;

                        

                        $customer_id = $postdata->customer_id;
                        $product_id = $postdata->product_id;
                        $amount = $postdata->amount;

                        $selected_payment_method = $postdata->job_payment_method;
                        $job_product_extra_price = $postdata->job_product_extra_price;
                        $job_product_extra_price_unit = $postdata->job_product_extra_price_unit;

                        $job_product_delivery_type = $postdata->job_product_delivery_type;
                        $job_product_delivery_price = $postdata->job_product_delivery_price;
                        $job_product_delivery_price_unit = $postdata->job_product_delivery_price_unit;
                        $job_product_delivery_price_in = $postdata->job_product_delivery_price_in;


                        $options = $postdata->options;

                        $nproduct_constant = new product_constant();

                        $nproduct_settings = new table_settings_product();
                        $nproduct_settings->select();
                        $product_settings = $nproduct_settings->get_alldata(true);

                        $njob_settings = new table_settings_jobs();
                        $njob_settings->select();
                        $job_settings = $njob_settings->get_alldata(true);


                        //Kullanıcı Kontrolu
                        $ncustomer = new table_customer();
                        $ncustomer->select();
                        $ncustomer->add_condition("customer_id", $customer_id);
                        $ncustomer->add_condition("type", "personel");
                        $ncustomer->add_join("customer_personel", "customer_id");

                        $ncustomer->add_condition("public", 1, "=", "customer");
                        if (!$customer_data = $ncustomer->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_CUSTOMER";
                            $data["error"] = true;
                            $data["message"] = "Sistemde Geçerli bir kaydınız bulunmuyor. Bu konu ile ilgili olarak yönetim ile görüşebilirsiniz.";
                        }

                        //Kullanıcın satış yapabilir kontrolü
                        if ($customer_data->sales != 1) {
                            $nvalidate->addError();
                            $data["type"] = "NO_SALES";
                            $data["error"] = true;
                            $data["message"] = "Sistem üzerinde alış veriş yapmanız kısıtlanmış durumda. Bu konu ile ilgili olarak yönetim ile görüşmelisiniz.";
                        }
                        //adet kontrolü 0'dan büyük olmalı
                        if ($postdata->amount <= 0) {
                            $nvalidate->addError();
                            $data["type"] = "ZERO_AMOUNT";
                            $data["error"] = true;
                            $data["message"] = "Ürün ile girdiğiniz adet sayısı en az 1 olmalıdır.";
                        }

                        //ürün kontrollü
                        $nproduct = new table_product();
                        $nproduct->select();
                        $nproduct->add_condition("product_id", $product_id);
                        $nproduct->add_condition("public", 1);
                        if (!$product_info = $nproduct->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_PRODUCT";
                            $data["error"] = true;
                            $data["message"] = "Seçmiş olduğunuz ürüne erişilemiyor. Ürün kısa süreliğine durdurulmuş veya tamamen kaldırılmış olabilir.";
                        }
                        if ($product_info->product_nostock == 0) {
                            if ($product_info->product_stock < $amount) {
                                $nvalidate->addError();
                                $data["type"] = "NO_AMOUNT";
                                $data["error"] = true;
                                $data["message"] = 'Belirlemiş olduğunuz ürün sayısı Mevcut stoktaki ürün sayısından fazladır. Ürün stoğunda sadece ' . $product_info->product_stock . ' adet ürün bulunmaktadır.';
                            }
                        }
                        //Kullanıcının açık iş kartı varmı yokmu


                        if ($nvalidate->passed()) {
                            $njob = new table_job();
                            $njob->select();
                            $njob->add_condition("customer_id", $customer_id);
                            $njob->add_condition("job_number", "-1");
                            $njob->add_condition("complete", "0");
                            $njob->add_limit_start(1);
                            $njob->add_direction("DESC");
                            $jobDBData = $njob->get_alldata(true);

                            //iş ID sini oluşturuyoruz

                            if (empty($jobDBData)) {
                                $jobseccode = seccode();
                                data::add_post_data("job_fields", "customer_id", $customer_id);
                                data::add_post_data("job_fields", "job_seccode", $jobseccode);
                                data::add_post_data("job_fields", "users_id", $customer_id);
                                $rawdata = data::get_postdata();
                                $nprepare_job_data = new prepare_job_data();
                                $control_module = $nprepare_job_data->set_new_job_data($rawdata);
                                $job_data = data::get_data($control_module);
                                $jobID = data::insert_data("job", $job_data["job"]);
                                //dnd($jobID, true);
                            } else {
                                $jobID = $jobDBData->job_id;
                                $jobseccode = $jobDBData->job_seccode;
                            }

                            //ürünün listede ekli olup olmadığını kontrol etmemiz gerekiyor
                            //aynı ürün varsa adetini yükseltmemiz lazım

                            $nproduct_module = new product_module();
                            $job_module = new job_module();
                            $product_price = $nproduct_module->get_product_price($product_id);
                            $product_discount = $nproduct_module->get_product_discount($product_id);
                            $product_tax_price = $nproduct_module->get_product_tax_price($product_id);
                            $product_sales_price = $nproduct_module->get_product_sales_price($product_id);

                            $payment_method = $job_module->get_payment_methods();
                            $product_delivery = $nproduct_module->get_product_transport($product_id);


                            data::add_post_data("job_product_fields", "secret_number", $jobID);
                            data::add_post_data("job_product_fields", "job_id", $jobID);
                            data::add_post_data("job_product_fields", "product_id", $product_id);
                            data::add_post_data("job_product_fields", "product_type", $product_info->product_type);
                            data::add_post_data("job_product_fields", "customer_id", $customer_id);
                            data::add_post_data("job_product_fields", "amount", $amount);
                            data::add_post_data("job_product_fields", "product_price_type", "-1");

                            data::add_post_data("job_product_fields", "product_price", "");
                            data::add_post_data("job_product_fields", "product_price_unit", "");


                            data::add_post_data("job_product_fields", "discount", "");
                            data::add_post_data("job_product_fields", "discount_type", "");
                            data::add_post_data("job_product_fields", "discount_rate", "");

                            data::add_post_data("job_product_fields", "product_tax_price", "");
                            data::add_post_data("job_product_fields", "product_tax_price_unit", "");
                            data::add_post_data("job_product_fields", "product_tax_rate", "");
                            data::add_post_data("job_product_fields", "product_intax", "");

                            data::add_post_data("job_product_fields", "product_sales_price", "");


                            // data::add_post_data("job_product_fields", "payment_method_workable_type", $payment_method["type"]);
                            data::add_post_data("job_product_fields", "payment_method", "");
                            data::add_post_data("job_product_fields", "product_extra_price", "");
                            data::add_post_data("job_product_fields", "product_extra_price_unit", "");


                            // data::add_post_data("job_product_fields", "product_delivery_workable_type", $product_delivery["type"]);
                            data::add_post_data("job_product_fields", "product_delivery_type", "");
                            data::add_post_data("job_product_fields", "product_delivery_price", "");
                            data::add_post_data("job_product_fields", "product_delivery_price_unit", "");
                            data::add_post_data("job_product_fields", "product_delivery_price_in", "");
                            data::add_post_data("job_product_fields", "users_id", $customer_id);


                            $rawdata = data::get_postdata();
                            $nprepare_job_data = new prepare_job_data();
                            $control_module = $nprepare_job_data->set_new_job_data($rawdata);
                            $job_product_data = data::get_data($control_module);

                            if (!$job_product_id = data::insert_data("job_products", $job_product_data["job_products"])) {
                                $nvalidate->addError();
                                $data["type"] = "NO_JOBPRODUCT";
                                $data["error"] = true;
                                $data["message"] = 'Seçili Ürün İş Kartına Kayıt edilemedi. Lütfen tekrar deneyin.';
                            }

                            if (!empty($options))
                                foreach ($options as $option) {
                                    $secret_number = rand(99999, 9999999);
                                    $ngrp = new table_product_price_group();
                                    $ngrp->add_filter("group_title");
                                    $ngrp->select();
                                    $ngrp->add_condition("product_price_group_id", $option->group_id);
                                    $grp_info = $ngrp->get_alldata(true);
                                    data::add_post_data("job_products_price_options_value_fields", "secret_number", $secret_number, $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "job_id", $jobID, $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "job_products_id", $job_product_id, $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "job_product_price_group_id", $option->group_id, $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "job_product_price_group_option_id", $option->option_id, $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "job_product_price_group_title", "", $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "price_title", "", $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "direction", "", $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "type", "", $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "value", "", $secret_number);
                                    data::add_post_data("job_products_price_options_value_fields", "users_id", $customer_id, $secret_number);
                                    $rawdata = data::get_postdata();
                                    $nprepare_job_data = new prepare_product_data();
                                    $control_module = $nprepare_job_data->set_new_product_data($rawdata);
                                    $job_product_options_data = data::get_data($control_module);
                                }


                            if (isset($job_product_options_data["job"])) {
                                unset($job_product_options_data["job"]);
                            }

                            if (isset($job_product_options_data["job_products"])) {
                                unset($job_product_options_data["job_products"]);
                            }

                            if (!empty($job_product_options_data["job_products_price_options_value"]))
                                foreach ($job_product_options_data as $table_name => $_dt) {
                                    foreach ($_dt as $key => $dt) {
                                        data::insert_data($table_name, $dt);
                                    }
                                }

                            //seçenekleri ekle
                            $jobModule = new job_module();
                            $data["jobid"] = $jobID;

                            $data["job_detail"] = $jobModule->get_job_detail($jobID);
                            $data["jobseccode"] = $jobseccode;
                            $data["type"] = "ADD_TO_CARD";
                            $data["error"] = false;
                            $data["message"] = "Sipariş Başarıyla Sipariş Kartına Eklendi";
                        } else {
                            dnd($postdata, true);
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $getdata[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $getdata[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function getjobdetailAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        try {
                            $jobID = $postdata->job_id;
                            $jobseccode = $postdata->jobseccode;
                            $customer_id = $postdata->customer_id;
                            $jobModule = new job_module();
                            $job_detail = $jobModule->get_job_detail($jobID);
                            $data["job_detail"] = $job_detail;
                            $data["error"] = false;
                            $data["message"] = "Sipariş Detayları Başarıyla Alındı";
                        } catch (Exception $ex) {
                            switch ($ex->getMessage()) {
                                case"NO_JOB":
                                    $data["type"] = "NO_JOB";
                                    $data["error"] = true;
                                    $data["message"] = "Siparişe Ulaşılamıyor";
                                    break;
                            }
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $getdata[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $getdata[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function removejobproductitemAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $job_product_id = $postdata->job_product_id;
                        $customer_id = $postdata->customer_id;
                        $njob_products = new table_job_products();
                        $njob_products->add_filter("job_products_id");
                        $njob_products->add_filter("job_id");
                        $njob_products->add_filter("product_price_type");
                        $njob_products->select();
                        $njob_products->add_condition("job_products_id", $job_product_id);
                        $njob_products->add_condition("customer_id", $customer_id);

                        if ($job_product_info = $njob_products->get_alldata(true)) {
                            $jobID = $job_product_info->job_id;
                            //evriliyor
                            $job_product_id = $job_product_info->job_products_id;
                            if (data::remove("job_products", $job_product_id)) {
                                if ($job_product_info->product_price_type == "options") {
                                    data::remove("job_products_price_options_value", ["job_products_id" => $job_product_id]);
                                }
                                $jobModule = new job_module();
                                $job_products_count = $jobModule->get_job_products_count($jobID);
                                if ($job_products_count == 0) {
                                    //iş de hiç ürün kalmaz ise İşi'de Kaldır tamamen
                                    if (data::remove("job", $jobID)) {
                                        $data["type"] = "REMOVE_JOB";
                                        $data["error"] = false;
                                        $data["message"] = "Ürün Sepetten Başarıyla Kaldırılmıştır.";
                                    } else {
                                        $data["type"] = "NO_REMOVE_JOB";
                                        $data["error"] = false;
                                        $data["message"] = "Ürün Sepetten Başarıyla Kaldırılmıştır.";
                                    }
                                } else {

                                    if ($job_detail = $jobModule->get_job_detail($jobID)) {
                                        $data["job_detail"] = $job_detail;
                                        $data["type"] = "REMOVE_ITEM";
                                        $data["error"] = false;
                                        $data["message"] = "Ürün Sepetten Başarıyla Kaldırılmıştır.";
                                    } else {
                                        $data["type"] = "NO_JOB";
                                        $data["error"] = true;
                                        $data["message"] = "Talep Edilen Siparişe Ulaşılamıyor";
                                    }
                                }
                            } else {
                                $data["type"] = "REMOVE_FAILED";
                                $data["error"] = false;
                                $data["message"] = "Ürün Sepetten Kaldırılmamıştır. Lütfen tekrar deneyin.";
                            }
                        } else {
                            $data["type"] = "NO_JOB_ITEM";
                            $data["error"] = false;
                            $data["message"] = "Sepetteki Ürüne Ulaşılamıyor.";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $getdata[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $getdata[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function jobcompleteAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        
                        $customer_id = $postdata->user_id;
                        $job_id = $postdata->job_id;
                        $selected_payment_method = $postdata->payment_method;
                        $selected_payment_method_options = $postdata->payment_method_opiton;
                        $credi_card_id = $postdata->credi_card; // Ödeme Yöntemi "KK" ise
                        $selected_delivery_method_type = $postdata->delivery_method;
                        $customer_adres_id = $postdata->customer_adres;
                        $job_note = $postdata->job_note;

                        //Kullanıcı aktif mi
                        //Kullanıcı satış için kısıtlamalımı
                        //iş numara almışmı
                        //iş ürünleri aktif ve stokları yeterlimi
                        //işin ücretini hesapla
                        //işin ürünlerin ücretlerini hesapla
                        //ödeme yöntemi extra ücretleri hesapla
                        //gönderim ücretini hesapla
                        //gönderim için lokasyon farklılıklarını hesapla
                        //iş kısıtlamaları vermı
                        //iş lokasyon ile kısıtlımı
                        //iş iş ayarlarına uygunmu
                        //kullanıcı adresini doğrula
                        //iş'e ;
                        //iş ücretini
                        //ödeme yöntemini
                        //gönderim ücretini
                        //toplam iş miktarını
                        //iş ürünlerinin ücretlerini
                        //ürünlerin seçenek fiyatlarını tamamla ve sabit yaz
                        //kullanıcıya mail gönder
                        //sistem yöneticisine mail gönder
                        //nodejs sunucusuna event oluştur
                        //iş numarasını güncelle
                        //siparişi onayla





                        $nproduct_constant = new product_constant();

                        $nproduct_settings = new table_settings_product();
                        $nproduct_settings->select();
                        $product_settings = $nproduct_settings->get_alldata(true);

                        $njob_settings = new table_settings_jobs();
                        $njob_settings->select();
                        $job_settings = $njob_settings->get_alldata(true);


                        //Kullanıcı Uygunluk Kontrolü
                        $ncustomer = new table_customer();
                        $ncustomer->select();
                        $ncustomer->add_condition("customer_id", $customer_id);
                        $ncustomer->add_condition("type", "personel");
                        $ncustomer->add_join("customer_personel", "customer_id");
                        $ncustomer->add_condition("public", 1, "=", "customer");
                        $ncustomer->add_condition("sales", 1, "=", "customer");
                        if (!$customer_data = $ncustomer->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_CUSTOMER";
                            $data["error"] = true;
                            $data["message"] = "Sistemde Geçerli bir kaydınız bulunmuyor. Bu konu ile ilgili olarak yönetim ile görüşebilirsiniz.";
                        }

                        // Müşteri Adresi Kayıtlımı // Doğrulanmış mı?

                        $ncustomer_adres = new table_customer_adres();
                        $ncustomer_adres->select();
                        $ncustomer_adres->add_condition("customer_adres_id", $customer_adres_id);
                        if (!$customer_adres_info = $ncustomer_adres->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_CUSTOMER_ADRES";
                            $data["error"] = true;
                            $data["message"] = "Kullanıcı Adresine Ulaşılamıyor. Yeni bir adres girmeyi deneyin.";
                        }



                        // 
                        //                         İş Numarası Kontrolü
                        //
                        $njob = new table_job();
                        $njob->add_filter("job_number");
                        $njob->select();
                        $njob->add_condition("job_id", $job_id);
                        $job_number_data = $njob->get_alldata(true);
                        if ($job_number_data->job_number != "-1") {
                            $nvalidate->addError();
                            $data["type"] = "TRUE_JOB_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Sipariş - 'bir sipariş numarası' almış durumda. Bu şekilde bir sipariş onaylaması olmaz";
                        }



                        //Sipariş ürünleri
                        $njob_product = new table_job_products();
                        $njob_product->select();
                        $njob_product->add_condition("job_id", $job_id);
                        //$njob_product->add_condition("public", 1, "=", "product");
                        $njob_product->add_join("product", "product_id");

                        if ($job_products_info = $njob_product->get_alldata()) {

                            foreach ($job_products_info as $product) {
                                //Sipariş ürünleri Yönetici Kısıtlaması varmı
                                if ($product->admin_public == 1) {
                                    //Sipariş ürünleri Aktif satışdamı
                                    if ($product->public == 1) {
                                        //Sipariş ürünleri Stok kontrolleri
                                        if ($product->product_nostock != 1) {
                                            if ($product->amount > $product->product_stock) {
                                                $nvalidate->addError();
                                                $data["type"] = "NO_STOCK";
                                                $data["error"] = true;
                                                $data["error_product_id"] = $product->product_id;
                                                $data["message"] = ucfirst(strtolower($product->product_name)) . "Bu ürün için yeterli stok bulunmuyor.
                                                    Ürünün adet değerini max. " . $product->product_stock . " olarak değiştirip tekrar deneyin";
                                            }
                                        }
                                    } else {
                                        $nvalidate->addError();
                                        $data["type"] = "NO_PUBLIC";
                                        $data["error"] = true;
                                        $data["error_product_id"] = $product->product_id;
                                        $data["message"] = ucfirst(strtolower($product->product_name)) . " İsimli Ürün 
                                        kısa süreliğine durdurulmuş olabilir. Bu Ürün listenizden kaldırıp tekrar deneyin";
                                    }
                                } else {
                                    $nvalidate->addError();
                                    $data["type"] = "NO_ADMIN_PUBLIC";
                                    $data["error"] = true;
                                    $data["error_product_id"] = $product->product_id;
                                    $data["message"] = ucfirst(strtolower($product->product_name)) . " İsimli Ürün 
                                        kısa yönetim tarafından listeden çıkarılmı. Bu Ürünü listenizden kaldırıp tekrar deneyin";
                                }
                            }
                        }

                        //iş Ayarlarının Kontrolünüde yapmamız lazım
                        //TODO:Sipariş Ayarları
                        //  --Sipariş Kırılımları Saate göre 
                        //  --Günlük sipariş sayısı sınırlaması
                        //  --Son sipariş saati
                        //  --Lokasyon sınırlaması -- ** -- 
                        //  --Müşteri Adresinin Sorgusu
                        //TODO:Gönderim Ayarları
                        //  --lokasyon farklılıkları --**--
                        //  
                        //  
                        //  
                        //  ************************
                        //  --extra ücretlendirmeler --**--
                        //  --Gönderi Ücretlendirmesi --**--
                        $job_module = new job_module();
                        $nsettings_job = new table_settings_jobs();
                        $nsettings_job->select();
                        $settings_job_info = $nsettings_job->get_alldata(true);
                        //dnd($settings_job_info);


                        $nsettings_delivery = new table_settings_transport();
                        $nsettings_delivery->add_filter("job_limit_delivery_location");
                        $nsettings_delivery->select();
                        $delivery_info = $nsettings_delivery->get_alldata(true);

                        //Lokasyon Sınırlaması Kontrolü
                        if ($delivery_info->job_limit_delivery_location) {
                            $job_delivery_method = $job_module->get_delivery_method($selected_delivery_method_type);
                            if (!empty($job_delivery_method["locations"])) {
                                $founded_location = $job_module->location_diffrent($job_delivery_method["locations"], $customer_adres_id);
                                if (!$founded_location) {
                                    $nvalidate->addError();
                                    $data["type"] = "NO_LOCATION";
                                    $data["error"] = true;
                                    $data["message"] = "Gönderim Adresi İzin verilen alanlardan birinde bulunmuyor. Gönderim adresinizi izin verilen alanların birinden seçmeye özen gösterin.";
                                }
                            }
                        }


                        //Maksimum Sipariş sayısı Kontrolü
                        if ($delivery_info->user_job_limit == 1) {

                            if (!$job_module->chekc_max_job_count($settings_job_info->max_job_count)) {
                                $nvalidate->addError();
                                $data["type"] = "MAX_JOB_COUNT";
                                $data["error"] = true;
                                $data["message"] = "Maalesef Bu günlük daha fazla sipariş alamıyoruz. Lütfen yarın tekrar deneyin.";
                            }
                        }

                        //Sipariş Saati Kontrolü
                        if ($delivery_info->job_time_limit == 1) {
                            if (!$job_module->check_job_time_limit(
                                            $delivery_info->user_first_job_hour,
                                            $delivery_info->user_first_job_minute,
                                            $delivery_info->user_last_job_hour,
                                            $delivery_info->user_last_job_minute)) {
                                $nvalidate->addError();
                                $data["type"] = "LAST_JOB";
                                $data["error"] = true;
                                $data["message"] = "Maalesef bugünlük sipariş saati sona ermiştir. Lütfen yarın tekrardan deneyin";
                            }
                        }




                        if ($nvalidate->passed()) {
                            //iş ID'si
                            $job_id;

                            $job_module = new job_module();
                            $job_constant = new job_constant();

                            $job_price = $job_module->get_job_price($job_id, true);
                            //İşin Ödeme Yöntemi
                            $job_payment_method = $job_module->get_payment_methods($selected_payment_method);
                            $job_payment_method_extra_price = $job_module->calculate_payment_methods($job_id, $job_payment_method);

                           // dnd($job_payment_method,true);
                            
                            //Gönderim Şekli
                            $job_delivery_method = $job_module->get_delivery_method($selected_delivery_method_type);
                            // dnd($job_delivery_method);
                            if (is_array($job_delivery_method["locations"])) {
                                $founded_location = $job_module->location_diffrent($job_delivery_method["locations"], $customer_adres_id);
                                $location_difrent_price = $job_module->calculate_delivery_location_price($job_price, $job_delivery_method, $founded_location, true);
                            }

                            $delivery_price = $job_module->calculate_delivery_price($job_delivery_method, $location_difrent_price);
                            $job_total_price = $job_module->calculate_job_total_price($job_price, $job_payment_method_extra_price, $delivery_price);

                            $njob = new table_job();
                            $njob->select();
                            $njob->add_condition("job_id", $job_id);
                            $job_data = $njob->get_alldata(true);
                          
                            //Ürünü Güncellemek gerekli
                            data::add_post_data("job_fields", "primary_key", $job_id);
                            data::add_post_data("job_fields", "customer_id", $customer_id);
                            data::add_post_data("job_fields", "job_number", $job_module->set_job_number()); //İş numarası
                            data::add_post_data("job_fields", "start_date", $job_data->start_date); //
                            data::add_post_data("job_fields", "end_date", $job_data->end_date); //
                            data::add_post_data("job_fields", "job_seccode", $job_data->job_seccode); //
                            data::add_post_data("job_fields", "customer_confirm_date", getNow()); //
                            data::add_post_data("job_fields", "date", $job_data->date); //
                            data::add_post_data("job_fields", "job_status", $job_constant::CONFIRM); //İş Durumunu Onaylandı Olarak Güncelliyoruz
                            data::add_post_data("job_fields", "public", $job_data->public); //
                            data::add_post_data("job_fields", "admin_public", $job_data->admin_public); //

                            data::add_post_data("job_fields", "confirm", 0); //işin Onaylandığını gösterir
                            data::add_post_data("job_fields", "confirm_date", NOTIME); //işin Onaylandığını gösterir
                            data::add_post_data("job_fields", "job_delivery_time", $job_data->job_delivery_time);

                            data::add_post_data("job_fields", "complete", $job_data->complete); //
                            data::add_post_data("job_fields", "complete_date", $job_data->complete_date); //

                            data::add_post_data("job_fields", "job_price", $job_price); //işin bedeli(Sipariş Kartındaki ürünlerin satış fiyatları toplamı)
                            data::add_post_data("job_fields", "job_price_unit", default_currency());
                            data::add_post_data("job_fields", "job_price_discount", 0); //İş ile ilglili indirim uygulanmıyor
                            data::add_post_data("job_fields", "job_payment_method", $job_payment_method["methods"][0]["method"]); ///Ödeme Yöntemi
                            data::add_post_data("job_fields", "job_payment_method_options", $selected_payment_method_options); ///Ödeme Yöntemi
                            data::add_post_data("job_fields", "job_extra_price", $job_payment_method_extra_price); //Ödeme Yöntemine göre extra ücretlendirmeler
                            data::add_post_data("job_fields", "job_extra_price_discount", 0); //Extra ödemeler indirimleri
                            data::add_post_data("job_fields", "job_delivery_price", $delivery_price); //Gönderim bedeli -- Lokasyon farklılıkları dahil
                            data::add_post_data("job_fields", "job_delivery_price_discount", 0); //Gönderime Bağlı kampanya indirimleri

                            data::add_post_data("job_fields", "job_tax_price", 0); //
                            data::add_post_data("job_fields", "job_tax_price_discount", 0); //


                            data::add_post_data("job_fields", "job_total_price", $job_total_price); //Net Fiyat
                            data::add_post_data("job_fields", "job_total_price_discount", 0); //Net fiyat üzerinden yapılan kampanya indirimleri
                            data::add_post_data("job_fields", "product_currency", default_currency()); //varsayılan para birimi

                            data::add_post_data("job_fields", "return_request", $job_data->return_request); //
                            data::add_post_data("job_fields", "return_request_date", $job_data->return_request_date); //
                            data::add_post_data("job_fields", "return", $job_data->return); //

                            data::add_post_data("job_fields", "customer_adres_id", $customer_adres_id); //Müsterinin kayıtlı adresi
                            data::add_post_data("job_fields", "delivery", $job_data->delivery); //
                            data::add_post_data("job_fields", "delivery_date", $job_data->delivery_date); //
                            data::add_post_data("job_fields", "delivery_complete", $job_data->delivery_complete); //
                            data::add_post_data("job_fields", "delivery_complete_date", $job_data->delivery_complete_date); //


                            data::add_post_data("job_fields", "job_note", $job_note); //İş Notu

                            data::add_post_data("job_fields", "view", $job_data->view); // İşlemi yapan ID'si
                            data::add_post_data("job_fields", "admin_view", $job_data->admin_view); // İşlemi yapan ID'si
                            data::add_post_data("job_fields", "users_id", $customer_id); // İşlemi yapan ID'si

                            foreach ($job_products_info as $job_product) {

                                $secret_number = rand(9999, 99999);
                                $nproduct_module = new product_module();
                                $job_module = new job_module();

                                //$payment_method = $job_module->get_payment_methods();
                                //$product_delivery = $nproduct_module->get_product_transport($product_id);

                                $product_price_info = $nproduct_module->get_product_price($job_product->product_id);
                                $product_discount_info = $nproduct_module->get_product_discount($job_product->product_id);
                                $product_tax_price_info = $nproduct_module->get_product_tax_price($job_product->product_id);
                                $product_sales_price_info = $nproduct_module->get_product_sales_price($job_product->product_id);





                                data::add_post_data("job_products_fields", "secret_number", $secret_number, $secret_number);
                                data::add_post_data("job_products_fields", "primary_key", $job_product->job_products_id, $secret_number);
                                data::add_post_data("job_products_fields", "job_id", $job_id, $secret_number);

                                data::add_post_data("job_products_fields", "product_id", $job_product->product_id, $secret_number);
                                data::add_post_data("job_products_fields", "product_type", $job_product->product_type, $secret_number);

                                data::add_post_data("job_products_fields", "customer_id", $customer_id, $secret_number);

                                data::add_post_data("job_products_fields", "amount", $job_product->amount, $secret_number);

                                data::add_post_data("job_products_fields", "product_price_type", $job_product->product_price_type, $secret_number);

                                data::add_post_data("job_products_fields", "product_price", $product_price_info["product_price"], $secret_number);
                                data::add_post_data("job_products_fields", "product_price_unit", $product_price_info["product_price_unit"], $secret_number);


                                data::add_post_data("job_products_fields", "discount", $product_discount_info["product_discount_price"], $secret_number);
                                data::add_post_data("job_products_fields", "discount_type", $product_discount_info["discount_type"], $secret_number);
                                data::add_post_data("job_products_fields", "discount_rate", $product_discount_info["discount_rate"], $secret_number);

                                data::add_post_data("job_products_fields", "product_tax_price", $product_tax_price_info["product_tax_price"], $secret_number);
                                data::add_post_data("job_products_fields", "product_tax_price_unit", $product_tax_price_info["product_tax_price_unit"], $secret_number);
                                data::add_post_data("job_products_fields", "product_tax_rate", $product_tax_price_info["product_tax_rate"], $secret_number);
                                data::add_post_data("job_products_fields", "product_intax", $product_tax_price_info["product_intax"], $secret_number);

                                data::add_post_data("job_products_fields", "product_sales_price", $product_sales_price_info["product_sales_price"], $secret_number);


                                //Bu kısımlar artık kullanılmıyor *********************************************************************
                                // data::add_post_data("job_product_fields", "payment_method_workable_type", $payment_method["type"]);
                                //data::add_post_data("job_products_fields", "payment_method", "", $secret_number);
                                //data::add_post_data("job_products_fields", "product_extra_price", "", $secret_number);
                                //data::add_post_data("job_products_fields", "product_extra_price_unit", "", $secret_number);
                                // data::add_post_data("job_product_fields", "product_delivery_workable_type", $product_delivery["type"]);
                                //data::add_post_data("job_products_fields", "product_delivery_type", "", $secret_number);
                                //data::add_post_data("job_products_fields", "product_delivery_price", "", $secret_number);
                                //data::add_post_data("job_products_fields", "product_delivery_price_unit", "", $secret_number);
                                //data::add_post_data("job_products_fields", "product_delivery_price_in", "", $secret_number);
                                //Bu kısımlar artık kullanılmıyor *********************************************************************
                                data::add_post_data("job_products_fields", "users_id", $customer_id, $secret_number);

                                $nprice_options = new table_job_products_price_options_value();
                                $nprice_options->select();
                                $nprice_options->add_condition("job_products_id", $job_product->job_products_id);
                                $price_options = $nprice_options->get_alldata();
                                if (!empty($price_options))
                                    foreach ($price_options as $price_option) {
                                        $sub_secret_number = rand(99999, 9999999);
                                        //Fiyat Seçenekleri Grup Ayarları 
                                        $ngroup = new table_product_price_group();
                                        $ngroup->select();
                                        $ngroup->add_condition("product_price_group_id", $price_option->job_product_price_group_id);
                                        $group_info = $ngroup->get_alldata(true);
                                        //Fiyat Seçenekleri
                                        $noption = new table_product_price_option();
                                        $noption->select();
                                        $noption->add_condition("product_price_option_id", $price_option->job_product_price_group_option_id);
                                        $option_info = $noption->get_alldata(true);

                                        data::add_post_data("job_products_price_options_value_fields", "secret_number", $sub_secret_number, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "primary_key", $price_option->job_product_price_group_id, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "job_id", $job_id, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "job_products_id", $job_product->job_products_id, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "job_product_price_group_id", $price_option->job_product_price_group_id, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "job_product_price_group_option_id", $price_option->job_product_price_group_option_id, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "job_product_price_group_title", $group_info->group_title, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "price_title", $option_info->product_price_title, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "direction", $option_info->direction, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "type", $option_info->type, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "value", $option_info->value, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "date", $price_option->date, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "public", $price_option->public, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "job_products_price_options_value_seccode", $price_option->job_products_price_options_value_seccode, $sub_secret_number);
                                        data::add_post_data("job_products_price_options_value_fields", "users_id", $customer_id, $sub_secret_number);
                                    }
                            }

                            //Veriyi Oluşturuyoruz
                            $rawdata = data::get_postdata();
                            $nprepare_job_data = new prepare_job_data();
                            $control_module = $nprepare_job_data->set_new_job_data($rawdata);


                            $job_data_all = data::get_data($control_module);
                           

                            if (!empty($job_data_all))
                                foreach ($job_data_all as $table_name => $dt) {
                                    if (!empty($job_data_all[$table_name])) {
                                        if (!data::insert_data($table_name, $dt)) {
                                            $data["type"] = "NO_DATA";
                                            $data["error"] = true;
                                            $data["message"] = $table_name . " - " . " Tablosu Verileri Kayıt Edilmesi";
                                            $nvalidate->addWarning($data["message"]);
                                        }
                                    } else {
                                        $data["type"] = "NO_DATA";
                                        $data["error"] = true;
                                        $data["message"] = $table_name . " - " . " Tablosu Verileri Oluşturlmadı";
                                        $nvalidate->addWarning($data["message"]);
                                    }
                                }

                            //TODO: Kredi Kartı Seçili ise bu noktada Kredi kartı ödeme işlemini yapmak gerekli


                            $data["type"] = "COMPLETE_TO_CARD";
                            $data["error"] = false;
                            $data["message"] = "Siparişinizi Başarıyla Onayladınız";
                        }
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $getdata[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function removejobAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $job_id = $postdata->job_id;
                        $customer_id = $postdata->customer_id;
                        $njob = new table_job();
                        $njob->add_filter("job_id");

                        $njob->select();
                        $njob->add_condition("job_id", $job_id);
                        $njob->add_condition("customer_id", $customer_id);

                        if ($jobInfo = $njob->get_alldata(true)) {
                            if (data::removeAll("job", $jobInfo->job_id)) {
                                $data["type"] = "REMOVE_JOB";
                                $data["error"] = false;
                                $data["message"] = "Sipariş Kaldırılmıştır.";
                            } else {
                                $data["type"] = "REMOVE_FAILED";
                                $data["error"] = false;
                                $data["message"] = "Ürün Sepetten Kaldırılmamıştır. Lütfen tekrar deneyin.";
                            }
                        } else {
                            $data["type"] = "NO_JOB";
                            $data["error"] = false;
                            $data["message"] = "Sipariş Bilgisine Ulaşılamıyor.";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $getdata[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $getdata[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

}

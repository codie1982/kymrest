<?php

header('Content-Type: application/json');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of apicustomer
 *
 * @author engin
 */
class apicustomer {

    public function addtofavoritesAction() {
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

                        $ncustomer_favorite = new table_customer_favorites();
                        $ncustomer_favorite->select();
                        $ncustomer_favorite->add_condition("product_id", $product_id);
                        $ncustomer_favorite->add_condition("customer_id", $customer_id);
                        if (!$customer_favorite_data = $ncustomer_favorite->get_alldata(true)) {

                            $key = rand(9999, 99999);
                            data::add_post_data("customer_favorites_fields", "customer_id", $customer_id, $key);
                            data::add_post_data("customer_favorites_fields", "product_id", $product_id, $key);
                            data::add_post_data("customer_favorites_fields", "users_id", $customer_id, $key);
                            $rawdata = data::get_postdata();
                            $nprepare_data = new prepare_customer_data();
                            $control_module = $nprepare_data->set_favorites_data($rawdata);
                            $customer_favorites_data = data::get_data($control_module);
                            //dnd($customer_favorites_data, true);
                            if ($customer_favorites_id = data::insert_data("customer_favorites", $customer_favorites_data["customer_favorites"])) {


                                $ncustomer_favorites = new table_customer_favorites();
                                $ncustomer_favorites->select();
                                $ncustomer_favorites->add_condition("customer_id", $customer_id);
                                $ncustomer_favorites->add_condition("public", 1, "=", "customer_favorites");
                                $ncustomer_favorites->add_condition("admin_public", 1, "=", "customer_favorites");
                                $ncustomer_favorites->add_condition("public", 1, "=", "product");
                                $ncustomer_favorites->add_direction("DESC");
                                $ncustomer_favorites->add_direction_by("date");
                                $ncustomer_favorites->add_join("product", "product_id");
                                $customer_favorites = [];

                                if ($favorites = $ncustomer_favorites->get_alldata()) {
                                    $product_module = new product_module();
                                    if (!empty($favorites))
                                        foreach ($favorites as $favorite) {
                                            $prodcut_price_info = $product_module->get_product_sales_price($favorite->product_id);
                                            $customer_favorites[] = [
                                                "id" => $favorite->product_id,
                                                "product_name" => $product_module->get_product_name($favorite->product_name),
                                                "product_sub_name" => $product_module->get_product_subname($favorite->product_sub_name),
                                                "product_sales_price" => number_format($prodcut_price_info["product_sales_price"], 2),
                                                "product_unit" => strtoupper($prodcut_price_info["product_sales_price_unit"]),
                                                "product_favorite" => $favorite->favorite,
                                                "date" => timeConvert($favorite->date),
                                            ];
                                        }
                                }
                                $data["favorite_list"] = $customer_favorites;

                                $data["customer_id"] = $customer_id;
                                $data["product_id"] = $product_id;
                                $data["type"] = "ADD_TO_FAVORITES";
                                $data["error"] = false;
                                $data["message"] = "Ürün Başarıyla Favoriler Listenize Eklendi";
                            } else {
                                $data["type"] = "NO_FAVORITES_ADDED";
                                $data["error"] = true;
                                $data["message"] = "Bu Ürün Favori Listenize Eklenemedi";
                            }
                        } else {
                            $data["type"] = "THREEISPRODUCT";
                            $data["error"] = true;
                            $data["message"] = "Bu Ürün Favori Listenize Daha Önce Eklenmiş";
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

    public function removetofavoritesAction() {
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

                        $ncustomer_favorite = new table_customer_favorites();
                        $ncustomer_favorite->select();
                        $ncustomer_favorite->add_condition("product_id", $product_id);
                        if ($customer_favorite_data = $ncustomer_favorite->get_alldata(true)) {
                            //dnd($customer_favorites_data, true);
                            if (data::remove("customer_favorites", ["customer_id" => $customer_id, "product_id" => $product_id], false)) {

                                $ncustomer_favorites = new table_customer_favorites();
                                $ncustomer_favorites->select();
                                $ncustomer_favorites->add_condition("customer_id", $customer_id);
                                $ncustomer_favorites->add_condition("public", 1, "=", "customer_favorites");
                                $ncustomer_favorites->add_condition("admin_public", 1, "=", "customer_favorites");
                                $ncustomer_favorites->add_condition("public", 1, "=", "product");
                                $ncustomer_favorites->add_direction("DESC");
                                $ncustomer_favorites->add_direction_by("date");
                                $ncustomer_favorites->add_join("product", "product_id");
                                $customer_favorites = [];

                                if ($favorites = $ncustomer_favorites->get_alldata()) {
                                    $product_module = new product_module();
                                    if (!empty($favorites))
                                        foreach ($favorites as $favorite) {
                                            $prodcut_price_info = $product_module->get_product_sales_price($favorite->product_id);
                                            $customer_favorites[] = [
                                                "id" => $favorite->product_id,
                                                "product_name" => $product_module->get_product_name($favorite->product_name),
                                                "product_sub_name" => $product_module->get_product_subname($favorite->product_sub_name),
                                                "product_sales_price" => number_format($prodcut_price_info["product_sales_price"], 2),
                                                "product_unit" => strtoupper($prodcut_price_info["product_sales_price_unit"]),
                                                "product_favorite" => $favorite->favorite,
                                                "date" => timeConvert($favorite->date),
                                            ];
                                        }
                                }
                                $data["favorite_list"] = $customer_favorites;
                                $data["type"] = "REMOVE_TO_FAVORITES";
                                $data["error"] = false;
                                $data["message"] = "Ürünler Başarıyla Listeden Kaldırılmıştır";
                            } else {
                                $data["type"] = "NO_FAVORITES_REMOVED";
                                $data["error"] = true;
                                $data["message"] = "Ürünler Favoriler listesinden kaldırılamamıştır. Lütfen tekrar deneyiniz";
                            }
                        } else {
                            $data["type"] = "THREEISPRODUCT";
                            $data["error"] = true;
                            $data["message"] = "Bu Ürün Favori Listenizde Bulunmuyor";
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

    public function addcustomeradresAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $key = rand(9999, 99999);
                        data::add_post_data("customer_adres_fields", "customer_id", $postdata->customer_id, $key);
                        data::add_post_data("customer_adres_fields", "province", $postdata->province, $key);
                        data::add_post_data("customer_adres_fields", "district", $postdata->district, $key);
                        data::add_post_data("customer_adres_fields", "neighborhood", $postdata->neighborhood, $key);
                        data::add_post_data("customer_adres_fields", "adres_title", $postdata->adres_title, $key);
                        data::add_post_data("customer_adres_fields", "mail_code", $postdata->postcode, $key);
                        data::add_post_data("customer_adres_fields", "street", $postdata->street, $key);
                        data::add_post_data("customer_adres_fields", "delivery", $postdata->delivery, $key);
                        data::add_post_data("customer_adres_fields", "shipping", $postdata->shipping, $key);
                        data::add_post_data("customer_adres_fields", "description", $postdata->description, $key);
                        data::add_post_data("customer_adres_fields", "confirm", 0, $key);
                        data::add_post_data("customer_adres_fields", "users_id", $postdata->customer_id, $key);
                        if ($postdata->primary_key != "") {
                            data::add_post_data("customer_adres_fields", "primary_key", $postdata->primary_key, $key);
                        }


                        $rawdata = data::get_postdata();
                        $nprepare_data = new prepare_customer_data();
                        $control_module = $nprepare_data->set_adres_data($rawdata);
                        $customer_adres_data = data::get_data($control_module);


                        if (trim($customer_adres_data["customer_adres"][$key]["adres_title"]) == NODATA || trim($customer_adres_data["customer_adres"][$key]["adres_title"]) == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_ADRES_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Adres Başlık Satırını Boş Bırakmayın.";
                        }

                        if (trim($customer_adres_data["customer_adres"][$key]["province"]) == NODATA || trim($customer_adres_data["customer_adres"][$key]["province"]) == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_PROVINCE";
                            $data["error"] = true;
                            $data["message"] = "Bir İl Seçimi Yapınız.";
                        }

                        if (trim($customer_adres_data["customer_adres"][$key]["district"]) == NODATA || trim($customer_adres_data["customer_adres"][$key]["district"]) == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_DISTRICT";
                            $data["error"] = true;
                            $data["message"] = "Bir İlçe Seçimi Yapınız.";
                        }

                        if (trim($customer_adres_data["customer_adres"][$key]["neighborhood"]) == NODATA || trim($customer_adres_data["customer_adres"][$key]["neighborhood"]) == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_NEIGHBORHOOD";
                            $data["error"] = true;
                            $data["message"] = "Bir Mahalle Seçimi Seçimi Yapınız.";
                        }

                        if (trim($customer_adres_data["customer_adres"][$key]["description"]) == NODATA || trim($customer_adres_data["customer_adres"][$key]["description"]) == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_DESCRIPTION";
                            $data["error"] = true;
                            $data["message"] = "Bir Detaylı Adres Yazınız.";
                        }


                        if ($nvalidate->passed()) {
                            if ($customer_adres_id = data::insert_data("customer_adres", $customer_adres_data["customer_adres"])) {

                                $ncustomer_adres = new table_customer_adres();
                                $ncustomer_adres->select();
                                $ncustomer_adres->add_condition("customer_id", $postdata->customer_id);
                                $ncustomer_adres->add_condition("public", 1);
                                $customer_adres = [];
                                if ($adress = $ncustomer_adres->get_alldata()) {
                                    if (!empty($adress))
                                        foreach ($adress as $adres) {

                                            $nadres = new table_adres();
                                            $province = $nadres->getprovince($adres->province);
                                            $district = $nadres->getdistrict($adres->province, $adres->district);
                                            $neighborhood = $nadres->getneighborhood($adres->neighborhood);

                                            $customer_adres[] = [
                                                "customer_adres_id" => $adres->customer_adres_id,
                                                "adres_title" => $adres->adres_title,
                                                "adres_id" => [
                                                    "province_id" => $adres->province,
                                                    "district_id" => $adres->district,
                                                    "neighborhood_id" => $adres->neighborhood,
                                                ],
                                                "adres_text" => [
                                                    "province" => ucfirst(strtolower(trim($province))),
                                                    "district" => ucfirst(strtolower(trim($district))),
                                                    "neighborhood" => ucfirst(strtolower(trim($neighborhood))),
                                                ],
                                                "street" => $adres->street,
                                                "mail_code" => $adres->mail_code,
                                                "description" => html_entity_decode($adres->description),
                                                "delivery_adres" => $adres->delivery_adres,
                                                "shipping_adres" => $adres->shipping_adres,
                                                "confirm" => $adres->confirm,
                                            ];
                                        }
                                }
                                $data["customer_adres_data"] = $customer_adres;
                                $data["type"] = "ADD_CUSTOMER_NEW_ADRES";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Adresi Başarıyla Kayıt Edildi";
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

    public function updatecustomeradresAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $key = rand(9999, 99999);
                        data::add_post_data("customer_adres_fields", "customer_id", $postdata->customer_id, $key);
                        data::add_post_data("customer_adres_fields", "province", $postdata->province, $key);
                        data::add_post_data("customer_adres_fields", "district", $postdata->district, $key);
                        data::add_post_data("customer_adres_fields", "neighborhood", $postdata->neighborhood, $key);
                        data::add_post_data("customer_adres_fields", "adres_title", $postdata->adres_title, $key);
                        data::add_post_data("customer_adres_fields", "mail_code", $postdata->postcode, $key);
                        data::add_post_data("customer_adres_fields", "street", $postdata->street, $key);
                        data::add_post_data("customer_adres_fields", "delivery", $postdata->delivery, $key);
                        data::add_post_data("customer_adres_fields", "shipping", $postdata->shipping, $key);
                        data::add_post_data("customer_adres_fields", "description", $postdata->description, $key);
                        data::add_post_data("customer_adres_fields", "confirm", 0, $key);
                        data::add_post_data("customer_adres_fields", "users_id", $postdata->customer_id, $key);
                        if ($postdata->primary_key != "") {
                            data::add_post_data("customer_adres_fields", "primary_key", $postdata->primary_key, $key);
                        }


                        $rawdata = data::get_postdata();
                        $nprepare_data = new prepare_customer_data();
                        $control_module = $nprepare_data->set_adres_data($rawdata);
                        $customer_adres_data = data::get_data($control_module);

                        if ($customer_adres_data["customer_adres"][$key]["adres_title"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_ADRES_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Adres Bailık Satırını Boş Bırakmayın.";
                        }
                        if ($nvalidate->passed()) {

                            if ($customer_adres_id = data::insert_data("customer_adres", $customer_adres_data["customer_adres"])) {
                                $data["customer_adres_id"] = $customer_adres_id;
                                $data["type"] = "UPDATE_CUSTOMER_ADRES";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Adresi Başarıyla Güncellendi";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "NO_RECORD";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı Adres Kaydı Yapılamadı Lütfen Tekrar Deneyin";
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

    public function removecustomeradresAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $customer_id = $postdata->customer_id;
                        $customer_adres_id = $postdata->customer_adres_id;

                        $ncustomer_adres = new table_customer_adres();
                        $ncustomer_adres->add_filter("customer_adres_id");
                        $ncustomer_adres->select();
                        $ncustomer_adres->add_condition("customer_adres_id", $customer_adres_id);
                        $ncustomer_adres->add_condition("customer_id", $customer_id);

                        if (!$ncustomer_adres->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_ADRES";
                            $data["error"] = true;
                            $data["message"] = "Bu Adres Kayıtlı Gözükmüyor.";
                        }

                        if ($nvalidate->passed()) {

                            if (data::remove("customer_adres", $customer_adres_id)) {

                                //Kullanıcı Adresi
                                $ncustomer_adres = new table_customer_adres();
                                $ncustomer_adres->select();
                                $ncustomer_adres->add_condition("customer_id", $postdata->customer_id);
                                $ncustomer_adres->add_condition("public", 1);
                                $customer_adres = [];
                                if ($adress = $ncustomer_adres->get_alldata()) {
                                    if (!empty($adress))
                                        foreach ($adress as $adres) {

                                            $nadres = new table_adres();
                                            $province = $nadres->getprovince($adres->province);
                                            $district = $nadres->getdistrict($adres->province, $adres->district);
                                            $neighborhood = $nadres->getneighborhood($adres->neighborhood);

                                            $customer_adres[] = [
                                                "customer_adres_id" => $adres->customer_adres_id,
                                                "adres_title" => $adres->adres_title,
                                                "adres_id" => [
                                                    "province_id" => $adres->province,
                                                    "district_id" => $adres->district,
                                                    "neighborhood_id" => $adres->neighborhood,
                                                ],
                                                "adres_text" => [
                                                    "province" => ucfirst(strtolower(trim($province))),
                                                    "district" => ucfirst(strtolower(trim($district))),
                                                    "neighborhood" => ucfirst(strtolower(trim($neighborhood))),
                                                ],
                                                "street" => $adres->street,
                                                "mail_code" => $adres->mail_code,
                                                "description" => html_entity_decode($adres->description),
                                                "delivery_adres" => $adres->delivery_adres,
                                                "shipping_adres" => $adres->shipping_adres,
                                                "confirm" => $adres->confirm,
                                            ];
                                        }
                                }
                                $data["customer_adres_data"] = $customer_adres;
                                $data["type"] = "REMOVE_CUSTOMER_ADRES";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Adresi Başarıyla Kaldırıldı";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "REMOVE_CUSTOMER_ADRES_ERROR";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı adresi kaldırılmadı. Lütfen tekrar deneyin";
                            }
                        } else {
                            $data["customer_adres_data"] = $customer_adres_data;
                            $data["type"] = "EMPTY_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Adres Bailık Satırını Boş Bırakmayın";
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

    public function addcustomercredicardAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;

                        $key = rand(9999, 99999);
                        data::add_post_data("customer_credicard_fields", "customer_id", $postdata->customer_id, $key);
                        data::add_post_data("customer_credicard_fields", "credicard_title", $postdata->card_title, $key);
                        data::add_post_data("customer_credicard_fields", "month", $postdata->month, $key);
                        data::add_post_data("customer_credicard_fields", "year", $postdata->year, $key);
                        data::add_post_data("customer_credicard_fields", "number", $postdata->card_number, $key);
                        data::add_post_data("customer_credicard_fields", "card_security_number", $postdata->security_number, $key);
                        data::add_post_data("customer_credicard_fields", "users_id", $postdata->customer_id, $key);

                        if ($postdata->primary_key != "") {
                            data::add_post_data("customer_credicard_fields", "primary_key", $postdata->primary_key, $key);
                        }


                        $rawdata = data::get_postdata();
                        $nprepare_data = new prepare_customer_data();
                        $control_module = $nprepare_data->set_credicard_data($rawdata);
                        $customer_credicard_data = data::get_data($control_module);

                        //dnd($customer_credicard_data);
                        if ($customer_credicard_data["customer_credi_card"][$key]["credicard_title"] == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Girdiğiniz Kredi Kartının Başlık Kısmını Girmeyin Utunmayınız.";
                        }
                        //Kart Kartın Son Kullanma Tarihini Kontrol Edebiliriz
                        //Kart yılı Küçükse veya Eşitse Ve Ay Küçükse Son Kullama Tarihi Geçmiş Demektir.

                        if ($customer_credicard_data["customer_credi_card"][$key]["year"] < date("Y")) {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_YEAR";
                            $data["error"] = true;
                            $data["message"] = "Kredi Kartınızın Son Kullanma Tarihi Geçersiz.";
                        } else {
                            if ($customer_credicard_data["customer_credi_card"][$key]["year"] == date("m")) {
                                if ($customer_credicard_data["customer_credi_card"][$key]["year"] < $nMonth) {
                                    $nvalidate->addError();
                                    $data["type"] = "NO_CARD_MONTH";
                                    $data["error"] = true;
                                    $data["message"] = "Kredi Kartınızın Son Kullanma Tarihi Geçersiz.";
                                }
                            }
                        }

                        //Kart Numarasını Kontrol Edelim
                        if ($customer_credicard_data["customer_credi_card"][$key]["credi_card_number"] == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Bir Kart Numarası Girin.";
                        }


                        //Kart Numarasını Kontrol Edelim
                        if ($customer_credicard_data["customer_credi_card"][$key]["card_security_number"] == "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_SECURTY_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Bir Kart Güvenlik Numarası Girin.";
                        }

                        //Kart Numarasını Kontrol Edelim
                        $ncustomer_card = new table_customer_credi_card();
                        $ncustomer_card->select();
                        $ncustomer_card->add_direction("DESC");
                        $ncustomer_card->add_direction_by("customer_credi_card_id");
                        $ncustomer_card->add_limit_start("1");
                        $ncustomer_card->add_condition("credi_card_number", $customer_credicard_data["customer_credi_card"][$key]["credi_card_number"]);
                        if ($card_info = $ncustomer_card->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "COPY_CARD";
                            $data["error"] = true;
                            $data["message"] = "Bu Kart Numarası Başka Bir Kullanıcı adına Kayıtlı.";
                        }

                        if ($nvalidate->passed()) {
                            if ($customer_card_id = data::insert_data("customer_credi_card", $customer_credicard_data["customer_credi_card"])) {

                                //Kullanıcı Kredi Kartları
                                $ncustomer_credi_card = new table_customer_credi_card();
                                $ncustomer_credi_card->select();
                                $ncustomer_credi_card->add_condition("customer_id", $postdata->customer_id);
                                $ncustomer_credi_card->add_condition("public", 1);
                                $customer_credi_card = [];
                                if ($cards = $ncustomer_credi_card->get_alldata()) {
                                    if (!empty($cards))
                                        foreach ($cards as $card) {
                                            $customer_credi_card[] = [
                                                "customer_credi_card_id" => $card->customer_credi_card_id,
                                                "credicard_title" => $card->credicard_title,
                                                "credi_card_number" => $card->credi_card_number,
                                                "month" => $card->month,
                                                "year" => $card->year,
                                                "card_security_number" => $card->card_security_number,
                                            ];
                                        }
                                }

                                $data["customer_card_data"] = $customer_credi_card;
                                $data["type"] = "ADD_CUSTOMER_NEW_CARD";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Kredi Kartı Başarıyla Kayıt Edildi";
                            } else {
                                $data["type"] = "NO_RECORD";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı Kredi Kart Kaydı Yapılamadı Lütfen Tekrar Deneyin";
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

    public function updatecustomercredicardAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;

                        $key = rand(9999, 99999);
                        data::add_post_data("customer_credicard_fields", "customer_id", $postdata->customer_id, $key);
                        data::add_post_data("customer_credicard_fields", "credicard_title", $postdata->card_title, $key);
                        data::add_post_data("customer_credicard_fields", "month", $postdata->month, $key);
                        data::add_post_data("customer_credicard_fields", "year", $postdata->year, $key);
                        data::add_post_data("customer_credicard_fields", "number", $postdata->card_number, $key);
                        data::add_post_data("customer_credicard_fields", "card_security_number", $postdata->security_number, $key);

                        if ($postdata->primary_key != "") {
                            data::add_post_data("customer_credicard_fields", "primary_key", $postdata->primary_key, $key);
                        }


                        $rawdata = data::get_postdata();
                        $nprepare_data = new prepare_customer_data();
                        $control_module = $nprepare_data->set_credicard_data($rawdata);
                        $customer_credicard_data = data::get_data($control_module);

                        if ($customer_credicard_data["customer_credi_card"][$key]["credicard_title"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Girdiğiniz Kredi Kartının Başlık Kısmını Girmeyin Utunmayınız.";
                        }
                        //Kart Kartın Son Kullanma Tarihini Kontrol Edebiliriz
                        //Kart yılı Küçükse veya Eşitse Ve Ay Küçükse Son Kullama Tarihi Geçmiş Demektir.

                        if ($customer_credicard_data["customer_credi_card"][$key]["year"] < date("Y")) {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_YEAR";
                            $data["error"] = true;
                            $data["message"] = "Kredi Kartınızın Son Kullanma Tarihi Geçersiz.";
                        } else {
                            if ($customer_credicard_data["customer_credi_card"][$key]["year"] == date("m")) {
                                if ($customer_credicard_data["customer_credi_card"][$key]["year"] < $nMonth) {
                                    $nvalidate->addError();
                                    $data["type"] = "NO_CARD_MONTH";
                                    $data["error"] = true;
                                    $data["message"] = "Kredi Kartınızın Son Kullanma Tarihi Geçersiz.";
                                }
                            }
                        }

                        //Kart Numarasını Kontrol Edelim
                        if ($customer_credicard_data["customer_credi_card"][$key]["card_number"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Bir Kart Numarası Girin.";
                        }

                        //Kart Numarasını Kontrol Edelim
                        if ($customer_credicard_data["customer_credi_card"][$key]["security_number"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_CARD_SECURTY_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Bir Kart Güvenlik Numarası Girin.";
                        }

                        //Kart Numarasını Kontrol Edelim
                        $ncustomer_card = new table_customer_credi_card();
                        $ncustomer_card->select();
                        $ncustomer_card->add_condition("card_number", $customer_credicard_data["customer_credi_card"][$key]["card_number"]);
                        $ncustomer_card->add_condition("customer_id", $postdata->customer_id, "<>");
                        if ($card_info = $ncustomer_card->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "COPY_CARD";
                            $data["error"] = true;
                            $data["message"] = "Bu Kart Numarası Başka Bir Kullanıcı adına Kayıtlı.";
                        }

                        if ($nvalidate->passed()) {
                            if ($customer_card_id = data::insert_data("customer_adres", $customer_adres_data["customer_adres"])) {

                                $data["customer_adres_id"] = $customer_adres_id;
                                $data["type"] = "ADD_CUSTOMER_CARD";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Kredi Kartı Başarıyla Kayıt Edildi";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "NO_RECORD";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı Adres Kaydı Yapılamadı Lütfen Tekrar Deneyin";
                            }
                        } else {
                            $data["customer_adres_data"] = $customer_adres_data;
                            $data["type"] = "EMPTY_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Adres Bailık Satırını Boş Bırakmayın";
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

    public function removecustomercredicardAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $customer_id = $postdata->customer_id;
                        $customer_credi_card_id = $postdata->customer_credi_card_id;

                        $ncustomer_credicard = new table_customer_credi_card();
                        $ncustomer_credicard->add_filter("customer_credi_card_id");
                        $ncustomer_credicard->select();
                        $ncustomer_credicard->add_condition("customer_credi_card_id", $customer_credi_card_id);
                        $ncustomer_credicard->add_condition("customer_id", $customer_id);

                        if (!$ncustomer_credicard->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_CREDICARD";
                            $data["error"] = true;
                            $data["message"] = "Bu Kredi Kartı Kayıtlı Gözükmüyor.";
                        }

                        if ($nvalidate->passed()) {
                            if (data::remove("customer_credi_card", $customer_credi_card_id)) {

                                //Kullanıcı Kredi Kartları
                                $ncustomer_credi_card = new table_customer_credi_card();
                                $ncustomer_credi_card->select();
                                $ncustomer_credi_card->add_condition("customer_id", $postdata->customer_id);
                                $ncustomer_credi_card->add_condition("public", 1);
                                $customer_credi_card = [];
                                if ($cards = $ncustomer_credi_card->get_alldata()) {
                                    if (!empty($cards))
                                        foreach ($cards as $card) {
                                            $customer_credi_card[] = [
                                                "customer_credi_card_id" => $card->customer_credi_card_id,
                                                "credicard_title" => $card->credicard_title,
                                                "credi_card_number" => $card->credi_card_number,
                                                "month" => $card->month,
                                                "year" => $card->year,
                                                "card_security_number" => $card->card_security_number,
                                            ];
                                        }
                                }

                                $data["customer_credicard_data"] = $customer_credi_card;
                                $data["type"] = "REMOVE_CUSTOMER_CREDICARD";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Kredi Kartı Başarıyla Kaldırıldı";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "REMOVE_CUSTOMER_CREDICARD_ERROR";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı kredi kartı kaldırılmadı. Lütfen tekrar deneyin";
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

    public function addcustomerphoneAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;

                        $key = rand(9999, 99999);
                        data::add_post_data("customer_phone_fields", "customer_id", $postdata->customer_id, $key);
                        data::add_post_data("customer_phone_fields", "phone_type", $postdata->phone_type, $key);
                        data::add_post_data("customer_phone_fields", "area_code", $postdata->area_code, $key);
                        data::add_post_data("customer_phone_fields", "phone_number", $postdata->phone_number, $key);
                        data::add_post_data("customer_phone_fields", "confirm", 0, $key);
                        data::add_post_data("customer_phone_fields", "users_id", $postdata->customer_id, $key);
                        if ($postdata->primary_key != "") {
                            data::add_post_data("customer_phone_fields", "primary_key", $postdata->primary_key, $key);
                        }


                        $rawdata = data::get_postdata();
                        $nprepare_data = new prepare_customer_data();
                        $control_module = $nprepare_data->set_phone_data($rawdata);
                        $customer_phone_data = data::get_data($control_module);



                        if ($customer_phone_data["customer_phone_fields"][$key]["phone_number"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_PHONE_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Numara Alanını Boş Bırakmayınız.";
                        }



                        if ($customer_phone_data["customer_phone_fields"][$key]["phone_number"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_PHONE_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Numara Alanını Boş Bırakmayınız.";
                        }


                        $ncustomer_phone = new table_customer_phone();
                        $ncustomer_phone->select();
                        $ncustomer_phone->add_condition("phone_number", $customer_phone_data["customer_phone_fields"][$key]["phone_number"]);
                        if ($ncustomer_phone->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_PHONE_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Bu Numaraya Kayıtlı bir Kullanıcı Bulunmaktadır.";
                        }

                       
                        if ($nvalidate->passed()) {
                            if ($customer_phone_id = data::insert_data("customer_phone", $customer_phone_data["customer_phone"])) {
                                //Kullanıcı Telefon Numaraları
                                $ncustomer_phone = new table_customer_phone();
                                $ncustomer_phone->select();
                                $ncustomer_phone->add_condition("customer_id", $postdata->customer_id);
                                $ncustomer_phone->add_condition("public", 1);
                                $customer_phone = [];
                                if ($phones = $ncustomer_phone->get_alldata()) {
                                    if (!empty($phones))
                                        foreach ($phones as $phone) {
                                            $customer_phone[] = [
                                                "customer_phone_id" => $phone->customer_phone_id,
                                                "phone_type" => $phone->phone_type,
                                                "area_code" => $phone->area_code,
                                                "phone_number" => $phone->phone_number,
                                                "confirm" => $phone->confirm,
                                            ];
                                        }
                                }
                                $data["customer_phone_data"] = $customer_phone;
                                $data["type"] = "ADD_CUSTOMER_NEW_PHONE";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Telefon Numarası Başarıyla Kayıt Edildi";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "NO_RECORD";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı Telefon Numarası Kaydı Yapılamadı. Lütfen Tekrar Deneyin";
                            }
                        } else {
                            $data["customer_adres_data"] = $customer_adres_data;
                            $data["type"] = "EMPTY_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Adres Bailık Satırını Boş Bırakmayın";
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

    public function updatecustomerphoneAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;

                        $key = rand(9999, 99999);
                        data::add_post_data("customer_phone_fields", "customer_id", $postdata->customer_id, $key);
                        data::add_post_data("customer_phone_fields", "phone_type", $postdata->phone_type, $key);
                        data::add_post_data("customer_phone_fields", "area_code", $postdata->area_code, $key);
                        data::add_post_data("customer_phone_fields", "phone_number", $postdata->phone_number, $key);
                        data::add_post_data("customer_phone_fields", "confirm", 0, $key);
                        data::add_post_data("customer_phone_fields", "users_id", $postdata->customer_id, $key);
                        if ($postdata->primary_key != "") {
                            data::add_post_data("customer_phone_fields", "primary_key", $postdata->primary_key, $key);
                        }


                        $rawdata = data::get_postdata();
                        $nprepare_data = new prepare_customer_data();
                        $control_module = $nprepare_data->set_phone_data($rawdata);
                        $customer_phone_data = data::get_data($control_module);



                        if ($customer_phone_data["customer_phone_fields"][$key]["phone_number"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_PHONE_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Numara Alanını Boş Bırakmayınız.";
                        }



                        if ($customer_phone_data["customer_phone_fields"][$key]["phone_number"] != "") {
                            $nvalidate->addError();
                            $data["type"] = "NO_PHONE_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Numara Alanını Boş Bırakmayınız.";
                        }


                        $ncustomer_phone = new table_customer_phone();
                        $ncustomer_phone->select();
                        $ncustomer_phone->add_condition("phone_number", $customer_phone_data["customer_phone_fields"][$key]["phone_number"]);
                        $ncustomer_phone->add_condition("customer_id", $postdata->customer_id, "<>");
                        if ($ncustomer_phone->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NO_PHONE_NUMBER";
                            $data["error"] = true;
                            $data["message"] = "Bu Numaraya Kayıtlı bir Kullanıcı Bulunmaktadır.";
                        }


                        if ($nvalidate->passed()) {
                            if ($customer_phone_id = data::insert_data("customer_phone", $customer_adres_data["customer_phone"])) {

                                $data["customer_phone_id"] = $customer_phone_id;
                                $data["type"] = "ADD_CUSTOMER_PHONE";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Adresi Başarıyla Kayıt Edildi";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "NO_RECORD";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı Adres Kaydı Yapılamadı Lütfen Tekrar Deneyin";
                            }
                        } else {
                            $data["customer_adres_data"] = $customer_adres_data;
                            $data["type"] = "EMPTY_TITLE";
                            $data["error"] = true;
                            $data["message"] = "Adres Bailık Satırını Boş Bırakmayın";
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

    public function removecustomerphoneAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;
                        $customer_id = $postdata->customer_id;
                        $customer_phone_id = $postdata->customer_phone_id;

                        $ncustomer_phone = new table_customer_phone();
                        $ncustomer_phone->add_filter("customer_phone_id");
                        $ncustomer_phone->select();
                        $ncustomer_phone->add_condition("customer_phone_id", $customer_phone_id);
                        $ncustomer_phone->add_condition("customer_id", $customer_id);

                        if (!$ncustomer_phone->get_alldata(true)) {
                            $nvalidate->addError();
                            $data["type"] = "NOPHONE";
                            $data["error"] = true;
                            $data["message"] = "Bu Telefon Kayıtlı Gözükmüyor.";
                        }

                        if ($nvalidate->passed()) {
                            if (data::remove("customer_phone", $customer_phone_id)) {

                                //Kullanıcı Telefon Numaraları
                                $ncustomer_phone = new table_customer_phone();
                                $ncustomer_phone->select();
                                $ncustomer_phone->add_condition("customer_id", $postdata->customer_id);
                                $ncustomer_phone->add_condition("public", 1);
                                $customer_phone = [];
                                if ($phones = $ncustomer_phone->get_alldata()) {
                                    if (!empty($phones))
                                        foreach ($phones as $phone) {
                                            $customer_phone[] = [
                                                "customer_phone_id" => $phone->customer_phone_id,
                                                "phone_type" => $phone->phone_type,
                                                "area_code" => $phone->area_code,
                                                "phone_number" => $phone->phone_number,
                                                "confirm" => $phone->confirm,
                                            ];
                                        }
                                }
                                $data["customer_phone_data"] = $customer_phone;
                                $data["type"] = "REMOVE_CUSTOMER_PHONE";
                                $data["error"] = false;
                                $data["message"] = "Kullanıcı Telefon Numarası Başarıyla Kaldırıldı";
                            } else {
                                $data["customer_adres_data"] = $customer_adres_data;
                                $data["type"] = "REMOVE_CUSTOMER_PHONE_ERROR";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcı Telefon Numarası kaldırılmadı. Lütfen tekrar deneyin";
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

    public function getcustomerinfoAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        //$data["postdata"] = $postdata;
                        $customer_id = $postdata->customer_id;
                        if ($customer_id != "") {
                            $ncustomer_account = new table_customer_siteaccount();
                            $ncustomer_account->select();
                            $ncustomer_account->add_condition("customer_id", $customer_id);
                            if ($customer_account_info = $ncustomer_account->get_alldata(true)) {

                                data::add_post_data("login_info_fields", "customer_id", $customer_id);
                                data::add_post_data("login_info_fields", "date", getNow());
                                $nprp = new prepare_login_data();
                                $control_module = $nprp->set_login_data(data::get_postdata());
                                $login_data = data::get_data($control_module);
                                data::insert_data("login_info", $login_data["login_info"]);


                                $ncustomer = new table_customer();
                                $ncustomer->select();
                                $ncustomer->add_condition("customer_id", $customer_id);
                                $ncustomer->add_condition("public", 1);
                                if ($customer_info = $ncustomer->get_alldata(true)) {
                                    if ($customer_info->type == "personel") {
                                        $ncustomer_personel = new table_customer_personel();
                                        $ncustomer_personel->select();
                                        $ncustomer_personel->add_condition("customer_id", $customer_id);

                                        if ($customer_personel_data = $ncustomer_personel->get_alldata(true)) {
                                            //Kullanıcı Etiketleri
                                            $ncustomer_tag = new table_customer_tag();
                                            $ncustomer_tag->select();
                                            $ncustomer_tag->add_condition("customer_id", $customer_id);
                                            $ncustomer_tag->add_condition("public", 1);
                                            $customer_tags = [];
                                            if ($tags = $ncustomer_tag->get_alldata()) {
                                                foreach ($tags as $tag) {
                                                    $customer_tags[] = ["tag" => $tag->tag];
                                                }
                                            }
                                            //Kullanıcı Adresi
                                            $ncustomer_adres = new table_customer_adres();
                                            $ncustomer_adres->select();
                                            $ncustomer_adres->add_condition("customer_id", $customer_id);
                                            $ncustomer_adres->add_condition("public", 1);
                                            $customer_adres = [];
                                            if ($adress = $ncustomer_adres->get_alldata()) {
                                                if (!empty($adress))
                                                    foreach ($adress as $adres) {

                                                        $nadres = new table_adres();
                                                        $province = $nadres->getprovince($adres->province);
                                                        $district = $nadres->getdistrict($adres->province, $adres->district);
                                                        $neighborhood = $nadres->getneighborhood($adres->neighborhood);

                                                        $customer_adres[] = [
                                                            "customer_adres_id" => $adres->customer_adres_id,
                                                            "adres_title" => $adres->adres_title,
                                                            "adres_id" => [
                                                                "province_id" => $adres->province,
                                                                "district_id" => $adres->district,
                                                                "neighborhood_id" => $adres->neighborhood,
                                                            ],
                                                            "adres_text" => [
                                                                "province" => ucfirst(strtolower(trim($province))),
                                                                "district" => ucfirst(strtolower(trim($district))),
                                                                "neighborhood" => ucfirst(strtolower(trim($neighborhood))),
                                                            ],
                                                            "street" => $adres->street,
                                                            "mail_code" => $adres->mail_code,
                                                            "description" => html_entity_decode($adres->description),
                                                            "delivery_adres" => $adres->delivery_adres,
                                                            "shipping_adres" => $adres->shipping_adres,
                                                            "confirm" => $adres->confirm,
                                                        ];
                                                    }
                                            }
                                            //Kullanıcı Telefon Numaraları
                                            $ncustomer_phone = new table_customer_phone();
                                            $ncustomer_phone->select();
                                            $ncustomer_phone->add_condition("customer_id", $customer_id);
                                            $ncustomer_phone->add_condition("public", 1);
                                            $customer_phone = [];
                                            if ($phones = $ncustomer_phone->get_alldata()) {
                                                if (!empty($phones))
                                                    foreach ($phones as $phone) {
                                                        $customer_phone[] = [
                                                            "customer_phone_id" => $phone->customer_phone_id,
                                                            "phone_type" => $phone->phone_type,
                                                            "area_code" => $phone->area_code,
                                                            "phone_number" => $phone->phone_number,
                                                            "confirm" => $phone->confirm,
                                                        ];
                                                    }
                                            }

                                            //Kullanıcı Kredi Kartları
                                            $ncustomer_credi_card = new table_customer_credi_card();
                                            $ncustomer_credi_card->select();
                                            $ncustomer_credi_card->add_condition("customer_id", $customer_id);
                                            $ncustomer_credi_card->add_condition("public", 1);
                                            $customer_credi_card = [];
                                            if ($cards = $ncustomer_credi_card->get_alldata()) {
                                                if (!empty($cards))
                                                    foreach ($cards as $card) {
                                                        $customer_credi_card[] = [
                                                            "customer_credi_card_id" => $card->customer_credi_card_id,
                                                            "credicard_title" => $card->credicard_title,
                                                            "credi_card_number" => $card->credi_card_number,
                                                            "month" => $card->month,
                                                            "year" => $card->year,
                                                            "card_security_number" => $card->card_security_number,
                                                        ];
                                                    }
                                            }

                                            //Kullanıcı mail Adresleri
                                            $ncustomer_mail = new table_customer_mail();
                                            $ncustomer_mail->select();
                                            $ncustomer_mail->add_condition("customer_id", $customer_id);
                                            $customer_mail = [];
                                            if ($mails = $ncustomer_mail->get_alldata()) {
                                                if (!empty($mails))
                                                    foreach ($mails as $mail) {
                                                        $customer_mail[] = [
                                                            "customer_mail_id" => $mail->customer_mail_id,
                                                            "customer_mail" => $mail->customer_mail,
                                                            "confirm" => $mail->confirm,
                                                        ];
                                                    }
                                            }



                                            //Kullanıcı mail Adresleri
                                            $ncustomer_favorites = new table_customer_favorites();
                                            $ncustomer_favorites->select();
                                            $ncustomer_favorites->add_condition("customer_id", $customer_id);
                                            $ncustomer_favorites->add_condition("public", 1, "=", "customer_favorites");
                                            $ncustomer_favorites->add_condition("admin_public", 1, "=", "customer_favorites");
                                            $ncustomer_favorites->add_condition("public", 1, "=", "product");
                                            $ncustomer_favorites->add_direction("ASC");
                                            $ncustomer_favorites->add_direction_by("date");
                                            $ncustomer_favorites->add_join("product", "product_id");
                                            $customer_favorites = [];

                                            if ($favorites = $ncustomer_favorites->get_alldata()) {
                                                $product_module = new product_module();
                                                if (!empty($favorites))
                                                    foreach ($favorites as $favorite) {
                                                        $prodcut_price_info = $product_module->get_product_sales_price($favorite->product_id);
                                                        $customer_favorites[] = [
                                                            "id" => $favorite->product_id,
                                                            "product_name" => $product_module->get_product_name($favorite->product_name),
                                                            "product_sub_name" => $product_module->get_product_subname($favorite->product_sub_name),
                                                            "product_sales_price" => number_format($prodcut_price_info["product_sales_price"], 2),
                                                            "product_unit" => strtoupper($prodcut_price_info["product_sales_price_unit"]),
                                                            "product_favorite" => $favorite->favorite,
                                                            "date" => timeConvert($favorite->date),
                                                        ];
                                                    }
                                            }



                                            $data["customer_info"] = [
                                                "customer_id" => $customer_id,
                                                "customer_personel_id" => $customer_personel_data->customer_personel_id,
                                                "customer_email" => $user_email,
                                                "customer_name" => html_entity_decode($customer_personel_data->name),
                                                "customer_lastname" => html_entity_decode($customer_personel_data->lastname),
                                                "customer_gender" => $customer_personel_data->gender,
                                                "customer_birth_day" => $customer_personel_data->birth_day,
                                                "customer_birth_month" => $customer_personel_data->birth_month,
                                                "customer_birth_year" => $customer_personel_data->birth_year,
                                                "customer_profession" => html_entity_decode($customer_personel_data->profession),
                                                "customer_professional_duty" => html_entity_decode($customer_personel_data->professional_duty),
                                                "customer_idnumber" => $customer_personel_data->idnumber,
                                                "public" => $customer_info->public,
                                                "sales" => $customer_info->sales,
                                                "customer_tags" => $customer_tags,
                                                "customer_adress_list" => $customer_adres,
                                                "customer_phone_list" => $customer_phone,
                                                "customer_credi_card_list" => $customer_credi_card,
                                                "customer_mail_list" => $customer_mail,
                                                "customer_favorite_list" => $customer_favorites,
                                            ];


                                            $data["type"] = "GET_USER_DATA";
                                            $data["message"] = "Giriş Başarılı.";
                                        } else {
                                            $data["type"] = "NO_PERSONEL_INFO";
                                            $data["error"] = true;
                                            $data["message"] = "Kişisel verilerilerinizi ulaşamıyoruz. Lütfen hesabınızı yeniden düzenlemeyi deneyiniz.";
                                        }
                                    } else {
                                        $data["type"] = "NO_COMPANY";
                                        $data["error"] = true;
                                        $data["message"] = "Bu Alandan Firma hesabi ile giriş yapamazsınız.Kişisel hesabınız ile kayıt olmayı ve giriş yapmayı deneyiniz.";
                                    }
                                } else {
                                    $data["type"] = "NO_RECORD";
                                    $data["error"] = true;
                                    $data["message"] = "Mail adresiniz ve şifreniz sistem ile uyuşmakta ancak kullanıcı bilgilerinize ulaşamıyoruz.Bu hata için sistem yöneticisi ile acilen temasa geçmenizi öneriyoruz.";
                                }
                            } else {
                                $data["type"] = "NO_ACCOUNT";
                                $data["error"] = true;
                                $data["message"] = "Kullanıcının Sistem içinde bir hesabı bulunmuyor";
                            }
                        } else {
                            $data["type"] = "NO_USERID";
                            $data["error"] = true;
                            $data["message"] = "Kullanıcı ID'si Okunamıyor";
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

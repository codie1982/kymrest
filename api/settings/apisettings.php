<?php

header('Content-Type: application/json');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of apisettings
 *
 * @author engin
 */
class apisettings {

    //put your code here
    public function getapplicationsettingsAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {

                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();

                //genel ayarlar
                //Ürün Arayları
                //gönderim ayarları
                //Sipaiş ayarları
                //Kategori Ayarları
                //Genel Ayarlar
                //Tema Ayarları
                //Firma Ayarları
                $napplication = new table_settings_customer_application();
                $napplication->select();

                $napplication->add_limit_start(1);
                $napplication->add_direction("DESC");

                if ($application_data = $napplication->get_alldata(true)) {
                    if ($application_data->public == 1) {

                        $ngeneral_settings = new table_settings_general();
                        $ngeneral_settings->select();
                        $ngeneral_settings->add_limit_start(1);
                        $ngeneral_settings->add_direction("DESC");
                        $general_settings = $ngeneral_settings->get_alldata(true);

                        $myCompany_id = $general_settings->mycompany_id;
                        $company_info = data::allInfo("customer", $myCompany_id);
                        $data["general_settings"] = [
                            "company_name" => ucwords_tr(html_entity_decode($company_info["customer_company"][0]->customer_company_title)),
                            "company_type" => $company_info["customer_company"][0]->company_type,
                        ];


                        $site_tema = modules::getModuleList("user");
                        $temaclass = "table_settings_" . $site_tema;
                        $ntema_settings = new $temaclass();
                        $ntema_settings->select();
                        $ntema_settings->add_limit_start(1);
                        $ntema_settings->add_direction("DESC");
                        $tema_gsettings = $ntema_settings->get_alldata(true);

                        $nimage = new table_image_gallery();
                        $image_info = $nimage->get_image_info($tema_gsettings->image_gallery_id);

                        $ht = site_info("site_link");
                        $logo_url = $ht . get_image($image_info);
                        $logo_url_100 = $ht . get_image($image_info, 100);
                        $logo_url_500 = $ht . get_image($image_info, 500);
                        $data["tema_settings"] = [
                            "site_title" => $tema_gsettings->site_title,
                            "site_description" => base64_decode($tema_gsettings->site_description),
                            "site_logo" => [
                                "orj" => $logo_url,
                                "100" => $logo_url_100,
                                "500" => $logo_url_500,
                            ],
                            "site_keywords" => $tema_gsettings->site_keywords,
                            "site_url" => $ht,
                            "site_mail" => $tema_gsettings->site_mail,
                        ];

                        $nproduct_settings = new table_settings_product();
                        $nproduct_settings->select();
                        $nproduct_settings->add_limit_start(1);
                        $nproduct_settings->add_direction("DESC");
                        $product_settings = $nproduct_settings->get_alldata(true);


                        $ndelivery_settings = new table_settings_transport();
                        $ndelivery_settings->select();
                        $ndelivery_settings->add_limit_start(1);
                        $ndelivery_settings->add_direction("DESC");
                        $delivery_data = $ndelivery_settings->get_alldata(true);

                        if ($delivery_data->transport_location_price == 1) {
                            $ndelivery_location_settings = new table_settings_transport_location();
                            $ndelivery_location_settings->select();
                            $delivery_location_settings = $ndelivery_location_settings->get_alldata();

                            if (!empty($delivery_location_settings))
                                foreach ($delivery_location_settings as $setting) {
                                    $delivery_data->delivery_location[] = $setting;
                                }
                        }

                        //dnd($delivery_data);

                        $delivery_type;
                        if ($delivery_data->messenger == 1) {
                            $delivery_type = "messenger";
                            $delivery_extra_price = $delivery_data->messenger_price;
                            $delivery_extra_price_unit = $delivery_data->messenger_price_unit;
                        }

                        if ($delivery_data->transport_truck == 1) {
                            $delivery_type = "transport_truck";
                            $delivery_extra_price = $delivery_data->transport_truck_price;
                            $delivery_extra_price_unit = $delivery_data->transport_truck_price_unit;
                        }

                        if ($delivery_data->cargo == 1) {
                            $delivery_type = "cargo";
                            $delivery_extra_price = $delivery_data->cargo_price;
                            $delivery_extra_price_unit = $delivery_data->cargo_price_unit;
                        }
                        if ($delivery_data->no_transport == 1) {
                            $delivery_settings = null;
                        } else {
                            $delivery_settings = [
                                "delivery_price" => $delivery_data->transport_price,
                                "delivery_price_fixed" => number_format($delivery_data->transport_price, 2),
                                "delivery_price_unit" => $delivery_data->transport_price_unit,
                                "delivery_type" => $delivery_type,
                                "delivery_extra_price" => $delivery_extra_price,
                                "delivery_extra_price_unit" => $delivery_extra_price_unit,
                                "anchor_type" => $delivery_data->transport_price_type,
                                "anchor_threshold" => $delivery_data->transport_anchor_threshold,
                                "anchor_calculation_type" => $delivery_data->transport_anchor_type,
                                "anchor_value" => $delivery_data->transport_anchor_value,
                                "location_price" => $delivery_data->transport_location_price,
                            ];
                            if ($delivery_data->transport_location_price == 1) {
                                foreach ($delivery_data->delivery_location as $location) {
                                    $delivery_settings["locations"][] = [
                                        "province" => $location->province,
                                        "district" => $location->district,
                                        "neighborhood" => $location->neighborhood,
                                        "direction" => $location->direction,
                                        "calculation_method" => $location->addmethod,
                                        "value" => $location->value,
                                        "unit" => $location->price_unit,
                                    ];
                                }
                            }
                        }

                        //dnd($delivery_settings);

                        $njob_settings = new table_settings_jobs();
                        $njob_settings->select();
                        $njob_settings->add_limit_start(1);
                        $njob_settings->add_direction("DESC");

                        $job_settings = $njob_settings->get_alldata(true);
                        $job_module = new job_module();

                        $payment_method = $job_module->get_payment_methods();

                        $time_threshold = null;
                        if ($job_settings->time_threshold == 1) {
                            $time_threshold = ["time_threshold_hour" => $job_settings->time_threshold_hour, "time_threshold_minute" => $job_settings->time_threshold_minute];
                        }

                        $user_last_job = null;
                        if ($job_settings->user_last_job == 1) {
                            $user_last_job = ["user_last_job_hour" => $job_settings->user_last_job_hour, "user_last_job_minute" => $job_settings->user_last_job_minute];
                        }

                        $user_job_limit = null;
                        if ($job_settings->user_job_limit == 1) {
                            $user_job_limit = ["max_job_count" => $job_settings->max_job_count];
                        }

                        $user_job_limit = null;
                        if ($job_settings->job_prepare_workable == "general") {
                            $prepare_time = ["prepare_time" => $job_settings->prepare_time, "prepare_time_type" => $job_settings->prepare_time_type];
                        }

                        $data["settings"] = [
                            "product_settings" => $product_settings,
                            "delivery_settings" => $delivery_settings,
                            "category_settings" => $customer_settings,
                            "job_settings" => [
                                "extra_function" => $job_settings->product_extra_function,
                                "payment_method" => $payment_method,
                                "time_threshold" => $time_threshold,
                                "last_job" => $user_last_job,
                                "max_job" => $user_job_limit,
                                "prepare_time" => $prepare_time,
                                "delivery_time_select_byuser" => $job_settings->delivery_time_select_byuser,
                                "job_limit_delivery_location" => $job_settings->job_limit_delivery_location,
                            ],
                        ];
                        $data["type"] = "APPLICATION_SETTINGS";
                        $data["message"] = " Sistem ayarları başarıyla alındı";
                    } else {
                        $data["type"] = "NO_PUBLIC";
                        $data["error"] = true;
                        $data["message"] = "Aplikasyon Bir Süreliğine Bakım Altındadır.";
                    }
                } else {
                    $data["type"] = "NO_INFO";
                    $data["error"] = true;
                    $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
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

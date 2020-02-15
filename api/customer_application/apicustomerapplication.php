<?php

header('Content-Type: application/json');

class apicustomerapplication {

    public function __construct() {
        return true;
    }

    public function getapplicationinfoAction() {
       
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                $napplication = new table_settings_customer_application();
                $napplication->select();
                $napplication->add_limit_start(1);
                $napplication->add_direction("DESC");
                $application_data = $napplication->get_alldata(true);
                if ($application_data = $napplication->get_alldata(true)) {
                    if ($application_data->public == 1) {
                        $data["application_data"] = [
                            "title" => $application_data->title,
                            "protocol" => $application_data->protocol,
                            "ipnumber" => $application_data->ipnumber,
                            "portnumber" => $application_data->portnumber,
                            "sub_company" => false,
                            "main_slider" => $application_data->main_slider,
                            "primary_color" => $application_data->primary_color,
                            "text_color" => $application_data->text_color,
                        ];
                        $data["type"] = "APPLICATION_INFO";
                        $data["message"] = " Aplikasyon Bilgileri Başarıyla Alındı";
                    } else {
                        $data["type"] = "NO_PUBLIC";
                        $data["error"] = true;
                        $data["message"] = "Ağlikasyon Bilgileri Alınamadı.";
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

    public function getapplicationmainsliderAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {

                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                $nslider = new table_application_main_slider();
                $nslider->select();
                $nslider->add_condition("public", 1);
                $nslider->add_condition("application_number", modules::getModuleList("application_key"));
                if ($sliders = $nslider->get_alldata()) {
                    $image_urls = [];
                    $ht = site_info("site_link");
                    foreach ($sliders as $slider) {
                        $nimage_info = new table_image_gallery();
                        $nimage_info->select();
                        $nimage_info->add_condition("image_gallery_id", $slider->image_gallery_id);
                        $image_info = $nimage_info->get_alldata(true);

                        if ($slider->screen_type == "category") {
                            $ncategory = new table_category();
                            $ncategory->add_filter("category_id");
                            $ncategory->add_filter("category_name");
                            $ncategory->select();
                            $ncategory->add_condition("category_id", $slider->screen);
                            $category_info = $ncategory->get_alldata(true);

                            $image_data[] = [
                                "redirect_screen_type" => $slider->screen_type,
                                "redirect_screen" => $slider->screen,
                                "category_id" => $category_info->category_id,
                                "category_name" => html_entity_decode($category_info->category_name),
                                "url" => $ht . get_closest_image($image_info, 500),
                            ];
                        } else if ($slider->screen_type == "product") {

                            $nproduct = new table_product();
                            $nproduct->add_filter("product_id");
                            $nproduct->add_filter("product_name");
                            $nproduct->add_filter("product_sub_name");
                            $nproduct->add_filter("product_price_unit");
                            $nproduct->select();
                            $nproduct->add_condition("product_id", $slider->screen);
                            $product_info = $nproduct->get_alldata(true);
                            //$nproduct->show_sql();
                            //dnd($product_info);
                            $product_module = new product_module();
                            $product_sales_info = $product_module->get_product_sales_price($product_info->product_id);
                            $image_data[] = [
                                "redirect_screen_type" => $slider->screen_type,
                                "redirect_screen" => $slider->screen,
                                "product_id" => $slider->screen,
                                "product_name" => $product_module->get_product_name($product_info->product_name),
                                "product_sales_price" => $product_sales_info["product_sales_price"],
                                "product_sub_name" => $product_module->get_product_subname($product_info->product_sub_name),
                                "product_unit" => default_currency(),
                                "url" => $ht . get_closest_image($image_info, 500),
                            ];
                        } else {
                            $image_data[] = [
                                "redirect_screen_type" => $slider->screen_type,
                                "url" => $ht . get_closest_image($image_info, 500),
                            ];
                        }
                    }

                    $data["slider_data"] = $image_data;
                    $data["type"] = "APPLICATION_INFO";
                    $data["message"] = " Aplikasyon Bilgileri Başarıyla Alındı";
                } else {
                    $data["type"] = "NO_IMAGE";
                    $data["error"] = true;
                    $data["message"] = "Slider'a Resim Eklenmemiş";
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

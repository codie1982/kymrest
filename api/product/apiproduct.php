<?php

header('Content-Type: application/json');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_category
 *
 * @author engin
 */
class apiproduct {

    public function __construct() {
        return true;
    }

    public function getproductlistAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        if (isset($getdata[2])) {
                            $category_id = $getdata[2];
                            $activePage = !isset($getdata[3]) ? "1" : $getdata[3];
                            //Seçili Kateogri var ise

                            $pagePerCount = 5;
                            $start = ($activePage - 1) * $pagePerCount;
                            $end = $pagePerCount;

                            $nproduct = new table_product();
                            $nproduct->add_filter("product_id");
                            $nproduct->add_filter("product_name");
                            $nproduct->add_filter("product_sub_name");
                            $nproduct->add_filter("favorite");
                            $nproduct->select();
                            $nproduct->add_join("product_category", "product_id");
                            $nproduct->add_condition("category_id", $category_id, "=", "product_category");
                            $nproduct->add_limit_start($start);
                            $nproduct->add_limit_end($end);
                            $nproduct->add_direction_by("product_id");
                            $nproduct->add_direction("DESC");
                            $nproduct->add_condition("public", 1);
                            if ($products = $nproduct->get_alldata()) {
                                $setProductData = [];
                                $product_module = new product_module();
                                foreach ($products as $product) {
                                    $prodcut_price_info = $product_module->get_product_sales_price($product->product_id);
                                    $setProductData = [
                                        "id" => $product->product_id,
                                        "product_name" => $product_module->get_product_name($product->product_name),
                                        "product_sub_name" => $product_module->get_product_subname($product->product_sub_name),
                                        "product_sales_price" => number_format($prodcut_price_info["product_sales_price"], 2),
                                        "product_unit" => strtoupper($prodcut_price_info["product_sales_price_unit"]),
                                        "product_favorite" => $product->favorite,
                                    ];
                                    $data["product_list"][] = $setProductData;
                                }


                                $nproductC = new table_product();
                                $nproductC->set_count();
                                $nproductC->select();
                                $nproductC->add_join("product_category", "product_id");
                                $nproductC->add_condition("category_id", $category_id, "=", "product_category");
                                $nproductC->add_condition("public", 1);

                                $products_count = $nproductC->get_alldata(true);

                                $data["active_page"] = $activePage;
                                $data["last_page"] = round($products_count / $pagePerCount);
                                $data["perPage_product"] = $pagePerCount;
                                $data["open_pagination"] = $products_count > $pagePerCount ? 1 : 0;
                                $data["type"] = "GET_PRODUCT_LIST";
                                $data["message"] = "Ürün Listesi Başarılı Şekilde Alındı";
                            } else {
                                //Örnek ürünler kısmında bir listeleme yapabiliriz
                                $data["type"] = "NO_PRODUCTS";
                                $data["error"] = true;
                                $data["message"] = "Seçili Kategoride Ürün Bulunmamaktadır";
                            }
                        } else {
                            $data["type"] = "NO_CATEGORY";
                            $data["error"] = true;
                            $data["message"] = " Ürünlerin Listeleneceği Bir Kategori Seçili Değil";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $data[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $data[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function getproductdetailAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        if (isset($getdata[2])) {
                            $product_id = $getdata[2];
                            //Seçili Kateogri var ise
                            $nproduct = new table_product();
                            $nproduct->select();
                            $nproduct->add_condition("product_id", $product_id);
                            $nproduct->add_condition("public", 1);
                            $nproduct->add_condition("product_type", "standart");
                            //$nproduct->show_sql();
                            if ($productDB = $nproduct->get_alldata(true)) {
                                $nproduct_settings = new table_settings_product();
                                $product_settings = $nproduct_settings->get_data();
                                //dnd($product_settings);
                                $setProductData = [];
                                $product_module = new product_module();
                                $prodcut_price_info = $product_module->get_product_price($productDB->product_id);
                                $prodcut_discount_info = $product_module->get_product_discount($productDB->product_id);
                                $prodcut_taxt_info = $product_module->get_product_tax_price($productDB->product_id);
                                $prodcut_sales_price_info = $product_module->get_product_sales_price($productDB->product_id);


                                $nproduct_category = new table_product_category();
                                $nproduct_category->select();
                                $nproduct_category->add_condition("product_id", $productDB->product_id, "=", "product_category");
                                $nproduct_category->add_condition("public", 1, "=", "category");
                                $nproduct_category->add_join("category", "category_id");
                                if ($prodcut_category_data = $nproduct_category->get_alldata()) {
                                    
                                } else {
                                    $prodcut_category_data == null;
                                }
                                //$nproduct_category->show_sql();

                                $nproduct_gallery = new table_product_gallery();
                                $nproduct_gallery->select();
                                $nproduct_gallery->add_condition("product_id", $productDB->product_id);

                                if ($product_gallery = $nproduct_gallery->get_alldata()) {
                                    foreach ($product_gallery as $gl) {
                                        $nimage_gallery = new table_image_gallery();
                                        $image_info = $nimage_gallery->get_data($gl->image_gallery_id);
                                        $product_image_list[] = get_closest_image($image_info, 500);
                                    }
                                } else {
                                    $product_image_list = null;
                                }

                                $nproduct_constant = new product_constant();
                                $sproduct_transport = $product_module->get_product_transport($productDB->product_id);
                                $product_transport_type = $sproduct_transport["type"];
                                $product_transport = [];
                                if ($product_transport_type == $nproduct_constant::changeable) {
                                    $product_transport = $sproduct_transport;
                                } else {
                                    $product_transport = null;
                                }
                                $product_price_group = [];
                                if ($productDB->product_price_type == $nproduct_constant::options) {
                                    $npr_group = new table_product_price_group();
                                    $npr_group->select();
                                    $npr_group->add_condition("product_id", $productDB->product_id);
                                    $npr_group->add_condition("public", 1);
                                    $npr_group->add_condition("admin_public", 1);
                                    $npr_group->add_direction("DESC");
                                    $npr_group->add_direction_by("group_line");
                                    $groups = $npr_group->get_alldata();


                                    $npr_options = new table_product_price_option();
                                    $npr_options->select();
                                    $npr_options->add_condition("product_id", $productDB->product_id);
                                    $npr_options->add_condition("public", 1);
                                    $npr_options->add_condition("admin_public", 1);

                                    $npr_options->add_direction("DESC");
                                    $npr_options->add_direction_by("options_line");
                                    $options = $npr_options->get_alldata();
                                    // $npr_options->show_sql();
                                    //dnd($options);
                                    $i = 0;
                                    foreach ($groups as $group) {
                                        $product_price_group[$i] = ["group_id" => $group->product_price_group_id, "title" => ucwords_tr(html_entity_decode($group->group_title)), "type" => $group->group_type];
                                        foreach ($options as $option) {
                                            if ($group->product_price_group_id == $option->product_price_group_id) {
                                                $product_price_group[$i]["opitons"][] = [
                                                    "option_id" => $option->product_price_option_id,
                                                    "title" => ucwords_tr(html_entity_decode($option->product_price_title)),
                                                    "direction" => $option->direction,
                                                    "type" => $option->type,
                                                    "value" => $option->value,
                                                    "selection" => $option->default_selection == "selected" ? true : false,
                                                ];
                                            }
                                        }
                                        $i++;
                                    }
                                } else {
                                    $product_price_group = null;
                                }
                                //dnd($product_price_group);
                                $setProductData = [
                                    "product_name" => $product_module->get_product_name($productDB->product_name),
                                    "product_sub_name" => $product_module->get_product_subname($productDB->product_sub_name),
                                    "product_price" => $prodcut_price_info["product_price"],
                                    "product_sales_price" => $prodcut_sales_price_info["product_sales_price"],
                                    "product_unit" => strtoupper(html_entity_decode($prodcut_price_info["product_price_unit"])),
                                    "product_discount_rate" => $prodcut_discount_info["discount_rate"],
                                    "product_tax_rate" => $prodcut_taxt_info["product_tax_rate"],
                                    "product_stock" => $productDB->product_stock,
                                    "product_description" => $product_module->get_product_description($productDB->product_description),
                                    "product_keywords" => $product_module->get_product_keywords($productDB->product_keywords),
                                    "product_category" => $prodcut_category_data,
                                    "product_gallery" => $product_image_list,
                                    "product_transport" => $product_transport,
                                    "product_price_type" => $productDB->product_price_type,
                                    "product_price_group" => $product_price_group,
                                ];

                                $data["product_detail"] = $setProductData;
                                $data["type"] = "GET_PRODUCT_DETAIL";
                                $data["message"] = "Ürün Bilgisi Başarılı bir şekilde alındı";
                            } else {
                                $data["type"] = "NO_PRODUCT";
                                $data["error"] = true;
                                $data["message"] = "Seçili Ürün Bulunamıyor";
                            }
                        } else {
                            $data["type"] = "NO_PRODUCT_ID";
                            $data["error"] = true;
                            $data["message"] = "Ürün İd'si  Tanımlanmamış";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $data[1] . " - " . " Fonksiyon Methoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $data[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function getfavoritesproductsAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {

                        $nproduct = new table_product();
                        $nproduct->add_filter("product_id");
                        $nproduct->add_filter("product_name");
                        $nproduct->add_filter("product_sub_name");
                        $nproduct->select();
                        $nproduct->add_limit_start(10);
                        $nproduct->add_direction_by("product_id");
                        $nproduct->add_direction("ASC");
                        $nproduct->add_condition("public", 1);
                        $nproduct->add_condition("favorite", 1);
                        if ($products = $nproduct->get_alldata()) {
                            $favoriteData = [];
                            $product_module = new product_module();
                            foreach ($products as $product) {
                                $prodcut_price_info = $product_module->get_product_sales_price($product->product_id);
                                $favoriteData = [
                                    "id" => $product->product_id,
                                    "product_name" => $product_module->get_product_name($product->product_name),
                                    "product_sub_name" => $product_module->get_product_subname($product->product_sub_name),
                                    "product_sales_price" => number_format($prodcut_price_info["product_sales_price"], 2),
                                    "product_unit" => strtoupper($prodcut_price_info["product_sales_price_unit"]),
                                    "product_favorite" => 1,
                                ];
                                $data["favorite_product_list"][] = $favoriteData;
                            }
                            $data["type"] = "GET_PRODUCT_FAVORITE_LIST";
                            $data["message"] = "Öne Çıkanlar Listesi Başarıyla Alındı";
                        } else {
                            //Örnek ürünler kısmında bir listeleme yapabiliriz
                            $data["type"] = "NO_PRODUCTS";
                            $data["error"] = true;
                            $data["message"] = "Seçili Kategoride Ürün Bulunmamaktadır";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $data[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $data[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function searchproductAction() {
        $nvalidate = new validate();
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        $data["postdata"] = $postdata;

                        $search_product_text = strtolower(trim(htmlentities($postdata->searct_text)));

                        $nproduct = new table_product();
                        $nproduct->select();
                        $nproduct->add_condition("product_name", [
                            "LIKE" => [$search_product_text]
                        ]);
                        $product_data = $nproduct->get_alldata();
                        if ($product_data = $nproduct->get_alldata()) {

                            $product_module = new product_module();
                            foreach ($product_data as $product) {
                                $prodcut_price_info = $product_module->get_product_sales_price($product->product_id);
                                $setProductData = [
                                    "id" => $product->product_id,
                                    "product_name" => $product_module->get_product_name($product->product_name),
                                    "product_sub_name" => $product_module->get_product_subname($product->product_sub_name),
                                    "product_sales_price" => number_format($prodcut_price_info["product_sales_price"], 2),
                                    "product_unit" => strtoupper($prodcut_price_info["product_sales_price_unit"]),
                                    "product_favorite" => $product->favorite,
                                ];
                                $data["search_product_list"][] = $setProductData;
                            }

                            $data["type"] = "SEARCH_PRODUCT_LIST";
                            $data["error"] = false;
                            $data["message"] = "Aramaya Ait Ürün Listesi";
                        } else {
                            $nvalidate->addError();
                            $data["type"] = "NO_SEARCH";
                            $data["error"] = true;
                            $data["message"] = "Bu arama terimine ait ürün bulunamadı.";
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

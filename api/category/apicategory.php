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
class apicategory {

    public function __construct() {
        return true;
    }

    public function getcategoryAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        if (isset($getdata[2])) {
                            $category_id = $getdata[2];
                            //Seçili Kateogri var ise
                            $ncategory = new table_category();
                            $ncategory->select();
                            $ncategory->add_condition("category_id", $category_id);
                            $ncategory->add_condition("public", 1);
                            $category_info = $ncategory->get_alldata(true);
                            $data["category"] = [
                                "category_id" => $category_info->category_id,
                                "parent_category_id" => $category_info->parent_category_id,
                                "category_name" => $category_info->category_name,
                                "category_description" => base64_decode($category_info->category_description),
                                "category_keywords" => $category_info->category_keywords,
                                "sub_categories" => [],
                            ];
                            $data["type"] = "SELECT_CATEGORY";
                            $data["message"] = " Seçili Kategori Başarılı bir şekilde alındı";
                        } else {
                            //Seçili Kateogri yok ise
                            $ncategory = new table_category();
                            $ncategory->select();
                            $ncategory->add_condition("parent_category_id", isset($parameter["parent"]) ? $parameter["parent"] : 0);
                            $ncategory->add_condition("public", 1);
                            $category_info = $ncategory->get_alldata();
                            foreach ($category_info as $info) {
                                //image gallery
                                //alt gruplama alanları
                                $data["category"][] = [
                                    "category_id" => $info->category_id,
                                    "parent_category_id" => $info->parent_category_id,
                                    "category_name" => html_entity_decode($info->category_name),
                                    "category_description" => html_entity_decode(base64_decode($info->category_description)),
                                    "category_keywords" => html_entity_decode($info->category_keywords),
                                ];
                            }
                        }
                        $data["total_category_count"] = count($category_info);
                        $data["type"] = "SELECT_CATEGORY_LIST";
                        $data["message"] = " Kategori Listesi Başarılı Şekilde Alındı";
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

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sidebar
 *
 * @author engin
 */
class waiting_order extends component {

    public function __construct($parameter) {
        
    }

    public function render($parameter) {
        $this->set_component_name("waiting_order");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                // dnd($_POST);
                $start = sanitize($_POST["start"]);
                $end = sanitize($_POST["end"]);
                $direction = sanitize($_POST["direction"]);
                $predata = [];
                for ($i = 0; $i < ($end - $start); $i++) {
                    $ln = $i + 1;
                    $predata[] = "data - " . ($ln + $start);
                }
                $data["result"] = $predata;
                $data["start"] = $start;
                $data["end"] = $end;
                $data["total"] = 30;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function totalAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                // dnd($_POST);
                $component_name = sanitize($_POST["component_name"]);
                $data["total"] = 50;
                $data["sonuc"] = true;
                $data["msg"] = "Toplam Veri Sayısı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function drawAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $total = $_POST["total"];
                $tabledata = $_POST["tabledata"];
                $start_item = $_POST["start"];
                $end_item = $_POST["end"];
                $id = uniqid();
                $ntable = new pretable($tabledata, $id);
                $ntable_cl = [
                    "cloumb" => [
                        ["thead_title" => "Ürün İsmi",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Ürün Ismi"],
                            "tbody_varible" => "product_name",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_name",
                        ],
                        ["thead_title" => "Satış Fiyatı",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Fiyatı"],
                            "tbody_varible" => "product_sales_name",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_sales_price",
                        ],
                        ["thead_title" => "Sayı",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Sayısı"],
                            "tbody_varible" => "product_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_count",
                        ],
                        ["thead_title" => "deneme",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Sayısı"],
                            "tbody_varible" => "product_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_deneme",
                        ]
                    ]
                ];
                $ntable->set_table_info($ntable_cl);
                $ntable->set_control_class("waiting_order_class");
                $ntable->set_table_header(false);
                $ntable->set_table_footer(false);
                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);
                $table = $ntable->add_table(false);
                $data["component_name"] = "waiting_order";
                $data["render"] = $table;
                $data["table_id"] = $ntable->get_table_key();
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

}

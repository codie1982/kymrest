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
class job_table extends component {

    public function render($parameter) {
        $this->set_component_name("job_table");
        $this->make_component($parameter["type"]);
    }

    public function loadAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $data = $_REQUEST["data"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

                $category_id = $_REQUEST["category_id"];
                $category_name = $_REQUEST["category_name"];

                $nview = new view();

                component::import_component("job_table", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["job_table"];
                $data["starter"] = component::starter($data["tempstarter"]);
                $data["sonuc"] = true;
                $nvalidate->addSuccess("Form verileri alınmıştır..");
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Öncelikle Giriş Yapmanız gerekmektedir.");
        }
        if (!empty($nvalidate->get_warning()))
            foreach ($nvalidate->get_warning() as $wr) {
                $data["warning_message"][] = $wr;
            }
        if (!empty($nvalidate->get_success()))
            foreach ($nvalidate->get_success() as $sc) {
                $data["success_message"][] = $sc;
            }
        if (!empty($nvalidate->get_errors()))
            foreach ($nvalidate->get_errors() as $err) {
                $data["error_message"][] = $err;
            }

        echo json_encode($data);
    }

    public function getdataAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                //dnd($_POST);
                $start = sanitize($_POST["start"]);
                $end = sanitize($_POST["end"]);
                $direction = sanitize($_POST["direction"]);
                $component_name = sanitize($_POST["component_name"]);
                $njob = new table_job();
                $njob->select();
                $job_data = $njob->get_alldata();
                
                $data["start"] = $start;
                $data["end"] = $end;
                if ($job_data) {
                    $ntjob = new table_job();
                    $ntjob->set_count();
                    $ntjob->select();
                    $total_data = $ntjob->get_alldata(true);
                  
                    $data["result"] = $job_data;
                    $data["total"] = $total_data;
                } else {
                    $data["result"] = 0;
                    $data["total"] = 0;
                }
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

    public function drawAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $total = $_POST["total"];
                $tabledata = $_POST["tabledata"];
                $start_item = $_POST["start"];
                $end_item = $_POST["end"];
                $update = $_POST["update"];
                $id = uniqid();
                $ntable = new pretable($tabledata, $id);
                $cloumb = [
                    "cloumb" => [
                        ["thead_title" => "#",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Yayın Durumu"],
                            "tbody_varible" => "product_public",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_public",
                        ],
                        ["thead_title" => "Sipariş Numarası",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "sipariş numarası"],
                            "tbody_varible" => "product_code",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_number",
                        ],
                        ["thead_title" => "Kullanıcı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Kullanıcı"],
                            "tbody_varible" => "product_name",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_user",
                        ],
                        ["thead_title" => "Ürün Sayısı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün sayısı"],
                            "tbody_varible" => "product_category",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_count",
                        ],
                        ["thead_title" => "Toplam Ücret",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Toplam Ücret"],
                            "tbody_varible" => "product_stock",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "card_total",
                        ],
                        ["thead_title" => "Toplam Kar",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Toplam Kazanç"],
                            "tbody_varible" => "product_payment_method",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "total_revenues",
                        ],
                        ["thead_title" => "Alınan Ödeme",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Alınan Ödeme"],
                            "tbody_varible" => "product_transport",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "total_payment",
                        ],
                        ["thead_title" => "Spiariş Zamanı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Sipariş Zamanı"],
                            "tbody_varible" => "product_price",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_time",
                        ],
                        ["thead_title" => "Sonraki Aşama",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Sonraki Aşama"],
                            "tbody_varible" => "product_discount",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "next_event",
                        ],
                        ["thead_title" => "Eylemler",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Fiyatı"],
                            "tbody_varible" => "actions",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "actions",
                        ]
                    ]
                ];
                $ntable->set_table_info($cloumb);
                $ntable->set_control_class("job_table_class");
                $ntable->set_component_name("job_table");
                $ntable->set_table_header(true);

                $ntable->set_check_cloumb(true);
                $ntable->set_table_remove_button(true);
                $ntable->set_table_filters(true);

                $ntable->add_table_filter("En Çok Satılan Ürünleri Göster", "fa fa-pencil", "show_best_products");

                $ntable->set_table_search_input(true);
                $ntable->set_multiple_search(false);
                $ntable->set_table_refresh_button(true);

                if ($update == "true") {
                    $ntable->set_table_update(true);
                }

                $ntable->set_table_footer(true);
                $ntable->set_error_message("Listenizde ekli herhangi bir sipariş bulunmamaktadır");

                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);
                $table = $ntable->add_table(false);

                $data["component_name"] = "job_table";
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

    public function searchAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $q = input::santize($_REQUEST["q"]);
                $items = [];
                $ncustomer = new table_customer();
                $res = $ncustomer->search_customer($q);
                if (!empty($res)) {
                    foreach ($res as $r) {
                        $items[] = get_object_vars($r);
                    }
                    $data["items"] = $items;
                }
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function searchdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                //dnd($_POST);
                $keyword = sanitize($_POST["keyword"]);
                $component_name = sanitize($_POST["component_name"]);


                $ncustomer = new table_customer();
                $customer_data = $ncustomer->search_customer_data($keyword);
                //dnd($customer_data);
                $total_data = count($customer_data);
                $data["result"] = $customer_data;
                $data["start"] = $start;
                $data["end"] = $end;
                $data["total"] = $total_data;
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

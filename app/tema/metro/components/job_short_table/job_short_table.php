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
class job_short_table extends component {

    public function render($parameter) {
        $this->set_component_name("job_short_table");
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

                component::import_component("job_short_table", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["job_short_table"];
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
                $njob->add_filter("job_id");
                $njob->select();
                $njob->add_condition("job_number", "-1", "<>");
                $njob->add_condition("complete", "0");
                if ($end != 0) {
                    $njob->add_limit_start($start);
                    $njob->add_limit_end($end);
                }

                $njob->add_direction($direction);
                $njob->add_direction_by("customer_confirm_date");
                $job_data = $njob->get_alldata();
//                $njob->show_sql();
//                $njob->show_where();
//                $njob->show_where_value();
                
                $alldata = [];
                if (!empty($job_data))
                    foreach ($job_data as $dt) {
                        $primary_value = $dt->job_id;
                        $sbfx = [];
                        $alldata[] = data::allInfo("job", $primary_value);
                    }

                $data["start"] = $start;

                if ($job_data) {
                    if ($end == 0) {
                        $data["end"] = count($job_data);
                        $data["result"] = $alldata;
                        $data["total"] = count($job_data);
                    } else {
                        $ntjob = new table_job();
                        $ntjob->set_count();
                        $ntjob->select();
                        $ntjob->add_condition("job_number", "-1", "<>");
                        $ntjob->add_condition("complete", "0");
                        $total = $ntjob->get_alldata(true);
                        $data["result"] = $alldata;
                        $data["total"] = $total;
                        $data["end"] = $end;
                    }
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

    public function get_last_dataAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $direction = sanitize($_POST["direction"]);
                $component_name = sanitize($_POST["component_name"]);
                $njob = new table_job();
                $njob->add_filter("job_id");
                $njob->select();
                $njob->add_direction("DESC");
                $njob->add_condition("job_number", "-1", "<>");
                $njob->add_condition("complete", "0");

                $njob->add_limit_start(1);



                $njob->add_direction_by("customer_confirm_date");
                $job_data = $njob->get_alldata();
                $alldata = [];
                if (!empty($job_data))
                    foreach ($job_data as $dt) {
                        $primary_value = $dt->job_id;
                        $sbfx = [];
                        $alldata[] = data::allInfo("job", $primary_value);
                    }

                $data["start"] = 1;
                $data["end"] = 1;
                $data["result"] = $alldata;
                $data["total"] = 1;
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
                        ["thead_title" => "Durum",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Sipariş Durumu"],
                            "tbody_varible" => "job_status",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_status",
                        ],
                        ["thead_title" => "Kullanıcı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Kullanıcı Bilgisi"],
                            "tbody_varible" => "job_customer",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_customer",
                        ],
                        ["thead_title" => "Ürün Sayısı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Cart üzerindeki Toplam Ürün Sayısı"],
                            "tbody_varible" => "job_product_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_product_count",
                        ],
                        ["thead_title" => "Ödeme Yöntemi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Ödeme Yöntemi"],
                            "tbody_varible" => "job_payment_method",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_payment_method",
                        ],
                        ["thead_title" => "Toplam Ücret",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Toplam Ücret"],
                            "tbody_varible" => "product_stock",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "card_total",
                        ],
                        ["thead_title" => "Göster",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Detayları Göster"],
                            "tbody_varible" => "product_show_detail",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_show_detail",
                        ],
                        ["thead_title" => "Aşama",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Detayları Göster"],
                            "tbody_varible" => "job_product_state",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_product_state",
                        ]
                    ]
                ];
                /*
                  ["thead_title" => "Teslim Zamanı",
                  "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Siparişin Teslim Zamanı"],
                  "tbody_varible" => "job_deliverytime",
                  "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                  "function" => "job_deliverytime",
                  ], */
                $ntable->set_table_info($cloumb);
                $ntable->set_control_class("job_short_table_class");
                $ntable->set_component_name("job_short_table");
                $ntable->set_table_header(true);

                $ntable->set_check_cloumb(true);
                $ntable->set_table_remove_button(true);
                $ntable->set_table_filters(true);

                $ntable->add_table_filter("En Çok Satılan Ürünleri Göster", "fa fa-pencil", "show_best_products");

                $ntable->set_table_search_input(false);
                $ntable->set_multiple_search(false);
                $ntable->set_table_refresh_button(true);

                if ($update == "true") {
                    $ntable->set_table_update(true);
                }

                $ntable->set_table_footer(false);
                $ntable->set_error_message("Gelen Sipariş Bulunmamaktadır");

                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);
                $table = $ntable->add_table(false);

                $data["component_name"] = "job_short_table";
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

    public function lastdrawAction() {
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
                        ["thead_title" => "Durum",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Sipariş Durumu"],
                            "tbody_varible" => "job_status",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_status",
                        ],
                        ["thead_title" => "Kullanıcı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Kullanıcı Bilgisi"],
                            "tbody_varible" => "job_customer",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_customer",
                        ],
                        ["thead_title" => "Ürün Sayısı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Cart üzerindeki Toplam Ürün Sayısı"],
                            "tbody_varible" => "job_product_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_product_count",
                        ],
                        ["thead_title" => "Ödeme Yöntemi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Ödeme Yöntemi"],
                            "tbody_varible" => "job_payment_method",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_payment_method",
                        ],
                        ["thead_title" => "Toplam Ücret",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Toplam Ücret"],
                            "tbody_varible" => "product_stock",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "card_total",
                        ],
                        ["thead_title" => "Göster",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Detayları Göster"],
                            "tbody_varible" => "product_show_detail",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_show_detail",
                        ],
                        ["thead_title" => "Aşama",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Detayları Göster"],
                            "tbody_varible" => "job_product_state",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "job_product_state",
                        ]
                    ]
                ];
                /*
                  ["thead_title" => "Teslim Zamanı",
                  "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Siparişin Teslim Zamanı"],
                  "tbody_varible" => "job_deliverytime",
                  "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                  "function" => "job_deliverytime",
                  ], */
                $ntable->set_table_info($cloumb);
                $ntable->set_control_class("job_short_table_class");
                $ntable->set_component_name("job_short_table");

                $ntable->set_check_cloumb(true);
                $ntable->set_table_remove_button(true);
                $ntable->set_table_filters(true);



                $table = $ntable->one_row();

                $data["component_name"] = "job_short_table";
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

    public function confirm_jobAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {

                $job_id = $_POST["job_id"];
                if (data::update_data("job", ["confirm" => 1, "confirm_date" => getNow()], "job_id", $job_id)) {
                    $data["background"] = "#e2ff9b";
                } else {
                    $data["background"] = "#fff";
                }

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

    public function prepare_jobAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {

                $job_id = $_POST["job_id"];
                if (data::update_data("job", ["prepare" => 1, "prepare_date" => getNow()], "job_id", $job_id)) {
                    $data["background"] = "#d0ff5c";
                } else {
                    $data["background"] = "#fff";
                }

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

    public function delivery_jobAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {

                $job_id = $_POST["job_id"];
                if (data::update_data("job", ["delivery" => 1, "delivery_date" => getNow()], "job_id", $job_id)) {
                    $data["background"] = "#5cff9d";
                } else {
                    $data["background"] = "#fff";
                }

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

    public function delivery_complete_jobAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {

                $job_id = $_POST["job_id"];
                if (data::update_data("job", ["delivery_complete" => 1, "delivery_complete_date" => getNow()], "job_id", $job_id)) {
                    $data["background"] = "#5cf0ff";
                } else {
                    $data["background"] = "#fff";
                }

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

    public function complete_jobAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {

                $job_id = $_POST["job_id"];
                if (data::update_data("job", ["complete" => 1, "complete_date" => getNow()], "job_id", $job_id)) {
                    $data["background"] = "#fff";
                } else {
                    $data["background"] = "#fff";
                }

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

}

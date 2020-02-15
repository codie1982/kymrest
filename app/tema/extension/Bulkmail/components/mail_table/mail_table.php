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
class mail_table extends component {

    public function render($parameter) {
        $this->set_component_name("mail_table");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                //dnd($_POST);
                $start = sanitize($_POST["start"]);
                $end = sanitize($_POST["end"]);
                $direction = sanitize($_POST["direction"]);

                $nsend_mail = new table_send_mail();
                $nsend_mail->select();
                $nsend_mail->add_limit_start($start);
                $nsend_mail->add_limit_end($end);
                $nsend_mail->add_direction($direction);
                $mail_data = $nsend_mail->get_alldata();


                $ntsend_mail = new table_send_mail();
                $ntsend_mail->set_count();
                $ntsend_mail->select();
                $total_mail_data = $ntsend_mail->get_alldata();
                $data["start"] = $start;
                $data["end"] = $end;
                if ($mail_data) {
                    $data["result"] = $mail_data;
                    $data["total"] = $total_mail_data;
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
                        ["thead_title" => "Mail Adresi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail adresi"],
                            "tbody_varible" => "mail_adres",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_adres",
                        ],
                        ["thead_title" => "Mail Konusu",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail konusu"],
                            "tbody_varible" => "mail_subject",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_subject",
                        ],
                        ["thead_title" => "Görüntülenme",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail Görüntülenmesi"],
                            "tbody_varible" => "mail_see",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_see",
                        ],
                        ["thead_title" => "Mail Gönderim Tarihi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail gönderim tarihi"],
                            "tbody_varible" => "mail_send_date",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_send_date",
                        ],
                        ["thead_title" => "Mail Görüntüleme Tarihi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail görüntüleme tarihi"],
                            "tbody_varible" => "mail_see_date",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_see_date",
                        ],
                        ["thead_title" => "Fark",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail gönderilmesi ile mail görüntülenmesi arasındaki fark"],
                            "tbody_varible" => "diff",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "diff",
                        ],
                        ["thead_title" => "ilgilenme oranı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail gönderilmesi ile mail görüntülenmesi arasındaki fark"],
                            "tbody_varible" => "diff",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "diff",
                        ],
                        ["thead_title" => "Mail eylemi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail içindeki aksiyonlar"],
                            "tbody_varible" => "mail_action",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_action",
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
                $ntable->set_control_class("product_table_class");
                $ntable->set_component_name("product_table");
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
                $ntable->set_error_message("Gönderilmiş Herhangi bir mail bulunmamaktadır.");

                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);

                $data["component_name"] = "mail_table";
                $data["render"] = $ntable->add_table(false);
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

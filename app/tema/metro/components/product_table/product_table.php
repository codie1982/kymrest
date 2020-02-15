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
class product_table extends component {

    public function render($parameter) {
        $this->set_component_name("product_table");
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

                component::import_component("product_table", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();
                $data["content"] = $content["product_table"];
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
                $nproduct = new table_product();
                $product_data = $nproduct->get_products_info($start, $end, $direction);
                //dnd($customer_data);
                $data["start"] = $start;
                $data["end"] = $end;
                if ($product_data) {
                    $total_data = $nproduct->get_products_total_count();
                    $data["result"] = $product_data;
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
                            "function" => "product_public",
                        ],
                        ["thead_title" => "#",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Öne Çıkanlar"],
                            "tbody_varible" => "product_public",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_favorite",
                        ],
                        ["thead_title" => "Ürün Kodu",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kodu"],
                            "tbody_varible" => "product_code",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_code",
                        ],
                        ["thead_title" => "Ürün Adı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün adı"],
                            "tbody_varible" => "product_name",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_name",
                        ],
                        ["thead_title" => "Ürün Kategorisi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kategorisi"],
                            "tbody_varible" => "product_category",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_category",
                        ],
                        ["thead_title" => "Stok",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Stok Sayısı"],
                            "tbody_varible" => "product_stock",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_stock",
                        ],
                        ["thead_title" => "Ürün Fiyatı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün fiyatı"],
                            "tbody_varible" => "product_price",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_price",
                        ],
                        ["thead_title" => "İndirim Oranı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "İndirim Oranı"],
                            "tbody_varible" => "product_discount",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_discount",
                        ],
                        ["thead_title" => "Vergilendirme",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün vergilendirmesi"],
                            "tbody_varible" => "product_tax",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_tax",
                        ],
                        ["thead_title" => "Satış Fiyatı",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Ürün Satış Fiyatı"],
                            "tbody_varible" => "product_sales_price",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_sales_price",
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
                $ntable->set_error_message("Listenizde ekli herhangi bir ürün bulunmamaktadır");

                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);
                $table = $ntable->add_table(false);

                $data["component_name"] = "product_table";
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
                $q = sef_link((($_REQUEST["q"])));


                $items = [];
                $nproduct = new table_product();
                $nproduct->add_filter("product_id");
                $nproduct->add_filter("product_name");
                $nproduct->select();
                $nproduct->add_condition("product_name_sef", ["LIKE" => $q]);
                $nproduct->add_condition("public", "1");
                $nproduct->add_condition("product_type", "standart");
                if ($q == "") {
                    $nproduct->add_limit_start(10);
                }
                $items = $nproduct->get_alldata();

                if (!empty($items)) {
                    foreach ($items as $item) {
                        $result[] = ["id" => $item->product_id, "search_keyword" => $item->product_name, "type" => "product"];
                    }
                }
                $ncategory = new table_category();
                $ncategory->add_filter("category_id");
                $ncategory->add_filter("category_name");
                $ncategory->select();
                $ncategory->add_condition("category_name_sef", ["LIKE" => $q]);
                $ncategory->add_condition("public", "1");
                if ($q == "") {
                    $ncategory->add_limit_start(10);
                }
                $items = $ncategory->get_alldata();
                if (!empty($items)) {
                    foreach ($items as $item) {
                        $result[] = ["id" => $item->category_id, "search_keyword" => $item->category_name, "type" => "category"];
                    }
                }

                if (empty($items)) {
                    $result[] = ["id" => 0, "search_keyword" => "Herhangi Bir Ürün veya Kategori Bulunamamıştır"];
                }

                $data["items"] = $result;
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
                $id = sanitize($_POST["id"]);
                $keyword = sanitize($_POST["keyword"]);
                $type = sanitize($_POST["type"]);
                $component_name = sanitize($_POST["component_name"]);

//                dnd($type);
                switch ($type) {
                    case "product":
                        $nproduct = new table_product();
                        $nproduct->select();
                        $nproduct->add_condition("product_id", $id);
                        $product_data = $nproduct->get_alldata();
                        break;
                    case "category":
                        $nproduct = new table_product();
                        $nproduct->select();
                        $nproduct->add_join("product_category", "product_id");
                        $nproduct->add_condition("category_id", $id, "=", "product_category");
                        $product_data = $nproduct->get_alldata();

//                        $nproduct->show_sql();
//                        $nproduct->show_where();
//                        $nproduct->show_where_value();
                        break;
                }

                //$nproduct->show_sql();
                //dnd($product_data);
                $data["result"] = $product_data;
                $data["start"] = 0;
                $data["end"] = 1;
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

}

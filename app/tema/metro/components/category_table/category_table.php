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
class category_table extends component {

    public function __construct() {
        
    }

    public function render($parameter) {

        $this->set_component_name("category_table");
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
                component::add_props(["category_id" => $category_id]);
                component::import_component("category_table", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["category_table"];
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
                // dnd($_POST);
                $start = sanitize($_POST["start"]);
                $end = sanitize($_POST["end"]);
                $direction = sanitize($_POST["direction"]);
                $parent_id = isset($_REQUEST["selected_id"]) && $_REQUEST["selected_id"] == "" ? 0 : $_REQUEST["selected_id"];

                $predata = [];

                $ncategory = new table_category();


                $ncategory->select();
                $ncategory->add_condition("parent_category_id", $parent_id);
                $ncategory->add_direction_by("sort_category");
                $ncategory->add_direction($direction);
                //$ncategory->add_limit_start($start);
                //$ncategory->add_limit_end($end);

//$condition, $direction, $by, 0, $primary_id
                $predata = $ncategory->get_alldata();
                $data["result"] = $predata;
                $data["start"] = $start;
                $data["total"] = $ncategory->get_category_total_count();
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
                $id = uniqid();
                $ntable = new pretable($tabledata, $id);
                $ntable_cl = [
                    "cloumb" => [
                        ["thead_title" => "Yayın",
                            "thead_attr" => ["style" => "width:5%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kategori Yayın Durumu"],
                            "tbody_varible" => "public",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "category_public",
                        ],
                        ["thead_title" => "Kategori Adı",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kategori Ad"],
                            "tbody_varible" => "category_name",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "category_name",
                        ],
                        ["thead_title" => "Alt Kategori Sayısı",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Alt Kategori Sayısı"],
                            "tbody_varible" => "category_sub_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "category_sub_count",
                        ],
                        ["thead_title" => "Gruplama Alanı",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kategorinin sahip olduğu gruplama alanı"],
                            "tbody_varible" => "category_group_fields",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "category_group_fields",
                        ],
                        ["thead_title" => "Galeri",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kategori Galerisi"],
                            "tbody_varible" => "category_gallery",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "category_gallery",
                        ],
                        ["thead_title" => "Ekli Ürün sayısı",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kategoriye ait ekli ürün sayısı"],
                            "tbody_varible" => "product_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "product_count",
                        ],
                        ["thead_title" => "Eylemler",
                            "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kategoriniz için eylemler"],
                            "tbody_varible" => "actions",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "actions",
                        ]
                    ]
                ];

                /*
                  ["thead_title" => "Ana Kategori",
                  "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Fiyatı"],
                  "tbody_varible" => "parent_category",
                  "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                  "function" => "parent_category",
                  ],
                 */
                $ntable->set_table_info($ntable_cl);
                $ntable->set_control_class("category_table_class");
                $ntable->set_check_cloumb(false);
                $ntable->set_table_header(false);
                $ntable->set_table_footer(false);
                $ntable->set_error_message("Seçilen kategorinin bir alt kategorisi bulunmuyor");
                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);
                $table = $ntable->add_table(false);
                $data["component_name"] = "category_table";
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

    public function remove_categoryAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $category_id = $_REQUEST["category_id"];

                if (!empty($category_id)) {

                    $ncategory = new table_category();
                    if ($main_data = $ncategory->get_data($category_id)) {
                        $remove_category = [];
                        $main_category[] = $main_data;
                        $sub_category[] = $ncategory->get_sub_category($category_id);
                        if (!empty($sub_category)) {
                            foreach ($sub_category as $ct) {
                                $remove_category = array_merge($main_category, $ct);
                            }
                        } else {
                            $remove_category = $main_category;
                        }

                        if (!empty($remove_category)) {
                            foreach ($remove_category as $prm) {
                                if (!empty($prm)) {
                                    if (data::removeAll("category", $prm->category_id)) {
                                        
                                    } else {
                                        $nvalidate->addWarning($prm->category_id . " id'li kategori silinmemiştir. Lütfen Tekrar deneyiniz.");
                                    }
                                }
                            }
                            $data["remove"] = true;
                            $data["parents"] = "tr";
                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "category_tree_list", "component_action" => "load"];
                            $nvalidate->addSuccess("Kategori ve Alt Kategoriler Sistemden Kaldırılmıştır.");
                        }
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addError("Kategoriye ulaşılamıyor.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
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

    public function pause_categoryAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $category_id = $_REQUEST["category_id"];

                if (!empty($category_id)) {

                    $ncategory = new table_category();
                    if ($main_data = $ncategory->get_data($category_id)) {
                        $pause_category = [];
                        $main_category[] = $main_data;
                        $sub_category[] = $ncategory->get_sub_category($category_id);
                        if (!empty($sub_category)) {
                            foreach ($sub_category as $ct) {
                                $pause_category = array_merge($main_category, $ct);
                            }
                        } else {
                            $pause_category = $main_category;
                        }

                        if (!empty($pause_category)) {
                            foreach ($pause_category as $prm) {
                                if (!empty($prm)) {
                                    $data = ["public" => 0];
                                    //$table_name, $data, $primary_id = "", $primary_key = ""
                                    if (data::update_data("category", $data, $prm->category_id)) {
                                        
                                    } else {
                                        $nvalidate->addWarning($prm->category_id . " id'li kategori durumu değişmedi. Lütfen Tekrar deneyiniz.");
                                    }
                                }
                            }

                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                            $nvalidate->addSuccess("Kategori ve Alt Kategoriler Sistemden Kaldırılmıştır.");
                        }
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addError("Kategoriye ulaşılamıyor.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
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

    public function public_categoryAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $category_id = $_REQUEST["category_id"];

                if (!empty($category_id)) {

                    $ncategory = new table_category();
                    if ($main_data = $ncategory->get_data($category_id)) {
                        $pause_category = [];
                        $main_category[] = $main_data;
                        $sub_category[] = $ncategory->get_sub_category($category_id);
                        if (!empty($sub_category)) {
                            foreach ($sub_category as $ct) {
                                $pause_category = array_merge($main_category, $ct);
                            }
                        } else {
                            $pause_category = $main_category;
                        }

                        if (!empty($pause_category)) {
                            foreach ($pause_category as $prm) {
                                if (!empty($prm)) {
                                    $data = ["public" => 1];
                                    //$table_name, $data, $primary_id = "", $primary_key = ""
                                    if (data::update_data("category", $data, $prm->category_id)) {
                                        
                                    } else {
                                        $nvalidate->addWarning($prm->category_id . " id'li kategori durumu değişmedi. Lütfen Tekrar deneyiniz.");
                                    }
                                }
                            }

                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                            $nvalidate->addSuccess("Kategori ve Alt Kategoriler Sistemden Kaldırılmıştır.");
                        }
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addError("Kategoriye ulaşılamıyor.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
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

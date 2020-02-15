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
class category_tree_list extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->add_global_plugin("jstree");
        $this->set_component_name("category_tree_list");
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

                $nview = new view();
                component::import_component("category_tree_list", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["category_tree_list"];
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
            if ($_REQUEST) {
                /*
                  {"id": "ajson1", "parent": "#", "text": "Simple root node"},
                  {"id": "ajson2", "parent": "#", "text": "Root node 2"},
                  {"id": "ajson3", "parent": "ajson2", "text": "Child 1"},
                  {"id": "ajson4", "parent": "ajson2", "text": "Child 2"},
                 */
                $ntable_category = new table_category();
                $ntable_category->select();
                $categories = $ntable_category->get_alldata();

                foreach ($categories as $category) {
                    if ($category->parent_category_id == 0) {
                        $parent = "#";
                    } else {
                        $parent = $category->parent_category_id;
                    }
                    if ($category->public == 1) {
                        $dt[] = ["id" => $category->category_id, "parent" => $parent, "text" => $category->category_name, "icon" => "fa fa-suitcase"];
                    } else {
                        $dt[] = ["id" => $category->category_id, "parent" => $parent, "text" => $category->category_name, "icon" => "fa fa-exclamation-circle", "color" => "red"];
                    }
                }

                //dnd($dt);

                /*
                  "new": {
                  "separator_before": false,
                  "separator_after": true,
                  "_disabled": false, //(this.check("create_node", data.reference, {}, "last")),
                  "label": "Yeni",
                  "action": function (data) {
                  let selected_category_id = document.getElementById("selected_category_id").value
                  send_data(selected_category_id, "newdata")
                  }
                  } */
                $contex_menu = [
                    [
                        "menu_name" => "new",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Yeni",
                        "component_name" => "category_form",
                        "component_action" => "new",
                        "modal" => "#category_modal",
                        "starter" => "component_run,form",
                    ],
                    [
                        "menu_name" => "edit",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Düzenle",
                        "component_name" => "category_form",
                        "component_action" => "load",
                        "modal" => "#category_modal",
                        "starter" => "component_run,form",
                    ]
                    ,
                    [
                        "menu_name" => "move",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Taşı",
                        "component_name" => "category_move_form",
                        "component_action" => "load",
                        "modal" => "#category_move",
                        "starter" => "component_run,form",
                    ]
                    ,
                    [
                        "menu_name" => "gallery",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Galeri Düzenle",
                        "component_name" => "category_gallery_form",
                        "component_action" => "load",
                        "modal" => "#category_gallery",
                        "starter" => "component_run,form",
                    ]
                    ,
                    [
                        "menu_name" => "edit_grup_fields",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Gruplama Alanlarını Düzenle",
                        "component_name" => "category_group_fields_form",
                        "component_action" => "load",
                        "modal" => "#category_group_fields",
                        "starter" => "component_run,form",
                    ]
                    ,
                    [
                        "menu_name" => "category_table",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Tabloda Göster",
                        "component_name" => "category_table",
                        "component_action" => "load",
                    ]
                    ,
                    [
                        "menu_name" => "remove",
                        "separator_before" => true,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Kaldır",
                        "component_name" => "category_tree_list",
                        "component_action" => "remove_category",
                    ]
                ];
//component_name, component_action, component_key, component_data
                $data["tree"] = json_encode($dt);
                $data["contex_menu"] = json_encode($contex_menu);
                $data["sonuc"] = true;
                $data["msg"] = "Kategori Listenize Erişildi.";
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

    public function remove_categoryAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $category_id = $_POST["category_id"];

                $ncategory = new table_category();
                if ($main_data = $ncategory->get_data($category_id)) {
                    $remove_category = [];
                    $main_category[] = $main_data;
                    $sub_category[] = $ncategory->get_sub_category($category_id);
                    foreach ($sub_category as $ct) {
                        $remove_category = array_merge($main_category, $ct);
                    }

                    //dnd($remove_category);
                    if (!empty($remove_category)) {
                        foreach ($remove_category as $prm) {
                            if (!empty($prm)) {
                                if (data::removeAll("category", $prm->category_id)) {
                                    
                                } else {
                                    $nvalidate->addWarning($prm->category_id . " id'li kategori silinmemiştir. Lütfen Tekrar deneyiniz.");
                                }
                            }
                        }

                        $data["recomponent"][] = ["component_name" => "category_tree_list", "component_action" => "load"];
                        $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Kategori ve Alt Kategoriler Sistemden Kaldırılmıştır.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Kategoriye ulaşılamıyor.");
                }
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Veri Gönderiminde Bir Sorun Bulunmakta.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
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

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
class product_category_tree extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->set_component_name("product_category_tree");
        $this->make_component($parameter["type"]);
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
                $ntable_category->add_condition("public", 1);
                $categories = $ntable_category->get_alldata();

                //dnd($categories);
                foreach ($categories as $category) {
                    if ($category->parent_category_id == 0) {
                        $parent = "#";
                    } else {
                        $parent = $category->parent_category_id;
                    }
                    $dt[] = ["id" => $category->category_id, "parent" => $parent, "text" => $category->category_name, "icon" => "fa fa-suitcase"];
                }

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
                        "action" => "newdata",
                    ],
                    [
                        "menu_name" => "edit",
                        "separator_before" => false,
                        "separator_after" => false,
                        "_disabled" => false,
                        "label" => "Düzenle",
                        "action" => "editdata",
                    ]
                ];

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

    public function removeAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_category_id = $_REQUEST["product_category_id"];

                if (data::remove("product_category", $product_category_id)) {
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Ürün kategorisi başarıyla kaldırılmıştır.");
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Ürün kategorisi  kaldırılmamıştır. Lütfen tekrar deneyin.");
                }
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
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

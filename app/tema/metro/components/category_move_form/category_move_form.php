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
class category_move_form extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->set_component_name("category_move_form");
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

                $selected_category_name = $_REQUEST["category_name"];
                $selected_category_id = $_REQUEST["category_id"];

                component::add_props(
                        [
                            "selected_category_name" => $selected_category_name,
                            "selected_category_id" => $selected_category_id,
                        ]
                );

                $nview = new view();
                component::import_component("category_move_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "category_move_list" => $content["category_move_list"],
                        ]
                );

                component::import_component("category_move_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();

                $data["content"] = $content["category_move_form"];
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

    public function move_categoryAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_category_data = new prepare_category_move_data();
                    $control_module = $nprepare_category_data->set_category_move_data($post);
                    $category_data = data::get_data($control_module);
                } else {
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
                if ($nvalidate->passed()) {
                    if (data::insert_data("category", $category_data["category"])) {
                        $nvalidate->addSuccess("Kategoriniz Taşındı");
                        $data["sonuc"] = true;
                    } else {
                        $nvalidate->addError("Kategoriniz Taşınma İşlemi Başarısızlıkla sonuçlanmıştır. Lütfen tekrar deneyin.");
                        $data["sonuc"] = false;
                    }
                } else {
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
                }
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Herhangi bir veri gelmemiştir";
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

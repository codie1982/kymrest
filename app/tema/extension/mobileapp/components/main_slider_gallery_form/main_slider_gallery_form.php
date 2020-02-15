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
class main_slider_gallery_form extends component {
    public function render($parameter) {
        $this->set_component_name("main_slider_gallery_form");
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
                $category_name = $_REQUEST["category_name"];
                $category_id = $_REQUEST["category_id"];


                $nview = new view();
                component::import_component("gallery_images", ["type" => "extension/mobileapp"], true);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(["gallery_images" => $content["gallery_images"]]);

                component::import_component("main_slider_gallery_form", ["type" => "extension/mobileapp"], true);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();

                $data["content"] = $content["main_slider_gallery_form"];
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

    public function update_gallery_formAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_category_gallery_data = new prepare_category_gallery_data();
                    $control_module = $nprepare_category_gallery_data->set_category_gallery_data($post);
                    $category_data = data::get_data($control_module);
                    dnd($category_data);
                    die();
                } else {
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
                if ($nvalidate->passed()) {

                    foreach ($category_data as $table_name => $dt) {
                        if (data::insert_data($table_name, $dt)) {
                            $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                        } else {
                            $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                        }
                    }
                    // $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                    $data["sonuc"] = true;
//                    if (data::insert_data("category_gallery", $category_data["category_gallery"])) {
//                        $nvalidate->addSuccess("Kategori Galeriniz Başarıyla oluşturuldu");
//                        
//                    } else {
//                        $nvalidate->addError("Kategori Galeriniz Kayıt Edilmemiştir. Lütfen tekrar deneyin.");
//                        $data["sonuc"] = false;
//                    }
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

    public function remove_category_galleryAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $category_gallery_id = $_REQUEST["category_gallery_id"];
                if (!empty($category_gallery_id)) {

                    if (data::remove("category_gallery", $category_gallery_id)) {
                        $data["sonuc"] = true;
                        $data["remove"] = true;
                        $data["parents"] = "tr";
                        $nvalidate->addSuccess("Kategori resmi sistemden kaldırılmıştır.");
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addSuccess("Kategori resmi sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
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

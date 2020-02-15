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
class category_group_fields_form extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->set_component_name("category_group_fields_form");
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
                $category_name = $_REQUEST["category_name"];
                $category_id = $_REQUEST["category_id"];

                component::add_props(
                        [
                            "category_name" => $category_name,
                            "category_id" => $category_id,
                        ]
                );


                $ncaregory_group_fields = new table_category_group_fields();
                $category_group_fields_data = $ncaregory_group_fields->get_data_main_key($category_id);

                component::add_props(
                        [
                            "category_group_fields_data" => $category_group_fields_data,
                        ]
                );

                component::import_component("category_group_fields_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                $data["content"] = $content["category_group_fields_form"];
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

    public function update_category_group_fieldsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_category_data = new prepare_category_group_fields_data();
                    $control_module = $nprepare_category_data->set_category_group_fields_data($post);
                    $category_data = data::get_data($control_module);

                    //TODO ::  Alanların ekli olup olmadığının kontrolünü yapılması gerekli
//                    dnd($category_data);
//                    die();
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
                    $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                    $data["sonuc"] = true;
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

    public function removeAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $group_fields_id = $_REQUEST["group_fields_id"];
                if (!empty($group_fields_id)) {
                    if (data::remove("category_group_fields", $group_fields_id)) {
                        $data["sonuc"] = true;
                        $data["remove"] = true;
                        $nvalidate->addSuccess("Kategori gruplama alanı kaldırılmıştır.");
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addSuccess("Kategori gruplama alanı sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
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

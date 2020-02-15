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
class category_form extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->set_component_name("category_form");
        $this->make_component($parameter["type"]);
    }

    public function add_new_categoryAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_category_data = new prepare_category_data();
                    $control_module = $nprepare_category_data->set_category_data($post);
                    $category_data = data::get_data($control_module);
                    if ($category_data["category"]["category_name"] != "") {
                        $ncategory_model = new table_category();
                        if (!$ncategory_model->checkCategory($category_data["category"]["category_name"])) {
                            
                        } else {
                            $nvalidate->addError('<strong>' . $category_data["category"]["category_name"] . '</strong> ' . "-" . " İsimli Kategori Daha Önce Girilmiş. Kategori ismini değiştirerek yeniden eklemeyi deneyin");
                        }
                    } else {
                        $nvalidate->addError("Kategori İsmini Boş Bırakmayınız");
                    }

                   

                    if ($nvalidate->passed()) {
                        if ($new_category_id = data::insert_data("category", $category_data["category"])) {
                            if (!empty($category_data)) {
                                $secrets = data::get_secret_number($control_module);
                                if (!empty($secrets))
                                    foreach ($secrets as $secret) {
                                        data::addextra("category_id", $new_category_id, $control_module, "sub", $secret);
                                    }
                                $category_data = data::get_data($control_module);
                                unset($category_data["category"]);

                                foreach ($category_data as $table_name => $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                    }
                                }
                            }
                            $nvalidate->addSuccess("Kategori Eklendi");
                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "category_tree_list", "component_action" => "load"];
                            $data["recomponent"][] = ["component_name" => "category_main_list", "component_action" => "load"];
                            $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                        } else {
                            $nvalidate->addError("Kayıt Yapılamadı. Lütfen tekrar deneyiniz.");
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

    public function update_categoryAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_category_data = new prepare_category_data();
                    $control_module = $nprepare_category_data->set_category_data($post);
                    $category_data = data::get_data($control_module);

//                    dnd($category_data);
//                    die();
                    if ($category_data["category"]["category_name"] != "") {
                        $ncategory_model = new table_category();
                        if (!$ncategory_model->get_data($category_data["category"]["category_id"])) {
                            $nvalidate->addError('<strong>' . $category_data["category"]["category_name"] . '</strong> ' . "-" . " İsimli Kategori Bulunamıyor. Kategori Kaldırılmış. Kategoriyi yeniden eklemeyi deneyin.");
                        }
                    } else {
                        $nvalidate->addError("Kategori İsmini Boş Bırakmayınız");
                    }
                } else {
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }

                if ($nvalidate->passed()) {
                    if (data::insert_data("category", $category_data["category"])) {
                        if (!empty($category_data)) {
                            $secrets = data::get_secret_number($control_module);
                            if (!empty($secrets))
                                foreach ($secrets as $secret) {
                                    data::addextra("category_id", $category_data["category"]["category_id"], $control_module, "sub", $secret);
                                }
                            $category_data = data::get_data($control_module);
                            unset($category_data["category"]);
                            foreach ($category_data as $table_name => $dt) {
                                if (data::insert_data($table_name, $dt)) {
                                    $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                } else {
                                    $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                }
                            }
                        }
                        $nvalidate->addSuccess("Kategori Gücellendi");
                        $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];
                        $data["sonuc"] = true;
                    } else {
                        $nvalidate->addError("Ürün İsmini Boş Bırakmayınız");
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


                if ($_REQUEST["data"][0] != "empty") {
                    $selected_category_name = isset($_REQUEST["category_name"]) ? $_REQUEST["category_name"] : null;
                    $selected_category_id = isset($_REQUEST["category_id"]) ? $_REQUEST["category_id"] : null;


                    $category_info = data::allInfo("category", $selected_category_id);

                    if (!empty($category_info["category"])) {
                        component::add_props(
                                [
                                    "action" => "update_category",
                                    "button_text" => "Güncelle",
                                ]
                        );
                    }

                    component::add_props(
                            [
                                "category_info" => $category_info,
                            ]
                    );


                    component::add_props(
                            [
                                "selected_category_name" => $selected_category_name,
                                "selected_category_id" => $selected_category_id,
                            ]
                    );
                }


                $ngroup_fields_list = new table_group_fields();
                $ngroup_fields_list->select();
                $fields_list = $ngroup_fields_list->get_alldata();

                component::add_props(
                        [
                            "fields_list" => $fields_list,
                        ]
                );

                $nview = new view();
                //            //group_fields_list_value

                component::import_component("group_fields_list_value", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_fields_list_value" => $content["group_fields_list_value"],
                        ]
                );

                component::import_component("group_fields_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_fields_list" => $content["group_fields_list"],
                        ]
                );


                component::import_component("category_main_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "category_main_list" => $content["category_main_list"],
                        ]
                );

                component::import_component("category_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["category_form"];
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

    public function newAction() {
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


                if ($_REQUEST["data"][0] != "empty") {
                    $selected_category_name = isset($_REQUEST["category_name"]) ? $_REQUEST["category_name"] : null;
                    $selected_category_id = isset($_REQUEST["category_id"]) ? $_REQUEST["category_id"] : null;






                    component::add_props(
                            [
                                "selected_category_name" => $selected_category_name,
                                "selected_category_id" => $selected_category_id,
                            ]
                    );
                }


                $nview = new view();
                //            //group_fields_list_value

                component::import_component("group_fields_list_value", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_fields_list_value" => $content["group_fields_list_value"],
                        ]
                );

                component::import_component("group_fields_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_fields_list" => $content["group_fields_list"],
                        ]
                );


                component::import_component("category_main_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "category_main_list" => $content["category_main_list"],
                        ]
                );

                component::import_component("category_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["category_form"];
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

    public function get_categoryAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $data = $_REQUEST["data"];
                $category_id = $_REQUEST["category_id"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

                $ncategory = new table_category();
                $category_info = data::allInfo("category", $category_id);


                component::add_props(
                        [
                            "category_info" => $category_info,
                        ]
                );
                if (!empty($category_info["category"])) {
                    component::add_props(
                            [
                                "action" => "update_category",
                                "button_text" => "Güncelle",
                            ]
                    );
                }
                $nview = new view();

                component::import_component("group_fields_list_value", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_fields_list_value" => $content["group_fields_list_value"],
                        ]
                );

                $ngf = new table_group_fields();
                $fields_list = $ngf->get_alldata();
                // dnd($fields_list);
                component::add_props(
                        [
                            "fields_list" => $fields_list,
                        ]
                );

                component::import_component("group_fields_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_fields_list" => $content["group_fields_list"],
                        ]
                );

                component::import_component("category_main_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "category_main_list" => $content["category_main_list"],
                        ]
                );

                component::import_component("category_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();



                $data["content"] = $content["category_form"];
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

}

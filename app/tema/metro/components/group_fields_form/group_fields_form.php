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
class group_fields_form extends component {

    public function render($parameter) {
        $this->set_component_name("group_fields_form");
        $this->make_component($parameter["type"]);
    }

    public function add_new_group_filedsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_group_fields_data = new prepare_group_fields_data();
                    $control_module = $nprepare_group_fields_data->set_group_fields_data($post);
                    $group_fields_data = data::get_data($control_module);


                    if ($group_fields_data["group_fields"]["fields_name"] == "") {
                        $nvalidate->addError("Gruplama Alanı İsmini Boş Bırakmayınız");
                    }

                    if ($nvalidate->passed()) {
                        if ($new_group_fields_id = data::insert_data("group_fields", $group_fields_data["group_fields"])) {
                            if (!empty($group_fields_data)) {
                                $secrets = data::get_secret_number($control_module);
                                if (!empty($secrets))
                                    foreach ($secrets as $secret) {
                                        data::addextra("group_fields_id", $new_group_fields_id, $control_module, "sub", $secret, "group_fields");
                                    }
                                $group_fields_data = data::get_data($control_module);
                                unset($group_fields_data["group_fields"]);
                                foreach ($group_fields_data as $table_name => $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                    }
                                }
                            }
                            $nvalidate->addSuccess("Gruplama Alanı Eklendi");
                            $data["sonuc"] = true;
                        } else {
                            $nvalidate->addError("Gruplama Alanı Eklenmedi");
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

    public function update_group_filedsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_group_fields_data = new prepare_group_fields_data();
                    $control_module = $nprepare_group_fields_data->set_group_fields_data($post);
                    $group_fields_data = data::get_data($control_module);
                    $group_fields_id = $group_fields_data["group_fields"]["group_fields_id"];
                    if ($nvalidate->passed()) {
                        if (data::insert_data("group_fields", $group_fields_data["group_fields"])) {
                            if (!empty($group_fields_data)) {
                                $secrets = data::get_secret_number($control_module);
                                if (!empty($secrets))
                                    foreach ($secrets as $secret) {
                                        data::addextra("group_fields_id", $group_fields_id, $control_module, "sub", $secret, "group_fields");
                                    }
                                $group_fields_data = data::get_data($control_module);
                                unset($group_fields_data["group_fields"]);
                                foreach ($group_fields_data as $table_name => $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                    }
                                }
                            }
                            $nvalidate->addSuccess("Gruplama Alanı Düzenlendi");
                            $data["sonuc"] = true;
                        } else {
                            $nvalidate->addError("Gruplama Alanı Düzenlenmedi. Lütfen tekrar deneyin");
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

                component::import_component("group_values", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_values" => $content["group_values"],
                        ]
                );
                component::import_component("group_fields_form", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["group_fields_form"];
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

    public function reloadAction() {
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

                component::import_component("group_values", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                component::add_props(
                        [
                            "group_values" => $content["group_values"],
                        ]
                );

                component::import_component("group_fields_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                $data["content"] = $content["group_fields_form"];
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

    public function get_group_dataAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $data = $_REQUEST["data"];
                $selected_group_id = $_REQUEST["selected_group_id"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }
                $data["tempstarter"][] = "component_run";
                $data["tempstarter"][] = "form";
                //dnd($category_id);

                $ngroup_fields = new table_group_fields();
                $ngroup_fields->select();
                $ngroup_fields->add_condition("group_fields_id", $selected_group_id);
                $group_fields_info = $ngroup_fields->get_alldata(true);
                //  $group_fields_info = $ngroup_fields->get_data($selected_group_id);



                component::add_props(
                        [
                            "action" => "update_group_fileds",
                            "button" => "Düzenle",
                            "remove_fields_button" => true,
                        ]
                );


                component::add_props(
                        [
                            "group_fields_info" => $group_fields_info,
                        ]
                );

                $ngroup_fields_value = new table_group_fields_value();
                $ngroup_fields_value->select();
                $ngroup_fields_value->add_condition("group_fields_id", $group_fields_info->group_fields_id);
                $group_fields_value_info = $ngroup_fields_value->get_alldata();
                //   $group_fields_value_info = $ngroup_fields_value->get_data_main_key($group_fields_info->group_fields_id);

                component::add_props(
                        [
                            "group_fields_value_info" => $group_fields_value_info,
                        ]
                );
                $nview = new view();

                component::import_component("group_values", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                component::add_props(
                        [
                            "group_values" => $content["group_values"],
                        ]
                );
                component::import_component("group_fields_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["group_fields_form"];
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

    public function remove_allAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $group_fields_id = $_REQUEST["group_fields_id"];
                if (!empty($group_fields_id)) {

                    if (data::removeAll("group_fields", $group_fields_id)) {
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Gruplama Alanları Başarıyla Kaldırılmıştır.");
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addSuccess("Gruplama Alanları Kaldırılamamıştır. Lütfen tekrar deneyin.");
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

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
class sidebar_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->set_component_name("sidebar_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_sidebarAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {


                    $ndata = new prepare_sidebar_data();
                    $control_module = $ndata->set_sidebar_data($post);
                    $module_data = data::get_data($control_module);
                    $nvalidate->addSuccess("Form Datası Başarı ile oluşturuldu");
                    if ($nvalidate->passed()) {
                        data::turncate("sidebar_menu");

                        if (!empty($module_data))
                            foreach ($module_data as $table_name => $secret_key) {
                                foreach ($secret_key as $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                    }
                                }
                            }
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Ana Tablo bilgileri kayıt edildi");

                        if (!empty($nvalidate->get_warning()))
                            foreach ($nvalidate->get_warning() as $wr) {
                                $data["warning_message"][] = $wr;
                            }
                        if (!empty($nvalidate->get_success()))
                            foreach ($nvalidate->get_success() as $sc) {
                                $data["success_message"][] = $sc;
                            }
                    } else {
                        $data["sonuc"] = false;
                    }
                } else {
                    data::turncate("sidebar_menu");
                    $data["sonuc"] = false;
                    $nvalidate->addError("SideBar Tamamen Kaldırılmıştır.");
                }
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
        }
        if (!empty($nvalidate->get_errors()))
            foreach ($nvalidate->get_errors() as $err) {
                $data["error_message"][] = $err;
            }
        if (!empty($nvalidate->get_warning()))
            foreach ($nvalidate->get_warning() as $wr) {
                $data["warning_message"][] = $wr;
            }
        if (!empty($nvalidate->get_success()))
            foreach ($nvalidate->get_success() as $sc) {
                $data["success_message"][] = $sc;
            }

        echo json_encode($data);
    }

}

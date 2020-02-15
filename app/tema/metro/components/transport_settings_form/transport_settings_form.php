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
class transport_settings_form extends component {

    public function render($parameter) {
        $this->set_component_name("transport_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_transport_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_transport_data = new prepare_transport_data();
                    $control_module = $nprepare_transport_data->set_new_transport_settings_data($post);
                    $settings_transport_data = data::get_data($control_module);
                    $nvalidate->addSuccess("Girişler Başarılı");
//                    dnd($settings_transport_data);
//                    die();
                    if ($nvalidate->passed()) {
                        if (data::insert_data("settings_transport", $settings_transport_data["settings_transport"])) {
                            unset($settings_transport_data["settings_transport"]);
                            if (!empty($settings_transport_data))
                                foreach ($settings_transport_data as $table_name => $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                    }
                                }

                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Ana Tablo bilgileri kayıt edildi");
                        } else {

                            $data["sonuc"] = false;
                            $nvalidate->addError("Ana Tablo bilgileri Kayıt Edilmedi");
                        }



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


                    //burada validate kullanabiliriz bu kısımda bir çok farklı hata yakalabilir
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

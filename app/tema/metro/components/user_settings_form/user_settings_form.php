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
class user_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->set_component_name("user_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_user_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_customer_settings_data = new prepare_customer_settings_data();
                    $control_module = $nprepare_customer_settings_data->set_new_customer_settings_data($post);
                    $customer_settings_data = data::get_data($control_module);
                    if ($nvalidate->passed()) {
                        if (data::insert_data("settings_customer", $customer_settings_data["settings_customer"])) {
                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Kullanıcı Ayarları Kayıt Edildi");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addError("Kullanıcı Ayarları Kayıt Edilmedi");
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

        echo json_encode($data);
    }

}

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
class mobile_pack extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");

        $this->set_component_name("mobile_pack");
        $this->make_component($parameter["type"]);
    }

    public function update_application_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare = new prepare_application_settings_data();
                    $control_module = $nprepare->set_new_application_settings_data($post);
                    $appdata = data::get_data($control_module);


                    if ($appdata["settings_customer_application"]["title"] == NODATA) {

                        $nvalidate->addError("Aplikasyon Başlığını Boş Bırakmayınız");
                    }
                } else {
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
                if ($nvalidate->passed()) {
                    if (data::insert_data("settings_customer_application", $appdata["settings_customer_application"])) {
                        if (!empty($appdata)) {

                            unset($appdata["settings_customer_application"]);
                            foreach ($appdata as $table_name => $dt) {
                                if (data::insert_data($table_name, $dt)) {
                                    $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                } else {
                                    $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                }
                            }
                        }
                        $nvalidate->addSuccess("Mobil Aplikasyon Değerleri Güncellendi");

                        $data["sonuc"] = true;
                    } else {
                        $nvalidate->addError("Tablo Verileri Girilemedi. Model Dosyasını Kontrol edebilirsiniz.");
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

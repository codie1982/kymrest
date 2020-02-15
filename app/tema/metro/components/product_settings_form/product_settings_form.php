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
class product_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->add_global_plugin("bootstrap-summernote");
        $this->set_component_name("product_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_product_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_product_data = new prepare_product_data();
                    $control_module = $nprepare_product_data->set_new_product_data($post);
                    $product_settings_data = data::get_data($control_module);

                    $nvalidate->addSuccess("Data Oluşumu Başarılı");

                    if ($nvalidate->passed()) {
                        if (data::insert_data("settings_product", $product_settings_data["settings_product"])) {
                            unset($product_settings_data["settings_product"]);
                            if (!empty($product_settings_data))
                                foreach ($product_settings_data as $table_name => $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                    }
                                }
                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Data Kayıt Edildi");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addError("Data Kayıt Edilmedi");
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

        echo json_encode($data);
    }

}

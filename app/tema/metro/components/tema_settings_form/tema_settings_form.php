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
class tema_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->add_global_plugin("bootstrap-summernote");
        $this->set_component_name("tema_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_tema_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_general_settings_data = new prepare_general_settings_data();
                    $control_module = $nprepare_general_settings_data->set_new_general_settings_data($post);
                    $general_settings_data = data::get_data($control_module, "settings_general");
                    if ($general_settings_data["site_title"] == "" || $general_settings_data["site_title"] == NODATA) {
                        $nvalidate->addError("Site İsmini Boş Bırakmayınız");
                    } else {
                        if ($general_settings_data["site_description"] == "" || $general_settings_data["site_description"] == NODATA) {
                            $nvalidate->addError("Site Açıklamalarını Boş Bırakmayınız");
                        } else {
                            if ($general_settings_data["site_keywords"] == "" || $general_settings_data["site_keywords"] == NODATA) {
                                $nvalidate->addError("Anahtar Kelime Alanlarınızı Boş bırakmayınız");
                            } else {
                                if ($general_settings_data["mail_adres"] == "" || $general_settings_data["mail_adres"] == NODATA) {
                                    $nvalidate->addError("Mail Adresinizi Boş Bırakmayınız");
                                } else {
                                    $nvalidate->addSuccess("Girişler Başarılı");
                                }
                            }
                        }
                    }
                    if ($nvalidate->passed()) {
                        $ngeneral_settings = new table_settings_general();
                        $ngeneral_settings->new_general_settings($general_settings_data);
                        $general_settings_data_temp = data::get_data($control_module);

                        unset($general_settings_data_temp["settings_general"]);

                        if (!empty($general_settings_data_temp))
                            foreach ($general_settings_data_temp as $table_name => $dt) {

                                $table_name = "table_" . $table_name;
                                if (class_exists($table_name)) {
                                    $ntbl = new $table_name;
                                    $key_name = array_keys($dt);
                                    if (is_array($dt[$key_name[0]])) {
                                        foreach ($dt as $dtt) {
                                            if (!empty($dtt)) {
                                                if ($ntbl->insert_data($dtt)) {
                                                    $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                                } else {
                                                    $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                                }
                                            }
                                        }
                                    } else {
                                        if (!empty($dt))
                                            if ($ntbl->insert_data($dt)) {
                                                $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                            } else {
                                                $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                            }
                                    }
                                } else {
                                    
                                }
                            }
                        $data["sonuc"] = true;
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

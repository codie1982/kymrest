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
class grnt_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->add_global_plugin("bootstrap-summernote");
        $this->set_component_name("grnt_settings_form");
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
                    $settings_grnt_data = data::get_data($control_module);
//                    dnd($settings_grnt_data);
//                    die();
                    if ($settings_grnt_data["settings_grnt"]["site_title"] == "" || $settings_grnt_data["settings_grnt"]["site_title"] == NODATA) {
                        $nvalidate->addError("Site İsmini Boş Bırakmayınız");
                    } else {
                        if ($settings_grnt_data["settings_grnt"]["site_description"] == "" || $settings_grnt_data["settings_grnt"]["site_description"] == NODATA) {
                            $nvalidate->addError("Site Açıklamalarını Boş Bırakmayınız");
                        } else {
                            if ($settings_grnt_data["settings_grnt"]["site_keywords"] == "" || $settings_grnt_data["settings_grnt"]["site_keywords"] == NODATA) {
                                $nvalidate->addError("Anahtar Kelime Alanlarınızı Boş bırakmayınız");
                            } else {
                                if ($settings_grnt_data["settings_grnt"]["site_mail"] == "" || $settings_grnt_data["settings_grnt"]["site_mail"] == NODATA) {
                                    $nvalidate->addError("Mail Adresinizi Boş Bırakmayınız");
                                } else {
                                    $nvalidate->addSuccess("Girişler Başarılı");
                                }
                            }
                        }
                    }
                    if ($nvalidate->passed()) {
                        $ngeneral_settings = new table_settings_grnt();
                        if (data::insert_data("settings_grnt", $settings_grnt_data["settings_grnt"])) {
                            $nvalidate->addSuccess("Tema Ayarları Kayıt Edildi");
                            $data["sonuc"] = true;
                        } else {
                            $nvalidate->addError("Tema Ayarları Kayıt Edilmedi. Lütfen Tekrar deneyin");
                            $data["sonuc"] = false;
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

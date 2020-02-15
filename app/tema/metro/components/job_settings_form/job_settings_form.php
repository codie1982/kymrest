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
class job_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
         $this->add_global_plugin("bootstrap-tagsinput");
        $this->set_component_name("job_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_job_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $ndata = new prepare_job_settings_data();
                    $control_module = $ndata->set_new_job_settings_data($post);
                    $fdata = data::get_data($control_module);

                    //dnd($fdata,true);
                    if ($nvalidate->passed()) {
                        if (!empty($fdata))
                            if ((data::insert_data("settings_jobs", $fdata["settings_jobs"]))) {
                                $nvalidate->addSuccess("Bilgileri kayıt edildi");
                            } else {
                                $nvalidate->addWarning("Bilgileri kayıt edilemedi");
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

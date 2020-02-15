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
class general_settings_form extends component {

    public function render($parameter) {
        $this->set_component_name("general_settings_form");
        $this->make_component($parameter["type"]);
    }

    public function update_general_settingsAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_general_settings_data = new prepare_general_settings_data();
                    $control_module = $nprepare_general_settings_data->set_new_general_settings_data($post);
                    $general_settings_data = data::get_data($control_module);

                    if ($nvalidate->passed()) {
                        if (data::insert_data("settings_general", $general_settings_data["settings_general"])) {
                            unset($general_settings_data["settings_general"]);


                            if (!empty($general_settings_data)) {
                                foreach ($general_settings_data as $table_name => $dt) {
                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                    }
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

        echo json_encode($data);
    }

    public function search_companyAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $q = input::santize($_REQUEST["q"]);
                $items = [];
                $ncustomer_company = new table_customer_company();
                $ncustomer_company->add_filter("customer_id", "id");
                $ncustomer_company->add_filter("customer_company_title", "search_keyword");
                $ncustomer_company->select();
                $ncustomer_company->add_condition("type", "company", "=", "customer");
                $ncustomer_company->add_condition("customer_company_title", [
                    "LIKE" => [$q]
                ]);

                $ncustomer_company->add_join("customer", "customer_id");
                $res = $ncustomer_company->get_alldata();
                if (!empty($res)) {
                    foreach ($res as $r) {
                        $items[] = get_object_vars($r);
                    }
                    $data["items"] = $items;
                }
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

}

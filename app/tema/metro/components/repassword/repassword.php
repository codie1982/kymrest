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
class repassword extends component {

    public function render($parameter) {
        $this->set_component_name("repassword");
        $this->make_component($parameter["type"]);
    }

    public function generate_repasswordAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (!session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_admin_login = new prepare_admin_login();
                    $control_module = $nprepare_admin_login->user_login_data($post);

                    $plasebo_data = data::get_plasebo_data($control_module);
                    if ($plasebo_data["customer_email"] == "" && $plasebo_data["customer_password"] == "") {
                        $nvalidate->addError("Mail Adresinizi ve Şifrenizi Boş Bırakmayınız");
                    }

                    if ($plasebo_data["customer_password"] != $plasebo_data["customer_repassword"]) {
                        $nvalidate->addError("Şifreleriniz Eşleşmiyor");
                    }

                    if ($nvalidate->passed()) {
                        $customer_siteaccount = new table_customer_siteaccount();
                        $customer_siteaccount->select();
                        $customer_siteaccount->add_condition("customer_email", $plasebo_data["customer_email"]);
                        $customer_siteaccount->add_condition("re_password", 1);
                        $customer_siteaccount->add_condition("re_password_code", $plasebo_data["verify_code"]);

                        if ($customer_info = $customer_siteaccount->get_alldata(true)) {
                            $customer_id = $customer_info->customer_id;
                            $customer_password = password_hash($plasebo_data["customer_password"], PASSWORD_DEFAULT);
                            $customer_data = [
                                "password" => $customer_password,
                                "re_password" => 0,
                                "re_password" => 0,
                            ];

                            if (data::update_data("customer_siteaccount", $customer_data)) {
                                $ncustomer = new table_customer();
                                $ncustomer->customerLogin($customer_id, true);
                                $data["sonuc"] = true;
                                $nvalidate->addSuccess("Şifreniz Değişikliğiniz onaylandı. Girişe Yönlendiriliyorsunuz");
                                $data["redirect"] = "/dashboard";
                            } else {
                                $data["sonuc"] = false;
                                $nvalidate->addError("Şifre Değişikliğiniz onaylanmadı. Lütfen tekrar deneyin");
                            }
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addError("Bu mail adresinde bir kullanıcı bulunmuyor");
                        }
                    } else {
                        $data["sonuc"] = false;
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
            $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
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

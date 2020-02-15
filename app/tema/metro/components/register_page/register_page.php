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
class register_page extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->set_component_name("register_page");
        $this->make_component($parameter["type"]);
    }

    public function customer_registerAction($param = "") {
        $data = [];
        $nvalidate = new validate();

        if (!session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_admin_login = new prepare_admin_login();
                    $control_module = $nprepare_admin_login->user_register_data($post);
                    $register_data = data::get_data($control_module);

                    if (cookie::exists(VISITORID)) {
                        $customer_id = cookie::get(VISITORID);
                    } else {
                        $nvisitor_module = new visitor_module();
                        $customer_id = $nvisitor_module->new_visitor(get_ipno());
                    }


                    //$key, $value, $control_module, $table, $secret = null
                    $register_plasebo_data = data::get_plasebo_data($control_module);

                    //Mail Adres Kontrolü
                    if ($register_data["customer_siteaccount"]["customer_email"] == NODATA && $register_data["customer_siteaccount"]["password"] == NODATA) {
                        $nvalidate->addError("Mail Adresinizi ve Şifrenizi Boş Bırakmayınız");
                    }

                    //geçerli bir mail adresi olup olmadığınıda kontrol edilmesi gerekiyor.
                    $ncustomer_siteaccount = new table_customer_siteaccount();
                    $ncustomer_siteaccount->add_filter("customer_id");
                    $ncustomer_siteaccount->select();
                    $ncustomer_siteaccount->add_condition("customer_email", $register_data["customer_siteaccount"]["customer_email"]);

                    if ($ncustomer_siteaccount->get_alldata(true)) {
                        $nvalidate->addError("Mail Adresi daha Önceden kayıt edilmiş. Başka bir mail adresi denemeniz gerekmektedir.");
                    }

                    $ncustomer_siteaccount = new table_customer_siteaccount();
                    $ncustomer_siteaccount->add_filter("customer_id");
                    $ncustomer_siteaccount->select();
                    $ncustomer_siteaccount->add_condition("customer_nickname", $register_data["customer_siteaccount"]["customer_nickname"]);

                    if ($ncustomer_siteaccount->get_alldata(true)) {
                        $nvalidate->addError("Kullanıcı adı daha önceden kayıt edilmiş. Başka bir kullanıcı adı denemeniz gerekmektedir.");
                    }

                    if ($nvalidate->passed()) {
                        foreach ($register_data as $tablename => $dt) {
                            $dt["customer_id"] = $customer_id;
                            if (data::insert_data($tablename, $dt)) {
                                $nvalidate->addSuccess($tablename . " Kayıt Oluşturuldu");
                                session::set(CURRENT_USER_SESSION_NAME, $customer_id);
                                cookie::delete(VISITORID);
                                if (isset($register_plasebo_data["rememberme"])) {
                                    cookie::set(REMEMBER_ME_COOKIE_NAME, $customer_id, REMEMBER_ME_COOKIE_EXPIRY);
                                }
                            } else {
                                $nvalidate->addWarning($tablename . " Kayıt Oluşturulamadı");
                            }
                        }
                        //ilk giriş tablosundaki kullanıcı tipini "automatic" personel olarak değiştirmemiz gerekmektedir.Visitor ID'ye göre yapması gerekir
                        data::update_data("customer", ["type" => "personel", "users_id" => $customer_id], "customer_id", $customer_id);
                        //mail tablosunada kayıt etmemiz gerekmektedir
                        data::add_post_data("customer_mail_fields", "customer_id", $customer_id, 1);
                        data::add_post_data("customer_mail_fields", "customer_mail", $register_data["customer_siteaccount"]["customer_email"], 1);
                        data::add_post_data("customer_mail_fields", "customer_mail_date", getNow(), 1);
                        data::add_post_data("customer_mail_fields", "confirm_code", md5(time() . uniqid()), 1);
                        data::add_post_data("customer_mail_fields", "users_id", $customer_id, 1);
                        $customer_mail_data = data::get_postdata();

                        $nprp = new prepare_admin_register();
                        $control_module = $nprp->user_mail_data($customer_mail_data);
                        $mail_data = data::get_data($control_module);
                        if ($customer_mail_id = data::insert_data("customer_mail", $mail_data["customer_mail"])) {
                            $nvalidate->addSuccess("Mail Tablosuna Mail Kayıt oldu");
                            $nsend_mail = new sendmail();
                            $nsend_mail->set_send_email($register_data["customer_siteaccount"]["customer_email"]);
                            $nsend_mail->set_send_username($register_data["customer_personel"]["name"] . " " . $register_data["customer_personel"]["lastname"]);
                            $nsend_mail->set_mail_controller("mail_confirm");
                            $nsend_mail->set_mail_parameters($customer_mail_id[0]);
                            $nsend_mail->set_mail_subject("Mail Onayı");
                            if ($nsend_mail->send_mail()) {
                                $nvalidate->addSuccess("Onaylama maili gönderildi");
                            } else {
                                $nvalidate->addWarning("Onaylama Maili gönderilemedi");
                            }
                        } else {
                            $nvalidate->addWarning("mail adresi mail tablosuna kayıt edilmedi");
                        }

                        if (isset($register_plasebo_data["redirect"])) {
                            $data["redirect"] = $register_plasebo_data["redirect"];
                        } else {
                            $data["redirect"] = "/home";
                        }
                        $nvalidate->addSuccess("Kayıt İşleminiz Başarıyla Gerçekleşti");
                        $data["sonuc"] = true;
                    } else {
                        $data["sonuc"] = false;
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Gelen herhangi bir veri yok.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Oturum açıkken bu alana giriş yapamazsınız.");
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

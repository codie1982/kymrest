<?php

/**
 * Description of sidebar
 *
 * @author engin
 */
class login_page extends component {

    public function render($parameter) {
        $this->set_component_name("login_page");
        $this->make_component($parameter["type"]);
    }

    public function user_loginAction($param = "") {
        $data = [];
        $nvalidate = new validate();

        if (!session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_admin_login = new prepare_admin_login();
                    $control_module = $nprepare_admin_login->user_login_data($post);

                    //$key, $value, $control_module, $table, $secret = null
                    $customer_data = data::get_data($control_module);
                    $plasebo_data = data::get_plasebo_data($control_module);

                    if ($customer_data["customer_siteaccount"]["customer_email"] == "" && $customer_data["customer_siteaccount"]["password"] == "") {
                        $nvalidate->addError("Mail Adresinizi ve Şifrenizi Boş Bırakmayınız");
                    }

                    if ($nvalidate->passed()) {
                        $ncustomer = new table_customer_siteaccount();
                        $ncustomer->select();
                        $ncustomer->add_condition("customer_email", $customer_data["customer_siteaccount"]["customer_email"]);
                        if ($customer_info = $ncustomer->get_alldata(true)) {
                            $customer_id = $customer_info->customer_id;

                            if ($customer_info->re_password == 1) {
                                $data["sonuc"] = true;
                                $data["redirect"] = DS . "setpassword" . DS . $customer_info->re_password_code;
                                $nvalidate->addSuccess("Sifre Değişikliği yapmanız gerekmektedir. Yönlendiriliyorsunuz");
                            } else {
                                if (password_verify($plasebo_data["loginpass"], $customer_info->password)) {
                                    isset($plasebo_data["rememberme"]) ? $plasebo_data["rememberme"] == true ? cookie::set(REMEMBER_ME_COOKIE_NAME, $customer_id, REMEMBER_ME_COOKIE_EXPIRY) : null : null;

                                    $nvalidate->addSuccess(" Giriş Yapıldı. Yönlendiriliyorsunuz");
                                    cookie::exists(VISITORID) == true ? cookie::delete(VISITORID) : null;

                                    //giriş bilgilerini Kayıt edebiliriz;
                                    $visitor_ip = get_ipno();
                                    $get_data = callAPI('GET', "http://extreme-ip-lookup.com/json/$visitor_ip", false);
                                    $response = json_decode($get_data);

                                    //mail tablosunada kayıt etmemiz gerekmektedir
                                    data::add_post_data("login_info_fields", "customer_id", $customer_id);
                                    data::add_post_data("login_info_fields", "continent", $response->continent);
                                    data::add_post_data("login_info_fields", "country", $response->country);
                                    data::add_post_data("login_info_fields", "city", $response->city);
                                    data::add_post_data("login_info_fields", "isp", $response->isp);
                                    data::add_post_data("login_info_fields", "lat", $response->lat);
                                    data::add_post_data("login_info_fields", "lon", $response->lon);
                                    data::add_post_data("login_info_fields", "date", getNow());

                                    $nprp = new prepare_login_data();
                                    $control_module = $nprp->set_login_data(data::get_postdata());
                                    $login_data = data::get_data($control_module);
                                    data::insert_data("login_info", $login_data["login_info"]);

                                    $data["sonuc"] = true;
                                    session::set(CURRENT_USER_SESSION_NAME, $customer_id);
                                    cookie::delete(VISITORID);
                                    $data["redirect"] = DS . isset($plasebo_data["redirect"]) ? ltrim($plasebo_data["redirect"], "/") : "/home";
                                } else {
                                    $nvalidate->addError("Şifreniz Doğru Değil");
                                    $data["sonuc"] = false;
                                }
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

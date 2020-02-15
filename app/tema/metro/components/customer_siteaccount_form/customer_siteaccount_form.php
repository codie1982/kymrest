<?php

class customer_siteaccount_form extends component {

    public function render($parameter) {
        $this->set_component_name("customer_siteaccount_form");
        $this->make_component($parameter["type"]);
    }

    public function add_new_customer_siteaccountAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_customer_data = new prepare_customer_data();
                    $control_module = $nprepare_customer_data->set_personel_data($post);
                    $customer_data = data::get_data($control_module);
                    if ($nvalidate->passed()) {
                        if ($new_customer_id = data::insert_data("customer_siteaccount", $customer_data["customer_siteaccount"])) {
                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Kullanıcı İçin Yeni bir Hesap Oluşturuldu, Kullanıcının ilk girişinde Kendisinden bir şifre oluşturması istenecek");
                        } else {
                            $nvalidate->addError("Kullanıcı hesabı oluşturulmadı");
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
//                        if (!empty($nvalidate->get_errors()))
//                            foreach ($nvalidate->get_errors() as $err) {
//                                $data["error_message"][] = $err;
//                            }
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

    public function loadAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $data = $_REQUEST["data"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

                $customer_id = $_POST["customer_id"];
                component::add_props(["customer_id" => $customer_id]);
                $ncustomer_mail = new table_customer_mail();
                $ncustomer_mail->select();
                $ncustomer_mail->add_condition("customer_id", $customer_id);
                if ($customer_mail_data = $ncustomer_mail->get_alldata()) {
                    component::add_props(["customer_mail_data" => $customer_mail_data]);
                } else {
                    component::add_props(["customer_mail_data" => []]);
                }

                $nview = new view();

                component::import_component("customer_siteaccount_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                $data["starter"] = component::starter($data["tempstarter"]);
                $data["content"] = $content["customer_siteaccount_form"];
                $data["sonuc"] = true;
                $nvalidate->addSuccess("Form verileri alınmıştır..");
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Öncelikle Giriş Yapmanız gerekmektedir.");
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

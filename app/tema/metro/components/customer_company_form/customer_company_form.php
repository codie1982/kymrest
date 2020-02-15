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
class customer_company_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->add_global_plugin("bootstrap-summernote");
        $this->set_component_name("customer_company_form");
        $this->make_component($parameter["type"]);
    }

    public function add_new_customerAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_customer_data = new prepare_customer_data();
                    $control_module = $nprepare_customer_data->set_company_data($post);
                    //$key, $value, $control_module, $table, $secret = null
                    $customer_data = data::get_data($control_module);


                    if ($customer_data["customer_company"]["customer_company_title"] != "") {
                        //mail adresi Kontrolü
                        if (data::check_data($control_module, "customer_mail")) {
                            foreach ($customer_data["customer_mail"] as $key => $customer_mail_info) {
                                if ($customer_mail_info["customer_mail"] == "") {
                                    unset($customer_data["customer_mail"][$key]);
                                } else {
                                    $ncustomer_mail = new table_customer_mail();
                                    $ncustomer_mail->set_condition();
                                    $ncustomer_mail->select();
                                    $ncustomer_mail->add_condition("customer_mail", $customer_mail_info["customer_mail"]);
                                    $mailcount = $ncustomer_mail->get_alldata(true);
                                    if ($mailcount > 0) {
                                        $nvalidate->addError($customer_mail_info["customer_mail"] . " Bu mail adresi ile bir kullanıcı kayıtlı. <br /> Bu mail adresini ya listeden çıkarın veya başka bir mail adresi ile değiştirin");
                                    }
                                }
                            }
                        }
                        if (data::check_data($control_module, "customer_phone")) {
                            foreach ($customer_data["customer_phone"] as $key => $customer_phone_info) {
                                if ($customer_phone_info["phone_number"] == "") {
                                    unset($customer_data["customer_phone"][$key]);
                                } else {
                                    $ncustomer_phone = new table_customer_phone();
                                    $ncustomer_phone->set_condition();
                                    $ncustomer_phone->select();
                                    $ncustomer_phone->add_condition("area_code", $customer_phone_info["area_code"]);
                                    $ncustomer_phone->add_condition("phone_number", $customer_phone_info["phone_number"]);
                                    $phonecount = $ncustomer_phone->get_alldata(true);
                                    if ($phonecount > 0) {
                                        $nvalidate->addError($customer_phone_info["phone_number"] . " Bu telefon numarası ile bir kullanıcı kayıtlı. <br /> Bu telefon numarasını ya listeden çıkarın veya başka bir telefon numarası ile değiştirin");
                                    }
                                }
                            }
                        }
                        if (data::check_data($control_module, "customer_personel")) {
                            foreach ($customer_data["customer_personel"] as $key => $customer_personel_info) {
                                if ($customer_personel_info["name"] == "") {
                                    unset($customer_data["customer_personel"][$key]);
                                } else {
                                    $ncustomer_personel = new table_customer_personel();
                                    $ncustomer_personel->set_condition();
                                    $ncustomer_personel->select();
                                    $ncustomer_personel->add_condition("idnumber", $customer_personel_info["idnumber"]);
                                    $idcount = $ncustomer_personel->get_alldata(true);
                                    if ($idcount > 0) {
                                        $nvalidate->addError($customer_personel_info["idnumber"] . ' kimlik numaralı kişi. sisteme kayıtlı <br /> Kimlik numarasını değiştirerek yeniden kayıt etmeyi deneyin');
                                    }
                                }
                            }
                        }
                    } else {
                        $nvalidate->addError("Firma Adını Boş Bırakmayınız");
                    }


                    //dnd($customer_data, true);
                    if ($nvalidate->passed()) {
                        $ncustomer = new table_customer();

                        if ($new_customer_id = data::insert_data("customer", $customer_data["customer"])) {
                            $nvalidate->addSuccess($customer_data["customer_company"]["customer_company_title"] . " kişi firma oluşturuldu");
                            $customer_data_temp = data::get_data($control_module);
                            unset($customer_data_temp["customer"]);
                            foreach ($customer_data_temp as $table_name => $dt) {

                                if (!empty($dt))
                                    if (data::insert_data($table_name, $dt, true, "customer_id", $new_customer_id)) {
                                        $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                    }
                            }
                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Firma Bilgileri Başarılı bir şekilde Kayıt Edildi");
                        } else {
                            $nvalidate->addError("Firma Bilgileri Kayıt Edilemedi");
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

    public function update_customerAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_customer_data = new prepare_customer_data();
                    $control_module = $nprepare_customer_data->set_company_data($post);


                    $customer_data = data::get_data($control_module);
                    if (data::check_data($control_module, "customer_mail")) {
                        foreach ($customer_data["customer_mail"] as $customer_mail_info) {
                            $ncustomer_mail = new table_customer_mail();
                            $ncustomer_mail->set_condition();
                            $ncustomer_mail->select();
                            $ncustomer_mail->add_condition("customer_mail", $customer_mail_info["customer_mail"]);
                            if (!$mailcount = $ncustomer_mail->get_alldata(true)) {
                                $nvalidate->addError($customer_mail_info["customer_mail"] . " Bu mail adresi ile kayıtlı bir kullanıcı bulunmuyor. Mail adresinizi sistemde kayıtlı olan mail adresi ile değiştirin");
                            }
                        }
                    }

                    //dnd($customer_data, true);

                    if ($nvalidate->passed()) {
                        $customer_id = $customer_data["customer"]["customer_id"];
                        if (data::insert_data("customer", $customer_data["customer"])) {

                            $nvalidate->addSuccess($customer_data["customer_company"][0]["customer_company_title"] . " Firması için ilgiler Güncellendi");

                            $customer_data_temp = data::get_data($control_module);
                            unset($customer_data_temp["customer"]);
                            foreach ($customer_data_temp as $table_name => $dt) {
                                if (!empty($dt))
                                    if (data::insert_data($table_name, $dt, true, "customer_id", $customer_id)) {
                                        $nvalidate->addSuccess($table_name . " bilgileri kayıt edildi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " bilgileri kayıt edilemedi");
                                    }
                            }
                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "customer_table", "component_action" => "load"];
                            $nvalidate->addSuccess("Kullanıcı Bilgileri Başarılı bir şekilde Kayıt Edildi");
                        } else {
                            $nvalidate->addError("Kullanıcı bilgileri güncellenmedi");
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


                $nsettings_customer = new table_settings_customer();
                $nsettings_customer->add_filter("customer_tag");
                $nsettings_customer->select();
                $customer_tag_list = $nsettings_customer->get_alldata(true);
                if ($customer_tag_list)
                    component::add_props(["customer_tag_list" => explode(",", $customer_tag_list->customer_tag)]);
                $nview = new view();


                component::import_component("block_personel_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_personel_company" => $content["block_personel_company"]]);

                component::import_component("block_tax_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_tax_company" => $content["block_tax_company"]]);


                component::import_component("block_tag_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_tag_company" => $content["block_tag_company"]]);

                component::import_component("block_email_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_email_company" => $content["block_email_company"]]);

                component::import_component("block_adres_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_adres_company" => $content["block_adres_company"]]);

                component::import_component("block_phone_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_phone_company" => $content["block_phone_company"]]);

                component::import_component("block_credicard_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_credicard_company" => $content["block_credicard_company"]]);

                component::import_component("block_bank_company", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["block_bank_company" => $content["block_bank_company"]]);

                component::import_component("customer_company_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();

                $data["starter"] = component::starter($data["tempstarter"]);
                $data["content"] = $content["customer_company_form"];
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

    public function edit_costumerAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $customer_id = $_REQUEST["customer_id"];
                if (!empty($customer_id)) {
                    if (isset($_REQUEST["modal"])) {
                        $data["modal"] = $_REQUEST["modal"];
                    }

                    if (isset($_REQUEST["starter"])) {
                        $data["tempstarter"] = $_REQUEST["starter"];
                    }
                    $nview = new view();
                    $customer_data = data::allInfo("customer", $customer_id);


                    //dnd($customer_data);

                    $nsettings_customer = new table_settings_customer();
                    $nsettings_customer->add_filter("customer_tag");
                    $nsettings_customer->select();
                    $customer_tag_list = $nsettings_customer->get_alldata(true);
                    if ($customer_tag_list)
                        component::add_props(["customer_tag_list" => explode(",", $customer_tag_list->customer_tag)]);

                    component::add_props(
                            [
                                "form_action" => "update_customer",
                                "button_text" => "Güncelle",
                                "customer_id" => $customer_id,
                                "customer_data" => $customer_data["customer"],
                                "customer_company_data" => $customer_data["customer_company"][0],
                                "customer_mail_data" => $customer_data["customer_mail"],
                                "customer_phone_data" => $customer_data["customer_phone"],
                                "customer_adres_data" => $customer_data["customer_adres"],
                                "customer_credi_card_data" => $customer_data["customer_credi_card"],
                                "customer_bank_data" => $customer_data["customer_bank"],
                                "customer_personel_data" => $customer_data["customer_personel"],
                                "customer_tag_data" => $customer_data["customer_tag"],
                            ]
                    );


                    component::import_component("block_personel_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_personel_company" => $content["block_personel_company"]]);

                    component::import_component("block_tax_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_tax_company" => $content["block_tax_company"]]);

                    component::import_component("block_tag_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_tag_company" => $content["block_tag_company"]]);

                    component::import_component("block_email_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_email_company" => $content["block_email_company"]]);

                    component::import_component("block_adres_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_adres_company" => $content["block_adres_company"]]);

                    component::import_component("block_phone_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_phone_company" => $content["block_phone_company"]]);

                    component::import_component("block_credicard_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_credicard_company" => $content["block_credicard_company"]]);

                    component::import_component("block_bank_company", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(["block_bank_company" => $content["block_bank_company"]]);


                    component::import_component("customer_company_form", ["type" => "admin"], true);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    $data["starter"] = component::starter($data["tempstarter"]);
                    $data["content"] = $content["customer_company_form"];
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Form verileri alınmıştır..");
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

    public function remove_costumerAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $customer_id = $_REQUEST["customer_id"];
                if (!empty($customer_id)) {

                    if (data::removeAll("customer", $customer_id)) {
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Kayıtlı kullanıcı sistemden kaldırılmıştır.");
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addSuccess("Kayıtlı kullanıcı sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
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

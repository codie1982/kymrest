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
class bulk_mail_send_form extends component {

    public function render($parameter) {
        //dnd((__DIR__));
        $this->set_component_name("bulk_mail_send_form");
        $this->make_component($parameter["type"]);
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

                $mail_components = modules::getBulkMailTemplatesList();
                component::add_props(["mail_components" => $mail_components]);

                $nview = new view();
                component::import_component("bulk_mail_send_form", ["type" => "extension/Bulkmail"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();
                $data["content"] = $content["bulk_mail_send_form"];
                $data["starter"] = component::starter($data["tempstarter"]);
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

    public function add_bulkmailAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $bulkdata = $_POST["bulkdata"];

                if (!empty($bulkdata)) {

                    foreach ($bulkdata as $maildata) {
                        $rand = rand(999, 9999);
                        data::add_post_data("bulkmail_fields", "secret_number", $rand);
                        data::add_post_data("bulkmail_fields", "name", $maildata["name"], $rand);
                        data::add_post_data("bulkmail_fields", "lastname", $maildata["lastname"], $rand);
                        data::add_post_data("bulkmail_fields", "mail", $maildata["mail"], $rand);
                        data::add_post_data("bulkmail_fields", "mail_subject", $maildata["mail_subject"], $rand);
                        data::add_post_data("bulkmail_fields", "customer_id", $maildata["id"], $rand);
                        data::add_post_data("bulkmail_fields", "bulkmail_seccode", seccode(), $rand);
                        data::add_post_data("bulkmail_fields", "date", getNow(), $rand);
                        data::add_post_data("bulkmail_fields", "users_id", $maildata["email"], $rand);
                    }
                    $bulkmail_post_data = data::get_postdata();
                    $nprepare_bulkmail_data = new prepare_bulkmail_data();
                    $control_module = $nprepare_bulkmail_data->set_data($bulkmail_post_data);
                    $bulkmail_data = data::get_data($control_module);

                    $tempbulkmail = $bulkmail_data;
                    foreach ($tempbulkmail as $table_name => $dt) {
                        foreach ($dt as $key => $vl) {
                            $id = $vl["customer_id"];
                            $mail_subject = $vl["mail_subject"];
                            $name = $vl["name"];
                            $lastname = $vl["lastname"];
                            $nbulkmail = new table_bulkmail();

                            $nbulkmail->select("bulkmail_id");
                            $nbulkmail->add_condition("customer_id", $id);
                            $nbulkmail->add_condition("mail_subject", $mail_subject);
                            $nbulkmail->add_condition("send", 0);
//                            $nbulkmail->show_sql();
//                            $nbulkmail->show_where_value();

                            if ($res = $nbulkmail->get_alldata()) {

                                $nvalidate->addError('
                                        ' . $name . ' ' . $lastname . ' adlı kullanıcı için mail gönderim kuyruğunda ' . $mail_subject . ' konulu bir mail bulunmaktadır.
                                    Bu sebeple ' . $name . ' ' . $lastname . ' kişisi mail kuyruğundan çıkarılmıştır.
                                    ');
                                unset($bulkmail_data[$table_name][$key]);
                            }
                        }
                    }


                    if ($nvalidate->passed()) {
                        if (!empty($bulkmail_data)) {
                            foreach ($bulkmail_data as $table_name => $dt) {
                                foreach ($dt as $vl) {
                                    if (data::insert_data($table_name, $vl)) {
                                        $nvalidate->addSuccess(' ' . $vl["name"] . ' ' . $vl["lastname"] . ' adlı kullanıcı için  ' . $vl["mail"] . '  mail gönderim kuyruğunda eklenmiştir.');
                                    } else {
                                        $nvalidate->addWarning(' ' . $vl["name"] . ' ' . $vl["name"] . ' adlı kullanıcı için  ' . $vl["mail"] . '  mail gönderim kuyruğunda eklenmemiştir.Lütfen tekrardan deneyiniz.');
                                    }
                                }
                            }
                            $data["sonuc"] = true;
                        } else {
                            $nvalidate->addError("Ürün İsmini Boş Bırakmayınız");
                            $data["sonuc"] = false;
                        }
                    } else {
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
                    }
                } else {
                    $data["sonuc"] = false;
                    $data["msg"] = "Herhangi bir veri gelmemiştir";
                }
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
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

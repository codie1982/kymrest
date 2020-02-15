<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author engin
 */
class admin_mail_confirm extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("confirm");
    }

    public function indexAction($classname, $action, $confirm_code = "") {

        if (isset($confirm_code)) {
            $ncustomer_mail = new table_customer_mail();
            $ncustomer_mail->select();
            $ncustomer_mail->add_condition("confirm_code", $confirm_code);
            $mail_code_info = $ncustomer_mail->get_alldata(true);
            if ($mail_code_info = $ncustomer_mail->get_alldata(true)) {
                if ($mail_code_info->confirm == 0) {
                    if ($mail_code_info->confirm_code == $confirm_code) {

                        data::add_post_data("customer_mail_fields", "primary_key", $mail_code_info->customer_mail_id);
                        data::add_post_data("customer_mail_fields", "confirm", 1);
                        data::add_post_data("customer_mail_fields", "confirm_date", getNow());
                        $nprp = new prepare_admin_register();
                        $control_module = $nprp->user_mail_data(data::get_postdata());
                        $mail_data = data::get_data($control_module);
                        if (data::insert_data("customer_mail", $mail_data["customer_mail"])) {
                            component::add_props(["confirm_message" => "Mail Adresiniz Onaylanmıştır"]);
                        } else {
                            component::add_props(["confirm_message" => "Mail Adresiniz Onaylanmamıştır"]);
                        }

//                        data::update_data("customer_mail", ["confirm" => 1, "confirm_date" => getNow()], $mail_code_info->customer_mail_id, "customer_mail_id");
                    } else {
                        component::add_props(["confirm_message" => "Mail Adresinin Onay Kodu Uyumlu değil"]);
                    }
                } else {
                    component::add_props(["confirm_message" => "Bu Mail Adresi Onaylı"]);
                }
            } else {
                component::add_props(["confirm_message" => "Mail Bilgisine Ulaşılamıyor"]);
            }
        } else {
            component::add_props(["confirm_message" => "Bir onay kodu bulunmamaktadır"]);
        }

        component::import_component("confirm_page", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["confirm_page"]);
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

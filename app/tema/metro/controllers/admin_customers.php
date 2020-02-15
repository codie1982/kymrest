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
class admin_customers extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        component::import_component("customer_action", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_personel_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_tag_personel", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_tag_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_tax_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_email_personel", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_email_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_adres_personel", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_adres_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_phone_personel", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_phone_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_credicard_personel", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_credicard_company", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("block_bank_company", ["type" => "admin"]);

        $this->view->add_page(component::get_component_module());



        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(
                [
                    "tax_block" => $content["tax_block"],
                    "email_block" => $content["email_block"],
                    "adres_block" => $content["adres_block"],
                    "phone_block" => $content["phone_block"],
                    "credicard_block" => $content["credicard_block"]
                ]
        );

        component::import_component("customer_siteaccount_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("customer_personel_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("customer_company_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("customer_table", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("2,2,2,2", $content["customer_action"]);
        tema::addrow();
        tema::column("12,12,12,12", $content["customer_table"]);
        tema::addrow();
        tema::adddiv($content["customer_personel_form"]);
        tema::adddiv($content["customer_company_form"]);
        tema::adddiv($content["customer_siteaccount_form"]);

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

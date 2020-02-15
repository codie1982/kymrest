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
class admin_product_settings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);

        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        $nproduct_settings = new table_settings_product();
        $product_settings = $nproduct_settings->get_data(15);

        $ncurrency = new table_settings_general_currency();
        $currency_data = $ncurrency->get_currency();
        //dnd($currency_data);

        component::add_props(
                [
                    "product_settings" => $product_settings,
                    "currency_data" => $currency_data
                ]
        );
//*******************************
        component::import_component("product_settings_currency", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(
                [
                    "product_settings_currency_component" => $content["product_settings_currency"],
                ]
        );
//*******************************
        component::import_component("product_settings_extra_price", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(
                [
                    "product_settings_extra_price_component" => $content["product_settings_extra_price"],
                ]
        );
//*******************************
        component::import_component("product_settings_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

//        $row = html::addrow([["12,12,12,12" => ["html" => $content["product_settings_form"]]]]);
        tema::column("12,12,12,12", $content["product_settings_form"]);
        tema::addrow();
        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

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
class admin_user_settings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);

        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {



        $ncustomer_settings = new table_settings_customer();
        $ncustomer_settings->select();
        $ncustomer_settings->add_limit_start(1);
        $ncustomer_settings->add_direction("DESC");
        $customer_settings_data = $ncustomer_settings->get_alldata(true);
        component::add_props(["customer_settings_data" => $customer_settings_data]);

        component::import_component("user_settings_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["user_settings_form"]);
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

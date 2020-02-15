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
class admin_general_settings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        $ngeneral_settings = new table_settings_general();
        $settings = $ngeneral_settings->get_general_settings();

        component::add_props(["settings" => $settings]);
        if ($settings->mycompany_id != 0) {

            $company_info = data::allInfo("customer", $settings->mycompany_id);
            component::add_props(["my_company_data" => $company_info]);
        }




        component::add_props(["settings_id" => $settings->settings_general_id]);

        component::import_component("general_settings_mycompany", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();


        component::add_props(["general_settings_mycompany" => $content["general_settings_mycompany"]]);

        component::import_component("general_settings_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["general_settings_form"]);
        tema::addrow();
        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

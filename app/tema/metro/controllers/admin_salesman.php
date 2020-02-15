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
class admin_salesman extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {


        tema::add_global_plugin("bootstrap-wizard");
        tema::add_global_plugin("socket.io.application");

        component::import_component("job_action", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_products_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_form_products_detail", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_id", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_new", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_short_table", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("job_detail_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();
        tema::column("2,2,2,2", $content["job_action"]);
        tema::addrow();
        tema::column("8,8,8,8", $content["job_short_table"]);
        tema::column("4,4,4,4", $content["job_detail_list"]);
        tema::addrow();
        tema::adddiv($content["job_form"]);

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

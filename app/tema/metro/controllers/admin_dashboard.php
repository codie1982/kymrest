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
class admin_dashboard extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
       
    }

    public function indexAction($parameter = array()) {

        tema::add_global_plugin(["morris", "counterup"]);

        component::import_component("data_counter", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("general_chart", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("donut_chart", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("complete_order", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("waiting_order", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("returned_order", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("tranport_order", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(
                [
                    "tab_section" => [
                        ["tab_name" => "Tamamlanan Satışlar", "tab_content" => $content["complete_order"]],
                        ["tab_name" => "Sepette Bekleyenler", "tab_content" => $content["waiting_order"]],
                        ["tab_name" => "İade Alınanlar", "tab_content" => $content["returned_order"]],
                        ["tab_name" => "Kargo Sürecinde", "tab_content" => $content["tranport_order"]],
                    ]
                ]
        );


        $ntab_list = component::import_component("tab_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["data_counter"]);
        tema::addrow();
        tema::column("8,8,8,8", $content["general_chart"]);
        tema::column("4,4,4,4", $content["donut_chart"]);
        tema::addrow();
        tema::column("12,12,12,12", $content["tab_list"]);
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

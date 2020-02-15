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
class admin_products extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        //tema::add_global_plugin(["morris"]);

        component::import_component("product_action", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_images_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_images", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_category_tree", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_group_fields", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_payment_group", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_payment_group_section", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_price_group", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_price_options", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("product_table", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();
        //$content["product_action"]
        tema::column("3,3,3,3", $content["product_action"]);
        tema::addrow();
        tema::column("12,12,12,12", $content["product_table"]);
        tema::addrow();
        tema::adddiv($content["product_form"]);

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

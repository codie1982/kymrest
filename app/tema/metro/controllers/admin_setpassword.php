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
class admin_setpassword extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("login");
    }

    public function indexAction($parameter = array(), $verify_code) {
        component::add_props(["verify_code" => $verify_code]);


        component::import_component("repassword", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["repassword"]);
        tema::addrow();


        $this->view->set_page_html();

        tema::add_html(tema::set_template());

        $this->view->render("page");
    }

}

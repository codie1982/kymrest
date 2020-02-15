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
class admin_mailbox extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {
        tema::add_meta('charset="UTF-8"');
        tema::add_meta('name="viewport" content="width=device-width, initial-scale=1.0"');

        component::import_component("mail_box_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["mail_box_form"]);
        tema::addrow();
        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

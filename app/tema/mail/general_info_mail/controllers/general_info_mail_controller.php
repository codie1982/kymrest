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
class general_info_mail_controller extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->view->set_mail_code("general_info_mail");
        $this->view->setLayout();
    }

    public function indexAction($parameters = array()) {
        component::import_component("info", ["type" => "mail/general_info_mail"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();
        return $content["info"];
    }

}

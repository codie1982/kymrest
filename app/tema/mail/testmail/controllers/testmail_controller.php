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
class testmail_controller extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("testmail");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {
        component::import_component("test01", ["type" => "mail/testmail"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();
        return $content["test01"];
    }

}

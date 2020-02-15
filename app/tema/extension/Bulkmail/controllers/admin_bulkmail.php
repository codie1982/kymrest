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
class admin_bulkmail extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

//        component::import_component("blkmail", ["type" => "extension/Bulkmail"]);
//        $this->view->add_page(component::get_component_module());
//
//        $this->view->prepare_page();
//        $content = $this->view->get_content();
//        $row = html::addrow([["12,12,12,12" => ["html" => $content["blkmail"]]]]);
//
//        $template = $this->view->set_template($row);
//        $this->view->set_page_html();
//        tema::add_html($template);
//
//        $this->view->render("page");
    }

}

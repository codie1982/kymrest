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
class admin_trash extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {
        //$row = html::addrow([["12,12,12,12" => ["html" => "Çöp Kutusu"]]]);
        $template = $this->view->set_template($row);
        $content = $this->view->get_content();

        tema::column("12,12,12,12", "Çöp Kutusu");
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

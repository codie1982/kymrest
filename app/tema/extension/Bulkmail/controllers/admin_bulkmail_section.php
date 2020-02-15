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
class admin_bulkmail_section extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        tema::add_meta('charset="UTF-8"');
        tema::add_meta('name="viewport" content="width=device-width, initial-scale=1.0"');

        component::import_component("mail_action", ["type" => "extension/Bulkmail"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("mail_query_table", ["type" => "extension/Bulkmail"]);
        $this->view->add_page(component::get_component_module());


        component::import_component("bulk_mail_form", ["type" => "extension/Bulkmail"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("test_mail_form", ["type" => "extension/Bulkmail"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("sendmail_action", ["type" => "extension/Bulkmail"]);
        $this->view->add_page(component::get_component_module());


        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["mail_action"]);
        tema::addrow();
        tema::column("12,12,12,12", $content["mail_query_table"]);
        tema::addrow();
        tema::adddiv($content["bulk_mail_form"]);
        tema::adddiv($content["test_mail_form"]);

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

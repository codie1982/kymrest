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
class admin_categories extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        tema::add_meta('charset="UTF-8"');
        tema::add_meta('name="viewport" content="width=device-width, initial-scale=1.0"');


        component::import_component("category_action", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_move_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_main_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("group_fields_list_value", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_move_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_gallery_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_group_fields_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("group_fields_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("group_fields_modal", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("group_fields_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("group_fields_edit_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("group_values", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_gallery_images", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_images_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_tree_list", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("category_table", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());


        $this->view->prepare_page();
        $content = $this->view->get_content();
//        $row .= html::addrow([
//                    ["2,2,12,12" => ["html" => $content["category_action"]]],
//        ]);
//
//        $row .= html::addrow([
//                    ["4,4,12,12" => ["html" => $content["category_tree_list"]]],
//                    ["8,8,12,12" => ["html" => $content["category_table"]]],
//                        ]
//        );
//        $row .= $content["group_fields_modal"];
//        $row .= $content["group_fields_edit_form"];
//        $row .= $content["category_form"];
//        $row .= $content["category_move_form"];
//        $row .= $content["category_gallery_form"];
//        $row .= $content["category_group_fields_form"];

        tema::column("2,2,12,12", $content["category_action"]);
        tema::addrow();
        tema::column("4,4,12,12", $content["category_tree_list"]);
        tema::column("8,8,12,12", $content["category_table"]);
        tema::addrow();
        tema::adddiv($content["group_fields_modal"]);
        tema::adddiv($content["group_fields_edit_form"]);
        tema::adddiv($content["category_form"]);
        tema::adddiv($content["category_move_form"]);
        tema::adddiv($content["category_gallery_form"]);
        tema::adddiv($content["category_group_fields_form"]);


        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

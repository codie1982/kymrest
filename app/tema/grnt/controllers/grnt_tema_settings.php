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
class grnt_tema_settings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
        
    }

    public function indexAction($parameters = array()) {
        $ntema_settings = new table_settings_grnt();
        $site_info = $ntema_settings->get_tema_settings();

        $image_gallery = new table_image_gallery();
        $site_logo_info = $image_gallery->get_image_info($site_info->image_gallery_id);

        //dnd($site_logo_info);
        component::add_props(
                [
                    "site_info" => $site_info,
                    "site_logo_info" => $site_logo_info,
                ]
        );

        component::import_component("grntlogo", ["type" => "user"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(
                [
                    "site_logo" => $content["grntlogo"],
                ]
        );
        component::import_component("grnt_settings_form", ["type" => "user"]);
        $this->view->add_page(component::get_component_module());



        $this->view->prepare_page();
        $content = $this->view->get_content();
        
        tema::column("12,12,12,12", $content["grnt_settings_form"]);
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

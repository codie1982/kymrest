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
class admin_library extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        tema::add_meta('charset="UTF-8"');
        tema::add_meta('name="viewport" content="width=device-width, initial-scale=1.0"');


        $nimage_gallery = new table_image_gallery();
        $nimage_gallery->select();
        $nimage_gallery->add_limit_start(0);
        $nimage_gallery->add_limit_end(10);
        $gallery_data = $nimage_gallery->get_alldata();

        $nimage_gallery_count = new table_image_gallery();
        $nimage_gallery_count->set_count();
        $nimage_gallery_count->select();
        $total_gallery_count = $nimage_gallery_count->get_alldata(true);

        component::add_props(
                [
                    "gallery_data" => $gallery_data,
                    "total_gallery_data" => $total_gallery_count,
                    "selected_date" => "all",
                    "page_number" => 1,
                    "page_count" => 10,
                    "start" => 0,
                    "end" => 10,
                    "view" => "image_list",
                    "image_type" => "all"
                ]
        );

        component::import_component("library_content_header", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("library_action", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("library_content", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("load_image_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("load_video_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("load_audio_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());
        component::import_component("load_document_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["library_action"]);
        tema::addrow();
        tema::column("12,12,12,12", $content["library_content_header"]);
        tema::addrow();
        tema::column("12,12,12,12", $content["library_content"]);
        tema::addrow();
        tema::adddiv($content["load_image_form"]);
        tema::adddiv($content["load_video_form"]);
        tema::adddiv($content["load_audio_form"]);
        tema::adddiv($content["load_document_form"]);

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

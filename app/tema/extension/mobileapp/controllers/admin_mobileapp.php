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
class admin_mobileapp extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        $nslider = new table_application_main_slider();
        $nslider->select();
        $sliders = $nslider->get_alldata();
        $sliders = object_to_array($sliders);
        $i = 0;
        if (!empty($sliders))
            foreach ($sliders as $slider) {
                $nimage = new table_image_gallery();
                $nimage->select();
                $nimage->add_condition("image_gallery_id", $slider["image_gallery_id"]);
                $sliders[$i]["image_info"] = $nimage->get_alldata(true);
                $i++;
            }

        component::add_props(["slider_data" => $sliders]);




        $nsettings_app = new table_settings_customer_application();
        $nsettings_app->select();
        $nsettings_app->add_limit_start(1);
        $nsettings_app->add_direction("DESC");

        $data = $nsettings_app->get_alldata(true);
        component::add_props(["form_data" => $data]);


        component::import_component("slider_images_list", ["type" => "extension/mobileapp"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(["slider_images_list" => $content["slider_images_list"]]);

        component::import_component("gallery_images", ["type" => "extension/mobileapp"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("main_slider_gallery_form", ["type" => "extension/mobileapp"]);
        $this->view->add_page(component::get_component_module());

        component::import_component("mobile_pack", ["type" => "extension/mobileapp"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["mobile_pack"]);
        tema::addrow();
        tema::adddiv($content["main_slider_gallery_form"]);

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

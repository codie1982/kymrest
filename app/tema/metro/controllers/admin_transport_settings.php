<?php

/**
 * Description of home
 *
 * @author engin
 */
class admin_transport_settings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {

        $ntransport_settings = new table_settings_transport();
        $transport_settings = $ntransport_settings->get_data();
        component::add_props(
                [
                    "transport_settings" => $transport_settings,
                ]
        );


        $ntransport_location_data = new table_settings_transport_location();
        $ntransport_location_data->select();
        $location_data = $ntransport_location_data->get_alldata();



        component::add_props(
                [
                    "display" => $transport_settings->transport_location_price == "1" ? true : false,
                    "location_data" => $location_data,
                ]
        );


        component::import_component("transport_adres_block", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();

        component::add_props(
                [
                    "transport_adres_block" => $content["transport_adres_block"],
                ]
        );

        component::import_component("transport_settings_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

//        $row = html::addrow([["12,12,12,12" => ["html" => $content["transport_settings_form"]]]]);
        tema::column("12,12,12,12", $content["transport_settings_form"]);
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

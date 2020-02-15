<?php

/**
 * Description of home
 *
 * @author engin
 */
class admin_sidebar_settings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {
        $nsidebar = new table_sidebar_menu();
        $nsidebar->select();
        $sidebarinfo = $nsidebar->get_alldata();
        //dnd($sidebarinfo);
        component::add_props(["sidebar_info" => $sidebarinfo]);

        component::import_component("sidebar_settings_form", ["type" => "admin"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        tema::column("12,12,12,12", $content["sidebar_settings_form"]);
        tema::addrow();

        $this->view->set_page_html();
        tema::add_html(tema::set_template());
        $this->view->render("page");
    }

}

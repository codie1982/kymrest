<?php

/**
 * Description of home
 *
 * @author engin
 */
class home extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->view->set_template_code("user");
        $this->view->setLayout();
    }

    public function indexAction($param = "") {

        tema::add_font("https://fonts.googleapis.com/css?family=Poppins:400,900&display=swap", false);

        component::import_component("app", ["type" => "user"]);
        $this->view->add_page(component::get_component_module());

        $this->view->prepare_page();
        $content = $this->view->get_content();

        //dnd(component::get_component_module());
        $template = $this->view->set_template($content["app"]);
        $this->view->set_page_html();
        tema::add_html($template);
        //dnd(tema::get_tema());
        $this->view->render("page");
    }

}

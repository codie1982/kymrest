<?php

/**
 * Description of home
 *
 * @author engin
 */
class config extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->view->set_template_code("config");
        $this->view->setLayout();

//        if ($action == "") {
//            $this->view->render("config/index");
//        } else {
//            $this->view->render('config/' . $action);
//        }
    }

    public function indexAction($param = "") {
        //  $this->view->render("config/index");
    }

    public function firstuserAction($param = "") {
        //  $this->view->render("config/firstuser");
    }

}

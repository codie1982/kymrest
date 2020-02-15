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
class admin_logout extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);

        tema::set_selected_tema("metro");
        tema::set_selected_template("standart");
    }

    public function indexAction($parameters = array()) {
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if (module_user::userlogout()) {
                router::redirect("home");
            } else {
                die("Sistem Çıkışınız sağlanamadı. Lütfen Tekrar Deneyin");
            }
        } else {
            router::redirect("home");
        }
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of register
 *
 * @author engin
 */
class dbsettings extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        return true;
    }
    public function indexAction() {
        if ($_POST) {
            parse_str($_POST["form_data"], $post);
            $data["data"] = $post;
            $data["sonuc"] = true;
            $data["msg"] = "veri doğru bir şekilde yüklendi";
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

}

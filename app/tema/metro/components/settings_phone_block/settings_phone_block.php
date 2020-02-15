<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sidebar
 *
 * @author engin
 */
class settings_phone_block extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->set_component_name("settings_phone_block");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $incomming = $_POST["senddata"];

                $nsettings_general_phone = new table_settings_general_phone();
                $phone_info = [];
                foreach ($incomming as $settings_general_phone_id) {
                    $phone_info[] = $nsettings_general_phone->get_general_settings_phone_from_id($settings_general_phone_id);
                }
                $data["result"] = $phone_info;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu Alana Bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu Alana Bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function removeAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $key = $_POST["key"];

                $nsettings_general_phone = new table_settings_general_phone();

                $nsettings_general_phone->remove($key);
                $data["sonuc"] = true;
                $data["msg"] = "Telefon numarası Kaldırıldı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu Alana Bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu Alana Bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

}

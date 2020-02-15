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
class settings_tax_block extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->set_component_name("settings_tax_block");
        $this->make_component($parameter["type"]);
    }

    public function gettaxdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $select_province_id = input::get("select_province_id");
                $ntax_office = new table_tax_office();
                $taxplacelist = $ntax_office->getTaxPlacelist($select_province_id);
                $data["sonuc"] = true;
                $data["taxplacelist"] = $taxplacelist;
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

    public function getdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $select_province_id = input::get("select_province_id");
                $ntax_office = new tax_office();
                $taxplacelist = $ntax_office->getTaxPlacelist($select_province_id);
                $data["sonuc"] = true;
                $data["taxplacelist"] = $taxplacelist;
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

}

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
class settings_adres_block extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->set_component_name("settings_adres_block");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $incomming = $_POST["senddata"];
                $nsettings_general_adres = new table_settings_general_adres();
                $adres_info = [];
                $i = 0;
                foreach ($incomming as $settings_general_adres_id) {
                    $info = $nsettings_general_adres->get_general_settings_adres_form_id($settings_general_adres_id);
                    $adres_info[$i] = get_object_vars($info);
                    $nadres = new table_adres();
                    $district_list = $nadres->getdistrictlist($adres_info[$i]["province"]);
                    $adres_info[$i]["districtlist"] = $district_list;
                    $neighborhoodSmtlist = $nadres->getneighborhoodSmtlist($adres_info[$i]["province"], $adres_info[$i]["district"]);
                    $adres_info[$i]["AASmtBckAdi"] = $neighborhoodSmtlist;
                    $neighborhoodlist = $nadres->getneighborhoodlist($adres_info[$i]["province"], $adres_info[$i]["district"]);
                    $adres_info[$i]["AAmhlKoyAdi"] = $neighborhoodlist;
                    $i++;
                }
                $data["result"] = $adres_info;
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

                $nsettings_general_adres = new table_settings_general_adres();
                $nsettings_general_adres->remove($key);
                $data["sonuc"] = true;
                $data["msg"] = "Adres Kaldırıldı";
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

    public function getdistrictdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $ntable_adres = new table_adres();
                $select_province_id = input::santize($_POST["select_province_id"]);
                $list = $ntable_adres->getdistrictlist($select_province_id);
                $data["sonuc"] = true;
                $data["districtlist"] = $list;
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

    public function getneighborhooddataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $select_province_id = input::santize($_POST["select_province_id"]);
                $select_district_id = input::santize($_POST["select_district_id"]);
                $ntable_adres = new table_adres();
                $AASmtBckAdi = $ntable_adres->getneighborhoodSmtlist($select_province_id, $select_district_id);
                $AAmhlKoyAdi = $ntable_adres->getneighborhoodlist($select_province_id, $select_district_id);
                $data["sonuc"] = true;
                $data["AASmtBckAdi"] = $AASmtBckAdi;
                $data["AAmhlKoyAdi"] = $AAmhlKoyAdi;
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

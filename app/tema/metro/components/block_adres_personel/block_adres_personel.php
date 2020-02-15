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
class block_adres_personel extends component {

    public function render($parameter) {
        $this->set_component_name("block_adres_personel");
        $this->make_component($parameter["type"]);
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
            } else if ($_GET) {
//                dnd($param);
//                dnd($_GET);
                $ntable_adres = new table_adres();
                $select_province_id = input::santize($_GET["select_province_id"]);
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
            } else if ($_GET) {
                $select_province_id = input::santize($_GET["select_province_id"]);
                $select_district_id = input::santize($_GET["select_district_id"]);
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

    public function getdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $incomming = $_POST["senddata"];
                $ncustomer_adres = new table_customer_adres();
                $adres_info = [];
                $i = 0;
                foreach ($incomming as $adres_id) {
                    $info = $ncustomer_adres->get_adres_info_from_adresid($adres_id);
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

                $ncustomer_mail = new table_customer_adres();
                if (data::remove($ncustomer_mail->get_table_name(), $key)) {
                    $data["sonuc"] = true;
                    $data["msg"] = "Kredi Kartı Bilgileri Kaldırıldı";
                } else {
                    $data["sonuc"] = false;
                    $data["msg"] = "Kredi Kartı Bilgileri Kaldırılmadı Lütfen tekrar deneyin.";
                }
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

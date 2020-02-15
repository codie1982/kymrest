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
class block_tag_company extends component {

    public function render($parameter) {
        $this->set_component_name("block_tag_company");
        $this->make_component($parameter["type"]);
    }

    public function removeAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $key = $_POST["key"];

                $ncustomer_mail = new table_customer_tag();
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

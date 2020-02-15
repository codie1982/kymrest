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
class donut_chart extends component {

    public function render($parameter) {
        $this->set_component_name("donut_chart");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $pie = $_POST["pie"];
                $njob = new table_job();
                $data["complete_job_label"] = "Tamamlanan İş";
                $data["return_job_label"] = "İade Edilen";
                $data["basket_job_label"] = "Sepette";
                $data["incargo_job_label"] = "Kargoda";

                $data["complete_job"] = $njob->getCompleteJobCount() == 0 ? 1 : $njob->getCompleteJobCount();
                $data["return_job"] = $njob->getReturnJobCount() == 0 ? 1 : $njob->getReturnJobCount();
                $data["basket_job"] = $njob->getInBasketJobCount() == 0 ? 1 : $njob->getInBasketJobCount();
                $data["incargo_job"] = $njob->getInCargoJobCount() == 0 ? 1 : $njob->getInCargoJobCount();
                $data["sonuc"] = true;
                $data["msg"] = "Sonuçlar";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

}

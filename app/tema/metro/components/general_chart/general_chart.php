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
class general_chart extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->set_component_name("general_chart");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $data_type = $_POST["data_type"];
                $time_type = $_POST["time_type"];

                $year = 2010;
                $dt = [];
                $dtlk = [];
                $dtck = [];
                $dtyk = [];
                $_dt = [];
                $dtyk[] = "y";


                if (count($time_type) == 2) {
                    //Custom Time
                    //Günlük Hesapla
                } else {
                    if (gettype($time_type[0] == "string")) {
                        if ($time_type[0] == "today") {
                            $data_count = 24;
                        } else if ($time_type[0] == "yesterday") {
                            $data_count = 24;
                        } else if ($time_type[0] == "last_7") {
                            $data_count = 7;
                        } else if ($time_type[0] == "last_30") {
                            $data_count = 30;
                        } else if ($time_type[0] == "last_60") {
                            $data_count = 60;
                        } else if ($time_type[0] == "last_90") {
                            $data_count = 90;
                        }
                    }
                }
                $now = strtotime("now");
                for ($i = 0; $i < $data_count; $i++) {
                    $start_date = 0;
                    $end_date = 0;
                    //$_dt["y"] = date("Y", mktime(0, 0, 0, 1, 1, $year++));
                    switch ($time_type[0]) {
                        case"today";
                            $timespan = $now - ($i * ONE_HOUR);
                            $start_date = $now - ($i * ONE_HOUR);
                            $end_date = $now - (($i + 1) * ONE_HOUR);
                            $_dt["y"] = date("H:i:s", $timespan);
                            break;
                        case"yesterday";
                            $timespan = ($now - ONE_DAY) - ($i * ONE_HOUR);
                            $start_date = ($now - ONE_DAY) - ($i * ONE_HOUR);
                            $end_date = ($now - ONE_DAY) - (($i + 1) * ONE_HOUR);
                            $_dt["y"] = date("H:i:s", $timespan);
                            break;
                        case"last_7";
                            $timespan = ($now) - ($i * ONE_DAY);
                            $start_date = $now - ($i * ONE_DAY);
                            $end_date = $now - (($i + 1) * ONE_DAY);
                            $_dt["y"] = date("d-m-Y", $timespan);
                            break;
                        case"last_30";
                            $timespan = ($now ) - ($i * ONE_DAY);
                            $start_date = $now - ($i * ONE_DAY);
                            $end_date = $now - (($i + 1) * ONE_DAY);
                            $_dt["y"] = date("d-m-Y", $timespan);
                            break;
                        case"last_60";
                            $timespan = ($now ) - ($i * ONE_DAY);
                            $start_date = $now - ($i * ONE_DAY);
                            $end_date = $now - (($i + 1) * ONE_DAY);
                            $_dt["y"] = date("d-m-Y", $timespan);
                            break;
                        case"last_90";
                            $start_date = $now - ($i * ONE_DAY);
                            $end_date = $now - (($i + 1) * ONE_DAY);
                            $timespan = ($now ) - ($i * ONE_DAY);
                            $_dt["y"] = date("d-m-Y", $timespan);
                            break;
                    }

                    foreach ($data_type as $ty) {
                        if ($ty == "visitor_count") {
                            $ncustomer = new table_customer();
                            $dnow = date("Y-m-d H:i:s", $start_date);
                            $dnowL24 = date("Y-m-d H:i:s", $end_date);
                            $customer_count = $ncustomer->getCustomerCount($dnow, $dnowL24);
                            $_dt[$ty] = $customer_count;
                            $dtlk[] = "Ziyaretci Sayısı";
                            $dtck[] = "#" . "e7505a";
                        }
                        if ($ty == "sales_count") {
                            $_dt[$ty] = rand(100, 200);
                            $dtlk[] = "Sipariş Sayısı";
                            $dtck[] = "#" . "3598dc";
                        }
                        if ($ty == "sales_onbasket_count") {
                            $_dt[$ty] = rand(500, 1500);
                            $dtlk[] = "Sepete Atılanlar";
                            $dtck[] = "#" . "ffc107";
                        }
                        if ($ty == "return_sales_count") {
                            $_dt[$ty] = rand(0, 10);
                            $dtlk[] = "İade Edilenler";
                            $dtck[] = "#" . "4caf50";
                        }
                    }
                    $dt[] = $_dt;
                }
                $data["chart_xkey"] = "y";
                $data["chart_ykey"] = $data_type;
                $data["chart_color"] = $dtck;
                $data["chart_label"] = $dtlk;
                $data["chart"] = $dt;

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

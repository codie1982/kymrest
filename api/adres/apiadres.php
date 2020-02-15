<?php

header('Content-Type: application/json');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of apisettings
 *
 * @author engin
 */
class apiadres {

    //put your code here
    public function getprovincelistAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                $nadres = new table_adres();
                $_province_list = $nadres->getprovincelist();
                $province_list = array_map(function($item) {
                    return ["label" => ucfirst(strtolower(trim($item->AAilAdi))), "value" => $item->AAilNo];
                }, $_province_list);

                if ($province_list) {
                    $data["province_list"] = $province_list;
                    $data["message"] = "İller Listesi Başarıyla Alındı";
                    $data["error"] = false;
                } else {
                    $data["type"] = "NO_PROVINCE";
                    $data["error"] = true;
                    $data["message"] = "İller Listesine Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function getdiscritlistAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                if (isset($getdata[2])) {
                    $province_id = $getdata[2];
                    $nadres = new table_adres();
                    $_district_list = $nadres->getdistrictlist($province_id);
                    $district_list = array_map(function($item) {
                        if (trim($item->AAilceAdi) != "") {
                            if ($item->AAilceNo != 0) {
                                return ["label" => ucfirst(strtolower(trim($item->AAilceAdi))), "value" => $item->AAilceNo];
                            } else {
                                
                            }
                        }
                    }, $_district_list);

                    $district_list = fix_array_null($district_list);
                    if ($district_list) {
                        $data["district_list"] = $district_list;
                        $data["message"] = "İlçeler Listesi Başarıyla Alındı";
                        $data["error"] = false;
                    } else {
                        $data["type"] = "NO_DISCRIT";
                        $data["error"] = true;
                        $data["message"] = "İlçeler Listesine Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_PROVINCE_ID";
                    $data["error"] = true;
                    $data["message"] = "İl id'si Okunmuyor.";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function getneighborhoodlistAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_GETDATA())) {
                $getdata = data::GET_GETDATA();
                $parameter = data::GET_GETPARAMETER();
                if (isset($getdata[2])) {
                    if (isset($getdata[3])) {
                        $province_id = $getdata[2];
                        $district_id = $getdata[3];
                        // dnd($province_id);
                        // dnd($district_id);
                        $nadres = new table_adres();
                        $_neighborhood_list = $nadres->getneighborhoodlist($province_id, $district_id);
                        $neighborhood_list = array_map(function($item) {
                            if (trim($item->AAmhlKoyAdi) != "") {
                                if ($item->adres_id != 0) {
                                    return ["label" => ucfirst(strtolower(trim($item->AAmhlKoyAdi))), "value" => $item->adres_id];
                                }
                            }
                        }, $_neighborhood_list);
                        $neighborhood_list = fix_array_null($neighborhood_list);
                        if ($neighborhood_list) {
                            $data["neighborhood_list"] = $neighborhood_list;
                            $data["message"] = "Mahalle Listesi Başarıyla Alındı";
                            $data["error"] = false;
                        } else {
                            $data["type"] = "NO_NEIGHBORHOOD";
                            $data["error"] = true;
                            $data["message"] = "Mahalle Listesine Ulaşılamıyor";
                        }
                    } else {
                        $data["type"] = "NO_DISTRICT_ID";
                        $data["error"] = true;
                        $data["message"] = "İlçe id'si Okunmuyor.";
                    }
                } else {
                    $data["type"] = "NO_PROVINCE_ID";
                    $data["error"] = true;
                    $data["message"] = "İl id'si Okunmuyor.";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

}

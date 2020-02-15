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
class slider_images_list extends component {

    public function render($parameter) {
        $this->set_component_name("slider_images_list");
        $this->make_component($parameter["type"]);
    }

    public function new_slider_images_listAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $image_info = $_REQUEST["image_info"];

                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

                if (isset($_REQUEST["dummy"])) {
                    $dummy = $_REQUEST["dummy"];
                }
                component::add_props(
                        [
                            "dummy" => json_decode($dummy),
                        ]
                );


                if (!empty($image_info)) {
                    $nview = new view();

                    $nslider = new table_application_main_slider();
                    $nslider->select();
                    $nslider->select();
                    $sliders = $nslider->get_alldata();
                    $sliders = object_to_array($sliders);
                    $i = 0;
                    if (!empty($sliders))
                        foreach ($sliders as $slider) {
                            $nimage = new table_image_gallery();
                            $nimage->select();
                            $nimage->add_condition("image_gallery_id", $slider["image_gallery_id"]);
                            $sliders[$i]["image_info"] = $nimage->get_alldata(true);
                            $i++;
                        }


                    $nimage = new table_image_gallery();
                    $image_list = $nimage->get_image_from_uniqid($image_info[0]["image_uniqid"]);
                    for ($n = 0; $n < count($image_list); $n++) {
                        $arr[$n] = [
                            "image_info" => $image_list[$n]
                        ];
                    }

                    if (!empty($sliders)) {
                        $result = array_merge($arr, $sliders);
                    } else {
                        $result = $arr;
                    }
                    component::add_props(
                            [
                                "slider_data" => $result,
                            ]
                    );
                    component::import_component("slider_images_list", ["type" => "extension/mobileapp"], true);
                    $nview->add_page(component::get_component_module());


                    $nview->prepare_page();
                    $content = $nview->get_content();


                    $data["starter"] = component::starter($data["tempstarter"]);
                    $data["content"] = $content["slider_images_list"];
                    $data["addtype"] = "html";
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Form verileri alınmıştır..");
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Herhangi bir veri gelmemiştir.");
                }
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Öncelikle Giriş Yapmanız gerekmektedir.");
        }
        if (!empty($nvalidate->get_warning()))
            foreach ($nvalidate->get_warning() as $wr) {
                $data["warning_message"][] = $wr;
            }
        if (!empty($nvalidate->get_success()))
            foreach ($nvalidate->get_success() as $sc) {
                $data["success_message"][] = $sc;
            }
        if (!empty($nvalidate->get_errors()))
            foreach ($nvalidate->get_errors() as $err) {
                $data["error_message"][] = $err;
            }

        echo json_encode($data);
    }

    public function search_productAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $q = input::santize($_REQUEST["q"]);
                $items = [];
                $nproduct = new table_product();
                $nproduct->add_filter("product_id", "id");
                $nproduct->add_filter("product_name", "search_keyword");
                $nproduct->select();
                $nproduct->add_condition("product_name", [
                    "LIKE" => [$q]
                ]);
                $res = $nproduct->get_alldata();
                if (!empty($res)) {
                    foreach ($res as $r) {
                        $items[] = get_object_vars($r);
                    }
                    $data["items"] = $items;
                }
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
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

    public function search_categoryAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $q = input::santize($_REQUEST["q"]);
                $items = [];
                $ncategory = new table_category();
                $ncategory->add_filter("category_id", "id");
                $ncategory->add_filter("category_name", "search_keyword");
                $ncategory->select();
                $ncategory->add_condition("category_name", [
                    "LIKE" => [$q]
                ]);
                $res = $ncategory->get_alldata();
                if (!empty($res)) {
                    foreach ($res as $r) {
                        $items[] = get_object_vars($r);
                    }
                    $data["items"] = $items;
                }
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
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

    public function removeAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $key = input::santize($_POST["key"]);
                if ($key != "") {
                    if (data::remove("application_main_slider", $key)) {
                        $data["sonuc"] = true;
                        $data["msg"] = "Resim Sliderdan Kaldırıldı";
                    } else {
                        $data["sonuc"] = false;
                        $data["msg"] = "Resim Sliderdan Kaldırılmadı. Lütfen Tekrar Deneyiniz";
                    }
                } else {
                    $data["sonuc"] = false;
                    $data["msg"] = "Veri Gelmedi";
                }
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

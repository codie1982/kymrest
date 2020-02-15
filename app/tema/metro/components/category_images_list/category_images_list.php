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
class category_images_list extends component {

    public function render($parameter) {
        $this->set_component_name("category_images_list");
        $this->make_component($parameter["type"]);
    }

    public function new_category_images_listAction() {
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

                    $nimage = new table_image_gallery();

                    $image_list = $nimage->get_image_from_uniqid($image_info[0]["image_uniqid"]);

                    component::add_props(
                            [
                                "image_list" => $image_list,
                            ]
                    );
                    component::import_component("category_images_list", ["type" => "admin"], true);
                    $nview->add_page(component::get_component_module());


                    $nview->prepare_page();
                    $content = $nview->get_content();


                    $data["starter"] = component::starter($data["tempstarter"]);
                    $data["content"] = $content["category_images_list"];
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

}

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
class product_group_fields extends component {

    public function render($parameter) {
        $this->set_component_name("product_group_fields");
        $this->make_component($parameter["type"]);
    }

    public function loadAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $data = $_REQUEST["data"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }
                $selected_category = $_REQUEST["selected_category"]; // array()



                if (!empty($selected_category)) {
                    $ncategory_group_fields = new table_category_group_fields();
                    foreach ($selected_category as $category_id) {
                        $temp[] = $ncategory_group_fields->get_data_main_key($category_id);
                    }
                    $category_group_fields_data = [];
                    foreach ($temp as $tm) {
                        if (!empty($tm)) {
                            foreach ($tm as $t) {
                                if (!search_object($t->group_fields_id, $category_group_fields_data, "group_fields_id")) {
                                    $category_group_fields_data[] = $t;
                                }
                            }
                        }
                    }

                    component::add_props(
                            [
                                "category_group_fields_data" => $category_group_fields_data,
                            ]
                    );
                }


                $nview = new view();

                component::import_component("product_group_fields", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());


                $nview->prepare_page();
                $content = $nview->get_content();

                $data["content"] = $content["product_group_fields"];
                $data["starter"] = component::starter($data["tempstarter"]);
                $data["sonuc"] = true;
                $nvalidate->addSuccess("Form verileri alınmıştır..");
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

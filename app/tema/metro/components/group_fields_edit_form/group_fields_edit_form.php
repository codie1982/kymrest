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
class group_fields_edit_form extends component {

    public function render($parameter) {
        $this->set_component_name("group_fields_edit_form");
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




                $ngroup_fields = new table_group_fields();
                $ngroup_fields->select();
                $group_fileds_info = $ngroup_fields->get_alldata();
                if (!empty($group_fileds_info)) {
                    component::add_props(
                            [
                                "group_fileds_info" => $group_fileds_info,
                            ]
                    );

                    $nview = new view();
                    component::add_props(
                            [
                                "no_content" => false,
                                "addul" => true,
                            ]
                    );



                    component::import_component("group_values", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "group_values" => $content["group_values"],
                            ]
                    );

                    component::import_component("group_fields_form", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "group_fields_form_component" => $content["group_fields_form"],
                            ]
                    );



                    component::import_component("group_fields_edit_form", ["type" => "admin"], true);
                    $nview->add_page(component::get_component_module());


                    $nview->prepare_page();
                    $content = $nview->get_content();

                    $data["content"] = $content["group_fields_edit_form"];
                    $data["starter"] = component::starter($data["tempstarter"]);
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Form verileri alınmıştır..");
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Alana ait veri bulunamamıştır.");
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

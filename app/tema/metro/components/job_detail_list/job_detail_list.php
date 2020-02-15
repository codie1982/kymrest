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
class job_detail_list extends component {

    public function render($parameter) {
        $this->set_component_name("job_detail_list");
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

                $job_id = $_REQUEST["job_id"];

                if (data::update_data("job", ["admin_view" => 1], "job_id", $job_id)) {
                    $data["font"] = "500";
                } else {
                    $data["font"] = "900";
                }

                $job_data = data::allInfo("job", $job_id);
                $job = $job_data["job"];
                component::add_props(["job_data" => $job_data]);

                $ncustomer = new table_customer();
                $ncustomer->select();
                $ncustomer->add_condition("customer_id", $job->customer_id, "=", "customer");
                $ncustomer->add_join("customer_personel", "customer_id");
                $customer_data = $ncustomer->get_alldata(true);

                if ($customer_data = $ncustomer->get_alldata(true)) {
                    component::add_props(["customer_data" => $customer_data]);
                } else {
                    component::add_props(["job_error" => ["Kullanıcı Bilgisine Erişilemiyor"]]);
                }


                $ncustomer_adres = new table_customer_adres();
                $ncustomer_adres->select();
                $ncustomer_adres->add_condition("customer_adres_id", $job->customer_adres_id);
                // $ncustomer_adres->add_condition("public", 1);


                if ($customer_adres_data = $ncustomer_adres->get_alldata(true)) {
                    component::add_props(["customer_adres_data" => $customer_adres_data]);
                } else {
                    component::add_props(["job_error" => ["Kullanıcı Adres Bilgisine Ulaşılamıyor"]]);
                }


                $nview = new view();

                component::import_component("job_detail_list", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["job_detail_list"];
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

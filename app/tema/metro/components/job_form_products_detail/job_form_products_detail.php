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
class job_form_products_detail extends component {

    public function render($parameter) {
        $this->set_component_name("job_form_products_detail");
        $this->make_component($parameter["type"]);
    }

    public function loadAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $data = $_POST["data"];
                if (isset($_POST["modal"])) {
                    $data["modal"] = $_POST["modal"];
                }
                if (isset($_POST["starter"])) {
                    $data["tempstarter"] = $_POST["starter"];
                }

                $selected_product_id = $_POST["selected_product_id"];
                $selected_job_id = $_POST["selected_job_id"];
                $customer_id = $_POST["customer_id"];
                component::add_props(["selected_job_id" => $selected_job_id]);
                component::add_props(["customer_id" => $customer_id]);

                $product_constant = new product_constant();
                $nproduct = new table_product();
                $product_data = data::allInfo("product", $selected_product_id);
                $nimage_gallery = new table_image_gallery();
                $nimage_gallery->select();
                $nimage_gallery->add_condition("image_gallery_id", $product_data["product_gallery"][0]->image_gallery_id);
                $product_image_info = $nimage_gallery->get_alldata(true);

                $nproduct_settings = new table_settings_product();
                $nproduct_settings->select();
                $product_settings = $nproduct_settings->get_alldata(true);

                $nproduct_settings_transport = new table_settings_transport();
                $nproduct_settings_transport->select();
                $product_transport_settings = $nproduct_settings_transport->get_alldata(true);



                $nproduct_module = new product_module();
                $product_price = $nproduct_module->get_product_price($selected_product_id);
                $product_sales_price = $nproduct_module->get_product_sales_price($selected_product_id);

                $product_tax_info = $nproduct_module->get_product_tax_price($selected_product_id);

                component::add_props(["product_tax_price" => $product_tax_info["product_tax_price"]]);
                component::add_props(["product_tax_price_unit" => $product_tax_info["product_tax_price_unit"]]);
                component::add_props(["product_tax_rate" => $product_tax_info["product_tax_rate"]]);
                component::add_props(["product_intax" => $product_tax_info["product_intax"]]);


                component::add_props(
                        [
                            "product_data" => $product_data,
                            "product_price" => $product_price,
                            "product_image_info" => $product_image_info,
                            "product_sales_price" => $product_sales_price,
                            "product_settings" => $product_settings,
                            "product_transport_settings" => $product_transport_settings,
                        ]
                );


              //  $product_payment = $nproduct_module->get_product_payment_method($selected_product_id);
                component::add_props(["payment_method_workable_type" => $product_payment["type"]]);

                if ($product_payment["type"] == $product_constant::constant) {
                    component::add_props(["payment_method" => NODATA]);
                    component::add_props(["product_extra_price" => 0]);
                    component::add_props(["product_extra_price_unit" => NODATA]);
                } else {
                    component::add_props(["payment_info" => $product_payment["payment_method"]]);
                }
              //  $product_delivery_price = $nproduct_module->get_product_transport($selected_product_id);

                component::add_props(["product_delivery_workable_type" => $product_delivery_price["type"]]);

                if ($product_delivery_price["type"] == $product_constant::constant) {
                    component::add_props(["product_delivery_type" => NODATA]);
                    component::add_props(["product_delivery_price" => 0]);
                    component::add_props(["product_delivery_price_unit" => NODATA]);
                    component::add_props(["product_intransportproduct" => -1]);
                } else {
                    component::add_props(["product_delivery_type" => $product_delivery_price["transport_type"]]);
                    component::add_props(["product_delivery_price" => $product_delivery_price["transport_price"]]);
                    component::add_props(["product_delivery_price_unit" => $product_delivery_price["transport_price_unit"]]);
                    component::add_props(["product_intransportproduct" => $product_delivery_price["intransportproduct"]]);
                }



                $nview = new view();

                component::import_component("job_form_products_detail", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["job_form_products_detail"];
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

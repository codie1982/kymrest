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
class product_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("bootstrap-tagsinput");
        $this->add_global_plugin("bootstrap-summernote");
        $this->set_component_name("product_form");
        $this->make_component($parameter["type"]);
    }

    public function add_new_productAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nproduct_constant = new product_constant();
                    $nsettings_product = new table_settings_product();
                    $product_settings = $nsettings_product->get_data();

                    $nprepare_product_data = new prepare_product_data();
                    $control_module = $nprepare_product_data->set_new_product_data($post);
                    $product_data = data::get_data($control_module);
//                    dnd($product_data);
//                    die();
                    if ($product_data["product"]["product_name"] != "") {
                        $nproduct = new table_product();
                        if (!$nproduct->check_product_from_safe_name($product_data["product"]["product_name_sef"])) {
                            $product_gallery_data = data::get_data($control_module, "product_gallery");
                            if (empty($product_gallery_data)) {
                                $nvalidate->addWarning("Ürününüzü Galerisi olmadan eklediniz. Ürününüz için bir galeri girmeyi unutmayın.");
                            }
                            $product_category_data = data::get_data($control_module, "product_category");
                            if (empty($product_category_data)) {
                                $nvalidate->addWarning("Ürününüz için herhangi bir Kategori seçilmedi. Ürününüz için bir kategori seçmeyi unutmayınız.");
                            }
                            //TODO : Ödeme Yöntemi Genel Seçilmemiş ise
                            if ($product_settings->extra_field_workable_type == $nproduct_constant::changeable) {
                                $product_payment_method_data = data::get_data($control_module, "product_payment_method");
                                if (empty($product_payment_method_data)) {
                                    $nvalidate->addWarning("Ürününüz için herhangi bir ödeme yöntemi seçilmedi. Ürününüz için bir ödeme yöntemi seçmeyi unutmayınız.");
                                }
                            }
                        } else {
                            $nvalidate->addError('<strong>' . $product_data["product"]["product_name"] . '</strong> ' . "-" . " İsimli Ürün Daha Önce Girilmiş. Ürün ismini değiştirerek yeniden eklemeyi deneyin");
                        }
                    } else {
                        $nvalidate->addError("Ürün İsmini Boş Bırakmayınız");
                    }
                    //dnd($product_data);
                    if ($nvalidate->passed()) {
                        $nproduct = new table_product();
                        if ($new_product_id = data::insert_data("product", $product_data["product"])) {
                            $secrets = data::get_secret_number($control_module);
                            if (!empty($secrets))
                                foreach ($secrets as $secret) {
                                    data::addextra("product_id", $new_product_id, $control_module, "sub", $secret);
                                }
                            $product_data_temp = data::get_data($control_module);
                            unset($product_data_temp["product"]);
                            if (!empty($product_data_temp))
                                foreach ($product_data_temp as $table_name => $dt) {

                                    if (data::insert_data($table_name, $dt)) {
                                        $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                    } else {
                                        $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                    }
                                }

                            //dnd(data::get_parent_data());
                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                            $nvalidate->addSuccess('<strong>' . $product_data["product_name"] . '</strong>' . " - " . " Ürün Bilgileri Kayıt edildi");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addError("Ürün Bilgileri Kayıt Edilmedi. Lütfen Tekrar deneyiniz.");
                        }
                    } else {
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
                    }
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
            $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
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

    public function remove_productAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id = $_REQUEST["product_id"];
                if (!empty($product_id)) {


                    if (data::removeAll("product", $product_id)) {
                        $data["sonuc"] = true;
                        $data["remove"] = true;
                        $data["parents"] = "tr";
                        $nvalidate->addSuccess("Ürün sistemden kaldırılmıştır.");
                    } else {
                        $data["sonuc"] = false;
                        $nvalidate->addSuccess("Ürün sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
                    }
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

    public function remove_allAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id_value = $_REQUEST["product_id"];
                if (!empty($product_id_value)) {
                    $product_id = explode(",", $product_id_value);
                    if (is_array($product_id)) {
                        foreach ($product_id as $id) {
                            if (data::removeAll("product", $id)) {
                                $res = true;
                            } else {
                                $res = false;
                            }
                        }
                        if ($res) {
                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Ürünler sistemden kaldırılmıştır.");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addSuccess("Ürünlerden bir veya birkısmı sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
                        }
                    }
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

                $nsettings_product = new table_settings_product();
                $product_settings = $nsettings_product->get_data();
                $nsettings_transport = new table_settings_transport();
                $transport_settings = $nsettings_transport->get_data();

                component::add_props(
                        [
                            "product_settings" => $product_settings,
                            "transport_settings" => $transport_settings,
                        ]
                );
                $nview = new view();

                component::import_component("product_images", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "product_images_component" => $content["product_images"],
                        ]
                );


                component::import_component("product_images_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "product_images_list_component" => $content["product_images_list"],
                        ]
                );

                component::import_component("product_category_tree", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "product_category_tree_component" => $content["product_category_tree"],
                        ]
                );

                component::import_component("product_group_fields", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "product_group_fields_component" => $content["product_group_fields"],
                        ]
                );



                component::import_component("product_payment_group", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "product_payment_group_component" => $content["product_payment_group"],
                        ]
                );


//                /*                 * ***********  Fiyat Varyasyonları               * ************* */
                component::import_component("product_price_options", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(
                        [
                            "product_price_options" => $content["product_price_options"],
                        ]
                );
//                /*                 * ***********    Fiyat Varyasyonları            * ************* */


                component::import_component("product_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["product_form"];
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

    public function get_productAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id = $_REQUEST["product_id"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

                if (!empty($product_id)) {

                    $nview = new view();
                    $product_data = data::allInfo("product", $product_id);


                    $nsettings_product = new table_settings_product();
                    $nsettings_product->select();
                    $product_settings = $nsettings_product->get_alldata(true);
                    $nsettings_transport = new table_settings_transport();
                    $nsettings_transport->select();
                    $transport_settings = $nsettings_transport->get_alldata(true);

                    component::add_props(
                            [
                                "product_settings" => $product_settings,
                                "transport_settings" => $transport_settings,
                            ]
                    );

                    component::add_props(
                            [
                                "form_action" => "update_product",
                                "button_text" => "Güncelle",
                                "product_data" => $product_data["product"],
                                "product_transport_data" => $product_data["product_transport"][0],
                                "product_payment_method_data" => $product_data["product_payment_method"],
                                "product_price_group" => $product_data["product_price_group"],
                                "product_price_option" => $product_data["product_price_option"],
                                "product_special_fields_value_data" => $product_data["product_special_fields_value"],
                                "product_category_data" => $product_data["product_category"],
                                "product_gallery_data" => $product_data["product_gallery"],
                            ]
                    );
//*********************************************
                    component::import_component("product_images", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_images_component" => $content["product_images"],
                            ]
                    );
//*********************************************
                    component::import_component("product_images_list", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_images_list_component" => $content["product_images_list"],
                            ]
                    );
//*********************************************
                    component::import_component("product_category_tree", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_category_tree_component" => $content["product_category_tree"],
                            ]
                    );
//*********************************************

                    component::import_component("product_group_fields", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(
                            [
                                "product_group_fields_component" => $content["product_group_fields"],
                            ]
                    );




                    component::import_component("product_payment_group", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_payment_group_component" => $content["product_payment_group"],
                            ]
                    );

                    /*                     * ***********  Ücret Gruplandırma Alanı               * ************* */
//                    component::import_component("product_price_group", ["type" => "admin"]);
//                    $nview->add_page(component::get_component_module());
//                    $nview->prepare_page();
//                    $content = $nview->get_content();
//
//                    component::add_props(
//                            [
//                                "product_price_group" => $content["product_price_group"],
//                            ]
//                    );
                    /*                     * ***********    Ücret Gruplandırma Alanı            * ************* */

//                /*                 * ***********  Fiyat Varyasyonları               * ************* */
                    component::import_component("product_price_options", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(
                            [
                                "product_price_options" => $content["product_price_options"],
                            ]
                    );
//                /*                 * ***********    Fiyat Varyasyonları            * ************* */
                    component::import_component("product_form", ["type" => "admin"], true);
                    $nview->add_page(component::get_component_module());


                    $nview->prepare_page();
                    $content = $nview->get_content();

                    $data["starter"] = component::starter($data["tempstarter"]);
                    $data["content"] = $content["product_form"];
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

    public function get_copy_productAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {

                $product_id = $_REQUEST["product_id"];

                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }

                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

                if (!empty($product_id)) {

                    $nview = new view();
                    $product_data = data::allInfo("product", $product_id);
                    //dnd($product_data);
                    $name = $product_data["product"]->product_name;
                    $product_data["product"]->product_name = $name . " - Kopya";
                    $nsettings_product = new table_settings_product();
                    $nsettings_product->select();
                    $product_settings = $nsettings_product->get_alldata(true);
                    $nsettings_transport = new table_settings_transport();
                    $nsettings_transport->select();
                    $transport_settings = $nsettings_transport->get_alldata(true);

                    component::add_props(
                            [
                                "product_settings" => $product_settings,
                                "transport_settings" => $transport_settings,
                            ]
                    );

                    component::add_props(
                            [
                                "copy" => true,
                                "form_action" => "add_new_product",
                                "button_text" => "Kaydet",
                                "product_data" => $product_data["product"],
                                "product_transport_data" => $product_data["product_transport"][0],
                                "product_payment_method_data" => $product_data["product_payment_method"],
                                "product_price_group" => $product_data["product_price_group"],
                                "product_price_option" => $product_data["product_price_option"],
                                "product_special_fields_value_data" => $product_data["product_special_fields_value"],
                                "product_category_data" => $product_data["product_category"],
                                "product_gallery_data" => $product_data["product_gallery"],
                            ]
                    );
//*********************************************
                    component::import_component("product_images", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_images_component" => $content["product_images"],
                            ]
                    );
//*********************************************
                    component::import_component("product_images_list", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_images_list_component" => $content["product_images_list"],
                            ]
                    );
//*********************************************
                    component::import_component("product_category_tree", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_category_tree_component" => $content["product_category_tree"],
                            ]
                    );
//*********************************************

                    component::import_component("product_group_fields", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(
                            [
                                "product_group_fields_component" => $content["product_group_fields"],
                            ]
                    );




                    component::import_component("product_payment_group", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());

                    $nview->prepare_page();
                    $content = $nview->get_content();

                    component::add_props(
                            [
                                "product_payment_group_component" => $content["product_payment_group"],
                            ]
                    );

                    /*                     * ***********  Ücret Gruplandırma Alanı               * ************* */
//                    component::import_component("product_price_group", ["type" => "admin"]);
//                    $nview->add_page(component::get_component_module());
//                    $nview->prepare_page();
//                    $content = $nview->get_content();
//
//                    component::add_props(
//                            [
//                                "product_price_group" => $content["product_price_group"],
//                            ]
//                    );
                    /*                     * ***********    Ücret Gruplandırma Alanı            * ************* */

//                /*                 * ***********  Fiyat Varyasyonları               * ************* */
                    component::import_component("product_price_options", ["type" => "admin"]);
                    $nview->add_page(component::get_component_module());
                    $nview->prepare_page();
                    $content = $nview->get_content();
                    component::add_props(
                            [
                                "product_price_options" => $content["product_price_options"],
                            ]
                    );
//                /*                 * ***********    Fiyat Varyasyonları            * ************* */
                    component::import_component("product_form", ["type" => "admin"], true);
                    $nview->add_page(component::get_component_module());


                    $nview->prepare_page();
                    $content = $nview->get_content();

                    $data["starter"] = component::starter($data["tempstarter"]);
                    $data["content"] = $content["product_form"];
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

    public function update_productAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

                    $nprepare_product_data = new prepare_product_data();
                    $control_module = $nprepare_product_data->set_new_product_data($post);
                    $product_data = data::get_data($control_module);


                    if ($product_data["product"]["product_name"] != "") {
                        $nproduct = new table_product();
                        $nproduct->select();
                        $nproduct->add_condition("product_name_sef", $product_data["product"]["product_name_sef"]);
                        if ($search_data = $nproduct->get_alldata(true)) {
                            if ($product_data["product"]["product_id"] != $search_data->product_id) {
                                $nvalidate->addError('<strong>' . $product_data["product"]["product_name"] . '</strong> ' . "-" . " Bu isimde bir ürün bulunmaktadır. Bu ürünü düzenlemek için farklı bir isim seçmeyi deneyin");
                            }

                            if (empty($product_data["product_gallery"])) {
                                $nvalidate->addWarning("Ürününüzü Galerisi olmadan eklediniz. Ürününüz için bir galeri girmeyi unutmayın.");
                            }
                            if (isset($product_data["product_category"]) && empty($product_data["product_category"])) {
                                $nvalidate->addWarning("Ürününüz için herhangi bir Kategori seçilmedi. Ürününüz için bir kategori seçmeyi unutmayınız.");
                            }
                            if (isset($product_data["product_payment_method"]) && empty($product_data["product_payment_method"])) {
                                $nvalidate->addWarning("Ürününüz için herhangi bir ödeme yöntemi seçilmedi. Ürününüz için bir ödeme yöntemi seçmeyi unutmayınız.");
                            }
                        }
                    } else {
                        $nvalidate->addError("Ürün İsmini Boş Bırakmayınız");
                    }


                    if ($nvalidate->passed()) {
                        $nproduct = new table_product();
                        if (data::insert_data("product", $product_data["product"])) {
                            $secrets = data::get_secret_number($control_module);
                            foreach ($secrets as $secret) {
                                data::addextra("product_id", $product_data["product"]["product_id"], $control_module, "sub", $secret);
                            }
                            $product_data_temp = data::get_data($control_module);
                            unset($product_data_temp["product"]);


                            foreach ($product_data_temp as $table_name => $dt) {
                                if (data::insert_data($table_name, $dt)) {



                                    $nvalidate->addSuccess($table_name . " alt tablo eklendi");
                                } else {
                                    $nvalidate->addWarning($table_name . " alt tablo eklenmedi");
                                }
                            }

                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                            $nvalidate->addSuccess("Ürün bilgileri güncellendi");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addError("Ürün Bilgileri güncellenmedi. Lütfen Tekrar deneyiniz.");
                        }
                    } else {
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
                    }
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
            $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
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

    public function pause_productAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id = $_REQUEST["product_id"];
                if (!empty($product_id)) {
                    if (data::update_data("product", ["public" => 0], "product_id", $product_id)) {
                        $data["sonuc"] = true;
                        //$data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                        $nvalidate->addSuccess("Ürün yayından kaldırılmıştır");
                    } else {
                        $data["sonuc"] = true;
                        //  $data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                        $nvalidate->addSuccess("Ürün yayından kaldırılılamamıştır. Lütfen tekrar deneyiniz.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Ürüne Ulaşılamıyor. Bu ürün büyük ihtimalle silimnmiştir.");
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

    public function public_productAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id = $_REQUEST["product_id"];
                if (!empty($product_id)) {
                    if (data::update_data("product", ["public" => 1], "product_id", $product_id)) {
                        $data["sonuc"] = true;
                        //$data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                        $nvalidate->addSuccess("Ürün tekrardan yayına alınmıştır");
                    } else {
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Üyün yayına alınamamıştır. Lütfen tekrardan deneyiniz.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Ürüne Ulaşılamıyor. Bu ürün büyük ihtimalle silimnmiştir.");
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

    public function add_favoriteAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id = $_REQUEST["product_id"];
                if (!empty($product_id)) {
                    if (data::update_data("product", ["favorite" => 1], "product_id", $product_id)) {
                        $data["sonuc"] = true;
                        //$data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                        $nvalidate->addSuccess("Ürün Favorilere Eklenmiştir");
                    } else {
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Üyün Favorilere Eklenememiştir. Lütfen tekrardan deneyiniz.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Ürüne Ulaşılamıyor. Bu ürün büyük ihtimalle silimnmiştir.");
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

    public function remove_favoriteAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $product_id = $_REQUEST["product_id"];
                if (!empty($product_id)) {
                    if (data::update_data("product", ["favorite" => 0], "product_id", $product_id)) {
                        $data["sonuc"] = true;
                        //$data["recomponent"][] = ["component_name" => "product_table", "component_action" => "load"];
                        $nvalidate->addSuccess("Ürün Favorilerinizden çıkarılmıştır");
                    } else {
                        $data["sonuc"] = true;
                        $nvalidate->addSuccess("Üyün Favorilerinizden çıkarılmamıştır. Lütfen tekrardan deneyiniz.");
                    }
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addError("Ürüne Ulaşılamıyor. Bu ürün büyük ihtimalle silimnmiştir.");
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

    public function remove_groupAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $key = $_REQUEST["key"];
                if (data::removeAll("product_price_group", $key)) {
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Group Kaldırılmıştır.");
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addSuccess("Group sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
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

    public function remove_group_itemAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $key = $_REQUEST["key"];
                if (data::removeAll("product_price_option", $key)) {
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Group Item Kaldırılmıştır.");
                } else {
                    $data["sonuc"] = false;
                    $nvalidate->addSuccess("Group Item sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
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

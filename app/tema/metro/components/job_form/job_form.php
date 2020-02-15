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
class job_form extends component {

    public function render($parameter) {
        //  $this->add_global_plugin("selecttw");
        $this->set_component_name("job_form");
        $this->make_component($parameter["type"]);
    }

    public function add_new_jobAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {
                    $nprepare_job_data = new prepare_job_data();
                    $control_module = $nprepare_job_data->set_new_job_data($post);
                    $job_data = data::get_data($control_module);

                  
                    $newone = true;
                    if ($job_data["job"]["customer_id"] == 0) {
                        $nvalidate->addError("Yeni Bir İş Oluşturmak için bir Kullanıcı Seçin");
                    }

                    $njob = new table_job();
                    $njob->add_filter("job_id");
                    $njob->select();
                    $njob->add_condition("customer_id", $job_data["job"]["customer_id"]);
                    $njob->add_condition("complete", 0);
                    $njob->add_condition("job_number", "-1");
                    $njob_data = $njob->get_alldata(true);
                    if (!empty($njob_data)) {
                        $newone = false;
                        $nvalidate->addWarning("Kullanıcının açık kartı üzerine kayıt yapılacak");
                    }

                    if ($nvalidate->passed()) {
                        if ($newone) {
                            $nproduct = new table_product();
                            if ($jobid = data::insert_data("job", $job_data["job"])) {
                                $data["sonuc"] = true;
                                $data["recomponent"][] = ["component_name" => "job_id", "component_action" => "load", "component_object" => ["selected_job_id" => $jobid]];
                                $data["recomponent"][] = ["component_name" => "job_short_table", "component_action" => "load"];

                                $nvalidate->addSuccess("Sipariş Kartı Kayıt Edildi");
                            } else {
                                $data["sonuc"] = false;
                                $nvalidate->addError("Sipariş Kartı Kayıt Edilmedi. Lütfen Tekrar deneyiniz.");
                            }
                        } else {
                            $jobid = $njob_data->job_id;

                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "job_id", "component_action" => "load", "component_object" => ["selected_job_id" => $jobid]];
                            $data["recomponent"][] = ["component_name" => "job_short_table", "component_action" => "load"];
                            $data["recomponent"][] = ["component_name" => "job_products_list", "component_action" => "load", "component_object" => ["job_id" => $jobid]];

                            $nvalidate->addSuccess("Sipariş Kartı Kayıtlı Kullanıcı Üzerine Kayıt Edildi");
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

    public function add_new_job_productAction($param = "") {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                parse_str($_POST["formdata"], $post);
                if (!empty($post)) {

//                    dnd($post);

                    $nprepare_job_products_data = new prepare_job_products_data();
                    $control_module = $nprepare_job_products_data->set_new_job_products_data($post);
                    $job_products_data = data::get_data($control_module);
                    $job_id = data::find_fields("job_id", $job_products_data);
                    $customer_id = data::find_fields("customer_id", $job_products_data);
                    $product_id = data::find_fields("product_id", $job_products_data);

//                    dnd($job_products_data);
//                    die();


                    if ($job_id == "" || $job_id == 0) {
                        $nvalidate->addError("Öncelikle İş Kartı Oluşturmalısınız");
                    } else {
                        if ($customer_id == "" || $customer_id == 0) {
                            $nvalidate->addError("Bu İş Kartının Kullanıcısı Bulunmamaktadır.");
                        } else {
                            if ($product_id == "" || $product_id == 0) {
                                $nvalidate->addError("Seçili Ürün Bulunmamaktadır.");
                            } else {
                                //TODO : bu işin ve özelliklerinin aynısının daha önce girilip girilmediğini bulmamız gerekli
                                //Eğer bu kart ürünün ay nözelliklerde bir kopyası girilmiş iseadet değerine eklenmeli
                            }
                        }
                    }

//                    $nproduct = new table_product();
//                    if (!$nproduct->check_product_from_safe_name($product_data["product"]["product_name_sef"])) {
//                        $product_gallery_data = data::get_data($control_module, "product_gallery");
//                        if (empty($product_gallery_data)) {
//                            $nvalidate->addWarning("Ürününüzü Galerisi olmadan eklediniz. Ürününüz için bir galeri girmeyi unutmayın.");
//                        }
//                        $product_category_data = data::get_data($control_module, "product_category");
//                        if (empty($product_category_data)) {
//                            $nvalidate->addWarning("Ürününüz için herhangi bir Kategori seçilmedi. Ürününüz için bir kategori seçmeyi unutmayınız.");
//                        }
//                        //TODO : Ödeme Yöntemi Genel Seçilmemiş ise
//                        if ($product_settings->extra_field_workable_type == $nproduct_constant::changeable) {
//                            $product_payment_method_data = data::get_data($control_module, "product_payment_method");
//                            if (empty($product_payment_method_data)) {
//                                $nvalidate->addWarning("Ürününüz için herhangi bir ödeme yöntemi seçilmedi. Ürününüz için bir ödeme yöntemi seçmeyi unutmayınız.");
//                            }
//                        }
//                    } else {
//                        $nvalidate->addError('<strong>' . $product_data["product"]["product_name"] . '</strong> ' . "-" . " İsimli Ürün Daha Önce Girilmiş. Ürün ismini değiştirerek yeniden eklemeyi deneyin");
//                    }





                    if ($nvalidate->passed()) {
                        if (!empty($job_products_data)) {
                            foreach ($job_products_data as $table_name => $dt) {
                                if (data::insert_data($table_name, $dt)) {
                                    $nvalidate->addSuccess($table_name . " tablo eklendi");
                                } else {
                                    $nvalidate->addWarning($table_name . " tablo eklenmedi");
                                }
                            }
                            $data["sonuc"] = true;
                            $data["recomponent"][] = ["component_name" => "job_products_list", "component_action" => "load", "component_object" => ["job_id" => $job_id]];
                            $nvalidate->addSuccess('<strong>' . $product_data["product_name"] . '</strong>' . " - " . " Ürün Sipariş Kartına Eklendi");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addError("Ürün Sipariş Kartına Eklenmedi. Lütfen Tekrar deneyiniz.");
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

    public function remove_jobAction() {
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

                $nproduct_setting = new table_settings_product();
                $nproduct_setting->select();
                $prodcut_settings = $nproduct_setting->get_alldata(true);
                $nproduct_transport_setting = new table_settings_transport();
                $nproduct_transport_setting->select();
                $product_transport_setting = $nproduct_transport_setting->get_alldata(true);


                component::add_props(["prodcut_settings" => $prodcut_settings]);
                component::add_props(["product_transport_setting" => $product_transport_setting]);

                $nview = new view();

                component::import_component("job_products_list", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["job_products_list" => $content["job_products_list"]]);

                component::import_component("job_form_products_detail", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["job_form_products_detail" => $content["job_form_products_detail"]]);

                component::import_component("job_new", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["job_new" => $content["job_new"]]);

                component::import_component("job_id", ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();
                component::add_props(["job_id" => $content["job_id"]]);

                component::import_component("job_form", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());
                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["job_form"];
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

    public function update_jobAction($param = "") {
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
                        if ($nproduct->get_alldata(true)) {
                            if (empty($product_data["product_gallery"])) {
                                $nvalidate->addWarning("Ürününüzü Galerisi olmadan eklediniz. Ürününüz için bir galeri girmeyi unutmayın.");
                            }
                            if (isset($product_data["product_category"]) && empty($product_data["product_category"])) {
                                $nvalidate->addWarning("Ürününüz için herhangi bir Kategori seçilmedi. Ürününüz için bir kategori seçmeyi unutmayınız.");
                            }
                            if (isset($product_data["product_payment_method"]) && empty($product_data["product_payment_method"])) {
                                $nvalidate->addWarning("Ürününüz için herhangi bir ödeme yöntemi seçilmedi. Ürününüz için bir ödeme yöntemi seçmeyi unutmayınız.");
                            }
                        } else {
                            $nvalidate->addError('<strong>' . $product_data["product"]["product_name"] . '</strong> ' . "-" . " Bu isimde bir ürün bulunmamaktadır. Bu ürünü Ürün ekle kısmından yeni ürün olarak eklemeyi deneyin");
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

    public function search_customerAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if (data::ISSET_GETDATA()) {
                // $getdata = input::santize($_GET["q"]);
                $getdata = data::GET_GETPARAMETER();
                $q = $getdata["q"];
                $items = [];
                $ncustomer_personel = new table_customer_personel();
                $ncustomer_personel->select();
                $ncustomer_personel->add_join("customer", "customer_id");
                $ncustomer_personel->add_condition("public", "1", "=", "customer");
                $ncustomer_personel->add_condition("sales", "1", "=", "customer");
                $ncustomer_personel->add_condition("name", [
                    "LIKE" => [$q]
                ]);
                $items = $ncustomer_personel->get_alldata();
                // dnd($items);
                // Eğer Data Yok ise Şirket Durumuna da bakmak lazım
                if (!empty($items)) {
                    foreach ($items as $item) {
                        $result[] = ["id" => $item->customer_id, "search_keyword" => $item->name . " " . $item->lastname];
                    }
                } else {
                    $result[] = ["id" => 0, "search_keyword" => "Kayıtlı Kullanıcı Bulunmamaktadır."];
                }

                $data["items"] = $result;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Oturumunuz Açık Değil";
        }
        echo json_encode($data);
    }

    public function search_productAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if (data::ISSET_GETDATA()) {

                $q = $_REQUEST["q"];
                $items = [];
                $nproduct = new table_product();
                $nproduct->add_filter("product_id");
                $nproduct->add_filter("product_name");
                $nproduct->select();

                $nproduct->add_condition("product_name", ["LIKE" => $q]);
                $nproduct->add_condition("public", "1");
                $nproduct->add_condition("product_type", "standart");
                if ($q == "") {
                    $nproduct->add_limit_start(10);
                }
                $items = $nproduct->get_alldata();
                //$nproduct->show_sql();
                // dnd($items);

                if (!empty($items)) {
                    foreach ($items as $item) {
                        $result[] = ["id" => $item->product_id, "search_keyword" => $item->product_name];
                    }
                } else {
                    $result[] = ["id" => 0, "search_keyword" => "Herhangi Bir Ürün Bulunamamıştır"];
                }

                $data["items"] = $result;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Oturumunuz Açık Değil";
        }
        echo json_encode($data);
    }

}

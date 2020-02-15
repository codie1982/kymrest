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
class library_content extends component {

    public function render($parameter) {
        $this->set_component_name("library_content");
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


                if ($_REQUEST["data"][0] != "empty") {
                    $selected_date = isset($_REQUEST["selected_date"]) ? $_REQUEST["selected_date"] : null;
                    $selected_count = isset($_REQUEST["selected_count"]) ? $_REQUEST["selected_count"] : null;
                    $selected_page_number = isset($_REQUEST["selected_page_number"]) ? $_REQUEST["selected_page_number"] : null;
                }

                component::add_props(["selected_date" => $selected_date, "selected_count" => $selected_count, "selected_page_number" => $selected_page_number]);
                $nimage_gallery = new table_image_gallery();
                $nimage_gallery->select();
                if ($selected_count == "all") {
                    
                } else {
                    $start = ($selected_page_number - 1) * $selected_count;
                    $end = ($selected_page_number) * $selected_count;
                    $nimage_gallery->add_limit_start($start);
                    $nimage_gallery->add_limit_end($end);
                }
                $now = strtotime("now");
                switch ($selected_date) {
                    case"all":
                        break;
                    case"today":
                        $start_date = $now;
                        $end_date = $now - ((24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;
                    case"yesterday":
                        $start_date = $now - ((24) * ONE_HOUR);
                        $end_date = $now - ((2 * 24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;
                    case"last7":
                        $start_date = $now - ((24) * ONE_HOUR);
                        $end_date = $now - ((7 * 24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;

                    case"last14":
                        $start_date = $now - ((24) * ONE_HOUR);
                        $end_date = $now - ((14 * 24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;
                    case"last30":
                        $start_date = $now - ((24) * ONE_HOUR);
                        $end_date = $now - ((30 * 24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;
                    case"last60":
                        $start_date = $now - ((24) * ONE_HOUR);
                        $end_date = $now - ((60 * 24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;
                    case"last90":
                        $start_date = $now - ((24) * ONE_HOUR);
                        $end_date = $now - ((90 * 24) * ONE_HOUR);
                        $nimage_gallery->add_condition("date", [
                            "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                        ]);
                        break;
                }

                $gallery_data = $nimage_gallery->get_alldata();
//                $nimage_gallery->show_sql();
//                $nimage_gallery->show_where_value();
                // die();

                $nimage_gallery_count = new table_image_gallery();
                $nimage_gallery_count->set_count();
                $nimage_gallery_count->select();
                $total_gallery_count = $nimage_gallery_count->get_alldata(true);



                component::add_props(
                        [
                            "gallery_data" => $gallery_data,
                            "total_gallery_data" => $total_gallery_count,
                            "selected_date" => "all",
                            "page_number" => $selected_page_number,
                            "page_count" => $selected_count,
                            "start" => $start,
                            "end" => $end,
                            "view" => "image_list",
                            "image_type" => "all"
                        ]
                );


                $nview = new view();

                component::import_component("library_content", ["type" => "admin"], true);
                $nview->add_page(component::get_component_module());

                $nview->prepare_page();
                $content = $nview->get_content();


                $data["content"] = $content["library_content"];
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

    public function removeAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $gallery_image_id = $_REQUEST["gallery_image_id"];
                if (!empty($gallery_image_id)) {
                    if (is_array($gallery_image_id)) {
                        foreach ($gallery_image_id as $mediaid) {
                            if (data::removeMedia("image_gallery", $mediaid)) {
                                $res = true;
                            } else {
                                $res = false;
                            }
                        }
                        if ($res) {
                            $data["sonuc"] = true;
                            $nvalidate->addSuccess("Medya dosyalarınız sistemden tamamen kaldırılmıştır.");
                        } else {
                            $data["sonuc"] = false;
                            $nvalidate->addSuccess("Medya dosyalarınız sistemden kaldırılmamıştır. Lütfen tekrar deneyin.");
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

}

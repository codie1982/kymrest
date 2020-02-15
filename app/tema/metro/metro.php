<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of metro
 *
 * @author engin
 */
class metro {

    public $template_component_list = [];

    //put your code here
    public function __construct() {
        
    }

    public function get_component_list($type = "standart") {
        switch ($type) {
            case"standart":
                $this->template_component_list = ["sidebar", "breacrumb", "page_title", "navigation_bar", "waiting_screen", "general_message", "footer"];
                break;
            case"login":
                break;
            case"config":
                break;
            default :
                break;
        }

        return $this->template_component_list;
    }

    public function set_template($content, $row = "", $type = "standart") {

        switch ($type) {
            case"standart":
                $wrapper .= $content["general_message"];
                $wrapper .= html::add_div(["class" => "page-sidebar-wrapper"], $content["sidebar"]);
                $outside = $content["breadcrumb"];
                $outside .= $content["page_title"];
                $outside .= $row;
                $wrapper .= html::add_div(["class" => "page-content-wrapper"], html::add_div(["class" => "page-content"], $outside));
                $page_container = $content["navigation_bar"];
                $page_container .= $content["waiting_screen"];
                $page_container .= html::add_div(["class" => "page-container"], $wrapper);
                return $page_container;
                break;
            case"login":
                $page_container .= html::add_div(["class" => "login"], $row);
                return $page_container;
                break;
            case"confirm":
                return html::add_div(["style" => "background-color:#fff"], $row);
                break;
            case"register":
                $page_container .= html::add_div(["class" => "login"], $row);
                return $page_container;
                break;
            default :
                $wrapper .= $content["general_message"];
                $wrapper .= html::add_div(["class" => "page-sidebar-wrapper"], $content["sidebar"]);
                $outside = $content["breadcrumb"];
                $outside .= $content["page_title"];
                $outside .= $row;
                $wrapper .= html::add_div(["class" => "page-content-wrapper"], html::add_div(["class" => "page-content"], $outside));
                $page_container = $content["navigation_bar"];
                $page_container .= $content["waiting_screen"];
                $page_container .= html::add_div(["class" => "page-container"], $wrapper);
                return $page_container;
                break;
        }

//**********Önemli***********
//        $filePath = "map.txt";
//        $delimiter = "\t";
//
//        $file = new \SplFileObject($filePath);
//        while (!$file->eof()) {
//            $line = $file->fgetcsv($delimiter);
//            dnd($line);
//        }
//        die();
//**********Önemli***********
    }

    public function create_tema() {
        tema::add_meta('http-equiv="Content-Type" content="text/html; charset=utf-8"');
        tema::add_css("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all");
        $tema_plugin = [
            "jquery",
            "jquery-ui",
            "bootstrap",
            "font-awesome",
            "bootstrap-hover-dropdown",
            "jquery-slimscroll",
            "jquery.blockui",
            "bootstrap-switch",
            "bootstrap-toastr",
            "js.cookie",
            "socket.io",
            "component_maker",
            "data_table",
            "html_block",
            "malsup",
            "image_upload_plugin",
            "makexhr",
            "component_run",
        ];
        tema::add_global_plugin($tema_plugin);

        $tema_global_css = [
            "components.min",
            "plugins.min",
            "system.min"
        ];
        tema::add_global_css($tema_global_css);

        $tema_global_scripts = [
            "app.min",
            "form",
        ];
        tema::add_global_script($tema_global_scripts);

        $tema_layout_css = [
            "layout.min",
            "darkblue",
            "custom.min",
        ];
        tema::add_layout_css($tema_layout_css);

        $tema_page_scripts = [
            "page-dashboard"
        ];
        tema::add_page_script($tema_page_scripts);

        $tema_layout_scripts = [
            "layout.min",
        ];
        tema::add_layout_scripts($tema_layout_scripts);
    }

}

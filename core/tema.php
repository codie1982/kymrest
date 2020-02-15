<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tema
 *
 * @author engin
 */
class tema {

    public static $tema_meta = array();
    public static $tema_link = array();
    public static $tema_font = array();
    public static $tema_css = array();
    public static $tema_javascript = array();
    public static $tema_json = array();
    public static $tema_content = array();
    public static $tema_components = array();
    public static $tema_html = array();
    public static $tema = array();
    public static $tema_dispatch = array();
    public static $selected_tema;
    public static $selected_templete;
    public static $plugin_file_list = array();
    public static $plugin_path_list = array();
    public static $layout;
    public static $global_javascript_list = array();
    public static $row;
    private static $selected_controller;
    public static $prerow = array();
    public static $prediv = array();
    public static $precol = array();

//put your code here

    public function __construct() {
        return true;
    }

    public static function set_selected_tema($tema) {
        self::$selected_tema = $tema;
        self::set_layout();
    }

    public static function set_selected_controller($controller) {
        self::$selected_controller = $controller;
    }

    public static function set_selected_template($templete) {
        self::$selected_templete = $templete;
    }

    public static function set_layout() {
        self::$tema_dispatch = new self::$selected_tema();
        call_user_func_array([self::$tema_dispatch, "create_tema"], []);
    }

    public static function add_global_plugin($plugin_list) {

        self::$plugin_path_list = [];

//dnd(count($plugin_list));
//  dnd($plugin_list);
//dnd(component::get_component_module());
        if (is_array($plugin_list)) {
            if (!empty($plugin_list)) {
                arrtolist::cleanList();
                foreach ($plugin_list as $plugin) {
                    if ($plugin != "") {

                        if ($global_plugin_path = self::search_global_plugin_path($plugin)) {
                            $global_plugin_dir = "";
// dnd($global_plugin_path);
                            $global_plugin_dir = dirToInside($global_plugin_path);
                            if (!empty($global_plugin_dir)) {
// dnd($count++);
                                self::$plugin_path_list[$plugin] = $global_plugin_dir;
                            }
                        }
                    }
                }
            }
        } else {
            if ($plugin_list != "")
                if ($global_plugin_path = self::search_global_plugin_path($plugin_list)) {
                    $global_plugin_dir = dirToInside($global_plugin_path);
                    if (!empty($global_plugin_dir))
                        self::$plugin_path_list[$plugin] = $global_plugin_dir;
                }
        }
// dnd(self::$plugin_path_list);
        arrtolist::cleanList();
        _arrayToList(self::$plugin_path_list);
        $file_list = (arrtolist::get_List());
        self::add_files_page($file_list);
    }

    public static function add_files_page($file_list) {
//dnd($file_list);
        foreach ($file_list as $paths) {
            if (!empty($paths)) {
                foreach ($paths as $path) {
                    $extension = self::sepereta_data($path);
                    self::correct_data($extension, $path);
                }
            }
        }
    }

    public static function add_global_css($css_list) {
//assets/global/css/components.min.css
        foreach ($css_list as $css) {
            $global_css_file = ROOT . DS . "assets" . DS . "global" . DS . 'css' . DS . $css . DOT . "css";
            $global_css_path = PROOT . "assets" . DS . "global" . DS . 'css' . DS . $css . DOT . "css";

            if (is_file($global_css_file)) {
                self::correct_data("css", $global_css_path);
            }
        }
    }

    public static function add_layout_css($css_list) {
//assets/layouts/layout/css/layout.min.css

        foreach ($css_list as $css) {
            $global_css_file = ROOT . DS . "assets" . DS . "layouts" . DS . modules::getModuleList("admin") . DS . 'css' . DS . $css . DOT . "css";
            $global_css_path = PROOT . "assets" . DS . "layouts" . DS . modules::getModuleList("admin") . DS . 'css' . DS . $css . DOT . "css";

            if (is_file($global_css_file)) {
                self::correct_data("css", $global_css_path);
            }
        }
    }

    public static function add_global_script($javascript_list) {
//assets/global/scripts/app.js
        self::$global_javascript_list = $javascript_list;
        foreach ($javascript_list as $js) {
            $global_js_file = ROOT . DS . "assets" . DS . "global" . DS . 'scripts' . DS . $js . DOT . "js";
            $global_js_path = PROOT . "assets" . DS . "global" . DS . 'scripts' . DS . $js . DOT . "js";
            if (is_file($global_js_file)) {
                self::correct_data("js", $global_js_path);
            }
        }
    }

    public static function get_global_javascript_list() {
        return self::$global_javascript_list;
    }

    public static function add_layout_scripts($javascript_list) {
//assets/layouts/layout/scripts/layout.min.js
        foreach ($javascript_list as $js) {
            $page_js_file = ROOT . DS . "assets" . DS . "layouts" . DS . modules::getModuleList("admin") . DS . 'scripts' . DS . $js . DOT . "js";
            $page_js_path = PROOT . "assets" . DS . "layouts" . DS . modules::getModuleList("admin") . DS . 'scripts' . DS . $js . DOT . "js";

            if (is_file($page_js_file)) {
                self::correct_data("js", $page_js_path);
            }
        }
    }

    public static function add_page_script($javascript_list) {
//assets/pages/scripts/html-block.js
        foreach ($javascript_list as $js) {
            $page_js_file = ROOT . DS . "assets" . DS . "pages" . DS . 'scripts' . DS . $js . DOT . "js";
            $page_js_path = PROOT . "assets" . DS . "pages" . DS . 'scripts' . DS . $js . DOT . "js";
            if (is_file($page_js_file)) {
                self::correct_data("js", $page_js_path);
            }
        }
    }

    public static function sepereta_data($file) {
        $extension = self::get_file_extention($file);
        if ($extension !== "") {
            return $extension;
        }
    }

    public static function correct_data($extension, $file) {
        switch ($extension) {
            case"css":
                self::add_css($file, false);
                break;
            case"js":
                self::add_javascript($file, false);
                break;
            case"json":
                self::add_json($file, false);
                break;
        }
    }

    public static function search_global_plugin($plugin_name) {
        $result = [];
        $file = ROOT . DS . 'assets' . DS . 'global' . DS . 'plugins' . DS . $plugin_name;
        if (is_dir($file)) {
            return $file;
        } else {
            return false;
        }
    }

    public static function search_global_plugin_path($plugin_name) {
        $result = [];
        $file = ROOT . DS . 'assets' . DS . 'global' . DS . 'plugins' . DS . $plugin_name;
        $path = PROOT . 'assets' . DS . 'global' . DS . 'plugins' . DS . $plugin_name;
        if (is_dir($file)) {
            return $path;
        } else {
            return false;
        }
    }

    public static function find_min($file_list) {
        $file_name_temp = [];
        $refile_name_temp = [];
        $file_extention_temp = [];

        if (count($file_list) > 1) {
            for ($i = 0; $i < count($file_list); $i++) {
                $file_items = self::get_file_path_item($file_list[$i]);
                $last_item = end($file_items);
                $file_extention_temp[] = self::get_file_extention($last_item);
                $file_name_temp[] = self::get_file_name($last_item);
                $refile_name_temp[] = $last_item;
            }
            $delete_index = [];
            for ($i = 0; $i < count($file_name_temp); $i++) {
                if (!empty($file_name_temp[$i])) {
                    $src = $file_name_temp[$i] . DOT . "min" . DOT . $file_extention_temp[$i];
                    if (in_array($src, $refile_name_temp)) {
                        $delete_index[] = $i;
                    }
                }
            }

            foreach ($delete_index as $index) {
                unset($file_list[$index]);
            }
            return $file_list;
        }
    }

    static function get_file_name_from_path($file_path) {

        $ex = explode("/", $file_path);
        $name = end($ex);

        return self::get_file_name($name);
    }

    static function get_file_name($file_name) {
        $ex = explode(".", $file_name);
        $lstid = count($ex) - 1;
        unset($ex[$lstid]);
        return implode(".", $ex);
    }

    static function get_file_extention($file_name) {

        $ex = explode(".", $file_name);
        if (!empty($ex)) {
            if (count($ex) > 1) {
                return end($ex);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    static function get_file_path_item($item) {
        $ex = explode("/", $item);
        return $ex;
    }

    protected function add_content($content, $relative_path = true) {
        self::$tema_content[] = $content;
        self::combine_tema("content", self::$tema_content);
    }

    public static function add_meta($meta, $relative_path = true) {
        self::$tema_meta[] = $meta;
        self::combine_tema("meta", self::$tema_meta);
    }

    public static function add_link($link, $relative_path = true) {
        self::$tema_link[] = $link;
        self::combine_tema("link", self::$tema_link);
    }

    public static function add_font($font, $relative_path = true) {
        self::$tema_font[] = $font;
        self::combine_tema("font", self::$tema_font);
    }

    public static function add_css($css, $relative_path = true) {
        self::$tema_css[] = $css;

        self::combine_tema("css", self::$tema_css);
    }

    public static function add_javascript($javascript, $relative_path = true) {
        self::$tema_javascript[] = $javascript;
        self::combine_tema("js", self::$tema_javascript);
    }

    public static function add_json($json, $relative_path = true) {
        self::$tema_json[] = $json;

        self::combine_tema("json", self::$tema_json);
    }

    public static function add_html($html) {
        self::$tema_html[] = $html;
        self::combine_tema("html", self::$tema_html);
    }

    public static function combine_tema($type, $file) {
        self::$tema[$type] = $file;
    }

    public static function get_tema($type = "") {
        $tm = [];
        foreach (self::$tema as $key => $_tm) {
            $tm[$key] = array_unique(find_min($_tm));
        }
        if ($type != "") {
            return $tm[$type];
        } else {
            return $tm;
        }
    }

    public static function clean($array, $clean_index) {
        foreach ($clean_index as $indx) {
            unset($array[$indx]);
        }
        return;
    }

    private function fixcombine_tema($type, $module) {
        self::$component_module[$type] = $module;
    }

    public static function get_template_code($type = "admin") {
        return modules::getModuleList($type);
    }

    public static function set_template() {

        $page_container = "";
        // $usetema = self::get_template_code(self::$selected_tema);
        //    $ntemplate = new self::$selected_tema();
        $components = self::$tema_dispatch->get_component_list(self::$selected_templete);
        // $ntemplate->create_tema();
        //$result = call_user_func_array([$dispatch, "create_tema"], []);
        $nview = new view();

        if (!empty($components))
            foreach ($components as $component) {
                component::import_component($component, ["type" => "admin"]);
                $nview->add_page(component::get_component_module());
            }

        $extentions = modules::getExtensions();
        if (!empty($extentions))
            foreach ($extentions as $starterclass => $extention) {
                if (class_exists($starterclass)) {
                    $cls = new $starterclass();
                    if (method_exists($cls, add_component)) {
                        $extention_components = $cls->add_component(self::$selected_controller);
                        foreach ($extention_components as $extention_component) {
                            $component_name = $extention_component["component_name"];
                            $component_position = $extention_component["position"];
                            component::import_component($component_name, ["type" => $extention_component["type"]]);
                            $nview->add_page(component::get_component_module());
                            $nview->prepare_page();
                            $content = $nview->get_content();
                            tema::extention_row($component_position, $content[$component_name]);
                        }
                    }
                }
            }
        //TODO:: Burada Sıkıntı Büyük!!!


        $nview->prepare_page();
        $content = $nview->get_content();
        $nview->set_page_html();
        $row = self::makerow();

        return self::$tema_dispatch->set_template($content, $row, self::$selected_templete);
    }

    public static function addrow() {
        self::$prerow[] = self::$precol;
        self::$precol = [];
    }

    public static function column($col = "12,12,12,12", $content) {
        self::$precol[] = [$col => ["html" => $content]];
    }

    public static function adddiv($content, $attr = []) {
        self::$prediv[] = html::add_div($attr, $content);
    }

    public static function addblank($content, $attr = []) {
        self::$prediv[] = $content;
    }

    public static function makerow() {
        foreach (self::$prerow as $r) {
            self::$row .= html::addrow($r);
        }
        foreach (self::$prediv as $d) {
            self::$row .= $d;
        }
        return self::$row;
    }

    //first_row-col,
    //append_row-rowpos-col,
    //inner_row-rowpos-colpos-col,
    //last_row-col,
    public static function extention_row($component_position, $content) {
        $expos = explode("-", $component_position);
        switch ($expos[0]) {
            case"first_row":
                $col = $expos[1] . "," . $expos[1] . "," . $expos[1] . "," . $expos[1];
                $excol = [$col => ["html" => $content]];
                $r = array_reverse(self::$prerow);
                $r[][] = $excol;
                self::$prerow = array_reverse($r);
                break;
            case"last_row":
                $col = $expos[1] . "," . $expos[1] . "," . $expos[1] . "," . $expos[1];
                $excol = [$col => ["html" => $content]];
                self::$prerow[][] = $excol;
                break;
            case"append_row":
                $rowpos = $expos[1];
                $col = $expos[2] . "," . $expos[2] . "," . $expos[2] . "," . $expos[2];
                $excol = [$col => ["html" => $content]];
                self::$prerow[$rowpos][] = $excol;
                break;
            case"inner_row":
                $rowpos = $expos[1];
                $colpos = $expos[2];
                $col = $expos[3] . "," . $expos[3] . "," . $expos[3] . "," . $expos[3];
                $excol = [$col => ["html" => $content]];
                self::$prerow[$rowpos][$colpos] = $excol;
                break;
        }
    }

}

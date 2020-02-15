<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of component
 *
 * @author engin
 */
class component {

    public static $component;
    public $component_name;
    public static $component_module = array();
    public $component_css = array();
    public $component_javascript = array();
    public $component_json = array();
    public static $component_global_plugin = array();
    public $component_local_plugin = array();
    public static $page_buffer;
    public static $props = array();
    public static $component_temp;
    public static $reload = false;
    public static $component_js_list = array();

    public function __construct($parameter = array()) {

        return true;
    }

//home/u8827636/public_html
    public function make_component($type) {


        $module_type = modules::getModuleList($type);
        if ($module_type == "")
            $module_type = $type;
        $file = ROOT . DS . 'app' . DS . 'tema' . DS . $module_type . DS . 'components' . DS . $this->component_name;
        $path = PROOT . 'app' . DS . 'tema' . DS . $module_type . DS . 'components' . DS . $this->component_name;
        $this->combine_component("component_name", $this->component_name);
        $this->set_component_content($file);
        $this->set_global_plugin();
        $this->set_local_plugin($path);
        $this->set_component_css($file, $path);
        $this->set_component_json($file, $path);
        $this->set_component_javascript($file, $path);
    }

    public static function add_props($data) {
        $dt = [];
        foreach ($data as $key => $value) {
            $dt[$key] = $value;
        }
        self::$props[] = $dt;
        return self::$props;
    }

    public function set_component_html($component_file, $path) {
        $html_path = $component_file . DS . "html";
        $component_html = dirToPath($html_path);
        if (!empty($component_html)) {
            foreach ($component_html as $html) {
                if (is_array($html)) {
                    foreach ($html as $h) {
                        $hpath = $path . DS . "html" . DS . ltrim($h, "/");
                        $extension = tema::sepereta_data($hpath);
                        $this->correct_data($extension, $jpath);
                    }
                } else {
                    $hpath = $path . DS . "html" . DS . ltrim($html, "/");
                    $extension = tema::sepereta_data($hpath);
                    $this->correct_data($extension, $hpath);
                }
            }
        }
    }

    public static function get_component_javascript_list($component_name = "") {
        if ($component_name != "") {
            return self::$component_js_list[$component_name];
        } else {
            return self::$component_js_list;
        }
    }

    public static function starter($outlist = array()) {
        $jslist = self::$component_js_list;
        arrtolist::cleanList();
        _arrayToList($jslist);
        $file_list = (arrtolist::get_List());
        $starter_list = [];
        foreach ($file_list as $files) {
            foreach ($files as $file) {
                $starter_list[] = data::get_file_name($file);
            }
        }
        $starter_list = array_reverse($starter_list);
        if (isset($outlist))
            $starter_list = array_merge($outlist, $starter_list);
        return $starter_list;
    }

    public function set_component_javascript($component_file, $path) {
        $js_path = $component_file . DS . "js";
        $component_js = dirToPath($js_path);
//        dnd($js_path);
//        dnd($component_js);
        if (!empty($component_js)) {
            foreach ($component_js as $js) {
                if (is_array($js)) {
                    foreach ($js as $j) {
                        $jpath = $path . DS . "js" . DS . ltrim($j, "/");

                        self::$component_js_list[$this->component_name][] = ltrim($j, "/");
                        $extension = tema::sepereta_data($jpath);
                        $this->correct_data($extension, $jpath);
                    }
                } else {
                    $jpath = $path . DS . "js" . DS . ltrim($js, "/");
                    self::$component_js_list[$this->component_name][] = ltrim($js, "/");
                    $extension = tema::sepereta_data($jpath);
                    $this->correct_data($extension, $jpath);
                }
            }
        }
    }

    public function set_component_css($component_file, $path) {
        $css_path = $component_file . DS . "css";
        $component_css = dirToPath($css_path);
        if (!empty($component_css)) {
            foreach ($component_css as $css) {
                if (is_array($css)) {
                    foreach ($css as $cs) {
                        $cpath = $path . DS . "css" . DS . ltrim($cs, "/");
                        $extension = tema::sepereta_data($cpath);
                        $this->correct_data($extension, $cpath);
                    }
                } else {
                    $cpath = $path . DS . "css" . DS . ltrim($css, "/");

                    $extension = tema::sepereta_data($cpath);
                    $this->correct_data($extension, $cpath);
                }
            }
        }
    }

    public function set_component_json($component_file, $path) {
        $json_path = $component_file . DS . "json";
        $component_json = dirToPath($json_path);
        if (!empty($component_json)) {
            foreach ($component_json as $json) {
                if (is_array($json)) {
                    foreach ($json as $jsn) {
                        $cpath = $path . DS . "json" . DS . ltrim($jsn, "/");
                        $extension = tema::sepereta_data($cpath);
                        $this->correct_data($extension, $cpath);
                    }
                } else {
                    $cpath = $path . DS . "json" . DS . ltrim($json, "/");
                    $extension = tema::sepereta_data($cpath);
                    $this->correct_data($extension, $cpath);
                }
            }
        }
    }

    public function set_global_plugin() {
        $this->combine_component("global", self::$component_global_plugin);
    }

    public function set_component_content($component_file) {
        $content = $component_file . DS . 'content' . DS . $this->component_name . DOT . 'php';
        if (file_exists($content)) {
            $this->set_buffer($content);
            if (self::$reload) {
                $this->combine_component("content", self::$page_buffer);
            } else {
                $this->combine_component("content", html::add_div(["component_name" => $this->component_name], self::$page_buffer));
            }
        } else {
            $content = $component_file . DS . 'html' . DS . "index" . DOT . 'html';
            if (file_exists($content)) {
                $this->set_html_buffer($content);
                if (self::$reload) {
                    $this->combine_component("content", self::$page_buffer);
                } else {
                    $this->combine_component("content", html::add_div(["component_name" => $this->component_name], self::$page_buffer));
                }
            } else {
                die($content . " sayfası bulunmuyor");
            }
        }
    }

    public function set_buffer($content) {
        if (file_exists($content)) {
            require ($content);
        } else {
            die($content . " Component Dosyasına Ulaşılamıyor");
        }
    }

    public function set_html_buffer($content) {
        if (file_exists($content)) {
            ob_start();
            require ($content);
            self::$page_buffer = ob_get_clean();
        } else {
            die($content . " Component Dosyasına Ulaşılamıyor");
        }
    }

    public static function get_component_list() {
        foreach (self::$props as $prp) {
            if (array_key_exists($key, $prp)) {
                return $prp[$key];
            }
        }
        return false;
    }

    public static function isset_probs($key) {
        foreach (self::$props as $prp) {
            if (array_key_exists($key, $prp)) {
                return true;
            }
        }
        return false;
    }

    public static function get_allprobs() {
        return self::$props;
    }

    public static function get_props($key) {
        foreach (self::$props as $prp) {
            if (array_key_exists($key, $prp)) {
                return $prp[$key];
            }
        }
        return false;
    }

    public static function start() {
        ob_start();
    }

    public static function end() {
        self::$page_buffer = ob_get_clean();
    }

    public function set_local_plugin($component_dir) {
        $local_plugin_path = $component_dir . DS . "plugin";
        $local_plugin_file = ROOT . $component_dir . DS . "plugin";
        if (is_dir($local_plugin_file)) {
            $local_plugin_list = dirToInside($local_plugin_path);
            arrtolist::cleanList();
            _arrayToList($local_plugin_list);
            $file_list = (arrtolist::get_List());
            foreach ($file_list as $plugin_files) {
                if (is_array($plugin_files)) {
                    foreach ($plugin_files as $file) {
                        $extension = tema::sepereta_data($file);
                        $this->correct_data($extension, $file);
                    }
                }
                $this->add_local_plugin($plugin_name);
            }
            $this->combine_component("global", $this->component_local_plugin);
        }
    }

    public function correct_data($extension, $file) {

        switch ($extension) {
            case"css":
                $this->add_css($file, false);
                break;
            case"js":
                $this->add_javascript($file, false);
                break;
            case"json":
                $this->add_json($file, false);
        }
    }

    protected function add_css($css, $relative_path = true) {
        if ($relative_path) {
            $this->component_css[] = $this->set_relative_path($css);
        } else {
            $this->component_css[] = $css;
        }
        $this->combine_component("css", $this->component_css);
    }

    protected function add_javascript($javascript, $relative_path = true) {
        if ($relative_path) {
            $this->component_javascript[] = $this->set_relative_path($javascript);
        } else {
            $this->component_javascript[] = $javascript;
        }

        $this->combine_component("js", $this->component_javascript);
    }

    protected function add_json($json, $relative_path = true) {
        if ($relative_path) {
            $this->component_json[] = $this->set_relative_path($json);
        } else {
            $this->component_json[] = $json;
        }

        $this->combine_component("json", $this->component_json);
    }

    private function combine_component($type, $plugin) {
        self::$component_module[$type] = $plugin;
    }

    public static function get_component_module($type = "") {
        if ($type == "") {
            return self::$component_module;
        } else {
            return self::$component_module[$type];
        }
    }

    public static function get_component_global_module() {
        return self::$component_global_plugin;
    }

    public function get_component_css() {
        return $this->component_css;
    }

    public static function test() {
        dnd("TEST");
    }

    public static function import_component($component_name, $parameter = array(), $reload = false) {


        self::$reload = $reload;
        self::$component = new $component_name($parameter);
        self::get_component_module();
        //Contente gönderilecek parametreleri alabilirlir aslında

        return self::$component->render($parameter);
    }

    public static function get_component() {
        return self::$component;
    }

//    public static function get_component() {
//        return self::$component_temp;
//    }

    public function set_relative_path($file, $type) {
        return PROOT . 'components' . DS . $this->component_name . DS . $type . DS . $file . DOT . $type;
    }

    public function set_css_relative_path($css) {
        return PROOT . 'components' . DS . $this->component_name . DS . 'css' . DS . $css . ".css";
    }

    public function set_js_relative_path($js) {
        return PROOT . 'components' . DS . $this->component_name . DS . 'js' . DS . $js . ".js";
    }

    public function set_html_relative_path($html) {
        return PROOT . 'components' . DS . $this->component_name . DS . 'html' . DS . $html . ".php";
    }

    public function set_component_name($val) {
        return $this->component_name = $val;
    }

    public function add_global_plugin($plugin_name) {
        self::$component_global_plugin[] = $plugin_name;
    }

    public function add_local_plugin($plugin_name) {
        $this->component_local_plugin[] = $plugin_name;
// $this->combine_component("local", $this->component_global_plugin);
//        if (tema::search_global_plugin($plugin_name)) {
//            
//        } else {
//            $this->component_local_plugin[] = $plugin_name;
//        }
    }

    public function set_parent_component($val) {
        return $this->component_parent_name = $val;
    }

}

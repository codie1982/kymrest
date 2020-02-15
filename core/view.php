<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author engin
 */
class view {

    protected $_head, $_body, $_topnav, $modalList = [],
            $_sidebar, $_modal, $modals = [], $modal_index = 0,
            $_megamenu, $_pagesubbant, $_nav, $_header,
            $_breadcrumb, $_sticky, $_pagefooter, $_pagePlugin, $_pageScript, $_outoutBuffer, $_outoutModalBuffer, $_layout = DEFAULT_LAYOUT, $_admin = false;
    protected $page_template;
    protected $templete_type;
    protected $template_code;
    protected $tema;
    public $_siteTitle;
    public $_siteDescription;
    public $_siteKeywords;
    public $_siteMail;
    public $_siteName;
    public $_siteImage;
    public $_siteUrl;
    public $_sitePhone;
    public $page_content = array();
    public $page_component = array();
    public $page_content_css = array();
    public $page_content_html = array();
    public $page_content_component_content = array();
    public $page_content_javascript = array();
    public $page_content_buffer = array();
    public $page_html;
    public $component_css_list = array();
    public $component_json_list = array();
    public $component_javascript_list = array();
    public $component_local_plugin_list = array();
    public $component_global_plugin_list = array();
    public $component_content = array();
    public static $component_content_detail = array();
    public static $component_css_detail = array();
    public static $component_js_detail = array();
    public static $component_json_detail = array();
    public static $component_global_plugin_detail = array();
    public static $component_local_plugin_detail = array();

    const ARR = "array";
    const OBJECT = "object";
    const STRING = "string";

    public function __construct() {
        return TRUE;
    }

    public function render($viewName) {
        include (ROOT . DS . 'app' . DS . 'views' . DS . $viewName . '.php');
    }

    public function set_template($row = "") {
        $page_container = "";
        $ntemplate = new $this->template_code();
        $components = $ntemplate->get_component_list();
        if (!empty($components))
            foreach ($components as $component) {
                component::import_component($component, ["type" => "admin"]);
                $this->add_page(component::get_component_module());
            }

        $this->prepare_page();
        $content = $this->get_content();
        return $ntemplate->set_template($content, $row, $this->templete_type);
    }

    public function add_page($component) {
        $this->set_page_component($component);
    }

    public function set_page_component($component) {
        if (is_string($component)) {
            $this->page_component[self::STRING][] = $component;
        } elseif (is_object($component)) {
            $this->page_component[self::OBJECT][] = $component;
        } elseif (is_array($component)) {
            $this->page_component[self::ARR][] = $component;
        }
    }

    public function get_component_list() {
        return $this->page_component;
    }

    /*
      public $component_css_list = array();
      public $component_javascript_list = array();
      public $component_local_plugin_list = array();
      public $component_global_plugin_list = array();
     */

    public function get_page_content($type = "") {
        $this->page_content["css"] = $this->component_css_list;
        $this->page_content["json"] = $this->component_json_list;
        $this->page_content["javascript"] = $this->component_javascript_list;
        $this->page_content["content"] = $this->component_content;
        $this->page_content["global"] = $this->component_global_plugin_list;
        $this->page_content["local"] = $this->component_local_plugin_list;
        if ($type != "") {
            return $this->page_content[$type];
        } else {
            return $this->page_content;
        }
    }

    public function prepare_page() {

        $obj = $this->page_component[self::OBJECT];

        if (array_key_exists(self::OBJECT, $this->page_component)) {
            foreach ($obj as $comp) {
                self::$component_css_detail[$comp->component_name][] = $comp->component_css;
                $this->add_component_css_list($comp->component_css, $comp->component_name);
            }
            foreach ($obj as $comp) {
                self::$component_js_detail[$comp->component_name][] = $comp->component_javascript;
                $this->add_component_javascript_list($comp->component_javascript, $comp->component_name);
            }
            foreach ($obj as $comp) {
                self::$component_global_plugin_detail[$comp->component_name][] = $comp->component_global_plugin;
                $this->add_component_global_plugin_list($comp->component_global_plugin, $comp->component_name);
            }
            foreach ($obj as $comp) {
                self::$component_local_plugin_detail[$comp->component_name][] = $comp->component_local_plugin;
                $this->add_component_local_plugin_list($comp->component_local_plugin, $comp->component_name);
            }
            foreach ($obj as $comp) {
                self::$component_content_detail[$comp->component_name][] = $comp->page_content_buffer;
                $this->add_component_content($comp->page_content_buffer, $comp->component_name); // 
            }
        } else if (array_key_exists(self::ARR, $this->page_component)) {

            //dnd($this->page_component);
            foreach ($this->page_component[self::ARR] as $cm) {

                $css_obj = $cm["css"];
                if (!empty($css_obj))
                    foreach ($css_obj as $css) {
                        self::$component_css_detail[$cm["component_name"]][] = $css;
                        $this->add_component_css_list($css, $cm["component_name"]);
                    }

                $json_obj = $cm["json"];
                if (!empty($json_obj))
                    foreach ($json_obj as $jsn) {
                        self::$component_json_detail[$cm["component_name"]][] = $jsn;
                        $this->add_component_json_list($jsn, $cm["component_name"]);
                    }

                $global_obj = $cm["global"];
                $global_list = array();
                if (!empty($global_obj)) {
                    $global_obj_f = array_unique($global_obj);
                    foreach ($global_obj_f as $global) {
                        if (!empty($global))
                            $global_list[] = $global;
                        $this->add_component_global_plugin_list($global, $cm["component_name"]);
                    }
                }
                tema::add_global_plugin($global_list);

                $javascript_obj = $cm["js"];
                if (!empty($javascript_obj))
                    foreach ($javascript_obj as $javascript) {
                        self::$component_js_detail[$cm["component_name"]][] = $javascript;
                        // dnd($javascript);
                        //$val      , $component_name
                        $this->add_component_javascript_list($javascript, $cm["component_name"]);
                    }




                $local_obj = $cm["local"];
                if (!empty($local_obj))
                    foreach ($local_obj as $local) {
                        self::$component_local_plugin_detail[$cm["component_name"]][] = $local;
                        $this->add_component_local_plugin_list($local, $cm["component_name"]);
                    }

                $content_obj = $cm["content"];
                if (!empty($content_obj)) {
                    self::$component_content_detail[$cm["component_name"]] = $content_obj;
                    $this->add_component_content($content_obj, $cm["component_name"]);
                }
            }
        }
    }

    public function get_content($component_name = "") {
        if ($component_name !== "") {
            $content = $this->get_page_content("content");
            return $content[$component_name];
        } else {
            return $this->get_page_content("content");
        }
    }

    public function set_page_html() {
        $cssess = $this->get_page_content("css");
        if (!empty($cssess))
            foreach ($cssess as $component_name => $css_list) {
                foreach ($css_list as $css) {
                    tema::add_css($css);
                }
                // dnd($component_name);
            }

        $json = $this->get_page_content("json");
        if (!empty($json))
            foreach ($json as $component_name => $jsn_list) {
                foreach ($jsn_list as $jsn) {
                    tema::add_json($jsn);
                }
            }

        $jsess = $this->get_page_content("javascript");

        //dnd($jsess);
        if (!empty($jsess))
            foreach ($jsess as $component_name => $js_list) {
                foreach ($js_list as $js) {
                    tema::add_javascript($js);
                }
                // dnd($component_name);
            }
    }

    private function add_component_content($val, $component_name) {
        $this->component_content[$component_name] = $val;
    }

    public static function get_component_detail($component_name = "") {
        if ($component_name == "") {
            return self::$component_content_detail;
        } else {
            return self::$component_content_detail[$component_name];
        }
    }

    public static function get_component_js_detail($component_name = "") {
        if ($component_name == "") {
            return self::$component_js_detail;
        } else {
            return self::$component_js_detail[$component_name];
        }
    }

    private function add_component_global_plugin_list($val, $component_name) {
        $this->component_global_plugin_list[$component_name][] = $val;
    }

    private function add_component_local_plugin_list($val, $component_name) {
        $this->component_local_plugin_list[$component_name][] = $val;
    }

    private function add_component_javascript_list($val, $component_name) {
        $this->component_javascript_list[$component_name][] = $val;
    }

    private function add_component_css_list($val, $component_name) {
        $this->component_css_list[$component_name][] = $val;
    }

    private function add_component_json_list($val, $component_name) {
        $this->component_json_list[$component_name][] = $val;
    }

    public function add_page_css($val) {
        $this->page_content_css[] = $val;
    }

    public function siteTitle() {
        if ($this->_siteTitle == "") {
            return SITE_TITLE;
        } else {
            return $this->_siteTitle;
        }
    }

    public function setSiteTitle($title) {
        $this->_siteTitle = $title;
    }

    public function setSiteDescription($val) {
        $this->_siteDescription = $val;
    }

    public function setSitekeywords($val) {
        $this->_siteKeywords = $val;
    }

    public function setSiteMail($val) {
        $this->_siteMail = $val;
    }

    public function setSiteName($val) {
        $this->_siteName = $val;
    }

    public function setSiteImage($val) {
        $this->_siteImage = $val;
    }

    public function setSiteUrl($val) {
        $this->_siteUrl = $val;
    }

    public function setSitePhone($val) {
        $this->_sitePhone = $val;
    }

    public function setLayout() {
//        tema::selecte
//        $dispatch = new $this->tema();
//        call_user_func_array([$dispatch, "create_tema"], []);
    }

    public function get_tema_global_script_list($component_name) {
        $file = $component_name . DOT . "php";
        $absolute_path = realpath($file);
//        $dispatch = new $this->template_code();
//        $result = call_user_func_array([$dispatch, "create_tema"], []);
    }

//    public function set_template_type($type = "standart") {
//        return $this->templete_type = $type;
//    }

//    public function set_template($templete = "standart") {
//        return $this->templete = $templete;
//    }

    public function set_tema($tema = "admin") {
        $this->tema = $tema;
    }

    public function set_template_code($type = "admin") {
        $this->template_code = modules::getModuleList($type);
    }

    public function set_mail_code($type = "admin") {
        $this->template_code = $type;
    }

    public function setAdmin($admin = false) {
        $this->_admin = true;
    }

    public static function getLayout() {
        return $this->_layout;
    }

    public function make_css_link($links) {
        if (is_array($links)) {
            if (!empty($links)) {
                foreach ($links as $link) {
                    echo '<link href="' . $link . '" rel="stylesheet" type="text/css" />';
                }
            }
        }
    }

    public function make_meta_link($links) {
        if (is_array($links)) {
            if (!empty($links)) {
                foreach ($links as $link) {
                    echo '<meta ' . $link . ' />';
                }
            }
        }
    }

    //<link href = "https://fonts.googleapis.com/css?family=Poppins:400,900&display=swap" rel = "stylesheet">
    public function make_font($fonts) {
        if (is_array($fonts)) {
            if (!empty($fonts)) {
                foreach ($fonts as $font) {
                    echo '<link href="' . $font . '" rel="stylesheet" />';
                }
            }
        }
    }

    public function screenOn($html) {
        echo $html[0];
    }

    public function make_javascript_link($links) {
        if (is_array($links)) {
            if (!empty($links)) {
                foreach ($links as $link) {
                    echo '<script src="' . $link . '" type="text/javascript"></script>';
                }
            }
        }
    }

    public function site_title($link) {
        return ' <title>' . $link . '</title>';
    }

    public function make_meta_tag($attr) {
        return html::add_meta($attr);
    }

}

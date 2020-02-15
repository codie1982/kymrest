<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class router {

    private static $url;
    private static $xml;

    const HOME = "home";
    const DASHBOARD = "dashboard";
    const ERROR = "error";
    const api = "api";
    const component = "component";
    const oneway = "oneway";
    const multiple = "multiple";

    public function __construct() {
        
    }

    static public function getUrl($array = true) {
        if ($array) {
            $_arr = isset($_GET["url"]) ? explode("/", ltrim($_GET["url"], "/")) : [];
            $cleanArray = array_filter($_arr);
            return $cleanArray;
        } else {
            return isset($_GET["url"]) ? ltrim($_GET["url"], "/") : "";
        }
    }

    static public function getPost() {
        return file_get_contents('php://input');
    }

    static public function getUrlParameter($array = true) {
        if ($array) {
            if (isset($_GET["url"])) {
                unset($_GET["url"]);
            }
            $GET = array_filter($_GET, function($item) {
                return strval($item);
            });
            $cleanArray = array_filter($GET);
            return $cleanArray;
        } else {
            return false;
        }
    }

    public static function get_module_info() {
        $result = [];
        return modules::getModuleList("router");
    }

    public static function get_permission() {

        if (class_exists("table_customer")) {
            $ncustomer = new table_customer_tag();
            $ncustomer->select();
            $ncustomer->add_condition("customer_id", session::get(CURRENT_USER_SESSION_NAME));
            $ncustomer->add_limit_start(1);

            $ncustomer->add_direction("DESC");
            $user_permission_data = $ncustomer->get_alldata();

            if (!empty($user_permission_data))
                foreach ($user_permission_data as $data) {
                    data::set_user_permission($data->tag);
                }
            return data::get_user_permission();
        }
    }

    public static function get_module_controller($module_list, $url) {
        $arr = [];
        $temp_url = $url;
        //$find_controller = false;
        if (empty($url)) {
            $hm = "home";
            //  dnd($module_list->$hm);
            $info = $module_list->$hm;
            $parameter = ltrim(ltrim(implode("/", $temp_url), $info->name), "/");
            $param_arr = explode("/", $parameter);
            $arr["module_type"] = "router";
            if (isset($info->controller))
                $arr["controller"] = $info->controller;
            if (isset($info->permission))
                $arr["permission"] = explode(",", $info->permission);
            if (isset($info->icon))
                $arr["icon"] = $info->icon;
            if ($parameter !== "")
                $arr["parameter"] = $param_arr;
            return $arr;
        } else {
            while ($find_controller == false) {
                $_url = implode("/", $url);
                if (!empty($_url)) {
                    foreach ($module_list as $page => $info) {
                        if ($page == rtrim($_url, "/")) {

                            $parameter = ltrim(ltrim(implode("/", $temp_url), $info->name), "/");
                            $param_arr = explode("/", $parameter);
                            $arr["module_type"] = "router";
                            if (isset($info->controller))
                                $arr["controller"] = $info->controller;
                            if (isset($info->permission))
                                $arr["permission"] = explode(",", $info->permission);
                            if (isset($info->icon))
                                $arr["icon"] = $info->icon;
                            if ($parameter !== "")
                                $arr["parameter"] = $param_arr;
                            $find_controller = true;
                            return $arr;
                        }
                    }
                }
                array_pop($url); //$url[1]
                if (empty($url)) {
                    return false;
                }
            }
        }
    }

    public static function route() {
//controller
        switch ($_SERVER['REQUEST_METHOD']) {
            case"GET":
                //api isteği ile normar istekleri birbirinden ayrmamız gerekli bu rada api istekeri token ile gelecek JWT ile encode yapmamız gerekli
                if (isset($_GET["site"])) {
                    self::set_funtion("sitemap", "index", []);
                } else {

                    $url = self::getUrl();
                    $urlparameter = self::getUrlParameter();
                    $module_list = self::get_module_info();
                    $user_permission = self::get_permission();

                    if ($module_controller = self::get_module_controller($module_list, $url)) {


                        data::ADD_GETDATA($url);
                        data::ADD_GETPARAMETER($urlparameter);
                        if (modules::getModuleList("router_type") == self::multiple) {
                            self::setup_function($module_controller);
                        } else {
                            self::set_funtion("home", "index", []);
                        }
                        //url 1.parametre Boş olduğunda yapılacak Aramalar
                        //ürünler
                        //categoriler
                        //kullanıcılar
                        //haberler
                        //genel Arama ve Eşleştirme
                        //$module_name = self::get_module_info($url);
                    } else {

                        if (self::isapi($url)) {
                            array_shift($url);
                            $appkey = $url[0];

                            if ($appkey == modules::getModuleList("application_key")) {
                                array_shift($url);
                                data::ADD_GETDATA($url);
                                data::ADD_GETPARAMETER($urlparameter);
                                self::set_funtion(self::get_api_controller($url), self::get_api_action($url), self::get_api_parameter($url));
                            } else {
                                data::ADD_APIERROR();
                                return false;
                            }
                        } else if (self::iscomponent($url)) {
                            array_shift($url);
                            data::ADD_GETDATA($url);
                            data::ADD_GETPARAMETER($urlparameter);
                            self::set_funtion(self::get_component_controller($url), self::get_component_action($url), self::get_component_parameter($url));
                        } else {

                            //URL boş olduğunda home componentini çalıştırı
                            self::set_funtion("home", "index", []);
                        }
                    }
                }
                break;
            case "POST":


                $url = self::getUrl();
                $post = self::getPost();
                $urlparameter = self::getUrlParameter();
                //$module_list = self::get_module_info();
                //$user_permission = self::get_permission();


                if (self::isapi($url)) {
                    array_shift($url);
                    $appkey = $url[0];
                    if ($appkey == modules::getModuleList("application_key")) {
                        array_shift($url);
                        data::ADD_GETDATA($url);
                        data::ADD_POSTDATA($post);
                        self::set_funtion(self::get_api_controller($url), self::get_api_action($url), self::get_api_parameter($url));
                    } else {
                        data::ADD_APIERROR();
                        return false;
                    }
                } else if (self::iscomponent($url)) {

                    array_shift($url);
                    data::ADD_GETDATA($url);
                    data::ADD_POSTDATA($post);
                    self::set_funtion(self::get_component_controller($url), self::get_component_action($url), self::get_component_parameter($url));
                } else {
                    //URL boş olduğunda home componentini çalıştırı

                    self::set_funtion("home", "index", []);
                }
                break;
        }
    }

    static public function iscomponent($url) {

        if ($url[0] == self::component)
            return true;
        return false;
    }

    static public function isapi($url) {
        if ($url[0] == self::api)
            return true;
        return false;
    }

    private static function get_component_controller($url) {
        return $url[0];
    }

    private static function get_api_controller($url) {
        return $url[0];
    }

    private static function get_component_action($url) {
        return $url[1];
    }

    private static function get_api_action($url) {
        return $url[1];
    }

    private static function get_component_parameter($url) {
        array_shift($url);
        array_shift($url);
        return $url;
    }

    private static function get_api_parameter($url) {
        array_shift($url);
        array_shift($url);
        return $url;
    }

    public static function get_url_parameter($url) {
        $_url = self::set_url($url);
        return $_url["parameter"];
    }

    public static function _set_url($url) {
        $result = [];
        $result["controller"] = rtrim(($url[0] . DS . $url[1]), "/");
        $result["parameter"] = [];
        if (count($url) >= 2) {
            array_shift($url); //$url[0]
            $result["parameter"] = $url;
        }
        return $result;
    }

    public static function set_url($url) {
        $result = [];
        $result["controller"] = rtrim(($url[0] . DS . $url[1]), "/");
        $result["parameter"] = [];
        if (count($url) >= 2) {
            array_shift($url); //$url[0]
            array_shift($url); //$url[1]
            $result["parameter"] = $url;
        }
        return $result;
    }

    public static function set_funtion($controller, $action = "", $parameters = array()) {
        if ($action !== "")
            if (substr($action, 0, -5) !== "Action") {
                $action = $action . "Action";
            }
        //Burada kullanıcının bu fonksiyonu çalıştırmaya yetkisi varmı yok mu diye bakmamız gerekli
        //eğer bu fonksiyonu çalıştırmak için başka birinden onay alması gerekiyorsa o izni de bu noktada kontrol etmemiz gerekmektedir.
        $dispatch = new $controller($controller, $action);
        tema::set_selected_controller($controller);
        call_user_func_array([$dispatch, $action], $parameters);
    }

    public static function setup_function($module_controller) {
        if (class_exists($module_controller["controller"])) {
            if (method_exists($module_controller["controller"], "indexAction")) {
                if (!isset($module_controller["parameter"]) && empty($module_controller["parameter"])) {
                    $module_controller["parameter"] = [];
                }
                self::set_funtion($module_controller["controller"], "index", $module_controller["parameter"]);
            } else {
                dnd("index Methoda Ulaşılamıyor");
                die();
            }
        } else {
            dnd($module_controller["controller"] . " class Dosyasına Ulaşılamıyor");
        }
    }

    public static function redirect($location) {
        if (!headers_sent()) {
            header("Location: " . PROOT . $location);
            exit();
        } else {
            echo '<script type="text/javascript">window.location.href="' . PROOT . $location . '"</script>';
            echo '<noscript><meta http:equiv="refresh" content="0;url=' . $location . ' /></noscript>';
            exit();
        }
    }

}

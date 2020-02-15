<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modules
 *
 * @author engin
 */
class modules {

    public $moduleList;
    public static $module_file_name = "module.json";

    public function __construct() {
        return true;
    }

    static function modulesAuthorizations($controller_permission = "", $customer_permission = "") {
        if (!empty($controller_permission)) {
            $access = "no";
            if (!empty($controller_permission)) {
                if (!in_array("everyone", $controller_permission)) {
                    if (!in_array("supermen", $customer_permission)) {
                        foreach ($controller_permission as $coper) {
                            if (in_array($coper, $customer_permission)) {
                                $access = "yes";
                            }
                        }
                        return $access == "yes" ? true : false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    static private function moduleList() {
        if (file_exists(self::set_path())) {
            $modulefile = file_get_contents(self::set_path());
            return $config_data = json_decode($modulefile);
        } else {
            return false;
        }
    }

    static public function getExtensions() {
        $obj = self::moduleList();
        $key = "extension-page";
        return $obj->$key;
    }

    static public function getMailTemplates() {
        $obj = self::moduleList();
        $key = "mail-template";
        return $obj->$key;
    }

    static public function getMailTemplatesList() {
        $obj = self::moduleList();
        $key = "mail-template";
        $templates = $obj->$key;
        $list = [];
        foreach ($templates as $template_name => $template) {
            $list[] = $template_name;
        }
        return $list;
    }

    static public function getBulkMailTemplatesList() {
        $obj = self::moduleList();
        $key = "mail-template";
        $templates = $obj->$key;
        $list = [];
        foreach ($templates as $template_name => $template) {
            if ($template->sender == "bulkmail") {
                $list[] = ["type" => $template_name, "title" => $template->title];
            }
        }
        return $list;
    }

    static public function getModuleList($key = null) {
        $obj = self::moduleList();
        if ($key != null) {
            return $obj->$key;
        } else {
            return $obj;
        }
    }

    static public function getControllerPermission($controller) {
        $module = self::findController($controller);
        return isset($module->permission) ? $module->permission : false;
    }

    static public function getControllerSession($controller) {
        $module = self::findController($controller);
      
        return $module->session;
    }

    static public function addData() {
        $obj = self::moduleList();
        $obj->category = ["dew"];
        self::setData($obj);
        return true;
    }

    static public function removeData() {
        $obj = self::moduleList();
        unset($obj->category);
        self::setData($obj);
        return true;
    }

    static private function setData($data) {
        $fp = fopen(self::set_path(), 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
        return true;
    }

    static private function set_path() {
        return ROOT . DS . 'module.json';
    }

    public static function getPageTitle($url = true) {
        $page = router::getUrl(false);
        $pagearr = router::getUrl();
        $lpage = explode("/", ltrim($page));
        if ($lpage[0] !== "api") {
            $link = $lpage[0] . "/" . $lpage[1];
            $module_list = router::get_module_info();
            $controller = router::get_module_controller($module_list, $pagearr);
            $module = self::findController($controller["controller"]);
            return $module->page_title;
        } else {
            return false;
        }
    }

    public static function findController($controller_name) {
        $modules = router::get_module_info("router");
        foreach ($modules as $key => $module) {
            if ($controller_name == $module->controller) {
                return $module;
            }
            switch ($key) {
                case"extensionPage":
                    foreach ($module as $extention) {
                        foreach ($extention as $m) {
                            if ($controller_name == $m->controller) {
                                return $m;
                            }
                        }
                    }
                    break;
                case"adminPage":
                  
                    break;
                case"temaPage":
                    foreach ($module as $m) {
                        if ($controller_name == $m->controller) {
                            return $m;
                        }
                    }
                    break;
            }
        }
    }

}

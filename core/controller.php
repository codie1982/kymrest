<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author engin
 */
class controller extends application {

    const sessinOn = "on";
    const sessinOff = "off";

    protected $controller, $action;
    public $view, $permission, $controller_permission;
    protected $user_authorizations;

    public function __construct($controller, $action) {
        parent::__construct();
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new view();
        $this->controller_session();
        if (!$this->controller_authorizations($controller)) {
            die("Bu Sayfayı Görmeye Yetkili Değilsiniz");
        }
    }

    public function set_controller($value) {
        $this->controller = $value;
    }

    protected function load_model($model) {
        $class_name = "table_" . $model;
        if (class_exists($class_name)) {
            $this->$model = new $class_name();
        }
    }

    protected function load_rmodel($model) {
        if (class_exists($model)) {
            return $this->{$model . "Model"} = new $model();
        }
    }

    public function set_user_authorizations() {
        return $this->user_authorizations = modules::getControllerPermission($this->controller);
    }

    public function get_controller_permission($controller = "") {
        return modules::getControllerPermission($controller == "" ? $this->controller : $controller);
    }

//"admin/login"
    protected function controller_session() {
        $session = modules::getControllerSession($this->controller);
        if (isset($session)) {
            if ($session == controller::sessinOn) {
                if (!session::exists(CURRENT_USER_SESSION_NAME)) {
                    die("Oturum Kapalı iken bu alana giremezsiniz");
                    return false;
                }
            } elseif ($session == controller::sessinOff) {
                if (session::exists(CURRENT_USER_SESSION_NAME)) {
                    die("Oturum Açıkken iken bu alana giremezsiniz");
                    return false;
                }
            }
        } else {
            return true;
        }
    }

    public function controller_user_authorizations($customer_permission) {
        $permission_type = explode(",", $this->get_user_authorizations());

        if (!in_array("everyone", $permission_type)) {
            if ($customer_permission) {
                if ($customer_permission[0]->permission != "supermen") {
                    $perms = [];
                    foreach ($customer_permission as $permission) {
                        $perms[] = $permission->permission;
                    }
                    if (is_array($customer_permission)) {
                        foreach ($permission_type as $user) {
                            if (!in_array($user, $perms))
                                return false;
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function controller_authorizations($controller = "") {
        $permission = $this->get_controller_permission($controller);
        if ($permission != "") {
            $this->controller_permission = explode(",", $permission);
            $customer_permission = data::get_user_permission();
            $access = "no";
            if (!empty($this->controller_permission)) {
                if (!in_array("everyone", $this->controller_permission)) {
                    if (!in_array("supermen", $customer_permission)) {
                        foreach ($this->controller_permission as $coper) {
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



//    protected function check_authorizations() {
//        if (!$this->controller_authorizations($this->user_authorizations)) {
//            die("Bu Sayfayı Görmeye Yetkili Değilsinizsss");
//        }
//    }

    protected function controller_users($value) {
        $this->user_type = $value;
    }

}

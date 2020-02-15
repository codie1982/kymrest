<?php

ob_start();
session_start();

define("ROOT", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);

require_once (ROOT . DS . 'config' . DS . 'constant.php');
require_once (ROOT . DS . 'config' . DS . 'preload.php');
require_once (ROOT . DS . 'config' . DS . 'arrtolist.php');


spl_autoload_register(function($class) {

    if (file_exists(ROOT . DS . 'core' . DS . $class . DOT . PHP)) {
        require_once(ROOT . DS . 'core' . DS . $class . DOT . PHP);
    }
    if (file_exists(ROOT . DS . 'class' . DS . 'class' . DOT . $class . DOT . PHP)) {
        require_once(ROOT . DS . 'class' . DS . 'class' . DOT . $class . DOT . PHP);
    }


    arrtolist::cleanList();
    $path = ROOT . DS . APP . DS . 'lib';
    $list = dirList($path, true);
    _arrayToList($list);
    $classlist = (arrtolist::get_List());
    foreach ($classlist as $class_file) {
        if (is_array($class_file)) {
            foreach ($class_file as $file) {
                if (file_exists($file . DS . $class . DOT . "php")) {
                    require_once($file . DS . $class . DOT . "php");
                }
            }
        } else {

            if (file_exists($class_file . DS . $class . DOT . "php")) {
                require_once($class_file . DS . $class . DOT . "php");
            }
        }
    }

    arrtolist::cleanList();
    $path = ROOT . DS . APP . DS . 'process';
    $list = dirList($path, true);
    _arrayToList($list);
    $classlist = (arrtolist::get_List());
    foreach ($classlist as $class_file) {
        if (is_array($class_file)) {
            foreach ($class_file as $file) {
                if (file_exists($file . DS . $class . DOT . "php")) {
                    require_once($file . DS . $class . DOT . "php");
                }
            }
        } else {

            if (file_exists($class_file . DS . $class . DOT . "php")) {
                require_once($class_file . DS . $class . DOT . "php");
            }
        }
    }

    arrtolist::cleanList();
    $path = ROOT . DS . APP . DS . 'models';
    $list = dirList($path, true);
    _arrayToList($list);
    $classlist = (arrtolist::get_List());
    foreach ($classlist as $class_file) {
        if (is_array($class_file)) {
            foreach ($class_file as $file) {
                if (file_exists($file . DS . $class . DOT . "php")) {
                    require_once($file . DS . $class . DOT . "php");
                }
            }
        } else {

            if (file_exists($class_file . DS . $class . DOT . "php")) {
                require_once($class_file . DS . $class . DOT . "php");
            }
        }
    }

    arrtolist::cleanList();
    $path = ROOT . DS . APP . DS . 'module';
    $list = dirList($path, true);
    _arrayToList($list);
    $classlist = (arrtolist::get_List());
    foreach ($classlist as $class_file) {
        if (is_array($class_file)) {
            foreach ($class_file as $file) {
                if (file_exists($file . DS . $class . DOT . "php")) {
                    require_once($file . DS . $class . DOT . "php");
                }
            }
        } else {

            if (file_exists($class_file . DS . $class . DOT . "php")) {
                require_once($class_file . DS . $class . DOT . "php");
            }
        }
    }

    arrtolist::cleanList();
    $path = ROOT . DS . APP . DS . 'data';
    $list = dirList($path, true);
    _arrayToList($list);
    $classlist = (arrtolist::get_List());
    foreach ($classlist as $class_file) {
        if (is_array($class_file)) {
            foreach ($class_file as $file) {
                if (file_exists($file . DS . $class . DOT . "php")) {
                    require_once($file . DS . $class . DOT . "php");
                }
            }
        } else {

            if (file_exists($class_file . DS . $class . DOT . "php")) {
                require_once($class_file . DS . $class . DOT . "php");
            }
        }
    }

    arrtolist::cleanList();
    $path = ROOT . DS . APP . DS . 'controllers';
    $list = dirList($path, true);
    _arrayToList($list);
    $classlist = (arrtolist::get_List());
    foreach ($classlist as $class_file) {
        if (is_array($class_file)) {
            foreach ($class_file as $file) {
                $ex = explode("/", $file);
                if (array_search("tema", $ex)) {
                    
                } else {
                    if (file_exists($file . DS . $class . DOT . "php")) {
                        require_once($file . DS . $class . DOT . "php");
                    }
                }
            }
        } else {
            if (file_exists($class_file . DS . $class . DOT . "php")) {
                require_once($class_file . DS . $class . DOT . "php");
            }
        }
    }
    arrtolist::cleanList();
    $path = ROOT . DS . API;
    if (is_dir($path)) {
        $list = dirList($path, true);
        _arrayToList($list);
        $classlist = (arrtolist::get_List());
        foreach ($classlist as $class_file) {
            if (is_array($class_file)) {
                foreach ($class_file as $file) {

                    if (file_exists($file . DS . $class . DOT . "php")) {
                        require_once($file . DS . $class . DOT . "php");
                    }
                }
            } else {
                if (file_exists($class_file . DS . $class . DOT . "php")) {
                    require_once($class_file . DS . $class . DOT . "php");
                }
            }
        }
    }
    if (router::isapi(router::getUrl())) {
        
    } else {

        arrtolist::cleanList();
        $path = ROOT . DS . APP . DS . 'tema' . DS . modules::getModuleList(ADMIN);
        if (is_dir($path)) {
            $list = dirList($path, true);
            _arrayToList($list);
            $classlist = (arrtolist::get_List());
            foreach ($classlist as $class_file) {
                if (is_array($class_file)) {
                    foreach ($class_file as $file) {
                        if (file_exists($file . DS . $class . DOT . "php")) {
                            require_once($file . DS . $class . DOT . "php");
                        }
                    }
                } else {
                    if (file_exists($class_file . DS . $class . DOT . "php")) {
                        require_once($class_file . DS . $class . DOT . "php");
                    }
                }
            }
        }


        arrtolist::cleanList();
        $path = ROOT . DS . APP . DS . 'tema' . DS . modules::getModuleList(USER);
        if (is_dir($path)) {
            $list = dirList($path, true);
            _arrayToList($list);
            $classlist = (arrtolist::get_List());
            foreach ($classlist as $class_file) {
                if (is_array($class_file)) {
                    foreach ($class_file as $file) {
                        if (file_exists($file . DS . $class . DOT . "php")) {
                            require_once($file . DS . $class . DOT . "php");
                        }
                    }
                } else {
                    if (file_exists($class_file . DS . $class . DOT . "php")) {
                        require_once($class_file . DS . $class . DOT . "php");
                    }
                }
            }
        }


        arrtolist::cleanList();
        $path = ROOT . DS . APP . DS . 'tema' . DS . EXTENSION;
        if (is_dir($path)) {
            $list = dirList($path, true);
            _arrayToList($list);
            $classlist = (arrtolist::get_List());
            foreach ($classlist as $class_file) {
                if (is_array($class_file)) {
                    foreach ($class_file as $file) {
                        if (file_exists($file . DS . $class . DOT . "php")) {
                            require_once($file . DS . $class . DOT . "php");
                        }
                    }
                } else {
                    if (file_exists($class_file . DS . $class . DOT . "php")) {
                        require_once($class_file . DS . $class . DOT . "php");
                    }
                }
            }
        }


        arrtolist::cleanList();
        $path = ROOT . DS . APP . DS . 'tema' . DS . MAIL;
        if (is_dir($path)) {
            $list = dirList($path, true);
            _arrayToList($list);
            $classlist = (arrtolist::get_List());
            foreach ($classlist as $class_file) {
                if (is_array($class_file)) {
                    foreach ($class_file as $file) {
                        if (file_exists($file . DS . $class . DOT . "php")) {
                            require_once($file . DS . $class . DOT . "php");
                        }
                    }
                } else {
                    if (file_exists($class_file . DS . $class . DOT . "php")) {
                        require_once($class_file . DS . $class . DOT . "php");
                    }
                }
            }
        }
    }
});




require_once (ROOT . DS . 'config' . DS . 'bootstrap.php');
require_once (ROOT . DS . 'config' . DS . 'maintenance.php');
require_once (ROOT . DS . 'config' . DS . 'visitor.php');


chmod (ROOT, 0777); 
router::route();
ob_end_flush();

<?php

// https://www.youtube.com/playlist?list=PLFPkAJFH7I0keB1qpWk5qVVUYdNLTEUs3
// DB Ayarları 
// DB Kurulumu Başarılımı
// İlk Kullanıcı
// Genel Site Ayarları
//DB Ayarları


if (file_exists(ROOT . DS . 'module.json')) {
    $module_path = ROOT . DS . 'module.json';
    $modulefile = file_get_contents($module_path);
    $config_data = json_decode($modulefile);

    $envormient = $config_data->envormient;
   
    define("DBHOST", $envormient->database->db_host);
    define("DBNAME", $envormient->database->db_name);
    define("DBUSER", $envormient->database->db_username);
    define("DBPASSWORD", $envormient->database->db_password);
    
    require_once(ROOT . DS . 'core' . DS . 'db.php');
    $db = new db();
    
    if ($db->error()) {
        //unlink(ROOT . DS . 'config.json');
        define("CONFIGFILE", FALSE);
        die();
    } else {
        define("CONFIGFILE", TRUE);
    }
} else {
    define("CONFIGFILE", FALSE);
}
/*
if (!CONFIGFILE) {
    //Yapılandırma Sayfasına Yönlendirme
//    require_once (ROOT . DS . 'config' . DS . 'first_setup.php');
//    if ($_POST) {
//        if (setdb::setconfigfile($_POST)) {
//            header("Location: " . PROOT);
//        } else {
//            die("Yapılandırmada Bir Sorun Var Sayfayı yeniden yükleyin.");
//        }
//    } else {
//        $config = new config("/", "index");
//    }
} else {
    require_once (ROOT . DS . 'config' . DS . 'first_setup.php');
    require_once(ROOT . DS . 'app' . DS . 'module' . DS . 'config' . DS . 'setdb.php');
    //check DB TABLES
    if (!setdb::checkbtables()) {
        if (setdb::createdbtables()) {
            if (!setdb::updateTablePrepare()) {
                die("Tablo Yapılandırılması gerçekleşmedi.Manuel olarak yapabilirsiniz.");
            }
        }
        die("DB Tablo Yapılandırılması Gerçekleştiriliyor. Lütfen Bu sayfayı yenileyin.");
    }
    //check mail setup
    require_once(ROOT . DS . 'app' . DS . 'module' . DS . 'config' . DS . 'setmail.php');
    if (!setmail::checkmailsettings()) {

        if ($_POST) {
            if (setmail::setmailfile($_POST)) {
                header("Location: " . PROOT);
            } else {
                die("Mail Ayarları yapılandırılmadı. Lütfen tekrr deneyin.");
            }
        }
        $config = new config("/", "mailsettings");
        die();
    }
    //check First User
    require_once(ROOT . DS . 'app' . DS . 'module' . DS . 'config' . DS . 'setuser.php');
    if (!setuser::checkfirstuser()) {
        if ($_POST) {
            if (setuser::addfirstuser($_POST)) {
                header("Location: " . PROOT);
            } else {
                die("İlk Kullanıcı Eklenmesi yapılamadı. Lütfen tekrar deneyin.");
            }
        }
        $config = new config("/", "firstuser");
        die();
    }
}
 * 
 */
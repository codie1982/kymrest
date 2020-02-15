<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function callAPI($method, $url, $data) {
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'APIKEY: 111111111111111111111',
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // EXECUTE:
    $result = curl_exec($curl);
    if (!$result) {
        die("Connection Failure");
    }
    curl_close($curl);
    return $result;
}

function component_link($component_name, $action, $parameters = array(), $varibles = []) {
    $link .= DS;
    $link .= API;
    $link .= DS;
    $link .= $component_name;
    $link .= DS;
    $link .= $action;
    if (!is_array($parameters)) {
        $link .= DS . $parameters;
    } else {
        if (!empty($parameters)) {
            foreach ($parameters as $pr) {
                $link .= DS . $pr;
            }
        }
    }
    if (!empty($varibles)) {
        if (!strpos($link, "?")) {
            $link .= "?";
        }
        foreach ($varibles as $key => $value) {
            $link .= $key . "=" . $value . "&";
        }
        $link = rtrim($link, "&");
    }


    return $link;
}

function module_link($module, $parameters = array(), $varibles = []) {
    $link .= DS;
    $link .= $module;
    if (!is_array($parameters)) {
        $link .= DS . $parameters;
    } else {
        if (!empty($parameters)) {
            foreach ($parameters as $pr) {
                $link .= DS . $pr;
            }
        }
    }
    if (!empty($varibles)) {
        if (!strpos($link, "?")) {
            $link .= "?";
        }
        foreach ($varibles as $key => $value) {
            $link .= $key . "=" . $value . "&";
        }
        $link = rtrim($link, "&");
    }


    return $link;
}

function site_logo($width = "ORJ") {
    $user_tema = modules::getModuleList("user");
    $cls = "table_settings_" . $user_tema;

    if (class_exists($cls)) {
        $nsettings = new $cls();
        $nsettings->add_filter("image_gallery_id");
        $nsettings->select();
        $nsettings->add_limit_end(1);
        $nsettings->add_direction("DESC");

        $settings = $nsettings->get_alldata(true);
        $image_id = $settings->image_gallery_id;
        $nimage_info = new table_image_gallery();
        $nimage_info->select();
        $nimage_info->add_condition("image_gallery_id", $image_id);
        $image_info = $nimage_info->get_alldata(true);

        return get_closest_image($image_info, $width);
    } else {
        return false;
    }
}

function class_to_array($stdclass) {
    $result = [];
    foreach ($stdclass as $key => $cls) {
        $result[$key] = $cls;
    }
    return $result;
}

function fixPre($string, $complete_count = 2, $pre = "0") {
    $_string = strval($string);
    $repeat_val = $complete_count - strlen($_string);
    if ($repeat_val != 0)
        return str_repeat($pre, $repeat_val) . $_string;
    return $_string;
}

function fix_array_null($array) {
    $result = [];
    foreach ($array as $key) {
        if ($key != null) {
            $result[] = $key;
        }
    }
    return $result;
}

function fix_array($array) {
    $result = [];
    foreach ($array as $key) {
        $result[] = $key;
    }
    return $result;
}

function removeZero($linksArray) {
    foreach ($linksArray as $key => $link) {
        if ($link === '') {
            unset($linksArray[$key]);
        }
    }
    return $linksArray;
}

function get_image_file_path($image_info, $width = "ORJ") {
    $path = ROOT . DS . rtrim($image_info->image_relative_path, "/");
    if (is_file(ROOT . DS . rtrim($image_info->image_relative_path, "/") . DS . $image_info->first_image_name . "_" . $width . DOT . $image_info->extention)) {
        return ROOT . DS . rtrim($image_info->image_relative_path, "/") . DS . $image_info->first_image_name . "_" . $width . DOT . $image_info->extention;
    } else {
        return false;
    }
}

function get_image($image_info, $width = "ORJ") {
    if (is_file(get_image_file_path($image_info, $width))) {
        return PROOT . rtrim($image_info->image_relative_path, "/") . DS . $image_info->first_image_name . "_" . $width . DOT . $image_info->extention;
    } else {
        return false;
    }
}

function get_image_variations($image_info) {
    $image_path = trim($image_info->image_folder, "/home/u8827636/public_html/");
    $path = ROOT . DS . rtrim($image_info->image_relative_path, "/");
    $image_name = $image_info->first_image_name;
    $main_image = $path . DS . $image_info->image_uniqid . DS . $image_info->first_image_name;
    $list = dirList($path);
    $resulation = [];
    foreach ($list as $img) {
        $nprepare_image = new prepare_image();
        $image_detail = $nprepare_image->explode_image_path($img);
        if ($image_name == $image_detail["first_image_name"]) {
            $imgex = explode("/", $img);
            $end = end($imgex);
            $imgresex = explode("_", $end);
            $_imgres = explode(".", $imgresex[1]);
            $res = $_imgres[0];
            if ($res != "ORJ") {
                $resulation[] = $res;
            }
        }
    }

    return $resulation;
}

function get_closest_image($image_info, $closest) {
    $resulation = get_image_variations($image_info);
    $gclosest_value = getClosest($closest, $resulation);
    if (is_file(ROOT . DS . rtrim($image_info->image_relative_path, "/") . DS . $image_info->first_image_name . "_" . $gclosest_value . DOT . $image_info->extention)) {
        return PROOT . rtrim($image_info->image_relative_path, "/") . DS . $image_info->first_image_name . "_" . $gclosest_value . DOT . $image_info->extention;
    } else {
        return false;
    }
}

function getClosest($search, $arr) {
    $closest = null;
    foreach ($arr as $item) {
        if ($closest === null || abs($search - $closest) > abs($item - $search)) {
            $closest = $item;
        }
    }
    return $closest;
}

function search_object($keyword, $array = array(), $index) {
    foreach ($array as $value) {
        if ($value->$index == $keyword) {
            return true;
        }
    }
    return false;
}

function search_array($keyword, $array = array()) {
    foreach ($array as $value) {
        if ($value == $keyword) {
            return true;
        }
    }
    return false;
}

function object_to_array($data) {
    if (is_array($data) || is_object($data)) {
        $result = array();
        foreach ($data as $key => $value) {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function exchange_rate($exchange, $exchange_currency = "tl") {
    $nproduct_settings = new table_settings_product();
    $nproduct_settings->select();
    $product_settings = $nproduct_settings->get_alldata(true);
    $default_currency = $product_settings->product_default_currency;
    if ($exchange_currency == $default_currency) {
//Girilen Para Birimi Varsayılan Para Birimine Eşitse
        return $exchange;
    } else {
        if ($exchange_currency == ANCHOR_CURRENCY) {
//Girilen Para Birimi tl ise
            $nproduct_currency = new table_settings_general_currency();
            return $exchange * $nproduct_currency->get_currency_price($default_currency);
        } else {
//Girilen Para Birimi tl değil ise
            $nproduct_currency = new table_settings_general_currency();
            return ($exchange * $nproduct_currency->get_currency_price($exchange_currency)) / $nproduct_currency->get_currency_price($default_currency);
        }
    }
}

function default_currency() {
    $nproduct_settings = new table_settings_product();
    $nproduct_settings->select();
    $product_settings = $nproduct_settings->get_alldata(true);
    return $product_settings->product_default_currency;
}

function dnd($data, $die = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($die) {
        die("Gösterim için Çalışma Durdurulmuştur");
    }
}

function noimage($type = "product", $width = "100") {
    return DS . 'assets' . DS . 'global' . DS . 'noimage' . DS . $type . DS . "noimage" . "_" . $width . DOT . "jpg";
}

function sanitize($dirty) {
    return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

function currentuser() {
    return users::$currentLoggedInUser;
}

function seccode($title = "") {
    if (strlen($title) > 3) {
        $_title = substr($title, 0, 3);
        $__title = strtoupper($_title);
    } else {
        $__title = $title;
    }
    $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    if ($__title == "") {
        $__title = $alphabet[rand(0, count($alphabet))] . $alphabet[rand(0, count($alphabet))] . $alphabet[rand(0, count($alphabet))];
    }
    return uniqid($__title);
}

function getNow($offset = "") {
    date_default_timezone_set('Europe/Istanbul');
    if ($offset != "") {
        $n = time() + $offset;
        return date("Y-m-d H:i:s", $n);
    } else {
        return date("Y-m-d H:i:s");
    }
}

function sef_link($str, $options = array()) {
    $str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
// Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function tirnak_replace($par) {
    return str_replace(array("'", "\""), array("&#39;", "&quot;"), $par);
}

function tirnak_replace_rev($par) {
    return str_replace(array("&#39;", "&quot;", "&amp;quot;"), array("'", "\"", "\""), $par);
}

function get_ipno() {
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode(',', $ip);
            $ip = trim($tmp[0]);
        }
    } else {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

function check_dir($dir) {
    if ($handle = opendir($dir)) {
        $full = FALSE;
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $full = TRUE;
            }
        }

        closedir($handle);
        return $full;
    } else {
        return FALSE;
    }
}

function check_view($dir) {
    if ($handle = opendir($dir)) {
        while (($dosya = readdir($dir)) !== false) { // While Döngüsüne girerek dosyamızı okuyoruz.
            echo "Dosya: " . $dosya . "<br >"; // Ekrana Yazdırıyoruz..
        }
        closedir($dir); //İşimiz Bitti
    } else {
        return FALSE;
    }
}

function timeConvert($zaman, $format = "Y-m-d H:i:s", $time_diff = TRUE) {
    $now = date($format, time());
    $zaman_farki = strtotime($now) - strtotime($zaman);

    if ($zaman_farki > 0) {
        $saniye = $zaman_farki;
        $dakika = round($zaman_farki / 60);
        $saat = round($zaman_farki / 3600);
        $gun = round($zaman_farki / 86400);
        $hafta = round($zaman_farki / 604800);
        $ay = round($zaman_farki / 2419200);
        $yil = round($zaman_farki / 29030400);
        if ($saniye < 60) {
            if ($saniye == 0) {
                return "az önce";
            } else {
                return $saniye . ' saniye önce';
            }
        } else if ($dakika < 60) {
            return $dakika . ' dakika önce';
        } else if ($saat < 24) {
            return $saat . ' saat önce';
        } else if ($gun < 7) {
            return $gun . ' gün önce';
        } else if ($hafta < 4) {
            return $hafta . ' hafta önce';
        } else if ($ay < 12) {
            return $ay . ' ay önce';
        } else {
            return $yil . ' yıl önce';
        }
    } else {

        $saniye = abs($zaman_farki);
        $dakika = round(abs($zaman_farki) / 60);
        $saat = round(abs($zaman_farki) / 3600);
        $gun = round(abs($zaman_farki) / 86400);
        $hafta = round(abs($zaman_farki) / 604800);
        $ay = round(abs($zaman_farki) / 2419200);
        $yil = round(abs($zaman_farki) / 29030400);
        if ($saniye < 60) {
            if ($saniye == 0) {
                return "az önce";
            } else {
                return $saniye . ' saniye Sonra';
            }
        } else if ($dakika < 60) {
            return $dakika . ' dakika Sonra';
        } else if ($saat < 24) {
            return $saat . ' saat Sonra';
        } else if ($gun < 7) {
            return $gun . ' gün Sonra';
        } else if ($hafta < 4) {
            return $hafta . ' hafta Sonra';
        } else if ($ay < 12) {
            return $ay . ' ay Sonra';
        } else {
            return $yil . ' yıl Sonra';
        }
    }
}

function KlasorSil($dir) {
    if (substr($dir, strlen($dir) - 1, 1) != '/')
        $dir .= '/';
//echo $dir; //silinen klasörün adı
    if ($handle = opendir($dir)) {
        while ($obj = readdir($handle)) {
            if ($obj != '.' && $obj != '..') {
                if (is_dir($dir . $obj)) {
                    if (!KlasorSil($dir . $obj))
                        return false;
                } elseif (is_file($dir . $obj)) {
                    if (!unlink($dir . $obj))
                        return false;
                }
            }
        }
        closedir($handle);
        if (!@rmdir($dir))
            return false;
        return true;
    }
    return false;
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city" => @$ipdat->geoplugin_city,
                        "state" => @$ipdat->geoplugin_regionName,
                        "country" => @$ipdat->geoplugin_countryName,
                        "country_code" => @$ipdat->geoplugin_countryCode,
                        "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

function kucuk_yap($gelen) {

    $gelen = str_replace('Ç', 'ç', $gelen);
    $gelen = str_replace('Ğ', 'ğ', $gelen);
    $gelen = str_replace('I', 'ı', $gelen);
    $gelen = str_replace('İ', 'i', $gelen);
    $gelen = str_replace('Ö', 'ö', $gelen);
    $gelen = str_replace('Ş', 'ş', $gelen);
    $gelen = str_replace('Ü', 'ü', $gelen);
    $gelen = strtolower($gelen);

    return $gelen;
}

function ucwords_tr($gelen) {

    $sonuc = '';
    $kelimeler = explode(" ", $gelen);

    foreach ($kelimeler as $kelime_duz) {

        $kelime_uzunluk = strlen($kelime_duz);
        $ilk_karakter = mb_substr($kelime_duz, 0, 1, 'UTF-8');

        if ($ilk_karakter == 'Ç' or $ilk_karakter == 'ç') {
            $ilk_karakter = 'Ç';
        } elseif ($ilk_karakter == 'Ğ' or $ilk_karakter == 'ğ') {
            $ilk_karakter = 'Ğ';
        } elseif ($ilk_karakter == 'I' or $ilk_karakter == 'ı') {
            $ilk_karakter = 'I';
        } elseif ($ilk_karakter == 'İ' or $ilk_karakter == 'i') {
            $ilk_karakter = 'İ';
        } elseif ($ilk_karakter == 'Ö' or $ilk_karakter == 'ö') {
            $ilk_karakter = 'Ö';
        } elseif ($ilk_karakter == 'Ş' or $ilk_karakter == 'ş') {
            $ilk_karakter = 'Ş';
        } elseif ($ilk_karakter == 'Ü' or $ilk_karakter == 'ü') {
            $ilk_karakter = 'Ü';
        } else {
            $ilk_karakter = strtoupper($ilk_karakter);
        }

        $digerleri = mb_substr($kelime_duz, 1, $kelime_uzunluk, 'UTF-8');
        $sonuc .= $ilk_karakter . kucuk_yap($digerleri) . ' ';
    }

    $son = trim(str_replace('  ', ' ', $sonuc));
    return $son;
}

function url_get_contents($url) {
    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($conn, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $url_get_contents_data = (curl_exec($conn));
        curl_close($conn);
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = fopen($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
    } else {
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}

function site_info($info) {

    $result = [];
    $user_tema = modules::getModuleList("user");
    $cls = "table_settings_" . $user_tema;
    try {
        if (class_exists($cls)) {
            $nsettings = new $cls();
            switch ($info) {
                case"logo":
                    $result = site_logo();
                    break;
                case"site_link":
                    $nsettings->add_filter("site_url_protocol,site_url");
                    $nsettings->select();
                    $nsettings->add_limit_end(1);
                    $nsettings->add_direction("DESC");
                    $settings = $nsettings->get_alldata(true);
                    $result = $settings->site_url_protocol . "://" . $settings->site_url;
                    break;
            }

            return $result;
        } else {
            return false;
        }
    } catch (Exception $ex) {
        
    }
}

function reArr($stdClass) {
    $arr = [];
    foreach ($stdClass as $key => $value) {
        $arr[$key] = $value;
    }
    return $arr;
}

function month_tr($month) {

    switch ($month) {
        case "July":
            return "Temmuz";
            break;
        case "August":
            return "Ağustos";
            break;
        case "September":
            return "Eylül";
            break;
        case "October":
            return "Ekim";
            break;
        case "November":
            return "Kasım";
            break;
        case "December":
            return "Aralık";
            break;
        case "January":
            return "Ocak";
            break;
        case "February":
            return "Şubat";
            break;
        case "March":
            return "Mart";
            break;
        case "April":
            return "Nisan";
            break;
        case "May":
            return "Mayıs";
            break;
        case "June":
            return "Haziran";
            break;
    }
}

function day_tr($day) {

    switch ($day) {
        case "Wednesday":
            return "Çarşamba";
            break;
        case "Thursday":
            return "Perşembe";
            break;
        case "Friday":
            return "Cuma";
            break;
        case "Saturday":
            return "Cumartesi";
            break;
        case "Sunday":
            return "Pazar";
            break;
        case "Monday":
            return "Pazartesi";
            break;
        case "Tuesday":
            return "Salı";
            break;
    }
}

$gunler = array(
    0 => "Pazar",
    1 => "Pazartesi",
    2 => "Salı",
    3 => "Çarşamba",
    4 => "Perşembe",
    5 => "Cuma",
    6 => "Cumartesi"
);
$aylar = array(
    1 => "Ocak",
    2 => "Şubat",
    3 => "Mart",
    4 => "Nisan",
    5 => "Mayıs",
    6 => "Haziran",
    7 => "Temmuz",
    8 => "Ağustos",
    9 => "Eylül",
    10 => "Ekim",
    11 => "Kasım",
    12 => "Aralık"
);

function kisalt($par, $uzunluk = 50) {

    if (strlen($par) > $uzunluk) {
        $par = mb_substr($par, 0, $uzunluk, "UTF-8") . " ...";
    }
    return $par;
}

function check_credicart_info($card_number, $card_name, $card_year, $card_month, $card_security_number) {
    $card_number = str_replace("/s+/", "", $card_number);
    $card_number = str_replace(" ", "", $card_number);
    $card_number = str_replace(" ", "", $card_number);
    $card_number = str_replace(" ", "", $card_number);
    $card_number = str_replace("/s/g", "", $card_number);
    $card_number = str_replace("/s+/g", "", $card_number);

    if (trim($card_number) != "") {
        if (is_numeric($card_number)) {
            if (is_numeric($card_number)) {
                if (strlen($card_number) == 16) {
                    if (trim($card_name) != "") {
                        if (is_string($card_name)) {
                            if ($card_year != "---") {
                                if ($card_month != "---") {
                                    if (trim($card_security_number)) {
                                        if (is_numeric($card_security_number)) {
                                            $data["sonuc"] = true;
                                            $data["card_number"] = $card_number;
                                        } else {
                                            $data["sonuc"] = false;
                                            $data["msg"] = "Geçerli bir Güvenlik Numarası Giriniz.";
                                        }
                                    } else {
                                        $data["sonuc"] = false;
                                        $data["msg"] = "Güvenlik Numarasını Boş Bırakmayınız.";
                                    }
                                } else {
                                    $data["sonuc"] = false;
                                    $data["msg"] = "Son Kullanma Ayını Seçiniz.";
                                }
                            } else {
                                $data["sonuc"] = false;
                                $data["msg"] = "Son Kullanma Yılını Seçiniz.";
                            }
                        } else {
                            $data["sonuc"] = false;
                            $data["msg"] = "İsim Alanı Sadece Metin Karakterlerinden Oluşmalıdır.";
                        }
                    } else {
                        $data["sonuc"] = false;
                        $data["msg"] = "İsim Alanını Boş Bırakmayınız.";
                    }
                } else {
                    $data["sonuc"] = false;
                    $data["msg"] = "Geçerli bir Kart Numarası Giriniz.";
                }
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Kart Numarası için Sayısal Bir Değer Giriniz.";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Kart Numarası için Sayısal Bir Değer Giriniz.";
        }
    } else {
        $data["sonuc"] = false;
        $data["msg"] = "Öncelikle Kart Numarasını Girmeniz Gerekmektedir.";
    }

    return $data;
}

function currency_text($currency_info, $option = true, $select = "") {

    if (is_array($currency_info)) {
        if ($currency_info["product_currency_type"] == "tl") {
            if ($option) {
                if ($selected == $currency_info["product_currency_type"]) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                return '<option value="' . $currency_info["product_currency_type"] . '" ' . $selected . '>TL</option>';
            } else {
                return "TL";
            }
        } else if ($currency_info["product_currency_type"] == "dl") {
            if ($option) {
                if ($selected == $currency_info["product_currency_type"]) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                return '<option value="' . $currency_info["product_currency_type"] . '" ' . $selected . '>DOLAR</option>';
            } else {
                return "DOLAR";
            }
        } else if ($currency_info["product_currency_type"] == "eu") {
            if ($option) {
                if ($selected == $currency_info["product_currency_type"]) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                return '<option value="' . $currency_info["product_currency_type"] . '" ' . $selected . '>EURO</option>';
            } else {
                return "EURO";
            }
        }
    } else {
        if ($currency_info->product_currency_type == "tl") {
            if ($option) {
                if ($selected == $currency_info->product_currency_type) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                return '<option value="' . $currency_info->product_currency_type . '" ' . $selected . '>TL</option>';
            } else {
                return "TL";
            }
        } else if ($currency_info->product_currency_type == "dl") {
            if ($option) {
                if ($selected == $currency_info->product_currency_type) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                return '<option value="' . $currency_info->product_currency_type . '" ' . $selected . '>DOLAR</option>';
            } else {
                return "DOLAR";
            }
        } else if ($currency_info->product_currency_type == "eu") {
            if ($option) {
                if ($selected == $currency_info->product_currency_type) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                return '<option value="' . $currency_info->product_currency_type . '" ' . $selected . '>EURO</option>';
            } else {
                return "EURO";
            }
        }
    }
}

function get_system_information() {
    if (file_exists(ROOT . DS . 'system.json')) {
        $strJsonFileContents = file_get_contents(ROOT . DS . 'system.json');
        return json_decode($strJsonFileContents);
    } else {
        die("Sistem Json Dosyası Bulunmuyor");
    }
}

function get_config_information() {
    if (file_exists(ROOT . DS . 'config.json')) {
        $strJsonFileContents = file_get_contents(ROOT . DS . 'config.json');
        return json_decode($strJsonFileContents);
    } else {
        return false;
    }
}

function search_arrays($array, $search_text) {
    $result_list = array();
    foreach ($array as $key => $params) {
        if ($key == $search_text) {
            $result_list[$key] = $params;
        } else {
            if (is_array($params)) {
                search_arrays($params, $search_text);
            }
        }
    }
    arrtolist::setList($result_list);
}

function dirToArray($dir) {
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DS . $value)) {
                $result[$value] = dirToArray($dir . DS . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function _dirToArray($dir) {
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = _dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

function dirToPath($dir) {
    $result = array();
    $path = $dir;
    if (is_dir($dir)) {
        $cdir = scandir($dir);
    }
    if (!empty($cdir)) {
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($path . DS . $value)) {
                    dirToPath($path . DS . $value);
                } else {
                    if ($value == IGNORE) {
                        $ignore_pahts = ignore($path);
                    }
                }
            }
        }
    }

    if (!empty($cdir)) {
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($path . DS . $value)) {
                    if (isset($ignore_pahts["direction"])) {
                        if (!in_array($value, $ignore_pahts["direction"])) {
                            $_dir .= DS . $value;
                            $result[] = dirToPath($path . DS . $value);
                        } else {
                            
                        }
                    } else {
                        $_dir .= DS . $value;
                        $result[] = dirToPath($path . DS . $value);
                    }
                } else {
                    if (isset($ignore_pahts["file"])) {
                        if (!in_array($value, $ignore_pahts["file"])) {
                            $rpath = $_dir . DS . $value;

                            $result[] = $rpath;
                        } else {
                            
                        }
                    } else {
                        if ($value != IGNORE) {
                            $rpath = $_dir . DS . $value;
                            $result[] = $rpath;
                        }
                    }
                }
            }
        }
    }

    return clean_ignore($result);
}

function clean_ignore($results) {

    $i = 0;
    $dt = [];
    if (!empty($results)) {
        foreach ($results as $result) {
            if (!is_array($result)) {
                $dt[$i] = ltrim($result, "/");
                if ($dt[$i] == IGNORE) {
                    unset($dt[$i]);
                }
                $i++;
            }
        }
    }
    return $dt;
}

function searchToPath($dir, $search_file) {
    $result = array();
    $path = $dir;
    if (is_dir($dir))
        $cdir = scandir($dir);

    if (!empty($cdir)) {
        foreach ($cdir as $key => $value) {
            if ($value == IGNORE) {
                $ignore_pahts = ignore($path);
            }
        }
    }

    if (!empty($cdir)) {
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($path . DS . $value)) {
                    if (isset($ignore_pahts["direction"])) {
                        if (!in_array($value, $ignore_pahts["direction"])) {
                            $_dir .= DS . $value;
                            $result[] = dirToPath($path . DS . $value);
                        } else {
                            
                        }
                    } else {
                        $_dir .= DS . $value;
                        $result[] = dirToPath($path . DS . $value);
                    }
                } else {
                    if (isset($ignore_pahts["file"])) {
                        if (!in_array($value, $ignore_pahts["file"])) {
                            $rpath = $_dir . DS . $value;
                            $result[] = $rpath;
                        }
                    } else {
                        if ($value == $search_file) {
                            $rpath = $_dir . DS . $value;
                            $result[] = $rpath;
                        }
                    }
                }
            }
        }
    }

    return $result;
}

function ignore($direction) {
    $dir = array();
    $rfile = array();
    $result = array();
    $ignore_file = $direction . DS . IGNORE;
    $file = @fopen($ignore_file, "r");
    while (!feof($file)) {
        $line = fgets($file);
        if ($line[0] == "/") {
            $dir[] = trim(substr($line, 1));
        } else {
            $rfile[] = trim($line);
        }
    }
//$rfile[] = IGNORE;
    $delete = array("", " ");
    $dirname = array_diff(array_unique($dir), $delete);
    $result["direction"] = $dirname;
    $filename = array_diff(array_unique($rfile), $delete);

    $result["file"] = $filename;
    fclose($file);
    return $result;
}

//   dnd($rpath . " - Last modified: " . date("F d Y H:i:s.", filemtime($rpath)));

function dirToInside($relative_path) {
    $result = array();
    $direction = ROOT . $relative_path;
    $path = $relative_path;
    if (is_dir($direction))
        $cdir = scandir($direction);

    if (!empty($cdir)) {
        if (in_array(IGNORE, $cdir)) {
            $ignore_pahts = ignore($direction);
        }
        foreach ($cdir as $value) {
            if (!in_array($value, array(".", ".."))) {

                if (is_dir($direction . DS . $value)) {
//$path .= DS . $value;

                    if (isset($ignore_pahts["direction"])) {
//dnd($ignore_pahts["direction"]);
                        if (!in_array($value, $ignore_pahts["direction"])) {
                            $result[$value] = dirToInside($relative_path . DS . $value);
                        }
                    } else {
                        $result[$value] = dirToInside($relative_path . DS . $value);
                    }
                } else {
// dnd($ignore_pahts["file"]);
                    if (isset($ignore_pahts["file"])) {
                        if ($ignore_pahts["file"][0] == "_tax_block.js") {
// dnd($value);
                        }
                        if (in_array($value, $ignore_pahts["file"]) === false) {
                            $result[] = $relative_path . DS . $value;
                        } else {
                            
                        }
                    } else {

                        $result[] = $relative_path . DS . $value;
                    }
                }
            }
        }
    }

    return $result;
}

function _dirToInside($dir, $relative_path = false) {

    $result = array();
    if ($relative_path) {
        $path = $relative_path . $dir;
        $r_path = $dir;
    } else {
        $path = $dir;
    }
    $cdir = scandir($path);
// dnd($path);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DS . $value)) {
                $path .= DS . $value;
                $r_path .= DS . $value;
                $result["path"][$value] = dirToInside($dir . DS . $value);
                $result["arr"][$value] = dirToInside($dir . DS . $value);
            } else {
                if (!$relative_path) {
                    $rpath = $path . DS . $value;
                    $result["path"][] = $rpath;
                    $result["arr"][] = $value;
                } else {
                    $rpath = $r_path . DS . $value;
                    $result["relative_path"][] = $rpath;
                    $result["path"][] = $path;
                    $result["arr"][] = $value;
                }
            }
        }
    }
    return $result;
}

function dirList($dir, $director = false) {
    $result = array();
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DS . $value)) {
                $result[$value] = dirList($dir . DS . $value, $director);
            } else {
                if ($director) {
                    $result[] = $dir;
                } else {
                    $result[] = $dir . DS . $value;
                }
            }
        }
    }

    return $result;
}

/**
 * 
 * @param type $array
 * @param type $ky
 * @return array
 */
function arrayToList($array = array(), $ky = "path") {
    $result = array();
    if (array_key_exists($ky, $array)) {
        if (!empty($array[$ky])) {
            foreach ($array[$ky] as $arr) {
                if (is_array($arr)) {
                    arrayToList($arr, $ky);
                } else {
                    $result[] = $arr;
                }
            }
        }
    }

    return $result;
}

function _arrayToList($array = array()) {
    $result = array();
    if (!empty($array)) {
        foreach ($array as $key => $arr) {
            if (is_array($arr)) {
                _arrayToList($arr);
            } else {
                $result[$key] = $arr;
            }
        }
    }

    arrtolist::setList($result);
}

/**
 * 
 * @param type $files
 * @return type
 */
function find_min($files = array()) {
    $temp = [];
    $temp2 = [];

    for ($i = 0; $i < count($files); $i++) {
        $index = $i;
        $file_exp = explode("/", $files[$i]);
        $file_name = end($file_exp);
        $file_name_exp = explode(".", $file_name);
        $file_extention = end($file_name_exp);
        $lstid = count($file_name_exp) - 1;
        unset($file_name_exp[$lstid]);
        $file_fname = implode(".", $file_name_exp);
        $temp[] = $file_fname;
        $tempex[] = $file_extention;
        $temp2[] = $file_name;
    }
    $ctemp = array_filter($temp);
    $delete_index = [];
    for ($i = 0; $i < count($temp); $i++) {
        $index = $i;
        $src = $temp[$i] . DOT . "min" . DOT . $tempex[$i];
        if (in_array($src, $temp2)) {
            $delete_index[] = $i;
        }
    }

    foreach ($delete_index as $index) {
        unset($files[$index]);
    }
    return $files;
}

function arrayToPluginList($array = array(), $ky = "path") {
    $result = array();
    if (array_key_exists($ky, $array)) {
        if (!empty($array[$ky])) {
            foreach ($array[$ky] as $key => $arr) {
                if (is_array($arr)) {
                    arrayToPluginList($arr, $ky);
                } else {
                    arrtolist::setList($arr);
                }
            }
        }
    }


    return $result;
}

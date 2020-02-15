<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of prepare_image
 *
 * @author engin
 */
class prepare_image {

    public function setImageFolder($media_type, $uniqid) {

        if (!is_dir(ROOT . DS . "assets" . DS . "media" . DS . $media_type)) {
            mkdir(ROOT . DS . "assets" . DS . "media" . DS . $media_type, 0777);
        }
        if (!is_dir(ROOT . DS . "assets" . DS . "media" . DS . $media_type . DS . $uniqid)) {
            mkdir(ROOT . DS . "assets" . DS . "media" . DS . $media_type . DS . $uniqid, 0777);
        }
        return ROOT . DS . "assets" . DS . "media" . DS . $media_type . DS . $uniqid; // Dosyaların Yükleneceği Konum;
    }

    public function explode_image_path($file) {
        $result = [];
        $imageex = explode("/", $file);

//        $imageex = array_unique($imageex);
//        $imageex = removeZero($imageex);

        $_lenght = count($imageex);
        $result["lenght"] = $_lenght;
        $image_name = $imageex[$_lenght - 1];
        $result["image_name"] = $image_name;
        $uniqid = $imageex[$_lenght - 2];
        $result["image_uniqid"] = $uniqid;
        $media_type = $imageex[$_lenght - 3];
        $result["media_type"] = $media_type;
        $i = 0;
        for ($i = 0; $i < $_lenght - 1; $i++) {
            $image_folder .= $imageex[$i] . "/";
            if ($i > 3) {
                $image_relative_path .= $imageex[$i] . "/";
            }
        }
        $_image_folder = rtrim($image_folder, "/");
        $result["image_folder"] = $_image_folder;

        $image_name_ex = explode(".", $image_name);
        $image_path = $image_folder . "/" . ltrim($image_name_ex[0], "/") . "_ORJ." . $image_name_ex[1];
        $result["image_relative_path"] = $image_relative_path;
        $first_image_name = $image_name_ex[0];
        $first_image_name_ex = explode("_", $first_image_name);
        if (count($first_image_name_ex) > 0) {
            $result["first_image_name"] = $first_image_name_ex[0];
        } else {
            $result["first_image_name"] = $first_image_name;
        }
        $extention = $image_name_ex[1];
        $result["extention"] = $extention;

        return $result;
    }

}

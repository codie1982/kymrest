<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image
 *
 * @author engin
 */
class image_process {

    public function __construct() {
        return true;
    }

    public function get_image($image_info, $width = "ORJ") {
        //app/tema/grnt/images/products/ZPF5d7343c3ccd76/20190907084435911010245_ORJ.jpg
        if (is_array($image_info)) {
            return DS . $image_info["image_relative_path"] . $image_info["first_image_name"] . "_" . $width . DOT . $image_info["extention"];
        } else if (is_object($image_info)) {
            return DS . $image_info->image_relative_path . $image_info->first_image_name . "_" . $width . DOT . $image_info->extention;
        }
    }

}

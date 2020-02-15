<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category_module
 *
 * @author engin
 */
class prepare_image_gallery_data extends data {

    public function __construct() {
        $this->control_tag = "images";
        return true;
    }

    public function set_new_image_gallery_data($data) {
        data::set_control_module($this->get_control_tag());
        $image_gallery_data = $this->seperate_data($data);
        $this->data_exec($image_gallery_data);
        return $this->get_control_tag();
    }

}

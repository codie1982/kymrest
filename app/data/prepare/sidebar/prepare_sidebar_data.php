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
class prepare_sidebar_data extends data {

    public function __construct() {
        $this->control_tag = "sdbbr";
        return true;
    }

    public function set_sidebar_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

}

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
class prepare_category_group_fields_data extends data {

    public function __construct() {
        $this->control_tag = "ctgry";
        return true;
    }

    public function set_category_group_fields_data($post) {

        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);

        //$data = data::integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

}

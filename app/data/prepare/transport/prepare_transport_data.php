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
class prepare_transport_data extends data {

    public function __construct() {
        $this->control_tag = rand(99, 99999);
        return true;
    }

    public function set_new_transport_settings_data($post) {
        data::set_control_module($this->get_control_tag());
        $transport_data = $this->seperate_data($post);
        $transport_data = data::integration($transport_data);
        $this->data_exec($transport_data);
        return $this->get_control_tag();
    }

}

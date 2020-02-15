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
class prepare_job_products_data extends data {

    public function __construct() {
        $this->control_tag = "s_job";
        return true;
    }

    public function set_new_job_products_data($post) {
        data::set_control_module($this->get_control_tag());
        $njob = $this->seperate_data($post);
        $njob = data::integration($njob);
        $this->data_exec($njob);
        return $this->get_control_tag();
    }

}

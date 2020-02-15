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
class prepare_job_settings_data extends data {

    public function __construct() {
        $this->control_tag = "s_product";
        return true;
    }

    public function set_new_job_settings_data($post) {
        data::set_control_module($this->get_control_tag());
        $job_settings_data = $this->seperate_data($post);
        $job_settings_data = data::integration($job_settings_data);
        $this->data_exec($job_settings_data);
        return $this->get_control_tag();
    }

}

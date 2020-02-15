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
class prepare_admin_register extends data {

    public function __construct() {
        $this->control_tag = "admucsmr";
        return true;
    }

    public function user_login_data($post) {
        data::set_control_module($this->get_control_tag());
        $admin_user_data = $this->seperate_data($post);
        $this->data_exec($admin_user_data);
        return $this->get_control_tag();
    }

    public function user_register_data($post) {
        data::set_control_module($this->get_control_tag());
        $admin_user_data = $this->seperate_data($post);
        $this->data_exec($admin_user_data);
        return $this->get_control_tag();
    }

    public function user_mail_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

}

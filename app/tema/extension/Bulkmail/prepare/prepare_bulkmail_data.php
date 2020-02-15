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
class prepare_bulkmail_data extends data {

    public function __construct() {
        $this->control_tag = "bulkmail";
        return true;
    }

    public function set_data($post) {
        data::set_control_module($this->get_control_tag());
        $bulkmail_data = $this->seperate_data($post);

        $this->integration($bulkmail_data);
        $this->data_exec($bulkmail_data);
        return $this->get_control_tag();
    }

}

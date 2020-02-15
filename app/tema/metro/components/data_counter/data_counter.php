<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sidebar
 *
 * @author engin
 */
class data_counter extends component {

    public function __construct() {
        
    }

    public function render($parameter) {
        $this->add_global_plugin("counterup");
        $this->add_global_plugin("bootstrap-confirmation");
        $this->set_component_name("data_counter");
        $this->make_component($parameter["type"]);
    }

}

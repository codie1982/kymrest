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
class tab_list extends component {

    public function __construct($parameter) {
        
    }

    public function render($parameter) {
        $this->set_component_name("tab_list");
        $this->make_component($parameter["type"]);
    }



}

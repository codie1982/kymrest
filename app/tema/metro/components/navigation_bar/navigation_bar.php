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
class navigation_bar extends component {

    public function __construct($parameter) {
        
    }

    public function render($parameter) {
        $this->set_component_name("navigation_bar");
        $this->make_component($parameter["type"]);
    }

}

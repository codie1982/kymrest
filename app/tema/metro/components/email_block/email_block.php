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
class email_block extends component {

    public function render($parameter) {
        $this->set_component_name("email_block");
        $this->make_component($parameter["type"]);
    }

}

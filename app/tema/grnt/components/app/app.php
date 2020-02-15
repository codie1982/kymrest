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
class app extends component {

    public function render($parameter) {
        $type = $parameter["type"];
        $this->set_component_name("app");
        $this->make_component($type);
    }

}

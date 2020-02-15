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
class library_content_header extends component {
    public function render($parameter) {
        $this->set_component_name("library_content_header");
        $this->make_component($parameter["type"]);
    }


}

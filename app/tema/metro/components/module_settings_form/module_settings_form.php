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
class module_settings_form extends component {

    public function render($parameter) {
        $this->add_global_plugin("makeForm");
        $this->set_component_name("module_settings_form");
        $this->make_component($parameter["type"]);
    }

}

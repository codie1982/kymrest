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
class product_price_options extends component {

    public function render($parameter) {
        $this->set_component_name("product_price_options");
        $this->make_component($parameter["type"]);
    }

  

}

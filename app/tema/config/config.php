<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tema
 *
 * @author engin
 */
class grnt extends template {

    public $template_component_list = [];

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_component_list() {

        return $this->template_component_list;
    }

    public function set_template($content, $row) {
        return html::add_div(["class" => "page-container"], $row);
    }

    public function create_tema() {
    }

}

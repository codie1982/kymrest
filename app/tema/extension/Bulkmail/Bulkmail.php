<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of metro
 *
 * @author engin
 */
class Bulkmail extends template {

    public $template_component_list = [];

    public function __construct() {
        parent::__construct();
    }

    public function get_component_list() {
        return $this->template_component_list;
    }

    public function add_component($controller) {
        //first_row-col,
        //append_row-rowpos-col,
        //inner_row-rowpos-colpos-col,
        //last_row-col,
        $component_list = [];
        switch ($controller) {
            case"admin_customers":
                $component_list[] = ["component_name" => "blkmail", "type" => "extension/Bulkmail", "position" => "append_row-0-2"];
                $component_list[] = ["component_name" => "bulk_mail_send_form", "type" => "extension/Bulkmail", "position" => "last_row-12"];
                break;
        }
        return $component_list;
    }

    public function set_template() {
        
    }

    public function create_tema() {
        
    }

    public function set_db() {
        
    }

}

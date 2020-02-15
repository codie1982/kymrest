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
class product_operations {

    public function add_component($controller) {
        //first_row-col-pos,append_row-rowpos-col,inner_row-rowpos-colpos-col,last_row-col-pos,
        $component_list = [];
        switch ($controller) {
            case"admin_products":
                $component_list[] = ["component_name" => "operations_action", "type" => "extension/product_operations", "position" => "append_row-0-2"];
                break;
        }
        return $component_list;
    }

    public function set_db() {
        
    }

}

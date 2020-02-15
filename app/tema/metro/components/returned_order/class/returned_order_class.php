<?php

/**
 * Description of class
 *
 * @author engin
 */
class returned_order_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function index($param) {
        return "#";
    }

    public function product_name($param, $id) {
        return $param;
    }

    public function product_sales_price($param, $id) {
        return "1250 TL";
    }

    public function product_count($param, $id) {
        return "16";
    }

    public function product_deneme($param, $id) {
        return "deneme";
    }

    public function actions($param, $id) {
        $result = '<div class = "btn-group">';
        $result .= '<button class = "btn btn-xs green dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> Eylemler<i class = "fa fa-angle-down"></i></button>';
        $result .= '<ul class = "dropdown-menu" role = "menu">';
        $result .= '<li><a href = "#products" table-actions="view_job_product"><i class = "fa fa-copy"></i> action </a></li>';
        $result .= '</ul>';
        $result .= '</div>';
        return $result;
    }

}

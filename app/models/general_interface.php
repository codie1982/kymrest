<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of table_interface
 *
 * @author engin
 */
interface general_interface {

    //put your code here
    public function _get_alldata($condition = array(), $direction = "DESC", $by = "default", $count = "0", $filter = null);
}

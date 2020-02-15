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
interface table_job_interface {

    public function insert_data($value);

    public function remove($key);

    public function get_data($key);

    public function get_table_name();
}

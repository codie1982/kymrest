<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of job_product_rate
 *
 * @author engin
 */
class job_product_rate {

    //put your code here
    public function __construct() {
        return true;
    }

    public function calculate_job_rate($paidPrice, $jobPrice) {
        if ($paidPrice == 0) {
            $rate = 0;
        } else {
            $rate = (doubleval($paidPrice) * 100) / doubleval($jobPrice);
        }
        if ($rate) {
            return $rate;
        } else {
            return false;
        }
    }

}

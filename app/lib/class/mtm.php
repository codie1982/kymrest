<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mtm
 *
 * @author engin
 */
class mtm {

    static function getPercent($number1, $number2, $sigma = false, $number_format = 2) {
        if ($number1 != 0 || $number2 != 0) {
            if ($sigma) {
                return number_format(ceil($number1 * $number2 / 100), $number_format) . "%";
            } else {
                return number_format(ceil($number1 * $number2 / 100), $number_format);
            }
        } else {
            return 0;
        }
    }

    static function getTaxRate($price, $taxrate, $intax) {
        if ($intax) {
            return (($price / (1 + ($taxrate / 100))));
        } else {
            return (($price * ($taxrate / 100)));
        }
    }

}

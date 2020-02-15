<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function generate_mobile_key (){
    return $key = rand(999, 9999) . "." . rand(999, 9999) . "." . rand(999, 9999) . "." . time() . rand(999, 9999);
}
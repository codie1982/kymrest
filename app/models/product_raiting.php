<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adres
 *
 * @author engin
 */
class product_raiting extends model {

    private $_selecttable;
    private $_category_list = array();
    private $_product_list = array();

    public function __construct($all = false) {
        $this->_selecttable = "product_raiting";
        parent::__construct($this->_selecttable);
    }

    public function checkProductRaiting($customer_id, $product_id) {
        if ($r = $this->query("SELECT product_raiting_id FROM $this->_selecttable  WHERE customer_id = ? AND product_id=?", [$customer_id, $product_id])->one()) {
            return $r->product_raiting_id;
        } else {
            return false;
        }
    }

    public function updateProductRaiting($customer_id, $product_id, $raiting, $product_raiting_id) {
        $fields = [
            "product_id" => $product_id,
            "customer_id" => $customer_id,
            "raiting" => $raiting,
        ];
        if ($this->update($product_raiting_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function insertProductRaiting($customer_id, $product_id, $raiting) {
        $fields = [
            "product_id" => $product_id,
            "customer_id" => $customer_id,
            "raiting" => $raiting,
            "date" => getNow(),
            "raiting_seccode" => seccode(),
        ];
        if ($this->insert($fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function getproductraitinginfo($product_id) {
       
        if ($r = $this->query("SELECT raiting FROM $this->_selecttable  WHERE product_id=?", [$product_id])->results()) {
            return $r->product_raiting_id;
        } else {
            return false;
        }
    }

    public function getproductaverageraiting($product_id) {
        if ($r = $this->query("SELECT raiting FROM $this->_selecttable  WHERE product_id=?", [$product_id])->results()) {
            $raiting;
            $count = count($r);
            foreach ($r as $rt) {
                $raiting = $raiting + $rt->raiting;
            }
            return ceil($raiting / $count);
        } else {
            return false;
        }
    }

}

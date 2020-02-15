<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of validate
 *
 * @author engin
 */
class validate {

    private $_db = null, $_passed = true, $_errors = [], $_warning = [], $_success = [];

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function check($source, $items = []) {
        $this->_errors = [];
        foreach ($items as $item => $rules) {
            $item = input::santize($item);
            $dislay = $rules["display"];
            foreach ($rules as $rule => $rule_value) {
                $value = input::santize(trim($source[$item]));
                if ($rule === "required" && empty($value)) {
                    $this->addError(["{$dislay} girmelisiniz", $item]);
                } else if (!empty($value)) {

                    switch ($rule) {
                        case "match_domain":
                            $mail = [];
                            $mail = explode("@", $value);
                            if (count($mail) > 1) {
                                if ($mail[1] != $rule_value) {
                                    $this->addError(["{$dislay} değeri <strong>www.{$rule_value}</strong> sitesine ait olmalı"]);
                                }
                            }
                            break;
                        case"min":
                            if (strlen($value) < $rule_value) {
                                $this->addError(["{$dislay} en az {$rule_value} karakterli olmalıdır", $item]);
                            }
                            break;
                        case "max":
                            if (strlen($value) >= $rule_value) {
                                $this->addError(["{$dislay} en çok {$rule_value} karakterli olmalıdır", $item]);
                            }
                            break;

                        case "matches":
                            if ($value != $source[$rule_value]) {
                                $matchDisplay = $items[$rule_value]['display'];
                                $this->addError("{$matchDisplay} ve {$dislay} değerleri aynı olmalı");
                            }
                            break;
                        case "unique":
                            $check = $this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?", [$value]);
                            if ($check->count()) {
                                $this->addError(["{$dislay} adresi bulunmaktadır. Lütfen başka bir adres seçin", $item]);
                            }
                            break;
                        case "unique_update":
                            $t = explode(",", $rule_value);
                            $table = $t[0];
                            $id = $t[1];
                            $query = $this->_db->query("SELECT * FROM {$table} WHERE $id = ? ADN {$item} = ?", [$id, $value]);
                            if ($query->count()) {
                                $this->addError(["{$dislay} adresi zaten bulunmaktadır. Lütfen başka bir adres deneyin.", $item]);
                            }
                            break;
                        case"is_numeric":
                            if (is_numeric($value)) {
                                $this->addError(["{$dislay} değeri sadece sayılardan oluşmalı. Lütfen sayı girerek tekrardan deneyin.", $item]);
                            }
                            break;
                        case"valid_email":
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError(["{$dislay} geçerli bir mail adresi giriniz.", $item]);
                            }
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
    }

    public function addError($error="") {
        $this->_errors[] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    public function addSuccess($success) {
        $this->_success[] = $success;
    }

    public function addWarning($warning) {
        $this->_warning[] = $warning;
    }

    public function get_success() {
        return array_unique($this->_success);
    }

    public function get_warning() {
        return array_unique($this->_warning);
    }

    public function get_errors() {
        return array_unique($this->_errors);
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

    public function display_errors() {
        $html = '<div class = "alert">';
        $html .= '<button class = "close" data-close = "alert"></button>';
        $html .= ' <ul class = "list-group">';
        if (!empty($this->_errors)) {
            foreach ($this->_errors as $error) {
                $html .= '<li class = "list-group-item list-group-item-danger"><span> ' . $error[0] . ' </span></li>';
            }
        }

        $html .= '</ul>';
        $html .= '</div >';
        return $html;
    }

}

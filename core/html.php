<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class html {

    private static $_instance = null;

    public function __construct() {
        return true;
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new html();
        }
        return self::$_instance;
    }

    public static function addrow($col = array(), $class = "", $form_group = false, $id = "") {
        if ($form_group) {
            $rw .= '<div class="form-group">';
        }
        $rw .= '<div id="' . $id . '" class="row ' . $class . '">';
        if (!empty($col))
            foreach ($col as $cl) {
                $i = 0;
                $space;
                $rw .= '<div class="';
                foreach ($cl as $ky => $_cl) {
                    $ky_ex = explode(",", $ky);
                    $count_ky = count($ky_ex);
                    if (!empty($ky)) {
                        if (!empty($ky_ex)) {
                            foreach ($ky_ex as $_col) {
                                $i++;
                                if ($i != 1 && $i != $count_ky) {
                                    $space = " ";
                                } else {
                                    $space = "";
                                }
                                if ($_col != 0) {
                                    if ($i == 1) {
                                        $_col_ex = explode("-", $_col);
                                        $cnt_col_ex = count($_col_ex);
                                        if ($cnt_col_ex > 1) {
                                            $rw .= $space . "col-lg-offset-$_col_ex[0] col-lg-$_col_ex[1]" . $space;
                                        } else {
                                            $rw .= $space . "col-lg-$_col" . $space;
                                        }
                                    } else if ($i == 2) {
                                        $_col_ex = explode("-", $_col);
                                        $cnt_col_ex = count($_col_ex);
                                        if ($cnt_col_ex > 1) {
                                            $rw .= $space . "col-md-offset-$_col_ex[0] col-md-$_col_ex[1]" . $space;
                                        } else {
                                            $rw .= $space . "col-md-$_col" . $space;
                                        }
                                    } else if ($i == 3) {
                                        $_col_ex = explode("-", $_col);
                                        $cnt_col_ex = count($_col_ex);
                                        if ($cnt_col_ex > 1) {
                                            $rw .= $space . "col-sm-offset-$_col_ex[0] col-sm-$_col_ex[1]" . $space;
                                        } else {
                                            $rw .= $space . "col-sm-$_col" . $space;
                                        }
                                    } else if ($i == 4) {
                                        $_col_ex = explode("-", $_col);
                                        $cnt_col_ex = count($_col_ex);
                                        if ($cnt_col_ex > 1) {
                                            $rw .= $space . "col-xs-offset-$_col_ex[0] col-xs-$_col_ex[1]" . $space;
                                        } else {

                                            $rw .= $space . "col-xs-$_col" . $space;
                                        }
                                    }
                                }
                            }
                        } else {
                            $rw .= "col-sm-12";
                        }
                    } else {
                        $rw .= "col-sm-12";
                    }
                }
                foreach ($_cl as $_ky => $__cl) {
                    if (!empty($_ky)) {
                        if ($_ky == "class") {
                            $rw .= " $__cl";
                        }
                    }
                }
                $rw .= '" ';
                foreach ($_cl as $_ky => $___cl) {
                    if (!empty($_ky)) {
                        if ($_ky == "attr") {
                            foreach ($___cl as $__k => $_v) {
                                $rw .= ' ' . $__k . '="' . $_v . '" ';
                            }
                        }
                    }
                }
                $rw .= ' > ';
                foreach ($_cl as $_ky => $__cl) {
                    if (!empty($_ky)) {
                        if ($_ky == "html") {
                            $rw .= $__cl;
                        }
                    }
                }
                $rw .= '</div>';
            }
        $rw .= '</div>';
        if ($form_group) {
            $rw .= '</div>';
        }

        return $rw;
    }

    public static function addhtmllist($attr, $li = array()) {
        $list = '<ul';
        if (!empty($attr))
            foreach ($attr as $key => $val) {
                $list .= " " . $key . '="' . $val . '" ';
            }
        $list .= '>';
        if (!empty($li)) {
            foreach ($li as $subli) {
                if (is_array($subli)) {
                    $list .= '<li';
                    if (!empty($subli["attr"]))
                        foreach ($subli["attr"] as $__key => $__val) {
                            $list .= " " . $__key . '="' . $__val . '" ';
                        }
                    $list .= '>';
                    $list .= $subli["html"];
                }
            }
            $list .= '</li>';
        }
        $list .= '</ul>';
        return $list;
    }

    public static function render($data) {
        echo $data;
    }

    public static function addimg($attr = array()) {
        $result = "<img";
        if (!empty($attr))
            foreach ($attr as $key => $val) {
                $result .= " " . $key . '="' . $val . '" ';
            }
        $result .= "/>";
        return $result;
    }

    public static function addselect($attr = array(), $option = array(), $select_item = "") {
        $result = '<select';
        if (!empty($attr))
            foreach ($attr as $key => $val) {

                $result .= " " . $key . '="' . $val . '" ';
            }
        $result .= '>';
        if (!empty($result)) {
            $first_item = $option["first_item"];
            if ($first_item == "") {
                $result .= '<option value="---">Seçim Yapınız</option>';
            } else {
                $result .= '<option value="' . $option["first_item"]["value"] . '">' . $option["first_item"]["html"] . '</option>';
            }
            foreach ($option as $key => $value) {
                if ($key == "item") {
                    foreach ($value as $val => $html) {
                        if ($select_item == $html["value"]) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        $result .= '<option value="' . $html["value"] . '" ' . $selected . '>' . $html["html"] . '</option>';
                    }
                }
            }
        }
        $result .= '</select>';
        return $result;
    }

    public static function add_tr($attr, $html = "") {
        $div = '<tr';
        if (!empty($attr))
            foreach ($attr as $key => $val) {
                $div .= " " . $key . '="' . $val . '" ';
            }
        $div .= '>' . $html . '</tr>';
        return $div;
    }

    public static function add_td($attr, $html = "") {
        $div = '<td';
        if (!empty($attr))
            foreach ($attr as $key => $val) {
                $div .= " " . $key . '="' . $val . '" ';
            }
        $div .= '>' . $html . '</td>';
        return $div;
    }

    public static function add_div($attr, $html = "") {

        $div = '<div';

        if (!empty($attr))
            foreach ($attr as $key => $val) {

                $div .= " " . $key . '="' . $val . '" ';
            }

        $div .= '>' . $html . '</div>';



        return $div;
    }

    public static function add_meta($attr = array()) {
        $result = "<meta";
        if (!empty($attr))
            foreach ($attr as $key => $val) {

                $result .= " " . $key . ' = "' . $val . '"';
            }

        $result .= "/>";

        return $result;
    }

    public static function addalink($attr = array(), $html) {
        $result = "<a";
        if (!empty($attr))
            foreach ($attr as $key => $val) {
                $result .= " " . $key . ' = "' . $val . '"';
            }
        $result .= ">$html</a>";
        return $result;
    }

    public static function addspan($attr = array(), $html = "") {

        $result = "<span";
        if (!empty($attr)) {
            foreach ($attr as $key => $val) {
                $result .= " " . $key . ' = "' . $val . '"';
            }
        } else {
            
        }
        $result .= ">$html</span>";
        return $result;
    }

    public static function addcheckbox($attr = array(), $id, $check_type = "check-complete", $html = NULL, $checked = FALSE) {

//<div class="checkbox"><input type="checkbox" value="1" id="' . $request_seccode . '" name="checkbox"><label for="' . $request_seccode . '"></label></div>
        if ($checked) {
            $check_text = "checked";
        } else {
            $check_text = "";
        }
        $col = self::addinput($attr, $id, "checkbox", $check_text);
        if (isset($attr["title"])) {
            $col .= self::addlabel(["for" => $id, "title" => $attr["title"]], $html);
        } else {
            $col .= self::addlabel(["for" => $id], $html);
        }
        return self::add_div(["class" => "checkbox $check_type"], $col);
    }

    public static function addinput($attr = array(), $id = "auto", $type = "text", $disabled = "", $checked = "", $required = "") {
        if ($id == "auto") {
            $id_text = rand(999999, 99999999);
        }
        if ($id == "") {
            $id_text = "";
        } else {
            $id_text = 'id="' . $id . '"';
        }

        $result = '<input  type="' . $type . '" ' . $id_text . ' ';

        if (!empty($attr))
            foreach ($attr as $key => $val) {

                $result .= " " . $key . ' = "' . $val . '" ';
            }

        $result .= " $disabled $checked $required />";

        return $result;
    }

    public static function addlabel($attr = array(), $html, $disabled = "") {

        $result = "<label";

        if (!empty($attr))
            foreach ($attr as $key => $val) {

                $result .= " " . $key . ' = "' . $val . '" ';
            }

        $result .= " $disabled >$html</label>";

        return $result;
    }

    public static function addbutton($attr = array(), $html, $disabled = "") {

        $result = "<button";

        if (!empty($attr))
            foreach ($attr as $key => $val) {

                $result .= " " . $key . ' = "' . $val . '" ';
            }

        $result .= " $disabled >$html</button>";

        return $result;
    }

}

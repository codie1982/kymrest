<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category_tree
 *
 * @author engin
 */
class category_tree {

    public function get_category_tree($category_tree, $select_category = 0, $style = "list", $move = false) {
// dnd($category_tree);
        if ($style == "list") {
            $result = ' <div id="category_id" class="category_tree">';
            $result .= '<ul class="sortable">';
            $result .= $this->getCategorylist($category_tree, 0, $select_category);
            $result .= '</ul>';
            $result .= ' </div>';
        } else if ($style == "select") {
            $result = '<select class="form-control" name="@category_fields$parent_category_id">';
            $result .= '<option value="---">Ana Kategori </option>';
            $result .= $this->getCategorySelect($category_tree, 0);
            $result .= '</select>';
        } else if ($style == "check_list") {
            $result .= '<ul class="list-unstyled">';
            $result .= $this->getCategoryChecklist($category_tree, 0, $select_category);
            $result .= '</ul>';
        }


        return html::render($result);
    }

    public function getCategorylist($category_tree, $parent = 0, $select_category = 0, $move = false) {
        foreach ($category_tree as $tree) {
            if ($tree->parent_category_id == $parent) {
                if ($tree->category_id == $select_category) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                //(' . $tree->category_id . ')
                $result .= ' <li class = "' . $selected . '" data-category_seccode = ' . $tree->category_seccode . '><a data-category_name="' . $tree->category_name . '" href = "' . PROOT . 'admin/categories/' . $tree->category_id . '">' . ucwords_tr($tree->category_name) . '' . $this->count_sub_category($category_tree, $tree->category_id) . '</a></li>';
                $result .= '<ul class = "sortable" style = "display:none;">';
                $result .= $this->getCategorylist($category_tree, $tree->category_id, $select_category);
                $result .= '</ul>';
            }
        }
        return $result;
    }

    public function getCategorySelect($category_tree, $parent = 0, $count = -1) {
        $count++;
        foreach ($category_tree as $tree) {
            if ($tree->parent_category_id == $parent) {
                $result .= ' <option value = "' . $tree->category_id . '">' . str_repeat("-", $count) . ' ' . ucwords_tr($tree->category_name) . ' ' . $this->count_sub_category($category_tree, $tree->category_id) . '</option>';
                $result .= $this->getCategorySelect($category_tree, $tree->category_id, $count);
            }
        }

        return $result;
    }

    public function getCategoryChecklist($category_tree, $parent = 0, $select_category = 0) {
        foreach ($category_tree as $tree) {
            if ($tree->parent_category_id == $parent) {
                if ($tree->category_id == $select_category) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $result .= '<li><label><input type = "checkbox" name = "product_categories[]" data-category="select_special_fields" value = "' . $tree->category_id . '"/>' . ucwords_tr($tree->category_name) . '</label>';
                $result .= '<ul class = "list-unstyled">';
                $result .= $this->getCategoryChecklist($category_tree, $tree->category_id, $select_category);
                $result .= '</ul>';
                $result .= '</li>';
            }
        }
        return $result;
    }

    public function count_sub_category($category_tree, $parent = 0) {
        $i = 0;
        foreach ($category_tree as $tree) {
            if ($tree->parent_category_id == $parent) {
                $i++;
            }
        }
        if ($i != 0) {
            return '(' . $i . ')';
        } else {
            return "";
        }
    }

}

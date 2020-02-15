<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of special_fields
 *
 * @author engin
 */
class page_category {

    public function get_special_fields_section($special_section_info) {
        $result = '<select class="form-control" data-category="select-special_fields" name="@category_fields$select_special_fileds">';
        if ($special_section_info) {
            $result .= '<option value = "---">Özel Alan Seçin </option>';
            foreach ($special_section_info as $in) {
                $result .= ' <option value = "' . $in->specialfields_id . '">' . ucwords_tr($in->fields_name) . '</option>';
            }
        } else {
            $result .= '<option value = "---">Özel Alan Bulunmamaktadır </option>';
        }

        $result .= '</select>';
        return html::render($result);
    }

}

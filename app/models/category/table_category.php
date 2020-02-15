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
class table_category extends general {

    private $category_list;
    private $category_columbs;

    public function __construct($all = true) {
        $this->selecttable = "category";
        parent::__construct($this->selecttable);
        $this->category_columbs = $this->get_columns();
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    /*
      foreach ($res as $r) {
      $r->primary_key = $prm;
      }
     */

    public function get_category_total_count() {
        $r = $this->query("SELECT COUNT(*) FROM $this->selecttable ", [])->one();
        return $r->{"COUNT(*)"};
    }

    public function get_sub_category($category_id) {
        $dnd = [];
        if ($sub_category = $this->get_categorylist($category_id)) {
            foreach ($sub_category as $category) {
                $dnd[] = $category;
                if ($rss = $this->get_sub_category($category->category_id)) {
                    foreach ($rss as $rsss) {
                        $dnd[] = $rsss;
                    }
                }
            }
        }
        return $dnd;
    }

    public function get_categorylist($category_id) {
        return $this->query("SELECT * FROM $this->selecttable WHERE parent_category_id=?", [$category_id])->results();
    }

    public function getcategoryInfo() {
        return $this->_category_list;
    }

    public function get_public_category_list() {
        return $this->query("SELECT * FROM category WHERE public = '1' ORDER BY sort_category ASC")->results();
    }

    public function addNewCategory($fields) {
        if ($this->insert($fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function editCategory($source) {
        if ($_POST) {
            $fields = [
                "parent_category_id" => input::santize($source["category_parent"]) == " ---" ? 0 : input::santize($source["category_parent"]),
                "category_name" => input::santize(strtolower($source["category_name"])),
                "category_name_sef" => input::santize(sef_link($source["category_name"])),
                "category_description" => strtolower(input::santize($source["category_description"])),
                "category_keywords" => strtolower(input::santize($source["category_keywords"])),
                "special_fileds" => isset($source["selected_special_fields"]) ? implode(", ", $source["selected_special_fields"]) : " ---",
            ];

            $this->update(input::santize($source["category_seccode"]), $fields, "category_seccode");
        }
    }

    public function removeCategory($category_id) {
        $ctl = $this->getChildCategoryList($category_id);
        if ($this->_db->query("DELETE FROM $this->selecttable WHERE category_id = ?", [$category_id])) {
            if (!empty($ctl)) {
                foreach ($ctl as $c) {
                    $this->_db->query("DELETE FROM $this->selecttable WHERE category_id = ?", [$c->category_id]);
                }
                return true;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getCategoryInfoFromSeccode($category_seccode) {
        try {
            $category_id = $this->get_category_id_from_seccode($category_seccode);
            return $this->_db->query("SELECT * FROM $this->selecttable WHERE category_id = ?", [$category_id])->one();
        } catch (Exception $ex) {
//dnd($ex);
        }
    }

    public function getCategoryInfoDetail($category_id, $filter = " * ") {
        $r = $this->_db->query("SELECT $filter FROM $this->selecttable WHERE category_id = ?", [$category_id])->one();
        if ($filter == " * ") {
            return $r;
        } else {
            return $r->$filter;
        }
    }

    public function getCategorykeywords($category_seccode) {
        $category_id = $this->get_category_id_from_seccode($category_seccode);
        $r = $this->_db->query("SELECT category_keywords FROM $this->selecttable WHERE category_id = ?", [$category_id])->one();
        $ex = explode(", ", $r->category_keywords);
        $rr = [];
        foreach ($ex as $k) {
            $rr[] = html_entity_decode($k);
        }
        return implode(", ", $rr);
    }

    public function checkCategoryFromSeccode($category_seccode) {
        if ($r = $this->_db->query("SELECT category_id FROM $this->selecttable WHERE category_seccode = ?", [$category_seccode])->one()) {
            return $r->category_id;
        } else {
            return false;
        }
    }

    public function checkCategory($category_name) {
        if ($r = $this->query("SELECT category_id FROM $this->selecttable WHERE category_name_sef = ?", [sef_link($category_name)])->one()) {
            return $r->category_id;
        } else {
            return false;
        }
    }

    public function get_category_id_from_seccode($category_seccode) {

        $res = $this->query("SELECT category_id FROM $this->selecttable WHERE category_seccode = ?", [$category_seccode])->one();
//throw new Exception("Value must be 1 or below");
        return $res->category_id;
    }

    public function getImageInfo($image_gallery_id) {
        return $this->_db->query("SELECT * FROM $this->selecttable WHERE image_gallery_id = ?", [$image_gallery_id])->results();
    }

    public function getParentCategoryList($selected_category = 0) {
// $selected_category = 8;
        $pt = [];
        for ($i = 0; $i < 2; $i++) {
            $selected_category;
            $ct = $this->_db->query("SELECT * FROM $this->selecttable WHERE category_id = ?", [$selected_category])->one();
            $pt[] = $ct;
            if ($ct->parent_category_id != 0) {
                $i = 0;
                $selected_category = $ct->parent_category_id;
            } else {
                break;
            }
        }
// dnd($pt);
        return array_reverse($pt);
    }

    public function getSubCategory($selected_category = 0, $limit = 0) {
// $selected_category = 8;
        if ($limit != 0) {
            $lmt = "LIMIT " . $limit;
        }
        $ct = $this->_db->query("SELECT * FROM $this->selecttable WHERE parent_category_id = ? ORDER BY sort_category ASC $lmt", [$selected_category])->results();
        return $ct;
    }

    public function getChildCategoryList($selected_category = 0, $limit = 0) {
// $selected_category = 8;
        if ($limit != 0) {
            $lmt = "LIMIT " . $limit;
        }
        $pt = [];
        $iend = 2;
        for ($i = 0; $i < $iend; $i++) {
            $ct = $this->_db->query("SELECT * FROM $this->selecttable WHERE parent_category_id = ? ORDER BY sort_category ASC $lmt", [$selected_category])->results();
            foreach ($ct as $t) {
                $pt[] = $t;
            }
            $i = 0;
            $iend = count($ct) + 1;
            $selected_category = $ct[$i]->category_id;
        }
        return $pt;
    }

    public function getChildCategoryCount($selected_category = 0, $limit = 0) {
// $selected_category = 8;
        if ($limit != 0) {
            $lmt = "LIMIT " . $limit;
        }
        $pt = [];
        $iend = 2;
        for ($i = 0; $i < $iend; $i++) {

            $ct = $this->_db->query("SELECT * FROM $this->selecttable WHERE parent_category_id = ? ORDER BY sort_category ASC $lmt", [$selected_category])->results();

            foreach ($ct as $t) {
                $pt[] = $t;
            }
            $i = 0;
            $iend = count($ct) + 1;
            $selected_category = $ct[$i]->category_id;
        }
        return count($pt);
    }

    public function _getChildCategoryCount($selected_category) {
        return $this->_db->query("SELECT * FROM $this->selecttable WHERE parent_category_id = ? ORDER BY sort_category ASC $lmt", [$selected_category])->results();
    }

    public function getCategory() {
        return $this->category_list;
    }

    public function getCategolyList($style = "select") {
        $nsite_html = new site_html();
        return $nsite_html->get_category_tree($this->category_list, "", false, $style);
    }

    public function setCategoryTable($category_gallery_info) { //Bu İsim Hatalı
        $standart_image_list = [];
        $thumbnail_image_list = [];


        foreach ($category_gallery_info as $in) {
//dnd($in);
            $img = $this->_db->query("SELECT * FROM image_gallery WHERE image_gallery_id = ?", [$in->image_gallery_id])->one();
            if (!empty($img)) {
                if ($in->image_type == "thumbnail") {
                    $thumbnail_image_list[] = reArr($img);
                } else if ($in->image_type == "standart") {
                    $standart_image_list[] = reArr($img);
                }
            }

//            $img = $this->_db->query("SELECT * FROM image_gallery WHERE image_gallery_id = ?", [$in->image_gallery_id])->one();
//            //$filename = TEMAPATH . 'image/category_gallery_form/EXC5c6c62bcf1751/201902192310361978022014_ORJ.jpg';
//            if (!empty($img)) {
//                $image_path = TEMAPATH . 'image/category_gallery_form/' . $img->image_uniqid . '/' . $img->first_image_name . '_ORJ.' . $img->extention;
//
//                $img_size_info = getimagesize($image_path);
//                $ratio = $img_size_info[0] / $img_size_info[1];
//                if ($ratio == 1) {
//                    //thumbnail image
//                    $thumbnail_image_list[] = reArr($img);
//                } else {
//                    //standart image;
//                    $standart_image_list[] = reArr($img);
//                }
//            }
        }


        $ncategory_gallery_table = new category_gallery_table($standart_image_list);
        $ncategory_gallery_table_cloumb = [
            "cloumb" => [
                ["thead_title" => "#",
                    "thead_attr" => ["style" => "width:1%", "class" => "v-align-middle text-center"],
                    "tbody_varible" => "checkbox",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Resim",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Galeri Resmi"],
                    "tbody_varible" => "gallery_image",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Yönlendirme",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Resimlerin Sırası"],
                    "tbody_varible" => "redirect",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Ana Resim",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Ana Görüntülenecek Resim"],
                    "tbody_varible" => "main_image",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Slidere Ekle",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Ana Görüntülenecek Resim"],
                    "tbody_varible" => "add_main_slider",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Resim Sırası",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Resimlerin Sırası"],
                    "tbody_varible" => "image_line",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Küçük Resim",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Referans Resim"],
                    "tbody_varible" => "image_thumbnail",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Eylemler",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "Eylemler"],
                    "tbody_varible" => "actions",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
            ]
        ];
        $ncategory_gallery_table->set_table_info($ncategory_gallery_table_cloumb);
        $ncategory_gallery_table->set_thumbnail_list($thumbnail_image_list);

        $ncategory_gallery_table->set_table_header(FALSE);
        $ncategory_gallery_table->set_table_footer(FALSE);
        return $ncategory_gallery_table->add_table(false);
    }

    public function get_category_name($category_id) {
        $res = $this->_db->query("SELECT category_name FROM $this->selecttable WHERE category_id = ?", [$category_id])->one();
        return $res->category_name;
    }

    public function get_category_sef_name($category_id) {
        $res = $this->query("SELECT category_name_sef FROM $this->selecttable WHERE category_id = ?", [$category_id])->one();
        return $res->category_name_sef;
    }

    public function getCategorySpecialFileds($category_id) {
        $r = $this->_db->query("SELECT special_fileds FROM $this->selecttable WHERE category_id = ?", [$category_id])->one();
        if ($r) {
            return $r->special_fileds;
        } else {
            return false;
        }
    }

    public function searchCategory($q) {
        $qsef = sef_link($q);
        $_qsef = "%{$qsef}%";
        $r = $this->_db->query("SELECT category_id as id,category_name as cname FROM $this->selecttable WHERE category_name_sef LIKE ? ORDER BY sort_category ASC ", [$_qsef])->results();
        if ($r) {
            return $r;
        } else {
            $r = $this->_db->query("SELECT category_id as id,category_name as cname FROM $this->selecttable  WHERE category_keywords LIKE ? ORDER BY sort_category ASC ", [$_qsef])->results();
            if ($r) {
                return $r;
            } else {
                return false;
            }
        }
    }

    public function lineCategory($category_id, $i) {
        $fields = ["line" => $i];
        if ($this->update($category_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function addCategoryMainMenu($category_id) {
        $fields = ["main_menu" => 1];
        if ($this->update($category_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function removeCategoryMainMenu($category_id) {
        $fields = ["main_menu" => 0];
        if ($this->update($category_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function check_category_name($category_name) {
        if ($_GET) {
            $qsef = input::santize(sef_link($category_name));
        }
        $r = $this->_db->query("SELECT * FROM $this->selecttable  WHERE category_name_sef = ? ORDER BY sort_category ASC ", [$qsef])->one();
        if ($r) {
            return $r;
        } else {
            return false;
        }
    }

    public function searchAllCategory($search_item) {
        $qsef = "%{$search_item}%";
        if ($results = $this->query("SELECT product_category.category_id FROM product 
            INNER JOIN product_category ON product_category.product_id=product.product_id
            WHERE product_name LIKE ? GROUP BY category_id ", [$qsef])->results()) {
            return $results;
        } else {
            return false;
        }
    }

    public function moveCategory($category_id, $target_category_id) {
        $fields = ["parent_category_id" => $target_category_id];
        if ($this->update($category_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function publicCategory($category_id, $public) {
        if ($public == "true") {
            $fields = ["public" => 1];
        } elseif ($public == "false") {
            $fields = ["public" => 0];
        }
        if ($this->update($category_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

}

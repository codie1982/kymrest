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
class table_category_gallery extends general {

    public function __construct($all = true) {
        $this->selecttable = "category_gallery";
        parent::__construct($this->selecttable);
        $this->category_gallery_columbs = $this->get_columns();
    }

//    public function get_data($primary_id = null) {
//        $prm = $this->selecttable . "_id";
//        if (is_null($primary_id)) {
//            $sql = "SELECT * FROM $this->selecttable ORDER BY $prm DESC LIMIT 1";
//            $arr = [];
//        } else {
//            $sql = "SELECT * FROM $this->selecttable WHERE $prm = ?";
//            $arr = [$primary_id];
//        }
//        if ($r = $this->query($sql, $arr)->one()) {
//            $r->primary_key = $prm;
//            return $r;
//        } else {
//            return false;
//        }
//    }
//
//    public function get_data_main_key($category_id) {
//        $prm = $this->selecttable . "_id";
//        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE category_id=?", [$category_id])->results()) {
//            foreach ($res as $r) {
//                $r->primary_key = $prm;
//            }
//            return $res;
//        } else {
//            return false;
//        }
//    }
//
//    public function insert_data($data) {
//        $primary_key = $this->selecttable . "_id";
//        if (isset($data[$primary_key])) {
//            $pr = $data[$primary_key];
//            if ($this->update($pr, $data)) {
//                return $data[$primary_key];
//            } else {
//                return false;
//            }
//        } else {
//            if ($this->insert($data)) {
//                return $this->_db->lastinsertID();
//            } else {
//                return false;
//            }
//        }
//    }
//
//    public function remove($key) {
//        if ($this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function setCategoryImageList($image_info, $category_id) {

        foreach ($image_info as $vl) {
            $galery_info = $this->_db->query("SELECT * FROM image_gallery WHERE gallery_seccode = ?", [$vl["galery_seccode"]])->one();
            // dnd($galery_info);
            if (!empty($galery_info)) {
                //$filename = TEMAPATH . 'image/category_gallery_form/EXC5c6c62bcf1751/201902192310361978022014_ORJ.jpg';
                $image_path = TEMAPATH . 'image' . DS . $galery_info->form_type . '/' . $galery_info->image_uniqid . '/' . $galery_info->first_image_name . '_ORJ.' . $galery_info->extention;

                $img_size_info = getimagesize($image_path);
                $ratio = $img_size_info[0] / $img_size_info[1];
                if ($ratio == 1) {
                    //thumbnail image
                    $image_type = "thumbnail";
                } else {
                    //standart image;
                    $image_type = "standart";
                }
            }

            $fields = [
                "category_id" => $category_id,
                "image_type" => $image_type,
                "image_gallery_id" => $galery_info->image_gallery_id,
                "date" => getNow(),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];
            $this->insert($fields);
        }
        return true;
    }

    public function category_gallery_info($category_id) {
        return $this->_db->query("SELECT * FROM $this->selecttable WHERE category_id = ? ORDER BY image_line ASC", [$category_id])->results();
    }

    public function category_gallery_mainimage_info($category_id) {
        return $this->_db->query("SELECT * FROM $this->selecttable WHERE category_id = ? && main_image = ? ORDER BY image_line ASC", [$category_id, 1])->one();
    }

    public function getImageGalleryID($category_gallery_id) {
        $img_info = $this->_db->query("SELECT image_gallery_id FROM $this->selecttable WHERE category_gallery_id = ? ", [$category_gallery_id])->one();
        return $img_info->image_gallery_id;
    }

    public function getImageThumbnailID($category_gallery_id) {
        $img_info = $this->_db->query("SELECT thumbnail  FROM $this->selecttable WHERE category_gallery_id = ? ", [$category_gallery_id])->one();
        return $img_info->thumbnail;
    }

    public function remove_category_gallery_image($category_gallery_id) {
        return $this->_db->query("DELETE FROM $this->selecttable WHERE category_gallery_id = ?", [$category_gallery_id]);
    }

    public function addImageThumbnail($main_image_id, $thumbnail_id) {
        $fields = [
            "thumbnail" => $thumbnail_id,
        ];
        if ($this->update($main_image_id, $fields, "category_gallery_id")) {
            return true;
        } else {
            return false;
        }
    }

    public function get_category_image_redirect($category_gallery_id) {
        //echo "SELECT redirect FROM $this->selecttable WHERE category_gallery_id = '$category_gallery_id'";
        $res = $this->query("SELECT redirect FROM $this->selecttable WHERE category_gallery_id = ?", [$category_gallery_id])->one();
        return $res->redirect;
    }

    public function get_category_id($category_gallery_id) {
        $res = $this->query("SELECT category_id FROM $this->selecttable WHERE category_gallery_id = ?", [$category_gallery_id])->one();
        return $res->redirect;
    }

    public function updateImage($category_gallery_id, $label, $main_image, $image_line, $main_image_redirect) {
        //Ana İmage için öncekileri kontrol etmemiz gerekiyor
        //Kategorisindeki diğer imajların ana resim değerlerini sıfırlamamın gerekiyor
        if ($main_image == 1) {
            $category = $this->_db->query("SELECT category_id FROM $this->selecttable WHERE category_gallery_id = ? ", [$category_gallery_id])->one();
            $category_id = $category->category_id;
            $fields = [
                "main_image" => 0
            ];
            if ($this->update($category_id, $fields, "category_id")) {
                $fields = [
                    "label" => $label,
                    "main_image" => $main_image,
                    "image_line" => $image_line,
                    "redirect" => $main_image_redirect,
                ];
                if ($this->update($category_gallery_id, $fields, "category_gallery_id")) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $fields = [
                "label" => $label,
                "image_line" => $image_line,
                "redirect" => $main_image_redirect,
            ];
            if ($this->update($category_gallery_id, $fields, "category_gallery_id")) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function addImageMainSlider($category_gallery_id) {
        $fields = ["slider_image" => 1];
        if ($this->update($category_gallery_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function removeImageMainSlider($category_gallery_id) {
        $fields = ["slider_image" => 1];
        if ($this->update($category_gallery_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

}

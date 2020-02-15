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
class table_product_gallery extends general {


    public function __construct($all = true) {
        $this->selecttable = "product_gallery";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

//   public function get_data($primary_id = null) {
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
//
//    public function get_data_main_key($product_id) {
//        $prm = $this->selecttable . "_id";
//        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE product_id=?", [$product_id])->results()) {
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

    public function get_product_first_image($product_id, $width = "ORJ") {
//        dnd("SELECT * FROM $this->selecttable 
//            INNER JOIN image_gallery ON $this->selecttable.image_gallery_id=image_gallery.image_gallery_id
//             WHERE product_id= '$product_id' ORDER BY $this->selecttable.product_gallery_id DESC LIMIT 1");

        $image_info = $this->query("SELECT * FROM $this->selecttable 
            INNER JOIN image_gallery ON $this->selecttable.image_gallery_id=image_gallery.image_gallery_id
             WHERE product_id= ? ORDER BY $this->selecttable.product_gallery_id DESC LIMIT 1", [$product_id])->one();
//        dnd($image_info);
        if ($image_info) {
            return PROOT . $image_info->image_relative_path . DS . $image_info->first_image_name . "_" . $width . DOT . $image_info->extention;
        } else {
            return false;
        }
    }

    public function getProductGallery($product_id, $filter = " * ") {
        $r = $this->_db->query("SELECT $filter FROM $this->selecttable 
            INNER JOIN image_gallery ON product_gallery.image_gallery_id=image_gallery.image_gallery_id
             WHERE product_id= ? ORDER BY image_line DESC", [$product_id])->results();
        return $r;
    }

    public function getProductFirstImageId($product_id, $filter = " * ") {
        $r = $this->_db->query("SELECT $this->selecttable.image_gallery_id FROM $this->selecttable 
            INNER JOIN image_gallery  ON image_gallery.image_gallery_id=$this->selecttable.image_gallery_id WHERE $this->selecttable.first_image= ? AND  $this->selecttable.product_id= ? ", [1, $product_id])->results();
        if (!$r) {
            $r = $this->_db->query("SELECT $this->selecttable.image_gallery_id FROM $this->selecttable 
            INNER JOIN image_gallery  ON image_gallery.image_gallery_id=$this->selecttable.image_gallery_id WHERE $this->selecttable.product_id= ? ", [$product_id])->one();
            if ($filter == " * ") {
                return $r;
            } else {
                return $r->$filter;
            }
        } else {
            if ($filter == " * ") {
                return $r[0];
            } else {
                return $r[0]->$filter;
            }
        }
    }

    public function checkProductGallery($sc) {
        if ($this->_db->query("SELECT * FROM product_gallery WHERE image_gallery_id = ? ", [$sc])->one()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductGalleryIdFromSeccode($product_gallery_seccode) {
        $r = $this->_db->query("SELECT product_gallery_id FROM $this->selecttable WHERE product_gallery_seccode= ? ", [$product_gallery_seccode])->one();
        return $r->product_gallery_id;
    }

    public function getImageGallery($procudt_gallery_id) {
        $r = $this->_db->query("SELECT image_gallery_id FROM $this->selecttable WHERE product_gallery_id= ? ", [$procudt_gallery_id])->one();
        return $r->image_gallery_id;
    }

    public function removeProductGalleryImage($procudt_gallery_id) {
        return $this->_db->query("DELETE FROM $this->selecttable WHERE product_gallery_id= ? ", [$procudt_gallery_id]);
    }

    public function addNewProduct_imagelist($product_gallery_image, $productid, $image_line, $first_image) {

        foreach ($product_gallery_image as $im) {
            $i++;
            if ($im == $first_image) {
                $fm = 1;
            } else {
                $fm = 0;
            }
            $fields = [
                "product_id" => $productid,
                "image_gallery_id" => $im,
                "first_image" => $fm,
                "image_line" => $i,
                "date" => getNow(),
                "product_gallery_seccode" => seccode(),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME)
            ];
            $this->insert($fields);
        }
        return true;
    }

    public function addNewProduct_image($image_id, $productid, $image_line, $first_image) {
        $fields = [
            "product_id" => $productid,
            "image_gallery_id" => $image_id,
            "first_image" => $first_image,
            "image_line" => $image_line,
            "date" => getNow(),
            "product_gallery_seccode" => seccode(),
            "users_id" => session::get(CURRENT_USER_SESSION_NAME)
        ];

        $this->insert($fields);
        return true;
    }

    public function updateProduct_image($image_id, $image_line, $first_image) {
        $fields = [
            "first_image" => $first_image,
            "image_line" => $image_line,
        ];
        $this->update($image_id, $fields, "image_gallery_id");
        return true;
    }

}

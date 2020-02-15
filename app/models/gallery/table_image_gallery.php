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
class table_image_gallery extends general {

    public function __construct() {
        $this->selecttable = "image_gallery";
        parent::__construct($this->selecttable);
    }

    public function getImageFromSeccode($img_seccode) {
        return $this->query("SELECT * FROM $this->selecttable WHERE gallery_seccode = ? ORDER BY image_gallery_id DESC LIMIT 1", [$img_seccode])->one();
    }

    public function checkImageGallery($sc) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE gallery_seccode = ? ", [$sc])->one()) {
            return true;
        } else {
            return false;
        }
    }

    public function getImageIDFromSeccode($img_seccode) {
        $r = $this->query("SELECT image_gallery_id  FROM $this->selecttable WHERE gallery_seccode = ? ORDER BY image_gallery_id DESC LIMIT 1", [$img_seccode])->one();
        return $r->image_gallery_id;
    }

    public function removeImage($image_gallery_id) {
        $img_info = $this->query("SELECT * FROM $this->selecttable WHERE image_gallery_id = ? ", [$image_gallery_id])->one();

        //$filename = TEMAPATH . 'image/category_gallery_form/EXC5c6c62bcf1751/201902192310361978022014_ORJ.jpg';
        $filename = TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_ORJ.' . $img_info->extention;
        if (file_exists($filename)) {
            //ORJ Dosyası ve Kalsörü sistemde kalır çok gerekirse kurtarma yapabiliriz.
            @unlink(TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_100.' . $img_info->extention);
            @unlink(TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_1000.' . $img_info->extention);
            @unlink(TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_1400.' . $img_info->extention);
            @unlink(TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_250.' . $img_info->extention);
            @unlink(TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_300.' . $img_info->extention);
            @unlink(TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_500.' . $img_info->extention);
        } else {
            //Dosya Bulunamıyor
        }

        if ($this->query("DELETE FROM $this->selecttable WHERE image_gallery_id= ? ", [$image_gallery_id])) {
            return true;
        } else {
            return false;
        }
    }

    public function add_new_gallery_item($data) {
        if ($this->insert($data)) {
            return $this->_db->lastinsertID();
        } else {
            return false;
        }
    }

    public function get_image_from_uniqid($uniqid) {
        $img_list = $this->query("SELECT * FROM $this->selecttable WHERE image_uniqid = ? ", [$uniqid])->results();
        if ($img_list) {
            return $img_list;
        } else {
            return false;
        }
    }

    public function setGalleryImage($image_info, $user_id, $file) {
        $gallery_seccode = seccode("IMG");
        $fields = [
            "form_type" => $image_info["form_type"],
            "image_name" => $image_info["image_name"],
            "file" => $file,
            "image_uniqid" => $image_info["uniqid"],
            "image_folder" => $image_info["image_folder"],
            "first_image_name" => $image_info["first_image_name"],
            "extention" => $image_info["extention"],
            "gallery_seccode" => $gallery_seccode,
            "date" => getNow(),
            "users_id" => $user_id,
        ];
        if ($this->insert($this->selecttable, $fields)) {
            return $gallery_seccode;
        } else {
            return false;
        }
    }

    public function get_image_info($image_gallery_id) {
        $img_info = $this->query("SELECT * FROM $this->selecttable WHERE image_gallery_id = ? ", [$image_gallery_id])->one();
        if ($img_info) {
            return $img_info;
        } else {
            return false;
        }
    }

    public function getImage($image_gallery_id, $width = "ORJ", $asfile = false) {
        $img_info = $this->query("SELECT * FROM $this->selecttable WHERE image_gallery_id = ? ", [$image_gallery_id])->one();
        $filename = TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_ORJ.' . $img_info->extention;
        if ($asfile) {
            return TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_' . $width . '.' . $img_info->extention;
        } else {
            if (file_exists($filename)) {
                return TEMAIMAGEPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $img_info->first_image_name . '_' . $width . '.' . $img_info->extention;
            } else {
                //noimage diye bir resim döndürebiliriz
                return false;
            }
        }
    }

    public function getCropImage($image_gallery_id, $product_job_seccode, $width = "ORJ", $asfile = false) {

        $img_info = $this->query("SELECT * FROM $this->selecttable WHERE image_gallery_id = ? ", [$image_gallery_id])->one();

        $filename = TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $product_job_seccode . DS . $img_info->first_image_name . '_' . $width . '.' . $img_info->extention;

        if ($asfile) {
            return TEMAPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $product_job_seccode . DS . $img_info->first_image_name . '_' . $width . '.' . $img_info->extention;
        } else {
            if (file_exists($filename)) {
                return TEMAIMAGEPATH . 'image' . DS . $img_info->form_type . DS . $img_info->image_uniqid . DS . $product_job_seccode . DS . $img_info->first_image_name . '_' . $width . '.' . $img_info->extention;
            } else {

                //noimage diye bir resim döndürebiliriz
                return false;
            }
        }
    }

    public function getImageInfo($image_gallery_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE image_gallery_id = ? ", [$image_gallery_id])->one()) {
            return $r;
        } else {
            return false;
        }
    }

}

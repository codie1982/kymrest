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
class middelslider_gallery extends model {

    private $_selecttable;

    public function __construct($all = true) {
        $this->_selecttable = "middelslider_gallery";
        parent::__construct($this->_selecttable);
    }

    public function getGalleryImageIDfromSeccode($gallery_seccode) {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            $this->_selecttable.image_gallery_id=image_gallery.image_gallery_id WHERE image_gallery.gallery_seccode =?  ", [$gallery_seccode])->one()) {
            return $r->image_gallery_id;
        } else {
            return false;
        }
    }

    public function setBannerPublic($public_value, $image_gallery_id) {
        $fields = ["slider_image" => $public_value];
        if ($this->update($image_gallery_id, $fields, "image_gallery_id")) {
            return true;
        } else {
            return false;
        }
    }

    public function setUpdateTargetUrl($target_url, $image_gallery_id) {
        $fields = ["target_url" => $target_url];
        if ($this->update($image_gallery_id, $fields, "image_gallery_id")) {
            return true;
        } else {
            return false;
        }
    }

    public function addgalleryimage($image_info) {

        foreach ($image_info as $vl) {
            $galery_info = $this->_db->query("SELECT image_gallery_id FROM image_gallery WHERE gallery_seccode = ?", [$vl["galery_seccode"]])->one();
            // dnd($galery_info);
            if ($i == 1) {
                $mainimage = 1;
            } else {
                $mainimage = 0;
            }
            $fields = [
                "image_gallery_id" => $galery_info->image_gallery_id,
                "main_image" => $mainimage,
                "date" => getNow(),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];
            $this->insert($fields);
            $i++;
        }
        return true;
    }

    public function middelslider_gallery_info() {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            middelslider_gallery.image_gallery_id =image_gallery.image_gallery_id ORDER BY $this->_selecttable.line ASC ")->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getmiddelslidermain() {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            middelslider_gallery.image_gallery_id =image_gallery.image_gallery_id WHERE slider_image='1' ORDER BY $this->_selecttable.line ASC  ")->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function removemiddelslider_item($gallery_seccode) {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            middelslider_gallery.image_gallery_id=image_gallery.image_gallery_id WHERE image_gallery.gallery_seccode =?  ", [$gallery_seccode])->one()) {

            if ($this->delete($r->middelslider_gallery_id)) {
                return $r->image_gallery_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setmiddelsliderTable($middelslider_gallery_info, $show = 10, $start = 0, $end = 10, $total = 30, $message = "") {
        //  dnd($middelslider_gallery_info);
        $nmiddel_slider_table = new middel_slider_table($middelslider_gallery_info);
        $nmiddel_slider_table->set_error_message($message);
        $nmiddel_slider_table_cloumb = [
            "cloumb" => [
                ["thead_title" => "#",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center"],
                    "tbody_varible" => "checkbox",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Resimler",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle", "title" => "ürün adı"],
                    "tbody_varible" => "image_name",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold"],
                ],
                ["thead_title" => "Bağlantı",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "Slider'a Ekle"],
                    "tbody_varible" => "link",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Slidera Ekle",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "Slider'a Ekle"],
                    "tbody_varible" => "add_slider",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Eylemler",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle ", "title" => "eylemler"],
                    "tbody_varible" => "actions",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
            ]
        ];

        /*
          ["thead_title" => "Ödeme Yöntemi",
          "thead_attr" => ["class" => "v-align-middle text-center", "title" => "ürün ödeme yöntemi"],
          "tbody_varible" => "product_payment_method",
          "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
          ],
          ["thead_title" => "Gönderim Şekli",
          "thead_attr" => ["class" => "v-align-middle text-center", "title" => "ürün gönderim şekli"],
          "tbody_varible" => "product_product_transport_type",
          "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
          ], */
        $nmiddel_slider_table->set_table_info($nmiddel_slider_table_cloumb);
        $nmiddel_slider_table->set_show_item($show);
        $nmiddel_slider_table->set_start_item($start);
        $nmiddel_slider_table->set_end_item($end);
        $nmiddel_slider_table->set_total_item($total);
        $nmiddel_slider_table->set_table_header(FALSE);
        $nmiddel_slider_table->set_table_footer(true);
        $nmiddel_slider_table->set_product_count(10);
        return $nmiddel_slider_table->add_table(false);
    }

    public function sortImageList($gallery_seccode = array()) {

        if (is_array($gallery_seccode)) {
            $i = 0;
            foreach ($gallery_seccode as $seccode) {
                $r = $this->query("SELECT $this->_selecttable.image_gallery_id FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            $this->_selecttable.image_gallery_id=image_gallery.image_gallery_id WHERE image_gallery.gallery_seccode =?  ", [$seccode])->one();
                $image_gallery_id = $r->image_gallery_id;
                $i++;
                $fields = ["line" => $i];
                $this->update($image_gallery_id, $fields, "image_gallery_id");
            }
        } else {
            return false;
        }
    }

}

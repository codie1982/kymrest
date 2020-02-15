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
class topban_gallery extends model {

    private $_selecttable;

    public function __construct($all = true) {
        $this->_selecttable = "topban_gallery";
        parent::__construct($this->_selecttable);
    }

    public function addgalleryimage($image_info) {

        foreach ($image_info as $vl) {
            $galery_info = $this->_db->query("SELECT image_gallery_id FROM image_gallery WHERE gallery_seccode = ?", [$vl["galery_seccode"]])->one();
            // dnd($galery_info);
            $fields = [
                "image_gallery_id" => $galery_info->image_gallery_id,
                "public" => 1,
                "date" => getNow(),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];
            $this->insert($fields);
            $i++;
        }
        return true;
    }

    public function gallery_info() {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            $this->_selecttable.image_gallery_id=image_gallery.image_gallery_id ORDER BY $this->_selecttable.line ASC")->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getTopBannerInfo() {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            $this->_selecttable.image_gallery_id=image_gallery.image_gallery_id WHERE $this->_selecttable.public='1' ORDER BY $this->_selecttable.line ASC ")->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function removeTopbanItem($gallery_seccode) {
        if ($r = $this->query("SELECT * FROM $this->_selecttable 
            INNER JOIN image_gallery ON
            $this->_selecttable.image_gallery_id=image_gallery.image_gallery_id WHERE image_gallery.gallery_seccode =?  ", [$gallery_seccode])->one()) {

            if ($this->delete($r->topban_gallery_id)) {
                return $r->image_gallery_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
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
        $fields = ["public" => $public_value];
        if ($this->update($image_gallery_id, $fields, "image_gallery_id")) {
            return true;
        } else {
            return false;
        }
    }

    public function setBannerBackground($background_color, $image_gallery_id) {
        $fields = ["background" => ltrim($background_color, "#")];
        if ($this->update($image_gallery_id, $fields, "image_gallery_id")) {
            return true;
        } else {
            return false;
        }
    }

    public function settopbanTable($gallery_info, $show = 10, $start = 0, $end = 10, $total = 30, $message = "") {
        //  dnd($middelslider_gallery_info);
        $ntopban_table = new topban_table($gallery_info);
        $ntopban_table->set_error_message($message);
        $ntopban_table_cloumb = [
            "cloumb" => [
                ["thead_title" => "#",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center"],
                    "tbody_varible" => "checkbox",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "imaj",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle", "title" => "Resim"],
                    "tbody_varible" => "image",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold"],
                ],
                ["thead_title" => "background",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "Arka Plan"],
                    "tbody_varible" => "background",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Aktif",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "Arka Plan"],
                    "tbody_varible" => "image_public",
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
        $ntopban_table->set_table_info($ntopban_table_cloumb);
        $ntopban_table->set_show_item($show);
        $ntopban_table->set_start_item($start);
        $ntopban_table->set_end_item($end);
        $ntopban_table->set_total_item($total);
        $ntopban_table->set_table_header(FALSE);
        $ntopban_table->set_table_footer(true);
        $ntopban_table->set_product_count(10);
        return $ntopban_table->add_table(false);
    }

}

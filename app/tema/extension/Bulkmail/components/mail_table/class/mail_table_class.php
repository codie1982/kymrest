<?php

/**
 * Description of class
 *
 * @author engin
 */
class mail_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function mail_adres($src) {
        if ($src["public"] == 1) {
            return'<span class="label label-sm label-success" data-product="public"  data-place="span" data-product_seccode= "' . $src->product_seccode . '" title="Yayından Al Durdur" > <span class="fa fa-play"></span></span>';
        } else {
            return '<span class="label label-sm label-danger" data-product="public"  data-place="span" data-product_seccode= "' . $src->product_seccode . '" title="Yayına Al"> <span class="fa fa-pause"></span></span>';
        }
    }

    public function mail_subject($src) {
        return $src["product_code"];
    }

    public function mail_see($src, $random) {
        return '<input type="hidden" name="morris_element" value="' . $random . '" />' . '<div id="' . $random . '" style="height: 50px;padding:0;margin:0;"></div>';
    }

    public function mail_send_date($src) {
        $nproduct_gallery = new table_product_gallery();
        if ($image = $nproduct_gallery->get_product_first_image($src["product_id"], 100)) {
            $col = [];
            $col[] = ["4,4,4,4" => ["html" => html::addimg(["src" => $image, "alt" => "product_image"])]];
            $col[] = ["8,8,8,8" => ["html" => ucfirst(html_entity_decode($src["product_name"]))]];
        } else {
            $col = [];
            $col[] = ["4,4,4,4" => ["html" => html::addimg(["src" => noimage("product", 100), "alt" => "product_image"])]];
            $col[] = ["8,8,8,8" => ["html" => ucfirst(html_entity_decode($src["product_name"]))]];
        }
        return html::addrow($col);
    }

    public function mail_see_date($src) {
        $product_id = $src["product_id"];
        $nproduct_category = new table_product_category();
        $category_count = $nproduct_category->get_product_category_count($product_id);
        return html::addspan([], "Ürün" . $category_count . " adet kategoride ekli");
    }

    public function diff($src) {
        if ($src["product_nostock"] == 1) {
            $stok_type = "danger";
            $stock_text = "Stok Yok";
        } else {
            if ($src["product_stock"] >= 0 && $src["product_stock"] < 5) {
                $stok_type = "danger";
            } else if ($src["product_stock"] >= 5 && $src["product_stock"] < 15) {
                $stok_type = "warning";
            } else if ($src["product_stock"] >= 15 && $src["product_stock"] < 25) {
                $stok_type = "info";
            } else if ($src["product_stock"] >= 25) {
                $stok_type = "success";
            }
            $stock_text = $src["product_stock"];
        }
        return html::addspan(["class" => 'label label-sm label-' . $stok_type, "style" => "font-size:13px;"], $stock_text);
    }

    public function mail_action($src) {
        $product_id = $src["product_id"];
        $nproduct_module = new product_module();
        $product_payment_method = $nproduct_module->get_product_payment_method($product_id);
        foreach ($product_payment_method["payment_method"] as $payment_method) {
            $payment_methodtext .= '<span class="label label-sm label-success tag label label-info label-info-hover" title="' . ucwords_tr(strtolower($payment_method["title"]), "utf-8") . '" style="cursor:pointer">' . strtoupper($payment_method["short_title"]) . '</span>';
        }
        return $payment_methodtext;
    }

    public function actions($src) {

        $content = html::addbutton(["class" => "btn btn-xs green dropdown-toggle", "type" => "button", "data-toggle" => "dropdown", "aria-expanded" => "false"], "Eylemler" . html::addspan(["class" => "fa fa-angle-down"]));
//$li[] = ["attr" => ["class" => "fs-12 $promotion"], "html" => html::addalink(["class" => "text-black", "href" => URL . "/company/me/promotion", "role" => "tab"], "Reklamlarım")];
        $li = [];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "mail_content",
                        "data-modal" => "#mail_content_form",
                        "data-component_action" => "load",
                        "data-component_key" => "send_mail_id",
                        "data-component_data" => $src["send_mail_id"],
                        "data-starter" => "form",
                    ]
                    , "Mail Formunu Göster")
        ];

        $content .= html::addhtmllist(["class" => "dropdown-menu", "role" => "menu"], $li);
        $btn = html::add_div(["class" => "btn-group"], $content);


        return $btn;
    }

}

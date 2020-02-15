<?php

/**
 * Description of class
 *
 * @author engin
 */
class product_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function product_public($src) {
        if ($src["public"] == 1) {
            return'<span class="label label-sm label-success" data-public_state="pause_product" component_title="product_form" component_data="' . $src["product_id"] . '"  title="Yayından Al Durdur" style = "cursor:pointer" > <span class="fa fa-play"></span></span>';
        } else {
            return '<span class="label label-sm label-danger" data-public_state="public_product" component_title="product_form" component_data="' . $src["product_id"] . '"   title="Yayına Al" style = "cursor:pointer"> <span class="fa fa-pause"></span></span>';
        }
    }

    public function product_favorite($src) {
        if ($src["favorite"] == 0) {
            return'<span class="label label-sm label-success" data-favorite="add_favorite" component_title="product_form"  component_data="' . $src["product_id"] . '" title = "Favorilere Ekle" style = "cursor:pointer" > <span class = "fa fa-star-o"></span></span>';
        } else {
            return '<span class = "label label-sm label-success" data-favorite="remove_favorite" component_title="product_form"  component_data="' . $src["product_id"] . '" title = "Favorilerden Çıkar" style = "cursor:pointer"> <span class = "fa fa-star"></span></span>';
        }
    }

    public function product_code($src) {
        return $src["product_code"];
    }

    public function product_deneme($src, $random) {
        return '<input type = "hidden" name = "morris_element" value = "' . $random . '" />' . '<div id = "' . $random . '" style = "height: 50px;padding:0;margin:0;"></div>';
    }

    public function product_name($src) {
        $nproduct_gallery = new table_product_gallery();
        if ($image = $nproduct_gallery->get_product_first_image($src["product_id"], 100)) {
            $col = [];
            $col[] = ["4,4,4,4" => ["html" => html::addimg(["src" => $image, "alt" => "product_image"])]];
            $col[] = ["8,8,8,8" => ["html" => ucfirst(html_entity_decode($src["product_name"]))]];
        } else {
            $col = [];
            //  $col[] = ["4,4,4,4" => ["html" => html::addimg(["src" => noimage("product", 100), "alt" => "product_image"])]];
            $col[] = ["12,12,12,12" => ["html" => ucfirst(html_entity_decode($src["product_name"]))]];
        }
        return html::addrow($col);
    }

    public function product_category($src) {
        $product_id = $src["product_id"];
        $nproduct_category = new table_product_category();
        $category_count = $nproduct_category->get_product_category_count($product_id);
        return html::addspan([], "Ürün" . $category_count . " adet kategoride ekli");
    }

    public function product_stock($src) {
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

    public function product_price($src) {

        $nproduct_module = new product_module();
        $active_price = $nproduct_module->get_product_price($src["product_id"]);
        if ($src["product_intax"]) {
            $tax_text = " ";
        } else {
            $tax_text = " + KDV";
        }
        return html::addspan(["style" => "font-size:13px;padding:0"], number_format($active_price["product_price"], 2) . "  " . strtoupper($active_price["product_price_unit"]) . $tax_text);
    }

    public function product_discount($src) {
        if ($src["product_discount_price"] == 0) {
            return html::addspan(["class" => "label label-sm label-danger", "style" => "font-size:13px;"], "İndirim Yok");
        } else {
            $nproduct_module = new product_module();
            $product_id = $src["product_id"];
            $product_discount = $nproduct_module->get_product_discount($product_id);
            return html::addspan(["class" => "label label-sm label-info", "style" => "font-size:13px;"], $product_discount["discount_rate"] . " %");
        }
    }

   

    public function product_tax($src, $random) {
        $nproduct_module = new product_module();
        $product_id = $src["product_id"];
        $product_tax_price = $nproduct_module->get_product_tax_price($product_id);
//        dnd($product_tax_price);
        return html::addspan(["class" => "label label-sm label-info", "style" => "font-size:13px;"], "% " . number_format($product_tax_price["product_tax_rate"], 2));
    }

    public function product_sales_price($src, $random) {
        $nproduct_module = new product_module();
        $product_id = $src["product_id"];
        $product_sales_price = $nproduct_module->get_product_sales_price($product_id);
        return html::addspan(["class" => "label label-sm label-info", "style" => "font-size:13px;"], number_format($product_sales_price["product_sales_price"], 2) . " " . strtoupper($product_sales_price["product_sales_price_unit"]));
    }

    public function actions($src) {

        $content = html::addbutton(["class" => "btn btn-xs green dropdown-toggle", "type" => "button", "data-toggle" => "dropdown", "aria-expanded" => "false"], "Eylemler" . html::addspan(["class" => "fa fa-angle-down"]));
//$li[] = ["attr" => ["class" => "fs-12 $promotion"], "html" => html::addalink(["class" => "text-black", "href" => URL . "/company/me/promotion", "role" => "tab"], "Reklamlarım")];
        $li = [];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "product_form",
                        "data-modal" => "#products",
                        "data-component_action" => "get_copy_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => $src["product_id"],
                        "data-starter" => "form",
                    ]
                    , "Ürünü Kopyala")
        ];
        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "product_form",
                        "data-modal" => "#products",
                        "data-component_action" => "get_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => "{$src["product_id"]}",
                        "data-starter" => "form",
                    ]
                    , "Ürünü Düzenle")
        ];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "product_form",
                        "data-component_action" => "go_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => $src["product_id"],
                    ]
                    , "Ürünü Git")
        ];
        if ($src["public"] == 1) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "product_form",
                            "data-component_action" => "pause_product",
                            "data-component_key" => "product_id",
                            "data-component_data" => $src["product_id"],
                        ]
                        , "Durdur")
            ];
        } else {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "product_form",
                            "data-component_action" => "public_product",
                            "data-component_key" => "product_id",
                            "data-component_data" => $src["product_id"],
                        ]
                        , "Yayınla")
            ];
        }




        $li[] = ["attr" => ["class" => "divider"]];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "style" => "color:#fff;font-weight:600;background: #8A2387;background: -webkit-linear-gradient(to right, #F27121, #E94057, #8A2387);background: linear-gradient(to right, #F27121, #E94057, #8A2387);",
                        "data-component_run" => "product_form",
                        "data-component_action" => "remove_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => $src["product_id"],
                    ]
                    , "Ürünü Kaldır")
        ];
        $content .= html::addhtmllist(["class" => "dropdown-menu", "role" => "menu"], $li);
        $btn = html::add_div(["class" => "btn-group"], $content);


        return $btn;
    }

}

<?php

/**
 * Description of class
 *
 * @author engin
 */
class category_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function category_name($src) {
        return html::add_div([], $src["category_name"]);
    }

    public function parent_category($src) {
        if ($src["parent_category_id"] == 0) {
            $result = html::add_div([], "Ana Kategori");
        } else {
            $ncategory = new table_category();
            $ncategory->select();
            $nproduct->add_condition("category_id", $src["parent_category_id"]);
            $parent_category_data = $ncategory->get_alldata();
            $result = html::add_div([], $parent_category_data["category_name"]);
        }
        return $result;
    }

    public function category_public($src) {
        $res = html::add_div([], html::addinput(["name" => "category_id", "value" => $src["category_id"]], "", "hidden"));
        if (intval($src["public"])) {
            return $res . html::add_div([], html::addspan(["class" => "fa fa-circle", "style" => "color:green;cursor:pointer"]));
        } else {
            return $res . html::add_div([], html::addspan(["class" => "fa fa-circle", "style" => "color:red;cursor:pointer"]));
        }
    }

    public function category_group_fields($src) {
        $ncategory_group_fields = new table_category_group_fields();
        if ($group_fileds = $ncategory_group_fields->get_data_main_key($src["category_id"])) {
            return html::add_div([], count($group_fileds) . " Adet");
        } else {
            return html::add_div([], "Gruplama Alanı Yok");
        }
    }

    public function category_gallery($src) {
        $ncategoy_gallery = new table_category_gallery();
        if ($gallery = $ncategoy_gallery->get_data_main_key($src["category_id"])) {
            return html::add_div([], count($gallery) . " Adet");
        } else {
            return html::add_div([], "Galeri Yok");
        }
    }

    public function category_sub_count($src) {
        $ncategory = new table_category();
        $sub_category = $ncategory->get_sub_category($src["category_id"]);
        $count_category = count($sub_category);
        if ($count_category == 0)
            $count_category = "Ana Kategori";

        return $count_category;
    }

    public function product_count($src) {
        $category_id = $src["category_id"];
        $nproduct = new table_product_category();
        $nproduct->select();
        $nproduct->add_condition("category_id", $category_id);
        $nproduct->add_join("product", "product_id");


        if ($product_data = $nproduct->get_alldata()) {
            // $nproduct->show_sql();
            return count($product_data);
        } else {
            return "0";
        }
    }

    public function actions($src) {
        $content = html::addbutton(["class" => "btn btn-xs green dropdown-toggle", "type" => "button", "data-toggle" => "dropdown", "aria-expanded" => "false"], "Eylemler" . html::addspan(["class" => "fa fa-angle-down"]));
//$li[] = ["attr" => ["class" => "fs-12 $promotion"], "html" => html::addalink(["class" => "text-black", "href" => URL . "/company/me/promotion", "role" => "tab"], "Reklamlarım")];
        $li = [];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "category_form",
                        "data-component_action" => "load",
                        "data-modal" => "#category_modal",
                        "data-component_key" => "category_id",
                        "data-component_data" => $src["category_id"],
                        "data-starter" => "component_run,form",
                    ]
                    , "Kategori Düzenle")
        ];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "category_gallery_form",
                        "data-component_action" => "load",
                        "data-modal" => "#category_gallery",
                        "data-component_key" => "category_id,category_name",
                        "data-component_data" => "{$src["category_id"]},{$src["category_name"]}",
                        "data-starter" => "component_run,form",
                    ]
                    , "Galeri Düzenle")
        ];
        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "category_group_fields_form",
                        "data-component_action" => "load",
                        "data-modal" => "#category_group_fields",
                        "data-component_key" => "category_id,category_name",
                        "data-component_data" => "{$src["category_id"]},{$src["category_name"]}",
                        "data-starter" => "component_run,form",
                    ]
                    , "Gruplama Alanlarını Düzenle")
        ];

        if ($src["public"] == 1) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "category_table",
                            "data-component_action" => "pause_category",
                            "data-component_key" => "category_id",
                            "data-component_data" => $src["category_id"],
                            "data-starter" => "component_run,form",
                        ]
                        , "Yayından Al")
            ];
        } else {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "category_table",
                            "data-component_action" => "public_category",
                            "data-component_key" => "category_id",
                            "data-component_data" => $src["category_id"],
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
                        "data-component_run" => "category_table",
                        "data-component_action" => "remove_category",
                        "data-component_key" => "category_id",
                        "data-component_data" => "{$src["category_id"]}",
                        "data-recomponent" => "category_tree_list",
                    ]
                    , "Kategoriyi Kaldır")
        ];
        $content .= html::addhtmllist(["class" => "dropdown-menu", "role" => "menu"], $li);
        $btn = html::add_div(["class" => "btn-group"], $content);


        return $btn;
    }

}

<?php component::start(); ?>
<?php $product_category_data = component::get_props("product_category_data"); ?>
<?php //dnd($product_category_data)                                                       ?>
<div>
    <?php
    if (!empty($product_category_data)) {
        $display = 'style="display:none"';
        $button = html::addbutton(["class" => "btn btn-xs btn-info", "data-category_button" => "open_category_list"], html::addspan(["class" => "fa fa-plus"]));
    } else {
        $display = 'style="display:block"';
        $button = "";
    }
    ?>
    <?= html::add_div(["class" => "row"], html::add_div(["class" => "col-sm-12"], $button)); ?>

    <div id="category_tree" <?= $display ?>></div>

    <div data-product_form="selected_category">
        <?php
        if (!empty($product_category_data)) {
            foreach ($product_category_data as $data) {
                $ncategory = new table_category();
                $category_name = $ncategory->get_category_name($data->category_id);
                $rand = rand(999, 9999);
                if (component::get_props("copy")) {
                    $removebutton = html::addbutton(["class" => "btn btn-xs btn-danger", "data-category_button" => "remove_button"], html::addspan(["class" => "fa fa-trash"]));
                } else {
                    $removebutton = html::addbutton(["class" => "btn btn-xs btn-danger", "data-category_button" => "remove_button", "key" => $data->product_category_id], html::addspan(["class" => "fa fa-trash"]));
                }
                echo html::add_div(["class" => "row remove_button"], html::add_div(["class" => "col-sm-6", "style" => "padding:5px;margin-top:10px;border-top:1px solid #e1e1e1;border-bottom:1px solid #e1e1e1"], $category_name) . html::add_div(["class" => "col-sm-1"], $removebutton));
                echo '<input type="hidden" name="@product_category_fields$secret_number:' . $rand . '" value="' . $rand . '" />';
                if (!component::get_props("copy"))
                    echo '<input type="hidden" name="@product_category_fields$primary_key:' . $rand . '" value="' . $data->product_category_id . '" />';
                echo '<input type="hidden" name="@product_category_fields$category_id:' . $rand . '" value="' . $data->category_id . '" />';
            }
        }
        ?>
    </div>
    <div data-category="special_fields_section"></div>
    <div data-category="selected_special_fields_section"></div>
</div>
<?php component::end(); ?>

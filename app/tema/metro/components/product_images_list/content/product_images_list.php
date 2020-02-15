<?php component::start($props); ?>
<?php $product_gallery_data = component::get_props("product_gallery_data"); ?>
<?php $image_list = component::get_props("image_list"); ?>
<?php $i = 0 ?>

<?php if (!empty($image_list)): ?>
    <div class="product_gallery row">
        <ul class="sortable">
            <?php foreach ($image_list as $info): ?>
                <?php
                //dnd($info);
                $rand = rand(999, 9999);
                $nimage = new image_process();
                $image_source = $nimage->get_image($info);
                ?>
                <li class="product_image_list">
                    <div class="product_gallery">
                        <div style="position:relative">
                            <input type="hidden" name="@product_gallery_fields$secret_number:<?= $rand ?>" value="<?= $rand ?>"/>
                            <input class="image_gallery_id" type="hidden" name="@product_gallery_fields$image_gallery_id:<?= $rand ?>" value="<?= $info->image_gallery_id; ?>" />
                            <input class="image_line_id" type="hidden" name="@product_gallery_fields$image_line:<?= $rand ?>" value="<?= ($i + 1); ?>" />
                            <img class="img-responsive img-thumbnail" src="<?= $image_source ?>" alt="product_gallery_image"/>
                            <button class="btn btn-danger btn-rounded btn-xs product_image_remove_button" data-product_image="remove" ><span class="fa fa-trash"></span></button>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>

<?php if (!empty($product_gallery_data)): ?>
    <div class="product_gallery row">
        <ul class="sortable">
            <?php foreach ($product_gallery_data as $imagedata): ?>
                <?php
                $rand = rand(999, 9999);

                $nimage_gallery = new table_image_gallery();
                if ($image_info = $nimage_gallery->get_image_info($imagedata->image_gallery_id)) {
                    $nimage = new image_process();
                    $image_source = $nimage->get_image($image_info, 100);
                } else {
                    $image_source = noimage("product", 100);
                }
                ?>
                <li>
                    <div class="product_gallery">
                        <div style="position:relative">
                            <?php
                            if (!component::get_props("copy"))
                                if (isset($imagedata->primary_key)) {
                                    $prm = $imagedata->primary_key;
                                    echo '<input type = "hidden" name = "@product_gallery_fields$primary_key:' . $rand . '" value = "' . $imagedata->$prm . '"/>';
                                }
                            ?>
                            <input type="hidden" name="@product_gallery_fields$secret_number:<?= $rand ?>" value="<?= $rand ?>"/>
                            <input class="image_gallery_id" type="hidden" name="@product_gallery_fields$image_gallery_id:<?= $rand ?>" value="<?= $imagedata->image_gallery_id ?>" />
                            <input class="image_line_id" type="hidden" name="@product_gallery_fields$image_line:<?= $rand ?>" value="<?= ($i + 1); ?>" />
                            <img class="img-responsive img-thumbnail" src="<?= $image_source ?>" alt="product_gallery_image"/>
                            <button class="btn btn-danger btn-rounded btn-xs product_image_remove_button" data-product_image="remove" data-key="<?= $imagedata->$prm ?>" ><span class="fa fa-trash"></span></button>
                        </div>
                    </div>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>



<?php component::end(); ?>

<?php component::start($props); ?>
<?php $category_gallery_data = component::get_props("category_gallery_data"); ?>
<?php $dummy = component::get_props("dummy"); ?>
<?php $image_list = component::get_props("image_list"); ?>
<?php //dnd($dummy);  ?>
<?php $i = 0 ?>

<?php if (!empty($image_list)): ?>
    <div class="category_gallery row">
        <ul class="category_sortable">
            <?php foreach ($image_list as $info): ?>
                <?php
                $rand = rand(999, 9999);
                $nimage = new image_process();
                $image_source = $nimage->get_image($info);
                ?>
                <li class="category_image_list">
                    <div class="category_gallery">
                        <div style="position:relative">
                            <input type="hidden" name="@category_gallery_fields$secret_number:<?= $rand ?>" value="<?= $rand ?>"/>
                            <input type="hidden" name="@category_gallery_fields$category_id:<?= $rand ?>" value="<?= $dummy[0]->category_id; ?>" />
                            <input type="hidden" name="@category_gallery_fields$image_gallery_id:<?= $rand ?>" value="<?= $info->image_gallery_id; ?>" />
                            <input type="hidden" name="@category_gallery_fields$image_type:<?= $rand ?>" value="standart" />
                            <input class="image_line_id" type="hidden" name="@category_gallery_fields$image_line:<?= $rand ?>" value="<?= ($i + 1); ?>" />
                            <img class="img-responsive img-thumbnail" src="<?= $image_source ?>" alt="category_gallery_image"/>
                            <button class="btn btn-danger btn-rounded btn-xs category_image_remove_button" data-category_image="remove" ><span class="fa fa-trash"></span></button>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>

<?php if (!empty($category_gallery_data)): ?>
    <div class="category_gallery row">
        <ul class="category_sortable">
            <?php foreach ($category_gallery_data as $imagedata): ?>
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
                <li class="category_image_list">
                    <div class="category_gallery">
                        <div style="position:relative">
                            <?php
                            if (isset($imagedata->primary_key)) {
                                $prm = $imagedata->primary_key;
                                echo '<input type = "hidden" name = "@category_gallery_fields$primary_key:' . $rand . '" value = "' . $imagedata->$prm . '"/>';
                            }
                            ?>
                            <input type="hidden" name="@category_gallery_fields$secret_number:<?= $rand ?>" value="<?= $rand ?>"/>
                            <input class="image_gallery_id" type="hidden" name="@category_gallery_fields$image_gallery_id:<?= $rand ?>" value="<?= $imagedata->image_gallery_id ?>" />
                            <input class="image_line_id" type="hidden" name="@category_gallery_fields$image_line:<?= $rand ?>" value="<?= ($i + 1); ?>" />
                            <img class="img-responsive img-thumbnail" src="<?= $image_source ?>" alt="category_gallery_image"/>
                            <button class="btn btn-danger btn-rounded btn-xs category_image_remove_button" data-category_image="remove" data-key="<?= $imagedata->$prm ?>" ><span class="fa fa-trash"></span></button>
                        </div>
                    </div>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>



<?php component::end(); ?>

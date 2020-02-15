<?php component::start($props); ?>
<?php $category_id = component::get_props("category_id") ?>
<div id="category_gallery_images">
    <input type="hidden" dummy_object key="category_id" value="<?= $category_id ?>" />
</div>
<?php component::end(); ?>

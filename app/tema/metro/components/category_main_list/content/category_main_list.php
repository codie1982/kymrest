<?php component::start(); ?>
<?php $selected_category_name = component::get_props("selected_category_name"); ?>
<?php $selected_category_id = component::get_props("selected_category_id"); ?>
<?php $category_info = component::get_props("category_info"); ?>


<?php $category_data = $category_info["category"]; ?>
<?php //dnd($category_data); ?>


<?php if (!empty($category_data)): ?>
    <?php if ($category_data->parent_category_id != 0): ?>
        <?php $value = $category_data->parent_category_id; ?>
    <?php else: ?>
        <?php $value = 0; ?>
    <?php endif; ?>
<?php else: ?>
    <?php if (isset($selected_category_id)): ?>
        <?php $value = $selected_category_id; ?>
    <?php else: ?>
        <?php $value = 0; ?>
    <?php endif; ?>
<?php endif; ?>

<div class="form-group">
    <div class="row">
        <label class="col-md-3 control-label">Üst Kategori Seçin.</label>
        <div class="col-md-7">
            <div id="category_main_list"></div>
            <input type="hidden" id="mainlist_category_main_id" name="@category_fields$parent_category_id" value="<?= $value ?>" />
            <span class="help-block"> Kategorinizin hangi kategori altında yer almasını istiyorsanız seçiniz</span>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-primary" data-component_run="category_main_list" data-component_action="reload" data-starter="component_run"><span class="fa fa-refresh"></span> Yenile</button>
        </div>
    </div>

</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" id="mainlist_category_name">
            <?php if (!empty($category_data)): ?>
                <?php if ($category_data->parent_category_id != 0): ?>
                    <?php
                    $ncategory = new table_category();
                    $cinfo = $ncategory->get_data($category_data->parent_category_id);
                    ?>
                    <d>Üst Kategori <strong><?= $cinfo->category_name ?></strong><button data-category_main_list="remove_parent_category" class="btn btn-xs btn-danger btn-circle" style="margin-left:10px;" title="Ana Kategori Seçimini Kaldırın"><i class="fa fa-times"></i></button></d>
                <?php endif; ?>
            <?php else: ?>
                <?php if (component::isset_probs("selected_category_id")): ?>
                    <d>Üst Kategori <strong><?= $selected_category_name ?></strong><button data-category_main_list="remove_parent_category" class="btn btn-xs btn-danger btn-circle" style="margin-left:10px;" title="Ana Kategori Seçimini Kaldırın"><i class="fa fa-times"></i></button></d>
                        <?php endif; ?>
                    <?php endif; ?>



        </div>
    </div>
</div>



<?php component::end(); ?>

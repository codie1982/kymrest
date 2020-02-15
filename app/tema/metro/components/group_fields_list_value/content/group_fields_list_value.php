<?php component::start(); ?>
<?php $text = component::get_props("text"); ?>
<?php $group_fields_id = component::get_props("group_fields_id"); ?>

<?php $category_info = component::get_props("category_info"); ?>
<?php $category_group_fields = $category_info["category_group_fields"]; ?>

<?php if (!empty($category_group_fields)): ?>
    <?php foreach ($category_group_fields as $fields): ?>
        <?php $rnd = rand(999, 9999); ?>
        <div class="form-group category_group_fields">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-md-4">
                    <?php
                    if (isset($fields->primary_key)) {
                        $prm = $fields->primary_key;
                        echo '<input type="hidden" name="@category_group_fields$primary_key:' . $rnd . '" value="' . $fields->$prm . '"/>';
                    }
                    ?>
                    <?php
                    $ngf = new table_group_fields();
                    $fields_info = $ngf->get_data($fields->group_fields_id);
                    ?>
                    <input type="hidden" name="@category_group_fields$secret_number:<?= $rnd ?>" value="<?= $rnd ?>" />
                    <input type="hidden" name="@category_group_fields$group_fields_id:<?= $rnd ?>" value="<?= $fields->group_fields_id ?>"  />
                    <input type="text" class="form-control" value="<?= $fields_info->fields_name ?>" />
                </div>
                <div class="col-sm-2"><button class="btn btn-xs btn-circle btn-danger" data-group_fields_list_value="remove_item" data-key="<?= $fields->$prm ?>"><span class="fa fa-times"></span></button></div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <?php $rnd = rand(999, 9999); ?>
    <?php if ($group_fields_id != ""): ?>
        <div class="form-group category_group_fields">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-md-4">
                    <input type="hidden" name="@category_group_fields$secret_number:<?= $rnd ?>" value="<?= $rnd ?>" />
                    <input type="hidden" name="@category_group_fields$group_fields_id:<?= $rnd ?>" value="<?= $group_fields_id ?>"  />
                    <input type="text" class="form-control" value="<?= $text ?>" />
                </div>
                <div class="col-sm-2"><button class="btn btn-xs btn-circle btn-danger" data-group_fields_list_value="remove_item"><span class="fa fa-times"></span></button></div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php component::end(); ?>

<?php component::start($props); ?>

<?php
//
$group_fields_value_info = component::get_props("group_fields_value_info");
if (component::isset_probs("addul")) {
    $addul = component::get_props("addul");
} else {
    $addul = true;
}
?>

<?php if (empty($group_fields_value_info)): ?>
    <?php if ($addul): ?>
        <ul class="sortable_group_values margin-10">
        <?php endif; ?>
        <li style="list-style:none;margin-top:10px;">
            <div class="row add_fields">
                <?php $rnd = rand(999, 9999); ?>
                <input type="hidden" name="@group_fields_value$secret_number:<?= $rnd ?>" value="<?= $rnd ?>" />
                <input type="hidden" class="options_line" name="@group_fields_value$line:<?= $rnd ?>" value="0" />
                <label class="col-sm-2 control-label" style="cursor:move;">Değer Ekleyin</label>
                <div class="col-sm-6"><input type="text" class="form-control" placeholder="Değer" name="@group_fields_value$group_fields_value_name:<?= $rnd ?>" value="<?= $group_values_info->group_fields_value_name ?>"/></div>
                <div class="col-sm-1" style="margin-top:5px;">
                    <button class="btn btn-danger btn-circle btn-xs" data-group_values="remove_fields">
                        <span class="fa fa-trash"></span>
                    </button>
                </div>
            </div>
        </li>
        <?php if ($addul): ?>
        </ul>
    <?php endif; ?>
<?php else: ?>

    <ul class="sortable_group_values margin-10">
        <?php foreach ($group_fields_value_info as $dt): ?>
            <?php $rnd = rand(999, 9999); ?>
            <li style="list-style:none;margin-top:10px;">
                <div class="row add_fields">
                    <?php
                    if (isset($dt->primary_key)) {
                        $prm = $dt->primary_key;
                        echo '<input type="hidden" name="@group_fields_value$primary_key:' . $rnd . '" value="' . $dt->$prm . '" />';
                    }
                    ?>
                    <input type="hidden" name="@group_fields_value$secret_number:<?= $rnd ?>" value="<?= $rnd ?>" />
                    <input type="hidden" class="options_line" name="@group_fields_value$line:<?= $rnd ?>" value="0" />
                    <label class="col-sm-2 control-label" style="cursor:move;">Değer Ekleyin</label>
                    <div class="col-sm-6"><input type="text" class="form-control" placeholder="Değer" name="@group_fields_value$group_fields_value_name:<?= $rnd ?>" value="<?= $dt->group_fields_value_name ?>"/></div>
                    <div class="col-sm-1" style="margin-top:5px;">
                        <button class="btn btn-danger btn-circle btn-xs" data-group_values="remove_fields" data-key="<?= $dt->$prm ?>">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php component::end(); ?>

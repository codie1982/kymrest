<?php component::start($props); ?>
<?php $group_fields_info = component::get_props("group_fields_info"); ?>
<?php $action = component::get_props("action"); ?>
<?php $button = component::get_props("button"); ?>
<?php $remove_fields_button = component::get_props("remove_fields_button"); ?>
<form class="form-horizontal" data-send="xhr" method="post" data-component_name="group_fields_form" data-action="<?= $action != "" ? $action : "add_new_group_fileds" ?>" role="form">
    <?php //dnd($group_fields_info); ?>
    <?php
    if (isset($group_fields_info->primary_key)) {
        $prm = $group_fields_info->primary_key;
        echo '<input type="hidden" name="@group_fields$primary_key" value="' . $group_fields_info->$prm . '" />';
    }
    ?>
    <div class="form-body">
        <div class="form-group">
            <div class="row">
                <label class="col-md-3 control-label">Grup Alanı ekleyin</label>
                <div class="<?= $remove_fields_button != "" ? "col-md-5" : "col-md-6" ?>">
                    <input type="text" class="form-control" placeholder="Başlık Girin" name="@group_fields$fields_name" value="<?= $group_fields_info->fields_name ?>"/>
                    <span class="help-block"> Gruplama Alanları Ekleyin. </span>
                </div>
                <div class="col-md-2">
                    <select class="form-control" data-customer="select-type"  name="@group_fields$fields_type">
                        <option <?= $group_fields_info->fields_type == NODATA ? "selected" : null ?> value="---">Alan Tipini Seçin </option>
                        <option <?= $group_fields_info->fields_type == "single" ? "selected" : null ?> value="single">Tekli</option>
                        <option <?= $group_fields_info->fields_type == "multiple" ? "selected" : null ?> value="multiple">Çoklu</option>
                        <option <?= $group_fields_info->fields_type == "color" ? "selected" : null ?> value="color">Renk</option>
                    </select>
                </div>
                <div class="col-sm-1"><button class="btn btn-primary" data-group_fields_form="add_fields" ><span class="fa fa-plus-circle"></span></button></div>
                <?=
                $remove_fields_button != "" ?
                        ' <div class="col-sm-1"> <button class="btn btn-danger" data-group_fields_form="remove_groups" data-key="' . $group_fields_info->$prm . '" ><span class="fa fa-times"></span></button></div>' :
                        null
                ?>
            </div>
        </div>

        <?= component::get_props("group_values") ?>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><?= $button == "" ? "Kaydet" : $button ?></button>
            </div>
        </div>
    </div>
</form>
<!-- END MODAL -->

<?php component::end(); ?>

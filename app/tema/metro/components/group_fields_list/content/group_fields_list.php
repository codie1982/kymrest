<?php component::start(); ?>
<?php $fields_list = component::get_props("fields_list"); ?>

<?php //dnd($fields_list);     ?>
<div class="form-group">
    <div class="row">
        <label class="col-md-3 control-label">Gruplama Alanı Ekleyin</label>
        <div class="col-md-4">
            <select class="form-control" data-category="select_group_fields">
                <?php if (!empty($fields_list)): ?>
                    <option value = "---">Bir Gruplama Alanı Seçin </option>
                    <?php foreach ($fields_list as $lt): ?>
                        <option value = "<?= $lt->group_fields_id ?>"><?= $lt->fields_name ?> </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value = "---">Özel Alan Bulunmamaktadır </option>
                <?php endif; ?>
            </select>
        </div>
    </div>
</div>
<?= component::get_props("group_fields_list_value") ?>
<?php component::end(); ?>

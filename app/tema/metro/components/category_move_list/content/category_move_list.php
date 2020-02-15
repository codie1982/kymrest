<?php component::start(); ?>
<?php $selected_category_name = component::get_props("selected_category_name"); ?>
<?php $selected_category_id = component::get_props("selected_category_id"); ?>

<div class="form-group">
    <div class="row">
        <label class="col-md-3 control-label">Üst Kategori Seçin.</label>
        <div class="col-md-7">
            <div id="category_move_list"></div>
            <?= '<input type="hidden" name="@category_fields$primary_key" value="' . $selected_category_id . '" />' ?>
            <span class="help-block"> <strong><?= ucwords_tr($selected_category_name) ?></strong> Kategorinizin hangi kategori altında yer almasını istiyorsanız listeden seçiniz</span>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-primary" data-component_run="category_move_list" data-component_action="reload" data-starter="component_run"><span class="fa fa-refresh"></span> Yenile</button>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" id="move_list_category_name"></div>
    </div>
</div>
<?php component::end(); ?>

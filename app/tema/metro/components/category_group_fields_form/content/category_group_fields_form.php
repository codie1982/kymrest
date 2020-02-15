<?php component::start($props); ?>
<?php $category_id = component::get_props("category_id"); ?>
<?php $category_name = component::get_props("category_name"); ?>
<?php $category_group_fields_data = component::get_props("category_group_fields_data"); ?>
<?php $fields_list = component::get_props("fields_list"); ?>


<div class="modal fade bs-modal-lg" id="category_group_fields" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase">Gruplama Alanları</span>
                            <span class="help-inline"> Kategoriniz içindeki gruplama alanlarını Özelleştirin. </span>
                        </div>
                    </div>
                    <div class="row margin-bottom-15">
                        <div class="col-md-12"><h4><strong><?= $category_name ?></strong> kategorisi için gruplama alanlarını oluşturun</h4></div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" data-send="xhr" method="post" data-component_name="category_group_fields_form" data-action="update_category_group_fields" role="form">
                            <?php
                            $ngroup_fields = new table_group_fields();
                            $ngroup_fields->select();
                            $group_fields_data = $ngroup_fields->get_alldata();
                            if (!empty($category_group_fields_data)):
                                foreach ($category_group_fields_data as $gr):
                                    $rnd = rand(999, 9999);
                                    ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-3 control-label">Gruplama Alanı Ekleyin</label>
                                            <div class="col-md-4">
                                                <?php
                                                if (isset($gr->primary_key)) {
                                                    $prm = $gr->primary_key;
                                                    echo '<input type="hidden" name="@category_group_fields$primary_key:' . $rnd . '" value="' . $gr->$prm . '"/>';
                                                }
                                                ?>
                                                <input type="hidden" name="@category_group_fields$category_id:<?= $rnd ?>" value="<?= $category_id ?>"/>
                                                <select class="form-control" data-category="select_group_fields" name="@category_group_fields$group_fields_id:<?= $rnd ?>">
                                                    <?php if (!empty($group_fields_data)): ?>
                                                        <option value = "---">Bir Gruplama Alanı Seçin </option>
                                                        <?php foreach ($group_fields_data as $lt): ?>
                                                            <?php $selected = $gr->group_fields_id == $lt->group_fields_id ? "selected" : ""; ?>
                                                            <option value = "<?= $lt->group_fields_id ?>" <?= $selected ?>><?= $lt->fields_name ?> </option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option value = "---">Özel Alan Bulunmamaktadır </option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-circle btn-danger btn-xs" data-category_group_fields_form="remove" data-key="<?= $gr->$prm ?>">
                                                    <span class="fa fa-times-circle"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>


                            <?php else: ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <h4>Kategorinize ait gruplama alanı bulunmuyor</h4>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Gruplama Alanlarını Düzenle</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="note note-info margin-bottom-15">
                    <div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i> </div>Kategorinize ekli gruplama alanlarınıo düzenleyin.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END MODAL -->

<?php component::end(); ?>

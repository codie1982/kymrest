<?php component::start(); ?>

<?php $category_group_fields_data = component::get_props("category_group_fields_data"); ?>
<?php //dnd($category_group_fields_data); ?>
<?php if (!empty($category_group_fields_data)): ?>
    <?php foreach ($category_group_fields_data as $data): ?>
        <div class="form-group">
            <div class="row">
                <?php $group_fields_id = $data->group_fields_id ?>
                <?php
                $ngroup_fields = new table_group_fields();
                $group_fields_info = $ngroup_fields->get_data($group_fields_id);
                $ngroup_fields_value = new table_group_fields_value();
                $ngroup_fields_value_info = $ngroup_fields_value->get_data_main_key($group_fields_id);
//                dnd($group_fields_info);
//                dnd($ngroup_fields_value_info);
                ?>
                <label class="col-md-3 control-label"><?= $group_fields_info->fields_name ?> Alanı Ekleyin</label>
                <?php
                switch ($group_fields_info->fields_type):

                    case "multiple":
                        ?>
                        <?php if (!empty($ngroup_fields_value_info)): ?>
                            <div class="col-sm-9">
                                <?php foreach ($ngroup_fields_value_info as $value): ?>
                                    <?php $rand = rand(999, 9999); ?>
                                    <div class="mt-checkbox-list inline">
                                        <label class="mt-checkbox">
                                            <input type="hidden" name="@product_group_fields_value$secret_number:<?= $rand ?>" value="<?= $rand ?>"/>
                                            <input type="checkbox" id="<?= $value->group_fields_value_id ?>"
                                                   class="md-check" value="<?= $value->group_fields_value_id ?>"
                                                   data-product_group_value_id data-key="<?= $value->group_fields_value_id ?>"
                                                   name="@product_group_fields_value$value_id:<?= $rand ?>"/><?= $value->group_fields_value_name ?>
                                            <span></span>
                                        </label>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        break;
                    case "single":
                        ?>
                        <?php if (!empty($ngroup_fields_value_info)): ?>
                            <div class="col-sm-9">
                                <?php $rand = rand(999, 9999); ?>
                                <?php foreach ($ngroup_fields_value_info as $value): ?>
                                    <div class="mt-radio-list">
                                        <label class="mt-radio">
                                            <input type="hidden" name="@product_group_fields_value$secret_number:<?= $rand ?>" value="<?= $rand ?>"/>
                                            <input type="radio" name="@product_group_fields_value$value_id:<?= $rand ?>" data-product_group_value_id value="<?= $value->group_fields_value_id ?>" data-key="<?= $value->group_fields_value_id ?>"  /> <?= $value->group_fields_value_name ?>
                                            <span></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        break;
                    case "color":
                        ?>
                        <div class="col-sm-9">
                            <?php if (!empty($ngroup_fields_value_info)): ?>
                                <ul class="group_fields_box_list">
                                    <?php foreach ($ngroup_fields_value_info as $value): ?>
                                        <li> <a href="javascript:void(0)"><div class="group_fields_box" data-product_group_color_value data-key=" <?= $value->group_fields_value_id ?>" style="background: <?= $value->group_fields_value_name ?>"></div></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <div id="selected_product_group_color_value"></div>
                        </div>
                        <?php
                        break;
                endswitch;
                ?>


            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<?php component::end(); ?>

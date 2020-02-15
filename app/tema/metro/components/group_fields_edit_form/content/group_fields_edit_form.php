<?php component::start($props); ?>
<?php $group_fileds_info = component::get_props("group_fileds_info"); ?>

<?php //$group_values_component = component::get_props("group_values_component");  ?>
<div class="modal fade bs-modal-lg" id="group_fields_edit_modal" tabindex="-1" role="basic" aria-hidden="true">
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
                            <span class="caption-subject font-dark sbold uppercase">Gruplama Alanlarınızı Düzenleyin</span>
                            <span class="help-inline"> Gruplama Alanlarınızı Yapılandırın. </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Gruplama Alanı Seçin</label>
                                <div class="col-md-4">
                                    <select class="form-control" data-category="select_group_fields">
                                        <?php if (!empty($group_fileds_info)): ?>
                                            <option value = "---">Bir Gruplama Alanı Seçin </option>
                                            <?php foreach ($group_fileds_info as $lt): ?>
                                                <option value = "<?= $lt->group_fields_id ?>"><?= $lt->fields_name ?> </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value = "---">Özel Alan Bulunmamaktadır </option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?= component::get_props("group_fields_form_component"); ?>
                    </div>
                </div>
                <div class="note note-info margin-bottom-15"><div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i></div><p>Gruplama Özellikleri Ürünlerinizi belirli alanlar altında gruplamanıza Olanak Sağlar.Ör. olarak (MARKA,RENK,BOYUT vb.) alanlarda ürünlerinizi gruplayabilri kullanıcı aramalarını kolaylaştırabilirsiniz.  </p></div>
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

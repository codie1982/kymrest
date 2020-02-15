<?php component::start($props); ?>
<?php $settings = component::get_props("settings"); ?>
<?php $my_company_data = component::get_props("my_company_data"); ?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Site Genel Ayarları</span>
                    <span class="help-inline"> Bu Ayarları Mümkün Olduğunca Değiştirmemeye Çalışın. </span>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="general_settings_form" data-action="update_general_settings">
                    <?php if (!empty($settings)): ?>
                        <?php $prm = $settings->primary_key ?>
                        <input type="hidden" name="@settings_general_fields$primary_key" value="<?= $settings->$prm ?>" />
                    <?php endif; ?>
                    <div class="form-body">
                        <div class="portlet-title margin-bottom-15">
                            <div class="caption">
                                <i class="icon-envelope font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Firma Tanımlayın</span>
                                <span class="help-inline"> Kayıtlı Firmalardan birni kendi firmanı olarak seçebilirsiniz. </span>
                            </div> 
                        </div>
                        <?php if (!component::isset_probs("my_company_data")): ?>
                            <div class="form-group">
                                <div class="row false">
                                    <label class="col-md-3 control-label">Firma İsmi</label>
                                    <div class="col-md-6">
                                        <select class="form-control" data-searchbox="company" ></select>
                                    </div>
                                </div>
                            </div>
                            <input id="myCompany" type="hidden" name="@settings_general_fields$mycompany_id" value="<?= $settings->mycompany_id ?>" />
                        <?php else: ?>
                            <input   type="hidden" name="@settings_general_fields$primary_key" value="<?= $settings->general_settings_id ?>" />
                        <?php endif; ?>

                    </div>
                    <div id="myCompanyInfo">
                        <?= component::get_props("general_settings_mycompany") ?>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green" name="settings" value="1">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- END SAMPLE FORM PORTLET-->

</div>
<?php component::end(); ?>
